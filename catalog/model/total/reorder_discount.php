<?php
class ModelTotalReorderDiscount extends Model {

	public function getTotal(&$total_data, &$total, &$taxes) {

		$this->load->language('total/reorder_discount');
		$this->load->model('marketing/reorder');

		$order_complete_total = $this->model_marketing_reorder->getTotalOrders();

		$discount_rules = $this->model_marketing_reorder->getDiscountRules();
		$current_rule = '';
		if(count($discount_rules)) {
			foreach($discount_rules as $rule) {
				if($order_complete_total >= $rule['orders_count']) {
					$current_rule = $rule;
				} else {
					break;
				}
			}
		}

		if(isset($current_rule['discount_size'])) {
			$discount = $total * $current_rule['discount_size'] / 100;

			$total_data[] = array(
				'code'			=> 'reorder_discount',
				'title'			=> $this->language->get('text_reorder_discount'),
				'value'			=> -$discount,
				'sort_order'	=> $this->config->get('reorder_discount_sort_order')
			);
      
			$total = $total - $discount;
			if ($total_data['products_total_minus_discount']) {
                foreach ($total_data['products_total_minus_discount']['products'] as &$product) {
                    $product['total'] = $product['total'] - ($product['total'] * ($current_rule['discount_size']/100));
                }
			}

			if(count($taxes)) {
				foreach($taxes as &$tax) {
					$tax = $tax * (100 - $current_rule['discount_size']) / 100;
				}
			}
		}
	}
}
?>
