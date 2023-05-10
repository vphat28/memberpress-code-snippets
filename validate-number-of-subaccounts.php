<?php

add_filter( 'mepr-validate-signup', function ( $errors ) {
  $user    = wp_get_current_user();
  $product = new MeprProduct( $_REQUEST['mepr_product_id'] );
  $is_down = $product->is_downgrade_for( $user->ID );

  if ( ! $is_down ) {
    return $errors;
  }

  $corporate_accounts = MPCA_Corporate_Account::get_all_by_user_id( $user->ID );
  $num_sub_accounts   = get_post_meta( $product->ID, 'mpca_num_sub_accounts', true );


  foreach ( $corporate_accounts as $corporate_account_rec ) {
    $corporate_account = new MPCA_Corporate_Account();
    $corporate_account->load_from_array( $corporate_account_rec );
    $sub_acc_used = $corporate_account->num_sub_accounts_used();
    $sub          = $corporate_account->get_obj();

    $subscription_product = $sub->product();
    if ( $subscription_product->group()->ID == $product->group()->ID && $corporate_account->is_enabled() ) {
      if ( $sub_acc_used > $num_sub_accounts ) {
        $errors[] = 'Your number of sub accounts have exceeded the maximum allowance which is ' . $num_sub_accounts;
      }
    }
  }

  return $errors;
} );
