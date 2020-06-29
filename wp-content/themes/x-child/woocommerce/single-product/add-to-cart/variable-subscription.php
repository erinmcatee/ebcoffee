<?php
/**
 * Variable subscription product add to cart
 *
 * @author  Prospress
 * @package WooCommerce-Subscriptions/Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

//print("<pre>".print_r($product,true)."</pre>");

$attribute_keys = array_keys( $attributes );
$user_id        = get_current_user_id();

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wcs_json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce-subscriptions' ); ?></p>
	<?php else : ?>
		<?php if ( ! $product->is_purchasable() && 0 !== $user_id && 'no' !== wcs_get_product_limitation( $product ) && wcs_is_product_limited_for_user( $product, $user_id ) ) : ?>
			<?php $resubscribe_link = wcs_get_users_resubscribe_link_for_product( $product->get_id() ); ?>
			<?php if ( ! empty( $resubscribe_link ) && 'any' === wcs_get_product_limitation( $product ) && wcs_user_has_subscription( $user_id, $product->get_id(), wcs_get_product_limitation( $product ) ) && ! wcs_user_has_subscription( $user_id, $product->get_id(), 'active' ) && ! wcs_user_has_subscription( $user_id, $product->get_id(), 'on-hold' ) ) : // customer has an inactive subscription, maybe offer the renewal button. ?>
				<a href="<?php echo esc_url( $resubscribe_link ); ?>" class="woocommerce-button button product-resubscribe-link"><?php esc_html_e( 'Resubscribe', 'woocommerce-subscriptions' ); ?></a>
			<?php else : ?>
				<p class="limited-subscription-notice notice"><?php esc_html_e( 'You have an active subscription to this product already.', 'woocommerce-subscriptions' ); ?></p>
			<?php endif; ?>
		<?php else : ?>
			<?php if ( wp_list_filter( $available_variations, array( 'is_purchasable' => false ) ) ) : ?>
				<p class="limited-subscription-notice notice"><?php esc_html_e( 'You have added a variation of this product to the cart already.', 'woocommerce-subscriptions' ); ?></p>
			<?php endif; ?>
			
			
			<table class="variations subscription-variations" cellspacing="0">
				<tbody>
					
					<?php
						
					
					foreach ( $attributes as $taxonomy => $terms_slug ) :
											
						$sanitized_name = sanitize_title( $taxonomy );
						// To get the attribute label (in WooCommerce 3+)
						$taxonomy_label = wc_attribute_label($taxonomy, $product);
					    
					    // Setting some data in an array
					    $variations_attributes_and_values[$taxonomy] = array('label' => $taxonomy_label);						
						
						//Set class for grid count
						$count = sizeof($terms_slug);
						if ($count <= 2 ) : $count_class = 'two-up';
						elseif ($count == 3) : $count_class = 'three-up';
						elseif ($count >= 4) : $count_class = 'four-up';
						endif;
						?>
						
						<?php 
							$heading = eb_subscription_attrs($taxonomy, 'heading');
							$subheading = eb_subscription_attrs($taxonomy, 'subheading');
						?>
												
						<tr class="attribute attribute-<?php echo esc_attr( $sanitized_name ); ?>">
							<td class="label">
								<label class="attribute-heading" for="<?php echo esc_attr( $sanitized_name ); ?>">
									<h5><?php echo $heading; ?></h5>
									<p><?php echo $subheading; ?></p>
								</label>
							</td>
							<td class="value <?php echo $count_class ?>"> <?php // Generate buttons ?>
							
							<?php if ( isset( $selected_attributes[ $sanitized_name ] ) ) {
								$checked = $selected_attributes[ $sanitized_name ];
								
							} else {
								$checked = $product->get_variation_default_attribute( $taxonomy );;
							}
														
							// Main function that builds styled radio buttons
							eb_radio_variation_attribute_options( array( 
								'options' 	=> $terms_slug,
								'attribute' => $taxonomy,
								'product' 	=> $product,
								'checked'	=> $checked
							));
							
							//Clear button
							echo wp_kses( end( $attribute_keys ) === $taxonomy ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . __( 'Clear', 'woocommerce-subscriptions' ) . '</a>' ) : '', array( 'a' => array( 'class' => array(), 'href' => array() ) ) );

							?>
							</td>
						</tr>
					<?php endforeach; ?>				
					
				</tbody>
			</table>

			<?php
			/**
			 * Post WC 3.4 the woocommerce_before_add_to_cart_button hook is triggered by the callback @see woocommerce_single_variation_add_to_cart_button() hooked onto woocommerce_single_variation.
			 */
			if ( WC_Subscriptions::is_woocommerce_pre( '3.4' ) ) {
				do_action( 'woocommerce_before_add_to_cart_button' );
			}
			?>

			<div class="single_variation_wrap subscription_variation">
				<?php
				/**
				 * woocommerce_before_single_variation Hook.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 *
				 * @since  2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook.
				 */
				do_action( 'woocommerce_after_single_variation' );
				?>
			</div>

			<?php
			/**
			 * Post WC 3.4 the woocommerce_after_add_to_cart_button hook is triggered by the callback @see woocommerce_single_variation_add_to_cart_button() hooked onto woocommerce_single_variation.
			 */
			if ( WC_Subscriptions::is_woocommerce_pre( '3.4' ) ) {
				do_action( 'woocommerce_after_add_to_cart_button' );
			}
			?>
		<?php endif; ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
