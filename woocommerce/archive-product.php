<?php
/**
 * Product category / shop archive.
 *
 * @package Custom44
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$c44_term   = is_product_taxonomy() ? get_queried_object() : null;
$c44_title  = woocommerce_page_title( false );
$c44_desc   = $c44_term ? term_description( $c44_term ) : '';
$c44_total  = $c44_term ? (int) $c44_term->count : (int) wp_count_posts( 'product' )->publish;

if ( ! $c44_desc ) {
	/* translators: %s: category name */
	$c44_desc = '<p>' . sprintf( esc_html__( 'Custom branded %s printed in Melbourne with commercial-grade DTF technology. Choose a style to see pricing, pick your print locations and request a free quote.', 'custom44' ), esc_html( strtolower( $c44_title ) ) ) . '</p>';
}

// Child categories, or siblings when this category has no children.
$c44_chips   = array();
$c44_current = $c44_term ? $c44_term->term_id : 0;
if ( $c44_term && 'product_cat' === $c44_term->taxonomy ) {
	$c44_chips = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $c44_term->term_id, 'hide_empty' => true ) );
	if ( empty( $c44_chips ) && $c44_term->parent ) {
		$c44_chips = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $c44_term->parent, 'hide_empty' => true ) );
	}
} else {
	$c44_chips = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) );
}
if ( is_wp_error( $c44_chips ) ) {
	$c44_chips = array();
}
?>

<!-- Category banner: content displays immediately (no reveal animation) -->
<section class="page-hero">
	<div class="hero__bg" aria-hidden="true"></div>
	<div class="hero__grid-lines" aria-hidden="true"></div>
	<div class="container">
		<?php woocommerce_breadcrumb(); ?>
		<div class="page-hero__inner">
			<div>
				<span class="eyebrow"><?php esc_html_e( 'Custom printed apparel', 'custom44' ); ?></span>
				<h1><?php echo esc_html( $c44_title ); ?></h1>
				<div class="page-hero__desc"><?php echo wp_kses_post( $c44_desc ); ?></div>
			</div>
			<div class="page-hero__stats">
				<div class="page-hero__stat"><strong><?php echo esc_html( $c44_total ); ?></strong><span><?php esc_html_e( 'Styles to brand', 'custom44' ); ?></span></div>
				<div class="page-hero__stat"><strong>35%</strong><span><?php esc_html_e( 'Max bulk saving', 'custom44' ); ?></span></div>
				<div class="page-hero__stat"><strong>7</strong><span><?php esc_html_e( 'Print locations', 'custom44' ); ?></span></div>
				<div class="page-hero__stat"><strong>DTF</strong><span><?php esc_html_e( 'Commercial-grade print', 'custom44' ); ?></span></div>
			</div>
		</div>

		<?php if ( $c44_chips ) : ?>
			<nav class="subcats" aria-label="<?php esc_attr_e( 'Sub categories', 'custom44' ); ?>">
				<?php foreach ( $c44_chips as $c44_chip ) : ?>
					<a class="<?php echo (int) $c44_chip->term_id === (int) $c44_current ? 'is-current' : ''; ?>" href="<?php echo esc_url( get_term_link( $c44_chip ) ); ?>"><?php echo esc_html( $c44_chip->name ); ?> <small><?php echo esc_html( $c44_chip->count ); ?></small></a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>
	</div>
</section>

<!-- Bulk tiers strip -->
<div class="tier-strip">
	<div class="container tier-strip__inner">
		<span class="tier-strip__label"><?php c44_the_icon( 'percent' ); ?><?php esc_html_e( 'Bulk savings', 'custom44' ); ?></span>
		<ul class="tier-strip__list">
			<?php foreach ( c44_tiers() as $c44_tier ) : ?>
				<li><b><?php echo esc_html( $c44_tier['qty'] ); ?>+</b> <?php echo esc_html( $c44_tier['off'] ); ?>% <?php esc_html_e( 'off', 'custom44' ); ?></li>
			<?php endforeach; ?>
		</ul>
		<a class="btn btn--dark btn--sm" href="#contact"><?php esc_html_e( 'Get a bulk quote', 'custom44' ); ?></a>
	</div>
</div>

