<?php
class ControllerModuleUmailchimp extends Controller {
	public function index($setting) {
		if ((isset($setting['name']))&&($setting['store']==$this->config->get('config_store_id'))) {
			$this->document->addScript('catalog/view/javascript/umailchimp.js');
			$data=$setting;
			$data['language_id']=$this->config->get('config_language_id');
			$stores[0] = $this->config->get('config_name');
			$this->load->model('setting/store');
			$results = $this->model_setting_store->getStores();
			foreach ($results as $result) {
			$stores[$result['store_id']] = $result['name'];
			}
			$data['store']=$stores[$this->config->get('config_store_id')];
			
			if($data['popup']==1){
			$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
			$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
			if((strpos(VERSION, '2.2')==0)&&(strpos(VERSION, '2.2')!==false)){
			return $this->load->view('module/umailchimp_popup.tpl', $data);
			}else{
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/umailchimp_popup.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/umailchimp_popup.tpl', $data);
			} else {
				return $this->load->view('default/template/module/umailchimp_popup.tpl', $data);
			}
			}
			}else{
			if((strpos(VERSION, '2.2')==0)&&(strpos(VERSION, '2.2')!==false)){
			return $this->load->view('module/umailchimp.tpl', $data);
			}else{
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/umailchimp.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/umailchimp.tpl', $data);
			} else {
				return $this->load->view('default/template/module/umailchimp.tpl', $data);
			}
			}
			}
			
		}
	}
	
	public function send() {
	if ($this->request->server['REQUEST_METHOD'] == 'POST') {
	$ret=$this->validate_form($this->request->post['mod_id']);
	if($ret['error']==''){
	$this->load->model('extension/module');
	$settings = $this->model_extension_module->getModule($this->request->post['mod_id']);
	$merge_fields=array();
	foreach($settings['fields'] as $field){
	if($field['merge_field']!='email_address')
	$merge_fields[$field['merge_field']]=$this->request->post[$field['merge_field']];
	}
	$this->load->model('setting/setting');
	$module_settings=$this->model_setting_setting->getSetting('umailchimp');
	
	$this->load->model('module/umailchimp');

	$is=$this->model_module_umailchimp->AddMCUser(array('email'=>$this->request->post['email_address'], 'type'=>$settings['name']), $merge_fields, $settings['list'], $module_settings['umailchimp_api_key']);
	if($is['status']=='subscribed'){
	$ret['success']=$settings['form_success'][$this->config->get('config_language_id')];
	}else{
	$ret['error']=$settings['form_already'][$this->config->get('config_language_id')];
	}
	}
	$this->response->addHeader('Content-Type: application/json');
	$this->response->setOutput(json_encode($ret));
	}
	}
	
	protected function validate_form($mod_id) {
		$data=array('error'=>'', 'success'=>'');
		if (($mod_id==0)||(!is_numeric($mod_id))){
			$data['error'] = 'Wrong data';
		}else{
			$this->load->model('extension/module');
			$settings = $this->model_extension_module->getModule($mod_id);
			foreach($settings['fields'] as $field){
			if(($field['merge_field']=='email_address')||($field['type_field']==1)){
			if ((utf8_strlen($this->request->post['email_address']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email_address'])) {
			$data['error'] = $settings['form_wrong_email'][$this->config->get('config_language_id')];
			}elseif(($field['merge_field']!='email_address')&&($field['type_field']==1)){
			if (utf8_strlen(trim($this->request->post[$field['merge_field']])) < 1) {
			$data['error'] = $settings['form_empty'][$this->config->get('config_language_id')];
			}
			}
			}
			}
		}
		return $data;
	}
	
	public function register($customer_id, $info='') {
	$cust_id=$customer_id;
	if(!is_numeric($customer_id))
	$cust_id=$info;
	$this->load->model('module/umailchimp');
	$customer=$this->model_module_umailchimp->getCustomer($cust_id);
	if(isset($customer['customer_id'])){
	$this->load->model('setting/setting');
	$data=$this->model_setting_setting->getSetting('umailchimp');
	$list=$this->model_module_umailchimp->getListFromRule($customer, $data['umailchimp_list_rules']);
	foreach($list['list'] as $item){
	$merge_fields=$this->model_module_umailchimp->getMergeFields($customer, $data['umailchimp_merge_fields'][$item]);

	$this->model_module_umailchimp->AddMCUser($customer, $merge_fields, $item, $data['umailchimp_api_key']);
	}
	foreach($list['workflow'] as $itm){
	if($itm!=''){
	$queue='';
	$queue=$this->model_module_umailchimp->getWorkflowInfo($data['umailchimp_api_key'], $itm);
	if($queue!='')
	$this->model_module_umailchimp->setWorkflow($customer['email'], $data['umailchimp_api_key'], $queue);
	}
	}
	}
	}
	
	public function add_order($order_id, $info='') {
	$ord_id=$order_id;
	if(!is_numeric($order_id))
	$ord_id=$info;
	$this->load->model('module/umailchimp');
	$customer=$this->model_module_umailchimp->getCustomerFromOrder($ord_id);
	if(isset($customer['customer_id'])){
	$this->load->model('setting/setting');
	$data=$this->model_setting_setting->getSetting('umailchimp');
	$list=$this->model_module_umailchimp->getListFromRule($customer, $data['umailchimp_list_rules']);
	foreach($list['list'] as $item){
	$merge_fields=$this->model_module_umailchimp->getMergeFields($customer, $data['umailchimp_merge_fields'][$item]);

	$this->model_module_umailchimp->AddMCUser($customer, $merge_fields, $item, $data['umailchimp_api_key']);
	}
	foreach($list['workflow'] as $itm){
	if($itm!=''){
	$queue='';
	$queue=$this->model_module_umailchimp->getWorkflowInfo($data['umailchimp_api_key'], $itm);
	if($queue!='')
	$this->model_module_umailchimp->setWorkflow($customer['email'], $data['umailchimp_api_key'], $queue);
	}
	}
	}
	}
}