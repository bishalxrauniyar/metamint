<?php
/**
 * Custom post types: Journal entries + Contact messages.
 *
 * @package metamint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	register_post_type( 'journal_entry', [
		'labels' => [
			'name'          => __( 'Journal Entries', 'metamint' ),
			'singular_name' => __( 'Journal Entry', 'metamint' ),
		],
		'public'        => true,
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-megaphone',
		'show_in_rest'  => true,
		'supports'      => [ 'title', 'editor', 'revisions' ],
		'rewrite'       => [ 'slug' => 'journal' ],
	] );

	register_post_type( 'contact_message', [
		'labels' => [
			'name'          => __( 'Contact Messages', 'metamint' ),
			'singular_name' => __( 'Contact Message', 'metamint' ),
		],
		'public'        => false,
		'show_ui'       => true,
		'menu_icon'     => 'dashicons-email-alt',
		'supports'      => [ 'title', 'editor' ],
		'capabilities'  => [ 'create_posts' => 'do_not_allow' ],
		'map_meta_cap'  => true,
	] );
} );
