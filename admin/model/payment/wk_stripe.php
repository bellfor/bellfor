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

	public function createTable(){
		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "order_stripe (
					                        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
					                        `order_id` INT(100) NOT NULL ,		                        
					                        `stripe_id` varchar(100) NOT NULL ,
					                        `customer_id` varchar(200) NOT NULL ,
					                        `description` varchar(200) NOT NULL ,
					                        `amount` int(100) NOT NULL ,
					                        `currency` varchar(100) NOT NULL ,
					                        `livemode` int(10) NOT NULL ,
					                      	`paid` int(10) NOT NULL ,
					                        `card_id` varchar(200) NOT NULL ,
					                        `brand` varchar(100) NOT NULL ,
					                        `name` varchar(100) NOT NULL ,
					                        `last4` varchar(15) NOT NULL ,
					                        `exp_month` int(10) NOT NULL ,
					                        `exp_year` int(10) NOT NULL ,
					                        `fingerprint` varchar(200) NOT NULL ,
					                        `country` varchar(100) NOT NULL ,
					                        `address1` varchar(100) NOT NULL ,
					                        `address2` varchar(15) NOT NULL ,
					                        `city` varchar(200) NOT NULL ,
					                        `state` varchar(200) NOT NULL ,
					                        `zip` varchar(100) NOT NULL ,
					                        `address_country` varchar(100) NOT NULL ,
					                        `cvc_check` varchar(15) NOT NULL ,
					                        `address_check` varchar(15) NOT NULL ,
					                        `address_zip_check` varchar(15) NOT NULL ,
					                        PRIMARY KEY (`id`) ) DEFAULT CHARSET=utf8 ;"
										); 
	}

	public function getOrderData($order_id){
		$result = $this->db->query("SELECT * FROM ".DB_PREFIX."order_stripe os WHERE os.order_id = '".(int)$order_id."'")->row;
		return $result;
	}

}
?>