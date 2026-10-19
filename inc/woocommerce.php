<?php
/**
 * WooCommerce integration.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

/* -------------------------------------------------------------------------
 * General
 * ---------------------------------------------------------------------- */

// Remove default wrappers and sidebar; templates provide their own layout.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Archive: result count and ordering are placed in the theme toolbar.
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );

/**
 * Products per page and columns.
 */
add_filter( 'loop_shop_per_page', function () {
	return 16;
}, 20 );
add_filter( 'loop_shop_columns', function () {
	return 4;
} );

/**
 * Breadcrumb args: plain slash delimiter.
 */
add_filter( 'woocommerce_breadcrumb_defaults', function ( $args ) {
	$args['delimiter']   = '<span class="sep">/</span>';
	$args['wrap_before'] = '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'custom44' ) . '">';
	$args['wrap_after']  = '</nav>';
	$args['before']      = '';
	$args['after']       = '';
	return $args;
} );

/**
 * Price ranges show as "From $x" (cleaner, and avoids en dash ranges).
 */
add_filter( 'woocommerce_format_price_range', function ( $price, $from, $to ) {
	/* translators: %s: lowest price */
	return '<span class="c44-from">' . esc_html__( 'From', 'custom44' ) . '</span> ' . ( is_numeric( $from ) ? wc_price( $from ) : $from );
}, 10, 3 );

/**
 * Keep the quote cart counter updated via AJAX fragments.
 */
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
	$fragments['span.c44-cart-count'] = '<span class="icon-btn__count c44-cart-count">' . esc_html( WC()->cart->get_cart_contents_count() ) . '</span>';
	return $fragments;
} );

/**
 * Disable default WooCommerce layout CSS (theme handles layout) but keep general styles.
 */
add_filter( 'woocommerce_enqueue_styles', function ( $styles ) {
	unset( $styles['woocommerce-layout'], $styles['woocommerce-smallscreen'] );
	return $styles;
} );

/* -------------------------------------------------------------------------
 * Single product summary (re-arranged with hooks so quote/option plugins keep working)
 * ---------------------------------------------------------------------- */

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

/**
 * Print location guide between the tabs and upsells.
 */
function c44_single_print_guide() {
	get_template_part( 'template-parts/print-guide' );
}
add_action( 'woocommerce_after_single_product_summary', 'c44_single_print_guide', 12 );

/**
 * Eyebrow row: brand, SKU, stock.
 */
function c44_single_eyebrow() {
	global $product;
	$brand = c44_product_brand( $product );
	echo '<div class="c44-eyebrow-row">';
	if ( $brand ) {
		echo '<span class="c44-brand">' . esc_html( $brand ) . '</span>';
	}
	if ( $product->get_sku() ) {
		echo '<span class="c44-sku">' . esc_html__( 'SKU', 'custom44' ) . ' ' . esc_html( $product->get_sku() ) . '</span>';
	}
	if ( $product->is_in_stock() ) {
		echo '<span class="c44-stock">' . esc_html__( 'In stock, ready to print', 'custom44' ) . '</span>';
	}
	echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'c44_single_eyebrow', 4 );

/**
 * Price note under the price.
 */
function c44_single_price_note() {
	echo '<p class="c44-price-note">' . esc_html__( 'Per item, before print locations. Bulk discounts apply automatically.', 'custom44' ) . '</p>';
}
add_action( 'woocommerce_single_product_summary', 'c44_single_price_note', 11 );

/**
 * Bulk tier table.
 */
function c44_single_tiers() {
	get_template_part( 'template-parts/tier-table' );
}
add_action( 'woocommerce_single_product_summary', 'c44_single_tiers', 25 );

/**
 * Trust points and help card after add to cart.
 */
function c44_single_trust() {
	$items = array(
		array( 'layers', __( 'Commercial-grade DTF print', 'custom44' ) ),
		array( 'pen', __( 'Free artwork check', 'custom44' ) ),
		array( 'truck', __( 'Australia-wide dispatch', 'custom44' ) ),
		array( 'heart', __( 'Family owned, Melbourne made', 'custom44' ) ),
	);
	echo '<ul class="pdp-trust">';
	foreach ( $items as $i ) {
		echo '<li>' . c44_icon( $i[0] ) . esc_html( $i[1] ) . '</li>'; // phpcs:ignore
	}
	echo '</ul>';
	?>
	<div class="pdp-help">
		<span class="pdp-help__icon"><?php c44_the_icon( 'phone' ); ?></span>
		<div><strong><?php esc_html_e( 'Need help with sizing or print?', 'custom44' ); ?></strong><span><?php esc_html_e( 'Talk to our team for a fast, free quote.', 'custom44' ); ?></span></div>
		<a class="btn btn--dark btn--sm" href="<?php echo esc_attr( c44_tel() ); ?>"><?php echo esc_html( c44_opt( 'phone' ) ); ?></a>
	</div>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'c44_single_trust', 35 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 45 );

/**
 * Related products: 4 items.
 */
add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
} );

/**
 * Rename the description tab heading and keep tabs clean.
 */
add_filter( 'woocommerce_product_description_heading', function () {
	return __( 'Product details', 'custom44' );
} );

/**
 * Result count without en dash ("Showing 1 to 16 of 57 styles").
 */
function c44_result_count() {
	if ( ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) {
		return;
	}
	$total    = wc_get_loop_prop( 'total' );
	$per_page = wc_get_loop_prop( 'per_page' );
	$current  = wc_get_loop_prop( 'current_page' );
	$first    = ( $per_page * $current ) - $per_page + 1;
	$last     = min( $total, $per_page * $current );
	echo '<p class="woocommerce-result-count">';
	if ( 1 === (int) $total ) {
		esc_html_e( 'Showing 1 style', 'custom44' );
	} elseif ( $total <= $per_page || -1 === $per_page ) {
		/* translators: %d: total results */
		printf( wp_kses_post( __( 'Showing all <b>%d</b> styles', 'custom44' ) ), (int) $total );
	} else {
		/* translators: 1: first result 2: last result 3: total results */
		printf( wp_kses_post( __( 'Showing %1$d to %2$d of <b>%3$d</b> styles', 'custom44' ) ), (int) $first, (int) $last, (int) $total );
	}
	echo '</p>';
}
