<?php
/**
 * Single product roast level
 * Dependent upon Advanced Custom Fields Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;


$roast_value = get_field('tasting_notes');


if( get_field('tasting_notes') ): 
	$notes = get_field('tasting_notes'); ?>
	
	<div itemprop="notes">
		<p><?php _e( 'Tasting Notes', '__x__' ); ?></p>
		<?php echo $notes ?>
	</div>
	
<?php endif; ?>