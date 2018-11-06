<?php
class ControllerPaymentKsofort extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/ksofort');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('ksofort', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');

		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_order_status_canceled'] = $this->language->get('entry_order_status_canceled');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_configkey'] = $this->language->get('entry_configkey');
		$data['entry_currency'] = $this->language->get('entry_currency');

		$data['help_total'] = $this->language->get('help_total');
		$data['help_configkey'] = $this->language->get('help_configkey');
		$data['help_status_canceled'] = $this->language->get('help_status_canceled');
		$data['help_currency'] = $this->language->get('help_currency');
		$data['help_currency_bankaccount'] = $this->language->get('help_currency_bankaccount');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$this->load->model('localisation/currency');
		$data['currencies'] = $this->model_localisation_currency->getCurrencies();
		
		$data["sofortcurrencys"] = array("EUR","GBP","CHF","PLN","HUF","CZK");

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/ksofort', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('payment/ksofort', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['ksofort_total'])) {
			$data['ksofort_total'] = $this->request->post['ksofort_total'];
		} else {
			$data['ksofort_total'] = $this->config->get('ksofort_total');
		}
		
		if (isset($this->request->post['ksofort_configkey'])) {
			$data['ksofort_configkey'] = $this->request->post['ksofort_configkey'];
		} else {
			$data['ksofort_configkey'] = $this->config->get('ksofort_configkey');
		}
		
		if (isset($this->request->post['ksofort_currency'])) {
			$data['ksofort_currency'] = $this->request->post['ksofort_currency'];
		} else {
			$data['ksofort_currency'] = $this->config->get('ksofort_currency');
		}

		if (isset($this->request->post['ksofort_order_status_id'])) {
			$data['ksofort_order_status_id'] = $this->request->post['ksofort_order_status_id'];
		} else {
			$data['ksofort_order_status_id'] = $this->config->get('ksofort_order_status_id');
		}
		
		if (isset($this->request->post['ksofort_order_status_id_canceled'])) {
			$data['ksofort_order_status_id_canceled'] = $this->request->post['ksofort_order_status_id_canceled'];
		} else {
			$data['ksofort_order_status_id_canceled'] = $this->config->get('ksofort_order_status_id_canceled');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['ksofort_geo_zone_id'])) {
			$data['ksofort_geo_zone_id'] = $this->request->post['ksofort_geo_zone_id'];
		} else {
			$data['ksofort_geo_zone_id'] = $this->config->get('ksofort_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['ksofort_status'])) {
			$data['ksofort_status'] = $this->request->post['ksofort_status'];
		} else {
			$data['ksofort_status'] = $this->config->get('ksofort_status');
		}

		if (isset($this->request->post['ksofort_sort_order'])) {
			$data['ksofort_sort_order'] = $this->request->post['ksofort_sort_order'];
		} else {
			$data['ksofort_sort_order'] = $this->config->get('ksofort_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/ksofort.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/ksofort')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$sofortcurrencys = array("EUR","GBP","CHF","PLN","HUF","CZK");
		
		//if(!in_array($this->config->get('config_currency'), $sofortcurrencys) && $this->request->post['ksofort_status'] == 1)
		//{
		//	$this->error['warning'] = $this->language->get('error_sofort_currency');
		//}	

		return !$this->error;
	}
}