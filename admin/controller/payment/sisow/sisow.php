<?php
class ControllerPaymentSisow extends Controller {
	public $error = array();

	public function _index($payment) {
		$this->load->language('payment/sisow');

		$this->document->setTitle($this->language->get('heading_title_' . $payment));

		$this->load->model('setting/setting');

		$this->load->model('localisation/tax_class');
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		// Display Sisow ecare payment fee at checkout - sisowfocum, sisowklarna, sisowpp
		if ($payment == 'sisowfocum' || $payment == 'sisowklarna' || $payment == 'sisowpp') {
			$display_fee = false;
			$this->load->model('extension/extension');
			$totals = $this->model_extension_extension->getInstalled('total');
			foreach ($totals as $total) {
				if ($total == $payment . 'fee') {
					$display_fee = true;
					break;
				}
			}
			if (!$display_fee) {
				$this->model_extension_extension->install('total', $payment . 'fee');
				$post[$payment . 'fee_sort_order'] = 4;
				$post[$payment . 'fee_status'] = 1;
				$this->model_setting_setting->editSetting($payment . 'fee', $post);
			}
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting($payment, $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title_' . $payment);

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_version'] = $this->language->get('text_version');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_register_klarna'] = $this->language->get('text_register_klarna');
		$data['text_register_paypal'] = $this->language->get('text_register_paypal');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_login_klarna'] = $this->language->get('text_login_klarna');
		$data['text_login_paypal'] = $this->language->get('text_login_paypal');
		$data['text_compatible'] = $this->language->get('text_compatible');
		$data['text_psp'] = $this->language->get('text_psp');
		$data['text_partner'] = $this->language->get('text_partner');
		$data['text_sisow_account'] = $this->language->get('text_sisow_account');
		$data['text_sisow_add'] = $this->language->get('text_sisow_add');
		$data['text_sisow_add_info'] = $this->language->get('text_sisow_add_info');
		$data['text_sisow_profile'] = $this->language->get('text_sisow_profile');
		$data['text_sisow_login'] = $this->language->get('text_sisow_login');
		$data['text_klarna_login'] = $this->language->get('text_klarna_login');
		$data['text_klarna_add'] = $this->language->get('text_klarna_add');
		$data['text_klarna_reg'] = $this->language->get('text_klarna_reg');
		$data['text_add_klarna'] = $this->language->get('text_add_klarna');
		$data['text_add_shops'] = $this->language->get('text_add_shops');
		$data['text_add_details'] = $this->language->get('text_add_details');
		$data['text_add_pp'] = $this->language->get('text_add_pp');
		$data['text_pp_add'] = $this->language->get('text_pp_add');
		$data['text_pp_reg'] = $this->language->get('text_pp_reg');
		$data['text_klarna'] = $this->language->get('text_klarna');
		$data['text_sisow'] = $this->language->get('text_sisow');
		$data['text_paypal'] = $this->language->get('text_paypal');

		$data['help_sisow_register'] = $this->language->get('help_sisow_register');
		$data['help_sisow_login'] = $this->language->get('help_sisow_login');
		$data['help_sisow_add_info'] = $this->language->get('help_sisow_add_info');
		$data['help_merchantid'] = $this->language->get('help_merchantid');
		$data['help_merchantkey'] = $this->language->get('help_merchantkey');
		$data['help_shopid'] = $this->language->get('help_shopid');
		$data['help_order_status'] = $this->language->get('help_order_status');
		$data['help_testmode'] = $this->language->get('help_testmode');
		$data['help_total'] = $this->language->get('help_total');
		$data['help_totalmax'] = $this->language->get('help_totalmax');
		$data['help_paymentfee'] = $this->language->get('help_paymentfee');
		$data['help_businessonly'] = $this->language->get('help_businessonly');
		$data['help_days'] = $this->language->get('help_days');
		$data['help_paylink'] = $this->language->get('help_paylink');
		$data['help_ovbprefix'] = $this->language->get('help_ovbprefix');
		$data['help_tax_class'] = $this->language->get('help_tax_class');

		$data['help_pending'] = $this->language->get('help_pending');
		$data['help_klarnaid'] = $this->language->get('help_klarnaid');
		$data['help_add_shops'] = $this->language->get('help_add_shops');
		$data['help_add_details'] = $this->language->get('help_add_details');
		$data['help_author'] = $this->language->get('help_author');
		$data['help_partner'] = $this->language->get('help_partner');
		$data['help_klarna_add_info'] = $this->language->get('help_klarna_add_info');
		$data['help_klaacc_add_info'] = $this->language->get('help_klaacc_add_info');
		$data['help_add_klarna'] = $this->language->get('help_add_klarna');
		$data['help_sisow_profile_info'] = $this->language->get('help_sisow_profile_info');
		$data['help_add_pp'] = $this->language->get('help_add_pp');
		$data['help_pp_add_info'] = $this->language->get('help_pp_add_info');

		$data['entry_merchantid'] = $this->language->get('entry_merchantid');
		$data['entry_merchantkey'] = $this->language->get('entry_merchantkey');
		$data['entry_shopid'] = $this->language->get('entry_shopid');
		$data['entry_success'] = $this->language->get('entry_success');
		$data['entry_testmode'] = $this->language->get('entry_testmode');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_totalmax'] = $this->language->get('entry_totalmax');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_psp'] = $this->language->get('entry_psp');
		$data['entry_partner'] = $this->language->get('entry_partner');
		$data['entry_sisow_module'] = $this->language->get('entry_sisow_module');

		// sisowafterpay
		$data['entry_useb2b'] = $this->language->get('entry_useb2b');

		// sisowklarna, sisowklaacc, sisowfocum
		$data['entry_makeinvoice'] = $this->language->get('entry_makeinvoice');
		$data['entry_mailinvoice'] = $this->language->get('entry_mailinvoice');

		// sisowklarna, sisowklaacc, afterpay, paypal
		$data['entry_paymentfee'] = $this->language->get('entry_paymentfee');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');

		// sisowklarna, sisowklaacc
		$data['entry_pending'] = $this->language->get('entry_pending');
		$data['entry_klarnaid'] = $this->language->get('entry_klarnaid');

		// sisowovb
		$data['entry_businessonly'] = $this->language->get('entry_businessonly');
		$data['entry_days'] = $this->language->get('entry_days');
		$data['entry_paylink'] = $this->language->get('entry_paylink');
		$data['entry_ovbprefix'] = $this->language->get('entry_ovbprefix');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_register'] = $this->language->get('tab_register');
		$data['tab_support'] = $this->language->get('tab_support');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_register'] = $this->language->get('button_register');
		$data['button_login'] = $this->language->get('button_login');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['merchantid'])) {
			$data['error_merchantid'] = $this->error['merchantid'];
		} else {
			$data['error_merchantid'] = '';
		}

		if (isset($this->error['merchantkey'])) {
			$data['error_merchantkey'] = $this->error['merchantkey'];
		} else {
			$data['error_merchantkey'] = '';
		}

		if (isset($this->error['klarnaid'])) {
			$data['error_klarnaid'] = $this->error['klarnaid'];
		} else {
			$data['error_klarnaid'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_' . $payment),
			'href' => $this->url->link('payment/' . $payment, 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('payment/' . $payment, 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		// Merchant ID
		if (isset($this->request->post[$payment . '_merchantid'])) {
			$data[$payment . '_merchantid'] = $this->request->post[$payment . '_merchantid'];
		} else {
			$data[$payment . '_merchantid'] = $this->config->get($payment . '_merchantid');
		}

		// Merchant Key
		if (isset($this->request->post[$payment . '_merchantkey'])) {
			$data[$payment . '_merchantkey'] = $this->request->post[$payment . '_merchantkey'];
		} else {
			$data[$payment . '_merchantkey'] = $this->config->get($payment . '_merchantkey'); 
		}
		
		// ShopID
		if (isset($this->request->post[$payment . '_shopid'])) {
			$data[$payment . '_shopid'] = $this->request->post[$payment . '_shopid'];
		} else {
			$data[$payment . '_shopid'] = $this->config->get($payment . '_shopid'); 
		}

		// Order status
		if (isset($this->request->post[$payment . '_status_success'])) {
			$data[$payment . '_status_success'] = $this->request->post[$payment . '_status_success'];
		} else {
			$data[$payment . '_status_success'] = $this->config->get($payment . '_status_success'); 
		} 

		// Test mode
		if (isset($this->request->post[$payment . '_testmode'])) {
			$data[$payment . '_testmode'] = $this->request->post[$payment . '_testmode'];
		} else {
			$data[$payment . '_testmode'] = $this->config->get($payment . '_testmode');
		} 

		// Minimum
		if (isset($this->request->post[$payment . '_total'])) {
			$data[$payment . '_total'] = $this->request->post[$payment . '_total'];
		} else {
			$data[$payment . '_total'] = $this->config->get($payment . '_total'); 
		} 

		// Maximum
		if (isset($this->request->post[$payment . '_totalmax'])) {
			$data[$payment . '_totalmax'] = $this->request->post[$payment . '_totalmax'];
		} else {
			$data[$payment . '_totalmax'] = $this->config->get($payment . '_totalmax'); 
		} 

		// Geo Zone
		$this->load->model('localisation/geo_zone');
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post[$payment . '_geo_zone_id'])) {
			$data[$payment . '_geo_zone_id'] = $this->request->post[$payment . '_geo_zone_id'];
		} else {
			$data[$payment . '_geo_zone_id'] = $this->config->get($payment . '_geo_zone_id'); 
		} 

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		// Active y/n
		if (isset($this->request->post[$payment . '_status'])) {
			$data[$payment . '_status'] = $this->request->post[$payment . '_status'];
		} else {
			$data[$payment . '_status'] = $this->config->get($payment . '_status');
		}

		// Sort order
		if (isset($this->request->post[$payment . '_sort_order'])) {
			$data[$payment . '_sort_order'] = $this->request->post[$payment . '_sort_order'];
		} else {
			$data[$payment . '_sort_order'] = $this->config->get($payment . '_sort_order');
		}
		
		// sisowafterpay b2b
		if (isset($this->request->post[$payment . '_useb2b'])) {
			$data[$payment . '_useb2b'] = $this->request->post[$payment . '_useb2b'];
		} else {
			$data[$payment . '_useb2b'] = $this->config->get($payment . '_useb2b');
		}

		// Make invoice - sisowecare, sisowklarna, sisowklaacc, sisowfocum
		if (isset($this->request->post[$payment . '_makeinvoice'])) {
			$data[$payment . '_makeinvoice'] = $this->request->post[$payment . '_makeinvoice'];
		} else {
			$data[$payment . '_makeinvoice'] = $this->config->get($payment . '_makeinvoice');
		}

		// Mail invoice
		if (isset($this->request->post[$payment . '_mailinvoice'])) {
			$data[$payment . '_mailinvoice'] = $this->request->post[$payment . '_mailinvoice'];
		} else {
			$data[$payment . '_mailinvoice'] = $this->config->get($payment . '_mailinvoice');
		}

		// Payment fee
		if (isset($this->request->post[$payment . '_paymentfee'])) {
			$data[$payment . '_paymentfee'] = $this->request->post[$payment . '_paymentfee'];
		} else {
			$data[$payment . '_paymentfee'] = $this->config->get($payment . '_paymentfee');
		}

		// Payment fee tax class
		if (isset($this->request->post[$payment . 'fee_tax'])) {
			$data[$payment . 'fee_tax'] = $this->request->post[$payment . 'fee_tax'];
		} else {
			$data[$payment . 'fee_tax'] = $this->config->get($payment . 'fee_tax');
		}

		// Pending status sisowklarna, sisowklaacc
		if (isset($this->request->post[$payment . '_status_pending'])) {
			$data[$payment . '_status_pending'] = $this->request->post[$payment . '_status_pending'];
		} else {
			$data[$payment . '_status_pending'] = $this->config->get($payment . '_status_pending'); 
		}

		// Klarna Merchant ID
		if (isset($this->request->post[$payment . '_klarnaid'])) {
			$data[$payment . '_klarnaid'] = $this->request->post[$payment . '_klarnaid'];
		} else {
			$data[$payment . '_klarnaid'] = $this->config->get($payment . '_klarnaid'); 
		}

		// sisowovb Business only
		if (isset($this->request->post[$payment . '_businessonly'])) {
			$data[$payment . '_businessonly'] = $this->request->post[$payment . '_businessonly'];
		} else {
			$data[$payment . '_businessonly'] = $this->config->get($payment . '_businessonly');
		}

		// Days
		if (isset($this->request->post[$payment . '_days'])) {
			$data[$payment . '_days'] = $this->request->post[$payment . '_days'];
		} else {
			$data[$payment . '_days'] = $this->config->get($payment . '_days');
		}

		// Paylink
		if (isset($this->request->post[$payment . '_paylink'])) {
			$data[$payment . '_paylink'] = $this->request->post[$payment . '_paylink'];
		} else {
			$data[$payment . '_paylink'] = $this->config->get($payment . '_paylink');
		}

		// Prefix
		if (isset($this->request->post[$payment . '_prefix'])) {
			$data[$payment . '_prefix'] = $this->request->post[$payment . '_prefix'];
		} else {
			$data[$payment . '_prefix'] = $this->config->get($payment . '_prefix');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view("payment/$payment.tpl", $data));
	}

	public function _validate($payment) {
		if (!$this->user->hasPermission('modify', 'payment/' . $payment)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post[$payment . '_merchantid']) {
			$this->error['merchantid'] = $this->language->get('error_merchantid');
		}

		if (!$this->request->post[$payment . '_merchantkey']) {
			$this->error['merchantkey'] = $this->language->get('error_merchantkey');
		}
		if ($payment == 'sisowklarna' || $payment == 'sisowklaacc') {
			if (!$this->request->post[$payment . '_klarnaid']) {
				$this->error['klarnaid'] = $this->language->get('error_klarnaid');
			}
		}
		return !$this->error;
	}
}
