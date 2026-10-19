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
		array( __( 'Left or Right Chest', 'custom44' ), __( 'Max 10cm x 10cm. The classic logo spot.', 'custom44' ), __( 'Popular', 'custom44' ) ),
		array( __( 'Centre Back', 'custom44' ), __( 'Max 28cm x 30cm. Perfect for large branding.', 'custom44' ), __( 'Popular', 'custom44' ) ),
		array( __( 'Sleeves', 'custom44' ), __( 'Left or right sleeve for a premium detail.', 'custom44' ), '' ),
		array( __( 'Centre Front & Lower Back', 'custom44' ), __( 'Bold statement prints and website or phone details.', 'custom44' ), '' ),
	)
);
?>
<section class="section section--dark print-guide" aria-labelledby="print-guide-title" style="border-radius:var(--radius-lg);margin-top:clamp(40px,5vw,80px);padding:clamp(32px,4vw,64px)">
	<div class="section-head section-head--center" style="margin-bottom:36px">
		<div class="section-head__text reveal">
			<span class="eyebrow"><?php esc_html_e( 'Print locations', 'custom44' ); ?></span>
			<h2 class="h-2" id="print-guide-title"><?php esc_html_e( 'Put your logo where it counts', 'custom44' ); ?></h2>
		</div>
	</div>
	<div class="print-spots">
		<?php foreach ( $c44_spots as $c44_k => $c44_spot ) : ?>
			<div class="print-spot reveal" style="--d:<?php echo esc_attr( $c44_k * 0.08 ); ?>s">
				<b><?php echo esc_html( $c44_spot[0] ); ?></b>
				<span><?php echo esc_html( $c44_spot[1] ); ?></span>
				<?php if ( $c44_spot[2] ) : ?>
					<br><em><?php echo esc_html( $c44_spot[2] ); ?></em>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="section-cta reveal">
		<a class="btn btn--accent btn--lg" href="#contact"><?php esc_html_e( 'Ask about artwork', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></a>
	</div>
</section>
