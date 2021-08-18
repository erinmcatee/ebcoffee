<?php
/**
 * Plugin Name: Extend WooCommerce Subscription Intervals
 * Description: Add a "every 10 weeks" billing interval to WooCommerce Subscriptions
 * Author: Brent Shepherd
 * Author URI: http://brent.io
 * Version: 1.0
 * License: GPL v2
 */

function eb_extend_subscription_period_intervals( $intervals ) {
	
	for ($i = 7; $i <= 48; $i++) {
	
		$intervals[$i] = sprintf( __( 'every %s', 'my-text-domain' ), WC_Subscriptions::append_numeral_suffix( $i ) );
	
	}
	
	return $intervals;
}
add_filter( 'woocommerce_subscription_period_interval_strings', 'eb_extend_subscription_period_intervals' );


/**
 * Output a list of variation attributes / buttons for use in the cart forms.
 *
 * @param array $args Arguments.
 * @since 2.4.0
 */
function eb_radio_variation_attribute_options( $args = array() ) {
    $args = wp_parse_args(
        apply_filters( 'eb_radio_variation_attribute_options_args', $args ),
        array(
            'options'          => false,
            'attribute'        => false,
            'product'          => false,
            'checked'    	   => '',
            'name'             => '',
            'id'               => '',
            'class'            => '',
        )
    );

    // Get selected value.
    if ( false === $args['checked'] && $args['attribute'] && $args['product'] instanceof WC_Product ) {
        $checked_key     = 'attribute_' . sanitize_title( $args['attribute'] );
        $args['checked'] = isset( $_REQUEST[ $checked_key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $checked_key ] ) ) : $args['product']->get_variation_default_attribute( $args['attribute'] ); // WPCS: input var ok, CSRF ok, sanitization ok.
    }

    $options               = $args['options'];
    $product               = $args['product'];
    $attribute             = $args['attribute'];
    $checked		   	   = $args['checked'];
    $name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
    $id                    = $args['id'] ? $args['id'] : sanitize_title( $attribute ); 
    $class                 = $args['class'];

    if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
        $attributes = $product->get_variation_attributes();
        $options    = $attributes[ $attribute ];
    }
    
    
    if (! empty ( $options ) ) {
	    // Get terms if this is a taxonomy - ordered. We need the names too.
	    $terms = wc_get_product_terms(
            $product->get_id(),
            $attribute,
            array(
                'fields' => 'all',
            )			    
	    );
	    
	    
	    
	     
	    foreach ( $terms as $term) {
			if(get_field('attribute_image', 'term_' . $term->term_id)) :  //ACF field returning url
				$term_image = get_field('attribute_image', 'term_' . $term->term_id);
			else :
				$term_image = '';
			endif; 
			
								
		    if ( in_array( $term->slug, $options, true ) ) {
			    $html  = '<div class="switch-field product-view">';
			    $html .= '<input type="radio" name="' . esc_attr( $name ) . '" value="' . esc_attr( $term->slug ) . '" id="' . $name . '_v_' . $term->slug . $product->get_id() . '" ' . checked( sanitize_title( $checked ), $term->slug, false ) . '>';
			    $html .= '<label class="' . esc_attr( $name ) . '" for="' . $name . '_v_' . $term->slug . $product->get_id() . '">';
			    $html .= '<span class="check"></span>';
			    if($term_image) : 
			    $html .= '<img class="attr-image" src="' . $term_image . '" alt="' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) ) . '" />';
			    endif;
			    $html .= '<div><p class="heading">' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) ) . '</p>';
			    $html .= '<p class="subheading">' . esc_html( $term->description ) . '</p></div>';
			    $html .= '</label></div>';
		    }
		    
		    echo apply_filters( 'eb_radio_variation_attribute_options_html', $html, $args ); // WPCS: XSS ok.
	    }
    }
}


//add_filter( 'woocommerce_available_variation', 'variations_product_price_per_bag' );
function variations_product_price_per_bag( $variations ) {
	
	if ( array_key_exists('attribute_pa_bags-per-shipment', $variations['attributes']) && array_key_exists('attribute_pa_plan', $variations['attributes']) ) :
		
		if ($variations['attributes']['attribute_pa_bags-per-shipment'] == 'two-bags') : $bags_per_shipment = 2; 
			else : $bags_per_shipment = 1;
			endif;
		if ($variations['attributes']['attribute_pa_plan'] == '12-coffee-plan') : $plan = 12; 
			elseif ($variations['attributes']['attribute_pa_plan'] == '6-coffee-plan') : $plan = 6;
			elseif ($variations['attributes']['attribute_pa_plan'] == 'pay-per-coffee') : $plan = 1;
			else : $plan = null;
			endif;
		
		//Display per bag price
		if ($bags_per_shipment == 2 && $plan == 1) :
			$bag_price = $variations['display_price'] / $plan / $bags_per_shipment;
		else :
			$bag_price = $variations['display_price'] / $plan;
		endif;
		
		//Communicate bulk shipping rate
		if ($bags_per_shipment == 2) :
			$shipping = 'Free Shipping!';
			$total_shipping = esc_html('All boxes in this subscription will ship free!');
		else :
			$shipping = '$4.99 shipping';
			$total_shipping = wc_price($plan * 4.99) . esc_html(' total shipping added at checkout.');
		endif;
		
		//Show savings badge
		if ($bags_per_shipment >= 2 ) :
			if ( $plan == 1 ) :
				$display = '';
				$ship_save = 9.98;
				$total_save = $ship_save;
			else :
				$display = '';
				$ship_save = $plan * 4.99;
				$coffee_save = (15 * $plan) - $variations['display_price'];
				$total_save = $ship_save + $coffee_save;			
			endif;
		else :
			if ( $plan >= 2 ) : 
				$display = '';
				$coffee_save = (15 * $plan) - ($variations['display_price']);
				$total_save = $coffee_save;
			else :
				$display = 'style="display:none"';
				$total_save = '';
			endif;
		endif;


		$bag_html  = '<span class="bag-price">';
		$bag_html .= wc_price($bag_price);
		$bag_html .= '<span class="details">' . esc_html(' / bag ');
		$bag_html .= '+ ' . $shipping . '</span>';
		$bag_html .= '</span>';
		
		$ship_total_html  = '<span class="total-shipping">';
		$ship_total_html .= $total_shipping;
		$ship_total_html .= '</span>';
		
		$badge  = '<div ' . $display . ' class="savings-badge x-alert x-alert-success">';
		$badge .= wc_price($total_save) . esc_html(' in total savings!');
		$badge .= '</div>';

		$variations['bag_html'] = $bag_html;
		$variations['total_shipping_html'] = $ship_total_html;
		$variations['savings_badge'] = $badge;

		return $variations;

	else :

		return $variations;

	endif;
}


 
function eb_subscription_attrs($slug, $field) {
	if ( !get_field($slug, 'option') ) :
		return;
	else :
		$attr = get_field($slug, 'option');
		if ( !$attr[$field] ) :
			return;
		else :
			$val = $attr[$field];
		endif;
	endif;
	
	return $val;
}

//add_action('woocommerce_before_add_to_cart_quantity', 'eb_add_qty_label');
function eb_add_qty_label() {
	$label = '<div class="label">';
	$label .= esc_html('QTY');
	$label .= '</div>';
	
	echo $label;
}
