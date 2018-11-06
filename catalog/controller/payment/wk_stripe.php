<?php
/**
	* @version [Supported opencart version 2.3.x.x.]
	* @category Webkul
	* @package Payment
	* @author [Webkul] <[<http://webkul.com/>]>
	* @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
	* @license https://store.webkul.com/license.html
*/
class ControllerPaymentWkStripe extends Controller {	

	public function index() {
		$this->language->load('payment/wk_stripe');
		
		$lang = $this->config->get('config_language_id');
		$stripe_currency = $this->config->get('wk_stripe_currency');
		$data['text_wait'] = $this->language->get('text_wait');
		$data['text_testmode'] = $this->language->get('text_testmode');		

		$button_confirm_array = $this->config->get('wk_stripe_button_text');

		$data['button_confirm'] = isset($button_confirm_array[$lang]) ? $button_confirm_array[$lang] : $this->language->get('button_confirm');

		$data['testmode'] = $this->config->get('wk_stripe_mode');

		$stripe_keys = $this->getKeys();

		$stripe_image = $this->config->get('wk_stripe_logo');

		$this->load->model('tool/image');

		if(file_exists(DIR_IMAGE.$stripe_image))
			$data['stripe_image'] = $this->model_tool_image->resize($stripe_image,'128','128');
		else
			$data['stripe_image'] = $this->model_tool_image->resize('no_image.jpg','128','128');

		$data['stripe_keys'] = $stripe_keys;
		$data['action'] = $this->url->link('payment/wk_stripe/stripePay');

		//if 1 then stripe popup else not tpl
		$payment_type = $this->config->get('wk_stripe_type');

		$this->load->model('checkout/order');		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);		

		$popup_description = $this->getData($this->config->get('wk_stripe_popup_description'),$order_info);
		
		if($popup_description)
			$data['popup_description'] = $popup_description;
		else
			$data['popup_description'] = $this->language->get('text_popup_description');

		$popup_title = $this->getData($this->config->get('wk_stripe_popup_title'),$order_info);
		
		if($popup_title)
			$data['popup_title'] = $popup_title;
		else
			$data['popup_title'] = $this->language->get('text_popup_title');

		$popup_btn_text = $this->getData($this->config->get('wk_stripe_popup_button'),$order_info);
		
		if($popup_btn_text)
			$data['popup_btn_text'] = $popup_btn_text;
		else
			$data['popup_btn_text'] = $this->language->get('text_popup_btn_text');

