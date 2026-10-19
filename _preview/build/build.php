<?php
/**
 * Renders static HTML previews of the theme templates: php -I build.php
 */
require __DIR__ . '/stubs.php';
require get_template_directory() . '/functions.php';
do_action( 'after_setup_theme' );

$out = dirname( __DIR__ );
$pages = array(
	'home'     => array( 'index.html', 'Custom 44 | Custom Workwear Printing Melbourne', '/front-page.php' ),
	'category' => array( 'category.html', 'Workwear | Custom 44', '/woocommerce/archive-product.php' ),
	'product'  => array( 'product.html', "JB's Hi Vis S/S Spider Polo | Custom 44", '/woocommerce/single-product.php' ),
);
foreach ( $pages as $key => $p ) {
	$GLOBALS['c44_page']  = $key;
	$GLOBALS['c44_title'] = $p[1];
	$all = c44__products();
	$GLOBALS['c44_loop'] = 'category' === $key ? $all : array( $all[1] );
	$GLOBALS['c44_loop_i'] = 0;
	$GLOBALS['c44_single'] = $all[1];
	ob_start();
	require get_template_directory() . $p[2];
	$html = ob_get_clean();
	file_put_contents( $out . '/' . $p[0], $html );
	echo "wrote {$p[0]} (" . strlen( $html ) . " bytes)\n";
}
