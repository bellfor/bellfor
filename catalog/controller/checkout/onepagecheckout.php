<?php
if(!function_exists('money_format')) {
function money_format ($frmt, $val) {
	$price = number_format($val, 2);
	$price = $price." EUR";
	return $price;
}
}
//fixed by oppo webiprog.com  05.12.2017
//set the level of error reporting
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

class ControllerCheckoutOnepagecheckout extends Controller
{
    public $errors = array();

    public function index()
    {
        // Validate cart has products and has stock.
        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $this->response->redirect($this->url->link('checkout/cart'));
        }
        $this->document->addStyle('catalog/view/theme/default/stylesheet/onepagecheckout.css');

        // Validate minimum quantity requirements.
        $products = $this->cart->getProducts();
        $this->load->language('checkout/onepagecheckout');

        $data['text_login'] = $this->language->get('text_login');
        $data['text_notlogged'] = $this->language->get('text_notlogged');
        $data['text_customer'] = $this->language->get('text_customer');
        $data['text_cart'] = $this->language->get('text_cart');
        $data['text_full_name'] = $this->language->get('text_full_name');
        $data['text_first_name'] = $this->language->get('text_first_name');
		$data['text_last_name'] = $this->language->get('text_last_name');
        $data['text_telephone'] = $this->language->get('text_telephone');
        $data['text_email'] = $this->language->get('text_email');
		$data['text_country'] = $this->language->get('text_country');
		$data['text_select_country'] = $this->language->get('text_select_country');
        $data['text_town'] = $this->language->get('text_town');
        $data['text_zip'] = $this->language->get('text_zip');
        $data['text_address'] = $this->language->get('text_address');
        $data['text_delivery_method'] = $this->language->get('text_delivery_method');
        $data['text_delivery_type_1'] = $this->language->get('text_delivery_type_1');
        $data['text_delivery_type_2'] = $this->language->get('text_delivery_type_2');
        $data['text_delivery_placeholder'] = $this->language->get('text_delivery_placeholder');

        $data['text_create_account'] = $this->language->get('text_create_account');
        $data['text_payment_address_different'] = $this->language->get('text_payment_address_different');

		$data['text_optin'] = $this->language->get('text_optin');

        $data['text_payment_method'] = $this->language->get('text_payment_method');
        $data['text_comment'] = $this->language->get('text_comment');
        $data['text_confirm'] = $this->language->get('text_confirm');
        $data['text_product'] = $this->language->get('text_product');
        $data['text_price'] = $this->language->get('text_price');
        $data['text_quantity'] = $this->language->get('text_quantity');
        $data['text_total'] = $this->language->get('text_total');
        $data['cart_total'] = 0;

		//fixed by oppo webiprog.com  18.12.2017 MAR-128 // Lieferfrist: bis zu 3 Tagen / Delivery time: up to 3 days
		$data['text_shipping_terms_3'] = $this->language->get('text_shipping_terms_3');
		$data['text_shipping_terms_6'] = $this->language->get('text_shipping_terms_6');
		$data['text_display_payment_methods'] = $this->language->get('text_display_payment_methods');




        /* login translate*/


        $this->load->language('account/login');
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_new_customer'] = $this->language->get('text_new_customer');
        $data['text_register'] = $this->language->get('text_register');
        $data['text_register_account'] = $this->language->get('text_register_account');
        $data['text_returning_customer'] = $this->language->get('text_returning_customer');
        $data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
        $data['text_forgotten'] = $this->language->get('text_forgotten');

        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_password'] = $this->language->get('entry_password');

        $data['button_continue'] = $this->language->get('button_continue');
        $data['button_login'] = $this->language->get('button_login');

        $data['action'] = $this->url->link('account/login', '', true);
        $data['register'] = $this->url->link('account/register', '', true);
        $data['forgotten'] = $this->url->link('account/forgotten', '', true);
      /*  if ($this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/account', '', true));
        }*/
        /* login translate END*/


		$this->load->model('catalog/product');
        foreach ($products as $i => $product) {
            if($this->request->server['REQUEST_METHOD'] != 'POST') {
                $products[$i]['price'] = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

            $product_data = $this->model_catalog_product->getProduct($product['product_id']);
			$category_data = $this->model_catalog_product->getMainCategory($product['product_id']);
            $products[$i]['category'] = $category_data['name'];
            $products[$i]['price_main'] = round(floatval($this->tax->calculate($product_data['price'], $product['tax_class_id'], $this->config->get('config_tax'))), 2, PHP_ROUND_HALF_DOWN);

            } else {
                $products[$i]['price'] = $product['price'];
			}
            $product_total = 0;
            $data['cart_total'] += $product['total'];
            $option_data = array();

            foreach ($product['option'] as $option) {
                $option_data[] = array(
                    'product_option_id' => $option['product_option_id'],
                    'product_option_value_id' => $option['product_option_value_id'],
                    'option_id' => $option['option_id'],
                    'option_value_id' => $option['option_value_id'],
                    'name' => $option['name'],
                    'value' => $option['value'],
                    'type' => $option['type']
                );
            }
            foreach ($products as $product_2) {
                if ($product_2['product_id'] == $product['product_id']) {
                    $product_total += $product_2['quantity'];
                }
            }

            if ($product['minimum'] > $product_total) {
                $this->response->redirect($this->url->link('checkout/cart'));
            }
        }

