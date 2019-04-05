<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerModuleBestSellerPlainList extends Controller {
	public function index($setting) {
		$this->load->language('module/bestseller_plain_list');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_tax'] = $this->language->get('text_tax');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

        $data['text_tax'] = $this->language->get('text_tax');
        $data['text_pro_kg'] = $this->language->get('text_pro_kg');

        $data['link_versand'] = $this->url->link('information/information', 'information_id=112');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

		$results = $this->model_catalog_product->getBestSellerProducts($setting['limit']);

		if ($results) {
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

                $tax_rates_raw = $this->tax->getRates($result['product_id'], $result['tax_class_id']);
                $tax_rate = array();
                foreach($tax_rates_raw as $tax_rate_raw)
                {
                    $tax_rate[] = $tax_rate_raw;
                }

				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
                    'tax_rate'    => $tax_rate,
					'tax'         => $tax,
					'rating'      => $rating,
                    'price_weight'=> round($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))/$result['weight'], 2),
                    'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/bestseller_plain_list.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/bestseller_plain_list.tpl', $data);
			} else {
				return $this->load->view('default/template/module/bestseller_plain_list.tpl', $data);
			}
		}
	}
}
