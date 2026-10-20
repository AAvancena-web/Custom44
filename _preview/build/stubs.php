<?php
/**
 * Minimal WordPress + WooCommerce stand-ins used ONLY to render static previews of the
 * real theme templates (see build.php). Not loaded by WordPress.
 */

define( 'ABSPATH', __DIR__ . '/' );
define( 'C44_PREVIEW', true );
$GLOBALS['c44_home'] = 'https://custom44.com.au';
$GLOBALS['c44_asset_base'] = '..';
$GLOBALS['c44_hooks'] = array();
$GLOBALS['c44_page'] = 'home';

/* Hooks ------------------------------------------------------------------ */
function add_action( $h, $cb, $p = 10, $a = 1 ) { $GLOBALS['c44_hooks'][ $h ][ $p ][] = array( $cb, $a ); return true; }
function add_filter( $h, $cb, $p = 10, $a = 1 ) { return add_action( $h, $cb, $p, $a ); }
function remove_action( $h, $cb, $p = 10 ) {
	if ( empty( $GLOBALS['c44_hooks'][ $h ][ $p ] ) ) return false;
	foreach ( $GLOBALS['c44_hooks'][ $h ][ $p ] as $i => $x ) { if ( $x[0] === $cb ) unset( $GLOBALS['c44_hooks'][ $h ][ $p ][ $i ] ); }
	return true;
}
function c44__sorted( $h ) { if ( empty( $GLOBALS['c44_hooks'][ $h ] ) ) return array(); $x = $GLOBALS['c44_hooks'][ $h ]; ksort( $x ); return $x; }
function do_action( $h, ...$args ) { foreach ( c44__sorted( $h ) as $list ) foreach ( $list as $cb ) call_user_func_array( $cb[0], array_slice( $args, 0, $cb[1] ) ); }
function apply_filters( $h, $v, ...$args ) { foreach ( c44__sorted( $h ) as $list ) foreach ( $list as $cb ) $v = call_user_func_array( $cb[0], array_slice( array_merge( array( $v ), $args ), 0, $cb[1] ) ); return $v; }
function __return_false() { return false; }

