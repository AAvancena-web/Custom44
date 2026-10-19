<?php
/**
 * Menu fallbacks so the theme looks complete before menus are assigned.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default primary navigation structure (mirrors the current site).
 *
 * @return array
 */
function c44_default_nav() {
	$cat = function ( $slug ) {
		return home_url( '/product-category/' . $slug . '/' );
	};
	$apparel = array( 'T-Shirts', 'Polos', 'Singlets', 'Hoodies', 'Jumpers', 'Jackets & Vests' );
	$sub     = function ( $prefix, $labels ) use ( $cat ) {
		$out = array();
		foreach ( $labels as $label ) {
			$slug  = $prefix . '-' . sanitize_title( str_replace( '&', '', $label ) );
			$out[] = array( 'title' => $label, 'url' => $cat( $slug ) );
		}
		return $out;
	};

	return array(
		array( 'title' => 'Best Sellers', 'url' => $cat( 'best-sellers' ) ),
		array(
			'title'    => 'Workwear',
			'url'      => $cat( 'workwear' ),
			'children' => array(
				array( 'title' => 'Hi-Vis T-Shirts', 'url' => $cat( 'hi-vis-t-shirts' ) ),
				array( 'title' => 'Hi-Vis Polos', 'url' => $cat( 'hi-vis-polos' ) ),
				array( 'title' => 'Hi-Vis Shirts', 'url' => $cat( 'workwear/hi-vis-shirts' ) ),
				array( 'title' => 'Hi-Vis Singlets', 'url' => $cat( 'hi-vis-singlets' ) ),
				array( 'title' => 'Hi-Vis Hoodies', 'url' => $cat( 'hi-vis-hoodies' ) ),
				array( 'title' => 'Hi-Vis Jumpers', 'url' => $cat( 'hi-vis-jumpers' ) ),
				array( 'title' => 'Hi-Vis Jackets & Vests', 'url' => $cat( 'hi-vis-jacketvests' ) ),
			),
		),
		array( 'title' => 'Mens', 'url' => $cat( 'mens' ), 'children' => array_merge( $sub( 'mens', $apparel ), array( array( 'title' => 'Trackpants', 'url' => $cat( 'mens-trackpants' ) ) ) ) ),
		array( 'title' => 'Womens', 'url' => $cat( 'womens' ), 'children' => $sub( 'womens', $apparel ) ),
		array( 'title' => 'Kids', 'url' => $cat( 'kids' ), 'children' => $sub( 'kids', $apparel ) ),
		array( 'title' => 'Headwear', 'url' => $cat( 'headwear' ) ),
		array( 'title' => 'Contact', 'url' => home_url( '/contact/' ) ),
	);
}

/**
 * Render a nav array as menu markup that matches wp_nav_menu output.
 *
 * @param array $items Items.
 * @param bool  $root  Root level.
 * @return string
 */
function c44_render_nav( $items, $root = true ) {
	$html = $root ? '<ul class="menu">' : '<ul class="sub-menu">';
	foreach ( $items as $item ) {
		$has = ! empty( $item['children'] );
		$html .= '<li class="menu-item' . ( $has ? ' menu-item-has-children' : '' ) . '"><a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['title'] ) . '</a>';
		if ( $has ) {
			$html .= c44_render_nav( $item['children'], false );
		}
		$html .= '</li>';
	}
	return $html . '</ul>';
}

/**
 * Fallback for the primary menu.
 */
function c44_primary_fallback() {
	echo c44_render_nav( c44_default_nav() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Output a menu location, or a simple fallback list.
 *
 * @param string $location Location.
 * @param array  $fallback title => url.
 */
function c44_footer_menu( $location, $fallback ) {
	if ( has_nav_menu( $location ) ) {
		wp_nav_menu( array( 'theme_location' => $location, 'container' => false, 'depth' => 1 ) );
		return;
	}
	echo '<ul>';
	foreach ( $fallback as $title => $url ) {
		echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $title ) . '</a></li>';
	}
	echo '</ul>';
}
