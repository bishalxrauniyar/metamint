<?php
/**
 * WooCommerce wiring: buy buttons go straight to checkout once products exist.
 *
 * Create two Simple Products with SKUs "metamint-helpdesk" and "metamint-seo" (or matching
 * slugs) and every buy button on the site switches from the placeholder marketplace URL to
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
	$pid = (int) wc_get_product_id_by_sku( 'metamint-' . $key );
	if ( $pid ) {
		return $pid;
	}
	$post = get_page_by_path( 'metamint-' . $key, OBJECT, 'product' );
	return $post ? (int) $post->ID : 0;
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

/**
 * Price pair (discounted + actual) for the first pricing plan.
 * Returns [ 'actual' => wc_price, 'discounted' => wc_price, 'save' => int|false ].
 */
function mm_price_pair( string $key, int $fallback ): array {
	$pid = mm_wc_product_id( $key );
	if ( $pid ) {
		$product = wc_get_product( $pid );
		if ( $product && $product->get_price() !== '' ) {
			$sale    = $product->get_sale_price();
			$regular = $product->get_regular_price();
			$fmt     = static fn( $v ) => wc_price( $v, [ 'price_format' => '%1$s%2$s' ] );
			$actual  = $regular !== '' ? $fmt( $regular ) : $fmt( $product->get_price() );
			$disc    = $sale !== '' ? $fmt( $sale ) : $fmt( $product->get_price() );
			$save    = false;
			if ( $regular !== '' && $sale !== '' && (float) $regular > 0 ) {
				$save = (int) round( ( 1 - (float) $sale / (float) $regular ) * 100 );
			}
			return [ 'actual' => $actual, 'discounted' => $disc, 'save' => $save ];
		}
	}
	return [ 'actual' => '$' . $fallback, 'discounted' => '', 'save' => false ];
}
