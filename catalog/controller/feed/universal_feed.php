<?php
class ControllerFeedUniversalFeed extends Controller {
	public function index() {
		if (empty($this->request->get['universal_feed_id'])) {
			$this->response->redirect('error/not_found');
		}

		$this->load->model('feed/universal_feed_common');

		$feed = $this->model_feed_universal_feed_common->getFeed($this->request->get['universal_feed_id']);

		if (empty($feed) || !$feed['status']) {
			$this->response->redirect('error/not_found');
		}

		$language_id = ($feed['language_id'] ? $feed['language_id'] : $this->config->get('config_language_id'));
		$currency_code = ($feed['currency_code'] ? $feed['currency_code'] : $this->config->get('config_currency'));

		$filename = $feed['universal_feed_id'] . '-s' . $this->config->get('config_store_id') . '-l' . $language_id;

		$times = json_decode($feed['date_reloaded'], TRUE);

		$last_cached = (empty($times[$this->config->get('config_store_id')]) ? 0 : $times[$this->config->get('config_store_id')]);

		if (!empty($this->request->get['force']) || $feed['cache'] <= 0 || !file_exists(DIR_CACHE . ModelFeedUniversalFeedCommon::DIR_FEED . '/' . $filename) || $last_cached + $feed['cache'] * 60 * 60 <= time()) {
			$this->model_feed_universal_feed_common->clearCache($this->request->get['universal_feed_id']);

			$language_tmp = $this->config->get('config_language_id');
			$currency_tmp = $this->currency->getCode();

			$this->config->set('config_language_id', $language_id);
			$this->currency->set($currency_code);

			$this->generate($feed, $filename);

			$this->config->set('config_language_id', $language_tmp);
			$this->currency->set($currency_tmp);

			$times[$this->config->get('config_store_id')] = time();

			$this->db->query("UPDATE " . DB_PREFIX . "universal_feed SET date_reloaded = '" . $this->db->escape(json_encode($times)) . "' WHERE universal_feed_id = " . (int)$feed['universal_feed_id']);
		}

		$this->response->addHeader('Content-Type: application/xml');

		$this->response->setOutput(file_get_contents(DIR_CACHE . ModelFeedUniversalFeedCommon::DIR_FEED . '/' . $filename));
	}

