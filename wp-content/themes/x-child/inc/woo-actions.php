<?php 	
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 50 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 60 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 5 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_before_add_to_cart_form', 'woocommerce_template_single_price', 10 );

add_action( 'woocommerce_after_shop_loop_item_title', 'eb_template_single_excerpt', 1 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_single_eb_roast_meta', 5 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_eb_roast_meta', 25 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_eb_stock_message', 24 );

add_action('init','remove_hooks');
function remove_hooks(){
    remove_action( 'woocommerce_composite_summary_widget_content', 'wc_cp_summary_widget_price', 20, 2 );
}