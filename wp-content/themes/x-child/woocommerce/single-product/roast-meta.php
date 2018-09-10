<?php
/**
 * Single product roast level
 * Dependent upon Advanced Custom Fields Pro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;


$roast_value = get_field('roast_level');
$notes = get_field('tasting_notes');
$processing = get_field('processing');

?>

<table class="roast-meta">
<?php 
if( get_field('roast_level') ): ?>
	<tr>
			<td><span class="w-600"><?php _e( 'Roast Level', '__x__' ); ?></span></td>
			<td>
				<div class="fit-content">
					<span class="roast-level small"><?php echo do_shortcode( '[roast level='.$roast_value.']' ); ?></span><div class="roast-light"><?php _e( 'Light', '__x__' ); ?></div><div class="roast-dark"><?php _e( 'Dark', '__x__' ); ?></div>
				</div>
			</td>
	</tr>
<?php endif; 

if( get_field('tasting_notes') ): ?>
	<tr>
		<td><span class="w-600"><?php _e( 'Tasting Notes', '__x__' ); ?></span></td>
		<td><span class="small"><?php echo $notes; ?></span></td>
	</tr>
<?php endif;

if( get_field('processing') ): ?>
	<tr>
		<td><span class="w-600"><?php _e( 'Processing', '__x__' ); ?></span></td>
		<td><span class="small"><?php echo $processing; ?></span></td>
	</tr>
<?php endif; ?>

</table>