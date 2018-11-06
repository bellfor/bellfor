<?php
class ModelModuleUmailchimp extends Model {
	public function getCustomer($customer_id) {
		$data=array();
		$query1 = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		$query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "' AND address_id='".(int)$query1->row['address_id']."'");
		
		if(isset($query1->row['customer_id'])){
		$this->load->model('localisation/country');
		$country = $this->model_localisation_country->getCountry($query2->row['country_id']);
		$this->load->model('localisation/zone');
		$zone = $this->model_localisation_zone->getZone($query2->row['zone_id']);
		$data=array('customer_id'=>$customer_id, 'type'=>'registration', 'firstname'=>$query1->row['firstname'], 'lastname'=>$query1->row['lastname'], 'email'=>$query1->row['email'], 'telephone'=>$query1->row['telephone'], 'fax'=>$query1->row['fax'], 'company'=>$query2->row['company'], 'address_1'=>$query2->row['address_1'], 'address_2'=>$query2->row['address_2'], 'city'=>$query2->row['city'], 'postcode'=>$query2->row['postcode'], 'country'=>$country['name'], 'country_id'=>$query2->row['country_id'], 'zone'=>$zone['name'], 'zone_id'=>$query2->row['zone_id'], 'newsletter'=>$query1->row['newsletter'], 'store_id'=>$query1->row['store_id']);
		}
		return $data;
	}
	
	public function getCustomerFromOrder($order_id) {
		$data=array();
		$query1 = $this->db->query("SELECT * FROM " . DB_PREFIX . "order WHERE order_id = '" . (int)$order_id . "'");
		if($query1->row['customer_id']==0){
		$data=array('customer_id'=>$query1->row['customer_id'], 'type'=>'guest_order', 'firstname'=>$query1->row['firstname'], 'lastname'=>$query1->row['lastname'], 'email'=>$query1->row['email'], 'telephone'=>$query1->row['telephone'], 'fax'=>$query1->row['fax'], 'company'=>$query1->row['payment_company'], 'address_1'=>$query1->row['payment_address_1'], 'address_2'=>$query1->row['payment_address_2'], 'city'=>$query1->row['payment_city'], 'postcode'=>$query1->row['payment_postcode'], 'country'=>$query1->row['payment_country'], 'country_id'=>$query1->row['payment_country_id'], 'zone'=>$query1->row['payment_zone'], 'zone_id'=>$query1->row['payment_zone_id'], 'store_id'=>$query1->row['store_id']);
		}
		return $data;
	}
	
	public function getListFromRule($customer, $data) {
	$rls=array();
	foreach($data as $item){
	if((isset($item['action'][$customer['type']]))&&($item['action'][$customer['type']]==1))
	$rls[]=array('list'=>$item['list'], 'workflow'=>$item['workflow'], 'rules'=>$item['rules']);
	}
	$final_lists=array();
	$final_workflows=array();
	foreach($rls as $item){
	if($this->isRightRules($customer, $item['rules'])){
	$final_lists[]=$item['list'];
	$final_workflows[]=$item['workflow'];
	}
	}
	$final_lists=array_unique($final_lists);
	$final_workflows=array_unique($final_workflows);
	return array('list'=>$final_lists, 'workflow'=>$final_workflows);
	}
	
	public function getWorkflowInfo($api_key, $work){
	$subdomain=explode('-', $api_key);
	$subdomain=$subdomain[1];
	$process = curl_init('http://'.$subdomain.'.api.mailchimp.com/3.0/automations/'.$work.'/emails');
	curl_setopt($process, CURLOPT_USERPWD, "user:".$api_key);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$response = curl_exec($process);
	curl_close($process);
	$response=json_decode($response);
	return '/automations/'.$response->emails[0]->workflow_id.'/emails/'.$response->emails[0]->id.'/queue';
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
	
	public function getMergeFields($customer, $data) {
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
	
	public function AddMCUser($customer, $merge_fields, $list, $api_key){
	$subdomain=explode('-', $api_key);
	$subdomain=$subdomain[1];
	$data=array('email_address'=>$customer['email'], 'status'=>'subscribed');
	if(count($merge_fields)>0)
	$data['merge_fields']=$merge_fields;
	$data=json_encode($data);
	$process = curl_init('http://'.$subdomain.'.api.mailchimp.com/3.0/lists/'.$list.'/members/'.md5(trim(strtolower($customer['email']))));
	curl_setopt($process, CURLOPT_USERPWD, "user:".$api_key);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($process, CURLOPT_POSTFIELDS, $data);
	curl_setopt($process, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$response = curl_exec($process);
	curl_close($process);
	$response=json_decode($response);
	$new_merge=array();
	if(isset($response->merge_fields)){
	foreach($response->merge_fields as $key=>$item)
	$new_merge[$key]=$item;
	}
	$title='';
	if(isset($response->title))
	$title=$response->title;
	$detail='';
	if(isset($response->detail))
	$detail=$response->detail;
	$email_address=$customer['email'];
	if(isset($response->email_address))
	$email_address=$response->email_address;
	$this->Log(array('email_address'=>$email_address, 'merge_fields'=>$new_merge, 'status'=>$response->status, 'title'=>$title, 'detail'=>$detail, 'type'=>$customer['type']));
	return array('email_address'=>$email_address, 'merge_fields'=>$new_merge, 'status'=>$response->status, 'title'=>$title, 'detail'=>$detail, 'type'=>$customer['type']);
	}
	
	public function setWorkflow($email, $api_key, $queue){
	$data=array('email_address'=>$email);
	$data=json_encode($data);
	$subdomain=explode('-', $api_key);
	$subdomain=$subdomain[1];
	$process = curl_init('http://'.$subdomain.'.api.mailchimp.com/3.0'.$queue);
	curl_setopt($process, CURLOPT_USERPWD, "user:".$api_key);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($process, CURLOPT_POST, true);
	curl_setopt($process, CURLOPT_POSTFIELDS, $data);
	curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$response = curl_exec($process);
	curl_close($process);
	$response=json_decode($response);
	$new_merge=array();
	if(isset($response->merge_fields)){
	foreach($response->merge_fields as $key=>$item)
	$new_merge[$key]=$item;
	}
	$title='';
	if(isset($response->title))
	$title=$response->title;
	$detail='';
	if(isset($response->detail))
	$detail=$response->detail;
	$email_address=$email;
	if(isset($response->email_address))
	$email_address=$response->email_address;
	$status='';
	if(isset($response->status))
	$status=$response->status;
	$this->Log(array('email_address'=>$email_address, 'merge_fields'=>$new_merge, 'status'=>$status, 'title'=>$title, 'detail'=>$detail, 'type'=>'workflow'));
	return array('email_address'=>$email_address, 'merge_fields'=>$new_merge, 'status'=>$status, 'title'=>$title, 'detail'=>$detail, 'type'=>'workflow');
	}
	
	protected function Log($data){
	$this->db->query("INSERT INTO ".DB_PREFIX."mailchimp_log SET `email`='".$data['email_address']."', `status`='".$this->db->escape($data['status'])."', `merge_fields`='".serialize($data['merge_fields'])."', `title`='".$this->db->escape($data['title'])."', `detail`='".$this->db->escape($data['detail'])."', `type`='".$data['type']."', `date_added`=NOW()");
	}
	

}