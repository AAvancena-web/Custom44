<?php
/**
 * Print location guide shown on product pages.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

$c44_spots = apply_filters(
	'c44_print_spots',
	array(
		array( 'chest', __( 'Left or Right Chest', 'custom44' ), __( 'Up to 10cm x 10cm. The classic logo spot for uniforms.', 'custom44' ), __( 'Popular', 'custom44' ) ),
		array( 'back', __( 'Centre Back', 'custom44' ), __( 'Up to 28cm x 30cm. Big, bold branding that gets noticed.', 'custom44' ), __( 'Popular', 'custom44' ) ),
		array( 'sleeve', __( 'Sleeves', 'custom44' ), __( 'Left or right sleeve for a premium finishing detail.', 'custom44' ), '' ),
		array( 'front', __( 'Centre Front & Lower Back', 'custom44' ), __( 'Statement prints, slogans and website or phone details.', 'custom44' ), '' ),
	)
);

/**
 * Tee outline with a highlighted print zone.
 *
 * @param string $spot chest|back|sleeve|front.
 * @return string SVG markup.
 */
$c44_tee = function ( $spot ) {
	$zones = array(
		'chest'  => '<rect class="zone" x="104" y="62" width="22" height="22" rx="3"/>',
		'back'   => '<rect class="zone" x="62" y="58" width="56" height="62" rx="4"/>',
		'sleeve' => '<polygon class="zone" points="32,45 35.2,58.3 27.7,63.9 22.7,52.7"/><polygon class="zone zone--alt" points="148,45 144.8,58.3 152.3,63.9 157.3,52.7"/>',
		'front'  => '<rect class="zone" x="66" y="70" width="48" height="36" rx="4"/><rect class="zone zone--alt" x="70" y="122" width="40" height="14" rx="3"/>',
	);
	$tee = '<path class="tee" d="M62 18 L40 26 L10 52 L26 76 L44 64 L44 150 L136 150 L136 64 L154 76 L170 52 L140 26 L118 18 C112 30 100 34 90 34 C80 34 68 30 62 18 Z"/>';
	$neck = 'back' === $spot ? '<path class="seam" d="M66 20 C76 26 104 26 114 20"/>' : '<path class="seam" d="M62 18 C68 30 80 36 90 36 C100 36 112 30 118 18"/>';
	return '<svg viewBox="0 0 180 160" aria-hidden="true" focusable="false">' . $tee . $neck . $zones[ $spot ] . '</svg>';
};
?>
<section class="section section--dark print-guide" aria-labelledby="print-guide-title">
	<div class="section-head section-head--center reveal">
		<span class="eyebrow"><?php esc_html_e( 'Print locations', 'custom44' ); ?></span>
		<h2 class="h-2" id="print-guide-title"><?php esc_html_e( 'Put your logo where it counts', 'custom44' ); ?></h2>
		<p class="lead"><?php esc_html_e( 'Choose one or more locations when you add this product to your quote.', 'custom44' ); ?></p>
	</div>
	<div class="print-spots">
		<?php foreach ( $c44_spots as $c44_k => $c44_spot ) : ?>
			<div class="print-spot reveal" style="--d:<?php echo esc_attr( $c44_k * 0.08 ); ?>s">
				<div class="print-spot__visual">
					<?php echo $c44_tee( $c44_spot[0] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php if ( $c44_spot[3] ) : ?>
						<span class="print-spot__badge"><?php echo esc_html( $c44_spot[3] ); ?></span>
					<?php endif; ?>
					<span class="print-spot__view"><?php echo 'back' === $c44_spot[0] ? esc_html__( 'Back', 'custom44' ) : esc_html__( 'Front', 'custom44' ); ?></span>
				</div>
				<div class="print-spot__body">
					<span class="print-spot__num">0<?php echo esc_html( $c44_k + 1 ); ?></span>
					<h3><?php echo esc_html( $c44_spot[1] ); ?></h3>
					<p><?php echo esc_html( $c44_spot[2] ); ?></p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="section-cta reveal">
		<a class="btn btn--accent btn--lg" href="#contact"><?php esc_html_e( 'Ask about artwork', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></a>
	</div>
</section>