        // Totals
        $this->load->model('extension/extension');

        $totals = array();
        $taxes = $this->cart->getTaxes();
        $total = 0;
        $total_val = 0;
        // Because __call can not keep var references so we put them into an array.
        $total_data = array();

        // Display prices

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
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

				$sort_order = array();

				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data);
			}


        $data['totals'] = array();
 			foreach ($total_data as $key => $total) {
                if (is_numeric($key)) {
                    $data['totals'][] = array(
                        'title' => $total['title'],
                        'text' => $this->currency->format($total['value'])
                    );
                }
			}


			$files = glob(DIR_APPLICATION . '/controller/total/*.php');

			if ($files) {
				foreach ($files as $file) {
					$extension = basename($file, '.php');

					$data[$extension] = $this->load->controller('total/' . $extension);
				}
			}


        $data['products'] = $products;

        // Gift Voucher
        $data['vouchers'] = array();

        if (!empty($this->session->data['vouchers'])) {
            foreach ($this->session->data['vouchers'] as $voucher) {
                $data['vouchers'][] = array(
                    'description' => $voucher['description'],
                    'code' => token(10),
                    'to_name' => $voucher['to_name'],
                    'to_email' => $voucher['to_email'],
                    'from_name' => $voucher['from_name'],
                    'from_email' => $voucher['from_email'],
                    'voucher_theme_id' => $voucher['voucher_theme_id'],
                    'message' => $voucher['message'],
                    'amount' => $voucher['amount']
                );
            }
        }


        $this->load->language('checkout/checkout');
        $data['entry_firstname'] = $this->language->get('entry_firstname');
        $data['entry_lastname'] = $this->language->get('entry_lastname');
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_cart'),
            'href' => $this->url->link('checkout/cart')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('checkout/checkout', '', true)
        );

        $data['heading_title'] = $this->language->get('heading_title');


		//Load countries
		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();


