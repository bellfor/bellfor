<?php
class ControllerModuleUmailchimp extends Controller {
	private $error = array();

	public function index() {
		if (!isset($this->request->get['module_id'])) {
			$this->edit_extension();
		} else {
			$this->edit_module();
		}
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/umailchimp')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->request->post['umailchimp_api_key']) {
			$this->error['api_key'] = $this->language->get('error_api_key');
		}
		
		if(($this->request->post['umailchimp_module']['name']!='')&&($this->request->post['umailchimp_module']['list']!='')){
		$tmp=array();
		$tmp1=array();
		foreach($this->request->post['umailchimp_module']['fields'] as $field){
		if($field['merge_field']=='email_address')
		$tmp[]=$field;
		if($field['field']=='store')
		$tmp1[]=$field;
		}
		if(count($tmp1)>0){
		foreach($tmp1 as $store){
		if($store['type_field']!=2){
		$this->error['warning'] = $this->language->get('error_module_store');
		break;
		}
		}
		}
		
		if((count($tmp)!=1)||($tmp[0]['type_field']!=1))
		$this->error['warning'] = $this->language->get('error_module_email');
		}

		return !$this->error;
	}
	
	protected function validate_module() {
		if (!$this->user->hasPermission('modify', 'module/umailchimp')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if(($this->request->post['name']!='')&&($this->request->post['list']!='')){
		$tmp=array();
		$tmp1=array();
		foreach($this->request->post['fields'] as $field){
		if($field['merge_field']=='email_address')
		$tmp[]=$field;
		if($field['field']=='store')
		$tmp1[]=$field;
		}
		if(count($tmp1)>0){
		foreach($tmp1 as $store){
		if($store['type_field']!=2){
		$this->error['warning'] = $this->language->get('error_module_store1');
		break;
		}
		}
		}
		
		if((count($tmp)!=1)||($tmp[0]['type_field']!=1))
		$this->error['warning'] = $this->language->get('error_module_email1');
		}

		return !$this->error;
	}
	
	protected function getlist($api_key) {
		$ret_arr=array();
		$subdomain=explode('-', $api_key);
		if((isset($subdomain[1]))&&($subdomain[1]!='')){
		$process = curl_init('http://'.$subdomain[1].'.api.mailchimp.com/3.0/lists/');
		curl_setopt($process, CURLOPT_USERPWD, "user:$api_key");
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$response = curl_exec($process);
		curl_close($process);
		$tmp=json_decode($response);
		if(isset($tmp->lists)){
		foreach($tmp->lists as $list)
		$ret_arr[]=array('id'=>$list->id,'name'=>$list->name);
		}
		}
		return $ret_arr;
	}
	
	protected function getMergeFields($api_key, $list_id) {
		$ret_arr=array();
		$subdomain=explode('-', $api_key);
		if((isset($subdomain[1]))&&($subdomain[1]!='')){
		$process = curl_init('http://'.$subdomain[1].'.api.mailchimp.com/3.0/lists/'.$list_id.'/merge-fields/');
		curl_setopt($process, CURLOPT_USERPWD, "user:$api_key");
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$response = curl_exec($process);
		curl_close($process);
		$tmp=json_decode($response);
		if(isset($tmp->merge_fields)){
		foreach($tmp->merge_fields as $list)
		$ret_arr[]=array('id'=>$list->merge_id, 'tag'=>$list->tag,  'name'=>$list->name, 'type'=>$list->type);
		}
		}
		return $ret_arr;
	}
	
	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

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
	
	protected function getFilterTitles() {
	$data=array();
		$query1 = $this->db->query("SELECT DISTINCT title FROM " . DB_PREFIX . "mailchimp_log WHERE title!='' ORDER BY title");
		foreach($query1->rows as $item)
		$data[]=$item['title'];
		return $data;
	}
	
	protected function getFilterStatuses() {
	$data=array();
		$query1 = $this->db->query("SELECT DISTINCT status FROM " . DB_PREFIX . "mailchimp_log WHERE status!='' ORDER BY status");
		foreach($query1->rows as $item)
		$data[]=$item['status'];
		return $data;
	}
	
	protected function getFilterTypes() {
	$data=array();
		$query1 = $this->db->query("SELECT DISTINCT type FROM " . DB_PREFIX . "mailchimp_log WHERE type!='' ORDER BY type");
		foreach($query1->rows as $item)
		$data[]=$item['type'];
		return $data;
	}
	
	protected function getLogsCount() {
	$str=array();
	if((isset($this->request->get['title']))&&($this->request->get['title']!=''))
	$str[]='title="'.$this->request->get['title'].'"';
	if((isset($this->request->get['status']))&&($this->request->get['status']!=''))
	$str[]='status="'.$this->request->get['status'].'"';
	if((isset($this->request->get['type']))&&($this->request->get['type']!=''))
	$str[]='type="'.$this->request->get['type'].'"';
	$where='';
	if(count($str)>0)
	$where=' WHERE '.implode(' AND ', $str);
	$query1 = $this->db->query("SELECT COUNT(*) as cnt FROM " . DB_PREFIX . "mailchimp_log".$where);
	return $query1->row['cnt'];
	}
	
	protected function getLogs($id='', $start=0, $count=0) {
	$data=array();
	$str=array();
	if((isset($this->request->get['title']))&&($this->request->get['title']!=''))
	$str[]='title="'.$this->request->get['title'].'"';
	if((isset($this->request->get['status']))&&($this->request->get['status']!=''))
	$str[]='status="'.$this->request->get['status'].'"';
	if((isset($this->request->get['type']))&&($this->request->get['type']!=''))
	$str[]='type="'.$this->request->get['type'].'"';
	if($id!='')
	$str[]='log_id="'.$id.'"';
	$where='';
	if(count($str)>0)
	$where=' WHERE '.implode(' AND ', $str);
	$limit='';
	if($count>0)
	$limit=' LIMIT '.($start*$count).', '.$count.'';
		$query1 = $this->db->query("SELECT * FROM " . DB_PREFIX . "mailchimp_log ".$where." ORDER BY date_added DESC".$limit);
		foreach($query1->rows as $item){
		$item['merge_fields']=unserialize($item['merge_fields']);
		$tmp='';
		if((is_array($item['merge_fields']))&&(count($item['merge_fields'])>0)){
		foreach($item['merge_fields'] as $key=>$itm)
		$tmp.='<div>'.$key.': '.$itm.'</div>';
		}
		if(strpos($item['detail'], '{')!==false)
		$details=unserialize($item['detail']);
		else
		$details='';
		if(is_array($details)){
		$tmp_d='';
		if(count($details)>0){
		foreach($details as $key=>$itm)
		$tmp_d.='<div>'.$key.': '.$itm.'</div>';
		}
		$item['detail']=$tmp_d;
		}
		$item['merge_fields']=$tmp;
		$item['date_added']=date('d.m.Y H:i:s', strtotime($item['date_added']));
		if(is_numeric($item['status']))
		$item['color']='#C0C0C0';
		else
		$item['color']='#FFEF99';
		$data[]=$item;
		}
		return $data;
	}
	
	public function lines_logs() {
	$data=$this->getLogs('', $this->request->post['startFrom'], 20);
	$this->response->addHeader('Content-Type: application/json');
	$this->response->setOutput(json_encode($data));
	}
	
	public function count_logs() {
		$data=array();
		$data['count']=$this->getLogsCount();
		$data['count']=ceil($data['count']/20)-1;
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}
	
	protected function edit_extension() {
	
	$this->load->language('module/umailchimp');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			foreach($this->request->post['umailchimp_list_rules'] as $key=>$item){
				foreach($this->request->post['umailchimp_list_rules'][$key]['rules'] as $key1=>$item1){
				if(($item1['type']=='')||($item1['equal']==''))
				unset($this->request->post['umailchimp_list_rules'][$key]['rules'][$key1]);
				}
			if(count($item['rules'])==0)
			unset($this->request->post['umailchimp_list_rules'][$key]);
			}
			if(($this->request->post['umailchimp_module']['name']!='')&&($this->request->post['umailchimp_module']['list']!='')){
			$this->load->model('extension/module');
			$this->model_extension_module->addModule('umailchimp', $this->request->post['umailchimp_module']);
			$module_id=$this->db->getLastId();
			$this->request->post['umailchimp_module']['module_id']=$module_id;
			$this->model_extension_module->editModule($module_id, $this->request->post['umailchimp_module']);
			}
			unset($this->request->post['umailchimp_module']);
			$this->model_setting_setting->editSetting('umailchimp', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			if($this->request->post['refresh']==1){
			$this->response->redirect($this->url->link('module/umailchimp', 'token=' . $this->session->data['token'], 'SSL'));
			}elseif($this->request->post['refresh']==2){
			$customers=$this->getCustomers();
			$orders=$this->getCustomerFromOrder();
			$datas=$this->model_setting_setting->getSetting('umailchimp');
			$final_arr=array();
			foreach($customers as $customer){
			$list=$this->getListFromRule($customer, $datas['umailchimp_list_rules']);
			foreach($list as $item){
			$merge_fields=$this->getMerge($customer, $datas['umailchimp_merge_fields'][$item]);
			$final_arr[]=array('email_address'=>$customer['email'], 'status'=>'subscribed', 'merge_fields'=>$merge_fields, 'list'=>$item);
			}
			
			}
			foreach($orders as $order){
			$list=$this->getListFromRule($order, $datas['umailchimp_list_rules']);
			foreach($list as $item){
			$merge_fields=$this->getMerge($order, $datas['umailchimp_merge_fields'][$item]);
			$final_arr[]=array('email_address'=>$order['email'], 'status'=>'subscribed', 'merge_fields'=>$merge_fields, 'list'=>$item);
			}
			}
			$batch=array();
			foreach($final_arr as $f_arr){
			if(count($f_arr['merge_fields'])>0)
			$batch['operations'][]=array('method'=>'PUT', 'path'=>'lists/'.$f_arr['list'].'/members/'.md5(strtolower($f_arr['email_address'])), 'body'=>json_encode(array('email_address'=>$f_arr['email_address'], 'status'=>$f_arr['status'], 'merge_fields'=>$f_arr['merge_fields'])));
			else
			$batch['operations'][]=array('method'=>'PUT', 'path'=>'lists/'.$f_arr['list'].'/members/'.md5(strtolower($f_arr['email_address'])), 'body'=>json_encode(array('email_address'=>$f_arr['email_address'], 'status'=>$f_arr['status'])));
			}
			$this->sendBatch($batch, $datas['umailchimp_api_key']);
			$this->response->redirect($this->url->link('module/umailchimp', 'token=' . $this->session->data['token'], 'SSL'));
			}else{
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}
		
	
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_api_key'] = $this->language->get('entry_api_key');
		$data['entry_list'] = $this->language->get('entry_list');
		$data['entry_merge_tags'] = $this->language->get('entry_merge_tags');
		$data['entry_merge_tag'] = $this->language->get('entry_merge_tag');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_workflow'] = $this->language->get('entry_workflow');
		$data['entry_action'] = $this->language->get('entry_action');
		$data['entry_registration'] = $this->language->get('entry_registration');
		$data['entry_guest_order'] = $this->language->get('entry_guest_order');
		$data['entry_yes'] = $this->language->get('entry_yes');
		$data['entry_no'] = $this->language->get('entry_no');
		$data['entry_field'] = $this->language->get('entry_field');
		$data['entry_type_field'] = $this->language->get('entry_type_field');
		$data['entry_equal_sign'] = $this->language->get('entry_equal_sign');
		$data['entry_value'] = $this->language->get('entry_value');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_hidden'] = $this->language->get('entry_hidden');
		$data['entry_rules'] = $this->language->get('entry_rules');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_connect'] = $this->language->get('entry_connect');
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_list'] = $this->language->get('tab_list');
		$data['entry_popup'] = $this->language->get('entry_popup');
		$data['entry_subscribe_form'] = $this->language->get('entry_subscribe_form');
		$data['entry_module_name'] = $this->language->get('entry_module_name');
		$data['entry_add_list_rule'] = $this->language->get('entry_add_list_rule');
		$data['entry_module_field'] = $this->language->get('entry_module_field');
		$data['entry_synchronize'] = $this->language->get('entry_synchronize');
		$data['entry_synchron'] = $this->language->get('entry_synchron');
		$data['entry_info_general'] = $this->language->get('entry_info_general');
		$data['entry_info_list_settings'] = $this->language->get('entry_info_list_settings');
		$data['entry_info_list_in_rule'] = $this->language->get('entry_info_list_in_rule');
		$data['entry_info_workflow_in_rule'] = $this->language->get('entry_info_workflow_in_rule');
		$data['entry_info_action_in_rule'] = $this->language->get('entry_info_action_in_rule');
		$data['entry_info_rule_in_rule'] = $this->language->get('entry_info_rule_in_rule');
		$data['entry_info_merge_tags'] = $this->language->get('entry_info_merge_tags');
		$data['entry_info_module'] = $this->language->get('entry_info_module');
		$data['entry_info_module_list'] = $this->language->get('entry_info_module_list');
		$data['entry_info_module_merge'] = $this->language->get('entry_info_module_merge');
		$data['entry_info_module_field'] = $this->language->get('entry_info_module_field');
		$data['entry_info_module_type_field'] = $this->language->get('entry_info_module_type_field');
		$data['entry_info_module_name_field'] = $this->language->get('entry_info_module_name_field');
		$data['entry_popup_link'] = $this->language->get('entry_popup_link');
		$data['entry_log'] = $this->language->get('entry_log');
		$data['entry_log_filter_title'] = $this->language->get('entry_log_filter_title');
		$data['entry_log_filter_status'] = $this->language->get('entry_log_filter_status');
		$data['entry_log_filter_clear_button'] = $this->language->get('entry_log_filter_clear_button');
		$data['entry_log_email'] = $this->language->get('entry_log_email');
		$data['entry_log_merge_fields'] = $this->language->get('entry_log_merge_fields');
		$data['entry_log_details'] = $this->language->get('entry_log_details');
		$data['entry_log_type'] = $this->language->get('entry_log_type');
		$data['entry_log_date'] = $this->language->get('entry_log_date');
		$data['entry_refresh'] = $this->language->get('entry_refresh');
		$data['entry_clear_logs'] = $this->language->get('entry_clear_logs');
		
		$data['entry_form_title'] = $this->language->get('entry_form_title');
		$data['entry_form_top'] = $this->language->get('entry_form_top');
		$data['entry_form_button'] = $this->language->get('entry_form_button');
		$data['entry_form_button_loading'] = $this->language->get('entry_form_button_loading');
		$data['entry_form_empty'] = $this->language->get('entry_form_empty');
		$data['entry_form_wrong_email'] = $this->language->get('entry_form_wrong_email');
		$data['entry_form_success'] = $this->language->get('entry_form_success');
		$data['entry_form_already'] = $this->language->get('entry_form_already');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		
		$data['log_filter_titles']=$this->getFilterTitles();
		$data['log_filter_statuses']=$this->getFilterStatuses();
		$data['log_filter_types']=$this->getFilterTypes();
		$data['logs_count']=$this->getLogsCount();
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['api_key'])) {
			$data['error_api_key'] = $this->error['api_key'];
		} else {
			$data['error_api_key'] = '';
		}
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/umailchimp', 'token=' . $this->session->data['token'], 'SSL')
			);

		$data['action'] = $this->url->link('module/umailchimp', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['umailchimp_api_key'])) {
			$data['umailchimp_api_key'] = $this->request->post['umailchimp_api_key'];
		} else {
			$data['umailchimp_api_key'] = $this->config->get('umailchimp_api_key');
		}
		
		if (isset($this->request->post['umailchimp_list_rules'])) {
			$data['umailchimp_list_rules'] = $this->request->post['umailchimp_list_rules'];
		} else {
			$data['umailchimp_list_rules'] = $this->config->get('umailchimp_list_rules');
		}
		
		if (isset($this->request->post['umailchimp_merge_fields'])) {
			$data['umailchimp_merge_fields'] = $this->request->post['umailchimp_merge_fields'];
		} else {
			$data['umailchimp_merge_fields'] = $this->config->get('umailchimp_merge_fields');
		}
		
		$data['umailchimp_lists']=$this->getlist($data['umailchimp_api_key']);
		$temp=$data['umailchimp_lists'];
		foreach($temp as $key=>$item){
		$data['umailchimp_lists'][$key]['fields']=$this->getMergeFields($data['umailchimp_api_key'], $item['id']);
		}
		$data['umailchimp_list_worflows']=$this->getWorkflows($data['umailchimp_api_key']);
		$data['umailchimp_token']=$this->session->data['token'];
		
		$data['umailchimp_rule_fields']=array(
		0=>array('path'=>'firstname', 'name'=>$this->language->get('entry_firstname'), 'type'=>1),
		1=>array('path'=>'lastname', 'name'=>$this->language->get('entry_lastname'), 'type'=>1),
		2=>array('path'=>'email', 'name'=>$this->language->get('entry_email'), 'type'=>1),
		3=>array('path'=>'telephone', 'name'=>$this->language->get('entry_telephone'), 'type'=>1),
		4=>array('path'=>'fax', 'name'=>$this->language->get('entry_fax'), 'type'=>1),
		5=>array('path'=>'company', 'name'=>$this->language->get('entry_company'), 'type'=>1),
		6=>array('path'=>'address_1', 'name'=>$this->language->get('entry_address_1'), 'type'=>1),
		7=>array('path'=>'address_2', 'name'=>$this->language->get('entry_address_2'), 'type'=>1),
		8=>array('path'=>'city', 'name'=>$this->language->get('entry_city'), 'type'=>1),
		9=>array('path'=>'postcode', 'name'=>$this->language->get('entry_postcode'), 'type'=>1),
		10=>array('path'=>'country_zone_id', 'name'=>$this->language->get('entry_country'), 'type'=>2),
		11=>array('path'=>'newsletter', 'name'=>$this->language->get('entry_newsletter'), 'type'=>3),
		12=>array('path'=>'store', 'name'=>$this->language->get('entry_store'), 'type'=>4)
		);
		
		$data['umailchimp_m_fields']=array(
		0=>array('path'=>'firstname', 'name'=>$this->language->get('entry_firstname')),
		1=>array('path'=>'lastname', 'name'=>$this->language->get('entry_lastname')),
		3=>array('path'=>'telephone', 'name'=>$this->language->get('entry_telephone')),
		4=>array('path'=>'fax', 'name'=>$this->language->get('entry_fax')),
		5=>array('path'=>'company', 'name'=>$this->language->get('entry_company')),
		6=>array('path'=>'address_1', 'name'=>$this->language->get('entry_address_1')),
		7=>array('path'=>'address_2', 'name'=>$this->language->get('entry_address_2')),
		8=>array('path'=>'city', 'name'=>$this->language->get('entry_city')),
		9=>array('path'=>'postcode', 'name'=>$this->language->get('entry_postcode')),
		10=>array('path'=>'country_id', 'name'=>$this->language->get('entry_country1')),
		11=>array('path'=>'zone_id', 'name'=>$this->language->get('entry_zone')),
		12=>array('path'=>'store', 'name'=>$this->language->get('entry_store'))
		);
		
		$data['umailchimp_mod_fields']=array(
		0=>array('path'=>'', 'name'=>''),
		1=>array('path'=>'store', 'name'=>$this->language->get('entry_store'))
		);
		
		$this->load->model('localisation/country');
		$data['umailchimp_countries'] = $this->model_localisation_country->getCountries();
		
		$data['umailchimp_main_equal']=array(
		0=>array('name'=>'Equal','val'=>'equal'),
		1=>array('name'=>'Not Equal','val'=>'not_equal'),
		2=>array('name'=>'Like','val'=>'like'),
		3=>array('name'=>'Not Like','val'=>'not_like')
		);
		
		$data['umailchimp_alt_equal']=array(
		0=>array('name'=>'Equal','val'=>'equal'),
		1=>array('name'=>'Not Equal','val'=>'not_equal')
		);
		$data['umailchimp_stores'][] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default')
		);
		$this->load->model('setting/store');
		$results = $this->model_setting_store->getStores();
		foreach ($results as $result) {
			$data['umailchimp_stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name']
			);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/umailchimp.tpl', $data));
	}
	
	protected function edit_module() {
	
	$this->load->language('module/umailchimp');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate_module()) {
			$this->request->post['module_id']=$this->request->get['module_id'];
			$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit_module');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_list'] = $this->language->get('entry_list');
		$data['entry_merge_tag'] = $this->language->get('entry_merge_tag');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_workflow'] = $this->language->get('entry_workflow');
		$data['entry_yes'] = $this->language->get('entry_yes');
		$data['entry_no'] = $this->language->get('entry_no');
		$data['entry_field'] = $this->language->get('entry_field');
		$data['entry_type_field'] = $this->language->get('entry_type_field');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_hidden'] = $this->language->get('entry_hidden');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_popup'] = $this->language->get('entry_popup');
		$data['entry_module_name'] = $this->language->get('entry_module_name');
		$data['entry_module_field'] = $this->language->get('entry_module_field');
		$data['entry_form_title'] = $this->language->get('entry_form_title');
		$data['entry_form_top'] = $this->language->get('entry_form_top');
		$data['entry_form_button'] = $this->language->get('entry_form_button');
		$data['entry_form_button_loading'] = $this->language->get('entry_form_button_loading');
		$data['entry_form_empty'] = $this->language->get('entry_form_empty');
		$data['entry_form_wrong_email'] = $this->language->get('entry_form_wrong_email');
		$data['entry_form_success'] = $this->language->get('entry_form_success');
		$data['entry_form_already'] = $this->language->get('entry_form_already');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		
		$data['entry_info_module_list'] = $this->language->get('entry_info_module_list');
		$data['entry_info_module_merge'] = $this->language->get('entry_info_module_merge');
		$data['entry_info_module_field'] = $this->language->get('entry_info_module_field');
		$data['entry_info_module_type_field'] = $this->language->get('entry_info_module_type_field');
		$data['entry_info_module_name_field'] = $this->language->get('entry_info_module_name_field');
		$data['entry_popup_link_edit'] = $this->language->get('entry_popup_link_edit');

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
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/umailchimp', 'token=' . $this->session->data['token'], 'SSL')
			);

		$data['action'] = $this->url->link('module/umailchimp', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['list'])) {
			$data['list'] = $this->request->post['list'];
		} elseif (!empty($module_info)) {
			$data['list'] = $module_info['list'];
		} else {
			$data['list'] = '';
		}
		
		if (isset($this->request->post['fields'])) {
			$data['fields'] = $this->request->post['fields'];
		} elseif (!empty($module_info)) {
			$data['fields'] = $module_info['fields'];
		} else {
			$data['fields'] = '';
		}
		
		if (isset($this->request->post['store'])) {
			$data['store'] = $this->request->post['store'];
		} elseif (!empty($module_info)) {
			$data['store'] = $module_info['store'];
		} else {
			$data['store'] = '';
		}
		
		if (isset($this->request->post['popup'])) {
			$data['popup'] = $this->request->post['popup'];
		} elseif (!empty($module_info)) {
			$data['popup'] = $module_info['popup'];
		} else {
			$data['popup'] = '';
		}
		
		if (isset($this->request->post['form_title'])) {
			$data['form_title'] = $this->request->post['form_title'];
		} elseif (!empty($module_info)) {
			$data['form_title'] = $module_info['form_title'];
		} else {
			$data['form_title'] = '';
		}
		
		if (isset($this->request->post['form_top'])) {
			$data['form_top'] = $this->request->post['form_top'];
		} elseif (!empty($module_info)) {
			$data['form_top'] = $module_info['form_top'];
		} else {
			$data['form_top'] = '';
		}
		
		if (isset($this->request->post['form_button'])) {
			$data['form_button'] = $this->request->post['form_button'];
		} elseif (!empty($module_info)) {
			$data['form_button'] = $module_info['form_button'];
		} else {
			$data['form_button'] = '';
		}
		
		if (isset($this->request->post['form_button_loading'])) {
			$data['form_button_loading'] = $this->request->post['form_button_loading'];
		} elseif (!empty($module_info)) {
			$data['form_button_loading'] = $module_info['form_button_loading'];
		} else {
			$data['form_button_loading'] = '';
		}
		
		if (isset($this->request->post['form_empty'])) {
			$data['form_empty'] = $this->request->post['form_empty'];
		} elseif (!empty($module_info)) {
			$data['form_empty'] = $module_info['form_empty'];
		} else {
			$data['form_empty'] = '';
		}
		
		if (isset($this->request->post['form_wrong_email'])) {
			$data['form_wrong_email'] = $this->request->post['form_wrong_email'];
		} elseif (!empty($module_info)) {
			$data['form_wrong_email'] = $module_info['form_wrong_email'];
		} else {
			$data['form_wrong_email'] = '';
		}
		
		if (isset($this->request->post['form_success'])) {
			$data['form_success'] = $this->request->post['form_success'];
		} elseif (!empty($module_info)) {
			$data['form_success'] = $module_info['form_success'];
		} else {
			$data['form_success'] = '';
		}
		
		if (isset($this->request->post['form_already'])) {
			$data['form_already'] = $this->request->post['form_already'];
		} elseif (!empty($module_info)) {
			$data['form_already'] = $module_info['form_already'];
		} else {
			$data['form_already'] = '';
		}
		$this->load->model('setting/setting');
		$settings=$this->model_setting_setting->getSetting('umailchimp');
		$data['umailchimp_lists']=$this->getlist($settings['umailchimp_api_key']);
		$temp=$data['umailchimp_lists'];
		foreach($temp as $key=>$item){
		$data['umailchimp_lists'][$key]['fields']=$this->getMergeFields($settings['umailchimp_api_key'], $item['id']);
		}
		
		$data['umailchimp_token']=$this->session->data['token'];
		
		$data['umailchimp_mod_fields']=array(
		0=>array('path'=>'', 'name'=>''),
		1=>array('path'=>'store', 'name'=>$this->language->get('entry_store'))
		);
		

		$data['umailchimp_stores'][] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default')
		);
		$this->load->model('setting/store');
		$results = $this->model_setting_store->getStores();
		foreach ($results as $result) {
			$data['umailchimp_stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name']
			);
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('module/umailchimp_module.tpl', $data));
	}
	
	public function install() {
	$this->load->model('extension/event');
	$this->model_extension_event->addEvent('umailchimp', 'post.customer.add', 'module/umailchimp/register');
	$this->model_extension_event->addEvent('umailchimp', 'catalog/model/account/customer/addCustomer/after', 'module/umailchimp/register');
	$this->model_extension_event->addEvent('umailchimp', 'post.order.add', 'module/umailchimp/add_order');
	$this->model_extension_event->addEvent('umailchimp', 'catalog/model/checkout/order/addOrder/after', 'module/umailchimp/add_order');
	$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "mailchimp_log` (
		`log_id` int(11) NOT NULL AUTO_INCREMENT,
		`email` varchar(96) NOT NULL,
		`status` varchar(255) NOT NULL,
		`merge_fields` text NOT NULL,
		`title` text NOT NULL,
		`detail` text NOT NULL,
		`type` varchar(255) NOT NULL,
		`date_added` datetime NOT NULL,
		PRIMARY KEY (`log_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;");
	}
	
	public function uninstall() {
	$this->load->model('extension/event');
	$this->model_extension_event->deleteEvent('umailchimp');
	$this->db->query("DROP TABLE " . DB_PREFIX . "mailchimp_log");
	}
	
	
	protected function getCustomers() {
		$data=array();
		$query1 = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE status = '1'");
		foreach($query1->rows as $cust){
		$query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$cust['customer_id'] . "' AND address_id='".(int)$cust['address_id']."'");
		$this->load->model('localisation/country');
		$country = $this->model_localisation_country->getCountry($query2->row['country_id']);
		$this->load->model('localisation/zone');
		$zone = $this->model_localisation_zone->getZone($query2->row['zone_id']);
		$data[]=array('customer_id'=>$cust['customer_id'], 'type'=>'registration', 'firstname'=>$cust['firstname'], 'lastname'=>$cust['lastname'], 'email'=>$cust['email'], 'telephone'=>$cust['telephone'], 'fax'=>$cust['fax'], 'company'=>$query2->row['company'], 'address_1'=>$query2->row['address_1'], 'address_2'=>$query2->row['address_2'], 'city'=>$query2->row['city'], 'postcode'=>$query2->row['postcode'], 'country'=>$country['name'], 'country_id'=>$query2->row['country_id'], 'zone'=>$zone['name'], 'zone_id'=>$query2->row['zone_id'], 'newsletter'=>$cust['newsletter'], 'store_id'=>$cust['store_id']);
		
		}
		return $data;
	}
	
	protected function getCustomerFromOrder() {
		$data=array();
		$query1 = $this->db->query("SELECT * FROM " . DB_PREFIX . "order WHERE customer_id = 0");
		foreach($query1->rows as $cust){
		$data[md5(strtolower(trim($cust['email'])))]=array('customer_id'=>$cust['customer_id'], 'type'=>'guest_order', 'firstname'=>$cust['firstname'], 'lastname'=>$cust['lastname'], 'email'=>$cust['email'], 'telephone'=>$cust['telephone'], 'fax'=>$cust['fax'], 'company'=>$cust['payment_company'], 'address_1'=>$cust['payment_address_1'], 'address_2'=>$cust['payment_address_2'], 'city'=>$cust['payment_city'], 'postcode'=>$cust['payment_postcode'], 'country'=>$cust['payment_country'], 'country_id'=>$cust['payment_country_id'], 'zone'=>$cust['payment_zone'], 'zone_id'=>$cust['payment_zone_id'], 'store_id'=>$cust['store_id']);
		}
		return $data;
	}
	
	protected function getListFromRule($customer, $data) {
	$rls=array();
	foreach($data as $item){
	if((isset($item['action'][$customer['type']]))&&($item['action'][$customer['type']]==1))
	$rls[]=array('list'=>$item['list'], 'workflow'=>$item['workflow'], 'rules'=>$item['rules']);
	}
	$final_lists=array();
	foreach($rls as $item){
	if($this->isRightRules($customer, $item['rules'])){
	$final_lists[]=$item['list'];
	}
	}
	$final_lists=array_unique($final_lists);
	return $final_lists;
	}
	
	protected function isRightRules($customer, $rules) {
	$count_rules=count($rules);
	$wright_rules=0;
	foreach($rules as $rule){
	if(!in_array($rule['type'], array('country_zone_id', 'store', 'newsletter'))){
	if($rule['equal']=='equal'){
	if(strtolower(mb_strtolower($customer[$rule['type']]))==strtolower(mb_strtolower($rule['value'])))
	$wright_rules++;
	}elseif($rule['equal']=='not_equal'){
	if(strtolower(mb_strtolower($customer[$rule['type']]))!=strtolower(mb_strtolower($rule['value'])))
	$wright_rules++;
	}elseif($rule['equal']=='like'){
	if(strpos(strtolower(mb_strtolower($customer[$rule['type']])), strtolower(mb_strtolower($rule['value'])))!==false)
	$wright_rules++;
	}elseif($rule['equal']=='not_like'){
	if(strpos(strtolower(mb_strtolower($customer[$rule['type']])), strtolower(mb_strtolower($rule['value'])))===false)
	$wright_rules++;
	}
	
	}elseif($rule['type']=='country_zone_id'){
	$tp='country';
	if($rule['value_zone']!='')
	$tp='zone';
	if($rule['equal']=='equal'){
	if($customer[$tp.'_id']==$rule['value_'.$tp])
	$wright_rules++;
	}elseif($rule['equal']=='not_equal'){
	if($customer[$tp.'_id']!=$rule['value_'.$tp])
	$wright_rules++;
	}
	
	}elseif($rule['type']=='store'){
	if($rule['equal']=='equal'){
	if($customer['store_id']==$rule['value'])
	$wright_rules++;
	}elseif($rule['equal']=='not_equal'){
	if($customer['store_id']!=$rule['value'])
	$wright_rules++;
	}
	}elseif(($rule['type']=='newsletter')&&($customer['type']!='guest_order')){
	if($rule['equal']=='equal'){
	if($customer['newsletter']==$rule['value'])
	$wright_rules++;
	}elseif($rule['equal']=='not_equal'){
	if($customer['newsletter']!=$rule['value'])
	$wright_rules++;
	}
	}elseif(($rule['type']=='newsletter')&&($customer['type']=='guest_order')){
	$wright_rules++;
	}
	
	}
	if($count_rules==$wright_rules)
	return true;
	else
	return false;
	}
	
	protected function getMerge($customer, $data) {
	$merge_fields=array();
	$stores[0] = $this->config->get('config_name');
	$this->load->model('setting/store');
	$results = $this->model_setting_store->getStores();
	foreach ($results as $result) {
		$stores[$result['store_id']] = $result['name'];
	}
	foreach($data as $key=>$itm){
	if($itm=='country_id')
	$merge_fields[$key]=$customer['country'];
	elseif($itm=='zone_id')
	$merge_fields[$key]=$customer['zone'];
	elseif($itm=='store')
	$merge_fields[$key]=$stores[$customer['store_id']];
	else
	$merge_fields[$key]=$customer[$itm];
	}
	return $merge_fields;
	}
	
	protected function sendBatch($operations, $api_key){
	$subdomain=explode('-', $api_key);
	$subdomain=$subdomain[1];
	$operations=json_encode($operations);
	$process = curl_init('http://'.$subdomain.'.api.mailchimp.com/3.0/batches');
	curl_setopt($process, CURLOPT_USERPWD, "user:".$api_key);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($process, CURLOPT_POST, true);
	curl_setopt($process, CURLOPT_POSTFIELDS, $operations);
	curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$response = curl_exec($process);
	curl_close($process);
	$response=json_decode($response);
	$title='';
	if(isset($response->title))
	$title=$response->title;
	$id_op='';
	if(isset($response->id))
	$id_op=$response->id;
	if(isset($response->detail)){
	$detail=$response->detail;
	}else{
	$detail=array();
	if(isset($response->total_operations))
	$detail['total_operations']=$response->total_operations;
	if(isset($response->finished_operations))
	$detail['finished_operations']=$response->finished_operations;
	if(isset($response->errored_operations))
	$detail['errored_operations']=$response->errored_operations;
	$detail=serialize($detail);
	}
	$this->db->query("INSERT INTO ".DB_PREFIX."mailchimp_log SET `email`='".$id_op."', `status`='".$response->status."', `title`='".$this->db->escape($title)."', `type`='synchronize', `detail`='".$this->db->escape($detail)."', `date_added`=NOW()");
	}
	
	public function checkbatch(){
	$this->load->model('setting/setting');
	$data=$this->model_setting_setting->getSetting('umailchimp');
	$subdomain=explode('-', $data['umailchimp_api_key']);
	$subdomain=$subdomain[1];
	$process = curl_init('http://'.$subdomain.'.api.mailchimp.com/3.0/batches/'.$this->request->post['batch']);
	curl_setopt($process, CURLOPT_USERPWD, "user:".$data['umailchimp_api_key']);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$response = curl_exec($process);
	curl_close($process);
	$response=json_decode($response);
	$title='';
	if(isset($response->title))
	$title=$response->title;
	$id_op='';
	if(isset($response->id))
	$id_op=$response->id;
	if(isset($response->detail)){
	$detail=$response->detail;
	}else{
	$detail=array();
	if(isset($response->total_operations))
	$detail['total_operations']=$response->total_operations;
	if(isset($response->finished_operations))
	$detail['finished_operations']=$response->finished_operations;
	if(isset($response->errored_operations))
	$detail['errored_operations']=$response->errored_operations;
	$detail=serialize($detail);
	}
	$this->db->query("UPDATE ".DB_PREFIX."mailchimp_log SET `email`='".$id_op."', `status`='".$response->status."', `title`='".$this->db->escape($title)."', `type`='synchronize', `detail`='".$this->db->escape($detail)."' WHERE log_id='".$this->request->post['id']."'");
	
	$data=$this->getLogs($this->request->post['id']);
	$this->response->addHeader('Content-Type: application/json');
	$this->response->setOutput(json_encode($data[0]));
	}
	
	public function clear_logs(){
	$this->db->query("DELETE FROM ".DB_PREFIX."mailchimp_log");
	}
	
	protected function getWorkflows($api_key){
	$data=array();
	$subdomain=explode('-', $api_key);
	if((isset($subdomain[1]))&&($subdomain[1]!='')){
	$process = curl_init('http://'.$subdomain[1].'.api.mailchimp.com/3.0/automations');
	curl_setopt($process, CURLOPT_USERPWD, "user:".$api_key);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$response = curl_exec($process);
	curl_close($process);
	$response=json_decode($response);
	foreach($response->automations as $workflow){
	if($workflow->trigger_settings->workflow_type=='api')
	$data[]=array('id'=>$workflow->id, 'name'=>$workflow->settings->title);
	}
	}
	return $data;
	}
	
}