	private function generate($feed, $filename) {
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');

		$field_types = $this->model_feed_universal_feed_common->getFieldTypes();

		$tables = array();

		foreach ($feed['fields'] as $field) {
			if (isset($field_types[$field['type']])) {
				foreach ($field_types[$field['type']]['params'] as $key => $value) {
					if (!in_array($key, $tables)) {
						$tables[] = $key;
					}
				}
			}
		}

		$output = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;

		$output .= html_entity_decode($feed['free_text_before'], ENT_QUOTES, 'UTF-8');

    $output .= '<' . $feed['tag_top'] . (strstr($feed['keyword'], 'zbozi')  ? ' xmlns="http://www.zbozi.cz/ns/offer/1.0"' : ''). '>';

        if ($feed['unique_products'] == 1) {
            $temp_products = $this->model_feed_universal_feed_common->getProducts($tables, $feed['only_in_stock'], $feed['only_priced'], $feed['filter_manufacturer']);
            $feed_products = $this->model_catalog_product->getProductsFeed();
            $language_id = ($feed['language_id'] ? $feed['language_id'] : $this->config->get('config_language_id'));

            foreach ($feed_products as $feed_product) {
                if (isset($feed_product['parent_product_id'])) {
                    unset($temp_products[$feed_product['product_id']]);
                } elseif (!isset($feed_product['parent_product_id']) && isset($feed_product['name_without_weight'][$language_id]) && isset($temp_products[$feed_product['product_id']])) {
                    $temp_products[$feed_product['product_id']]['product_description']['name'] = $feed_product['name_without_weight'][$language_id];
                }
            }
            $products = $temp_products;

        } else {
            $products = $this->model_feed_universal_feed_common->getProducts($tables, $feed['only_in_stock'], $feed['only_priced'], $feed['filter_manufacturer']);
        }

		foreach ($products as $product_id => $product) {
			$output .= '<' . $feed['tag_item'] . '>';

			foreach ($feed['fields'] as $field) {
				if ($field['in_product'] && isset($field_types[$field['type']])) {
					$this->model_feed_universal_feed_common->cdata = (empty($field['cdata']) ? false : true);

                    if  ($field['setting'] == 'MerchantCategory'){
                        $results = $this->getMerchantCategories($product);
                        foreach ($results as $result){
                            $output .= '<' . $field['tag'] . '><![CDATA[' . $result . ']]></' . $field['tag'] . '>';
                        }
                        continue;
                    } elseif ($field['setting'] == 'price'){
                        $result = $this->getPriceInfo($product, $feed);
                    } elseif ($field['setting'] == 'brand'){
                        $result = $product['product']['attribute'];
                    } elseif ($field['setting'] == 'image_sort'){
                        $result = HTTP_SERVER . 'image/' . $product['product']['image_sort'];
                    } else {
                        $result = call_user_func(array($this->model_feed_universal_feed_common, 'tag' . $field_types[$field['type']]['method']), $product, $field['setting'], $feed);
                    }

					if ($result !== FALSE) {
						if (is_array($result)) {
							foreach ($result as $res) {
								if (is_array($res)) {
									$output .= '<' . $res['tag'] . '>';

									foreach ($res['values'] as $vkey => $vval) {
										$output .= '<' . $vkey . '>' . $vval . '</' . $vkey . '>';
									}

									$output .= '</' . $res['tag'] . '>';
								} else {
									$output .= '<' . $field['tag'] . '>' . $res . '</' . $field['tag'] . '>';
								}
							}
						} else {
							$output .= '<' . $field['tag'] . '>' . $result . '</' . $field['tag'] . '>';
						}
					}
				}
			}

			if ($feed['variant_type'] == 'S') {
				$output .= '</' . $feed['tag_item'] . '>';
			}

			if ($feed['tag_variant']) {
				$variants = $this->model_feed_universal_feed_common->getProductVariants($product_id, $product, $feed['only_in_stock']);

				foreach ($variants as $variant) {
					$output .= '<' . $feed['tag_variant'] . '>';

					foreach ($feed['fields'] as $field) {
						if ($field['in_variant'] && isset($field_types[$field['type']])) {
							$this->model_feed_universal_feed_common->cdata = (empty($field['cdata']) ? false : true);

							$result = call_user_func(array($this->model_feed_universal_feed_common, 'tag' . $field_types[$field['type']]['method']), $variant, $field['setting'], $feed);

							if ($result !== FALSE) {
								if (is_array($result)) {
									foreach ($result as $res) {
										if (is_array($res)) {
											$output .= '<' . $res['tag'] . '>';

											foreach ($res['values'] as $vkey => $vval) {
												$output .= '<' . $vkey . '>' . $vval . '</' . $vkey . '>';
											}

											$output .= '</' . $res['tag'] . '>';
										} else {
											$output .= '<' . $field['tag'] . '>' . $res . '</' . $field['tag'] . '>';
										}
									}
								} else {
									$output .= '<' . $field['tag'] . '>' . $result . '</' . $field['tag'] . '>';
								}
							}
						}
					}

					$output .= '</' . $feed['tag_variant'] . '>';
				}
			}

			if ($feed['variant_type'] == 'I') {
				$output .= '</' . $feed['tag_item'] . '>';
			}
		}

		$output .= '</' . $feed['tag_top'] . '>';

		$output .= html_entity_decode($feed['free_text_after'], ENT_QUOTES, 'UTF-8');

		$dirs = explode('/', ModelFeedUniversalFeedCommon::DIR_FEED);

		$actual = DIR_CACHE;

		foreach ($dirs as $dir) {
			$actual .= $dir;

			if (!is_dir($actual)) {
				mkdir($actual, 0775);
			}

			$actual .= '/';
		}

		file_put_contents(DIR_CACHE . ModelFeedUniversalFeedCommon::DIR_FEED . '/' . $filename, $output);
	}

    public function getPriceInfo($product, $feed){

        $VATRate = call_user_func(array($this->model_feed_universal_feed_common, 'tagCUSTOM_CODE'), $product,'return  $this->tax->getTax(100, $params[\'product\'][\'tax_class_id\']);', $feed);
        $currency = call_user_func(array($this->model_feed_universal_feed_common, 'tagCUSTOM_CODE'), $product,'return  $this->currency->getCode();', $feed);
        $output = '<NormalPriceWithoutVAT>' . round($product['product']['price'], 2) . '</NormalPriceWithoutVAT>';
        $output .= '<VATRate>' . $VATRate . '</VATRate>';
        $output .= '<Currency>' . $currency . '</Currency>';

        return $output;
    }

    public function getMerchantCategories ($product){

        $this->load->model('catalog/product');
        $this->load->model('feed/google_merchant_center');

        $categories = $this->model_catalog_product->getCategories($product['product']['product_id']);

        $merchantCategories = array();

        foreach ($categories as $category){
            $merchantCategories[] = $this->model_feed_google_merchant_center->getMerchantCategory($category['category_id']);
        }

        return array_unique($merchantCategories);
    }
}