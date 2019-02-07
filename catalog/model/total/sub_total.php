<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelTotalSubTotal extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		$this->load->language('total/sub_total');

		$sub_total = $this->cart->getSubTotal();

		if (isset($this->session->data['vouchers']) && $this->session->data['vouchers']) {
			foreach ($this->session->data['vouchers'] as $voucher) {
				$sub_total += $voucher['amount'];
			}
		}

		$total_data[] = array(
			'code'       => 'sub_total',
			'title'      => $this->language->get('text_sub_total'),
			'value'      => $sub_total,
			'sort_order' => $this->config->get('sub_total_sort_order')
		);

		//Modification: record auxiliary array of product prices without tax,
        $products = array();

        foreach ($this->cart->getProducts() as $product) {

            $products[] = array(
                'product_id'   => $product['product_id'],
                'total'        => $product['total'],
                'tax_class_id' => $product['tax_class_id']
            );
        }

        $total_data['products_total_minus_discount'] = array(
            'products' => $products
        );
        /*------------------------------------------------------------------*/

        $total += $sub_total;
	}
}