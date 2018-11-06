<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

        require_once dirname(dirname(dirname(dirname(__FILE__)))).'/system/klarna-xmlrpc/vendor/autoload.php';
		
use Klarna\XMLRPC\Klarna;
use Klarna\XMLRPC\Country;
use Klarna\XMLRPC\Language;
use Klarna\XMLRPC\Currency;
use Klarna\XMLRPC\Flags;
use Klarna\XMLRPC\Address;
use Klarna\XMLRPC\PClass;



class ControllerPaymentKlarnaInvoicePro extends Controller {
	public function index() {
		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if ($order_info) {
			$this->load->language('payment/klarna_invoice_pro');

			$data['text_additional'] = $this->language->get('text_additional');
			$data['text_payment_option'] = $this->language->get('text_payment_option');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['text_day'] = $this->language->get('text_day');
			$data['text_month'] = $this->language->get('text_month');
			$data['text_year'] = $this->language->get('text_year');
			$data['text_male'] = $this->language->get('text_male');
			$data['text_female'] = $this->language->get('text_female');

			$data['entry_pno'] = $this->language->get('entry_pno');
			$data['entry_dob'] = $this->language->get('entry_dob');
			$data['entry_gender'] = $this->language->get('entry_gender');
			$data['entry_street'] = $this->language->get('entry_street');
			$data['entry_house_no'] = $this->language->get('entry_house_no');
			$data['entry_house_ext'] = $this->language->get('entry_house_ext');
			$data['entry_phone_no'] = $this->language->get('entry_phone_no');
			$data['entry_company'] = $this->language->get('entry_company');

			$data['button_confirm'] = $this->language->get('button_confirm');

			$data['days'] = array();

			for ($i = 1; $i <= 31; $i++) {
				$data['days'][] = array(
					'text'  => sprintf('%02d', $i),
					'value' => $i
				);
			}

			$data['months'] = array();

			for ($i = 1; $i <= 12; $i++) {
				$data['months'][] = array(
					'text'  => sprintf('%02d', $i),
					'value' => $i
				);
			}

			$data['years'] = array();

			for ($i = date('Y'); $i >= 1900; $i--) {
				$data['years'][] = array(
					'text'  => $i,
					'value' => $i
				);
			}

			// Store Taxes to send to Klarna
			$total_data = array();
			$total = 0;

			$this->load->model('extension/extension');

			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			$klarna_tax = array();

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);

					$taxes = array();

					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);

					$amount = 0;

					foreach ($taxes as $tax_id => $value) {
						$amount += $value;
					}

