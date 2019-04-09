<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerModuleFeatured extends Controller {
	public function index($setting) {
		$this->load->language('module/featured');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_pro_kg'] = $this->language->get('text_pro_kg');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		if (!empty($setting['product'])) {
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));

                        $tax_rates_raw = $this->tax->getRates($product_info['product_id'], $product_info['tax_class_id']);
                        $tax_rate = array();
                        foreach($tax_rates_raw as $tax_rate_raw)
                        {
                            $tax_rate[] = $tax_rate_raw;
                        }
                        $price_without_symbol = $product_info['price'];
                        $price_full = round($price_without_symbol + $price_without_symbol * ($tax_rate[0]['rate']/100), 2);
                        $price_full_formatted = $this->currency->format($price_full, false);
                        if ('' !== $this->currency->getSymbolRight($this->session->data['currency']))
                        {
                            $currency_symbol = $this->currency->getSymbolRight($this->session->data['currency']);
                            $price_symbol_position = 'r';
                        } elseif ('' !== $this->currency->getSymbolLeft($this->session->data['currency'])) {
                            $currency_symbol = $this->currency->getSymbolLeft($this->session->data['currency']);
                            $price_symbol_position = 'l';
                        } else {
                            $currency_symbol = $this->session->data['currency'];
                            $price_symbol_position = 'r';
                        }
                        $price_full = str_replace(",", ".", str_replace($currency_symbol, "", $price_full_formatted));

					} else {
						$price = false;
					}

					if ((float)$product_info['special']) {
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $product_info['rating'];
					} else {
						$rating = false;
					}

                    $category_data = $this->model_catalog_product->getMainCategory($product_info['product_id']);
                    $discounts = array();
                    $discounts_data = $this->model_catalog_product->getProductDiscounts($product_info['product_id']);
                    if (!empty($discounts_data)) {
                        foreach ($discounts_data as $discount)
                        {
                            $discount['price_full'] = $this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax'));
                            $discounts[] = $discount;
                        }
                    }

                    $data['products'][] = array(
						'product_id'  => $product_info['product_id'],
                        'weight'      => $product_info['weight'],
                        'thumb'       => $image,
						'name'        => $product_info['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
						'price'       => $price,
                        'discounts'   => $discounts,
                        'category'    => $category_data['name'],
                        'model'       => $product_info['model'],
                        'special'     => $special,
						'tax'         => $tax,
                        'tax_rate'    => $tax_rate,
                        'price_without_symbol' => $price_without_symbol,
                        'price_full'  => $price_full,
                        'price_full_formatted' => $price_full_formatted,
                        'currency'    => $currency_symbol,
                        'currency_position' => $price_symbol_position,
                        'rating'      => $rating,
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
                        'price_weight_special' => round($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax'))/$product_info['weight'], 2)
                    );
				}
			}
		}

		if ($data['products']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featured.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/featured.tpl', $data);
			} else {
				return $this->load->view('default/template/module/featured.tpl', $data);
			}
		}
	}
}