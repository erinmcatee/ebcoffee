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


if( get_field('roast_level') || get_field('roast_level') != 0 ): ?>
	<div itemprop="roast">
		<?php echo '<p class="roast-tag"><mark class=" x-highlight '. $roast_value .'">'. $roast_value .'</mark></p>'; ?>
	</div>
<?php endif; ?>