<section class="section section--tight">
	<div class="container shop-layout">
		<div class="drawer-overlay" data-filter-close></div>
		<aside class="shop-sidebar" id="shop-sidebar" aria-label="<?php esc_attr_e( 'Product filters', 'custom44' ); ?>">
			<div class="shop-sidebar__close">
				<strong><?php esc_html_e( 'Filter products', 'custom44' ); ?></strong>
				<button type="button" data-filter-close aria-label="<?php esc_attr_e( 'Close filters', 'custom44' ); ?>"><?php c44_the_icon( 'close' ); ?></button>
			</div>

			<?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
				<?php dynamic_sidebar( 'shop-sidebar' ); ?>
			<?php else : ?>
				<div class="side-card">
					<h3><?php esc_html_e( 'Categories', 'custom44' ); ?></h3>
					<ul class="side-cats">
						<?php
						$c44_parents = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) );
						if ( ! is_wp_error( $c44_parents ) ) :
							foreach ( $c44_parents as $c44_p ) :
								$c44_is_cur = $c44_term && ( (int) $c44_p->term_id === (int) $c44_term->term_id || term_is_ancestor_of( $c44_p, $c44_term, 'product_cat' ) );
								?>
								<li class="<?php echo $c44_is_cur ? 'is-current' : ''; ?>">
									<a href="<?php echo esc_url( get_term_link( $c44_p ) ); ?>"><?php echo esc_html( $c44_p->name ); ?> <small><?php echo esc_html( $c44_p->count ); ?></small></a>
									<?php
									if ( $c44_is_cur ) :
										$c44_kids = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $c44_p->term_id, 'hide_empty' => true ) );
										if ( $c44_kids && ! is_wp_error( $c44_kids ) ) :
											?>
											<ul>
												<?php foreach ( $c44_kids as $c44_kid ) : ?>
													<li class="<?php echo (int) $c44_kid->term_id === (int) $c44_current ? 'is-current' : ''; ?>"><a href="<?php echo esc_url( get_term_link( $c44_kid ) ); ?>"><?php echo esc_html( $c44_kid->name ); ?> <small><?php echo esc_html( $c44_kid->count ); ?></small></a></li>
												<?php endforeach; ?>
											</ul>
											<?php
										endif;
									endif;
									?>
								</li>
								<?php
							endforeach;
						endif;
						?>
					</ul>
				</div>
			<?php endif; ?>

			<div class="side-card side-help">
				<h3><?php esc_html_e( 'Not sure what to pick?', 'custom44' ); ?></h3>
				<p><?php esc_html_e( 'Tell us your trade, team size and budget and we will recommend the right garments.', 'custom44' ); ?></p>
				<a class="btn btn--accent btn--block btn--sm" href="<?php echo esc_attr( c44_tel() ); ?>"><?php c44_the_icon( 'phone' ); ?><?php echo esc_html( c44_opt( 'phone' ) ); ?></a>
			</div>
		</aside>

		<div class="shop-main">
			<?php
			/**
			 * Notices and plugin hooks (filters, etc.).
			 */
			do_action( 'woocommerce_before_main_content' );
			?>

			<?php if ( woocommerce_product_loop() ) : ?>
				<div class="shop-toolbar">
					<?php c44_result_count(); ?>
					<div class="shop-toolbar__right">
						<button class="btn btn--paper btn--sm filter-toggle" type="button" data-filter-toggle aria-controls="shop-sidebar" aria-expanded="false"><?php c44_the_icon( 'filter' ); ?><?php esc_html_e( 'Filters', 'custom44' ); ?></button>
						<?php woocommerce_catalog_ordering(); ?>
					</div>
				</div>

				<?php
				do_action( 'woocommerce_before_shop_loop' );

				woocommerce_product_loop_start();

				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) {
						the_post();
						do_action( 'woocommerce_shop_loop' );
						wc_get_template_part( 'content', 'product' );
					}
				}

				woocommerce_product_loop_end();

				do_action( 'woocommerce_after_shop_loop' );
				?>
			<?php else : ?>
				<div class="no-products">
					<h2 class="h-3"><?php esc_html_e( 'No products found here yet', 'custom44' ); ?></h2>
					<p><?php esc_html_e( 'Get in touch and we will source the right garment for you.', 'custom44' ); ?></p>
					<a class="btn btn--accent" href="#contact"><?php esc_html_e( 'Request a quote', 'custom44' ); ?></a>
				</div>
				<?php do_action( 'woocommerce_no_products_found' ); ?>
			<?php endif; ?>

			<?php do_action( 'woocommerce_after_main_content' ); ?>
		</div>
	</div>
</section>

<!-- Ordering steps -->
<section class="section section--white">
	<div class="container">
		<div class="section-head section-head--center reveal">
			<span class="eyebrow"><?php esc_html_e( 'Ordering made simple', 'custom44' ); ?></span>
			<h2 class="h-1"><?php esc_html_e( 'Choose, customise, approve, wear', 'custom44' ); ?></h2>
		</div>
		<div class="steps" data-observe>
			<?php
			$c44_steps = array(
				array( 'shirt', __( 'Pick a style', 'custom44' ), __( 'Select colours and add quantities per size.', 'custom44' ) ),
				array( 'target', __( 'Choose print spots', 'custom44' ), __( 'Left chest, back, sleeves and more.', 'custom44' ) ),
				array( 'upload', __( 'Upload artwork', 'custom44' ), __( 'Or ask us to design a new logo.', 'custom44' ) ),
				array( 'check-c', __( 'Approve and relax', 'custom44' ), __( 'We print, check and dispatch Australia-wide.', 'custom44' ) ),
			);
			foreach ( $c44_steps as $c44_k => $c44_step ) :
				?>
				<div class="step reveal" style="--d:<?php echo esc_attr( $c44_k * 0.08 ); ?>s; --i:<?php echo esc_attr( $c44_k ); ?>">
					<div class="step__top">
						<span class="step__icon"><?php c44_the_icon( $c44_step[0] ); ?></span>
						<span class="step__num">0<?php echo esc_html( $c44_k + 1 ); ?></span>
					</div>
					<span class="step__label"><?php echo esc_html( sprintf( __( 'Step %d', 'custom44' ), $c44_k + 1 ) ); ?></span>
					<h3><?php echo esc_html( $c44_step[1] ); ?></h3>
					<p><?php echo esc_html( $c44_step[2] ); ?></p>
					<span class="step__link" aria-hidden="true"></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
get_footer( 'shop' );
