<?php
// Heading
$_['heading_title']      = 'Stripe';

// Text 
$_['text_payment']       = 'Payment';
$_['text_success']       = 'Success: Stripe details have been saved.';
$_['text_stripe']        = '<a href="http://www.stripe.com" target="_blank"><img src="view/image/payment/stripe.png" alt="Stripe" title="Stripe" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization'] = 'Authorization';
$_['text_sale']          = 'Sale';
$_['text_edit']          = 'Edit';

// Entry
$_['entry_test_publishable_key']     = 'Test Publishable Key:';
$_['entry_test_secret_key']     = 'Test Secret Key:';

$_['entry_live_publishable_key']     = 'Live Publishable Key:';
$_['entry_live_secret_key']     = 'Live Secret Key:';



$_['entry_password']     = 'API Password:';
$_['entry_signature']    = 'API Signature:';
$_['entry_test']         = 'Test Mode:';
$_['entry_test_help']    = "If yes, transactions will be run through the test Stripe server. Turn off on live stores.";
$_['entry_transaction']  = 'Transaction Method:';
$_['entry_total']        = 'Total:';
$_['entry_total_help']	= "The checkout total the order must reach before this payment method becomes available.";
$_['entry_order_status'] = 'Order Status:';
$_['entry_geo_zone']     = 'Geo Zone:';
$_['entry_status']       = 'Status:';
$_['entry_sort_order']   = 'Sort Order:';
$_['entry_prevent_duplicate_charge']   = 'Prevent duplicate charges';
$_['entry_prevent_duplicate_charge_help']   = 'If set, Easy Stripe won\'t attempt to charge if the order status is already the above status.';
$_['entry_journal_mode']   = 'Journal Mode';
$_['entry_journal_mode_help']   = 'Only turn on if you\'re using the Journal2 theme with Quick Checkout.';

// Error
$_['error_permission']   = 'Warning: You do not have permission to modify the Stripe module!';
$_['error_live_publishable_key']     = 'Please provide a live publishable key';
$_['error_live_secret_key']     = 'Please provide a live secret key';
$_['error_test_publishable_key']     = 'Please provide a test publishable key';
$_['error_test_secret_key']     = 'Please provide a test secret key';
$_['error_password']     = 'API Password Required!'; 
$_['error_signature']    = 'API Signature Required!';