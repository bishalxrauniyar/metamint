<?php
/**
 * Contact form handler (admin-post). Stores a contact_message CPT entry and emails the site admin.
 *
 * @package metamint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mm_handle_contact(): void {
	$back = wp_get_referer() ?: home_url( '/contact/' );

	if ( ! isset( $_POST['mm_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mm_contact_nonce'] ) ), 'mm_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'error', $back ) );
		exit;
	}

	// Honeypot: bots fill this, humans never see it.
	if ( ! empty( $_POST['mm_company'] ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'ok', $back ) );
		exit;
	}

	$name     = isset( $_POST['mm_name'] ) ? sanitize_text_field( wp_unslash( $_POST['mm_name'] ) ) : '';
	$email    = isset( $_POST['mm_email'] ) ? sanitize_email( wp_unslash( $_POST['mm_email'] ) ) : '';
	$interest = isset( $_POST['mm_interest'] ) ? sanitize_text_field( wp_unslash( $_POST['mm_interest'] ) ) : '';
	$message  = isset( $_POST['mm_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mm_message'] ) ) : '';

	if ( $name === '' || ! is_email( $email ) || $message === '' ) {
		wp_safe_redirect( add_query_arg( 'sent', 'invalid', $back ) );
		exit;
	}

	$post_id = wp_insert_post( [
		'post_type'    => 'contact_message',
		'post_status'  => 'publish',
		'post_title'   => sprintf( '%s — %s (%s)', $name, $interest, $email ),
		'post_content' => $message,
	] );

	if ( ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, 'email', $email );
		update_post_meta( $post_id, 'product_interest', $interest );
		wp_mail(
			get_option( 'admin_email' ),
			sprintf( '[Metamint] New message from %s', $name ),
			"Product: {$interest}\nEmail: {$email}\n\n{$message}"
		);
	}

	wp_safe_redirect( add_query_arg( 'sent', 'ok', $back . '#contact-form' ) );
	exit;
}
add_action( 'admin_post_mm_contact', 'mm_handle_contact' );
add_action( 'admin_post_nopriv_mm_contact', 'mm_handle_contact' );