//fixed by oppo webiprog.com  11.12.2017 indische code
/*
		$data['countries_de'] = array(
81 => 'Deutschland',
14 => 'Österreich',
21 => 'Belgien',
57 => 'Dänemark',
74 => 'Frankreich',
124 => 'Luxemburg',
150 => 'Niederlande',
170 => 'Polen',
195 => 'Spanien',
222 => 'Großbritannien',
122 => 'Liechtenstein',
204 => 'Switzerland'
);
		*/
        //fixed by oppo webiprog.com  11.12.2017
		$data['countries_de'] = $countries_arr = array();
		foreach($data['countries'] as $der=>$country_val){

		//fixed by oppo webiprog.com  15.12.2017
		//MAR-128 The list of countries when choosing a shipping should be in English
		$country_val_name = $this->language->get($country_val['iso_code_2'].'_'.$country_val['iso_code_3']);
		if($country_val_name !=($country_val['iso_code_2'].'_'.$country_val['iso_code_3'])) {
			$data['countries'][$der]['name']=$country_val['name'] = $country_val_name;
		}

		$countries_arr[$country_val['country_id']] = array('name' => $country_val['name'], 'iso_code_2' => $country_val['iso_code_2']);
		//fixed by oppo webiprog.com  11.12.2017

			if($country_val['status']==1) {
				$data['countries_de'][$country_val['country_id']]= $country_val['name'];
			}
		}
        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];
            unset($this->session->data['error']);
        } else {
            $data['error_warning'] = '';
        }

        if ( $this->customer->isLogged()) {
				$order_data['customer_id'] = $this->customer->getId();
				$customer_info = $this->model_account_customer->getCustomer($order_data['customer_id']);
				$order_data['customer_group_id'] = $customer_info['customer_group_id'];
            $this->load->model('account/address');
            $addr = $this->model_account_address->getAddress($this->customer->getAddressId());
            $data['c_logged'] = true;
            $data['f_name'] = $this->customer->getFirstName();
            $data['l_name'] = $this->customer->getLastName();
            $data['country_id'] = $addr['country_id'];
            $data['city'] = $addr['city'];
            $data['zip'] = (isset($addr['postcode']))?$addr['postcode']:'';
            $data['address_1'] = $addr['address_1'];
            $data['email'] = $this->customer->getEmail();
            $data['telephone'] = $this->customer->getTelephone();
        }
        else {
                $this->session->data['guest'] = array();
				$this->session->data['account'] = 'guest';
				$this->session->data['guest']['customer_group_id'] = $this->config->get('config_customer_group_id');
				$order_data['customer_id'] = 0;
				$order_data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];

            $data['c_logged'] = false;
            $data['f_name'] = '';
            $data['l_name'] = '';
            $data['city'] = '';
            $data['zip'] = '';
            $data['address_1'] = '';
            $data['email'] = '';
            $data['telephone'] = '';
        }


        if (isset($this->session->data['account'])) {
            $data['account'] = $this->session->data['account'];
        } else {
            $data['account'] = '';
        }
        if (isset($this->session->data['payment_address']['firstname'])) {
            $data['firstname'] = $this->session->data['payment_address']['firstname'];
        } else {
            $data['firstname'] = '';
        }

		if (isset($this->session->data['payment_address']['lastname'])) {
            $data['lastname'] = $this->session->data['payment_address']['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if (isset($this->session->data['payment_address']['address_1'])) {
            $data['address_1'] = $this->session->data['payment_address']['address_1'];
        }

        if (isset($this->session->data['payment_address']['city'])) {
            $data['city'] = $this->session->data['payment_address']['city'];
        }
        if (isset($this->session->data['payment_address']['telephone'])) {
            $data['telephone'] = $this->session->data['payment_address']['telephone'];
        }
        if (isset($this->session->data['comment'])) {
            $data['comment'] = $this->session->data['comment'];
        } else {
            $data['comment'] = '';
        }
        if (isset($this->session->data['email'])) {
            $data['email'] = $this->session->data['email'];
        }

        if (isset($this->session->data['address_1'])) {
            $data['address_1'] = $this->session->data['address_1'];
        }


        //    var_dump(json_decode('{"type": "page", "id": 1, "color": "#69F"}',true));exit;
        $this->errors = [];
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            if ($this->validate_form()) {
                $order_data = array();

			$order_data['totals'] = array();
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

					$this->{'model_total_' . $result['code']}->getTotal($order_data['totals'], $total, $taxes);
				}
			}

			$sort_order = array();

			foreach ($order_data['totals'] as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $order_data['totals']);



                if ($this->affiliate->isLogged()) {
                    $order_data['affiliate_id'] = $this->affiliate->getId();
                } else {
                    $order_data['affiliate_id'] = '';

                }
                $order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
                $order_data['store_id'] = $this->config->get('config_store_id');
                $order_data['store_name'] = $this->config->get('config_name');

                if ($order_data['store_id']) {
                    $order_data['store_url'] = $this->config->get('config_url');
                } else {
                    if ($this->request->server['HTTPS']) {
                        $order_data['store_url'] = HTTPS_SERVER;
                    } else {
                        $order_data['store_url'] = HTTP_SERVER;
                    }
                }


							$order_data['products'] = array();

			foreach ($this->cart->getProducts() as $product) {
				$option_data = array();

				foreach ($product['option'] as $option) {
					$option_data[] = array(
						'product_option_id'       => $option['product_option_id'],
						'product_option_value_id' => $option['product_option_value_id'],
						'option_id'               => $option['option_id'],
						'option_value_id'         => $option['option_value_id'],
						'name'                    => $option['name'],
						'value'                   => $option['value'],
						'type'                    => $option['type']
					);
				}

				$order_data['products'][] = array(
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $option_data,
					'download'   => $product['download'],
					'quantity'   => $product['quantity'],
					'subtract'   => $product['subtract'],
					'price'      => $product['price'],
					'total'      => $product['total'],
					'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
					'reward'     => $product['reward']
				);
			}


                $order_data['vouchers'] = $data['vouchers'];
                $order_data['cart_total'] = $total_val;


                if (isset($this->request->post['firstname'])) {
				    $this->session->data['firstname'] = $this->request->post['firstname'];
                    $this->session->data['payment_address']['firstname'] = $this->request->post['firstname'];
                    $order_data['firstname'] = $this->request->post['firstname'];
                    $order_data['payment_firstname'] = $this->request->post['firstname'];
                }

                if (isset($this->request->post['lastname'])) {
					$this->session->data['lastname'] = $this->request->post['lastname'];
                    $this->session->data['payment_address']['lastname'] = $this->request->post['lastname'];
                    $order_data['lastname'] = $this->request->post['lastname'];
                    $order_data['payment_lastname'] = $this->request->post['lastname'];
                }

                if (isset($this->request->post['telephone'])) {
                    $this->session->data['payment_address']['telephone'] = $this->request->post['telephone'];
                    $order_data['telephone'] = $this->request->post['telephone'];
                }

				$this->session->data['fax'] = '';
				$order_data['fax'] = '';
				$this->session->data['custom_field'] = '';
				$order_data['custom_field'] = '';


                if (isset($this->request->post['email'])) {
                    $this->session->data['email'] = $this->request->post['email'];
                    $order_data['email'] = $this->request->post['email'];
                    if(!empty(trim($this->request->post['email'])))
                        $order_data['order_status_id'] =0 ;
                    else
                        $order_data['order_status_id'] = $this->config->get('config_order_status_id');
                }


                if (isset($this->request->post['country_id'])) {
                    $this->session->data['payment_address']['country_id'] = $this->request->post['country_id'];
                    $order_data['payment_country_id'] = $this->request->post['country_id'];
					$order_data['payment_country'] = $countries_arr[$order_data['payment_country_id']]['name'];
					if (isset($this->session->data['shipping_method'])){
					$order_data['shipping_method'] = $this->session->data['shipping_method']['title'];
					$order_data['shipping_code'] = $this->session->data['shipping_method']['code'];
					} else {
					$shipping_data = getshipping($this->request->post['country_id'], true);
					$this->session->data['shipping_method'] = array();
					$this->session->data['shipping_method']['title'] = $shipping_data['title'];
					$this->session->data['shipping_method']['code'] = $shipping_data['code'];
					$this->session->data['shipping_method']['cost'] = $shipping_data['cost'];
					$this->session->data['shipping_method']['tax_class_id'] = $shipping_data['tax_class_id'];
					$this->session->data['shipping_method']['text'] = $shipping_data['text'];
					$order_data['shipping_method'] = $this->session->data['shipping_method']['title'];
					$order_data['shipping_code'] = $this->session->data['shipping_method']['code'];
					}

                }

                if (isset($this->request->post['city'])) {
                    $this->session->data['payment_address']['city'] = $this->request->post['city'];
                    $order_data['city'] = $this->request->post['city'];
                    $order_data['payment_city'] = $this->request->post['city'];
                }

                if (isset($this->request->post['zip'])) {
                    $this->session->data['payment_address']['postcode'] = $this->request->post['zip'];
                    $order_data['payment_postcode'] = $this->request->post['zip'];
                }

                $this->session->data['payment_address']['zone_id'] = 0;


                if (isset($this->request->post['address_1'])) {
                    $this->session->data['payment_address']['address_1'] = $this->request->post['address_1'];
                    $order_data['address_1'] = $this->request->post['address_1'];
					$order_data['payment_address_1'] = $this->request->post['address_1'];
                }

                $order_data['payment_company'] = '';
				$order_data['payment_address_2'] = '';
				$order_data['payment_zone'] = '';
				$order_data['payment_zone_id'] = 0;

                $order_data['shipping_company'] = '';
				$order_data['shipping_address_2'] = '';
				$order_data['shipping_address_format'] = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				$order_data['payment_address_format'] = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				$order_data['shipping_zone'] = '';
				$order_data['shipping_zone_id'] = 0;


                if (isset($this->request->post['payment_address_different'])) {

                if (isset($this->request->post['shipping_country_id'])) {
                    $this->session->data['shipping_address']['country_id'] = $this->request->post['shipping_country_id'];
                    $order_data['shipping_country_id'] = $this->request->post['shipping_country_id'];
					$order_data['shipping_country'] = $countries_arr[$order_data['shipping_country_id']]['name'];
                } else {
                    $this->session->data['shipping_address']['country_id'] = $this->request->post['country_id'];
                    $order_data['shipping_country_id'] = $this->request->post['country_id'];
					$order_data['shipping_country'] = $countries_arr[$order_data['shipping_country_id']]['name'];
				}

                if (isset($this->request->post['shipping_city'])) {
                    $this->session->data['shipping_address']['city'] = $this->request->post['shipping_city'];
                    $order_data['shipping_city'] = $this->request->post['shipping_city'];
                } else {
                    $this->session->data['shipping_address']['city'] = $this->request->post['city'];
                    $order_data['shipping_city'] = $this->request->post['city'];
				}

                if (isset($this->request->post['shipping_zip'])) {
                    $this->session->data['shipping_address']['postcode'] = $this->request->post['shipping_zip'];
                    $order_data['shipping_postcode'] = $this->request->post['shipping_zip'];
                } else {
                    $this->session->data['shipping_address']['postcode'] = $this->request->post['zip'];
                    $order_data['shipping_postcode'] = $this->request->post['zip'];
				}

                if (isset($this->request->post['shipping_address_1'])) {
                    $this->session->data['shipping_address']['address_1'] = $this->request->post['shipping_address_1'];
                    $order_data['shipping_address_1'] = $this->request->post['shipping_address_1'];
                } else {
                    $this->session->data['shipping_address']['address_1'] = $this->request->post['address_1'];
                    $order_data['shipping_address_1'] = $this->request->post['address_1'];
				}

                if (isset($this->request->post['shipping_firstname'])) {
                    $this->session->data['shipping_address']['firstname'] = $this->request->post['shipping_firstname'];
                    $order_data['shipping_firstname'] = $this->request->post['shipping_firstname'];
                } else {
                    $this->session->data['shipping_address']['firstname'] = $this->request->post['firstname'];
                    $order_data['shipping_firstname'] = $this->request->post['firstname'];
				}

                if (isset($this->request->post['shipping_lastname'])) {
                    $this->session->data['shipping_address']['lastname'] = $this->request->post['shipping_lastname'];
                    $order_data['shipping_lastname'] = $this->request->post['shipping_lastname'];
                } else {
                    $this->session->data['shipping_address']['lastname'] = $this->request->post['lastname'];
                    $order_data['shipping_lastname'] = $this->request->post['lastname'];
				}

                if (isset($this->request->post['shipping_telephone'])) {
                    $this->session->data['shipping_address']['telephone'] = $this->request->post['shipping_telephone'];
                    $order_data['telephone'] = $this->request->post['shipping_telephone'];
                } else {
                    $this->session->data['shipping_address']['telephone'] = $this->request->post['telephone'];
                    $order_data['telephone'] = $this->request->post['telephone'];
				}

				} else {

                if (isset($this->request->post['country_id'])) {
                    $this->session->data['shipping_address']['country_id'] = $this->request->post['country_id'];
                    $order_data['shipping_country_id'] = $this->request->post['country_id'];
					$order_data['shipping_country'] = $countries_arr[$order_data['shipping_country_id']]['name'];
                }

                if (isset($this->request->post['city'])) {
                    $this->session->data['shipping_address']['city'] = $this->request->post['city'];
                    $order_data['shipping_city'] = $this->request->post['city'];
                }

                if (isset($this->request->post['zip'])) {
                    $this->session->data['shipping_address']['postcode'] = $this->request->post['zip'];
                    $order_data['shipping_postcode'] = $this->request->post['zip'];
                }

                if (isset($this->request->post['address_1'])) {
                    $this->session->data['shipping_address']['address_1'] = $this->request->post['address_1'];
                    $order_data['shipping_address_1'] = $this->request->post['address_1'];
                }

                if (isset($this->request->post['firstname'])) {
					$this->session->data['firstname'] = $this->request->post['firstname'];
                    $this->session->data['shipping_address']['firstname'] = $this->request->post['firstname'];
                    $order_data['shipping_firstname'] = $this->request->post['firstname'];
                }

                if (isset($this->request->post['lastname'])) {
                    $this->session->data['shipping_address']['lastname'] = $this->request->post['lastname'];
                    $order_data['shipping_lastname'] = $this->request->post['lastname'];
                }

                if (isset($this->request->post['telephone'])) {
					$this->session->data['telephone'] = $this->request->post['telephone'];
                    $this->session->data['shipping_address']['telephone'] = $this->request->post['telephone'];
                    $order_data['telephone'] = $this->request->post['telephone'];
                }


				}
				$this->session->data['shipping_address']['zone_id'] = 0;
                if (isset($this->request->post['payment_method'])) {
                    $this->session->data['payment_method'] = json_decode(htmlspecialchars_decode($this->request->post['payment_method']), true);
                    $order_data['payment_method'] = $this->session->data['payment_method']['title'];
					$order_data['payment_code'] = $this->session->data['payment_method']['code'];
                }


                if (isset($this->request->post['comment'])) {
                    $this->session->data['comment'] = $this->request->post['comment'];
                    $order_data['comment'] = $this->request->post['comment'];
                }
                if (isset($this->request->post['delivery-type'])) {
                    $this->session->data['delivery-type'] = $this->request->post['delivery-type'];
                    $order_data['address_1'] = $this->request->post['delivery-type'] . ' - ' . $order_data['address_1'];
                }


                $order_data['language_id'] = $this->config->get('config_language_id');
                $order_data['currency_id'] = $this->currency->getId($this->session->data['currency']);
                $order_data['currency_code'] = $this->session->data['currency'];
                $order_data['currency_value'] = $this->currency->getValue($this->session->data['currency']);
                $order_data['ip'] = $this->request->server['REMOTE_ADDR'];

                if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                    $order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
                } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                    $order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
                } else {
                    $order_data['forwarded_ip'] = '';
                }

                if (isset($this->request->server['HTTP_USER_AGENT'])) {
                    $order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
                } else {
                    $order_data['user_agent'] = '';
                }

                if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                    $order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
                } else {
                    $order_data['accept_language'] = '';
                }





                if (isset($this->session->data['guest']['customer_group_id'])) {

					if(isset($this->request->post['create_account']) && ($this->request->post['create_account']==1)) {
//Create account
     					$account_data = $this->request->post;
						$account_data['postcode'] = $account_data['zip'];
						$account_data['address_2'] = '';
						$account_data['fax'] = '';
						$account_data['zone_id'] = '';
						$account_data['company'] = '';
						$length = 10;
                        $randomString = substr(str_shuffle(md5(time())),0,$length);
                        $account_data['password'] = $randomString;

	    	$this->load->model('account/customer');
			$order_data['customer_id']= $this->model_account_customer->addCustomer($account_data);
            $order_data['customer_group_id'] = $this->config->get('config_customer_group_id');
			// Clear any previous login attempts for unregistered accounts.
			$this->model_account_customer->deleteLoginAttempts($account_data['email']);

			$this->customer->login($account_data['email'], $account_data['password']);

			unset($this->session->data['guest']);

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $order_data['customer_id'],
				'name'        => $account_data['firstname'] . ' ' . $account_data['lastname']
			);

			$this->model_account_activity->addActivity('register', $activity_data);

//Create account END
					} else {
					$order_data['customer_id'] = 0;
					$this->session->data['guest']['firstname'] = $this->request->post['firstname'];
					$this->session->data['guest']['lastname'] = $this->request->post['lastname'];
                    $order_data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
					}
                } else {
					$order_data['customer_id'] = $this->customer->getId();
                    $order_data['customer_group_id'] = $this->config->get('config_customer_group_id');
                }


				$order_data['total'] = $total;

			if (isset($this->request->cookie['tracking'])) {
				$order_data['tracking'] = $this->request->cookie['tracking'];

				$subtotal = $this->cart->getSubTotal();

				// Affiliate
				$this->load->model('affiliate/affiliate');

				$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

				if ($affiliate_info) {
					$order_data['affiliate_id'] = $affiliate_info['affiliate_id'];
					$order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
				} else {
					$order_data['affiliate_id'] = 0;
					$order_data['commission'] = 0;
				}

				// Marketing
				$this->load->model('checkout/marketing');

				$marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);

				if ($marketing_info) {
					$order_data['marketing_id'] = $marketing_info['marketing_id'];
				} else {
					$order_data['marketing_id'] = 0;
				}
			} else {
				$order_data['affiliate_id'] = 0;
				$order_data['commission'] = 0;
				$order_data['marketing_id'] = 0;
				$order_data['tracking'] = '';
			}

                //$this->load->model('checkout/onepagecheckout');
                $this->load->model('checkout/order');

