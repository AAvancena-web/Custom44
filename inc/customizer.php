<?php
/**
 * Customizer settings: Appearance > Customize > Custom 44 Settings.
 *
 * @package Custom44
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register settings.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function c44_customize_register( $wp_customize ) {
	$wp_customize->add_panel( 'c44_panel', array( 'title' => __( 'Custom 44 Settings', 'custom44' ), 'priority' => 30 ) );

	$sections = array(
		'c44_contact' => __( 'Contact Details & Map', 'custom44' ),
		'c44_home'    => __( 'Homepage Banner', 'custom44' ),
		'c44_social'  => __( 'Social & Reviews', 'custom44' ),
		'c44_forms'   => __( 'Contact Form', 'custom44' ),
		'c44_work'    => __( 'Recent Work Photos', 'custom44' ),
		'c44_product' => __( 'Product Page', 'custom44' ),
	);
	foreach ( $sections as $id => $title ) {
		$wp_customize->add_section( $id, array( 'title' => $title, 'panel' => 'c44_panel' ) );
	}

	$fields = array(
		// key, section, label, type.
		array( 'announcement', 'c44_home', __( 'Top bar announcement (HTML allowed)', 'custom44' ), 'textarea' ),
		array( 'hero_title', 'c44_home', __( 'Banner title (HTML allowed)', 'custom44' ), 'textarea' ),
		array( 'hero_text', 'c44_home', __( 'Banner text', 'custom44' ), 'textarea' ),
		array( 'hero_image', 'c44_home', __( 'Banner main image URL', 'custom44' ), 'url' ),
		array( 'hero_image_2', 'c44_home', __( 'Banner secondary image URL', 'custom44' ), 'url' ),
		array( 'orders', 'c44_home', __( 'Orders shipped (number)', 'custom44' ), 'text' ),
		array( 'rating', 'c44_home', __( 'Google rating (e.g. 4.7)', 'custom44' ), 'text' ),
		array( 'review_count', 'c44_home', __( 'Google review count', 'custom44' ), 'text' ),
		array( 'phone', 'c44_contact', __( 'Phone', 'custom44' ), 'text' ),
		array( 'email', 'c44_contact', __( 'Email', 'custom44' ), 'email' ),
		array( 'location', 'c44_contact', __( 'Location', 'custom44' ), 'text' ),
		array( 'service_area', 'c44_contact', __( 'Service area', 'custom44' ), 'text' ),
		array( 'hours', 'c44_contact', __( 'Opening hours (leave empty to hide)', 'custom44' ), 'text' ),
		array( 'map_query', 'c44_contact', __( 'Google Map search query or address', 'custom44' ), 'text' ),
		array( 'map_cid', 'c44_contact', __( 'Google Business Profile CID (pins the exact listing, overrides the query)', 'custom44' ), 'text' ),
		array( 'map_link', 'c44_contact', __( 'Google Maps link (directions)', 'custom44' ), 'url' ),
		array( 'facebook', 'c44_social', __( 'Facebook URL', 'custom44' ), 'url' ),
		array( 'instagram', 'c44_social', __( 'Instagram URL', 'custom44' ), 'url' ),
		array( 'google_reviews', 'c44_social', __( 'Google reviews URL', 'custom44' ), 'url' ),
		array( 'ig_token', 'c44_social', __( 'Instagram access token (long-lived, for the live feed; refreshed automatically)', 'custom44' ), 'text' ),
		array( 'feed_code', 'c44_social', __( 'Or an Instagram feed plugin shortcode, e.g. Smash Balloon (replaces the gallery photos)', 'custom44' ), 'textarea' ),
		array( 'reviews_code', 'c44_social', __( 'Reviews widget shortcode (optional)', 'custom44' ), 'textarea' ),
		array( 'form_code', 'c44_forms', __( 'Form plugin shortcode (optional, replaces built-in form)', 'custom44' ), 'textarea' ),
		array( 'size_chart', 'c44_product', __( 'Default size chart: image URL, size chart plugin shortcode or HTML table (a product\'s "size_chart" custom field overrides it; leave empty to hide)', 'custom44' ), 'textarea' ),
		array( 'form_to', 'c44_forms', __( 'Send enquiries to (defaults to contact email)', 'custom44' ), 'email' ),
	);

	for ( $i = 1; $i <= 8; $i++ ) {
		/* translators: %d: photo number */
		$fields[] = array( 'work_' . $i, 'c44_work', sprintf( __( 'Photo %d', 'custom44' ), $i ), 'url' );
		/* translators: %d: photo number */
		$fields[] = array( 'work_' . $i . '_alt', 'c44_work', sprintf( __( 'Photo %d description (alt text)', 'custom44' ), $i ), 'text' );
	}

	$defaults = c44_defaults();
	foreach ( $fields as $f ) {
		list( $key, $section, $label, $type ) = $f;
		$sanitize = 'sanitize_text_field';
		if ( 'url' === $type ) {
			$sanitize = 'esc_url_raw';
		} elseif ( 'email' === $type ) {
			$sanitize = 'sanitize_email';
		} elseif ( 'textarea' === $type ) {
			$sanitize = 'wp_kses_post';
		}
		$wp_customize->add_setting(
			'c44_' . $key,
			array(
				'default'           => isset( $defaults[ $key ] ) ? $defaults[ $key ] : '',
				'sanitize_callback' => $sanitize,
			)
		);
		if ( preg_match( '/^work_\d+$/', $key ) && class_exists( 'WP_Customize_Image_Control' ) ) {
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'c44_' . $key, array( 'label' => $label, 'section' => $section ) ) );
			continue;
		}
		$wp_customize->add_control(
			'c44_' . $key,
			array(
				'label'   => $label,
				'section' => $section,
				'type'    => 'url' === $type ? 'text' : $type,
			)
		);
	}
}
add_action( 'customize_register', 'c44_customize_register' );