/* Core ------------------------------------------------------------------- */
function get_template_directory() { return dirname( __DIR__, 2 ); }
function get_template_directory_uri() { return $GLOBALS['c44_asset_base']; }
function add_theme_support() {}
function register_nav_menus() {}
function register_sidebar() {}
function load_theme_textdomain() {}
function wp_enqueue_style() {}
function wp_enqueue_script() {}
function get_theme_mod( $k, $d = '' ) { return $d; }
function home_url( $p = '' ) {
	if ( 0 === strpos( ltrim( $p, '/' ), 'product-category/' ) ) return 'category.html';
	if ( '' === $p || '/' === $p ) return 'index.html';
	if ( 0 === strpos( ltrim( $p, '/' ), 'wp-content/' ) ) return $GLOBALS['c44_home'] . '/' . ltrim( $p, '/' );
	return $GLOBALS['c44_home'] . '/' . ltrim( $p, '/' );
}
function admin_url( $p = '' ) { return home_url( 'wp-admin/' . $p ); }
function wp_get_attachment_image_url() { return ''; }
function wp_get_attachment_image() { return ''; }
function get_bloginfo( $k = 'name' ) { return 'charset' === $k ? 'UTF-8' : 'Custom 44'; }
function bloginfo( $k = 'name' ) { echo get_bloginfo( $k ); }
function esc_html( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8', false ); }
function esc_attr( $s ) { return esc_html( $s ); }
function esc_url( $s ) { return esc_html( $s ); }
function esc_url_raw( $s ) { return $s; }
function esc_textarea( $s ) { return esc_html( $s ); }
function __( $s ) { return $s; }
function _e( $s ) { echo $s; }
function esc_html__( $s ) { return esc_html( $s ); }
function esc_attr__( $s ) { return esc_attr( $s ); }
function esc_html_e( $s ) { echo esc_html( $s ); }
function esc_attr_e( $s ) { echo esc_attr( $s ); }
function _n( $a, $b, $n ) { return 1 === (int) $n ? $a : $b; }
function wp_kses_post( $s ) { return $s; }
function sanitize_title( $s ) { return trim( preg_replace( '/[^a-z0-9]+/', '-', strtolower( $s ) ), '-' ); }
function sanitize_key( $s ) { return strtolower( preg_replace( '/[^a-z0-9_\-]/i', '', $s ) ); }
function sanitize_text_field( $s ) { return trim( strip_tags( $s ) ); }
function wp_unslash( $s ) { return $s; }
function is_ssl() { return true; }
function language_attributes() { echo 'lang="en-AU"'; }
function wp_head() {
	echo '<title>' . esc_html( $GLOBALS['c44_title'] ) . '</title>' . "\n";
	echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,400..900&family=Inter:wght@400;500;600;700;800&display=swap">' . "\n";
	echo '<link rel="stylesheet" href="' . $GLOBALS['c44_asset_base'] . '/assets/css/main.css">' . "\n";
	do_action( 'wp_head' );
}
function wp_footer() {
	echo '<script src="' . $GLOBALS['c44_asset_base'] . '/assets/js/main.js" defer></script>' . "\n";
	if ( 'product' === $GLOBALS['c44_page'] ) {
		echo "<script>document.addEventListener('click',function(e){var a=e.target.closest('.wc-tabs a');if(!a)return;e.preventDefault();document.querySelectorAll('.wc-tabs li').forEach(function(l){l.classList.remove('active')});a.parentElement.classList.add('active');document.querySelectorAll('.woocommerce-Tabs-panel').forEach(function(p){p.style.display='none'});document.querySelector(a.getAttribute('href')).style.display='block';});document.addEventListener('click',function(e){var t=e.target.closest('.flex-control-thumbs img');if(!t)return;document.querySelector('.woocommerce-product-gallery__image img').src=t.dataset.full;document.querySelectorAll('.flex-control-thumbs img').forEach(function(i){i.classList.remove('flex-active')});t.classList.add('flex-active');});</script>\n";
	}
}
function body_class( $c = '' ) {
	$map = array( 'home' => 'home page-template-default', 'category' => 'archive tax-product_cat woocommerce woocommerce-page', 'product' => 'product-template-default single single-product woocommerce woocommerce-page' );
	echo 'class="' . $map[ $GLOBALS['c44_page'] ] . '"';
}
function wp_body_open() {}
function has_nav_menu() { return false; }
function wp_nav_menu( $args ) { if ( ! empty( $args['fallback_cb'] ) ) call_user_func( $args['fallback_cb'] ); }
function get_search_query() { return ''; }
function get_header() { require get_template_directory() . '/header.php'; }
function get_footer() { require get_template_directory() . '/footer.php'; }
function get_template_part( $slug ) { require get_template_directory() . '/' . $slug . '.php'; }
function wp_nonce_field() { echo '<input type="hidden" name="c44_nonce" value="preview">'; }
function do_shortcode( $s ) { return $s; }
function number_format_i18n( $n ) { return number_format( $n ); }
function wp_json_encode( $d ) { return json_encode( $d ); }
function is_active_sidebar() { return false; }
function dynamic_sidebar() {}
function get_option( $k ) { return 0; }
function is_wp_error( $x ) { return false; }
function wp_list_pluck( $list, $f ) { $o = array(); foreach ( $list as $x ) { if ( is_object( $x ) ) $o[] = $x->$f; } return $o; }
function is_cart() { return false; }
function is_checkout() { return false; }
function is_account_page() { return false; }
function post_password_required() { return false; }
function the_ID() { echo 101; }
function get_the_ID() { return $GLOBALS['c44_cur_id']; }
function wp_reset_postdata() {}

/* Taxonomy --------------------------------------------------------------- */
function taxonomy_exists( $t ) { return 'product_cat' === $t || 'product_tag' === $t; }
function c44__term( $id, $slug, $name, $count, $parent = 0 ) { return (object) array( 'term_id' => $id, 'slug' => $slug, 'name' => $name, 'count' => $count, 'parent' => $parent, 'taxonomy' => 'product_cat' ); }
function c44__terms() {
	static $t = null;
	if ( $t ) return $t;
	$t = array(
		c44__term( 1, 'best-sellers', 'Best Sellers', 15 ), c44__term( 2, 'workwear', 'Workwear', 57 ), c44__term( 3, 'mens', 'Mens', 86 ),
		c44__term( 4, 'womens', 'Womens', 48 ), c44__term( 5, 'kids', 'Kids', 22 ), c44__term( 6, 'headwear', 'Headwear', 14 ),
		c44__term( 21, 'hi-vis-t-shirts', 'Hi-Vis T-Shirts', 6, 2 ), c44__term( 22, 'hi-vis-polos', 'Hi-Vis Polos', 14, 2 ), c44__term( 23, 'hi-vis-shirts', 'Hi-Vis Shirts', 7, 2 ),
		c44__term( 24, 'hi-vis-singlets', 'Hi-Vis Singlets', 4, 2 ), c44__term( 25, 'hi-vis-hoodies', 'Hi-Vis Hoodies', 12, 2 ), c44__term( 26, 'hi-vis-jumpers', 'Hi-Vis Jumpers', 6, 2 ),
		c44__term( 27, 'hi-vis-jacketvests', 'Hi-Vis Jackets & Vests', 8, 2 ),
	);
	return $t;
}
function get_term_by( $f, $v ) { foreach ( c44__terms() as $t ) if ( $t->slug === $v ) return $t; return false; }
function get_term_link( $t ) { return home_url( 'product-category/' . $t->slug . '/' ); }
function get_term_meta() { return ''; }
function get_terms( $a ) { $o = array(); foreach ( c44__terms() as $t ) if ( isset( $a['parent'] ) && (int) $t->parent === (int) $a['parent'] ) $o[] = $t; return $o; }
function term_is_ancestor_of( $a, $b ) { return (int) $b->parent === (int) $a->term_id; }
function get_the_terms( $id, $tax ) {
	if ( 'product_tag' === $tax ) return 101 === $id || 1 === $id ? array( (object) array( 'slug' => 'most-popular' ) ) : array();
	return $GLOBALS['c44_page'] === 'home' ? array( (object) array( 'slug' => 'best-sellers' ) ) : array();
}
function is_product_taxonomy() { return 'category' === $GLOBALS['c44_page']; }
function get_queried_object() { return get_term_by( 'slug', 'workwear' ); }
function term_description() { return '<p>Custom branded workwear, from hi-vis to polos and jackets. Every logo is printed in Melbourne using DTF technology for a sharp, durable finish. Choose a style to see pricing and request a free quote.</p>'; }
function wp_count_posts() { return (object) array( 'publish' => 300 ); }

/* WooCommerce ------------------------------------------------------------ */
class WooCommerce {}
function WC() { return (object) array( 'cart' => null ); }
function wc_get_cart_url() { return home_url( 'cart-2/' ); }
function wc_get_page_permalink( $p ) { return 'shop' === $p ? home_url( 'shop/' ) : home_url( 'my-account-2/' ); }
function wc_price( $n ) { return '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>' . number_format( (float) $n, 2 ) . '</bdi></span>'; }
function wc_get_price_to_display( $p ) { return $p->min; }
function wc_product_class( $c, $p ) { echo 'class="product type-product ' . esc_attr( $c ) . '"'; }

class WC_Product {
	public $id, $name, $sku, $min, $max, $img, $brand;
	public function __construct( $d ) { foreach ( $d as $k => $v ) $this->$k = $v; }
	public function get_id() { return $this->id; }
	public function get_sku() { return $this->sku; }
	public function get_name() { return $this->name; }
	public function get_permalink() { return 'product.html'; }
	public function full() { return preg_replace( '/-\d+x\d+(\.\w+)$/', '$1', $this->img ); }
	public function get_image() { return '<img src="' . esc_url( $this->full() ) . '" onerror="this.onerror=null;this.src=\'' . esc_url( $this->img ) . '\'" alt="' . esc_attr( $this->name ) . '" loading="lazy" width="600" height="600">'; }
	public function get_price_html() { return apply_filters( 'woocommerce_format_price_range', '', $this->min, $this->max ) . ''; }
	public function is_on_sale() { return false; }
	public function is_type( $t ) { return 'variable' === $t; }
	public function get_variation_price() { return $this->min; }
	public function get_attribute() { return $this->brand; }
	public function is_in_stock() { return true; }
	public function is_visible() { return true; }
	public function get_review_count() { return 0; }
	public function get_image_id() { return 0; }
}
function c44__products() {
	$u = 'https://custom44.com.au/wp-content/uploads/';
	$rows = array(
		array( "ASCOLOUR Staple Tee", '5001', 17.55, 27, '2025/12/5001_STAPLE_TEE_ARCTIC_BLUE__41532.1750652269.1280.1280-300x300.jpg', 'AS Colour' ),
		array( "JB's Hi Vis S/S Spider Polo", '6HSP', 27.30, 42, '2025/10/6HSPEB_1_635484437303012044-300x366.jpg', "JB's Wear" ),
		array( "JB's Hi Vis S/S Arm Panel Polo", '6AP4S', 27.95, 43, '2025/10/6AP4SEB_1_635484434081889370-300x366.jpg', "JB's Wear" ),
		array( 'AIW Alliance S/S Safety Polo', 'SW71', 25.35, 39, '2026/10/SW71_OrangeNavy_l-300x381.jpg', 'AIW' ),
		array( "JB's Hi Vis Southern Cross Polo", '6HSC', 28.60, 44, '2025/10/6HSC_EG_0120copy_637091565975498409-300x367.jpg', "JB's Wear" ),
		array( "JB's Hi Vis 280G Pull Over Hoodie", '6HVPH', 39.00, 60, '2025/10/6HVPH_EB_0120copy_637572006166524083-300x367.jpg', "JB's Wear" ),
		array( "JB's Hi Vis 350G Trade Hoodie", '6CHVH', 46.80, 72, '2026/07/6CHVH_ON_01_639040801633024948-1-300x366.jpg', "JB's Wear" ),
		array( 'AIW Hi-Vis Two Tone Fleecy Hoodie', 'SW38', 36.40, 56, '2026/10/SW38_OrangeNavy_l-300x381.jpg', 'AIW' ),
		array( "JB's Hi Vis Full Zip Fleecy Hoodie", '6HVH', 45.50, 70, '2025/10/6HVH_EN_01_639162655045556321-300x366.jpg', "JB's Wear" ),
		array( "JB's Hi Vis Rippa Sub Polo", '6HVRS', 28.60, 44, '2025/10/6HVRSEB_01_636656914088830849-300x367.jpg', "JB's Wear" ),
		array( "JB's Hi Vis Net Sub Polo", '6HVNS', 28.60, 44, '2025/10/6HVNSEB_1_635484442273381364-300x366.jpg', "JB's Wear" ),
		array( "JB's Hi Vis S/S Cotton Polo", '6CPHV', 29.90, 46, '2025/10/6CPHV_EB_01_638411877806039757-300x366.jpg', "JB's Wear" ),
		array( 'ASCOLOUR Classic Tee', '5026', 20.80, 32, '2025/10/5026_CLASSIC_TEE_RED__05370.1753143714.386.513-300x300.jpg', 'AS Colour' ),
		array( "JB's 210 Polo", '210', 22.75, 35, '2025/10/2101_01_636173073886203878-300x366.jpg', "JB's Wear" ),
		array( 'ASCOLOUR Supply Hood', '5101', 34.45, 53, '2026/04/5101_SUPPLY_HOOD_RED__22117.1590379811.1280.1280-300x300.jpg', 'AS Colour' ),
		array( "JB's Contrast Fleecy Hoodie", '3CFH', 40.95, 63, '2025/10/3CFH_BC_01_638512143459332329-300x367.jpg', "JB's Wear" ),
	);
	$o = array();
	foreach ( $rows as $i => $r ) {
		$o[] = new WC_Product( array( 'id' => $i + 1, 'name' => $r[0], 'sku' => $r[1], 'min' => $r[2], 'max' => $r[3], 'img' => $u . $r[4], 'brand' => $r[5] ) );
	}
	return $o;
}
function wc_get_product( $id ) { foreach ( c44__products() as $p ) if ( $p->id === $id ) return $p; return null; }

class WP_Query {
	public $posts, $i = 0;
	public function __construct( $a ) {
		$all = c44__products();
		$this->posts = array( $all[0], $all[12], $all[13], $all[1], $all[2], $all[14], $all[15], $all[6] );
	}
	public function have_posts() { return $this->i < count( $this->posts ); }
	public function the_post() { $GLOBALS['c44_cur_id'] = $this->posts[ $this->i ]->id; $this->i++; }
}

/* Archive loop */
$GLOBALS['c44_loop'] = array();
$GLOBALS['c44_loop_i'] = 0;
function have_posts() { return $GLOBALS['c44_loop_i'] < count( $GLOBALS['c44_loop'] ); }
function the_post() { global $product; $product = $GLOBALS['c44_loop'][ $GLOBALS['c44_loop_i'] ]; $GLOBALS['c44_loop_i']++; }
function woocommerce_product_loop() { return true; }
function woocommerce_products_will_display() { return true; }
function wc_get_loop_prop( $k ) { $p = array( 'is_paginated' => true, 'total' => 57, 'per_page' => 16, 'current_page' => 1 ); return $p[ $k ]; }
function woocommerce_page_title() { return 'Workwear'; }
function woocommerce_breadcrumb( $args = array() ) {
	$d = apply_filters( 'woocommerce_breadcrumb_defaults', array() );
	$a = array_merge( $d, $args );
	$crumbs = 'product' === $GLOBALS['c44_page'] ? array( 'Home' => home_url(), 'Workwear' => home_url( 'product-category/workwear/' ), 'Hi-Vis Polos' => home_url( 'product-category/hi-vis-polos/' ), "JB's Hi Vis S/S Spider Polo" => '' ) : array( 'Home' => home_url(), 'Workwear' => '' );
	$out = array();
	foreach ( $crumbs as $t => $u ) $out[] = $u ? '<a href="' . esc_url( $u ) . '">' . esc_html( $t ) . '</a>' : '<span>' . esc_html( $t ) . '</span>';
	echo $a['wrap_before'] . implode( $a['delimiter'], $out ) . $a['wrap_after'];
}
function woocommerce_catalog_ordering() {
	echo '<form class="woocommerce-ordering" method="get"><select name="orderby" class="orderby" aria-label="Shop order"><option>Default sorting</option><option>Sort by popularity</option><option>Sort by average rating</option><option>Sort by latest</option><option>Sort by price: low to high</option><option>Sort by price: high to low</option></select></form>';
}
function woocommerce_product_loop_start() { echo '<ul class="products columns-4">'; }
function woocommerce_product_loop_end() { echo '</ul>'; }
function wc_get_template_part( $slug, $name ) {
	if ( 'single-product' === $name ) { global $product; $product = $GLOBALS['c44_single']; }
	require get_template_directory() . '/woocommerce/' . $slug . '-' . $name . '.php';
}
function woocommerce_pagination() {
	echo '<nav class="woocommerce-pagination"><ul class="page-numbers"><li><span aria-current="page" class="page-numbers current">1</span></li><li><a class="page-numbers" href="#">2</a></li><li><a class="page-numbers" href="#">3</a></li><li><a class="page-numbers" href="#">4</a></li><li><a class="next page-numbers" href="#">&rarr;</a></li></ul></nav>';
}
function woocommerce_output_all_notices() {}

/* Default Woo single product hooks (as WooCommerce registers them) */
function woocommerce_show_product_sale_flash() {}
function woocommerce_show_product_images() {
	$p = $GLOBALS['c44_single'];
	$imgs = array(
		'https://custom44.com.au/wp-content/uploads/2025/10/6HSPEB_1_635484437303012044.jpg',
		'https://custom44.com.au/wp-content/uploads/2025/10/6HSC_EG_0120copy_637091565975498409.jpg',
		'https://custom44.com.au/wp-content/uploads/2025/10/6HVRSEB_01_636656914088830849.jpg',
		'https://custom44.com.au/wp-content/uploads/2025/10/6HVNSEB_1_635484442273381364.jpg',
		'https://custom44.com.au/wp-content/uploads/2025/10/6CPHV_EB_01_638411877806039757.jpg',
	);
	echo '<div class="woocommerce-product-gallery woocommerce-product-gallery--with-images images"><a href="#" class="woocommerce-product-gallery__trigger">Zoom</a>';
	echo '<div class="woocommerce-product-gallery__wrapper"><div class="woocommerce-product-gallery__image"><img src="' . $imgs[0] . '" alt="' . esc_attr( $p->name ) . '" width="1000" height="1000"></div></div>';
	echo '<ol class="flex-control-nav flex-control-thumbs">';
	foreach ( $imgs as $i => $src ) echo '<li><img src="' . $src . '" data-full="' . $src . '" class="' . ( 0 === $i ? 'flex-active' : '' ) . '" alt="" width="200" height="200"></li>';
	echo '</ol></div>';
}
function woocommerce_template_single_title() { echo '<h1 class="product_title entry-title">' . esc_html( $GLOBALS['c44_single']->name ) . '</h1>'; }
function woocommerce_template_single_rating() {}
function woocommerce_template_single_price() { echo '<p class="price">' . $GLOBALS['c44_single']->get_price_html() . '</p>'; }
function woocommerce_template_single_excerpt() { echo '<div class="woocommerce-product-details__short-description"><p>A breathable, quick-dry hi-vis polo with spider-mesh panels built for long days on site. Day/night compliant colourways with a durable finish that takes your logo beautifully.</p></div>'; }
function woocommerce_template_single_add_to_cart() {
	$colours = array( 'Orange/Navy', 'Yellow/Navy', 'Orange/Black', 'Yellow/Black', 'Lime/Navy', 'Orange/Bottle', 'Yellow/Bottle', 'Orange/Royal', 'Yellow/Royal', 'Lime/Black' );
	$sizes = array( 'S' => 42, 'M' => 42, 'L' => 42, 'XL' => 42, '2XL' => 44, '3XL' => 46, '4XL' => 48, '5XL' => 50 );
	$spots = array( array( 'Left Chest', 5, true ), array( 'Centre Back', 5, true ), array( 'Right Chest', 5, false ), array( 'Left Sleeve', 7, false ), array( 'Right Sleeve', 7, false ), array( 'Centre Front', 5, false ), array( 'Lower Back', 8, false ) );
	echo '<form class="cart c44-demo-options" method="post">';
	echo '<div class="c44-opt"><label class="c44-opt__label">1. Colour</label><div class="c44-swatches">';
	foreach ( $colours as $i => $c ) echo '<label class="c44-swatch"><input type="radio" name="c" ' . ( 0 === $i ? 'checked' : '' ) . '><span>' . esc_html( $c ) . '</span></label>';
	echo '</div></div>';
	echo '<div class="c44-opt"><label class="c44-opt__label">2. Sizes & quantities</label><div class="c44-sizes">';
	foreach ( $sizes as $s => $pr ) echo '<label class="c44-size"><span>' . $s . '<small>$' . number_format( $pr, 2 ) . '</small></span><input type="number" min="0" value="0" inputmode="numeric" data-price="' . $pr . '" aria-label="Quantity ' . $s . '"></label>';
	echo '</div></div>';
	echo '<div class="c44-opt"><label class="c44-opt__label">3. Print locations</label><div class="c44-spots">';
	foreach ( $spots as $sp ) echo '<label class="c44-spot"><input type="checkbox" data-price="' . $sp[1] . '"' . ( 'Left Chest' === $sp[0] ? ' checked' : '' ) . '><span>' . esc_html( $sp[0] ) . ( $sp[2] ? ' <em>Popular</em>' : '' ) . '<small>+$' . number_format( $sp[1], 2 ) . '</small></span></label>';
	echo '</div></div>';
	echo '<div class="c44-opt"><label class="c44-opt__label" for="art">4. Artwork</label><select id="art"><option>I will supply my own artwork</option><option>Use my file on record</option><option>Design a new logo for me</option></select></div>';
	echo '<button type="submit" class="single_add_to_cart_button button alt">Add to Quote</button></form>';
}
function woocommerce_template_single_meta() { echo '<div class="product_meta"><span class="sku_wrapper">SKU: <span class="sku">6HSP</span></span><span class="posted_in">Categories: <a href="#">Hi-Vis Polos</a>, <a href="#">Workwear</a></span><span class="tagged_as">Brand: <a href="#">JB\'s Wear</a></span></div>'; }
function woocommerce_template_single_sharing() {}
function woocommerce_output_product_data_tabs() {
	$tabs = array(
		'description' => array( 'title' => 'Description', 'priority' => 10, 'callback' => function () {
			echo '<h2>' . apply_filters( 'woocommerce_product_description_heading', 'Description' ) . '</h2><p>Stay cool and visible with the JB\'s Hi Vis S/S Spider Polo. Spider-mesh side and underarm panels move air where you need it most, while the quick-dry fabric keeps you comfortable through the hottest Aussie days.</p><ul><li>Breathable spider-mesh panels</li><li>Quick-dry, moisture wicking polyester</li><li>Day use hi-vis colourways</li><li>Three button placket with contrast collar</li><li>UPF rated fabric</li></ul><h3>Logo print location information</h3><ul><li>Front left or right chest: max 10cm x 10cm</li><li>Back print: max 28cm x 30cm</li></ul>';
		} ),
		'additional_information' => array( 'title' => 'Additional information', 'priority' => 20, 'callback' => function () {
			echo '<h2>Additional information</h2><table class="shop_attributes"><tr><th>Colour</th><td>Orange/Navy, Yellow/Navy, Orange/Black, Yellow/Black, Lime/Navy</td></tr><tr><th>Size</th><td>S, M, L, XL, 2XL, 3XL, 4XL, 5XL</td></tr></table>';
		} ),
		'reviews' => array( 'title' => 'Reviews (0)', 'priority' => 30, 'callback' => function () { echo '<h2>Reviews</h2><p>There are no reviews yet.</p>'; } ),
	);
	$tabs = apply_filters( 'woocommerce_product_tabs', $tabs );
	uasort( $tabs, function ( $x, $y ) { return $x['priority'] <=> $y['priority']; } );
	echo '<div class="woocommerce-tabs wc-tabs-wrapper"><ul class="tabs wc-tabs" role="tablist">';
	$i = 0;
	foreach ( $tabs as $k => $t ) echo '<li class="' . $k . '_tab' . ( 0 === $i++ ? ' active' : '' ) . '"><a href="#tab-' . $k . '">' . esc_html( $t['title'] ) . '</a></li>';
	echo '</ul>';
	$i = 0;
	foreach ( $tabs as $k => $t ) {
		echo '<div class="woocommerce-Tabs-panel panel" id="tab-' . $k . '"' . ( 0 === $i++ ? '' : ' style="display:none"' ) . '>';
		call_user_func( $t['callback'], $k, $t );
		echo '</div>';
	}
	echo '</div>';
}
function woocommerce_upsell_display() {}
function woocommerce_output_related_products() {
	$args = apply_filters( 'woocommerce_output_related_products_args', array() );
	global $product;
	$keep = $product;
	echo '<section class="related products"><h2>Related products</h2><ul class="products columns-4">';
	foreach ( array_slice( c44__products(), 9, $args['posts_per_page'] ) as $p ) { $product = $p; require get_template_directory() . '/woocommerce/content-product.php'; }
	echo '</ul></section>';
	$product = $keep;
}

$c44_defaults = array(
	'woocommerce_before_single_product_summary' => array( array( 'woocommerce_show_product_sale_flash', 10 ), array( 'woocommerce_show_product_images', 20 ) ),
	'woocommerce_single_product_summary' => array( array( 'woocommerce_template_single_title', 5 ), array( 'woocommerce_template_single_rating', 10 ), array( 'woocommerce_template_single_price', 10 ), array( 'woocommerce_template_single_excerpt', 20 ), array( 'woocommerce_template_single_add_to_cart', 30 ), array( 'woocommerce_template_single_meta', 40 ), array( 'woocommerce_template_single_sharing', 50 ) ),
	'woocommerce_after_single_product_summary' => array( array( 'woocommerce_output_product_data_tabs', 10 ), array( 'woocommerce_upsell_display', 15 ), array( 'woocommerce_output_related_products', 20 ) ),
	'woocommerce_after_shop_loop' => array( array( 'woocommerce_pagination', 10 ) ),
	'woocommerce_before_shop_loop' => array( array( 'woocommerce_output_all_notices', 10 ) ),
);
foreach ( $c44_defaults as $h => $list ) foreach ( $list as $x ) add_action( $h, $x[0], $x[1] );
