<?php
class ControllerPaymentStripe extends Controller {
	public function index() {
		$this->language->load('payment/stripe');

		$data['text_credit_card'] = $this->language->get('text_credit_card');
		$data['text_start_date'] = $this->language->get('text_start_date');
		$data['text_issue'] = $this->language->get('text_issue');
		$data['text_wait'] = $this->language->get('text_wait');
		$data['text_ajax_error'] = $this->language->get('text_ajax_error');
		$data['text_please_wait'] = $this->language->get('text_please_wait');
		$data['text_valid_cc'] = $this->language->get('text_valid_cc');
		$data['text_valid_cvc'] = $this->language->get('text_valid_cvc');


		$data['entry_cc_type'] = $this->language->get('entry_cc_type');
		$data['entry_cc_number'] = $this->language->get('entry_cc_number');
		$data['entry_cc_start_date'] = $this->language->get('entry_cc_start_date');
		$data['entry_cc_expire_date'] = $this->language->get('entry_cc_expire_date');
		$data['entry_cc_cvv2'] = $this->language->get('entry_cc_cvv2');
		$data['entry_cc_issue'] = $this->language->get('entry_cc_issue');

		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['publishable_key']=($this->config->get('stripe_test') ? $this->config->get('stripe_test_publishable_key') : $this->config->get('stripe_live_publishable_key'));
		$data['secret_key']=($this->config->get('stripe_test') ? $this->config->get('stripe_test_secret_key') : $this->config->get('stripe_live_secret_key'));

		$data['cards'] = array();

		$data['cards'][] = array(
			 'text'  => 'Visa',
			 'value' => 'VISA'
		);

		$data['cards'][] = array(
			 'text'  => 'MasterCard',
			 'value' => 'MASTERCARD'
		);

		$data['cards'][] = array(
			 'text'  => 'Discover Card',
			 'value' => 'DISCOVER'
		);

		$data['cards'][] = array(
			 'text'  => 'American Express',
			 'value' => 'AMEX'
		);

		$data['cards'][] = array(
			 'text'  => 'JCB',
			 'value' => 'JCB'
		);

		$data['cards'][] = array(
			 'text'  => 'Diners Club',
			 'value' => 'DINERS'
		);

		$data['months'] = array();

		for ($i = 1; $i <= 12; $i++) {
			$data['months'][] = array(
				 'text'  => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)),
				 'value' => sprintf('%02d', $i)
			);
		}

		$today = getdate();

		$data['year_expire'] = array();

		for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
			$data['year_expire'][] = array(
				 'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
				 'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i))
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/stripe.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/stripe.tpl';
		} else {
			$this->template = 'default/template/payment/stripe.tpl';
		}

		//pass customer info
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$data['order_info'] = $order_info;

		if ($this->config->get('stripe_journal_mode')) {
			$data['journal_mode']=true;
		} else {
			$data['journal_mode']=false;
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/stripe.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/stripe.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/stripe.tpl', $data);
		}
	}

	public function send() {
		require('system/library/stripe-php-3.21.0/init.php');

		$secret_key=($this->config->get('stripe_test') ? $this->config->get('stripe_test_secret_key') : $this->config->get('stripe_live_secret_key'));

		$this->load->model('checkout/order');

		try {
			\Stripe\Stripe::setApiKey($secret_key);
			\Stripe\Stripe::setApiVersion("2016-07-06");

			$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
			if (empty($order_info)) throw new Exception('Invalid order information, please try again.');

			if ($this->config->get('stripe_prevent_duplicate_charge')) {
				if ($order_info['order_status_id']==$this->config->get('stripe_order_status_id')) {
					//this order has already processed, prevent it from being processed again
					$json['success'] = $this->url->link('checkout/success');
				}
			}

			if (empty($json['success'])) {
				$token = $_REQUEST['token'];

				if ($this->config->get('stripe_transaction')) {
					//sale (auth & capture)
					$capture = true;
				} else {
					//authorization only
					$capture = false;
				}

				$total = (float)$order_info['total'] * $order_info['currency_value'];

				\Stripe\Charge::create(array(
					 'amount' => (int)number_format($total * 100, 0, '.', ''),
					 'currency' => $order_info['currency_code'],
					 'source' => $token,
					 'capture' => $capture,
					 'metadata' => array('order_id' => $order_info['order_id'],
						  'customer_email' => $order_info['email'])
				));

				$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('stripe_order_status_id'), false, false);
				$json['success'] = $this->url->link('checkout/success');
			}


		} catch (\Stripe\Error\InvalidRequest $e) {
			// Invalid parameters were supplied to Stripe's API
			$json['error'] = (string)$e->getMessage();
		} catch (\Stripe\Error\Authentication $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$json['error'] = (string)$e->getMessage();
		} catch (\Stripe\Error\ApiConnection $e) {
			// Network communication with Stripe failed
			$json['error'] = (string)$e->getMessage();
		} catch (\Stripe\Error\Base $e) {
			// Display a very generic error to the user, and maybe send
			// yourself an email
			$json['error'] = (string)$e->getMessage();
		} catch (Exception $e) {
			// Something else happened, completely unrelated to Stripe
			$json['error'] = (string)$e->getMessage();
		}


		$this->response->setOutput(json_encode($json));
	}
}