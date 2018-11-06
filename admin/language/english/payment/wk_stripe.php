<?php
/**
	* @version [Supported opencart version 2.3.x.x.]
	* @category Webkul
	* @package Payment
	* @author [Webkul] <[<http://webkul.com/>]>
	* @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
	* @license https://store.webkul.com/license.html
*/
// Heading
$_['heading_title']       = 'Stripe Payment';

$_['button_close'] 		  = 'Close';
$_['button_save']         = 'Save';

$_['tab_general'] 		  = 'General Management';
$_['tab_stripe']          = 'Stripe Management';
$_['tab_checkout']        = 'Checkout Management';
$_['tab_status']          = 'Status Management';

// Text 
$_['text_refund']	      = 'Success - Amount has been refunded successfully.';
$_['text_payment']	      = 'Payment';
$_['text_authorization']  = 'Authorization';
$_['text_all_zones']  	  = 'All Zones';
$_['text_all_customer']   = 'Not Logged In';
$_['text_enabled']        = 'Enable';
$_['text_disabled']       = 'Disable';
$_['text_yes']         	  = 'Yes';
$_['text_no']      		  = 'No';
$_['text_success']        = 'Success You have modified Stripe Payment Method details!';
$_['text_sale']           = 'Sale';
$_['text_live']    		  = 'Live';
$_['text_test']    		  = 'Test';
$_['text_clear']    	  = 'Clear';
$_['text_browse']    	  = 'Browse';
$_['text_image_manager']  = 'Image Manager';

// Entry
$_['entry_order_status'] 		     = 'Order Status ';
$_['entry_geo_zone']    			 = 'Allowed Geo Zone(s) ';
$_['entry_geo_zoneinfo']   			 = '';

$_['entry_status']      			 = 'Payment Method Status ';
$_['entry_sort_order']  			 = 'Sort Order ';
$_['entry_total']       			 = 'Total';
$_['entry_min']     			 	 = 'Min';
$_['entry_max']     			     = 'Max';
$_['entry_title']    	 			 = 'Payment Method Title ';
$_['entry_title_info']    	 	     = 'Enter the title for payment method that will be displayed to the customer while choosing payment method at checkout.';
$_['entry_btn_text']    	 		 = 'Confirmation Button Text ';
$_['entry_btn_info']    	 	     = 'Enter the text for order confirmation button that will be displayed to the customer while order confirmation at checkout.';
$_['entry_success_status']  		 = 'Order Success Status ';
$_['entry_refund_status'] 			 = 'Status Refund ';
$_['entry_zip_status']   			 = 'Status Zip Failure ';
$_['entry_cvc_status']  	   		 = 'Status CVC Failure ';
$_['entry_addess_status']   	     = 'Status Address Failure ';
$_['entry_keysinfo'] 				 = 'You can get all your API keys at Stripe admin panel under Your Account > Account Settings > API Keys';
$_['entry_test_key']   				 = 'Secret Key for testing ';
$_['entry_test_publish_key']  	     = 'Publish Key for testing ';
$_['entry_live_key']   			     = 'Secret Key for live ';
$_['entry_live_publish_key'] 		 = 'Publish Key for live ';
$_['entry_groups']     				 = 'Allowed Customer Group(s) ';
$_['entry_groupsinfo']				 = '';

$_['entry_stripe_mode']    			 = 'Payment Mode ';
$_['entry_stripe_modeinfo']    		 = 'Use Test to test payments via Stripe payment gateway. Use Live when you are ready to accept payments.';
$_['entry_currecny_mapping']    	 = 'Currency Alteration ';
$_['entry_currecny_mappinginfo']     = 'Select currency that will be charged against selected currency by customer at the time of payment. If it is disabled and customer is using disabled currency at front-end then stripe payment method will no longer available for payment. ';
$_['entry_send_customer']   		 = 'Customer Data ';
$_['entry_send_customerinfo']  		 = 'Sending customer data will create a customer profile at Stripe using the email address which is provided while placing order. The credit card which is used for payment, will be attached to this customer, allowing you to charge them again in the future in Stripe.';

$_['entry_stripe_description']    	 = 'Transaction Description ';
$_['entry_stripe_descriptioninfo'] 	 = 'If you want simple text sent as transaction description then enter text, otherwise can be given like "XYZ [comment] ABC", where comment will be index of order information array, could be given anything from index';
$_['entry_stripe_settingsinfo']    	 = 'Stripe Checkout uses Stripe\'s design and their own validation regarding card number,cvc etc.';
$_['entry_stripe_button']    		 = 'Use Stripe Button';
$_['entry_total_info']			     = 'Transaction Amount RestrictionEnter min and max value if you want that stripe will work only in between of some range, otherwise leave it blank.';

$_['entry_remember_me']    			 = 'Enable Remember Me ';
$_['entry_remember_meinfo'] 		 = 'This will allow customers to remember their details.';
$_['entry_shipping']    			 = 'Enable Shipping Address ';
$_['entry_shippinginfo']   			 = 'Set Yes if you want address from customer otherwise No.';
$_['entry_stripe_logo']    	 		 = 'Logo at Pop-up Box ';
$_['entry_stripe_logoinfo']	 		 = 'Select the image that will be used as your company logo in the pop-up Box.';
$_['entry_stripe_pop_title']    	 = 'Pop-up Title ';
$_['entry_stripe_pop_titleinfo']   	 = 'If you want simple text title on stripe popup then enter text, otherwise can be given like "XYZ | [order_id]", where order_id will be index of order information array, could be given anything from index.';
$_['entry_stripe_pop_description']	 = 'Pop-up Description ';
$_['entry_stripe_pop_desinfo']  	 = 'If you want simple text description on stripe popup then enter text, otherwise can be given like "XYZ | [order_id]", where order_id will be index of order information array, could be given anything from index.';
$_['entry_stripe_pop_text']    	 	 = 'Pop-up Button Text ';
$_['entry_stripe_pop_textinfo']	 	 = 'If you want simple text on stripe popup then enter text, otherwise can be given like "XYZ | [amount]", where amount will be index of order information array, could be given anything from index.';

$_['entry_orderinfo']    		     = 'Choose status that will be shown when any of below event will occur.';
$_['entry_successpayment']    		 = 'Successfully Paid Status ';
$_['entry_streetchk']    	         = 'Address(street) Failure Status ';
$_['entry_zipchk']    				 = 'Zip Code Failure Status ';
$_['entry_cvcchk']    				 = 'CVC Code Failure Status ';
$_['entry_refund']    				 = 'Refund Payment Status ';

$_['entry_popup_discription_placeholder']	=	'Your order id | [order_id]';
$_['entry_popup_title_placeholder']			=	'Amount to be paid | [total]';
$_['entry_popup_button_placeholder']		=	'Pay | [total]';
$_['entry_tran_description_placeholder']		=	'Description For Order - | [order_id]';  

// Error
$_['error_permission']   = 'Warning You do not have permission to modify payment Stripe Payment Checkout!';
$_['error_username']     = 'API Username Required!'; 
$_['error_password']     = 'API Password Required!'; 
$_['error_signature']    = 'API Signature Required!'; 
?>