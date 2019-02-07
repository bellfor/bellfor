<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelTotalTax extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {

        foreach ($taxes as $key => $value) {
            $tax = 0;
            $key_tax= 0;
            if ($total_data['products_total_minus_discount']) {
                foreach ($total_data['products_total_minus_discount']['products'] as &$product) {
                    $tax_rates = $this->tax->getRates($product['total'], $product['tax_class_id']);
                    foreach ($tax_rates as $key_rate => $rate) {
                        if ($key_rate == $key){
                            $tax += $rate['amount'];
                            $key_tax = $key_rate;
                        }
                    }
                }
            }

            if ($value > 0 && $key == $key_tax) {
                $total_data[] = array(
                    'code' => 'tax',
                    'title' => $this->tax->getRateName($key),
                    'value' => $tax,
                    'sort_order' => $this->config->get('tax_sort_order')
                );

                $total += $tax;
            }
        }
	}
}