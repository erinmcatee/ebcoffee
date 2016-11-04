<?php
/**
 * Single variation cart button
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<div class="label">QTY</div>
	<div class="x-column x-sm x-1-2">
		<?php if ( ! $product->is_sold_individually() ) : ?>
			<?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ); ?>
		<?php endif; ?>
	</div>
	<div class="x-column x-sm x-1-2">
		<button type="submit" class="single_add_to_cart_button x-btn x-btn-large alt">
			<i class="x-icon x-icon-shopping-cart" data-x-icon="" aria-hidden="true"></i>
			<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
		</button>
		<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->id ); ?>" />
		<input type="hidden" name="product_id" value="<?php echo absint( $product->id ); ?>" />
		<input type="hidden" name="variation_id" class="variation_id" value="0" />
	</div>
	<hr class="x-clear">
</div>