		$data['remember_me'] = $this->config->get('wk_stripe_rememberme');
		$data['enable_shipping'] = $this->config->get('wk_stripe_shipping');
		$data['enable_billing'] = $this->config->get('wk_stripe_billing');
		$data['enable_zip'] = false;
		$data['enable_email'] = $this->customer->getEmail();
		$data['cart_currency'] = (isset($stripe_currency[$order_info['currency_code']]) AND $stripe_currency[$order_info['currency_code']]) ? $stripe_currency[$order_info['currency_code']]: 'USD';
		$data['cart_amount'] = 100 * $this->currency->format($order_info['total'], $data['cart_currency'] , '' ,false);
		if(version_compare(VERSION, '2.2.0.0', '>=')) 
			return $this->load->view('payment/wk_stripe.tpl', $data);
		else {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/wk_stripe.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/payment/wk_stripe.tpl', $data);
			} else {
				return $this->load->view('default/template/payment/wk_stripe.tpl', $data);
			}
		}
		
	}
	
	private function getKeys() {

		$testmode = $this->config->get('wk_stripe_mode');

		if($testmode)
			$stripe_keys = array(
			  "secret_key"      => $this->config->get('wk_stripe_live_key'),
			  "publishable_key" => $this->config->get('wk_stripe_live_publish_key')
			);
		else
			$stripe_keys = array(
			  "secret_key"      => $this->config->get('wk_stripe_test_key'),
			  "publishable_key" => $this->config->get('wk_stripe_test_publish_key')
			);

		return $stripe_keys;
	}

	private function getData($useMe,$order_info) {

		$returnMe = '';
		$lang = $this->config->get('config_language_id');
		
		if(isset($useMe[$lang]) AND $useMe[$lang]){
			if(strpos($useMe[$lang],'[')!== false){
				$explodedData = explode('|', $useMe[$lang]);
				foreach ($explodedData as $key => $value) {
					if(isset($order_info[trim(str_replace(']','',str_replace('[','', $value)))])){
						if(trim(str_replace(']','',str_replace('[','', $value)))=='total')
							$returnMe = $returnMe .' '.$this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);
						else
							$returnMe = $returnMe .' '.$order_info[trim(str_replace(']','',str_replace('[','', $value)))];
					}else{
						$returnMe = $returnMe .' '.trim(str_replace(']','',str_replace('[','', $value)));
					}
				}
			}else
				$returnMe = $useMe[$lang];
		}

		return $returnMe;
	}

	public function stripePay() {

		$rowData = $this->request->post;

		if ($this->request->server['REQUEST_METHOD'] == 'POST' AND isset($rowData['tokenData']['id'])) {

			$json = array();
			$this->language->load('payment/wk_stripe');
			$this->load->model('checkout/order');	
			$order_id = $this->session->data['order_id'];	
			$order_info = $this->model_checkout_order->getOrder($order_id);

			$stripe_currency = $this->config->get('wk_stripe_currency');				

			$cart_currency = (isset($stripe_currency[$order_info['currency_code']]) AND $stripe_currency[$order_info['currency_code']]) ? $stripe_currency[$order_info['currency_code']]: 'USD';

			$cart_amount = 100 * $this->currency->format($order_info['total'], $cart_currency , '' ,false);

			$descriptionWork = $this->config->get('wk_stripe_transaction_description');

			$returnMe = '';			
			if($descriptionWork){
				if(strpos($descriptionWork,'[')!== false){
					$explodedData = explode('|', $descriptionWork);
					foreach ($explodedData as $key => $value) {
						if(isset($order_info[trim(str_replace(']','',str_replace('[','', $value)))])){
							if(trim(str_replace(']','',str_replace('[','', $value)))=='total')
								$returnMe = $returnMe .' '.$this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);
							else
								$returnMe = $returnMe .' '.$order_info[trim(str_replace(']','',str_replace('[','', $value)))];
						}else{
							$returnMe = $returnMe .' '.trim(str_replace(']','',str_replace('[','', $value)));
						}
					}
				}else
					$returnMe = $descriptionWork;
			}

			$description = $returnMe;

			require_once(DIR_IMAGE. '../stripe-lib/Stripe.php');

			$stripe_keys = $this->getKeys();
			Stripe::setApiKey($stripe_keys['secret_key']);
			$token  = $rowData['tokenData']['id'];

			try {
				//create customer on not with charge
				if($this->config->get('wk_stripe_customer_data')){

					$rowData['tokenData']['card']['cvc_check'] = 

					$customer = Stripe_Customer::create(array(
					  'email' => $rowData['tokenData']['email'],
					  'card'  => $token
					));

					$charge = Stripe_Charge::create(array(
					  'customer' => $customer->id,
					  'description' => $description,
					  'amount'   => $cart_amount,
					  'currency' => $cart_currency,
					));

				}else{	
					$charge = Stripe_Charge::create(array(
					  'description' => $description,
					  'amount'   => $cart_amount,
					  'currency' => $cart_currency,
					  'card' => $token
					));
				}
			} catch (Stripe_Error $e) {		
				$error = $e->getMessage();
				$this->log->write('STRIPE_PAYMENRT :: Charge failed ' . $error);
			}

			
			if(!isset($error)){

				$cardObj = $charge->card ? $charge->card : $charge->source;

				//for error 
				if ($charge->failure_message || $charge->failure_code) {
					$this->log->write('STRIPE_PAYMENRT :: Charge failed ' . $charge->failure_message . '(' . $charge->failure_code . ')');
				}
				$comment = $this->language->get('text_transaction_details');
				$this->db->query("INSERT INTO `".DB_PREFIX."order_stripe` SET `order_id` = '".$order_id."', stripe_id = '".$this->db->escape($charge->id)."'");
				$updateId = $this->db->getLastId();
				$comment .= $this->language->get('text_stripe_id').$charge->id;
				if($charge->customer)
				$comment .= $this->language->get('text_stripe_customer_id').$charge->customer;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `customer_id` = '".$this->db->escape($charge->customer)."' WHERE id = '".(int)$updateId."'");

				$comment .= $this->language->get('text_stripe_amount').$charge->amount;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `amount` = '".$this->db->escape($charge->amount)."' WHERE id = '".(int)$updateId."'");
				$comment .= $this->language->get('text_currency').strtoupper($charge->currency);
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `currency` = '".$this->db->escape($charge->currency)."' WHERE id = '".(int)$updateId."'");

				$comment .= $this->language->get('text_description').$charge->description;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `description` = '".$this->db->escape($charge->description)."' WHERE id = '".(int)$updateId."'");
				$comment .= $this->language->get('text_livemode'). ($charge->livemode ? $this->language->get('Yes') : $this->language->get('No'));
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `livemode` = '".$this->db->escape($charge->livemode)."' WHERE id = '".(int)$updateId."'");
				$comment .= $this->language->get('text_paid').($charge->paid ? $this->language->get('Yes') : $this->language->get('No'));
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `paid` = '".$this->db->escape($charge->paid)."' WHERE id = '".(int)$updateId."'");
				//card data
				$comment .= $this->language->get('text_card_data');
				$comment .= $this->language->get('text_card_id').$cardObj->id;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `card_id` = '".$this->db->escape($cardObj->id)."' WHERE id = '".(int)$updateId."'");				
				$comment .= $this->language->get('text_brand').$cardObj->brand;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `brand` = '".$this->db->escape($cardObj->brand)."' WHERE id = '".(int)$updateId."'");
				$comment .= $this->language->get('text_name').$cardObj->name;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `name` = '".$this->db->escape($cardObj->name)."' WHERE id = '".(int)$updateId."'");
				$comment .= $this->language->get('text_last4').$cardObj->last4;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `last4` = '".$this->db->escape($cardObj->last4)."' WHERE id = '".(int)$updateId."'");
				$comment .= $this->language->get('text_exp_month').$cardObj->exp_month;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `exp_month` = '".$this->db->escape($cardObj->exp_month)."' WHERE id = '".(int)$updateId."'");
				$comment .= $this->language->get('text_exp_year').$cardObj->exp_year;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `exp_year` = '".$this->db->escape($cardObj->exp_year)."' WHERE id = '".(int)$updateId."'");
				$comment .= $this->language->get('text_fingerprint').$cardObj->fingerprint;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `fingerprint` = '".$this->db->escape($cardObj->fingerprint)."' WHERE id = '".(int)$updateId."'");
				$comment .= $this->language->get('text_country').$cardObj->country . (file_exists(DIR_IMAGE.'flags/'.strtolower(trim($cardObj->country)).'.png') ? ' <img src="'.HTTP_SERVER.'image/flags/'.strtolower(trim($cardObj->country)).'.png">' : '');
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `country` = '".$this->db->escape($cardObj->country)."' WHERE id = '".(int)$updateId."'");
				if($cardObj->address_line1)
				$comment .= $this->language->get('text_address1').$cardObj->address_line1;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `address1` = '".$this->db->escape($cardObj->address_line1)."' WHERE id = '".(int)$updateId."'");
				if($cardObj->address_line2)
				$comment .= $this->language->get('text_address2').$cardObj->address_line2;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `address2` = '".$this->db->escape($cardObj->address_line2)."' WHERE id = '".(int)$updateId."'");
				if($cardObj->address_city)
				$comment .= $this->language->get('text_city').$cardObj->address_city;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `city` = '".$this->db->escape($cardObj->address_city)."' WHERE id = '".(int)$updateId."'");
				if($cardObj->address_state)
				$comment .= $this->language->get('text_state').$cardObj->address_state;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `state` = '".$this->db->escape($cardObj->address_state)."' WHERE id = '".(int)$updateId."'");
				if($cardObj->address_zip)
				$comment .= $this->language->get('text_zip').$cardObj->address_zip;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `zip` = '".$this->db->escape($cardObj->address_zip)."' WHERE id = '".(int)$updateId."'");
				if($cardObj->address_country)
				$comment .= $this->language->get('text_add_country').$cardObj->address_country;
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `address_country` = '".$this->db->escape($cardObj->address_country)."' WHERE id = '".(int)$updateId."'");
				//checks
				$comment .= $this->language->get('text_cvc_check').ucwords($cardObj->cvc_check);
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `cvc_check` = '".$this->db->escape($cardObj->cvc_check)."' WHERE id = '".(int)$updateId."'");
				$comment .= $this->language->get('text_address_check').ucwords($cardObj->address_line1_check);
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `address_check` = '".$this->db->escape($cardObj->address_line1_check)."' WHERE id = '".(int)$updateId."'");
				$comment .= $this->language->get('text_address_zip_check').ucwords($cardObj->address_zip_check);
				$this->db->query("UPDATE `".DB_PREFIX."order_stripe` SET `address_zip_check` = '".$this->db->escape($cardObj->address_zip_check)."' WHERE id = '".(int)$updateId."'");
				$comment .= "<br/><a onclick='refund(".$order_id.");'>".$this->language->get('text_refund').'</a>';		
				$notify = true;

				if($charge->captured){

					$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('wk_stripe_success_status'));
					$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('wk_stripe_success_status'),$comment);

					if($cardObj->cvc_check != 'pass'){
						$comment = $this->language->get('text_cvc_chk_failed');
						$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('wk_stripe_cvc_status'),$comment,$notify);

					}elseif($cardObj->address_line1_check !='pass'){
						$comment = $this->language->get('text_address_ckeck_failed');
						$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('wk_stripe_addess_status'),$comment,$notify);

					}elseif($cardObj->address_zip_check !='pass'){
						$comment = $this->language->get('text_address_zip_ckeck_failed');
						$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('wk_stripe_zip_status'),$comment,$notify);
					}

				} else {
					$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('config_order_status_id'),$comment,$notify);
				}

				$json['continue'] = $this->url->link('checkout/success');
				$json['success'] = $this->language->get('text_success');
			}else{
				$json['error']  = $error;
			}

			$this->response->setOutput(json_encode($json));

		}				
		
	}
	
}
?>