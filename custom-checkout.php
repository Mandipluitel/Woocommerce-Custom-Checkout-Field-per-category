// Check if a specific product category is in the cart
add_filter( 'woocommerce_checkout_fields', 'conditionally_remove_checkout_fields', 25, 1 );
function conditionally_remove_checkout_fields( $fields ) {
  // HERE the defined product Categories
  $categories = array('events');
  $found = false;

  // CHECK CART ITEMS: search for items from our defined product category
  foreach ( WC()->cart->get_cart() as $cart_item ){
    if( has_term( $categories, 'product_cat', $cart_item['product_id'] ) ) {
      $found = true;
      break;
    }
  }

  // If a special category is in the cart, remove some shipping fields
  if ( $found ) {
    // hide the billing fields
    unset( $fields['billing']['billing_company'] );
    unset( $fields['billing']['billing_address_1'] );
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_postcode'] );
    unset( $fields['billing']['billing_state'] );
    unset( $fields['billing']['billing_city'] );
    unset( $fields['billing']['billing_phone'] );

    // hide the additional information section
    add_filter('woocommerce_enable_order_notes_field', '__return_false');
    add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );
  }
  return $fields;
}
