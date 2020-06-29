<?php
	

add_filter( 'woocommerce_get_availability', 'eb_get_availability', 1, 2);
function eb_get_availability( $availability, $_product ) {
	global $post, $product;
	$WooCommerceEventsEvent = get_post_meta($post->ID, 'WooCommerceEventsEvent', true);
   
    if ($WooCommerceEventsEvent == 'Event' ):
	    //change text "In Stock' to 'SPECIAL ORDER'
	    if ( $_product->is_in_stock() ) $availability['availability'] = sprintf( __('%s Tickets available', 'woocommerce'), $product->get_stock_quantity() );
	  
	    //change text "Out of Stock' to 'SOLD OUT'
	    if ( !$_product->is_in_stock() ) $availability['availability'] = __('Event Sold Out', 'woocommerce');
	        return $availability;
	endif;
}