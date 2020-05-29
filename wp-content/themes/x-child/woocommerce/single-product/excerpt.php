<?php
/**
 * Single product excerpt - replaces short description for loop listings
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
$excerpt = get_field('product_excerpt');

if ( $excerpt ) {
	$output = '<p>'. get_field('product_excerpt') . '</p>';
} else if ( ! $short_description ) {
	return;
} else {
	$output = $short_description;
}

?>
<div class="woocommerce-product-details__short-description">
	<?php echo $output; // WPCS: XSS ok. ?>
</div>
