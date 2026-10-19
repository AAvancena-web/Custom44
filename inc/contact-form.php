<?php
/**
 * Built-in enquiry form handler (used when no form plugin shortcode is set).
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

/**
 * Handle form submission.
 */
function c44_handle_enquiry() {
	$redirect = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$redirect = remove_query_arg( 'enquiry', $redirect );

	if ( ! isset( $_POST['c44_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['c44_nonce'] ) ), 'c44_enquiry' ) ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'error', $redirect ) . '#contact' );
		exit;
	}

	// Honeypot: bots fill hidden fields.
	if ( ! empty( $_POST['c44_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'sent', $redirect ) . '#contact' );
		exit;
	}

	$name     = isset( $_POST['c44_name'] ) ? sanitize_text_field( wp_unslash( $_POST['c44_name'] ) ) : '';
	$email    = isset( $_POST['c44_email'] ) ? sanitize_email( wp_unslash( $_POST['c44_email'] ) ) : '';
	$phone    = isset( $_POST['c44_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['c44_phone'] ) ) : '';
	$company  = isset( $_POST['c44_company'] ) ? sanitize_text_field( wp_unslash( $_POST['c44_company'] ) ) : '';
	$interest = isset( $_POST['c44_interest'] ) ? sanitize_text_field( wp_unslash( $_POST['c44_interest'] ) ) : '';
	$qty      = isset( $_POST['c44_qty'] ) ? sanitize_text_field( wp_unslash( $_POST['c44_qty'] ) ) : '';
	$message  = isset( $_POST['c44_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['c44_message'] ) ) : '';
	$page     = isset( $_POST['c44_page'] ) ? esc_url_raw( wp_unslash( $_POST['c44_page'] ) ) : '';

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'invalid', $redirect ) . '#contact' );
		exit;
	}

	$to = c44_opt( 'form_to' ) ? c44_opt( 'form_to' ) : c44_opt( 'email' );
	if ( ! is_email( $to ) ) {
		$to = get_option( 'admin_email' );
	}

	$subject = sprintf( 'New website enquiry from %s', $name );
	$body    = "Name: {$name}\nCompany: {$company}\nEmail: {$email}\nPhone: {$phone}\nInterested in: {$interest}\nEstimated quantity: {$qty}\nPage: {$page}\n\nMessage:\n{$message}\n";
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, $subject, $body, $headers );

	do_action( 'c44_enquiry_submitted', compact( 'name', 'email', 'phone', 'company', 'interest', 'qty', 'message', 'page' ), $sent );

	wp_safe_redirect( add_query_arg( 'enquiry', $sent ? 'sent' : 'error', $redirect ) . '#contact' );
	exit;
}
add_action( 'admin_post_nopriv_c44_enquiry', 'c44_handle_enquiry' );
add_action( 'admin_post_c44_enquiry', 'c44_handle_enquiry' );
