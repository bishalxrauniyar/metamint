<?php
/**
 * Metamint Apps theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'METAMINT_VERSION', '1.0.0' );
define( 'METAMINT_DIR', get_template_directory() );
define( 'METAMINT_URI', get_template_directory_uri() );

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
	add_theme_support( 'woocommerce' );
	add_editor_style( 'assets/css/main.css' );

	register_nav_menus( [
		'primary' => __( 'Primary Menu', 'metamint' ),
		'footer'  => __( 'Footer Menu', 'metamint' ),
	] );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'metamint-fonts',
		'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Instrument+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;600&display=swap',
		[],
		null
	);
	wp_enqueue_style( 'metamint-main', METAMINT_URI . '/assets/css/main.css', [ 'metamint-fonts' ], METAMINT_VERSION );
	wp_enqueue_script( 'metamint-main', METAMINT_URI . '/assets/js/main.js', [], METAMINT_VERSION, true );
} );

add_action( 'enqueue_block_editor_assets', function () {
	wp_enqueue_style(
		'metamint-editor-fonts',
		'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Instrument+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;600&display=swap',
		[],
		null
	);

	wp_enqueue_script(
		'metamint-blocks-editor',
		METAMINT_URI . '/assets/js/blocks-editor.js',
		[ 'wp-blocks', 'wp-element', 'wp-server-side-render' ],
		METAMINT_VERSION,
		true
	);
} );

require_once METAMINT_DIR . '/inc/cpt.php';
require_once METAMINT_DIR . '/inc/scf-fields.php';
require_once METAMINT_DIR . '/inc/contact-handler.php';
require_once METAMINT_DIR . '/inc/patterns.php';
require_once METAMINT_DIR . '/inc/woocommerce.php';
require_once METAMINT_DIR . '/inc/blocks-home.php';
require_once METAMINT_DIR . '/inc/blocks-product.php';
require_once METAMINT_DIR . '/inc/blocks-pages.php';

/**
 * Small SCF-safe getter: uses SCF/ACF when active, otherwise returns the fallback.
 */
function mm_field( string $key, $fallback = '', $post_id = false ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $key, $post_id );
		if ( $value !== null && $value !== '' && $value !== [] ) {
			return $value;
		}
	}
	return $fallback;
}
