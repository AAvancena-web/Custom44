<?php
/**
 * Global contact section: contact info, Google Map and enquiry form. Sits just above the footer.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

$c44_status = isset( $_GET['enquiry'] ) ? sanitize_key( wp_unslash( $_GET['enquiry'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$c44_map    = 'https://maps.google.com/maps?q=' . rawurlencode( c44_opt( 'map_query' ) ) . '&z=11&output=embed';
$c44_url    = ( is_ssl() ? 'https://' : 'http://' ) . ( isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '' ) . ( isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '' );
?>
<section class="contact section is-dark" id="contact" aria-labelledby="contact-title">
	<div class="container">
		<div class="section-head section-head--center reveal">
			<span class="eyebrow"><?php esc_html_e( 'Get in touch', 'custom44' ); ?></span>
			<h2 class="h-1" id="contact-title"><?php echo wp_kses_post( __( "Let's get your team <span class=\"hl\">looking sharp.</span>", 'custom44' ) ); ?></h2>
			<p class="lead"><?php esc_html_e( 'Tell us what you need and we will come back with pricing, mock-ups and a turnaround that suits you. Prefer to talk? Give us a call.', 'custom44' ); ?></p>
		</div>
	<div class="contact__grid">
		<div class="contact__info">

			<ul class="contact-list reveal" style="--d:.1s">
				<li>
					<a href="<?php echo esc_attr( c44_tel() ); ?>">
						<span class="contact-list__icon"><?php c44_the_icon( 'phone' ); ?></span>
						<span><small><?php esc_html_e( 'Call', 'custom44' ); ?></small><strong><?php echo esc_html( c44_opt( 'phone' ) ); ?></strong></span>
					</a>
				</li>
				<li>
					<a href="mailto:<?php echo esc_attr( c44_opt( 'email' ) ); ?>">
						<span class="contact-list__icon"><?php c44_the_icon( 'mail' ); ?></span>
						<span><small><?php esc_html_e( 'Email', 'custom44' ); ?></small><strong><?php echo esc_html( c44_opt( 'email' ) ); ?></strong></span>
					</a>
				</li>
				<li>
					<a href="<?php echo esc_url( c44_opt( 'map_link' ) ); ?>" target="_blank" rel="noopener">
						<span class="contact-list__icon"><?php c44_the_icon( 'pin' ); ?></span>
						<span><small><?php esc_html_e( 'Location', 'custom44' ); ?></small><strong><?php echo esc_html( c44_opt( 'location' ) ); ?></strong></span>
					</a>
				</li>
				<li>
					<?php if ( c44_opt( 'hours' ) ) : ?>
						<span class="contact-item">
							<span class="contact-list__icon"><?php c44_the_icon( 'clock' ); ?></span>
							<span><small><?php esc_html_e( 'Hours', 'custom44' ); ?></small><strong><?php echo esc_html( c44_opt( 'hours' ) ); ?></strong></span>
						</span>
					<?php else : ?>
						<span class="contact-item">
							<span class="contact-list__icon"><?php c44_the_icon( 'truck' ); ?></span>
							<span><small><?php esc_html_e( 'Delivery', 'custom44' ); ?></small><strong><?php echo esc_html( c44_opt( 'service_area' ) ); ?></strong></span>
						</span>
					<?php endif; ?>
				</li>
			</ul>

			<div class="contact-map reveal reveal--scale" style="--d:.15s">
				<iframe src="<?php echo esc_url( $c44_map ); ?>" title="<?php esc_attr_e( 'Custom 44 location on Google Maps', 'custom44' ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
				<a class="contact-map__pin" href="<?php echo esc_url( c44_opt( 'map_link' ) ); ?>" target="_blank" rel="noopener"><?php c44_the_icon( 'pin' ); ?><?php esc_html_e( 'Get directions', 'custom44' ); ?></a>
			</div>
		</div>

		<div class="contact-form reveal reveal--right" style="--d:.1s">
			<h3><?php esc_html_e( 'Request a free quote', 'custom44' ); ?></h3>
			<p><?php esc_html_e( 'Most quotes are answered within one business day.', 'custom44' ); ?></p>

			<?php if ( c44_opt( 'form_code' ) ) : ?>
				<?php echo do_shortcode( wp_kses_post( c44_opt( 'form_code' ) ) ); ?>
			<?php else : ?>
				<?php if ( 'sent' === $c44_status ) : ?>
					<div class="form-notice form-notice--ok" role="status"><?php esc_html_e( 'Thanks, your enquiry is in. We will be in touch shortly.', 'custom44' ); ?></div>
				<?php elseif ( 'invalid' === $c44_status ) : ?>
					<div class="form-notice form-notice--err" role="alert"><?php esc_html_e( 'Please add your name, a valid email and a message.', 'custom44' ); ?></div>
				<?php elseif ( 'error' === $c44_status ) : ?>
					<div class="form-notice form-notice--err" role="alert"><?php esc_html_e( 'Something went wrong sending your enquiry. Please call or email us directly.', 'custom44' ); ?></div>
				<?php endif; ?>

				<form class="enquiry-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="c44_enquiry">
					<input type="hidden" name="c44_page" value="<?php echo esc_attr( $c44_url ); ?>">
					<?php wp_nonce_field( 'c44_enquiry', 'c44_nonce' ); ?>
					<div class="form-hp" aria-hidden="true"><label>Website<input type="text" name="c44_website" tabindex="-1" autocomplete="off"></label></div>

					<div class="form-grid">
						<div class="form-field">
							<label for="c44_name"><?php esc_html_e( 'Full name', 'custom44' ); ?> <span class="req">*</span></label>
							<input id="c44_name" name="c44_name" type="text" autocomplete="name" placeholder="<?php esc_attr_e( 'e.g. Jane Smith', 'custom44' ); ?>" required>
						</div>
						<div class="form-field">
							<label for="c44_company"><?php esc_html_e( 'Business / team', 'custom44' ); ?></label>
							<input id="c44_company" name="c44_company" type="text" autocomplete="organization" placeholder="<?php esc_attr_e( 'e.g. Smith Plumbing', 'custom44' ); ?>">
						</div>
						<div class="form-field">
							<label for="c44_email"><?php esc_html_e( 'Email', 'custom44' ); ?> <span class="req">*</span></label>
							<input id="c44_email" name="c44_email" type="email" autocomplete="email" placeholder="<?php esc_attr_e( 'you@company.com.au', 'custom44' ); ?>" required>
						</div>
						<div class="form-field">
							<label for="c44_phone"><?php esc_html_e( 'Phone', 'custom44' ); ?></label>
							<input id="c44_phone" name="c44_phone" type="tel" autocomplete="tel" placeholder="<?php esc_attr_e( '04XX XXX XXX', 'custom44' ); ?>">
						</div>
						<div class="form-field">
							<label for="c44_interest"><?php esc_html_e( 'I am interested in', 'custom44' ); ?></label>
							<select id="c44_interest" name="c44_interest">
								<option><?php esc_html_e( 'Hi-vis workwear', 'custom44' ); ?></option>
								<option><?php esc_html_e( 'T-shirts & polos', 'custom44' ); ?></option>
								<option><?php esc_html_e( 'Hoodies & jumpers', 'custom44' ); ?></option>
								<option><?php esc_html_e( 'Jackets & vests', 'custom44' ); ?></option>
								<option><?php esc_html_e( 'Headwear', 'custom44' ); ?></option>
								<option><?php esc_html_e( 'Full uniform fit-out', 'custom44' ); ?></option>
								<option><?php esc_html_e( 'Logo design', 'custom44' ); ?></option>
							</select>
						</div>
						<div class="form-field">
							<label for="c44_qty"><?php esc_html_e( 'Estimated quantity', 'custom44' ); ?></label>
							<select id="c44_qty" name="c44_qty">
								<option>1 to 4</option>
								<option>5 to 9 (15% off)</option>
								<option>10 to 19 (20% off)</option>
								<option>20 to 49 (25% off)</option>
								<option>50 to 99 (30% off)</option>
								<option>100+ (35% off)</option>
							</select>
						</div>
						<div class="form-field form-field--full">
							<label for="c44_message"><?php esc_html_e( 'Tell us about your order', 'custom44' ); ?> <span class="req">*</span></label>
							<textarea id="c44_message" name="c44_message" required placeholder="<?php esc_attr_e( 'Garments, colours, print locations, deadline...', 'custom44' ); ?>"></textarea>
						</div>
					</div>
					<div class="form-foot">
						<small><?php c44_the_icon( 'lock' ); ?><?php esc_html_e( 'Your details stay private. No spam.', 'custom44' ); ?></small>
						<button class="btn btn--dark btn--lg" type="submit"><?php esc_html_e( 'Send my enquiry', 'custom44' ); ?><?php c44_the_icon( 'arrow' ); ?></button>
					</div>
				</form>
			<?php endif; ?>
		</div>
	</div>
	</div>
</section>
