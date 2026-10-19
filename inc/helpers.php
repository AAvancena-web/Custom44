<?php
/**
 * Helper functions.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default theme option values (editable in Appearance > Customize > Custom 44).
 */
function c44_defaults() {
	return array(
		'phone'          => '0481 316 944',
		'email'          => 'sales@custom44.com.au',
		'location'       => "Melbourne's South East, VIC",
		'service_area'   => 'Servicing all of Australia',
		'hours'          => '',
		'map_query'      => 'Custom 44 Pty Ltd, Officer VIC',
		'map_link'       => 'https://www.google.com/maps/place/Custom+44+Pty+Ltd/@-38.0482687,145.4089145,12491m/data=!3m1!1e3!4m8!3m7!1s0x64cdbec35f67126f:0x8c1f3249aa2259ad!8m2!3d-38.0482688!4d145.4089146!9m1!1b1!16s%2Fg%2F11t6xc782n',
		'facebook'       => 'https://www.facebook.com/Custom44Melbourne',
		'instagram'      => 'https://www.instagram.com/custom.44/',
		'google_reviews' => 'https://www.google.com/maps/place/Custom+44+Pty+Ltd/@-38.0482687,145.4089145,12491m/data=!3m1!1e3!4m8!3m7!1s0x64cdbec35f67126f:0x8c1f3249aa2259ad!8m2!3d-38.0482688!4d145.4089146!9m1!1b1!16s%2Fg%2F11t6xc782n',
		'reviews_code'   => '',
		'form_code'      => '',
		'form_to'        => '',
		'announcement'   => 'Save up to <strong>35%</strong> on bulk orders, automatically applied from 5+ items.',
		'hero_title'     => 'Custom workwear, <span class="hl">printed to perform.</span>',
		'hero_text'      => "Melbourne's custom workwear printing specialists. Hi-vis, polos, hoodies and uniforms branded with commercial-grade DTF prints that survive the toughest job sites. Perfect results, every single time.",
		'hero_image'     => '/wp-content/uploads/2026/08/about-custom-44-new-bg-img.jpg',
		'hero_image_2'   => '/wp-content/uploads/2025/09/2.jpg',
		'orders'         => '10000',
		'logo_fallback'  => '/wp-content/uploads/2025/09/logo-footer.png',
	);
}

/**
 * Get a theme option.
 *
 * @param string $key Option key.
 * @return string
 */
function c44_opt( $key ) {
	$defaults = c44_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
	return get_theme_mod( 'c44_' . $key, $default );
}

/**
 * Turn a site relative upload path into a full URL. Absolute URLs pass through.
 *
 * @param string $path Path or URL.
 * @return string
 */
function c44_img( $path ) {
	if ( is_numeric( $path ) ) {
		$src = wp_get_attachment_image_url( (int) $path, 'large' );
		return $src ? $src : '';
	}
	if ( preg_match( '#^https?://#', $path ) ) {
		return $path;
	}
	return home_url( $path );
}

/**
 * Phone number formatted for tel: links.
 */
function c44_tel() {
	return 'tel:' . preg_replace( '/[^0-9+]/', '', c44_opt( 'phone' ) );
}

/**
 * Bulk discount tiers.
 *
 * @return array[] min quantity => discount percent.
 */
function c44_tiers() {
	return apply_filters(
		'c44_tiers',
		array(
			array( 'qty' => 5, 'off' => 15 ),
			array( 'qty' => 10, 'off' => 20 ),
			array( 'qty' => 20, 'off' => 25 ),
			array( 'qty' => 50, 'off' => 30 ),
			array( 'qty' => 100, 'off' => 35 ),
		)
	);
}

/**
 * Logo markup (custom logo, fallback image, or text).
 *
 * @param string $class Extra class.
 */
