<?php
/**
 * Bulk discount tier table for the product page.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="pdp-tiers" data-tiers>
	<div class="pdp-tiers__head">
		<strong><?php c44_the_icon( 'percent' ); ?><?php esc_html_e( 'Bulk savings', 'custom44' ); ?></strong>
		<span><?php esc_html_e( 'Applied automatically from 5 items', 'custom44' ); ?></span>
	</div>
	<div class="pdp-tiers__grid">
		<?php foreach ( c44_tiers() as $c44_tier ) : ?>
			<div class="pdp-tiers__cell" data-min="<?php echo esc_attr( $c44_tier['qty'] ); ?>">
				<b><?php echo esc_html( $c44_tier['off'] ); ?>%</b>
				<small><?php echo esc_html( $c44_tier['qty'] ); ?>+ <?php esc_html_e( 'items', 'custom44' ); ?></small>
			</div>
		<?php endforeach; ?>
	</div>
</div>
