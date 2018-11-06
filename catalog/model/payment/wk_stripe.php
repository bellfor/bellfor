<?php 
/**
	* @version [Supported opencart version 2.3.x.x.]
	* @category Webkul
	* @package Payment
	* @author [Webkul] <[<http://webkul.com/>]>
	* @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
	* @license https://store.webkul.com/license.html
*/
class ModelPaymentWkStripe extends Model {

  	public function getMethod($address, $total) {

		$this->language->load('payment/wk_stripe');

		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getGroupId();
		} else {
			$customer_group_id = 0;
		}		

		$status = true;

		if ($this->config->get('wk_stripe_min') > 0 && $this->config->get('wk_stripe_max') > 0 && ( $this->config->get('wk_stripe_min') > $total || $this->config->get('wk_stripe_max') < $total) ) {
			$status = false;
		} elseif ($this->config->get('wk_stripe_zone')) {
			if(!in_array((int)$address['zone_id'], $this->config->get('wk_stripe_zone')) AND !in_array(0, $this->config->get('wk_stripe_zone'))){
				$status = false;
			}elseif ($this->config->get('wk_stripe_customergroups')) {
				if(!in_array((int)$customer_group_id, $this->config->get('wk_stripe_customergroups'))){
					$status = false;
				}
			}else{
				$status = false;
			}	
		}else {
			$status = false;
		}	

		$stripe_curriencies = $this->config->get('wk_stripe_currency');
		if(version_compare(VERSION, '2.2.0.0', '>='))  {
			if(!isset($stripe_curriencies[trim(strtoupper($this->session->data['currency']))]) || !$stripe_curriencies[trim(strtoupper($this->session->data['currency']))]){
				$status = false;

		} else {
			if(!isset($stripe_curriencies[trim(strtoupper($this->session->data['currency']))]) || !$stripe_curriencies[trim(strtoupper($this->session->data['currency']))]){
				$status = false;
			}		
		}	
					
		$method_data = array();
	
		if ($status) {  
			$title = $this->config->get('wk_stripe_title');
      		$method_data = array( 
        		'code'       => 'wk_stripe',
        		'title'      => isset($title[$this->config->get('config_language_id')]) ? $title[$this->config->get('config_language_id')] : $this->language->get('text_title'),
				'sort_order' => $this->config->get('wk_stripe_sort_order'),
				'terms'		 => ''
      		);
    	}
   	
    	return $method_data;
  	}
}
?>