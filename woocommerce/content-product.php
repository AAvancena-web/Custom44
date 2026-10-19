<?php
/**
 * Product card within loops. The whole card is clickable.
 *
 * @package Custom44
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

get_template_part( 'template-parts/product-card' );
