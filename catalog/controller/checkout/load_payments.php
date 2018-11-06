<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt
if(!function_exists('money_format')) {
function money_format ($frmt, $val) {
	$price = number_format($val, 2);
	$price = $price." EUR";
	return $price;
}
}
class ControllerCheckoutLoadPayments extends Controller {
	public function index() {

	$this->load->language('checkout/checkout');
    $this->load->language('checkout/onepagecheckout');
    $this->load->language('payments/pp_plus');

    $this->load->model('localisation/country');
	$data['countries'] = $this->model_localisation_country->getCountries();

	$country_codes = array();
	foreach ($data['countries'] as $countrydata)
	{
		$country_codes[$countrydata['country_id']] = array('iso_code_2' => $countrydata['iso_code_2'], 'name' => $countrydata['name']);
	}

		if ($this->validate_form()) {
			// Totals
			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();

			$this->load->model('extension/extension');

			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);

					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}


 //Payment address

			$this->session->data['payment_address'] = array();
			$this->session->data['payment_address']['zone_id'] = '';
			$this->session->data['payment_address']['custom_field'] = '';
			$this->session->data['payment_address']['email'] =  $this->request->post['email'];




                    $this->session->data['payment_address']['country_id'] = $this->request->post['country_id'];

                    $this->session->data['payment_address']['city'] = $this->request->post['city'];

                    $this->session->data['payment_address']['postcode'] = $this->request->post['zip'];

                    $this->session->data['payment_address']['address_1'] = $this->request->post['address_1'];

                    $this->session->data['payment_address']['firstname'] = $this->request->post['firstname'];

                    $this->session->data['payment_address']['lastname'] = $this->request->post['lastname'];

                    $this->session->data['payment_address']['telephone'] = $this->request->post['telephone'];



