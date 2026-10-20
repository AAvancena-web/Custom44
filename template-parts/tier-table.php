<?php
/**
 * "Buy more, save more" tier box for the product page.
 * Highlights the active tier and shows "Add N more to unlock X% off" as quantities change
 * (see the product page section of assets/js/main.js).
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

$c44_tiers_list = c44_tiers();
$c44_first      = reset( $c44_tiers_list );
?>
<div class="pdp-tiers" data-tiers>
	<div class="pdp-tiers__head">
		<strong><?php esc_html_e( 'Buy more, save more', 'custom44' ); ?></strong>
		<span><?php esc_html_e( 'Mix sizes and colours to reach a tier', 'custom44' ); ?></span>
	</div>
	<div class="pdp-tiers__grid">
		<?php foreach ( $c44_tiers_list as $c44_tier ) : ?>
			<div class="pdp-tiers__cell" data-min="<?php echo esc_attr( $c44_tier['qty'] ); ?>" data-off="<?php echo esc_attr( $c44_tier['off'] ); ?>">
				<small><?php echo esc_html( $c44_tier['qty'] ); ?>+</small>
				<b><?php echo esc_html( $c44_tier['off'] ); ?>%</b>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="pdp-tiers__bar" aria-hidden="true"><span data-tiers-bar></span></div>
	<p class="pdp-tiers__msg" data-tiers-msg aria-live="polite">
		<?php
		/* translators: 1: quantity 2: discount percent */
		echo wp_kses_post( sprintf( __( 'Add <b>%1$d items</b> to unlock <b>%2$d%% off</b>', 'custom44' ), $c44_first['qty'], $c44_first['off'] ) );
		?>
	</p>
</div>
