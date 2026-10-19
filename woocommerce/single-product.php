<?php
/**
 * Single product page.
 *
 * @package Custom44
 * @version 1.6.4
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>
<div class="pdp-crumbs">
	<div class="container"><?php woocommerce_breadcrumb( array( 'wrap_before' => '<nav class="breadcrumb breadcrumb--light" aria-label="Breadcrumb">' ) ); ?></div>
</div>
<?php
do_action( 'woocommerce_before_main_content' );

while ( have_posts() ) :
	the_post();
	wc_get_template_part( 'content', 'single-product' );
endwhile;

do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
