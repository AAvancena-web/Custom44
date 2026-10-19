<?php
/**
 * Process timeline (How it works). Expects $c44_steps: array of [ icon, title, text ].
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $c44_steps ) ) {
	return;
}
?>
<div class="process" data-observe style="--n:<?php echo esc_attr( count( $c44_steps ) ); ?>">
	<div class="process__track" aria-hidden="true"><span class="process__fill"></span></div>
	<?php foreach ( $c44_steps as $c44_k => $c44_step ) : ?>
		<div class="process__step reveal" style="--d:<?php echo esc_attr( $c44_k * 0.1 ); ?>s">
			<div class="process__node process__node--<?php echo esc_attr( $c44_k ); ?>">
				<span class="process__icon"><?php c44_the_icon( $c44_step[0] ); ?></span>
			</div>
			<div class="process__body">
				<span class="process__num" aria-hidden="true">0<?php echo esc_html( $c44_k + 1 ); ?></span>
				<span class="process__label"><?php echo esc_html( sprintf( __( 'Step %d', 'custom44' ), $c44_k + 1 ) ); ?></span>
				<h3><?php echo esc_html( $c44_step[1] ); ?></h3>
				<p><?php echo esc_html( $c44_step[2] ); ?></p>
			</div>
		</div>
	<?php endforeach; ?>
</div>