					$klarna_tax[$result['code']] = $amount;
				}
			}

			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];

				if (isset($klarna_tax[$value['code']])) {
					if ($klarna_tax[$value['code']]) {
						$total_data[$key]['tax_rate'] = abs($klarna_tax[$value['code']] / $value['value'] * 100);
					} else {
						$total_data[$key]['tax_rate'] = 0;
					}
				} else {
					$total_data[$key]['tax_rate'] = '0';
				}
			}

			$this->session->data['klarna'][$this->session->data['order_id']] = $total_data;

			// Order must have identical shipping and billing address or have no shipping address at all
			if ($this->cart->hasShipping() && !($order_info['payment_firstname'] == $order_info['shipping_firstname'] && $order_info['payment_lastname'] == $order_info['shipping_lastname'] && $order_info['payment_address_1'] == $order_info['shipping_address_1'] && $order_info['payment_address_2'] == $order_info['shipping_address_2'] && $order_info['payment_postcode'] == $order_info['shipping_postcode'] && $order_info['payment_city'] == $order_info['shipping_city'] && $order_info['payment_zone_id'] == $order_info['shipping_zone_id'] && $order_info['payment_zone_code'] == $order_info['shipping_zone_code'] && $order_info['payment_country_id'] == $order_info['shipping_country_id'] && $order_info['payment_country'] == $order_info['shipping_country'] && $order_info['payment_iso_code_3'] == $order_info['shipping_iso_code_3'])) {
				$data['error_warning'] = $this->language->get('error_address_match');
			} else {
				$data['error_warning'] = '';
			}

			$klarna_invoice_pro = $this->config->get('klarna_invoice_pro');

			$data['merchant'] = $klarna_invoice_pro[$order_info['payment_iso_code_3']]['merchant'];
			$data['phone_number'] = $order_info['telephone'];

			if ($order_info['payment_iso_code_3'] == 'DEU' || $order_info['payment_iso_code_3'] == 'NLD' || $order_info['payment_iso_code_3'] == 'AUT') {
				$address = $this->splitAddress($order_info['payment_address_1']);

				$data['street'] = $address[0];
				$data['street_number'] = $address[1];
				$data['street_extension'] = $address[2];

				if ($order_info['payment_iso_code_3'] == 'DEU') {
					$data['street_number'] = trim($address[1] . ' ' . $address[2]);
				}
			} else {
				$data['street'] = '';
				$data['street_number'] = '';
				$data['street_extension'] = '';
			}

			$data['company'] = $order_info['payment_company'];
			$data['iso_code_2'] = $order_info['payment_iso_code_2'];
			$data['iso_code_3'] = $order_info['payment_iso_code_3'];

			// Get the invoice fee
			$query = $this->db->query("SELECT `value` FROM `" . DB_PREFIX . "order_total` WHERE `order_id` = " . (int)$order_info['order_id'] . " AND `code` = 'klarna_fee'");

			if ($query->num_rows && !$query->row['value']) {
				$data['klarna_fee'] = $query->row['value'];
			} else {
				$data['klarna_fee'] = '';
			}

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/klarna_invoice_pro.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/payment/klarna_invoice_pro.tpl', $data);
			} else {
				return $this->load->view('default/template/payment/klarna_invoice_pro.tpl', $data);
			}
		}
	}

	public function send() {	



		$this->load->language('payment/klarna_invoice_pro');

		$json = array();

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		// Order must have identical shipping and billing address or have no shipping address at all
		if ($order_info) {
			if ($order_info['payment_iso_code_3'] == 'DEU' && empty($this->request->post['deu_terms'])) {
				$json['error'] = $this->language->get('error_deu_terms');
			}

			if ($this->cart->hasShipping() && !($order_info['payment_firstname'] == $order_info['shipping_firstname'] && $order_info['payment_lastname'] == $order_info['shipping_lastname'] && $order_info['payment_address_1'] == $order_info['shipping_address_1'] && $order_info['payment_address_2'] == $order_info['shipping_address_2'] && $order_info['payment_postcode'] == $order_info['shipping_postcode'] && $order_info['payment_city'] == $order_info['shipping_city'] && $order_info['payment_zone_id'] == $order_info['shipping_zone_id'] && $order_info['payment_zone_code'] == $order_info['shipping_zone_code'] && $order_info['payment_country_id'] == $order_info['shipping_country_id'] && $order_info['payment_country'] == $order_info['shipping_country'] && $order_info['payment_iso_code_3'] == $order_info['shipping_iso_code_3'])) {
				$json['error'] = $this->language->get('error_address_match');
			}

			if (!$json) {
				$klarna_invoice_pro = $this->config->get('klarna_invoice_pro');

				if ($klarna_invoice_pro[$order_info['payment_iso_code_3']]['server'] == 'live') {
					$url = 'https://payment.klarna.com/';
				} else {
					$url = 'https://payment.testdrive.klarna.com/';
				}

				$country_to_currency = array(
					'NOR' => 'NOK',
					'SWE' => 'SEK',
					'FIN' => 'EUR',
					'DNK' => 'DKK',
					'DEU' => 'EUR',
					'AUT' => 'EUR',					
					'NLD' => 'EUR'
				);

				switch ($order_info['payment_iso_code_3']) {
					// Sweden
					case 'SWE':
						$country = 209;
						$language = 138;
						$encoding = 2;
						$currency = 0;
						break;
					// Finland
					case 'FIN':
						$country = 73;
						$language = 37;
						$encoding = 4;
						$currency = 2;
						break;
					// Denmark
					case 'DNK':
						$country = 59;
						$language = 27;
						$encoding = 5;
						$currency = 3;
						break;
					// Norway
					case 'NOR':
						$country = 164;
						$language = 97;
						$encoding = 3;
						$currency = 1;
						break;
					// Germany
					case 'DEU':
						$country =     Country::DE;
						$language =  Language::DE;
						$currency = Currency::EUR;
						break;
					// Germany
					case 'AUT':
						$country =     Country::AT;
						$language =  Language::DE;
						$currency = Currency::EUR;
						break;						
					// Netherlands
					case 'NLD':
						$country = 154;
						$language = 101;
						$encoding = 7;
						$currency = 2;
						break;
				}

				if (isset($this->request->post['street'])) {
					$street = $this->request->post['street'];
				} else {
					$street = $order_info['payment_address_1'];
				}

				if (isset($this->request->post['house_no'])) {
					$house_no = $this->request->post['house_no'];
				} else {
					$house_no = '';
				}

				if (isset($this->request->post['house_ext'])) {
					$house_ext = $this->request->post['house_ext'];
				} else {
					$house_ext = '';
				}

				$address = array(
					'email'           => $order_info['email'],
					'telno'           => $this->request->post['phone_no'],
					'cellno'          => '',
					'fname'           => $order_info['payment_firstname'],
					'lname'           => $order_info['payment_lastname'],
					'company'         => $order_info['payment_company'],
					'careof'          => '',
					'street'          => $street,
					'house_number'    => $house_no,
					'house_extension' => $house_ext,
					'zip'             => $order_info['payment_postcode'],
					'city'            => $order_info['payment_city'],
					'country'         => $country,
				);

				$product_query = $this->db->query("SELECT `name`, `model`, `price`, `quantity`, `tax` / `price` * 100 AS 'tax_rate' FROM `" . DB_PREFIX . "order_product` WHERE `order_id` = " . (int)$order_info['order_id'] . " UNION ALL SELECT '', `code`, `amount`, '1', 0.00 FROM `" . DB_PREFIX . "order_voucher` WHERE `order_id` = " . (int)$order_info['order_id']);

				foreach ($product_query->rows as $product) {
					$goods_list[] = array(
						'qty'   => (int)$product['quantity'],
						'goods' => array(
							'artno'    => $product['model'],
							'title'    => $product['name'],
							'price'    => (int) $this->currency->format($product['price'], $country_to_currency[$order_info['payment_iso_code_3']], '', false),
							'vat'      => (float)$product['tax_rate'],
							'discount' => 0.0,
							'flags'    => 0
						)
					);
				}

				if (isset($this->session->data['klarna'][$this->session->data['order_id']])) {
					$totals = $this->session->data['klarna'][$this->session->data['order_id']];
				} else {
					$totals = array();
				}

				foreach ($totals as $total) {
					if ($total['code'] != 'sub_total' && $total['code'] != 'tax' && $total['code'] != 'total') {
						$goods_list[] = array(
							'qty'   => 1,
							'goods' => array(
								'artno'    => '',
								'title'    => $total['title'],
								'price'    => (int) $this->currency->format($total['value'], $country_to_currency[$order_info['payment_iso_code_3']], '', false),
								'vat'      => (float)$total['tax_rate'],
								'discount' => 0.0,
								'flags'    => 0
							)
						);
					}
				}



				if (isset($this->request->post['pno'])) {
					$pno = $this->request->post['pno'];
				} else {
					$pno = sprintf('%02d', (int)$this->request->post['pno_day']) . sprintf('%02d', (int)$this->request->post['pno_month']) . (int)$this->request->post['pno_year'];
				}

				$pclass = -1;

				if (isset($this->request->post['gender']) && ($order_info['payment_iso_code_3'] == 'DEU' || $order_info['payment_iso_code_3'] == 'NLD' || $order_info['payment_iso_code_3'] == 'AUT')) {
					$gender = (int)$this->request->post['gender'];
				} else {
					$gender = '';
				}



	
$k = new Klarna();
$k->config(
    $klarna_invoice_pro[$order_info['payment_iso_code_3']]['merchant'],              // Merchant ID
    $klarna_invoice_pro[$order_info['payment_iso_code_3']]['secret'], // Shared secret
    $country,    // Purchase country
    $language,   // Purchase language
    $currency,  // Purchase currency
    Klarna::BETA    // Server
);


				foreach ($goods_list as $goods) {
$k->addArticle(
    $goods['qty'],                 // Quantity
    $goods['goods']['artno'],        // Article number
    $goods['goods']['title'], // Article name/title
    $goods['goods']['price'],            // Price
    $goods['goods']['vat'],                // % VAT
    $goods['goods']['discount'],                 // Discount
    Flags::NO_FLAG     // Price is including VAT.
);
				}





//$k->addArticle(1, '', 'Shipping fee', 14.5, 25, 0, Flags::INC_VAT | Flags::IS_SHIPMENT);


if ($klarna_invoice_pro[$order_info['payment_iso_code_3']]['fee'] > 0) {
$k->addArticle(1, '', 'Handling fee', $klarna_invoice_pro[$order_info['payment_iso_code_3']]['fee'], 7, 0, Flags::NO_FLAG | Flags::IS_HANDLING);
}

$addr = new Address(
    $address['email'], // Email address
    $address['telno'],                           // Telephone number, only one phone number is needed
    '',                 // Cell phone number
    $address['fname'],              // First name (given name)
    $address['lname'],                   // Last name (family name)
    '',                           // No care of, C/O
    $address['street'],                // Street address
    $address['zip'],                      // Zip code
    $address['city'],                   // City
    $country,                  // Country
    $address['house_number'],                         // House number (AT/DE/NL only)
    null                          // House extension (NL only)
);

$k->setAddress(Flags::IS_BILLING, $addr);
$k->setAddress(Flags::IS_SHIPPING, $addr);

if ($gender == 1){
$gender_flag = 	Flags::MALE;
} else {
$gender_flag = 	Flags::FEMALE;	
}	


try {
    $result = $k->reserveAmount(
        $pno,   // PNO (Date of birth for AT/DE/NL)
        $gender_flag,           // Flags::MALE, Flags::FEMALE (AT/DE/NL only)
        -1,             // Automatically calculate and reserve the cart total amount
        Flags::NO_FLAG,
        PClass::INVOICE
    );

    $rno = $result[0];
    $status = $result[1];

    // $status is Flags::PENDING or Flags::ACCEPTED.


						
						if ($status == 1) {
							$order_status = $klarna_invoice_pro[$order_info['payment_iso_code_3']]['accepted_status_id'];
						} elseif ($status == 2) {
							$order_status = $klarna_invoice_pro[$order_info['payment_iso_code_3']]['pending_status_id'];
						} else {
							$order_status = $this->config->get('config_order_status_id');
						}

						
	
						$log = new Log('klarna_invoice_pro.log');
						$log->write('OK to create an invoice for order #' . $rno . '. Status: ' . $status);						
						
						
						$comment = sprintf($this->language->get('text_comment'), $rno, $this->config->get('config_currency'), $country_to_currency[$order_info['payment_iso_code_3']], $this->currency->getValue($country_to_currency[$order_info['payment_iso_code_3']]));

						$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $order_status, $comment, false);						
						
						$json['redirect'] = $this->url->link('checkout/success');
	
} catch (\Exception $e) {

                        $json['error'] = 'Failed to create an invoice for order #' . $e->getMessage() . '. Code: ' . $e->getCode();
						$log = new Log('klarna_invoice_pro.log');
						$log->write('Failed to create an invoice for order #' . $e->getMessage() . '. Code: ' . $e->getCode());
}


		}
		}

		
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function constructXmlrpc($data) {
		$type = gettype($data);

		switch ($type) {
			case 'boolean':
				if ($data == true) {
					$value = 1;
				} else {
					$value = false;
				}

				$xml = '<boolean>' . $value . '</boolean>';
				break;
			case 'integer':
				$xml = '<int>' . (int)$data . '</int>';
				break;
			case 'double':
				$xml = '<double>' . (float)$data . '</double>';
				break;
			case 'string':
					$xml = '<string>' . htmlspecialchars($data) . '</string>';
				break;
			case 'array':
				// is numeric ?
				if ($data === array_values($data)) {
					$xml = '<array><data>';

					foreach ($data as $value) {
						$xml .= '<value>' . $this->constructXmlrpc($value) . '</value>';
					}

					$xml .= '</data></array>';

				} else {
					// array is associative
					$xml = '<struct>';

					foreach ($data as $key => $value) {
						$xml .= '<member>';
						$xml .= '  <name>' . htmlspecialchars($key) . '</name>';
						$xml .= '  <value>' . $this->constructXmlrpc($value) . '</value>';
						$xml .= '</member>';
					}

					$xml .= '</struct>';
				}

				break;
			default:
				$xml = '<nil/>';
				break;
		}

		return $xml;
	}

	private function splitAddress($address) {
		$numbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

		$characters = array('-', '/', ' ', '#', '.', 'a', 'b', 'c', 'd', 'e',
						'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p',
						'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A',
						'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L',
						'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W',
						'X', 'Y', 'Z');

		$specialchars = array('-', '/', ' ', '#', '.');

		$num_pos = $this->strposArr($address, $numbers, 2);

		$street_name = substr($address, 0, $num_pos);

		$street_name = trim($street_name);

		$number_part = substr($address, $num_pos);

		$number_part = trim($number_part);

		$ext_pos = $this->strposArr($number_part, $characters, 0);

		if ($ext_pos != '') {
			$house_number = substr($number_part, 0, $ext_pos);

			$house_extension = substr($number_part, $ext_pos);

			$house_extension = str_replace($specialchars, '', $house_extension);
		} else {
			$house_number = $number_part;
			$house_extension = '';
		}

		return array($street_name, $house_number, $house_extension);
	}

	private function strposArr($haystack, $needle, $where) {
		$defpos = 10000;

		if (!is_array($needle)) {
			$needle = array($needle);
		}

		foreach ($needle as $what) {
			if (($pos = strpos($haystack, $what, $where)) !== false) {
				if ($pos < $defpos) {
					$defpos = $pos;
				}
			}
		}

		return $defpos;
	}
}