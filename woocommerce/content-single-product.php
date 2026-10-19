<?php
/**
 * Single product content layout.
 *
 * Standard WooCommerce hooks are kept so variation, quote cart and product option
 * plugins continue to work. Layout is re-arranged in inc/woocommerce.php.
 *
 * @package Custom44
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

$c44_tags = get_the_terms( $product->get_id(), 'product_tag' );
$c44_tags = is_array( $c44_tags ) ? wp_list_pluck( $c44_tags, 'slug' ) : array();
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<section class="pdp">
		<div class="container pdp__grid">
			<div class="pdp__gallery">
				<div class="pdp__badges">
					<?php if ( $product->is_on_sale() ) : ?>
						<span class="badge badge--orange"><?php esc_html_e( 'Sale', 'custom44' ); ?></span>
					<?php endif; ?>
					<?php if ( in_array( 'most-popular', $c44_tags, true ) ) : ?>
						<span class="badge badge--accent"><?php esc_html_e( 'Most Popular', 'custom44' ); ?></span>
					<?php endif; ?>
				</div>
				<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
			</div>

			<div class="summary entry-summary pdp__summary">
				<?php do_action( 'woocommerce_single_product_summary' ); ?>
			</div>
		</div>
	</section>

	<section class="pdp-details">
		<div class="container">
			<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
		</div>
	</section>

	<section class="pdp-related">
		<div class="container">
			<?php woocommerce_output_related_products(); ?>
		</div>
	</section>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
