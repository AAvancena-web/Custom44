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
	// Mirrors the live custom44.com.au menu (labels and URLs) so nothing changes for shoppers.
	$cat = function ( $slug ) {
		return home_url( '/product-category/' . $slug . '/' );
	};
	$items = function ( $rows ) use ( $cat ) {
		$out = array();
		foreach ( $rows as $title => $slug ) {
			$out[] = array( 'title' => $title, 'url' => $cat( $slug ) );
		}
		return $out;
	};

	return array(
		array(
			'title'    => 'Value Packs',
			'url'      => $cat( 'value-packs' ),
			'children' => $items( array( 'Hi Vis Packs' => 'value-packs/hi-vis-packs', 'Workwear Packs' => 'value-packs/workwear-packs' ) ),
		),
		array( 'title' => 'Best Sellers', 'url' => $cat( 'best-sellers' ) ),
		array(
			'title'    => 'Workwear',
			'url'      => $cat( 'workwear' ),
			'children' => $items(
				array(
					'Hi-Vis Polos'           => 'hi-vis-polos',
					'Hi-Vis Shirts'          => 'workwear/hi-vis-shirts',
					'Hi-Vis Singlets'        => 'hi-vis-singlets',
					'Hi-Vis Hoodies'         => 'hi-vis-hoodies',
					'Hi-Vis Jumpers'         => 'hi-vis-jumpers',
					'Hi-Vis Jackets & Vests' => 'hi-vis-jacketvests',
				)
			),
		),
		array(
			'title'    => 'Mens',
			'url'      => $cat( 'mens' ),
			'children' => $items(
				array(
					'T-Shirts'        => 'mens/t-shirts',
					'Polos'           => 'mens/polos',
					'Singlets'        => 'mens-singlets',
					'Hoodies'         => 'mens/mens-hoodies',
					'Jumpers'         => 'jumpers',
					'Jackets & Vests' => 'jackets-vest',
					'Trackpants'      => 'mens/trackpants',
				)
			),
		),
		array(
			'title'    => 'Womens',
			'url'      => $cat( 'womens' ),
			'children' => $items(
				array(
					'T-Shirts'        => 'womens/womens-t-shirts',
					'Polos'           => 'womens/womens-polos',
					'Singlets'        => 'womens-singlets',
					'Hoodies'         => 'womens/womens-hoodies',
					'Jumpers'         => 'womens-jumpers',
					'Jackets & Vests' => 'womens/womens-jackets-vests',
				)
			),
		),
		array(
			'title'    => 'Kids',
			'url'      => $cat( 'kids' ),
			'children' => $items(
				array(
					'T-Shirts'       => 'kids-t-shirts',
					'Polos'          => 'kids-polos',
					'Singlets'       => 'kids-singlets',
					'Hoodies'        => 'kids-hoodies',
					'Jumpers'        => 'kids-jumpers',
					'Jacket & Vests' => 'kids-jackets-vests',
				)
			),
		),
		array( 'title' => 'Headwear', 'url' => $cat( 'headwear' ) ),
		array( 'title' => 'Contact Us', 'url' => home_url( '/contact/' ) ),
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
