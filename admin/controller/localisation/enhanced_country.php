<?php
class ControllerLocalisationEnhancedCountry extends Controller {
	private $error = array();

	public function index() {
		$language_data = $this->load->language('localisation/enhanced_country');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}

		$this->document->setTitle($this->language->get('breadcrumb_title'));
		$this->document->addStyle('view/template/enhancement/css/enhanced_country_zone.css?v=1.1');

		$this->load->model('localisation/enhanced_country');

		$this->getList();
	}

	public function add() {
		$language_data = $this->load->language('localisation/enhanced_country');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}

		$this->document->setTitle($this->language->get('breadcrumb_title'));

		$this->load->model('localisation/enhanced_country');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_enhanced_country->addCountry($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_geo_zone_id'])) {
				$url .= '&filter_geo_zone_id=' . $this->request->get['filter_geo_zone_id'];
			}

			if (isset($this->request->get['filter_country'])) {
				$url .= '&filter_country=' . urlencode(html_entity_decode($this->request->get['filter_country'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('localisation/enhanced_country', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$language_data = $this->load->language('localisation/enhanced_country');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}

		$this->document->setTitle($this->language->get('breadcrumb_title'));

		$this->load->model('localisation/enhanced_country');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_enhanced_country->editCountry($this->request->get['country_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_geo_zone_id'])) {
				$url .= '&filter_geo_zone_id=' . $this->request->get['filter_geo_zone_id'];
			}

			if (isset($this->request->get['filter_country'])) {
				$url .= '&filter_country=' . urlencode(html_entity_decode($this->request->get['filter_country'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('localisation/enhanced_country', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$language_data = $this->load->language('localisation/enhanced_country');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}

		$this->document->setTitle($this->language->get('breadcrumb_title'));

		$this->load->model('localisation/enhanced_country');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $country_id) {
				$this->model_localisation_enhanced_country->deleteCountry($country_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_geo_zone_id'])) {
				$url .= '&filter_geo_zone_id=' . $this->request->get['filter_geo_zone_id'];
			}

			if (isset($this->request->get['filter_country'])) {
				$url .= '&filter_country=' . urlencode(html_entity_decode($this->request->get['filter_country'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('localisation/enhanced_country', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	public function enableCountries() {
		$language_data = $this->load->language('localisation/enhanced_country');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}

		$this->load->model('localisation/enhanced_country');

		$json = array();

		if (isset($this->request->post['selected']) && $this->user->hasPermission('modify', 'localisation/enhanced_country')) {
			$enabled_count = 0;
			foreach ($this->request->post['selected'] as $country_id) {
				$country_info = $this->model_localisation_enhanced_country->getCountry($country_id);
				if ($country_info && !$country_info['status']) {
					$this->model_localisation_enhanced_country->enableCountries($country_id);
					$enabled_count++;
				}
			}
			$json['success'] = sprintf($this->language->get('text_success_country_enabled'), $enabled_count);
		} else {
			$json['failed'] = $this->language->get('error_permission');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function disableCountries() {
		$language_data = $this->load->language('localisation/enhanced_country');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}

		$this->load->model('localisation/enhanced_country');

		$json = array();

		if (isset($this->request->post['selected']) && $this->user->hasPermission('modify', 'localisation/enhanced_country')) {
			$disabled_count = 0;
			foreach ($this->request->post['selected'] as $country_id) {
				$country_info = $this->model_localisation_enhanced_country->getCountry($country_id);
				if ($country_info && $country_info['status']) {
					$this->model_localisation_enhanced_country->disableCountries($country_id);
					$disabled_count++;
				}
			}
			$json['success'] = sprintf($this->language->get('text_success_country_disabled'), $disabled_count);
		} else {
			$json['failed'] = $this->language->get('error_permission');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function getList() {
		$language_data = $this->load->language('localisation/enhanced_country');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}

		if (isset($this->request->get['filter_geo_zone_id'])) {
			$filter_geo_zone_id = $this->request->get['filter_geo_zone_id'];
		} else {
			$filter_geo_zone_id = null;
		}

		if (isset($this->request->get['filter_country'])) {
			$filter_country = $this->request->get['filter_country'];
		} else {
			$filter_country = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_geo_zone_id'])) {
			$url .= '&filter_geo_zone_id=' . $this->request->get['filter_geo_zone_id'];
		}

		if (isset($this->request->get['filter_country'])) {
			$url .= '&filter_country=' . urlencode(html_entity_decode($this->request->get['filter_country'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrumb_title'),
			'href' => $this->url->link('localisation/enhanced_country', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('localisation/enhanced_country/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('localisation/enhanced_country/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['countries'] = array();

		$filter_data = array(
			'filter_geo_zone_id' => $filter_geo_zone_id,
			'filter_country' => $filter_country,
			'filter_status' => $filter_status,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$country_total = $this->model_localisation_enhanced_country->getTotalCountries($filter_data);

		$results = $this->model_localisation_enhanced_country->getCountries($filter_data);

		$this->load->model('localisation/enhanced_zone');

		foreach ($results as $result) {
			$data['countries'][] = array(
				'country_id' => $result['country_id'],
				'name'       => $result['name'] . (($result['country_id'] == $this->config->get('config_country_id')) ? $this->language->get('text_default') : null),
				'iso_code_2' => $result['iso_code_2'],
				'iso_code_3' => $result['iso_code_3'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled2') : $this->language->get('text_disabled2')),
				'postcode'   => ($result['postcode_required'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'zones'      => $this->model_localisation_enhanced_zone->getTotalZonesByCountryId($result['country_id']),
				'list_zones' => $this->url->link('localisation/enhanced_zone', 'token=' . $this->session->data['token'] . '&filter_country=' . urlencode(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), true),
				'edit'       => $this->url->link('localisation/enhanced_country/edit', 'token=' . $this->session->data['token'] . '&country_id=' . $result['country_id'] . $url, true)
			);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_geo_zone_id'])) {
			$url .= '&filter_geo_zone_id=' . $this->request->get['filter_geo_zone_id'];
		}

		if (isset($this->request->get['filter_country'])) {
			$url .= '&filter_country=' . urlencode(html_entity_decode($this->request->get['filter_country'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('localisation/enhanced_country', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_iso_code_2'] = $this->url->link('localisation/enhanced_country', 'token=' . $this->session->data['token'] . '&sort=iso_code_2' . $url, true);
		$data['sort_iso_code_3'] = $this->url->link('localisation/enhanced_country', 'token=' . $this->session->data['token'] . '&sort=iso_code_3' . $url, true);
		$data['sort_status'] = $this->url->link('localisation/enhanced_country', 'token=' . $this->session->data['token'] . '&sort=status' . $url, true);
		$data['sort_postcode'] = $this->url->link('localisation/enhanced_country', 'token=' . $this->session->data['token'] . '&sort=postcode_required' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_geo_zone_id'])) {
			$url .= '&filter_geo_zone_id=' . $this->request->get['filter_geo_zone_id'];
		}

		if (isset($this->request->get['filter_country'])) {
			$url .= '&filter_country=' . urlencode(html_entity_decode($this->request->get['filter_country'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $country_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('localisation/enhanced_country', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($country_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($country_total - $this->config->get('config_limit_admin'))) ? $country_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $country_total, ceil($country_total / $this->config->get('config_limit_admin')));

		$this->load->model('localisation/geo_zone');
    	$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$data['filter_geo_zone_id'] = $filter_geo_zone_id;
		$data['filter_country'] = $filter_country;
		$data['filter_status'] = $filter_status;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['zone_manager'] = $this->url->link('localisation/enhanced_zone', 'token=' . $this->session->data['token'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('localisation/enhanced_country_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['country_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_iso_code_2'] = $this->language->get('entry_iso_code_2');
		$data['entry_iso_code_3'] = $this->language->get('entry_iso_code_3');
		$data['entry_address_format'] = $this->language->get('entry_address_format');
		$data['entry_postcode_required'] = $this->language->get('entry_postcode_required');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['help_address_format'] = $this->language->get('help_address_format');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_geo_zone_id'])) {
			$url .= '&filter_geo_zone_id=' . $this->request->get['filter_geo_zone_id'];
		}

		if (isset($this->request->get['filter_country'])) {
			$url .= '&filter_country=' . urlencode(html_entity_decode($this->request->get['filter_country'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('breadcrumb_title'),
			'href' => $this->url->link('localisation/enhanced_country', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['country_id'])) {
			$data['action'] = $this->url->link('localisation/enhanced_country/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('localisation/enhanced_country/edit', 'token=' . $this->session->data['token'] . '&country_id=' . $this->request->get['country_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('localisation/enhanced_country', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['country_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$country_info = $this->model_localisation_enhanced_country->getCountry($this->request->get['country_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($country_info)) {
			$data['name'] = $country_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['iso_code_2'])) {
			$data['iso_code_2'] = $this->request->post['iso_code_2'];
		} elseif (!empty($country_info)) {
			$data['iso_code_2'] = $country_info['iso_code_2'];
		} else {
			$data['iso_code_2'] = '';
		}

		if (isset($this->request->post['iso_code_3'])) {
			$data['iso_code_3'] = $this->request->post['iso_code_3'];
		} elseif (!empty($country_info)) {
			$data['iso_code_3'] = $country_info['iso_code_3'];
		} else {
			$data['iso_code_3'] = '';
		}

		if (isset($this->request->post['address_format'])) {
			$data['address_format'] = $this->request->post['address_format'];
		} elseif (!empty($country_info)) {
			$data['address_format'] = $country_info['address_format'];
		} else {
			$data['address_format'] = '';
		}

		if (isset($this->request->post['postcode_required'])) {
			$data['postcode_required'] = $this->request->post['postcode_required'];
		} elseif (!empty($country_info)) {
			$data['postcode_required'] = $country_info['postcode_required'];
		} else {
			$data['postcode_required'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($country_info)) {
			$data['status'] = $country_info['status'];
		} else {
			$data['status'] = '1';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('localisation/enhanced_country_form.tpl', $data));
	}

	public function updateStatus() {
		$language_data = $this->load->language('localisation/enhanced_country');
		foreach($language_data as $key=>$value){
			$data[$key] = $value;
		}
		$this->load->model('localisation/enhanced_country');
		$output='';
		if(isset($this->request->get['object_id'])){
			$get_request = explode('-',$this->request->get['object_id']);
			if(count($get_request)==2){
				$column_name = $get_request[0];
				$country_id = $get_request[1];
				$result = $this->model_localisation_enhanced_country->getCountry($country_id);
				if($result[$column_name]){
					$this->model_localisation_enhanced_country->updateStatus($country_id, $column_name, 0);
				} else {
					$this->model_localisation_enhanced_country->updateStatus($country_id, $column_name, 1);
				}
				$result = $this->model_localisation_enhanced_country->getCountry($country_id);
				$output = $result[$column_name] ? $this->language->get('text_enabled2') : $this->language->get('text_disabled2');
			}
		}
		$this->response->setOutput($output);
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'localisation/enhanced_country')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 128)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localisation/enhanced_country')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('setting/store');
		$this->load->model('customer/customer');
		$this->load->model('marketing/affiliate');
		$this->load->model('localisation/zone');
		$this->load->model('localisation/geo_zone');

		foreach ($this->request->post['selected'] as $country_id) {
			if ($this->config->get('config_country_id') == $country_id) {
				$this->error['warning'] = $this->language->get('error_default');
			}

			$store_total = $this->model_setting_store->getTotalStoresByCountryId($country_id);

			if ($store_total) {
				$this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
			}

			$address_total = $this->model_customer_customer->getTotalAddressesByCountryId($country_id);

			if ($address_total) {
				$this->error['warning'] = sprintf($this->language->get('error_address'), $address_total);
			}

			$affiliate_total = $this->model_marketing_affiliate->getTotalAffiliatesByCountryId($country_id);

			if ($affiliate_total) {
				$this->error['warning'] = sprintf($this->language->get('error_affiliate'), $affiliate_total);
			}

			$zone_total = $this->model_localisation_zone->getTotalZonesByCountryId($country_id);

			if ($zone_total) {
				$this->error['warning'] = sprintf($this->language->get('error_zone'), $zone_total);
			}

			$zone_to_geo_zone_total = $this->model_localisation_geo_zone->getTotalZoneToGeoZoneByCountryId($country_id);

			if ($zone_to_geo_zone_total) {
				$this->error['warning'] = sprintf($this->language->get('error_zone_to_geo_zone'), $zone_to_geo_zone_total);
			}
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_country'])) {
			$filter_country = $this->request->get['filter_country'];
		} else {
			$filter_country = '';
		}

		$this->load->model('localisation/enhanced_country');

		$filter_data = array(
			'filter_country'  => $filter_country,
			'start'        => 0,
			'limit'        => 5
		);

		$results = $this->model_localisation_enhanced_country->getCountries($filter_data);

		foreach ($results as $result) {
			$json[] = array(
				'country_id' => $result['country_id'],
				'name'       => $result['name']
			);
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/enhanced_country');

		$country_info = $this->model_localisation_enhanced_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}