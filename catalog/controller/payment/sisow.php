<?php
require_once('sisow.cls5.php');
class ControllerPaymentSisow extends Controller {
	public function _index($payment) {
		$this->load->language('payment/' . $payment);

		$data['text_readmore'] = $this->language->get('text_readmore');
		$data['text_bankcode'] = $this->language->get('text_bankcode');
		$data['text_klarna_terms'] = $this->language->get('text_klarna_terms');
		$data['text_terms_url'] = $this->language->get('text_terms_url');
		$data['text_gender'] = $this->language->get('text_gender');
		$data['text_sir'] = $this->language->get('text_sir');
		$data['text_madam'] = $this->language->get('text_madam');
		$data['text_iban'] = $this->language->get('text_iban');
		$data['text_coc'] = $this->language->get('text_coc');
		$data['text_tphone'] = $this->language->get('text_tphone');
		$data['text_birthday'] = $this->language->get('text_birthday');
		$data['text_klarna_account'] = $this->language->get('text_klarna_account');
		$data['text_month'] = $this->language->get('text_month');
		$data['text_bank'] = $this->language->get('text_bank');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_select_day'] = $this->language->get('text_select_day');
		$data['text_select_month'] = $this->language->get('text_select_month');
		$data['text_select_year'] = $this->language->get('text_select_year');
		$data['text_select_gender'] = $this->language->get('text_select_gender');

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$data['text_description'] = $this->language->get('text_description');
		$data['text_phone'] = $order_info['telephone'];

		if ($payment == 'sisowideal') {
			$sisow = new Sisow($this->config->get($payment . '_merchantid'), $this->config->get($payment . '_merchantkey'), $this->config->get($payment . '_shopid'));
			$sisow->DirectoryRequest($arr, false, $this->config->get($payment . '_testmode') == 'true');
			$data['banks'] = $arr;
		} else if ($payment == 'sisowklarna' || $payment == 'sisowklaacc' || $payment == 'sisowfocum' || $payment == 'sisowpp') {
			$data['text_klarnaid'] = $this->config->get($payment . '_klarnaid');
			// Klarna fee
			if ($payment == 'sisowklarna') {
				if (isset($this->session->data['sisowklarnafee']['fee'])) {
					$fee = $this->session->data['sisowklarnafee']['fee'];
					if (isset($this->session->data['sisowklarnafee']['feetax'])) {
						$fee += $this->session->data['sisowklarnafee']['feetax'];
					}
					$data['text_fee'] = $fee;
					$data['text_paymentfee'] = str_replace('{fee}', $this->currency->format($fee), $this->language->get('text_paymentfee'));
				} else {
					$data['text_fee'] = '';
					$data['text_paymentfee'] = '';
				}
			// Focum fee
			} else if ($payment == 'sisowfocum') {	
				if (isset($this->session->data['sisowfocumfee']['fee'])) {
					$fee = $this->session->data['sisowfocumfee']['fee'];
					if (isset($this->session->data['sisowfocumfee']['feetax'])) {
						$fee += $this->session->data['sisowfocumfee']['feetax'];
					}
					$data['text_fee'] = $fee;
					$data['text_paymentfee'] = str_replace('{fee}', $this->currency->format($fee), $this->language->get('text_paymentfee'));
				}
			// PayPal fee
			} else if ($payment == 'sisowpp') {	
				if (isset($this->session->data['sisowppfee']['fee'])) {
					$fee = $this->session->data['sisowppfee']['fee'];
					if (isset($this->session->data['sisowppfee']['feetax'])) {
						$fee += $this->session->data['sisowppfee']['feetax'];
					}
					$data['text_fee'] = $fee;
					$data['text_paymentfee'] = str_replace('{fee}', $this->currency->format($fee), $this->language->get('text_paymentfee'));
				}
			} else {
				$sisow = new Sisow($this->config->get($payment . '_merchantid'), $this->config->get($payment . '_merchantkey'), $this->config->get($payment . '_shopid'));
				$m = $sisow->FetchMonthlyRequest($order_info['total']);
				$data['text_monthly'] = $m > 0 ? $this->currency->format(round($m / 100.0, 2)) : false;
				$data['text_pclass'] = $m > 0 ? $sisow->pclass : false;
				$data['text_fee'] = $m;
				$data['text_paymentfee'] = '';
			}
		// Overboeking
		} else if ($payment == 'sisowovb') {
			$data['text_ovb'] = $this->language->get('text_ovb');
		}

		// Afterpay, Focum, Klarna: Day, month, year select
		$data['days'] = array();
		for ($i = 1; $i <= 31; $i++) {
			$data['days'][] = array(
				'text'  => strftime('%d', mktime(0, 0, 0, 31, $i)),
				'value' => sprintf('%02d', $i)
			);
		}
		$data['months'] = array();
		for ($i = 1; $i <= 12; $i++) {
			$data['months'][] = array(
				'text'  => strftime('%d', mktime(0, 0, 0, 12, $i)),
				'value' => sprintf('%02d', $i)
			);
		}
		$today = getdate();
		$data['year_valid'] = array();
		for ($i = $today['year'] - 17; $i > $today['year'] - 99; $i--) { 

			$data['year_valid'][] = array(
				'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
				'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
			);
		}
		$data['year_expire'] = array();
		for ($i = $today['year'] - 17; $i > $today['year'] - 99; $i--) { 
			$data['year_expire'][] = array(
				'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
				'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
			);
		}

		$data['text_header'] = $this->language->get('text_header');
		$data['text_redirect'] = $this->language->get('text_redirect');
		$data['button_confirm'] = $this->language->get('button_confirm');
		
		// if b2b is yes, checkout via sisowafterpayb2b.tpl
		if ($this->config->get($payment . '_useb2b') == 'true') $payment .= 'b2b';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/'.$payment.'.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/'.$payment.'.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/'.$payment.'.tpl', $data);
		}
	}

	public function _redirectbank($payment) {
		$this->load->language('payment/' . $payment);

		$data['error_nobank'] = $this->language->get('error_nobank');
		$data['error_nogender'] = $this->language->get('error_nogender');
		$data['error_nophone'] = $this->language->get('error_nophone');
		$data['error_noiban'] = $this->language->get('error_noiban');
		$data['error_nobirthday'] = $this->language->get('error_nobirthday');
		$data['error_nococ'] = $this->language->get('error_nococ');

		// control bank choice, bankcode
		if ($payment == 'sisowideal') {
			if (!$this->request->post['sisowbank']) {
				$json['error'] = $this->language->get('error_nobank');
			}
		}
		if ($payment == 'sisowgiropay') {
			if (!$this->request->post['bic_giropay']) {
				$json['error'] = $this->language->get('error_nobank');
			}
		}
		if ($payment == 'sisoweps') {
			if (!$this->request->post['bic_eps']) {
				$json['error'] = $this->language->get('error_nobank');
			}
		}

		// control gender, phone, iban
		if ($payment == 'sisowklarna' || $payment == 'sisowklaacc' || $payment == 'sisowfocum' || $payment == 'sisowafterpay') {
			if (!isset($this->request->post['sisowgender']) || $this->request->post['sisowgender'] == '') {
				$json['error'] = $this->language->get('error_nogender');
			}
			if (!isset($this->request->post['sisowphone']) || $this->request->post['sisowphone'] == '') {
				$json['error'] = $this->language->get('error_nophone');
			}
			if ($payment == 'sisowfocum' &&  (!isset($this->request->post['sisowiban']) || $this->request->post['sisowiban'] == '')) {
				$json['error'] = $this->language->get('error_noiban');
			}
			
			// control birthdate
			$day = (int)$this->request->post['sisowday'];
			$month = (int)$this->request->post['sisowmonth'];
			$year = (int)$this->request->post['sisowyear'];
			if ($day < 1 || $day > 31 || $month < 1 || $month > 12 || $year < 0) {
				$json['error'] = $this->language->get('error_nobirthday');
			}
			if ($year < 100) {
				$year += 1900;
			}
			$posts['birthdate'] = sprintf('%02d%02d%04d', $day, $month, $year);
			$posts['gender'] = $this->request->post['sisowgender'];
			$posts['billing_phone'] = $this->request->post['sisowphone'];

			if ($payment == 'sisowfocum')
				$posts['iban'] = $this->request->post['sisowiban'];

			if ($payment == 'sisowafterpay' && $this->config->get($payment . '_useb2b') == 'true') {
				$posts['billing_coc'] = $this->request->post['sisowcoc'];
				if (!isset($this->request->post['sisowcoc']) || $this->request->post['sisowcoc'] == '') {
				$json['error'] = $this->language->get('error_nococ');
				}
			}
		}

		if (empty($json['error'])) {
			$this->load->language('payment/' . $payment);
			$this->load->model('payment/'. $payment);

			$this->load->model('checkout/order');
			$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

			$sisow = new Sisow($this->config->get($payment . '_merchantid'), $this->config->get($payment . '_merchantkey'), $this->config->get($payment . '_shopid'));
			
			switch ($payment) {
				case 'sisowideal':
					$sisow->issuerId = $this->request->post['sisowbank'];
					break;
				case 'sisowklarna':
					$sisow->payment = 'klarna';
					$fee = $feetax = $feetaxrate = 0;
					if (isset($this->session->data['sisowklarnafee']['fee'])) {
						$fee = $this->session->data['sisowklarnafee']['fee'];
						if (isset($this->session->data['sisowklarnafee']['feetax'])) {
							$feetax = $this->session->data['sisowklarnafee']['feetax'];
						}
					}
					break;
				case 'sisowfocum':
					$sisow->payment = 'focum';
					$fee = $feetax = $feetaxrate = 0;
					if (isset($this->session->data['sisowfocumfee']['fee'])) {
						$fee = $this->session->data['sisowfocumfee']['fee'];
						if (isset($this->session->data['sisowfocumfee']['feetax'])) {
							$feetax = $this->session->data['sisowfocumfee']['feetax'];
						}
					}
					break;
				case 'sisowklaacc':
					$sisow->payment = 'klarnaacc';
					break;
				case 'sisowovb':
					$sisow->payment = 'overboeking';
					break;
				case 'sisowmc':
					$sisow->payment = 'mistercash';
					break;
				case 'sisowde':
					$sisow->payment = 'sofort';
					break;
				case 'sisowhomepay':
					$sisow->payment = 'homepay';
					break;
				case 'sisoweps':
					$sisow->payment = 'eps';
					break;
				case 'sisowgiropay':
					$sisow->payment = 'giropay';
					break;
				case 'sisowwg':
					$sisow->payment = 'webshop';
					break;
				case 'sisowmaestro':
					$sisow->payment = 'maestro';
					break;
				case 'sisowmastercard':
					$sisow->payment = 'mastercard';
					break;
				case 'sisowvisa':
					$sisow->payment = 'visa';
					break;
				case 'sisowvvv':
					$sisow->payment = 'vvv';
					break;
				case 'sisowafterpay':
					$sisow->payment = 'afterpay';
					break;
				case 'sisowbelfius':
					$sisow->payment = 'belfius';
					break;
				case 'sisowbunq':
					$sisow->payment = 'bunq';
					break;
				case 'sisowidealqr':
					$sisow->payment = 'idealqr';
					break;
				case 'sisowpp':
					$sisow->payment = 'paypalec';
					$fee = $feetax = $feetaxrate = 0;
					if (isset($this->session->data['sisowppfee']['fee'])) {
						$fee = $this->session->data['sisowppfee']['fee'];
						if (isset($this->session->data['sisowppfee']['feetax'])) {
							$feetax = $this->session->data['sisowppfee']['feetax'];
						}
					}
					break;
				case 'sisowvpay':
					$sisow->payment = 'vpay';
					break;
			}
			
			if ($payment == 'sisowovb') {
				$sisow->purchaseId = $this->config->get($payment . '_prefix') . $order_info['order_id'];
				$sisow->entranceCode = $order_info['order_id'];
			} else {
				$sisow->purchaseId = $order_info['order_id'];
			}
			
			$sisow->description = $this->config->get('config_name') . " order " . $order_info['order_id'];
			$sisow->amount = $order_info['total'];
			$posts['currency'] = $this->session->data['currency'];

			$sisow->notifyUrl = $this->url->link('payment/' . $payment . '/notify');
			$sisow->returnUrl = $sisow->notifyUrl;
			
			if ($this->config->get($payment . '_testmode') == 'true') {
				$posts['testmode'] = 'true';
			}

			if ($payment == 'sisowklaacc') {
				$posts['pclass'] = $this->request->post['sisowpclass'];

			} else if ($payment == 'sisowklarna' || $payment == 'sisowklaacc') {
				$posts['makeinvoice'] = $this->config->get($payment . '_makeinvoice'); 
				$posts['mailinvoice'] = $this->config->get($payment . '_mailinvoice'); 

			} else if ($payment == 'sisowovb') {
				if ($this->config->get('sisowovb_days') > 0)
					$posts['days'] = $this->config->get('sisowovb_days');
				if ($this->config->get('sisowovb_paylink') == 'true')
					$posts['including'] = 'true';

			} else if($payment == 'sisowgiropay' || $payment == 'sisoweps') {
				$posts['bic'] = $payment == 'sisowgiropay' ? $this->request->post['bic_giropay'] : $this->request->post['bic_eps'];
			}

			if ($order_info['customer_id']) {
				$posts['customer'] = $order_info['customer_id'];
			}
			$posts['ipaddress'] = $this->request->server['REMOTE_ADDR'];
			// billing
			$posts['billing_company']	= $order_info['payment_company'];
			$posts['billing_firstname']	= $order_info['payment_firstname'];
			$posts['billing_lastname']	= $order_info['payment_lastname'];
			$posts['billing_address1']	= $order_info['payment_address_1'];
			if (!empty($order_info['payment_address_2']))
				$posts['billing_address2'] = $order_info['payment_address_2'];
			$posts['billing_zip']		= $order_info['payment_postcode'];
			$posts['billing_city']		= $order_info['payment_city'];
			$posts['billing_mail']		= $order_info['email'];
			$posts['billing_country']	= $order_info['payment_country'];
			$posts['billing_countrycode'] =$order_info['payment_iso_code_2'];
			if (!isset($posts['billing_phone']))
				$posts['billing_phone']		= $order_info['telephone'];
			
			// shipping
			$posts['shipping_company']	= $order_info['shipping_company'];
			$posts['shipping_firstname']	= $order_info['shipping_firstname'];
			$posts['shipping_lastname']	= $order_info['shipping_lastname'];
			$posts['shipping_address1']	= $order_info['shipping_address_1'];
			if (!empty($order_info['shipping_address_2']))
				$posts['shipping_address2'] = $order_info['shipping_address_2'];
			$posts['shipping_zip']		= $order_info['shipping_postcode'];
			$posts['shipping_city']		= $order_info['shipping_city'];
			$posts['shipping_mail']		= $order_info['email'];
			$posts['shipping_phone']	= $order_info['telephone'];
			$posts['shipping_country']	= $order_info['shipping_country'];
			$posts['shipping_countrycode'] = $order_info['shipping_iso_code_2'];
			
			// currency
			$posts['currency'] = $order_info['currency_code'];
				
			// products
			$products_info = $this->cart->getProducts();
			$i = 1;
			foreach ($products_info as $key => $data) {
				$taxrate = $this->_getRate($data['tax_class_id']);
				$posts['product_id_' . $i] = $data['product_id'];
				$posts['product_description_' . $i] = $data['name'];
				$posts['product_quantity_' . $i] = $data['quantity'];
				$posts['product_weight_' . $i] = round($data['weight'] * 1000, 0);
				$posts['product_netprice_' . $i] = round($data['price'] * 100, 0);
				$posts['product_nettotal_' . $i] = round($data['total'] * 100, 0);
				if ($taxrate) {
					$posts['product_taxrate_' . $i] = round($taxrate * 100, 0);
					$posts['product_tax_' . $i] = round($data['price'] * $taxrate, 0);
					$posts['product_total_' . $i] = round($data['total'] * ($taxrate / 100 + 1) * 100, 0);
				} else {
					$posts['product_taxrate_' . $i] = "0";
					$posts['product_tax_' . $i] = "0";
					$posts['product_total_' . $i] = $posts['product_nettotal_' . $i];
				}
				$i++;
			}
			// Shipping
			if ($this->cart->hasShipping() && isset($this->session->data['shipping_method']) && $this->config->get('shipping_status')) {
				$shipping = $this->session->data['shipping_method']['cost'];
				$shiptax = $shiptaxrate = 0;
				if ($this->session->data['shipping_method']['tax_class_id']) {
					$shiptaxrate = $this->_getRate($this->session->data['shipping_method']['tax_class_id']);
					$shiptax = round($shipping * $shiptaxrate / 100, 2);
				}
				$posts['product_id_' . $i] = 'shipping';
				$posts['product_description_' . $i] = 'Verzendkosten';
				$posts['product_quantity_' . $i] = 1;
				$posts['product_netprice_' . $i] = round($shipping * 100, 0);
				$posts['product_nettotal_' . $i] = round($shipping * 100, 0);
				if ($shiptaxrate) {
					$posts['product_taxrate_' . $i] = round($shiptaxrate * 100, 0);
					$posts['product_tax_' . $i] = round($shiptax * 100, 0);
					$posts['product_price_' . $i] = round(($shipping + $shiptax) * 100, 0);
					$posts['product_total_' . $i] = round(($shipping + $shiptax) * 100, 0);
				} else {
					$posts['product_taxrate_' . $i] = "0";
					$posts['product_tax_' . $i] = "0";
					$posts['product_total_' . $i] = $posts['product_nettotal_' . $i];
				}
				$i++;
			}
			// Payment fee
			if (($payment == 'sisowpp' || $payment == 'sisowklarna' || $payment == 'sisowfocum') && $fee) {
				$feetaxrate = $this->_getRate($this->config->get($payment . 'fee_tax'));
				$posts['product_id_' . $i] = 'paymentfee';
				$posts['product_description_' . $i] = 'Payment fee';
				$posts['product_quantity_' . $i] = 1;
				$posts['product_netprice_' . $i] = round($fee * 100, 0);
				$posts['product_nettotal_' . $i] = round($fee * 100, 0);
				if ($feetaxrate) {
					$posts['product_taxrate_' . $i] = round($feetaxrate * 100, 0);
					$posts['product_tax_' . $i] = round($feetax * 100, 0);
					$posts['product_price_' . $i] = round(($fee + $feetax) * 100, 0);
					$posts['product_total_' . $i] = round(($fee + $feetax) * 100, 0);
				} else {
					$posts['product_taxrate_' . $i] = "0";
					$posts['product_tax_' . $i] = "0";
					$posts['product_total_' . $i] = $posts['product_nettotal_' . $i];
				}
				$i++;
			}
			
			// Request
			$json = array();
			if (($ex = $sisow->TransactionRequest($posts)) < 0) {
				$this->log->write($payment . ': TransactionRequest ' . $ex . ' ' . $sisow->errorMessage);

				if ($payment == 'sisowklarna' || $payment == 'sisowklarnaacc' || $payment == 'sisowfocum' || $payment == 'sisowafterpay')
					$json['error'] = $ex . ' ' . $sisow->errorMessage;
				else
					$json['error'] = 'Geen communicatie mogelijk (' . $ex . ' ' . $sisow->errorCode . ')';
			} else if ($payment == 'sisowklarna' || $payment == 'sisowklaacc' || $payment == 'sisowfocum' || $payment == 'sisowafterpay') {
				if ($sisow->pendingKlarna)
					$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get($payment . '_status_pending'));
				else
					$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get($payment . '_status_success'));
				$message = 'Transactie ' . $sisow->trxId . ' gecontroleerd door Sisow.';
				if ($sisow->invoiceNo) {
					$message .= '<br/>'.$this->_getDesc($payment).' invoice ' . $sisow->invoiceNo . '';
				} else {
					$message .= '<br/><br/><a href="https://www.sisow.nl/Sisow/iDeal/RestHandler.ashx/CancelReservationRequest?report=true&merchantid=' . $this->config->get($payment . '_merchantid') . '&trxid=' . $sisow->trxId . '&sha1=' . sha1($sisow->trxId . $this->config->get($payment . '_merchantid') . $this->config->get($payment . '_merchantkey')) . '" target="_blank" onclick="return confirm(\'Bent u zeker? De '.$this->_getDesc($payment).' reservering wordt geannuleerd!\');">Annuleer '.$this->_getDesc($payment).' reservering</a>';
				}
				$message .= '<br/><br/><a href="https://www.sisow.nl/Sisow/iDeal/RestHandler.ashx/InvoiceRequest?report=true&'.($payment == 'sisowklaacc' ? '' : 'returnpdf=true&').'merchantid=' . $this->config->get($payment . '_merchantid') . '&trxid=' . $sisow->trxId . '&sha1=' . sha1($sisow->trxId . $this->config->get($payment . '_merchantid') . $this->config->get($payment . '_merchantkey')) . '" target="_blank" onclick="return confirm(\'Bent u zeker? De '.$this->_getDesc($payment).' factuur wordt gegenereerd!\');">Maak of open '.$this->_getDesc($payment).' factuur</a>';
				$message .= '<br/><br/><a href="https://www.sisow.nl/Sisow/iDeal/RestHandler.ashx/CreditInvoiceRequest?report=true&'.($payment == 'sisowklaacc' ? '' : 'returnpdf=true&').'merchantid=' . $this->config->get($payment . '_merchantid') . '&trxid=' . $sisow->trxId . '&sha1=' . sha1($sisow->trxId . $this->config->get($payment . '_merchantid') . $this->config->get($payment . '_merchantkey')) . '" target="_blank" onclick="return confirm(\'Bent u zeker? De '.$this->_getDesc($payment).' factuur wordt gecrediteerd!\');">Maak of open '.$this->_getDesc($payment).' creditnota</a>';
				$message .= '<br/><br/>';
				if ($sisow->pendingKlarna)
					$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get($payment . '_status_pending'), $message, false);
				else
					$this->model_checkout_order->addOrderHistory($order_info['order_id'], $this->config->get($payment . '_status_success'), $message, false);

				$reurl = $this->url->link('checkout/success');
				$json['redirect'] = $reurl;
			} else if ($payment == 'sisowovb') {
				$this->model_checkout_order->addOrderHistory($order_info['order_id'], 1);
				$message = 'Transactie ' . $sisow->trxId . ' gecontroleerd door Sisow.<br />';
				$this->model_checkout_order->addOrderHistory($order_info['order_id'], 1, $message, false);

				$reurl = $this->url->link('checkout/success');
				
				$json['redirect'] = $reurl;
			} else {
				$json['redirect'] = $sisow->issuerUrl;
			}
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function _notify($payment) {
		if (isset($this->request->get['trxid'])) {
			$this->load->model('payment/' . $payment);

			$trxid = $this->request->get['trxid'];
			$order_id = $this->request->get['ec'];

			$this->load->model('checkout/order');
			$order_info = $this->model_checkout_order->getOrder($order_id);
						
			if ($order_info['order_status_id'] != $this->config->get($payment . '_status_success')) {
				if (($payment == 'sisowklarna' || $payment == 'sisowklaacc') && $this->request->get['action']) {
					if ($this->request->get['action'] == 'invoice') {
						$this->model_checkout_order->addOrderHistory($order_id, $order_info['order_status_id']);
						$message = 'Transactie ' . $trxid . ' gecontroleerd door Sisow.<br />';
						$message .= $this->_getDesc($payment).' invoice created.';
						$this->model_checkout_order->addOrderHistory($order_id, $order_info['order_status_id'], $message, false);
						echo 'OK';
					} else if ($this->request->get['action'] == 'creditinvoice') {
						$this->model_checkout_order->addOrderHistory($order_id, 7);
						$message = 'Transactie ' . $trxid . ' gecontroleerd door Sisow.<br />';
						$message .= $this->_getDesc($payment).' credit invoice created.';
						$this->model_checkout_order->addOrderHistory($order_id, 7, $message, false);
						echo 'OK';
					} else if ($this->request->get['action'] == 'cancelreservation') {
						$this->model_checkout_order->addOrderHistory($order_id, 7);
						$message = 'Transactie ' . $trxid . ' gecontroleerd door Sisow.<br />';
						$message .= $this->_getDesc($payment).' reservation cancelled.';
						$this->model_checkout_order->addOrderHistory($order_id, 7, $message, false);
						echo 'OK';
					}
					return;
				}

				$sisow = new Sisow($this->config->get($payment . '_merchantid'), $this->config->get($payment . '_merchantkey'), $this->config->get($payment . '_shopid'));
				if (($ex = $sisow->StatusRequest($trxid)) < 0) {
					$this->log->write($payment . ': StatusRequest ' . $ex . ' ' . $sisow->errorMessage);
					header("Status: 404 Not Found");
					echo 'NOK ' . $ex;
				} else {
					if ($sisow->status == 'Success' || $sisow->status == 'Reservation') {
						$this->model_checkout_order->addOrderHistory($order_id, $this->config->get($payment . '_status_success'));
						$message = 'Transactie ' . $trxid . ' gecontroleerd door Sisow.<br />';
						if ($payment == 'sisowideal') {
							$message .= 'Bankrekening: ' . $sisow->consumerAccount . '.<br />';
							$message .= 'Ten name van: ' . $sisow->consumerName . '.<br />';
							$message .= 'Plaats: ' . $sisow->consumerCity . '.<br />';
						}
						$this->model_checkout_order->addOrderHistory($order_id, $this->config->get($payment . '_status_success'), $message, true);
					}
					if ($sisow->status == 'Denied') {

					}
				}
			}
		}
		
		if (!isset($_GET['notify']) && !isset($_GET['callback'])) {
			if ($this->request->get['status'] == 'Success')
				header("Location: " . $this->url->link('checkout/success'));
			else
				header("Location: " . $this->url->link('checkout/checkout'));
		}
		exit;
	}

	private function _getRate($tax_class_id) {
		if (method_exists($this->tax, 'getRate')) {
			return $this->tax->getRate($tax_class_id);
		} else {
			$tax_rates = $this->tax->getRates(100, $tax_class_id);
			foreach ($tax_rates as $tax_rate) {
				return $tax_rate['amount'];
			}
		}
	}

	private function _getDesc($payment) {
		switch ($payment) {
			case 'sisowklarna':
				return 'Sisow Klarna Invoice';
			case 'sisowklaacc':
				return 'Sisow Klarna Account';
			default:
				return '';
		}
	}
}