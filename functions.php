<?php
/**
 * Custom 44 theme functions.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

define( 'C44_VERSION', '1.0.0' );
define( 'C44_DIR', get_template_directory() );
define( 'C44_URI', get_template_directory_uri() );

require_once C44_DIR . '/inc/helpers.php';
require_once C44_DIR . '/inc/icons.php';
require_once C44_DIR . '/inc/customizer.php';
require_once C44_DIR . '/inc/contact-form.php';
require_once C44_DIR . '/inc/menus.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once C44_DIR . '/inc/woocommerce.php';
}

/**
 * Theme setup.
 */
function c44_setup() {
	load_theme_textdomain( 'custom44', C44_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 120,
			'width'       => 360,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 600,
			'single_image_width'    => 1000,
			'product_grid'          => array(
				'default_rows'    => 4,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 2,
				'max_columns'     => 4,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus(
		array(
			'primary'     => __( 'Primary Menu', 'custom44' ),
			'footer_shop' => __( 'Footer: Shop', 'custom44' ),
			'footer_help' => __( 'Footer: Helpful Links', 'custom44' ),
			'legal'       => __( 'Footer: Legal', 'custom44' ),
		)
	);
}
add_action( 'after_setup_theme', 'c44_setup' );

/**
 * Widget areas.
 */
function c44_widgets() {
	register_sidebar(
		array(
			'name'          => __( 'Shop Sidebar (Category pages)', 'custom44' ),
			'id'            => 'shop-sidebar',
			'description'   => __( 'Filters and widgets shown on product category pages.', 'custom44' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'c44_widgets' );

/**
 * Styles and scripts.
 */
function c44_assets() {
	wp_enqueue_style( 'c44-fonts', 'https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,400..900&family=Inter:wght@400;500;600;700;800&display=swap', array(), null );
	wp_enqueue_style( 'c44-main', C44_URI . '/assets/css/main.css', array(), C44_VERSION );
	wp_enqueue_script( 'c44-main', C44_URI . '/assets/js/main.js', array(), C44_VERSION, array( 'in_footer' => true, 'strategy' => 'defer' ) );
}
add_action( 'wp_enqueue_scripts', 'c44_assets' );

/**
 * Preconnect to Google Fonts.
 */
function c44_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'c44_resource_hints', 10, 2 );

/**
 * Mark the document as JS-enabled as early as possible (prevents hidden reveal content without JS).
 */
function c44_js_class() {
	echo "<script>document.documentElement.classList.remove('no-js');</script>\n";
}
add_action( 'wp_head', 'c44_js_class', 0 );

/**
 * Title separator (no em dash).
 */
add_filter( 'document_title_separator', function () {
	return '|';
} );

/**
 * Replace em and en dashes in rendered content with plain alternatives.
 * Keeps the brand rule of "no em dash" across editor content and Woo output.
 */
function c44_strip_dashes( $text ) {
	if ( ! is_string( $text ) || '' === $text ) {
		return $text;
	}
	$em = "\u{2014}";
	$en = "\u{2013}";
	return str_replace(
		array( ' &#8212; ', ' &mdash; ', ' ' . $em . ' ', '&#8212;', '&mdash;', $em, '&#8211;', '&ndash;', $en ),
		array( ', ', ', ', ', ', ', ', ', ', ', ', '-', '-', '-' ),
		$text
	);
}
foreach ( array( 'the_content', 'the_excerpt', 'the_title', 'term_description', 'woocommerce_short_description', 'widget_text_content', 'get_the_archive_description' ) as $c44_filter ) {
	add_filter( $c44_filter, 'c44_strip_dashes', 99 );
}
// Stop WordPress converting "--" into dashes.
add_filter( 'run_wptexturize', '__return_false' );
