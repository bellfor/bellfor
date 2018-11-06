<?php
class ControllerMarketingReorder extends Controller {
	private $error = array();

	public function reorder() {
		$this->load->language('account/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$this->load->model('account/order');

		$order_info = $this->model_account_order->getOrder($order_id);

		if ($order_info) {
			$products = $this->model_account_order->getOrderProducts($order_id);

			if(count($products)) {
				$success = array();
				$error = array();
				foreach($products as $product) {

					$order_product_id = $product['order_product_id'];
					$order_product_info = $this->model_account_order->getOrderProduct($order_id, $order_product_id);

					if($order_product_info) {
						$this->load->model('catalog/product');

						$product_info = $this->model_catalog_product->getProduct($order_product_info['product_id']);

						if($product_info) {
							$option_data = array();

							$order_options = $this->model_account_order->getOrderOptions($order_product_info['order_id'], $order_product_id);

							foreach($order_options as $order_option) {
								if($order_option['type'] == 'select' || $order_option['type'] == 'radio' || $order_option['type'] == 'image') {
									$option_data[$order_option['product_option_id']] = $order_option['product_option_value_id'];
								} elseif($order_option['type'] == 'checkbox') {
									$option_data[$order_option['product_option_id']][] = $order_option['product_option_value_id'];
								} elseif($order_option['type'] == 'text' || $order_option['type'] == 'textarea' || $order_option['type'] == 'date' || $order_option['type'] == 'datetime' || $order_option['type'] == 'time') {
									$option_data[$order_option['product_option_id']] = $order_option['value'];
								} elseif($order_option['type'] == 'file') {
									$option_data[$order_option['product_option_id']] = $this->encryption->encrypt($order_option['value']);
								}
							}

							$this->cart->add($order_product_info['product_id'], $order_product_info['quantity'], $option_data);

							$success[] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $product_info['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

							unset($this->session->data['shipping_method']);
							unset($this->session->data['shipping_methods']);
							unset($this->session->data['payment_method']);
							unset($this->session->data['payment_methods']);
						} else {
							$error[] = sprintf($this->language->get('error_reorder'), $order_product_info['name']);
						}
					}
				}
				if(count($success)) {
					$this->session->data['success'] = '<div class="success-table table-info-box">' . implode('<br />', $success) . '</div>';
				}
				if(count($error)) {
					$this->session->data['error'] = '<div class="error-table table-info-box">' . implode('<br />', $error) . '</div>';
				}

			}
		}

		$this->response->redirect($this->url->link('account/order'));
	}
}
?>
