<?php
/**
 * WooCommerce wiring: buy buttons go straight to checkout once products exist.
 *
 * Create two Simple Products with SKUs "metamint-helpdesk" and "metamint-seo" and every
 * buy button on the site switches from the placeholder marketplace URL to
 * checkout?add-to-cart=<id>. An SCF "Marketplace URL" value always wins.
 *
 * @package metamint
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mm_wc_product_id( string $key ): int {
	if ( ! function_exists( 'wc_get_product_id_by_sku' ) ) {
		return 0;
	}
	return (int) wc_get_product_id_by_sku( 'metamint-' . $key );
}

/**
 * Resolve the buy URL for a product: SCF override → WooCommerce straight-to-checkout → fallback.
 */
function mm_buy_url( string $key, string $fallback ): string {
	$custom = function_exists( 'get_field' ) ? (string) get_field( 'buy_url' ) : '';
	if ( $custom !== '' ) {
		return $custom;
	}
	$pid = mm_wc_product_id( $key );
	if ( $pid ) {
		return add_query_arg( 'add-to-cart', $pid, wc_get_checkout_url() );
	}
	return $fallback;
}

/**
 * Live price from WooCommerce when available (used on pricing cards), else the SCF/default price.
 */
function mm_price( string $key, int $fallback ): string {
	$pid = mm_wc_product_id( $key );
	if ( $pid ) {
		$product = wc_get_product( $pid );
		if ( $product && $product->get_price() !== '' ) {
			return wc_price( $product->get_price(), [ 'price_format' => '%1$s%2$s' ] );
		}
	}
	return '$' . $fallback;
}
