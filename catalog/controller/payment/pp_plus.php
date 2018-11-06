<?php
class ControllerPaymentPPPlus extends Controller {
	public function index() {
		$this->load->language('payment/pp_plus');
		
		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['text_loading'] = $this->language->get('text_loading');

		$data['continue'] = $this->url->link('checkout/success');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pp_plus.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/pp_plus.tpl', $data);
		} else {
			return $this->load->view('payment/pp_plus', $data);
		}
	}
	
	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'pp_plus') {
			$this->load->model('checkout/order');

			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('pp_plus_order_status_id'));
		}
	}
	
	public function send() {
	}
}
?>