                $this->session->data['payment_address']['iso_code_2'] = $country_codes[$this->session->data['payment_address']['country_id']]['iso_code_2'];
                $this->session->data['payment_address']['country'] = $country_codes[$this->session->data['payment_address']['country_id']]['name'];
				} else {

         //fixed by oppo webiprog.com  07.02.2018 MAR-128 Please fill in all the form fields
		 echo '<h3>'.$this->language->get('text_fill_out_all_form_fields').'<br /></h3>';
		 echo '<script type="text/javascript">';
		 if (!empty($this->errors['firstname'])) {
		 echo '$(\'#firstname-ch+.error\').html(\''.$this->language->get('error_firstname').'\');';
		 } else {
		 echo '$(\'#firstname-ch+.error\').html(\'\');';
		 }

		 if (!empty($this->errors['lastname'])) {
		 echo '$(\'#lastname-ch+.error\').html(\''.$this->language->get('error_lastname').'\');';
		 } else {
		 echo '$(\'#lastname-ch+.error\').html(\'\');';
		 }

		 if (!empty($this->errors['email'])) {
		 echo '$(\'#email-ch+.error\').html(\''.$this->language->get('error_email').'\');';
		 } else {
		 echo '$(\'#email-ch+.error\').html(\'\');';
		 }

		 if (!empty($this->errors['country_id'])) {
		 echo '$(\'#input-payment-country+.error\').html(\''.$this->language->get('error_country').'\');';
		 } else {
		 echo '$(\'#input-payment-country+.error\').html(\'\');';
		 }

		 if (!empty($this->errors['address_1'])) {
		 echo '$(\'#address_1-ch+.error\').html(\''.$this->language->get('error_address_1').'\');';
		 } else {
		 echo '$(\'#address_1-ch+.error\').html(\'\');';
		 }

		 if (!empty($this->errors['city'])) {
		 echo '$(\'#city-ch+.error\').html(\''.$this->language->get('error_city').'\');';
		 } else {
		 echo '$(\'#city-ch+.error\').html(\'\');';
		 }

		 if (!empty($this->errors['zip'])) {
		 echo '$(\'#zip-ch+.error\').html(\''.$this->language->get('error_postcode').'\');';
		 } else {
		 echo '$(\'#zip-ch+.error\').html(\'\');';
		 }

		 echo '</script>';
         die();
				}



			// Payment Methods
			$method_data = array();

			$this->load->model('extension/extension');

			$results = $this->model_extension_extension->getExtensions('payment');

			$recurring = $this->cart->hasRecurringProducts();

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('payment/' . $result['code']);

					$method = $this->{'model_payment_' . $result['code']}->getMethod($this->session->data['payment_address'], $total);

					if ($method) {
						if ($recurring) {
							if (method_exists($this->{'model_payment_' . $result['code']}, 'recurringPayments') && $this->{'model_payment_' . $result['code']}->recurringPayments()) {
								$method_data[$result['code']] = $method;
							}
						} else {
							$method_data[$result['code']] = $method;
						}
					}
				}
			}

			$sort_order = array();

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $method_data);

			$this->session->data['payment_methods'] = $method_data;


           //Paypal Plus
			if($this->config->get('pp_plus_test') == 1)
			{
				$data['pp_plus_mode'] = ".sandbox";
			} else {
				$data['pp_plus_mode'] = "";
			}

			$this->load->language('payment/pp_plus');
			$data['ppp_notification'] = $this->language->get('ppp_notification');

			//!!! Language
			$data['language'] = 'DE';
			$data['country'] = $this->session->data['payment_address']['iso_code_2'];

			$data['pp_plus_link'] = $this->sentData($this->getToken(), $total);


			$data['language'] = str_replace("-", "_", $this->config->get('config_language'));
			//Paypal Plus END

		$data['text_payment_method'] = $this->language->get('text_payment_method');
		$data['text_comments'] = $this->language->get('text_comments');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_cart'] = $this->language->get('text_cart');

		$data['button_continue'] = $this->language->get('button_continue');

		if (empty($this->session->data['payment_methods'])) {
			$data['error_warning'] = sprintf($this->language->get('error_no_payment'), $this->url->link('information/contact'));
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['payment_methods'])) {
			$data['payment_methods'] = $this->session->data['payment_methods'];
		} else {
			$data['payment_methods'] = array();
		}

		if (isset($this->session->data['payment_method']['code'])) {
			$data['code'] = $this->session->data['payment_method']['code'];
		} else {
			$data['code'] = '';
		}


		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));

			if ($information_info) {
				$data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('config_checkout_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$data['text_agree'] = '';
			}
		} else {
			$data['text_agree'] = '';
		}

		if (isset($this->session->data['agree'])) {
			$data['agree'] = $this->session->data['agree'];
		} else {
			$data['agree'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/load_payments.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/load_payments.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/checkout/load_payments.tpl', $data));
		}

	}

    public function validate_form()
    {

        $this->error = [];
        if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 42)) {

            $data['error']['firstname'] = $this->language->get('error_firstname');
        }

        if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 42)) {

            $data['error']['lastname'] = $this->language->get('error_lastname');
        }

        if ((utf8_strlen(trim($this->request->post['email'])) < 6) || (!strpos($this->request->post['email'], '@'))) {
            //var_dump($this->request->post['telephone']);exit;
            $data['error']['email'] = $this->language->get('error_email');
        }

        if (!isset($this->request->post['country_id']) || (int)$this->request->post['country_id'] == 0) {
            //var_dump($this->request->post['country_id']);exit;
            $data['error']['country_id'] = $this->language->get('error_country');

        }

        if ((utf8_strlen(trim($this->request->post['address_1'])) < 1) || (utf8_strlen(trim($this->request->post['address_1'])) > 92)) {
            $data['error']['address_1'] = $this->language->get('error_address_1');
        }
        if ((utf8_strlen(trim($this->request->post['city'])) < 1) || (utf8_strlen(trim($this->request->post['city'])) > 32)) {
            $data['error']['city'] = $this->language->get('error_city');
        }
        if ((utf8_strlen(trim($this->request->post['zip'])) < 1) || (utf8_strlen(trim($this->request->post['zip'])) > 7)) {
            $data['error']['zip'] = $this->language->get('error_zip');
        }
        if (!empty($data['error'])) {
            $this->errors = $data['error'];
            return false;
        } else
            return true;
    }

			public function getToken()
			{
				$clientId = $this->config->get('pp_plus_clientId');
				$secret = $this->config->get('pp_plus_secret');

				if($this->config->get('pp_plus_test') == 1)
				{
					$mode= ".sandbox";
				} else {
					$mode= "";
				}

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://api".$mode.".paypal.com/v1/oauth2/token");
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
				curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
				$result = curl_exec($ch);
				$json = json_decode($result);
				$access_token=$json->access_token;
				curl_close($ch);

				return $access_token;
			}

			public function sentData($token, $total)
			{
				$tax_total = $this->cart->getTaxes();
				$tax = 0; // initialize tax;
				foreach($tax_total as $value){
				 $tax += $value;
				}
				$tax = money_format('%i', $tax);

                if ($this->currency->getDefaultCode() != $this->session->data['currency']){
                    $total = $this->currency->convert($total, $this->currency->getDefaultCode(), $this->session->data['currency']);
                }

				$total = money_format('%i', $total);
				//$shipping = $this->tax->calculate($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id'], $this->config->get('config_tax'));
				//$shipping = money_format('%i', $shipping);

				//$subtotal = $total - $shipping - $tax;

				if($this->config->get('pp_plus_test') == 1)
				{
					$mode= ".sandbox";
				} else {
					$mode= "";
				}

				$currency = $this->session->data['currency'];

				$order_data = array();

				if ($this->customer->isLogged()) {
					$this->load->model('account/customer');

					//$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

					$order_data['customer_id'] = $this->customer->getId();
                    $customer_info = $this->model_account_customer->getCustomer($order_data['customer_id']);
					$order_data['customer_group_id'] = $customer_info['customer_group_id'];
					$order_data['firstname'] = $customer_info['firstname'];
					$order_data['lastname'] = $customer_info['lastname'];
					$order_data['email'] = $customer_info['email'];
					$order_data['telephone'] = $customer_info['telephone'];
					$order_data['fax'] = $customer_info['fax'];
					$order_data['custom_field'] = json_decode($customer_info['custom_field'], true);
				} elseif (isset($this->session->data['guest'])) {
					$order_data['customer_id'] = 0;
					$order_data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
					$order_data['firstname'] = $this->session->data['payment_address']['firstname'];
					$order_data['lastname'] = $this->session->data['payment_address']['lastname'];
					$order_data['email'] = $this->session->data['payment_address']['email'];
					$order_data['telephone'] = $this->session->data['payment_address']['telephone'];
					$order_data['fax'] = '';
					$order_data['custom_field'] = $this->session->data['payment_address']['custom_field'];
				}

				if (!isset($this->session->data['payment_address']))
				{
					$this->session->data['payment_address'] = $this->session->data['shipping_address'];
				}

				//Set country code

					$this->load->model('localisation/country');
		                $data['countries'] = $this->model_localisation_country->getCountries();
                        $countries_arr = array();
	                	foreach($data['countries'] as $country_val){
	                	$countries_arr[$country_val['country_id']] = array('name' => $country_val['name'], 'iso_code_2' => $country_val['iso_code_2']);
	                 	}


				$this->session->data['payment_address']['iso_code_2'] = $countries_arr[$this->session->data['payment_address']['country_id']]['iso_code_2'];
				$code = $this->session->data['payment_address']['iso_code_2'];
                $this->session->data['payment_address']['country'] = $countries_arr[$this->session->data['payment_address']['country_id']]['name'];

				//Set address fields


					$firstname = $this->session->data['payment_address']['firstname'];

					$lastname = $this->session->data['payment_address']['lastname'];

					$address_1 = $this->session->data['payment_address']['address_1'];

				$address_2 = '';

					$city = $this->session->data['payment_address']['city'];

					$postcode = $this->session->data['payment_address']['postcode'];


				$fields = '{
				"intent":"sale",
				"redirect_urls":{
				  "return_url":"'.$this->url->link('checkout/success', '', true).'",
				  "cancel_url":"'.$this->url->link('checkout/onepagecheckout', '', true).'"
				},
				"payer":{
				  "payment_method":"paypal",
				  "payer_info":{
					"first_name":"'.$firstname.'",
					"last_name":"'.$lastname.'",
					"billing_address":{
						"line1":"'.$address_1.'",
						"line2":"'.$address_2.'",
						"city":"'.$city .'",
						"postal_code":"'.$postcode.'",
						"country_code":"'.$code.'"
					}
				  }
				},
				"transactions":[
				{
				  "amount":{
					"total":"'.$total.'",
					"currency":"'.$currency.'"

				  },
					"item_list":{';


					$order_data['shipping_firstname'] = $this->session->data['payment_address']['firstname'];
					$order_data['shipping_lastname'] = $this->session->data['payment_address']['lastname'];
					$order_data['shipping_company'] = '';
					$order_data['shipping_address_1'] = $this->session->data['payment_address']['address_1'];
					$order_data['shipping_address_2'] = '';
					$order_data['shipping_city'] = $this->session->data['payment_address']['city'];
					$order_data['shipping_postcode'] = $this->session->data['payment_address']['postcode'];
					$order_data['shipping_zone'] = '';
					$order_data['shipping_zone_id'] = '';
					$order_data['shipping_country'] = '';
					$order_data['iso_code_2'] = $this->session->data['payment_address']['iso_code_2'];


				$code = $order_data['iso_code_2'];

				$fields .= '
						  "shipping_address":{
						  "recipient_name":"'.$order_data['shipping_firstname'].' '.$order_data['shipping_lastname'].'",
						  "line1":"'.$order_data['shipping_address_1'].'",
						  "line2":"'.$order_data['shipping_address_2'].'",
						  "city":"'.$order_data['shipping_city'].'",
						  "postal_code":"'.$order_data['shipping_postcode'].'",
						  "country_code":"'.$code.'"
						}
					},
				  "description":"Warenkorb"
				}
				]
				}';

				if($this->config->get('pp_plus_test') == 1)
				{
					$mode= ".sandbox";
				} else {
					$mode= "";
				}

				$ch = curl_init();
				$headers=array('Content-Type:application/json','Authorization:Bearer '.$token);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_URL, "https://api".$mode.".paypal.com/v1/payments/payment");
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
				$result = curl_exec($ch);
				//print_r($result)."<br /><br />"; print_r(json_decode($fields)); die();
				$json = json_decode($result);

				//fixed by oppo webiprog.com  04.12.2017
				if ($json && json_last_error() == JSON_ERROR_NONE && isset($json->links)){
				$link_pay=$json->links[1]->href;
				}else {
				$link_pay = '';
				}
				// END fix by oppo webiprog.com  04.12.2017

				return $link_pay;
			}
}
