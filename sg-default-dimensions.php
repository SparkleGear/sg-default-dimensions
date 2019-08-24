<?php
/**
 * Snippet to set default weight and Dimension if it's not set for any product.
 * Created at : 14 May 2018
 * Updated at : 16 May 2018
 * Xadapter Plugins : https://www.xadapter.com/shop/
 * Gist Link : https://gist.github.com/xadapter/4fb8dbfc6c025630558e43488775eb7d
 */

// To set Default Length
add_filter( 'woocommerce_product_get_length', 'xa_product_default_length' );
add_filter( 'woocommerce_product_variation_get_length', 'xa_product_default_length' );	// For variable product variations

if( ! function_exists('xa_product_default_length') ) {
	function xa_product_default_length( $length) {

		$default_length = 9.99 ;			// Provide default Length
		if( empty($length) ) {
			return $default_length;
		}
		else {
			return $length;
		}
	}
}

// To set Default Width
add_filter( 'woocommerce_product_get_width', 'xa_product_default_width');
add_filter( 'woocommerce_product_variation_get_width', 'xa_product_default_width' );	// For variable product variations

if( ! function_exists('xa_product_default_width') ) {
	function xa_product_default_width( $width) {

		$default_width = 9.99;			// Provide default Width
		if( empty($width) ) {
			return $default_width;
		}
		else {
			return $width;
		}
	}
}

// To set Default Height
add_filter( 'woocommerce_product_get_height', 'xa_product_default_height');
add_filter( 'woocommerce_product_variation_get_height', 'xa_product_default_height' );	// For variable product variations

if( ! function_exists('xa_product_default_height')) {
	function xa_product_default_height( $height) {

		$default_height = 1.99;			// Provide default Height
		if( empty($height) ) {
			return $default_height;
		}
		else {
			return $height;
		}
	}
}

// To set Default Weight
add_filter( 'woocommerce_product_get_weight', 'xa_product_default_weight' );
add_filter( 'woocommerce_product_variation_get_weight', 'xa_product_default_weight' );	// For variable product variations

if( ! function_exists('xa_product_default_weight') ) {
	function xa_product_default_weight( $weight) {

		$default_weight = 0.75;			// Provide default Weight
		if( empty($weight) ) {
			return $default_weight;
		}
		else {
			return $weight;
		}
	}
}



add_action('woocommerce_before_checkout_form', 'bbloomer_print_cart_weight');
add_action('woocommerce_before_cart', 'bbloomer_print_cart_weight');

function bbloomer_print_cart_weight( $posted ) {
	global $woocommerce;

	$weight = $woocommerce->cart->get_cart_contents_weight();
	$notice = 'Your cart weight is: ' . number_format($weight, 1) . ' ' . get_option('woocommerce_weight_unit');
	if( is_cart() ) {
		wc_print_notice( $notice, 'notice' );
	} else {
		wc_add_notice( $notice, 'notice' );
	}
}