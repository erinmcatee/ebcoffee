<?php

// =============================================================================
// VIEWS/INTEGRITY/_EB-HEADER.PHP
// -----------------------------------------------------------------------------
// Handles custom EB header background image, set using Advanced Custom Fields options page
// =============================================================================
?>


<?php if (get_field('image_override_header') == FALSE ) : 	

  if ( get_field('header_bg_image', 'option') ) : ?>
  	<div style="background-image:url('<?php the_field("header_bg_image", "option"); ?>'); background-position:top; background-size:cover;" class="bg-image header-min-height"></div>
  <?php else : ?>
  	<div style="background-color:rgb(40,40,40);" class="x-section bg-image header-min-height"></div>
  <?php endif;

endif;

if (is_product() ) :

	$product = wc_get_product( get_the_id() );
	if(get_field('header_global_block_id','option')) {
		if( $product->is_type( 'variable-subscription' ) ){
			echo do_shortcode( '[cs_gb id=' . get_field('header_global_block_id','option') . ']');
		}
	}
	
endif;