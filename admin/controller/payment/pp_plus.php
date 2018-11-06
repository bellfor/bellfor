<?php 
class ControllerPaymentPPPlus extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/pp_plus');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('pp_plus', $this->request->post);				

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_authorization'] = $this->language->get('text_authorization');
		$data['text_sale'] = $this->language->get('text_sale');

		$data['entry_username'] = $this->language->get('entry_username');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_signature'] = $this->language->get('entry_signature');
		$data['entry_test'] = $this->language->get('entry_test');
		$data['entry_transaction'] = $this->language->get('entry_transaction');
		$data['entry_total'] = $this->language->get('entry_total');	
		$data['entry_order_status'] = $this->language->get('entry_order_status');		
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['help_test'] = $this->language->get('help_test');
		$data['help_total'] = $this->language->get('help_total');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

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
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/pp_plus', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('payment/pp_plus', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['pp_plus_clientId'])) {
			$data['pp_plus_clientId'] = $this->request->post['pp_plus_clientId'];
		} else {
			$data['pp_plus_clientId'] = $this->config->get('pp_plus_clientId');
		}

		if (isset($this->request->post['pp_plus_secret'])) {
			$data['pp_plus_secret'] = $this->request->post['pp_plus_secret'];
		} else {
			$data['pp_plus_secret'] = $this->config->get('pp_plus_secret');
		}

		if (isset($this->request->post['pp_plus_test'])) {
			$data['pp_plus_test'] = $this->request->post['pp_plus_test'];
		} else {
			$data['pp_plus_test'] = $this->config->get('pp_plus_test');
		}

		if (isset($this->request->post['pp_plus_method'])) {
			$data['pp_plus_transaction'] = $this->request->post['pp_plus_transaction'];
		} else {
			$data['pp_plus_transaction'] = $this->config->get('pp_plus_transaction');
		}

		if (isset($this->request->post['pp_plus_total'])) {
			$data['pp_plus_total'] = $this->request->post['pp_plus_total'];
		} else {
			$data['pp_plus_total'] = $this->config->get('pp_plus_total'); 
		} 

		if (isset($this->request->post['pp_plus_order_status_id'])) {
			$data['pp_plus_order_status_id'] = $this->request->post['pp_plus_order_status_id'];
		} else {
			$data['pp_plus_order_status_id'] = $this->config->get('pp_plus_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['pp_plus_geo_zone_id'])) {
			$data['pp_plus_geo_zone_id'] = $this->request->post['pp_plus_geo_zone_id'];
		} else {
			$data['pp_plus_geo_zone_id'] = $this->config->get('pp_plus_geo_zone_id'); 
		} 

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['pp_plus_status'])) {
			$data['pp_plus_status'] = $this->request->post['pp_plus_status'];
		} else {
			$data['pp_plus_status'] = $this->config->get('pp_plus_status');
		}

		if (isset($this->request->post['pp_plus_sort_order'])) {
			$data['pp_plus_sort_order'] = $this->request->post['pp_plus_sort_order'];
		} else {
			$data['pp_plus_sort_order'] = $this->config->get('pp_plus_sort_order');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('payment/pp_plus.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/pp_plus')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['pp_plus_clientId']) {
			$this->error['username'] = $this->language->get('error_username');
		}

		if (!$this->request->post['pp_plus_secret']) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>