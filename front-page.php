<?php
/**
 * Homepage.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

get_header();

$c44_orders     = (int) c44_opt( 'orders' );
$c44_shop_url   = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
$c44_cat_url    = function ( $slug ) {
	if ( taxonomy_exists( 'product_cat' ) ) {
		$t = get_term_by( 'slug', $slug, 'product_cat' );
		if ( $t && ! is_wp_error( $t ) ) {
			return get_term_link( $t );
		}
	}
	return home_url( '/product-category/' . $slug . '/' );
};
$c44_gallery = array(
	array( '/wp-content/uploads/2026/08/hero-banner-image.webp', __( 'Custom 44 branded workwear on display', 'custom44' ) ),
	array( '/wp-content/uploads/2026/04/banner-home-page.jpg', __( 'Custom printed tees and polos', 'custom44' ) ),
	array( '/wp-content/uploads/2026/08/hero-banner-img.webp', __( 'Branded polos, hoodies and hi-vis', 'custom44' ) ),
	array( '/wp-content/uploads/2026/10/6HSP-6HVPH-ON-ON.png', __( 'Hi-vis polo and hoodie set', 'custom44' ) ),
	array( '/wp-content/uploads/2026/08/middle-banner-img.webp', __( 'Uniform range with logo placement', 'custom44' ) ),
	array( '/wp-content/uploads/2026/10/7BEL-BLACK-ORANGE-.png', __( 'Polo and hoodie team set', 'custom44' ) ),
);
?>

<!-- Banner: content displays immediately (no reveal animation) -->
<section class="hero" aria-labelledby="hero-title">
	<div class="hero__bg" aria-hidden="true"></div>
	<div class="hero__grid-lines" aria-hidden="true"></div>
	<div class="container hero__inner">
		<div class="hero__content">
			<a class="hero__rating" href="<?php echo esc_url( c44_opt( 'google_reviews' ) ); ?>" target="_blank" rel="noopener">
				<span class="hero__rating-badge"><?php c44_the_icon( 'google' ); ?><?php esc_html_e( 'Reviews', 'custom44' ); ?></span>
				<?php echo c44_stars(); // phpcs:ignore ?>
				<span><?php esc_html_e( 'See what Aussie businesses say about us on Google', 'custom44' ); ?></span>
			</a>
			<h1 class="h-display" id="hero-title"><?php echo wp_kses_post( c44_opt( 'hero_title' ) ); ?></h1>
			<p class="lead"><?php echo esc_html( c44_opt( 'hero_text' ) ); ?></p>
			<div class="btn-row">
				<a class="btn btn--accent btn--lg" href="<?php echo esc_url( $c44_cat_url( 'workwear' ) ); ?>"><?php esc_html_e( 'Shop Workwear', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></a>
				<a class="btn btn--white btn--lg" href="#contact"><?php esc_html_e( 'Get a Bulk Quote', 'custom44' ); ?></a>
			</div>
			<ul class="hero__ticks">
				<li><?php c44_the_icon( 'check-c' ); ?><?php esc_html_e( 'Up to 35% off bulk orders', 'custom44' ); ?></li>
				<li><?php c44_the_icon( 'check-c' ); ?><?php esc_html_e( 'Family owned in Melbourne', 'custom44' ); ?></li>
				<li><?php c44_the_icon( 'check-c' ); ?><?php esc_html_e( 'Australia-wide dispatch', 'custom44' ); ?></li>
			</ul>
		</div>

		<div class="hero__visual">
			<div class="hero__img-main" data-parallax-wrap>
				<img src="<?php echo esc_url( c44_img( c44_opt( 'hero_image' ) ) ); ?>" alt="<?php esc_attr_e( 'Custom printed workwear by Custom 44', 'custom44' ); ?>" width="900" height="1100" fetchpriority="high" data-parallax="0.08">
			</div>
			<div class="hero__img-small">
				<img src="<?php echo esc_url( c44_img( c44_opt( 'hero_image_2' ) ) ); ?>" alt="<?php esc_attr_e( 'DTF printed logo detail', 'custom44' ); ?>" width="400" height="500">
			</div>
			<div class="hero__chip hero__chip--a">
				<span class="hero__chip-icon"><?php c44_the_icon( 'truck' ); ?></span>
				<div><strong><?php echo esc_html( number_format_i18n( $c44_orders ) ); ?>+</strong><span><?php esc_html_e( 'Orders shipped Australia-wide', 'custom44' ); ?></span></div>
			</div>
			<div class="hero__chip hero__chip--b">
				<span class="hero__chip-icon"><?php c44_the_icon( 'layers' ); ?></span>
				<div><strong>DTF</strong><span><?php esc_html_e( 'Commercial-grade prints', 'custom44' ); ?></span></div>
			</div>
		</div>
	</div>
</section>

<!-- USP marquee -->
<div class="marquee" aria-hidden="true">
	<div class="marquee__track">
		<?php
		$c44_marquee = array( 'DTF Printing', 'Hi-Vis Workwear', 'Bulk Savings to 35%', 'Corporate Uniforms', 'Nationwide Dispatch', 'Family Owned', 'AS Colour', "JB's Wear" );
		for ( $c44_i = 0; $c44_i < 2; $c44_i++ ) :
			foreach ( $c44_marquee as $c44_word ) :
				?>
				<span class="marquee__item"><?php echo esc_html( $c44_word ); ?><?php c44_the_icon( 'spark' ); ?></span>
				<?php
			endforeach;
		endfor;
		?>
	</div>
</div>

<!-- Shop by category -->
<section class="section" aria-labelledby="cats-title">
	<div class="container">
		<div class="section-head section-head--center">
			<div class="section-head__text reveal">
				<span class="eyebrow"><?php esc_html_e( 'Shop by category', 'custom44' ); ?></span>
				<h2 class="h-1" id="cats-title"><?php echo wp_kses_post( __( 'Gear for every crew, <span class="hl-ink">branded your way.</span>', 'custom44' ) ); ?></h2>
			</div>
		</div>

		<div class="cat-grid">
			<?php foreach ( c44_home_categories() as $c44_idx => $c44_cat ) : ?>
				<a class="cat-card reveal reveal--scale" style="--d:<?php echo esc_attr( $c44_idx * 0.07 ); ?>s" href="<?php echo esc_url( $c44_cat['url'] ); ?>">
					<img src="<?php echo esc_url( $c44_cat['img'] ); ?>" alt="" loading="lazy">
					<?php if ( $c44_cat['tag'] ) : ?>
						<span class="cat-card__tag"><?php echo esc_html( $c44_cat['tag'] ); ?></span>
					<?php endif; ?>
					<div class="cat-card__body">
						<div>
							<span class="cat-card__count"><?php echo esc_html( $c44_cat['count'] ? $c44_cat['count'] : $c44_cat['label'] ); ?></span>
							<h3><?php echo esc_html( $c44_cat['title'] ); ?></h3>
						</div>
						<span class="cat-card__arrow" aria-hidden="true"><?php c44_the_icon( 'arrow' ); ?></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
		<div class="section-cta reveal">
			<a class="btn btn--dark btn--lg" href="<?php echo esc_url( $c44_shop_url ); ?>"><?php esc_html_e( 'View all products', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></a>
		</div>
	</div>
</section>

<!-- Bulk savings -->
<section class="section section--dark bulk" id="bulk-pricing" aria-labelledby="bulk-title">
	<div class="container bulk__inner">
		<div class="reveal reveal--left">
			<span class="eyebrow"><?php esc_html_e( 'Bulk pricing', 'custom44' ); ?></span>
			<h2 class="h-1" id="bulk-title"><?php echo wp_kses_post( __( 'The more you order, <span class="hl">the more you save.</span>', 'custom44' ) ); ?></h2>
			<p class="lead"><?php esc_html_e( 'Discounts are applied automatically in your quote cart from just five items. Mix sizes across the same style and still unlock the tier.', 'custom44' ); ?></p>
			<div class="btn-row" style="margin-top:34px">
				<a class="btn btn--accent btn--lg" href="<?php echo esc_url( $c44_cat_url( 'best-sellers' ) ); ?>"><?php esc_html_e( 'Start your order', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></a>
				<a class="btn btn--white btn--lg" href="<?php echo esc_attr( c44_tel() ); ?>"><?php c44_the_icon( 'phone' ); ?><?php esc_html_e( 'Talk to us', 'custom44' ); ?></a>
			</div>
		</div>
		<div class="reveal" style="--d:.1s">
			<div class="tiers" data-observe>
				<?php
				$c44_tiers = c44_tiers();
				foreach ( $c44_tiers as $c44_n => $c44_tier ) :
					$c44_h = 28 + ( $c44_n * 18 );
					?>
					<div class="tier">
						<div class="tier__bar" style="--h:<?php echo esc_attr( $c44_h ); ?>%">
							<span class="tier__pct"><?php echo esc_html( $c44_tier['off'] ); ?>%<small><?php esc_html_e( 'OFF', 'custom44' ); ?></small></span>
						</div>
						<span class="tier__qty"><b><?php echo esc_html( $c44_tier['qty'] ); ?>+</b> <?php esc_html_e( 'items', 'custom44' ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
			<p class="bulk__note"><?php esc_html_e( 'Per item discount on the garment price. Print locations are priced separately on each product.', 'custom44' ); ?></p>
		</div>
	</div>
</section>

<!-- Best sellers carousel -->
<?php
if ( class_exists( 'WooCommerce' ) ) :
	$c44_q = new WP_Query(
		array(
			'post_type'      => 'product',
			'posts_per_page' => 10,
			'post_status'    => 'publish',
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => 'best-sellers',
				),
			),
		)
	);
	if ( ! $c44_q->have_posts() ) {
		$c44_q = new WP_Query( array( 'post_type' => 'product', 'posts_per_page' => 10, 'post_status' => 'publish', 'orderby' => 'popularity' ) );
	}
	if ( $c44_q->have_posts() ) :
		?>
		<section class="section section--white" aria-labelledby="best-title">
			<div class="container">
				<div class="section-head section-head--center">
					<div class="section-head__text reveal">
						<span class="eyebrow"><?php esc_html_e( 'Best sellers', 'custom44' ); ?></span>
						<h2 class="h-1" id="best-title"><?php esc_html_e( 'Proven on site. Loved by crews.', 'custom44' ); ?></h2>
					</div>
				</div>
				<div class="carousel reveal" data-carousel>
					<button class="carousel__btn carousel__btn--prev carousel__side" type="button" data-carousel-prev aria-label="<?php esc_attr_e( 'Previous products', 'custom44' ); ?>"><?php c44_the_icon( 'arrow' ); ?></button>
					<button class="carousel__btn carousel__btn--next carousel__side" type="button" data-carousel-next aria-label="<?php esc_attr_e( 'Next products', 'custom44' ); ?>"><?php c44_the_icon( 'arrow' ); ?></button>
					<ul class="carousel__track c44-products-track">
						<?php
						while ( $c44_q->have_posts() ) :
							$c44_q->the_post();
							global $product;
							$product = wc_get_product( get_the_ID() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
							get_template_part( 'template-parts/product-card' );
						endwhile;
						wp_reset_postdata();
						?>
					</ul>
					<div class="carousel__progress"><span data-carousel-bar></span></div>
				</div>
				<div class="section-cta reveal">
					<a class="btn btn--dark btn--lg" href="<?php echo esc_url( $c44_cat_url( 'best-sellers' ) ); ?>"><?php esc_html_e( 'Shop all best sellers', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></a>
				</div>
			</div>
		</section>
		<?php
	endif;
endif;
?>

<!-- How it works -->
<section class="section section--dark steps-section" aria-labelledby="steps-title">
	<div class="container">
		<div class="section-head section-head--center reveal">
			<span class="eyebrow"><?php esc_html_e( 'How it works', 'custom44' ); ?></span>
			<h2 class="h-1" id="steps-title"><?php esc_html_e( 'From idea to uniform in four simple steps', 'custom44' ); ?></h2>
			<p class="lead"><?php esc_html_e( 'Order online in minutes or let our team handle everything for you. Either way, you approve before we print.', 'custom44' ); ?></p>
		</div>
		<div class="steps" data-observe>
			<?php
			$c44_steps = array(
				array( 'shirt', __( 'Choose your garments', 'custom44' ), __( 'Pick from trusted brands like AS Colour and JB\'s Wear in the colours and sizes your team needs.', 'custom44' ) ),
				array( 'target', __( 'Select print locations', 'custom44' ), __( 'Left chest, centre back, sleeves and more. Every location is priced upfront on the product page.', 'custom44' ) ),
				array( 'upload', __( 'Upload your artwork', 'custom44' ), __( 'Send EPS, SVG, AI, PDF, PNG or JPG files. No logo yet? Ask us to design one for you.', 'custom44' ) ),
				array( 'truck', __( 'We print and dispatch', 'custom44' ), __( 'Your order is DTF printed in Melbourne, checked by hand and shipped anywhere in Australia.', 'custom44' ) ),
			);
			foreach ( $c44_steps as $c44_k => $c44_step ) :
				?>
				<div class="step reveal" style="--d:<?php echo esc_attr( $c44_k * 0.1 ); ?>s; --i:<?php echo esc_attr( $c44_k ); ?>">
					<div class="step__top">
						<span class="step__icon"><?php c44_the_icon( $c44_step[0] ); ?></span>
						<span class="step__num">0<?php echo esc_html( $c44_k + 1 ); ?></span>
					</div>
					<span class="step__label"><?php echo esc_html( sprintf( __( 'Step %d', 'custom44' ), $c44_k + 1 ) ); ?></span>
					<h3><?php echo esc_html( $c44_step[1] ); ?></h3>
					<p><?php echo esc_html( $c44_step[2] ); ?></p>
					<span class="step__link" aria-hidden="true"></span>
					<span class="step__arrow" aria-hidden="true"><?php c44_the_icon( 'arrow' ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Why Custom 44 -->
<section class="section section--paper2" aria-labelledby="why-title">
	<div class="container">
		<div class="section-head section-head--center reveal">
			<span class="eyebrow"><?php esc_html_e( 'Why Custom 44', 'custom44' ); ?></span>
			<h2 class="h-1" id="why-title"><?php esc_html_e( 'Commercial scale. Family-run care.', 'custom44' ); ?></h2>
			<p class="lead"><?php esc_html_e( 'We are a family owned business that treats every order like it carries our own name. You get the capacity of a commercial printer with the attention of a local team.', 'custom44' ); ?></p>
		</div>
		<div class="why-stats">
			<div class="why-stat reveal"><strong><span data-count="<?php echo esc_attr( $c44_orders ); ?>">0</span><span class="hl">+</span></strong><span><?php esc_html_e( 'Orders shipped across Australia', 'custom44' ); ?></span></div>
			<div class="why-stat reveal" style="--d:.08s"><strong><span data-count="7">0</span></strong><span><?php esc_html_e( 'Print locations to choose from', 'custom44' ); ?></span></div>
			<div class="why-stat reveal" style="--d:.16s"><strong><span data-count="35">0</span><span class="hl">%</span></strong><span><?php esc_html_e( 'Maximum bulk saving', 'custom44' ); ?></span></div>
			<div class="why-stat reveal" style="--d:.24s"><strong><span data-count="5">0</span><span class="hl">+</span></strong><span><?php esc_html_e( 'Items to unlock discounts', 'custom44' ); ?></span></div>
		</div>
		<div class="why-features">
			<?php
			$c44_why = array(
				array( 'layers', __( 'Prints built for the trade', 'custom44' ), __( 'Commercial-grade DTF inks on rugged base garments that hold up wash after wash.', 'custom44' ) ),
				array( 'zap', __( 'Ready for big runs', 'custom44' ), __( 'Large uniform runs, corporate fit-outs and nationwide dispatch handled with ease.', 'custom44' ) ),
				array( 'heart', __( 'Personal service', 'custom44' ), __( 'Real people who answer the phone, check your artwork and keep you updated.', 'custom44' ) ),
			);
			foreach ( $c44_why as $c44_k => $c44_item ) :
				?>
				<div class="why-feature reveal" style="--d:<?php echo esc_attr( $c44_k * 0.08 ); ?>s">
					<span class="why__list-icon"><?php c44_the_icon( $c44_item[0] ); ?></span>
					<h3><?php echo esc_html( $c44_item[1] ); ?></h3>
					<p><?php echo esc_html( $c44_item[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="section-cta reveal">
			<div class="btn-row">
				<a class="btn btn--dark btn--lg" href="#contact"><?php esc_html_e( 'Get a free quote', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></a>
				<a class="link-arrow" href="<?php echo esc_url( c44_opt( 'google_reviews' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Read our reviews', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></a>
			</div>
		</div>
	</div>
</section>

<!-- Services (entire card clickable) -->
<section class="section section--dark" aria-labelledby="services-title">
	<div class="container">
		<div class="section-head section-head--center">
			<div class="section-head__text reveal">
				<span class="eyebrow"><?php esc_html_e( 'What we do', 'custom44' ); ?></span>
				<h2 class="h-1" id="services-title"><?php esc_html_e( 'Branded apparel for every part of your business', 'custom44' ); ?></h2>
			</div>
		</div>
		<div class="services">
			<?php
			$c44_services = array(
				array( __( 'Hi-Vis Workwear', 'custom44' ), __( 'Compliant hi-vis polos, shirts, hoodies and jackets printed with your logo for every crew on site.', 'custom44' ), $c44_cat_url( 'workwear' ), '5.jpg' ),
				array( __( 'Corporate Uniforms', 'custom44' ), __( 'Polished polos, tees and outerwear that keep your front-of-house and office teams on brand.', 'custom44' ), $c44_cat_url( 'mens' ), '6.jpg' ),
				array( __( 'Teams, Clubs & Schools', 'custom44' ), __( 'Matching hoodies, tees and caps in adult and kids sizes for sport, events and school leavers.', 'custom44' ), $c44_cat_url( 'kids' ), '2.jpg' ),
				array( __( 'Logo Design', 'custom44' ), __( 'No print-ready artwork? Our team can create a new logo so your gear looks sharp from day one.', 'custom44' ), '#contact', '3.jpg' ),
			);
			foreach ( $c44_services as $c44_k => $c44_s ) :
				?>
				<a class="service-card reveal" style="--d:<?php echo esc_attr( $c44_k * 0.08 ); ?>s" href="<?php echo esc_url( $c44_s[2] ); ?>" data-spotlight>
					<span class="service-card__num">0<?php echo esc_html( $c44_k + 1 ); ?></span>
					<h3><?php echo esc_html( $c44_s[0] ); ?></h3>
					<p><?php echo esc_html( $c44_s[1] ); ?></p>
					<span class="service-card__go"><?php esc_html_e( 'Explore', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></span>
					<span class="service-card__img" aria-hidden="true"><img src="<?php echo esc_url( c44_img( '/wp-content/uploads/2025/09/' . $c44_s[3] ) ); ?>" alt="" loading="lazy"></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Recent work gallery -->
<section class="section" aria-labelledby="gallery-title">
	<div class="container">
		<div class="section-head section-head--center reveal">
			<span class="eyebrow"><?php esc_html_e( 'Recent work', 'custom44' ); ?></span>
			<h2 class="h-1" id="gallery-title"><?php esc_html_e( 'Printed in Melbourne, worn across Australia', 'custom44' ); ?></h2>
			<p class="lead"><?php esc_html_e( 'A look at recent uniforms and merch we have produced for local tradies, teams and businesses.', 'custom44' ); ?></p>
		</div>
		<div class="gallery">
			<?php foreach ( $c44_gallery as $c44_k => $c44_g ) : ?>
				<figure class="gallery__item reveal reveal--scale" style="--d:<?php echo esc_attr( $c44_k * 0.06 ); ?>s">
					<img src="<?php echo esc_url( c44_img( $c44_g[0] ) ); ?>" alt="<?php echo esc_attr( $c44_g[1] ); ?>" loading="lazy">
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Reviews -->
<section class="section section--white" aria-labelledby="reviews-title">
	<div class="container">
		<div class="section-head section-head--center reveal">
			<span class="eyebrow"><?php esc_html_e( 'What customers value', 'custom44' ); ?></span>
			<h2 class="h-1" id="reviews-title"><?php esc_html_e( 'Trusted by tradies, teams and local businesses', 'custom44' ); ?></h2>
		</div>
		<?php
		$c44_reviews = apply_filters(
			'c44_reviews',
			array(
				array( 'Joey taylor', 'I&rsquo;ve had an outstanding experience with this company. The shirt quality is absolutely top-notch really impressive. Service is always friendly and professional, and they consistently give me great prices. They really take care of their customers, and I wouldn&rsquo;t hesitate to recommend them.' ),
				array( 'Cameron Dixon', 'Marko and Maria are so easy to deal with, with quick communication. The product arrived quickly to my door and is fantastic quality. Highly recommend to anyone looking for custom work wear.' ),
				array( 'Nick Keating', 'Custom 44 is so easy to deal with. Marko and Maria were very helpful when I placed my order. Answered any question I had very quickly. Once the mock up was approved I received my order the same week even though I&rsquo;m in a different state. I would highly recommend this company.' ),
				array( 'Cinzia Cailotto', 'Amazing to work with and hoodies and polos are PERFECT. Great quality product and printing. Thank you so much Marko and Maria, you guys are the best every time I order. Balloons and More look so professional in their tops x' ),
				array( 'Brijeshkumar Patel', 'I&rsquo;m very happy with Custom 44. Very fast turnaround, the quality is excellent and very easy to deal with Marko &amp; Maria. Highly recommend.' ),
				array( 'Simon Albore', 'After seeing an advertisement on Facebook I ended up using custom44 to supply and print 50 work shirts for my business. They were easy to deal with, the printing looks great and the T-shirt quality is very good. They even threw in a pack of Allen&rsquo;s Snakes chewie lollies which my family was happy to receive. Would definitely use their services in the future.' ),
			)
		);
		?>
		<div class="review-grid">
			<?php foreach ( $c44_reviews as $c44_k => $c44_r ) : ?>
				<figure class="review-card reveal" style="--d:<?php echo esc_attr( ( $c44_k % 3 ) * 0.08 ); ?>s">
					<div class="review-card__head">
						<?php echo c44_stars(); // phpcs:ignore ?>
						<span class="review-card__g" title="Google review"><?php c44_the_icon( 'google' ); ?></span>
					</div>
					<blockquote><?php echo wp_kses_post( $c44_r[1] ); ?></blockquote>
					<figcaption>
						<span class="review-card__avatar" aria-hidden="true"><?php echo esc_html( mb_substr( $c44_r[0], 0, 1 ) ); ?></span>
						<span><b><?php echo esc_html( $c44_r[0] ); ?></b><small><?php esc_html_e( 'Google review', 'custom44' ); ?></small></span>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
		<?php if ( c44_opt( 'reviews_code' ) ) : ?>
			<div class="reviews-embed reveal"><?php echo do_shortcode( wp_kses_post( c44_opt( 'reviews_code' ) ) ); ?></div>
		<?php endif; ?>
		<div class="section-cta reveal">
			<a class="btn btn--dark btn--lg" href="<?php echo esc_url( c44_opt( 'google_reviews' ) ); ?>" target="_blank" rel="noopener"><?php c44_the_icon( 'google' ); ?><?php esc_html_e( 'Read all reviews on Google', 'custom44' ); ?></a>
		</div>
	</div>
</section>

<!-- FAQ -->
<section class="section" aria-labelledby="faq-title">
	<div class="container faq-wrap">
		<div class="section-head section-head--center reveal">
			<span class="eyebrow"><?php esc_html_e( 'FAQs', 'custom44' ); ?></span>
			<h2 class="h-1" id="faq-title"><?php esc_html_e( 'Good questions, quick answers', 'custom44' ); ?></h2>
			<p class="lead"><?php esc_html_e( 'Still unsure? Our team is a phone call away.', 'custom44' ); ?></p>
		</div>
		<div class="faq reveal" style="--d:.1s">
			<?php
			$c44_faqs = array(
				array( __( 'How do bulk discounts work?', 'custom44' ), __( 'Discounts apply automatically per item: 15% off from 5 items, 20% from 10, 25% from 20, 30% from 50 and 35% from 100 items.', 'custom44' ) ),
				array( __( 'What printing method do you use?', 'custom44' ), __( 'We use DTF (Direct to Film) printing with commercial-grade inks. It produces vibrant, detailed prints that stay flexible and durable on a wide range of fabrics.', 'custom44' ) ),
				array( __( 'What artwork files can I upload?', 'custom44' ), __( 'We accept EPS, SVG, AI, PDF, PNG and JPG files up to 10MB. Vector files give the sharpest result. Returning customers can use artwork already on file.', 'custom44' ) ),
				array( __( 'Can you design a logo for me?', 'custom44' ), __( 'Yes. Choose the new logo design option when ordering or mention it in your enquiry and our team will work with you on a design.', 'custom44' ) ),
				array( __( 'Where can I print my logo?', 'custom44' ), __( 'Popular locations include left chest, right chest, centre front, centre back, lower back and both sleeves. Each location is priced on the product page.', 'custom44' ) ),
				array( __( 'Do you deliver outside Melbourne?', 'custom44' ), __( 'Yes. We are based in Melbourne\'s South East and dispatch orders to customers right across Australia.', 'custom44' ) ),
			);
			foreach ( $c44_faqs as $c44_k => $c44_f ) :
				?>
				<details <?php echo 0 === $c44_k ? 'open' : ''; ?>>
					<summary><?php echo esc_html( $c44_f[0] ); ?><span class="faq__icon" aria-hidden="true"><?php c44_the_icon( 'plus' ); ?></span></summary>
					<div class="faq__body"><p><?php echo esc_html( $c44_f[1] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
		<div class="section-cta reveal">
			<a class="btn btn--dark btn--lg" href="<?php echo esc_attr( c44_tel() ); ?>"><?php c44_the_icon( 'phone' ); ?><?php echo esc_html( sprintf( __( 'Call %s', 'custom44' ), c44_opt( 'phone' ) ) ); ?></a>
		</div>
	</div>
</section>

<!-- CTA band -->
<section class="section" style="padding-top:0" aria-labelledby="cta-title">
	<div class="container">
		<div class="cta-band reveal reveal--scale">
			<div>
				<h2 class="h-1" id="cta-title"><?php esc_html_e( 'Ready to kit out your crew?', 'custom44' ); ?></h2>
				<p><?php esc_html_e( 'Browse our best sellers or send us your brief. We will take care of the rest.', 'custom44' ); ?></p>
			</div>
			<div class="btn-row">
				<a class="btn btn--dark btn--lg" href="<?php echo esc_url( $c44_cat_url( 'best-sellers' ) ); ?>"><?php esc_html_e( 'Shop Best Sellers', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></a>
				<a class="btn btn--white btn--lg" href="#contact"><?php esc_html_e( 'Request a Quote', 'custom44' ); ?></a>
			</div>
		</div>
	</div>
</section>

<?php
// FAQ schema for SEO.
$c44_schema = array(
	'@context'   => 'https://schema.org',
	'@type'      => 'FAQPage',
	'mainEntity' => array_map(
		function ( $f ) {
			return array( '@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => array( '@type' => 'Answer', 'text' => $f[1] ) );
		},
		$c44_faqs
	),
);
echo '<script type="application/ld+json">' . wp_json_encode( $c44_schema ) . '</script>';

get_footer();