if($this->session->data['payment_method']['code'] != "pp_plus") {

                $json['order_id'] = $this->model_checkout_order->addOrder($order_data);
                $this->session->data['order_id'] = $json['order_id'];

} else {
$this->session->data['order_data'] = $order_data;
}


                $json['payment'] = $this->load->controller('payment/' . $order_data['payment_code']);

                if($order_data['payment_code']=='cod') {
                $json['cod'] = 1;
				}
            } else
                $json['error'] = $this->errors;

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        } else {

            $this->session->data['payment_address']['country_id'] = $this->config->get('config_country_id');
            $this->session->data['payment_address']['zone_id'] = $this->config->get('config_zone_id');
            /*get shippings methods*/


            // Shipping Methods

			$method_data = array();

			$this->load->model('extension/extension');

			$results = $this->model_extension_extension->getExtensions('shipping');

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('shipping/' . $result['code']);

					$quote = $this->{'model_shipping_' . $result['code']}->getQuote($this->session->data['payment_address']);

					if ($quote) {
						$method_data[$result['code']] = array(
							'title'      => $quote['title'],
							'quote'      => $quote['quote'],
							'sort_order' => $quote['sort_order'],
							'error'      => $quote['error']
						);
					}
				}
			}

			$sort_order = array();

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $method_data);

			$this->session->data['shipping_methods'] = $method_data;


            foreach ($method_data as $i => $shipping_method)
                foreach ($shipping_method['quote'] as $shipping_method2) {
                    $data['shipping_methods'][$i]['value'] = $shipping_method2['code'];
                    $data['shipping_methods'][$i]['title'] = $shipping_method2['title'];
                    if (isset($shipping_method2['cost']))
                        $data['shipping_methods'][$i]['cost'] = $shipping_method2['cost'];
                    else
                        $data['shipping_methods'][$i]['cost']='';

                }
            //var_dump( $data['shipping_methods']);exit;


            /* payment methods*/
            // Payment Methods
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

			// Payment Methods
			$method_data = array();

			$this->load->model('extension/extension');

			$results = $this->model_extension_extension->getExtensions('payment');

			$recurring = $this->cart->hasRecurringProducts();

			if (!isset($this->session->data['payment_address'])) {
				$payment_address = array('country_id' => $this->config->get('config_country_id'), 'zone_id' => $this->config->get('config_zone_id'));
			} else {
				if (!isset($this->session->data['payment_address']['country_id'])) {
				$this->session->data['payment_address']['country_id'] = $this->config->get('config_country_id');
				$this->session->data['payment_address']['zone_id'] = $this->config->get('config_zone_id');
				}
				$payment_address = $this->session->data['payment_address'];
			}

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('payment/' . $result['code']);

					$method = $this->{'model_payment_' . $result['code']}->getMethod($payment_address, $total);

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





            $data['payment_methods'] = $method_data;


            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/onepagecheckout.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/onepagecheckout.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/checkout/onepagecheckout.tpl', $data));
		}
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
            $data['error']['zip'] = $this->language->get('error_postcode');
        }

		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));

			if ($information_info && !isset($this->request->post['agree'])) {
				$data['error']['agree'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}

        if (!empty($data['error'])) {
            $this->errors = $data['error'];
            return false;
        } else
            return true;
    }


    public function AjaxLogin(){
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateLogin()) {
            $this->load->model('account/address');
            $addr = $this->model_account_address->getAddress($this->customer->getAddressId());
            $loginData['f_name'] = $this->customer->getFirstName();
			$loginData['l_name'] = $this->customer->getLastName();
			$loginData['country_id'] =$addr['country_id'];
            $loginData['city'] =$addr['city'];
			$loginData['zip'] =$addr['postcode'];
            $loginData['address_1'] = $addr['address_1'];
            $loginData['email'] = $this->customer->getEmail();
            $loginData['telephone'] = $this->customer->getTelephone();
            $this->load->language('account/login');
            // Unset guest
            unset($this->session->data['guest']);

            // Default Shipping Address
            $this->load->model('account/address');

            if ($this->config->get('config_tax_customer') == 'payment') {
                $this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }

            if ($this->config->get('config_tax_customer') == 'shipping') {
                $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }



            // Add to activity log
            if ($this->config->get('config_customer_activity')) {
                $this->load->model('account/activity');

                $activity_data = array(
                    'customer_id' => $this->customer->getId(),
                    'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
                );

                $this->model_account_activity->addActivity('login', $activity_data);
            }


        }
        if( $this->errors) {
        $loginData['errors'] = $this->errors;
        } else {
        $loginData['errors']=0;
		}
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($loginData));
    }
    protected function validateLogin() {
        // Check how many login attempts have been made.
        $this->load->model('account/customer');
        $this->load->language('account/login');
        $login_info = $this->model_account_customer->getLoginAttempts($this->request->post['email']);

        if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
            $this->errors['warning'] = $this->language->get('error_attempts');
        }

        // Check if customer has been approved.
        $customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

        if ($customer_info && !$customer_info['approved']) {
            $this->errors['warning'] = $this->language->get('error_approved');
        }

        if (!$this->errors) {
            if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
                $this->errors['warning'] = $this->language->get('error_login');

                $this->model_account_customer->addLoginAttempt($this->request->post['email']);
            } else {
                $this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
            }
        }
        return  !$this->errors;
    }

