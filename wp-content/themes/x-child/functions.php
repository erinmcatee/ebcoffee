<?php

// =============================================================================
// FUNCTIONS.PHP
// -----------------------------------------------------------------------------
// Overwrite or add your own custom functions to X in this file.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Enqueue Parent Stylesheet
//   02. Additional Functions
// =============================================================================

// Enqueue Parent Stylesheet
// =============================================================================

add_filter( 'x_enqueue_parent_stylesheet', '__return_true' );


// Favicons
// =============================================================================
function eb_favicon_links() {
    echo '<link rel="apple-touch-icon" sizes="180x180" href="' . get_stylesheet_directory_uri() . '/favicons/apple-touch-icon.png">' . "\n";
	echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/favicons/favicon-32x32.png" sizes="32x32">' . "\n";
	echo '<link rel="icon" type="image/png" href="' . get_stylesheet_directory_uri() . '/favicons/favicon-16x16.png" sizes="16x16">' . "\n";
	echo '<link rel="manifest" href="' . get_stylesheet_directory_uri() . '/favicons/manifest.json">' . "\n";
	echo '<link rel="mask-icon" href="' . get_stylesheet_directory_uri() . '/favicons/safari-pinned-tab.svg" color="#5bbad5">' . "\n";
	echo '<meta name="theme-color" content="#ffffff">' . "\n";
}
add_action( 'wp_head', 'eb_favicon_links' );

// BHC Social Meta override for social plugin
// =============================================================================
function x_social_meta() {
	return;
}

// ACF options page
// =============================================================================
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page('E&B Settings');
}

// Copyright Year Shortcode
// =============================================================================
function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('year', 'year_shortcode');

//WooCommerce Modifications
// =============================================================================
// Remove price ranges.
//

/**
 * Output the product roast.
 *
 * @subpackage	Product
 */
function woocommerce_template_single_eb_roast_meta() {
	wc_get_template( 'single-product/roast-meta.php' );
}
/** 
 * Output the stock message if populated. Relies on ACF.
 *
 * @subpackage	Product
 */
function woocommerce_template_single_eb_stock_message() {
	wc_get_template( 'single-product/stock-message.php' );
}


// Cart actions.
//First remove x-theme function, then rewrite it.
function remove_x_woocommerce_cart_actions() {
	remove_action( 'woocommerce_cart_actions', 'x_woocommerce_cart_actions' );
}
add_action('wp_loaded', 'remove_x_woocommerce_cart_actions');


function x_woocommerce_cart_actions_eb() {

  $output = '';


//
// Check based off of wc_coupons_enabled(), which is only available in
// WooCommerce v2.5+.
//
if ( apply_filters( 'woocommerce_coupons_enabled', 'yes' === get_option( 'woocommerce_enable_coupons' ) ) ) {
	$output .= '<input type="submit" class="button" name="apply_coupon" value="' . esc_attr__( 'Apply Coupon', '__x__' ) . '">';
}

echo $output;

}

add_action( 'woocommerce_cart_actions', 'x_woocommerce_cart_actions_eb' );


// Remove phone from required fields
//
add_filter( 'woocommerce_billing_fields', 'wc_npr_filter_phone', 10, 1 );
function wc_npr_filter_phone( $address_fields ) {
	$address_fields['billing_phone']['required'] = false;
	return $address_fields;
}

// Change login error for username/email
add_filter('login_errors', function($a) {return '<b>Error:</b> Email address is required.';});

/* // Remove Country from checkout 
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     unset($fields['billing']['billing_country']);
     unset($fields['shipping']['shipping_country']);

     return $fields;
} */

//Remove cross sell
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');


// Updated gift message field
add_filter( 'woocommerce_checkout_fields', 'eb_custom_checkout_fields');
function eb_custom_checkout_fields( $fields ) {
     $fields['order']['order_comments']['placeholder'] = 'Include a personal message!';
     $fields['order']['order_comments']['label'] = 'Gift Message';
     
     unset($fields['billing']['billing_company']);
     unset($fields['shipping']['shipping_company']);
     
     return $fields;
}


// Do Not Remove Woocommerce Plugin Settings
// =============================================================================
function x_woocommerce_donot_remove_plugin_setting(){
  if ( ! is_admin() ) {
    return;
  }
  remove_filter( 'woocommerce_product_settings', 'x_woocommerce_remove_plugin_settings', 10 );
}
add_action('init', 'x_woocommerce_donot_remove_plugin_setting');


// Roast Level, with shortcode.
// =============================================================================
function get_roast_tag($atts) {
	$a = shortcode_atts( array(
		'level' => '',
	), $atts );
	
	$roast_level = $a['level'];
	
	switch ($roast_level) {
		case 0:
			return '<i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i>';
			break;
		case 1:
			return '<i class="fas fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i>';
			break;
		case 2:
			return '<i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i>';
			break;		
		case 3:
			return '<i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i>';
			break;		
		case 4:
			return '<i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i>';
			break;		
		case 5:
			return '<i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="far fa-circle"></i><i class="far fa-circle"></i>';
			break;		
		case 6:
			return '<i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="far fa-circle"></i>';
			break;		
		case 7:
			return '<i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i><i class="fas fa-circle"></i>';
			break;		
		default:
			return '';
	}
}
add_shortcode('roast', 'get_roast_tag');


/**
 * Output the (excerpt) - different from short description.
 */
function eb_template_single_excerpt() {
	wc_get_template( 'single-product/excerpt.php' );
}


// Required includes
require 'inc/enqueue.php';
require 'inc/subscriptions.php';
require 'inc/woo-actions.php';
require 'inc/acf.php';
require 'inc/fooevents.php';
