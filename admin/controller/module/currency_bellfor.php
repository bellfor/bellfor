<?php
class ControllerModuleCurrencyBellfor extends Controller {

	private $error = array();

	public function __construct($registry) {
		parent::__construct($registry);

		$this->load->language('module/currency_bellfor');

		//error_reporting(-1);
		//ini_set('display_errors', 1);
	}

	public function index() {

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_source_alphavantage'] = $this->language->get('text_source_alphavantage');
		$data['text_source_fixer'] = $this->language->get('text_source_fixer');
		$data['text_alphavantage_api_key'] = $this->language->get('text_alphavantage_api_key');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_source'] = $this->language->get('entry_source');
		$data['entry_autoupdate'] = $this->language->get('entry_autoupdate');
		$data['entry_comission'] = $this->language->get('entry_comission');
		$data['entry_debug'] = $this->language->get('entry_debug');
		$data['entry_alphavantage_api_key'] = $this->language->get('entry_alphavantage_api_key');

		$data['help_source'] = $this->language->get('help_source');
		$data['help_autoupdate'] = $this->language->get('help_autoupdate');
		$data['help_comission'] = $this->language->get('help_comission');
		$data['help_alphavantage_api_key'] = $this->language->get('help_alphavantage_api_key');

		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_update'] = $this->language->get('button_update');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {


		if (isset($this->request->post['module_currency_bellfor_code'])) {
			$this->request->post['module_currency_bellfor_code'] = serialize($this->request->post['module_currency_bellfor_code']);
		}


			$this->model_setting_setting->editSetting('module_currency_bellfor', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
		}

		if (isset($this->session->data['success'])) {
			$data['error_success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['error_success'] = '';
		}

		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['alphavantage_api_key'])) {
			$data['error_alphavantage_api_key'] = $this->error['alphavantage_api_key'];
		} else {
			$data['error_alphavantage_api_key'] = '';
		}

		if (isset($this->error['comission'])) {
			$this->data['error_comission'] = $this->error['comission'];
		} else {
			$this->data['error_comission'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/currency_bellfor', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('module/currency_bellfor', 'token=' . $this->session->data['token'], true);

		$data['update'] = $this->url->link('module/currency_bellfor/update', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

		if (isset($this->request->post['module_currency_bellfor_autoupdate'])) {
			$data['module_currency_bellfor_autoupdate'] = $this->request->post['module_currency_bellfor_autoupdate'];
		} elseif ($this->config->get('module_currency_bellfor_autoupdate')) {
			$data['module_currency_bellfor_autoupdate'] = $this->config->get('module_currency_bellfor_autoupdate');
		} else {
			$data['module_currency_bellfor_autoupdate'] = 0;
		}

		if (isset($this->request->post['module_currency_bellfor_source'])) {
			$data['module_currency_bellfor_source'] = $this->request->post['module_currency_bellfor_source'];
		} elseif ($this->config->get('module_currency_bellfor_source')) {
			$data['module_currency_bellfor_source'] = $this->config->get('module_currency_bellfor_source');
		} else {
			$data['module_currency_bellfor_source'] = 'fixer.io';
		}

		if (isset($this->request->post['module_currency_bellfor_alphavantage_api_key'])) {
			$data['module_currency_bellfor_alphavantage_api_key'] = $this->request->post['module_currency_bellfor_alphavantage_api_key'];
		} elseif ($this->config->get('module_currency_bellfor_alphavantage_api_key')) {
			$data['module_currency_bellfor_alphavantage_api_key'] = $this->config->get('module_currency_bellfor_alphavantage_api_key');
		} else {
			$data['module_currency_bellfor_alphavantage_api_key'] = '';
		}

		if (isset($this->request->post['module_currency_bellfor_comission'])) {
			$data['module_currency_bellfor_comission'] = $this->request->post['module_currency_bellfor_comission'];
		} elseif ($this->config->get('module_currency_bellfor_comission')) {
			$data['module_currency_bellfor_comission'] = $this->config->get('module_currency_bellfor_comission');
		} else {
			$data['module_currency_bellfor_comission'] = 0;
		}

		if (isset($this->request->post['module_currency_bellfor_debug'])) {
			$data['module_currency_bellfor_debug'] = $this->request->post['module_currency_bellfor_debug'];
		} elseif ($this->config->get('module_currency_bellfor_comission')) {
			$data['module_currency_bellfor_debug'] = $this->config->get('module_currency_bellfor_debug');
		} else {
			$data['module_currency_bellfor_debug'] = 0;
		}

		if (isset($this->request->post['module_currency_bellfor_status'])) {
			$data['module_currency_bellfor_status'] = $this->request->post['module_currency_bellfor_status'];
		} elseif ($this->config->get('module_currency_bellfor_status')) {
			$data['module_currency_bellfor_status'] = $this->config->get('module_currency_bellfor_status');
		} else {
			$data['module_currency_bellfor_status'] = 0;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        $data['currencies'] = array();


		$sort = 'title';
		$order = 'ASC';
		$page = 1;

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);


		$this->load->model('localisation/currency');
		$results = $this->model_localisation_currency->getCurrencies($filter_data);

		$def_currency = $this->config->get('config_currency');
		foreach ($results as $result) {
			if($result['code'] ==  $def_currency) {
				continue ;

			}
			$data['currencies'][] = array(
				'currency_id'   => $result['currency_id'],
				'title'         => $result['title'] . (($result['code'] == $this->config->get('config_currency')) ? $this->language->get('text_default') : null),
				'code'          => $result['code'],
				'value'         => $result['value'],
				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
			);
		}
		if (($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = unserialize($this->config->get('module_currency_bellfor_code'));
			//1,07
			if(is_array($module_info) && isset($module_info['CHF'])) {
				if((float)$module_info['CHF']< '7') {
					$module_info['CHF'] = '7';
				}
			}
		}

		if (isset($this->request->post['module_currency_bellfor_code'])) {
			$data['module_currency_bellfor_code'] = $this->request->post['module_currency_bellfor_code'];
		} elseif (!empty($module_info)) {
			$data['module_currency_bellfor_code'] = $module_info;
		} else {
			$data['module_currency_bellfor_code'] = array();
		}


		$this->response->setOutput($this->load->view('module/currency_bellfor.tpl', $data));
	}

	public function update() {
		$this->load->model('module/currency_bellfor');
		$status = $this->model_module_currency_bellfor->update(true);

		if ($status) {
			$this->session->data['success'] = $this->language->get('text_update_success');
		} else {
			$this->session->data['warning'] = $this->language->get('text_update_error');
		}

		$this->response->redirect($this->url->link('module/currency_bellfor', 'token=' . $this->session->data['token'], true));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/currency_bellfor')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['module_currency_bellfor_source'] == 'alphavantage.co') {
			if (strlen($this->request->post['module_currency_bellfor_alphavantage_api_key']) <= 0) {
				$this->error['alphavantage_api_key'] = $this->language->get('error_alphavantage_api_key');
			}
		}

		if (strlen($this->request->post['module_currency_bellfor_comission']) > 0) {
			preg_match_all('/^(?:\d+|\d*\.\d+)$/', $this->request->post['module_currency_bellfor_comission'], $matches, PREG_SET_ORDER, 0);
			if (empty($matches)) {
				$this->error['comission'] = $this->language->get('error_comission');
			}
		}

		return !$this->error;
	}
}