/**
 * Selecting a delivery method between DPD and DHL for German customers
 *
 * @author oppo
 * @return void
 */
    public function rumun()
    {
        if (isset($this->request->post['rumun_id']) && strlen($this->request->post['rumun_id'])>2) {
            $country_selected =$this->request->post['country_selected'];
            $rumun_id = $this->request->post['rumun_id'];
            $this->session->data['rumun'] = (string)$rumun_id;
        } else {
            $rumun_id = false;
            $this->session->data['rumun'] = null;
        }
        echo($rumun_id);
        exit();
    }


	//fixed by oppo webiprog.com  25.12.2017
	public function getshipping($country = '', $return = false)
	{
		if (isset($this->request->post['country_id']))
		{
			$country_id = $this->request->post['country_id'];
		}
		else
		{
			$country_id = $country;
		}

		$this->load->language('shipping/weight');

		$quote_data = array();


		//fixed by oppo webiprog.com  25.12.2017
		$total = $this->cart->getTotal();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");

		if ($this->request->post['shipping_method'] != 'DHLE') {
            foreach ($query->rows as $result)
            {
                if ($this->config->get('weight_' . $result['geo_zone_id'] . '_status'))
                {
                    $free = false;
                    if (!empty($this->config->get('weight_' . $result['geo_zone_id'] . '_free')) && intval($this->config->get('weight_' . $result['geo_zone_id'] . '_free')) > 0
                    )
                    {
                        if ($total >= intval($this->config->get('weight_' . $result['geo_zone_id'] . '_free')))
                        {
                            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$country_id . "'");

                            if ($query->num_rows)
                            {
                                $quote_data = array('code' => 'weight.weight_' . $result['geo_zone_id'],
                                    'title' => '',
                                    'cost' => 0,
                                    'tax_class_id' => $this->config->get('weight_tax_class_id'),
                                    'text' => ''
                                );
                                $free = true;
                                $status = false;
                                break;
                            }
                        }
                    }

                    if ($free === false)
                    {
                        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$country_id . "'");

                        if ($query->num_rows)
                        {
                            $status = true;
                        }
                        else
                        {
                            $status = false;
                        }
                    }
                }
                else
                {
                    $status = false;
                }

                if ($status)
                {
                    $cost = '';
                    $weight = $this->cart->getWeight();

                    $rates = explode(',', $this->config->get('weight_' . $result['geo_zone_id'] . '_rate'));

                    $highest = 0;

                    foreach ($rates as $rate)
                    {
                        $data = explode(':', $rate);

                        if ($data[0] >= $weight)
                        {
                            if (isset($data[1]))
                            {
                                $cost = $data[1];
                            }

                            break;
                        }

                        if (isset($data[1]) && $data[1] > $highest)
                        {
                            $highest = $data[1];
                        }
                    }

                    if ($cost == '')
                    {
                        $cost = $highest;
                    }

                    if ((string)$cost != '')
                    {
                        $quote_data = array('code' => 'weight.weight_' . $result['geo_zone_id'],
                            'title' => $result['name'] . '  (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
                            'cost' => $cost,
                            'tax_class_id' => $this->config->get('weight_tax_class_id'),
                            'text' => $this->currency->format($this->tax->calculate($cost, $this->config->get('weight_tax_class_id'), $this->config->get('config_tax')))
                        );
                    }
                }
            } // end foreach
        } else {
		    // If create new geo zone for DHL Express check hem id and change this id "geo_zone_id  = '27'"
            $geo_zone = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone WHERE geo_zone_id  = '27' ORDER BY name");

            $cost = '';
            $weight = $this->cart->getWeight();

            $rates = explode(',', $this->config->get('weight_' . $geo_zone->row['geo_zone_id'] . '_rate'));

            $highest = 0;

            foreach ($rates as $rate)
            {
                $data = explode(':', $rate);

                if ($data[0] >= $weight)
                {

                    if (isset($data[1]))
                    {
                        $cost = $data[1];
                    }

                    break;
                }

                if (isset($data[1]) && $data[1] > $highest)
                {
                    $highest = $data[1];
                }
            }

            if ($cost == '')
            {
                $cost = $highest;
            }

            if ((string)$cost != '')
            {
                $quote_data = array('code' => 'weight.weight_' . $geo_zone->row['geo_zone_id'],
                    'title' => $geo_zone->row['name'] . '  (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')',
                    'cost' => $cost,
                    'tax_class_id' => $this->config->get('weight_tax_class_id'),
                    'text' => $this->currency->format($this->tax->calculate($cost, $this->config->get('weight_tax_class_id'), $this->config->get('config_tax')))
                );
            }
		}

        $method_data = array();

		if ($quote_data)
		{
			$method_data = array('code' => $quote_data['code'],
				'title' => $this->language->get('text_title'),
				'comment' => '',
				'shipping_method' => $quote_data['code'],
				'cost' => $quote_data['cost'],
				'tax_class_id' => '',
				'text' => $quote_data['text'],
				// 'sort_order' => $this->config->get('weight_sort_order'),
				// 'error'      => false
				);
		}
		if ($return == false)
		{
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($method_data));
		}
		else
		{
			return $method_data;
		}
	}


	public function setshipping() {
		$this->load->language('checkout/checkout');

		$json = array();

		// Validate if shipping is required. If not the customer should not have reached this page.
		if (!$this->cart->hasShipping()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

		// Validate if shipping address has been set.
		if (!isset($this->session->data['payment_address'])) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$json['redirect'] = $this->url->link('checkout/cart');

				break;
			}
		}

		if (!isset($this->request->post['shipping_method'])) {
			$json['error']['warning'] = $this->language->get('error_shipping');
		} else {
			$shipping = explode('.', $this->request->post['shipping_method']);

			if (!isset($shipping[0]) || !isset($shipping[1])) {
				$json['error']['warning'] = $this->language->get('error_shipping');
			}
		}

		if (!$json) {
			$this->session->data['shipping_method'] = array(
			'code' => $this->request->post['shipping_method'],
			'title' => $this->request->post['title'],
			'cost' => $this->request->post['cost'],
			'tax_class_id' => $this->request->post['tax_class_id'],
			'text' => $this->request->post['text'],
			);

			$this->session->data['comment'] = strip_tags($this->request->post['comment']);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

    public function totals() {
			// Totals
			$this->load->model('extension/extension');

			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
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

				$sort_order = array();

				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data);
			}

			$data['totals'] = array();

			foreach ($total_data as $key => $total) {
                if (is_numeric($key)) {
                    $data['totals'][] = array(
                        'title' => $total['title'],
                        'text' => $this->currency->format($total['value'])
                    );
                }
			}

			$data['continue'] = $this->url->link('common/home');

			$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

			$this->load->model('extension/extension');

			$data['checkout_buttons'] = array();

			$files = glob(DIR_APPLICATION . '/controller/total/*.php');

			if ($files) {
				foreach ($files as $file) {
					$extension = basename($file, '.php');

					$data[$extension] = $this->load->controller('total/' . $extension);
				}
			}

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($data));

    }



           // public function load_payments () {}


}
