<?php
// Google Analytics
// =============================================================================

// Include the Google Analytics Tracking Code (ga.js)
// @ https://developers.google.com/analytics/devguides/collection/gajs/
function google_analytics_tracking_code(){ ?>

		<script>
		
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-77591609-1', 'auto');
		  ga('send', 'pageview');
		
		</script>
		
<?php
}

// include GA tracking code before the closing head tag
add_action('wp_head', 'google_analytics_tracking_code');

// Include the Google Maps API script & draw map
// =============================================================================


//Google maps API script load, draw map
function eb_scripts(){
	if ((wc_get_product() && wc_get_product()->is_type('variable-subscription'))) {
		wp_deregister_script( 'wc-add-to-cart-variation' );
		wp_register_script( 'wc-add-to-cart-variation', get_stylesheet_directory_uri() . '/src/js/add-to-cart-variation.js', array( 'jquery','wp-util'), 1.2, true );
	}
	
	wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css' );
}
add_action( 'wp_enqueue_scripts', 'eb_scripts' );


//to add async & defer to loading of scripts
// =============================================================================
function add_async_attribute($tag, $handle) {
    if ( 'google-map-api' !== $handle )
        return $tag;
    return str_replace( ' src', ' async defer src', $tag );
}
add_filter('script_loader_tag', 'add_async_attribute', 10, 2);

// Include fonts in head
// =============================================================================
function google_fonts() {
	$query_args = array(
		'family' => 'Pacifico',
		'subset' => 'latin,latin-ext'
	);
	wp_register_style( 'google_fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );
}      
add_action('wp_enqueue_scripts', 'google_fonts');