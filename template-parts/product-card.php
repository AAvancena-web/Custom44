<?php
/**
 * Product card. The entire card is a single link.
 *
 * Expects global $product (WC_Product).
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

global $product;
if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
	return;
}

$c44_brand  = c44_product_brand( $product );
$c44_sku    = $product->get_sku();
$c44_meta   = array_filter( array( $c44_brand, $c44_sku ? 'SKU ' . $c44_sku : '' ) );
$c44_tags   = get_the_terms( $product->get_id(), 'product_tag' );
$c44_tags   = is_array( $c44_tags ) ? wp_list_pluck( $c44_tags, 'slug' ) : array();
$c44_cats   = get_the_terms( $product->get_id(), 'product_cat' );
$c44_cats   = is_array( $c44_cats ) ? wp_list_pluck( $c44_cats, 'slug' ) : array();
$c44_badges = array();
if ( $product->is_on_sale() ) {
	$c44_badges[] = array( 'Sale', 'badge--orange' );
}
if ( in_array( 'most-popular', $c44_tags, true ) ) {
	$c44_badges[] = array( 'Most Popular', 'badge--accent' );
} elseif ( in_array( 'best-sellers', $c44_cats, true ) ) {
	$c44_badges[] = array( 'Best Seller', 'badge--accent' );
}
?>
<li <?php wc_product_class( 'c44-product', $product ); ?>>
	<a class="product-card" href="<?php echo esc_url( $product->get_permalink() ); ?>">
		<div class="product-card__media">
			<?php echo $product->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php if ( $c44_badges ) : ?>
				<div class="product-card__badges">
					<?php foreach ( $c44_badges as $c44_badge ) : ?>
						<span class="badge <?php echo esc_attr( $c44_badge[1] ); ?>"><?php echo esc_html( $c44_badge[0] ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<span class="product-card__quick"><?php esc_html_e( 'Choose colours & print', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></span>
		</div>
		<div class="product-card__body">
			<?php if ( $c44_meta ) : ?>
				<span class="product-card__meta"><?php echo esc_html( implode( ' | ', $c44_meta ) ); ?></span>
			<?php endif; ?>
			<h3 class="product-card__title"><?php echo esc_html( $product->get_name() ); ?></h3>
			<div class="product-card__foot">
				<div class="product-card__price">
					<span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
					<?php esc_html_e( 'per item', 'custom44' ); ?>
				</div>
				<span class="product-card__go" aria-hidden="true"><?php c44_the_icon( 'arrow' ); ?></span>
			</div>
		</div>
	</a>
</li>
