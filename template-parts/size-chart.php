<?php
/**
 * Size Chart accordion for the product page.
 *
 * A collapsible "Size Chart" section with a button that opens the chart in a popup.
 * The chart comes from c44_size_chart_content(): the product's "size_chart" custom field,
 * else the default set under Appearance > Customize > Custom 44 Settings > Product Page.
 * Hidden when neither is set.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

$c44_chart = c44_size_chart_content();
if ( '' === $c44_chart ) {
	return;
}
?>
<details class="pdp-acc pdp-size-chart">
	<summary class="pdp-acc__head">
		<span><?php esc_html_e( 'Size Chart', 'custom44' ); ?></span>
		<?php c44_the_icon( 'chevron', 'pdp-acc__chev' ); ?>
	</summary>
	<div class="pdp-acc__body">
		<p><?php esc_html_e( 'Measurements are garment measurements in centimetres. Compare with a well-fitting garment you already own.', 'custom44' ); ?></p>
		<button type="button" class="btn btn--dark btn--sm" data-size-chart-open>
			<?php c44_the_icon( 'ruler' ); ?>
			<span><?php esc_html_e( 'Size Chart', 'custom44' ); ?></span>
		</button>
	</div>
</details>

<dialog class="c44-modal" id="c44-size-chart" aria-labelledby="c44-size-chart-title" data-size-chart>
	<div class="c44-modal__head">
		<h2 id="c44-size-chart-title"><?php esc_html_e( 'Size Chart', 'custom44' ); ?></h2>
		<button type="button" class="c44-modal__close" data-size-chart-close aria-label="<?php esc_attr_e( 'Close size chart', 'custom44' ); ?>"><?php c44_the_icon( 'close' ); ?></button>
	</div>
	<div class="c44-modal__body">
		<?php echo $c44_chart; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built and sanitised in c44_size_chart_content(). ?>
	</div>
</dialog>
