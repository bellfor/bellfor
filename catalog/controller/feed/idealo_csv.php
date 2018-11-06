<?php 
class ControllerFeedIdealoCSV extends Controller {
	private function time_diff_conv($start, $s) {
		$t = array( 
		    'd' => 86400,
		    'h' => 3600,
		    'm' => 60,
		);
		$string = '';
		$s = abs($s - $start);
		foreach($t as $key => &$val) {
		    $$key = floor($s/$val);
		    $s -= ($$key*$val);
		    $string .= ($$key==0) ? '' : $$key . "$key ";
		}
		return $string . $s. 's';
	}

	public function index() {
		set_time_limit ( 1800 );
	  	$start_time = time();

		$i = 0;
		$setting = 0;  
		if ($this->config->get('idealo_csv_status')) { 

			$this->load->model('feed/idealo_csv');
			$data = $this->model_feed_idealo_csv->getSetting('idealo_csv');

			$strstart   = $data['idealo_csv_data_feed_seperator'];
			$strnext    = $data['idealo_csv_data_feed_seperator'] . $data['idealo_csv_data_feed_seperator_2'] . $data['idealo_csv_data_feed_seperator'];
			$strnextinf = "$";
			$strclose   = $data['idealo_csv_data_feed_seperator'];			
			$strnl      = "\n";
			$output     = "";

			if ($data['idealo_csv_language_id']) {
				$this->config->set('idealo_csv_language_id', $data['idealo_csv_language_id']);
			}

			if(!isset($data['idealo_csv_status'])) {die($data['error']);}
		
			if (isset($data['idealo_csv_product_category']) ) {
					$exclude_categories = $data['idealo_csv_product_category'];
			} else {
					$exclude_categories = array();
			}
			
			$all_categories = array();

			foreach ($this->model_feed_idealo_csv->getAllCategories(0) as $category) {
				$all_categories[$category['category_id']] = $category;
				unset($all_categories[$category['category_id']]['category_id']);
			}

			$this->load->model('catalog/category');
			
			$this->load->model('catalog/product');

			$this->load->language('product/product');
			$data['text_instock'] = $this->language->get('text_instock');
			
			$this->load->model('tool/image');

	$output .= $strstart;
	$output .= 'Category' . $strnext;
	$output .= 'Manufacturer' . $strnext;
	$output .= 'Product name' . $strnext;
	$output .= 'Model' . $strnext;
	$output .= 'SKU' . $strnext;
	$output .= 'UPC' . $strnext;
	$output .= 'EAN' . $strnext;
	$output .= 'ISBN' . $strnext;
	$output .= 'JAN' . $strnext;
	$output .= 'MPN' . $strnext;
	$output .= 'Minimum' . $strnext;
	$output .= 'Currency' . $strnext;
	$output .= 'Price' . $strnext;
	$output .= 'Surcharge min. order value' . $strnext;
	$output .= 'Price dif. to min. order value' . $strnext;
	$output .= 'Comment Surcharge for min. order value' . $strnext;
	$output .= 'Weight' . $strnext;
	$output .= 'Link' . $strnext;
	$output .= 'Quantity' . $strnext;
	$output .= 'Availability' . $strnext;
	$output .= 'Date available' . $strnext;
	$output .= 'Date modified' . $strnext;
	$output .= 'Date added' . $strnext;
	$output .= 'Location zip' . $strnext;
	$output .= 'Shipping time' . $strnext;
	$output .= 'Shipping charge by price' . $strnext;
	$output .= 'Shipping charge by weight' . $strnext;
	$output .= 'Payment method 1' . $strnext;
	$output .= 'Payment method 2' . $strnext;
	$output .= 'Payment method 3' . $strnext;
	$output .= 'Additional Payment methods' . $strnext;
	$output .= 'Payment fee method 1' . $strnext;
	$output .= 'Payment fee method 2' . $strnext;
	$output .= 'Payment fee method 3' . $strnext;
	$output .= 'image main link' . $strnext;
	$output .= 'Additional image links' . $strnext;
	$output .= $strclose . $strnl;

			$products = array();
			$products = $this->model_feed_idealo_csv->getProducts();

			$total_products = count($products);

			foreach ($products as $product) {

					$data['images'] = array();

					$results = $this->model_feed_idealo_csv->getProductImages($product['product_id']);
					$j = 0;
					$image = '';

					foreach ($results as $result) {
						$data['images'][] = array(
							'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
						);
					}

					$categories = $this->model_feed_idealo_csv->getCategories($product['product_id']);
					$show = true;
					$deepest_cat_id = 0;

					foreach ($categories as $category) {
						if (in_array($category['category_id'], $exclude_categories)) {
							$show = false;
							break;
						}
						if (!$deepest_cat_id) {
							$deepest_cat_id = $category['category_id'];
						} else {
							if (isset($all_categories[$category['category_id']]['depth']) && ($all_categories[$category['category_id']]['depth'] > $all_categories[$deepest_cat_id]['depth'])) {
								$deepest_cat_id = $category['category_id'];
							}
						}
					}

				if ($show) {
				   if ($product['description']) {
					$i = ($i + 1);

					$output .= $strstart;
					$categories = $this->model_catalog_product->getCategories($product['product_id']);

					foreach ($categories as $category) {
						$path = $this->getPath($category['category_id']);
						
						if ($path) {
							$string = '';
								
							foreach (explode('_', $path) as $path_id) {
								$category_info = $this->model_catalog_category->getCategory($path_id);
								
								if ($category_info) {
									if (!$string) {
										$string = $category_info['name'];
									} else {
										$string .= ' &gt; ' . $category_info['name'];
									}
								}
							}
						}
					}
					$output .= $string . $strnext;
					$output .= html_entity_decode($product['manufacturer'], ENT_QUOTES, 'UTF-8') . $strnext;
					$output .= html_entity_decode($product['name'], ENT_QUOTES, 'UTF-8') . $strnext;
					$output .= html_entity_decode($product['model'], ENT_QUOTES, 'UTF-8') . $strnext;
					$output .= $product['sku'] . $strnext;
					$output .= $product['upc'] . $strnext;
					$output .= $product['ean'] . $strnext;
					$output .= $product['isbn'] . $strnext;
					$output .= $product['jan'] . $strnext;
					$output .= $product['mpn'] . $strnext;
					$output .= $product['minimum'] . $strnext;
					$currencies = array(
						'USD', 
						'EUR', 
						'GBP',
						'RUB',
						'INR'
					);
					if (in_array($this->currency->getCode(), $currencies)) {
					$currency_code = $this->currency->getCode();
						$currency_value = $this->currency->getValue();
						$output .= $currency_code . $strnext;
					} else {
						$currency_code = 'USD';
						$currency_value = $this->currency->getValue('USD');
						$output .=  $currency_code . $strnext;
					}
					if ((float)$product['special']) {
               				    $output .= $this->currency->format($this->tax->calculate(($product['minimum'] * $product['special']), $product['tax_class_id']), $currency_code, $currency_value, false) . $strnext;
					    $product_price = 0;
					    $product_price = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id']), $currency_code, $currency_value, false);
            			        } else {
            			            $output .= $this->currency->format($this->tax->calculate(($product['minimum'] * $product['price']), $product['tax_class_id']), $currency_code, $currency_value, false) . $strnext;
					    $product_price = 0;
					    $product_price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id']), $currency_code, $currency_value, false);
      				        }
					if ( ($product_price < $data['idealo_csv_order_minimum_sum']) &&  ($product_price > 0) ){
						$output .= $data['idealo_csv_order_minimum_fee'] . $strnext;
						$output .= $this->currency->format((abs($data['idealo_csv_order_minimum_sum'] - ($this->currency->format($this->tax->calculate(($product['minimum'] * $product_price), $product['tax_class_id']), $currency_code, $currency_value, false)))), $currency_code, $currency_value, false) . $strnext;
						$output .= $data['idealo_csv_order_minimum_comment'] . $strnext;
					} else {
						$output .= $strnext;
						$output .= $strnext;
						$output .= $strnext;
					}
					$output .= $this->weight->format($product['weight'], $product['weight_class_id']) . $strnext;
					$output .= html_entity_decode($this->url->link('product/product', 'product_id=' . $product['product_id']), ENT_QUOTES, 'UTF-8') . $strnext;
					$output .= $product['quantity'] . $strnext;
					$output .= ($product['quantity'] ? $data['text_instock'] : $product['stock_status']) . $strnext;
		   			$output .= $product['date_available'] . $strnext;
		   			$output .= $product['date_modified'] . $strnext;
		   			if($product['date_added'] == '0000-00-00 00:00:00'){
		   				$output .= $product['date_modified'] . $strnext;
		   			}else{
		   				$output .= $product['date_added'] . $strnext;
		   			} 
					$output .= $data['idealo_csv_location_zip'] . $strnext;
					$output .= $data['idealo_csv_delivery_time'] . $strnext;
					if ($data['idealo_csv_delivery_price_calc']) {
						$cost = 0;
						$price = 0;
						$rates = array();

						$price = $product_price;
						$rates = explode(',', $data['idealo_csv_delivery_price_calc']);

						foreach ($rates as $rate) {
							$datad = explode(':', $rate);

							if ($datad[0] >= $price) {
								if (isset($datad[1])) {
									$cost = $datad[1];
								}

								break;
							}
						}
            			           	$output .= $this->currency->format($cost, $currency_code, $currency_value, false) . $strnext;
            			        } else {
            			          	$output .= $strnext;
					}
					if ($data['idealo_csv_delivery_weight_calc']) {
						$cost = 0;
						$weight = 0;
						$rates = array();
						if ($product['weight_class_id'] == '2') {
							$weight = $product['weight'] / 1000 ;
						} else {
							$weight = $product['weight'];
						}
						$rates = explode(',', $data['idealo_csv_delivery_weight_calc']);

						foreach ($rates as $rate) {
							$datac = explode(':', $rate);

							if ($datac[0] >= $weight) {
								if (isset($datac[1])) {
									$cost = $datac[1];
								}

								break;
							}
						}
            			           	$output .= $this->currency->format($cost, $currency_code, $currency_value, false) . $strnext;
            			        } else {
            			          	$output .= $strnext;
					}
					$output .= $data['idealo_csv_payment_method'] . $strnext;
					$output .= $data['idealo_csv_payment_method_2'] . $strnext;
					$output .= $data['idealo_csv_payment_method_3'] . $strnext;
					$output .= $data['idealo_csv_payment_methods'] . $strnext;
					if ($data['idealo_csv_payment_max'] >= $product_price) {
					 if ($data['idealo_csv_payment_free'] >= $product_price) {
					   $product_price_payment = '';
					  if (substr($data['idealo_csv_payment_cost'], -1) == '%') {
					     $product_price_payment = ($product_price * $data['idealo_csv_payment_cost']) / 100;
            			           } else {
					     $product_price_payment = $data['idealo_csv_payment_cost'];
					   }
               				   //$output .= $product_price_payment . $strnext;
               				   $output .= $this->currency->format($product_price_payment, $currency_code, $currency_value, false) . $strnext;
            			         } else {
            			           $output .= '0.00' . $strnext;
      				         }
            			        } else {
            			           $output .= '' . $strnext;
      				        }
					if ($data['idealo_csv_payment_max_2'] >= $product_price) {
					 if ($data['idealo_csv_payment_free_2'] >= $product_price) {
					   $product_price_payment_2 = '';
					  if (substr($data['idealo_csv_payment_cost_2'], -1) == '%') {
					     $product_price_payment_2 = (($product_price * $data['idealo_csv_payment_cost_2']) / 100);
            			           } else {
					     $product_price_payment_2 = $data['idealo_csv_payment_cost_2'];
					   }
               				   //$output .= $product_price_payment_2 . $strnext;
               				   $output .= $this->currency->format($product_price_payment_2, $currency_code, $currency_value, false) . $strnext;
            			         } else {
            			           $output .= '0.00' . $strnext;
      				         }
            			        } else {
            			           $output .= '' . $strnext;
      				        }
					if ($data['idealo_csv_payment_max_3'] >= $product_price) {
					 if ($data['idealo_csv_payment_free_3'] >= $product_price) {
					   $product_price_payment_3 = 0;
					  if (substr($data['idealo_csv_payment_cost_3'], -1) == '%') {
					     $product_price_payment_3 = ($product_price * $data['idealo_csv_payment_cost_3']) / 100;
            			           } else {
					     $product_price_payment_3 = $data['idealo_csv_payment_cost_3'];
					   }
               				   //$output .= $product_price_payment_3 . $strnext;
               				   $output .= $this->currency->format($product_price_payment_3, $currency_code, $currency_value, false) . $strnext;
            			         } else {
            			           $output .= '0.00' . $strnext;
      				         }
            			        } else {
            			           $output .= '' . $strnext;
      				        }
					if ($product['image']) {
						$output .=  $this->model_tool_image->resize($product['image'], 500, 500) . $strnext;
					} else {
						$output .=  $this->model_tool_image->resize('no_image.jpg', 500, 500) . $strnext;
					}
					if ($data['images']) {
						foreach ($data['images'] as $image) {
	   					$output .=  $image['popup'] . $strnextinf;
						}
					}
					$output .= $strclose . $strnl;
				   }
				}
			}

			$this->response->addHeader('Content-Type: text/plain; charset=utf-8');
			$this->response->setOutput($output);
		}
	}
	protected function getPath($parent_id, $current_path = '') {
		$category_info = $this->model_catalog_category->getCategory($parent_id);
	
		if ($category_info) {
			if (!$current_path) {
				$new_path = $category_info['category_id'];
			} else {
				$new_path = $category_info['category_id'] . '_' . $current_path;
			}	
		
			$path = $this->getPath($category_info['parent_id'], $new_path);
					
			if ($path) {
				return $path;
			} else {
				return $new_path;
			}
		}
	}		
	protected function clear($data) {
		foreach ($data as $key => $value) {
			$data[$key] = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
			$data[$key] = strip_tags($data[$key]);
			$data[$key] = preg_replace(array('/(\s){1,100}/us', '/&nbsp;/', '/\r\n/', '/\n\r/', '/\n/'), array(' ', ' ', '', '', ''), $data[$key]);
			$data[$key] = trim($data[$key]);
		}

		return $data;
	}
}
?>
