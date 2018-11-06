<?php
class ControllerFeedZooexperte extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('feed/zooexperte');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		$this->load->model('feed/zooexperte');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('zooexperte', $this->request->post);

			$this->model_feed_zooexperte->saveSetting($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			if ((int)str_replace('.','',VERSION)>=2300)
				$this->response->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'] . '&type=feed', true));
			else
				$this->response->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
		}

		//$this->model_feed_zooexperte->install();

		$data['zooexperte_base_category'] = array();

		$google_base = $this->model_feed_zooexperte->getBaseCategory();

		foreach ($google_base as $base) {
			$data['zooexperte_base_category'][] = array (
				'taxonomy_id' => $base['taxonomy_id'],
				'status' => $base['status'],
				'name' => $base['name']
			);
		}


		$data['merchant_center_apparel_id'] = array();

		$apparel_id = $this->model_feed_zooexperte->getOptionID();

		foreach ($apparel_id as $apparel) {
			$data['merchant_center_option'][] = array (
				'option_id' => $apparel['option_id'],
				'name' => $apparel['name']
			);
		}

		if (isset($this->request->post['zooexperte_attribute'])) {
			$data['zooexperte_attribute'] = $this->request->post['zooexperte_attribute'];
		} else {
			$data['zooexperte_attribute'] = $this->config->get('zooexperte_attribute');
		}

		if (isset($this->request->post['zooexperte_attribute_type'])) {
			$data['zooexperte_attribute_type'] = $this->request->post['zooexperte_attribute_type'];
		} else {
			$data['zooexperte_attribute_type'] = $this->config->get('zooexperte_attribute_type');
		}

		if (isset($this->request->post['zooexperte_description'])) {
			$data['zooexperte_description'] = $this->request->post['zooexperte_description'];
		} else {
			$data['zooexperte_description'] = $this->config->get('zooexperte_description');
		}

		if (isset($this->request->post['zooexperte_description_html'])) {
			$data['zooexperte_description_html'] = $this->request->post['zooexperte_description_html'];
		} else {
			$data['zooexperte_description_html'] = $this->config->get('zooexperte_description_html');
		}

		$attribute_id=$this->model_feed_zooexperte->getAttributes();
		$data['merchant_center_attributes'][] = array (
			'attribute_id' => '-1',
			'name' => $this->language->get('entry_zooexperte_attribute_product')
		);
		$data['merchant_center_attributes_type'][] = array (
			'attribute_id' => '-1',
			'name' => $this->language->get('entry_zooexperte_attribute_product_type')
		);
		foreach ($attribute_id as $attribute) {
			$data['merchant_center_attributes'][] = array (
				'attribute_id' => $attribute['attribute_id'],
				'name' => $attribute['name']
			);
			$data['merchant_center_attributes_type'][] = array (
				'attribute_id' => $attribute['attribute_id'],
				'name' => $attribute['name']
			);
		}

		$data['entry_zooexperte_base'] = $this->language->get('entry_zooexperte_base');
		$data['entry_zooexperte_attribute'] = $this->language->get('entry_zooexperte_attribute');
		$data['entry_zooexperte_attribute_type'] = $this->language->get('entry_zooexperte_attribute_type');
		$data['entry_zooexperte_option'] = $this->language->get('entry_zooexperte_option');
		$data['entry_zooexperte_availability'] = $this->language->get('entry_zooexperte_availability');
		$data['entry_zooexperte_shipping_flat'] = $this->language->get('entry_zooexperte_shipping_flat');
		$data['entry_zooexperte_description'] = $this->language->get('entry_zooexperte_description');
		$data['entry_zooexperte_description_html'] = $this->language->get('entry_zooexperte_description_html');
		$data['entry_zooexperte_feed_id1'] = $this->language->get('entry_zooexperte_feed_id1');
		$data['entry_zooexperte_use_taxes'] = $this->language->get('entry_zooexperte_use_taxes');

		$data['help_zooexperte_base'] = $this->language->get('help_zooexperte_base');
		$data['help_zooexperte_attribute'] = $this->language->get('help_zooexperte_attribute');
		$data['help_zooexperte_attribute_type'] = $this->language->get('help_zooexperte_attribute_type');
		$data['help_zooexperte_option'] = $this->language->get('help_zooexperte_option');
		$data['help_zooexperte_availability'] = $this->language->get('help_zooexperte_availability');
		$data['help_zooexperte_shipping_flat'] = $this->language->get('help_zooexperte_shipping_flat');
		$data['help_zooexperte_feed_id1'] = $this->language->get('help_zooexperte_feed_id1');
		$data['help_zooexperte_use_taxes'] = $this->language->get('help_zooexperte_use_taxes');
		$data['help_data_feed'] = $this->language->get('help_data_feed');

		$data['help_file'] = $this->language->get('help_file');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_enabled_default'] = $this->language->get('text_enabled_default');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_file'] = $this->language->get('entry_file');
		$data['entry_data_feed'] = $this->language->get('entry_data_feed');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_feed'),
			'href'      => $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('feed/zooexperte', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('feed/zooexperte', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['zooexperte_status'])) {
			$data['zooexperte_status'] = $this->request->post['zooexperte_status'];
		} else {
			$data['zooexperte_status'] = $this->config->get('zooexperte_status');
		}

		if (isset($this->request->post['zooexperte_file'])) {
			$data['zooexperte_file'] = $this->request->post['zooexperte_file'];
		} else {
			$data['zooexperte_file'] = $this->config->get('zooexperte_file');
		}

		if (isset($this->request->post['zooexperte_availability'])) {
			$data['zooexperte_availability'] = $this->request->post['zooexperte_availability'];
		} else {
			$data['zooexperte_availability'] = $this->config->get('zooexperte_availability');
		}

		if (isset($this->request->post['zooexperte_option'])) {
			$data['zooexperte_option'] = $this->request->post['zooexperte_option'];
		} else {
			$data['zooexperte_option'] = $this->config->get('zooexperte_option');
		}
		if (isset($this->request->post['zooexperte_shipping_flat'])) {
			$data['zooexperte_shipping_flat'] = $this->request->post['zooexperte_shipping_flat'];
		} else {
			$data['zooexperte_shipping_flat'] = $this->config->get('zooexperte_shipping_flat');
		}

		if (isset($this->request->post['zooexperte_feed_id1'])) {
			$data['zooexperte_feed_id1'] = $this->request->post['zooexperte_feed_id1'];
		} elseif ($this->config->get('zooexperte_feed_id1')!='') {
			$data['zooexperte_feed_id1'] = $this->config->get('zooexperte_feed_id1');
		} else {
			$data['zooexperte_feed_id1'] = 'product_id';
		}

		if (isset($this->request->post['zooexperte_use_taxes'])) {
			$data['zooexperte_use_taxes'] = $this->request->post['zooexperte_use_taxes'];
		} else {
			$data['zooexperte_use_taxes'] = $this->config->get('zooexperte_use_taxes');
		}

		//fixed by oppo webiprog.com  09.02.2018

		/**
		 * http://localhost/bellfor.info_opc/index.php?route=feed/zooexperte&lang=de&curr=EUR&store=0
		 */

		$this->load->model('setting/store');
		$stores = $this->model_setting_store->getStores();

		$tupz = array();
		foreach($stores as $key => $val)
		{

		$q = $this->db->query("SELECT `value`,`key` FROM " . DB_PREFIX . "setting
		WHERE store_id = '" . $val['store_id'] . "'
		AND `code` = 'config'
		AND `key` IN ('config_name','config_language','config_currency') ORDER BY `store_id` ");

			if (!empty($q->rows) && is_array($q->rows))
			{
				foreach($q->rows as $m => $v)
				{
					$tupz[$val['store_id']][$v['key']] = $v['value'];

				}
				$tupz[$val['store_id']]['url'] = $val['url'];
				$tupz[$val['store_id']]['ssl'] = $val['ssl'];
			}
		}


		$feed_array[] = $this->config->get('config_name').PHP_EOL.HTTP_CATALOG . 'index.php?route=feed/zooexperte&lang='.$this->config->get('config_language').'&curr='.$this->config->get('config_currency').'&store='.(int)$this->config->get('config_store_id');

		foreach($tupz as $ss =>$vf) {
         $feed_array[] = $vf['config_name'].PHP_EOL.$vf['ssl'] . 'index.php?route=feed/zooexperte&lang='.$vf['config_language'].'&curr='.$vf['config_currency'].'&store='.(int)$ss;
		}

		$data['data_feed'] = implode(PHP_EOL.'----------------------------------------------------'.PHP_EOL,$feed_array);


		/*
		$data['data_feed'] = HTTP_CATALOG . 'index.php?route=feed/zooexperte&lang='.$this->config->get('config_language').'&curr='.$this->config->get('config_currency').'&store='.(int)$this->config->get('config_store_id');
		*/

		// END fixed by oppo webiprog.com  09.02.2018

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('feed/zooexperte.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'feed/zooexperte')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