function c44_logo( $class = '' ) {
	$logo_id = get_theme_mod( 'custom_logo' );
	$name    = get_bloginfo( 'name' );
	echo '<a class="site-logo ' . esc_attr( $class ) . '" href="' . esc_url( home_url( '/' ) ) . '" rel="home" aria-label="' . esc_attr( $name ) . '">';
	if ( $logo_id ) {
		echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'alt' => esc_attr( $name ), 'loading' => 'eager' ) );
	} elseif ( c44_opt( 'logo_fallback' ) ) {
		echo '<img src="' . esc_url( c44_img( c44_opt( 'logo_fallback' ) ) ) . '" alt="' . esc_attr( $name ) . '" width="180" height="60">';
	} else {
		echo '<span class="site-logo__text">CUSTOM<span>44</span></span>';
	}
	echo '</a>';
}

/**
 * Category tiles used on the homepage. Pulls the WooCommerce category image when one is set.
 *
 * @return array[]
 */
function c44_home_categories() {
	$items = array(
		array( 'slug' => 'workwear', 'title' => 'Workwear', 'label' => 'Built for site', 'img' => '/wp-content/uploads/2025/09/workwear.jpg', 'tag' => 'Most ordered' ),
		array( 'slug' => 'best-sellers', 'title' => 'Best Sellers', 'label' => 'Crowd favourites', 'img' => '/wp-content/uploads/2025/09/3.jpg', 'tag' => '' ),
		array( 'slug' => 'mens', 'title' => 'Mens', 'label' => 'Tees to jackets', 'img' => '/wp-content/uploads/2025/09/mens.jpg', 'tag' => '' ),
		array( 'slug' => 'womens', 'title' => 'Womens', 'label' => 'Tailored fits', 'img' => '/wp-content/uploads/2025/09/women.jpg', 'tag' => '' ),
		array( 'slug' => 'kids', 'title' => 'Kids', 'label' => 'Schools & clubs', 'img' => '/wp-content/uploads/2025/10/3032_KIDS_SUPPLY_HOOD_ECRU__94694.1748551445.1280.1280.jpg', 'tag' => '' ),
		array( 'slug' => 'headwear', 'title' => 'Headwear', 'label' => 'Caps & beanies', 'img' => '/wp-content/uploads/2025/09/HEADWEAR-removebg-preview.png', 'tag' => '' ),
	);

	foreach ( $items as &$item ) {
		$item['url']   = home_url( '/product-category/' . $item['slug'] . '/' );
		$item['count'] = '';
		if ( taxonomy_exists( 'product_cat' ) ) {
			$term = get_term_by( 'slug', $item['slug'], 'product_cat' );
			if ( $term && ! is_wp_error( $term ) ) {
				$item['url'] = get_term_link( $term );
				/* translators: %d: number of styles */
				$item['count'] = sprintf( _n( '%d style', '%d styles', $term->count, 'custom44' ), $term->count );
				$thumb_id      = get_term_meta( $term->term_id, 'thumbnail_id', true );
				if ( $thumb_id ) {
					$src = wp_get_attachment_image_url( $thumb_id, 'large' );
					if ( $src ) {
						$item['img'] = $src;
					}
				}
			}
		}
		$item['img'] = c44_img( $item['img'] );
	}
	return apply_filters( 'c44_home_categories', $items );
}

/**
 * Product brand name (WooCommerce Brands or pa_brand attribute).
 *
 * @param WC_Product $product Product.
 * @return string
 */
function c44_product_brand( $product ) {
	foreach ( array( 'product_brand', 'pwb-brand', 'yith_product_brand' ) as $tax ) {
		if ( taxonomy_exists( $tax ) ) {
			$terms = get_the_terms( $product->get_id(), $tax );
			if ( $terms && ! is_wp_error( $terms ) ) {
				return $terms[0]->name;
			}
		}
	}
	$attr = $product->get_attribute( 'pa_brand' );
	return $attr ? $attr : '';
}

/**
 * Lowest "from" price for a product, used for "From $x" labels.
 *
 * @param WC_Product $product Product.
 * @return string Formatted price HTML or empty.
 */
function c44_from_price( $product ) {
	if ( $product->is_type( 'variable' ) ) {
		$min = $product->get_variation_price( 'min', true );
	} else {
		$min = wc_get_price_to_display( $product );
	}
	return $min ? wc_price( $min ) : '';
}
