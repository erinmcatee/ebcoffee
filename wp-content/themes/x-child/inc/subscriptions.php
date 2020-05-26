<?php
/**
 * Plugin Name: Extend WooCommerce Subscription Intervals
 * Description: Add a "every 10 weeks" billing interval to WooCommerce Subscriptions
 * Author: Brent Shepherd
 * Author URI: http://brent.io
 * Version: 1.0
 * License: GPL v2
 */

function eg_extend_subscription_period_intervals( $intervals ) {
	
	for ($i = 7; $i <= 48; $i++) {
	
		$intervals[$i] = sprintf( __( 'every %s', 'my-text-domain' ), WC_Subscriptions::append_numeral_suffix( $i ) );
	
	}
	
	return $intervals;
}
add_filter( 'woocommerce_subscription_period_interval_strings', 'eg_extend_subscription_period_intervals' );