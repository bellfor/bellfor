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
	
	private $error = array(); 

	public function install(){
		$this->load->model('payment/wk_stripe');
		$this->model_payment_wk_stripe->createTable();
	}

	public function index() {
		
		$this->language->load('extension/payment/wk_stripe');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('wk_stripe', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('payment/wk_stripe', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['button_close'] = $this->language->get('button_close');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_stripe'] = $this->language->get('tab_stripe');
		$data['tab_checkout'] = $this->language->get('tab_checkout');
		$data['tab_status'] = $this->language->get('tab_status');
		$data['tab_subscription'] = $this->language->get('tab_subscription');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_authorization'] = $this->language->get('text_authorization');
		$data['text_all_customer'] = $this->language->get('text_all_customer');
		$data['text_live'] = $this->language->get('text_live');
		$data['text_test'] = $this->language->get('text_test');
		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');
		$data['text_image_manager'] = $this->language->get('text_image_manager');

		$data['entry_order_status'] = $this->language->get('entry_order_status');		
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_min'] = $this->language->get('entry_min');
		$data['entry_max'] = $this->language->get('entry_max');	
		$data['entry_title'] = $this->language->get('entry_title');		
		$data['entry_btn_text'] = $this->language->get('entry_btn_text');	
		$data['entry_success_status'] = $this->language->get('entry_success_status');
		$data['entry_refund_status'] = $this->language->get('entry_refund_status');
		$data['entry_zip_status'] = $this->language->get('entry_zip_status');
		$data['entry_cvc_status'] = $this->language->get('entry_cvc_status');		
		$data['entry_addess_status'] = $this->language->get('entry_addess_status');
		$data['entry_test_key'] = $this->language->get('entry_test_key');
		$data['entry_test_publish_key'] = $this->language->get('entry_test_publish_key');
		$data['entry_live_key'] = $this->language->get('entry_live_key');		
		$data['entry_live_publish_key'] = $this->language->get('entry_live_publish_key');
		$data['entry_groups'] = $this->language->get('entry_groups');
		$data['entry_webhook'] = $this->language->get('entry_webhook');
		$data['entry_stripe_mode'] = $this->language->get('entry_stripe_mode');
		$data['entry_currecny_mapping'] = $this->language->get('entry_currecny_mapping');
		$data['entry_send_customer'] = $this->language->get('entry_send_customer');
		$data['entry_store_card'] = $this->language->get('entry_store_card');		
		$data['entry_stripe_description'] = $this->language->get('entry_stripe_description');
		$data['entry_stripe_button'] = $this->language->get('entry_stripe_button');
		$data['entry_embed'] = $this->language->get('entry_embed');
		$data['entry_remember_me'] = $this->language->get('entry_remember_me');		
		$data['entry_shipping'] = $this->language->get('entry_shipping');
		$data['entry_billing'] = $this->language->get('entry_billing');
		$data['entry_stripe_logo'] = $this->language->get('entry_stripe_logo');
		$data['entry_stripe_pop_title'] = $this->language->get('entry_stripe_pop_title');
		$data['entry_stripe_pop_description'] = $this->language->get('entry_stripe_pop_description');
		$data['entry_stripe_pop_text'] = $this->language->get('entry_stripe_pop_text');
		$data['entry_subscription'] = $this->language->get('entry_subscription');
		$data['entry_subscription_guest'] = $this->language->get('entry_subscription_guest');
		$data['entry_successpayment'] = $this->language->get('entry_successpayment');
		$data['entry_streetchk'] = $this->language->get('entry_streetchk');
		$data['entry_zipchk'] = $this->language->get('entry_zipchk');		
		$data['entry_cvcchk'] = $this->language->get('entry_cvcchk');
		$data['entry_refund'] = $this->language->get('entry_refund');

		$data['entry_title_info'] = $this->language->get('entry_title_info');
		$data['entry_btn_info'] = $this->language->get('entry_btn_info');
		$data['entry_orderinfo'] = $this->language->get('entry_orderinfo');
		$data['entry_geo_zoneinfo'] = $this->language->get('entry_geo_zoneinfo');		
		$data['entry_groupsinfo'] = $this->language->get('entry_groupsinfo');
		$data['entry_keysinfo'] = $this->language->get('entry_keysinfo');
		$data['entry_webhookinfo'] = $this->language->get('entry_webhookinfo');
		$data['entry_stripe_modeinfo'] = $this->language->get('entry_stripe_modeinfo');
		$data['entry_currecny_mappinginfo'] = $this->language->get('entry_currecny_mappinginfo');		
		$data['entry_send_customerinfo'] = $this->language->get('entry_send_customerinfo');
		$data['entry_store_cardinfo'] = $this->language->get('entry_store_cardinfo');
		$data['entry_stripe_descriptioninfo'] = $this->language->get('entry_stripe_descriptioninfo');
		$data['entry_stripe_settingsinfo'] = $this->language->get('entry_stripe_settingsinfo');
		$data['entry_embedinfo'] = $this->language->get('entry_embedinfo');		
		$data['entry_remember_meinfo'] = $this->language->get('entry_remember_meinfo');
		$data['entry_shippinginfo'] = $this->language->get('entry_shippinginfo');
		$data['entry_billinginfo'] = $this->language->get('entry_billinginfo');
		$data['entry_stripe_logoinfo'] = $this->language->get('entry_stripe_logoinfo');

		$data['entry_stripe_pop_titleinfo'] = $this->language->get('entry_stripe_pop_titleinfo');
		$data['entry_stripe_pop_textinfo'] = $this->language->get('entry_stripe_pop_textinfo');
		$data['entry_stripe_pop_desinfo'] = $this->language->get('entry_stripe_pop_desinfo');
		$data['entry_subscriptioninfo'] = $this->language->get('entry_subscriptioninfo');
		$data['entry_subscription_guestinfo'] = $this->language->get('entry_subscription_guestinfo');
		$data['entry_popup_discription_placeholder'] = $this->language->get('entry_popup_discription_placeholder');
		$data['entry_popup_title_placeholder'] = $this->language->get('entry_popup_title_placeholder');
		$data['entry_popup_button_placeholder'] = $this->language->get('entry_popup_button_placeholder');
		$data['entry_tran_description_placeholder'] = $this->language->get('entry_tran_description_placeholder');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

 		if (isset($this->error['username'])) {
			$data['error_username'] = $this->error['username'];
		} else {
			$data['error_username'] = '';
		}
		
 		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}
		
 		if (isset($this->error['signature'])) {
			$data['error_signature'] = $this->error['signature'];
		} else {
			$data['error_signature'] = '';
		}		

		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/wk_stripe', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		$data['action'] = $this->url->link('payment/wk_stripe', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		$data['token'] = $this->session->data['token'];

		$this->load->model('tool/image');

		if (isset($this->request->post['wk_stripe_logo']) && is_file(DIR_IMAGE . $this->request->post['wk_stripe_logo'])) {
			$data['wk_stripe_img'] = $this->model_tool_image->resize($this->request->post['wk_stripe_logo'], 100, 100);
		} elseif ($this->config->get('wk_stripe_logo') && is_file(DIR_IMAGE . $this->config->get('wk_stripe_logo'))) {
			$data['wk_stripe_img'] = $this->model_tool_image->resize($this->config->get('wk_stripe_logo'), 100, 100);
		} else {
			$data['wk_stripe_img'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$config = array(
						'wk_stripe_status',
						'wk_stripe_sort_order',
						'wk_stripe_success_status',
						'wk_stripe_refund_status',
						'wk_stripe_zip_status',
						'wk_stripe_addess_status',
						'wk_stripe_cvc_status',
						'wk_stripe_min',
						'wk_stripe_max',
						'wk_stripe_test_key',
						'wk_stripe_test_publish_key',
						'wk_stripe_live_key',
						'wk_stripe_live_publish_key',
						'wk_stripe_webhook',
						'wk_stripe_mode',
						'wk_stripe_customer_data',
						'wk_stripe_customer_discount',
						'wk_stripe_transaction_description',
						'wk_stripe_type',
						'wk_stripe_embed',
						'wk_stripe_rememberme',
						'wk_stripe_shipping',
						'wk_stripe_billing',
						'wk_stripe_logo',						
						'wk_stripe_subscription',
						'wk_stripe_subscription_allow',
						);

		foreach($config as $value){
			if (isset($this->request->post[$value])) {
				$data[$value] = $this->request->post[$value];
			} else {
				$data[$value] = $this->config->get($value);
			}
		}

		$config_array = array( 'wk_stripe_title',
							   'wk_stripe_button_text',	
							   'wk_stripe_zone',	
							   'wk_stripe_customergroups',
							   'wk_stripe_currency',
							   'wk_stripe_popup_description',
							   'wk_stripe_popup_button',
							   'wk_stripe_popup_title',								
							 );

		foreach($config_array as $value){
			if (isset($this->request->post[$value])) {
				$data[$value] = $this->request->post[$value];
			} elseif($this->config->get($value)) {
				$data[$value] = $this->config->get($value);
			}else{
				$data[$value] = array();
			}
		}

		$this->load->model('tool/image');

		if ($data['wk_stripe_logo'] && file_exists(DIR_IMAGE . $data['wk_stripe_logo'])) {
			$data['wk_stripe_thumb'] = $this->model_tool_image->resize($data['wk_stripe_logo'], 100, 100);
		} else {
			$data['wk_stripe_thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		$this->load->model('localisation/order_status');
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->load->model('localisation/geo_zone');
										
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();	

		if (version_compare(VERSION, '2.1', '>=')) {
			$this->load->model('customer/customer_group');
			$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();		
		} else {			
			$this->load->model('sale/customer_group');
			$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		}

		$this->load->model('localisation/currency');

		$data['currencies'] = $this->model_localisation_currency->getCurrencies();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('payment/wk_stripe.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/wk_stripe')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	public function returnStripe () {
		$this->load->language('payment/wk_stripe');
		if(isset($this->request->get['order_id']) AND $this->request->get['order_id'] AND $this->validate()){
			$this->load->model('payment/wk_stripe');
			$getData = $this->model_payment_wk_stripe->getOrderData($this->request->get['order_id']);
			if($getData){
				require_once(DIR_IMAGE. '../stripe-lib/Stripe.php');
				$stripe_keys = $this->getKeys();
				Stripe::setApiKey($stripe_keys['secret_key']);
				try {
					$ch = Stripe_Charge::retrieve($getData['stripe_id']);
					$re = $ch->refunds->create();
				}catch(Stripe_Error $e) {		
					$error = $e->getMessage();
					$this->log->write('STRIPE_PAYMENRT :: Charge failed ' . $error);
				}

				if(!isset($error)){
					$this->load->model('sale/order');
					$this->model_sale_order->addOrderHistory($this->request->get['order_id'],array('order_status_id' => $this->config->get('wk_stripe_refund_status'),'comment' => '<b>Refunded</b>','notify' => false ));
					$this->session->data['success'] = $this->language->get('text_refund');
					$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'));
				}else{
					$this->session->data['error_stripe'] = $error;
					$this->redirect($this->url->link('sale/order/info&order_id='.$this->request->get['order_id'], 'token=' . $this->session->data['token'], 'SSL'));
				}
			}
		}else{
			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'));
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

}
?>