<?php
/**
 * Snippet to set default weight and Dimension if it's not set for any product.
 * Created at : 14 May 2018
 * Updated at : 16 May 2018
 * Xadapter Plugins : https://www.xadapter.com/shop/
 * Gist Link : https://gist.github.com/xadapter/4fb8dbfc6c025630558e43488775eb7d
 */

// To set Default Length
add_filter( 'woocommerce_product_get_length', 'xa_product_default_length',10,2 );
add_filter( 'woocommerce_product_variation_get_length', 'xa_product_default_length',10,2 );    // For variable product variations

if ( ! function_exists( 'xa_product_default_length' ) ) {
	function xa_product_default_length( $length, $wc_product_thing ) {

		if ( sg_is_a_design( $wc_product_thing->get_id() ) ) {
			$sg_design = new SG_Design_Product( $wc_product_thing->get_id() );
			if ( $design_height = $sg_design->get_design_height() ) {
				$height = $design_height + 3;
			}
		}

		if ( empty( $height ) ) {
			$sg_default_height = get_option( 'sg_default_height', 10 );
			$height            = $sg_default_height;
		}

		return $height; // inches
	}
}

// To set Default Width
add_filter( 'woocommerce_product_get_width', 'xa_product_default_width', 10,2 );
add_filter( 'woocommerce_product_variation_get_width', 'xa_product_default_width',10,2 );    // For variable product variations

if ( ! function_exists( 'xa_product_default_width' ) ) {
	function xa_product_default_width( $width, $wc_product_thing ) {
		if ( sg_is_a_design( $wc_product_thing->get_id() ) ) {
			$sg_design = new SG_Design_Product( $wc_product_thing->get_id() );
			if ( $design_width = $sg_design->get_design_width() ) {
				$width = $design_width + 3;
			}
		}

		if ( empty( $width ) ) {
			$sg_default_width = get_option( 'sg_default_width', 10 );
			$width            = $sg_default_width;
		}

		return $width; // inches
	}
}

// To set Default Height
add_filter( 'woocommerce_product_get_height', 'xa_product_default_height',10,2 );
add_filter( 'woocommerce_product_variation_get_height', 'xa_product_default_height',10,2 );    // For variable product variations

if ( ! function_exists( 'xa_product_default_height' ) ) {
	function xa_product_default_height( $height, $wc_product_thing ) {

		if ( empty( $height ) ) {
			$sg_default_height = get_option( 'sg_default_height', .125 );
			$height            = $sg_default_height;
		}

		return $height; // inches
	}
}


// To set Default Weight
add_filter( 'woocommerce_product_get_weight', 'xa_product_default_weight', 10, 2 );
add_filter( 'woocommerce_product_variation_get_weight', 'xa_product_default_weight', 10, 2 );    // For variable product variations

if ( ! function_exists( 'xa_product_default_weight' ) ) {
	/**
	 * @param float $weight
	 * @param WC_Product $wc_product_thing
	 *
	 * @return float
	 */
	function xa_product_default_weight( $weight, $wc_product_thing ) {
		if ( sg_is_a_design( $wc_product_thing->get_id() ) ) {
			$sg_design = new SG_Design_Product( $wc_product_thing->get_id() );
			if ( $gem_count = $sg_design->get_bling_rhinestone_count() ) {

				// 0.03 lbs per 1000 rhinestones
				$sg_rhinestone_weight_per_1000 = get_option( 'sg_rhinestone_weight_per_1000', 0.03 );

				// 0.16 lbs per 16 inch x 16 inch transfer sheet
				$sg_rhinestone_carrier_weight = get_option( 'sg_rhinestone_carrier_weight', 0.1 );

				// weight in pounds
				$weight = $sg_rhinestone_carrier_weight + $gem_count * $sg_rhinestone_weight_per_1000 / 1000;

				// round this up to the nearest ounce
				$ounces = $weight * 16;
				$ounces = ceil( $ounces );
				$weight = round( $ounces / 16, 1 );

			}
		}

		if ( empty( $weight ) ) {
			$sg_default_weight = get_option( 'sg_default_weight', 0.5 );
			$weight            = $sg_default_weight;
		}

		return $weight; // pounds
	}
}


add_action( 'woocommerce_before_checkout_form', 'bbloomer_print_cart_weight' );
add_action( 'woocommerce_before_cart', 'bbloomer_print_cart_weight' );

function bbloomer_print_cart_weight( $posted ) {
	global $woocommerce;
	$notice = 'Your cart weight is: ' . $woocommerce->cart->cart_contents_weight . get_option( 'woocommerce_weight_unit' );
	if ( is_cart() ) {
		wc_print_notice( $notice, 'notice' );
	} else {
		wc_add_notice( $notice, 'notice' );
	}
}