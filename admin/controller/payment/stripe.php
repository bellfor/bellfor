<?php
class ControllerPaymentStripe extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/stripe');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('stripe', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_authorization'] = $this->language->get('text_authorization');
		$data['text_sale'] = $this->language->get('text_sale');;

		$data['entry_test_publishable_key'] = $this->language->get('entry_test_publishable_key');
		$data['entry_test_secret_key'] = $this->language->get('entry_test_secret_key');
		$data['entry_live_publishable_key'] = $this->language->get('entry_live_publishable_key');
		$data['entry_live_secret_key'] = $this->language->get('entry_live_secret_key');
		$data['entry_test'] = $this->language->get('entry_test');
		$data['entry_test_help'] = $this->language->get('entry_test_help');
		$data['entry_transaction'] = $this->language->get('entry_transaction');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_total_help'] = $this->language->get('entry_total_help');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_prevent_duplicate_charge'] = $this->language->get('entry_prevent_duplicate_charge');
		$data['entry_prevent_duplicate_charge_help'] = $this->language->get('entry_prevent_duplicate_charge_help');
		$data['entry_journal_mode'] = $this->language->get('entry_journal_mode');
		$data['entry_journal_mode_help'] = $this->language->get('entry_journal_mode_help');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['test_publishable_key'])) {
			$data['error_test_publishable_key'] = $this->error['test_publishable_key'];
		} else {
			$data['error_test_publishable_key'] = '';
		}

		if (isset($this->error['live_publishable_key'])) {
			$data['error_live_publishable_key'] = $this->error['live_publishable_key'];
		} else {
			$data['error_live_publishable_key'] = '';
		}

		if (isset($this->error['test_secret_key'])) {
			$data['error_test_secret_key'] = $this->error['test_secret_key'];
		} else {
			$data['error_test_secret_key'] = '';
		}
		if (isset($this->error['live_secret_key'])) {
			$data['error_live_secret_key'] = $this->error['live_secret_key'];
		} else {
			$data['error_live_secret_key'] = '';
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
			 'href'      => $this->url->link('payment/stripe', 'token=' . $this->session->data['token'], 'SSL'),
			 'separator' => ' :: '
		);

		$data['action'] = $this->url->link('payment/stripe', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['stripe_test_publishable_key'])) {
			$data['stripe_test_publishable_key'] = $this->request->post['stripe_test_publishable_key'];
		} else {
			$data['stripe_test_publishable_key'] = $this->config->get('stripe_test_publishable_key');
		}
		if (isset($this->request->post['stripe_live_publishable_key'])) {
			$data['stripe_live_publishable_key'] = $this->request->post['stripe_live_publishable_key'];
		} else {
			$data['stripe_live_publishable_key'] = $this->config->get('stripe_live_publishable_key');
		}

		if (isset($this->request->post['stripe_test_secret_key'])) {
			$data['stripe_test_secret_key'] = $this->request->post['stripe_test_secret_key'];
		} else {
			$data['stripe_test_secret_key'] = $this->config->get('stripe_test_secret_key');
		}
		if (isset($this->request->post['stripe_live_secret_key'])) {
			$data['stripe_live_secret_key'] = $this->request->post['stripe_live_secret_key'];
		} else {
			$data['stripe_live_secret_key'] = $this->config->get('stripe_live_secret_key');
		}

		if (isset($this->request->post['stripe_test'])) {
			$data['stripe_test'] = $this->request->post['stripe_test'];
		} else {
			$data['stripe_test'] = $this->config->get('stripe_test');
		}

		if (isset($this->request->post['stripe_method'])) {
			$data['stripe_transaction'] = $this->request->post['stripe_transaction'];
		} else {
			$data['stripe_transaction'] = $this->config->get('stripe_transaction');
		}

		if (isset($this->request->post['stripe_total'])) {
			$data['stripe_total'] = $this->request->post['stripe_total'];
		} else {
			$data['stripe_total'] = $this->config->get('stripe_total');
		}

		if (isset($this->request->post['stripe_order_status_id'])) {
			$data['stripe_order_status_id'] = $this->request->post['stripe_order_status_id'];
		} else {
			$data['stripe_order_status_id'] = $this->config->get('stripe_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['stripe_geo_zone_id'])) {
			$data['stripe_geo_zone_id'] = $this->request->post['stripe_geo_zone_id'];
		} else {
			$data['stripe_geo_zone_id'] = $this->config->get('stripe_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['stripe_status'])) {
			$data['stripe_status'] = $this->request->post['stripe_status'];
		} else {
			$data['stripe_status'] = $this->config->get('stripe_status');
		}

		if (isset($this->request->post['stripe_sort_order'])) {
			$data['stripe_sort_order'] = $this->request->post['stripe_sort_order'];
		} else {
			$data['stripe_sort_order'] = $this->config->get('stripe_sort_order');
		}

		if (isset($this->request->post['stripe_prevent_duplicate_charge'])) {
			$data['stripe_prevent_duplicate_charge'] = $this->request->post['stripe_prevent_duplicate_charge'];
		} else {
			$data['stripe_prevent_duplicate_charge'] = $this->config->get('stripe_prevent_duplicate_charge');
		}

		if (isset($this->request->post['stripe_journal_mode'])) {
			$data['stripe_journal_mode'] = $this->request->post['stripe_journal_mode'];
		} else {
			$data['stripe_journal_mode'] = $this->config->get('stripe_journal_mode');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/stripe.tpl', $data));
	}

	protected function validate() {
		$this->request->post['stripe_test_publishable_key']=trim($this->request->post['stripe_test_publishable_key']);
		$this->request->post['stripe_test_secret_key']=trim($this->request->post['stripe_test_secret_key']);
		$this->request->post['stripe_live_publishable_key']=trim($this->request->post['stripe_live_publishable_key']);
		$this->request->post['stripe_live_secret_key']=trim($this->request->post['stripe_live_secret_key']);

		if (!$this->user->hasPermission('modify', 'payment/stripe')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (empty($this->request->post['stripe_test_publishable_key'] )) {
			$this->error['test_publishable_key'] = $this->language->get('error_test_publishable_key');
		}
		if (empty($this->request->post['stripe_test_secret_key'])) {
			$this->error['test_secret_key'] = $this->language->get('error_test_secret_key');
		}
		if (empty($this->request->post['stripe_live_publishable_key'])) {
			$this->error['live_publishable_key'] = $this->language->get('error_live_publishable_key');
		}
		if (empty($this->request->post['stripe_live_secret_key'])) {
			$this->error['live_secret_key'] = $this->language->get('error_live_secret_key');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}