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


if( get_field('stock_message') && get_field('stock_message') != null ): ?>
	<div class="x-alert x-alert-warning fade in" itemprop="stock">
		<?php echo '<p>'. get_field('stock_message'). '</p>'; ?>
	</div>
<?php endif; ?>