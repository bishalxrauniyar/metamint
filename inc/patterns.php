<?php
/**
 * Block patterns for the editor (Block Editor preference).
 *
 * @package metamint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	register_block_pattern_category( 'metamint', [ 'label' => __( 'Metamint', 'metamint' ) ] );

	register_block_pattern( 'metamint/hero-centered', [
		'title'   => __( 'Hero — Centered with pill badge', 'metamint' ),
		'categories' => [ 'metamint' ],
		'content' => '
<!-- wp:group {"align":"wide","className":"mm-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide mm-hero">
	<!-- wp:paragraph {"align":"center","className":"mm-pill mm-pill-teal"} -->
	<p class="has-text-align-center mm-pill mm-pill-teal">Indie software studio — est. 2024</p>
	<!-- /wp:paragraph -->
	<!-- wp:heading {"textAlign":"center","level":1,"fontSize":"display"} -->
	<h1 class="wp-block-heading has-text-align-center has-display-font-size">Plugins with punch. Software with soul.</h1>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center","textColor":"muted"} -->
	<p class="has-text-align-center has-muted-color has-text-color">A tiny studio crafting mighty tools for WordPress and Shopify.</p>
	<!-- /wp:paragraph -->
	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"ink","textColor":"canvas","className":"is-style-fill"} -->
		<div class="wp-block-button is-style-fill"><a class="wp-block-button__link has-canvas-color has-ink-background-color has-text-color has-background wp-element-button">Meet the apps</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
	] );

	register_block_pattern( 'metamint/cta-dark', [
		'title'   => __( 'CTA — Dark panel', 'metamint' ),
		'categories' => [ 'metamint' ],
		'content' => '
<!-- wp:group {"align":"wide","className":"mm-cta-dark","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide mm-cta-dark">
	<!-- wp:heading {"textAlign":"center","textColor":"canvas","fontSize":"x-large"} -->
	<h2 class="wp-block-heading has-text-align-center has-canvas-color has-text-color has-x-large-font-size">Ready to mint something great?</h2>
	<!-- /wp:heading -->
	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"canvas","textColor":"ink"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-ink-color has-canvas-background-color has-text-color has-background wp-element-button">Talk to us</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
	] );

	register_block_pattern( 'metamint/stats-band', [
		'title'   => __( 'Stats band — 4 columns', 'metamint' ),
		'categories' => [ 'metamint' ],
		'content' => '
<!-- wp:columns {"align":"wide","className":"mm-stats"} -->
<div class="wp-block-columns alignwide mm-stats">
	<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"textAlign":"center","fontSize":"x-large"} --><h2 class="wp-block-heading has-text-align-center has-x-large-font-size">2</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center","textColor":"muted","fontSize":"small"} --><p class="has-text-align-center has-muted-color has-text-color has-small-font-size">Products, crafted slowly</p><!-- /wp:paragraph --></div><!-- /wp:column -->
	<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"textAlign":"center","fontSize":"x-large"} --><h2 class="wp-block-heading has-text-align-center has-x-large-font-size">1,200+</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center","textColor":"muted","fontSize":"small"} --><p class="has-text-align-center has-muted-color has-text-color has-small-font-size">Stores &amp; sites powered</p><!-- /wp:paragraph --></div><!-- /wp:column -->
	<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"textAlign":"center","fontSize":"x-large"} --><h2 class="wp-block-heading has-text-align-center has-x-large-font-size">4.9 / 5</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center","textColor":"muted","fontSize":"small"} --><p class="has-text-align-center has-muted-color has-text-color has-small-font-size">Average rating</p><!-- /wp:paragraph --></div><!-- /wp:column -->
	<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"textAlign":"center","fontSize":"x-large"} --><h2 class="wp-block-heading has-text-align-center has-x-large-font-size">&lt; 1 day</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center","textColor":"muted","fontSize":"small"} --><p class="has-text-align-center has-muted-color has-text-color has-small-font-size">Median support reply</p><!-- /wp:paragraph --></div><!-- /wp:column -->
</div>
<!-- /wp:columns -->',
	] );
} );
