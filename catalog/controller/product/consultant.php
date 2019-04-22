<?php

class ControllerProductConsultant extends Controller {
    public function __construct($registry) {
        parent::__construct($registry);
        $this->load->language('product/category');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');

    }


    public function index() {

        $category_id = false;
		
		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
			$this->document->setRobots('noindex,follow');
		} else {
			$filter = '';
		}

		if (isset($this->request->get['exclude'])) {
			$exclude = $this->request->get['exclude'];
		} else {
			$exclude = '';
		}		

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
            $this->document->setRobots('noindex,follow');
        } else {
            $sort = 'p.sort_order';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
            $this->document->setRobots('noindex,follow');
        } else {
            $page = 1;
        }

        if (isset($this->request->get['limit'])) {
            $limit = (int)$this->request->get['limit'];
            $this->document->setRobots('noindex,follow');
        } else {
            $limit = $this->config->get('config_product_limit');
        }


        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );


        $this->document->setTitle('Ernährungsberater');
		$data['heading_title'] = 'Ernährungsberater';

        $data['text_refine'] = $this->language->get('text_refine');
		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_quantity'] = $this->language->get('text_quantity');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_model'] = $this->language->get('text_model');
		$data['text_price'] = $this->language->get('text_price');
		$data['text_tax'] = $this->language->get('text_tax');
		$data['text_points'] = $this->language->get('text_points');
		$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$data['text_sort'] = $this->language->get('text_sort');
		$data['text_limit'] = $this->language->get('text_limit');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_list'] = $this->language->get('button_list');
		$data['button_grid'] = $this->language->get('button_grid');

        $data['link_versand'] = $this->url->link('information/information', 'information_id=112');
        $data['button_go_product'] = $this->language->get('button_go_product');

        // Set the last category breadcrumb
		$data['breadcrumbs'][] = array(
			'text' => 'Ernährungsberater',
			'href' => $this->url->link('product/consultant')
		);

		$data['products'] = array();
		$filter_data = array(
			'filter_category_id' => $category_id,
			'filter_filter'      => $filter,
			'filter_exclude'     => $exclude,
			'sort' => $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);

		$product_total = $this->model_catalog_product->getTotalProducts($filter_data);
		$results = $this->model_catalog_product->getProducts($filter_data);


		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				$tax_rates_raw = $this->tax->getRates($result['product_id'], $result['tax_class_id']);
				$tax_rate = array();
				foreach ($tax_rates_raw as $tax_rate_raw) {
					$tax_rate[] = $tax_rate_raw;
				}
				$price_without_symbol = $result['price'];
				$price_full = round($price_without_symbol + $price_without_symbol * ($tax_rate[0]['rate'] / 100), 2);
				$price_full_formatted = $this->currency->format($price_full, false);
				if ('' !== $this->currency->getSymbolRight($this->session->data['currency'])) {
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
				$price_full = false;
				$price_full_formatted = false;
				$tax_rate = false;
				$price_without_symbol = false;
				$currency_symbol = false;
				$price_symbol_position = false;
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
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}

			$category_data = $this->model_catalog_product->getMainCategory($result['product_id']);
			$discounts = array();
			$discounts_data = $this->model_catalog_product->getProductDiscounts($result['product_id']);
			if (!empty($discounts_data)) {
				foreach ($discounts_data as $discount) {
					$discount['price_full'] = $this->tax->calculate($discount['price'], $result['tax_class_id'], $this->config->get('config_tax'));
					$discounts[] = $discount;
				}
			}

			$data['products'][] = array(
				'product_id' => $result['product_id'],
				'thumb' => $image,
				'name' => $result['name'],
				'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
				'price' => $price,
				'special' => $special,
				'model' => $result['model'],
				'discounts'       => $discounts,
				'category' => $category_data['name'],
				'weight' => $result['weight'],


				'tax_rate' => $tax_rate,
				'price_without_symbol' => $price_without_symbol,
				'price_full' => $price_full,
				'price_full_formatted' => $price_full_formatted,
				'currency' => $currency_symbol,
				'currency_position' => $price_symbol_position,

                'p2cg_product_id' => $result['p2cg_product_id'],
                'email_required' => $result['email_required'],

				'tax' => $tax,
				'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
				'rating' => $result['rating'],
				'href' => $this->url->link('product/product', '&product_id=' . $result['product_id'])
			);
		}

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$data['sorts'] = array();

		$data['sorts'][] = array(
			'text' => $this->language->get('text_default'),
			'value' => 'p.sort_order-ASC',
			'href' => $this->url->link('product/consultant', '&sort=p.sort_order&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text' => $this->language->get('text_name_asc'),
			'value' => 'pd.name-ASC',
			'href' => $this->url->link('product/consultant', '&sort=pd.name&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text' => $this->language->get('text_name_desc'),
			'value' => 'pd.name-DESC',
			'href' => $this->url->link('product/consultant', '&sort=pd.name&order=DESC' . $url)
		);

		$data['sorts'][] = array(
			'text' => $this->language->get('text_price_asc'),
			'value' => 'p.price-ASC',
			'href' => $this->url->link('product/consultant', '&sort=p.price&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text' => $this->language->get('text_price_desc'),
			'value' => 'p.price-DESC',
			'href' => $this->url->link('product/consultant', '&sort=p.price&order=DESC' . $url)
		);

		if ($this->config->get('config_review_status')) {
			$data['sorts'][] = array(
				'text' => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href' => $this->url->link('product/consultant', '&sort=rating&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text' => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href' => $this->url->link('product/consultant', '&sort=rating&order=ASC' . $url)
			);
		}

		$data['sorts'][] = array(
			'text' => $this->language->get('text_model_asc'),
			'value' => 'p.model-ASC',
			'href' => $this->url->link('product/consultant', '&sort=p.model&order=ASC' . $url)
		);

		$data['sorts'][] = array(
			'text' => $this->language->get('text_model_desc'),
			'value' => 'p.model-DESC',
			'href' => $this->url->link('product/consultant', '&sort=p.model&order=DESC' . $url)
		);

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['limits'] = array();

		$limits = array_unique(array($this->config->get('config_product_limit'), 25, 50, 75, 100));

		sort($limits);

		foreach ($limits as $value) {
			$data['limits'][] = array(
				'text' => $value,
				'value' => $value,
				'href' => $this->url->link('product/consultant', $url . '&limit=' . $value)
			);
		}

		$url = '';

		if (isset($this->request->get['filter'])) {
			$url .= '&filter=' . $this->request->get['filter'];
		}
		
		if (isset($this->request->get['dog_name'])) {
			$dog_name = $this->request->get['dog_name'];
			$url .= '&dog_name=' . $dog_name;
			$data['dog_name'] = $dog_name;
		}		

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('product/consultant', $url . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

		// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
		if ($page == 1) {
			$this->document->addLink($this->url->link('product/consultant'), 'canonical');
		} elseif ($page == 2) {
			$this->document->addLink($this->url->link('product/consultant'), 'prev');
		} else {
			$this->document->addLink($this->url->link('product/consultant', '&page=' . ($page - 1), 'SSL'), 'prev');
		}

		if ($limit && ceil($product_total / $limit) > $page) {
			$this->document->addLink($this->url->link('product/consultant', '&page=' . ($page + 1), 'SSL'), 'next');
		}

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['limit'] = $limit;

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/consultant.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/consultant.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/product/consultant.tpl', $data));
		}

    }

    public function step() {

        $data['cons_title'] = $this->language->get('cons_title');
        $data['cons_mydata'] = $this->language->get('cons_mydata');
        $data['cons_input_name'] = $this->language->get('cons_input_name');
        $data['cons_input_race'] = $this->language->get('cons_input_race');
        $data['cons_input_plach_name'] = $this->language->get('cons_input_plach_name');
        $data['cons_input_plach_race'] = $this->language->get('cons_input_plach_race');
        $data['cons_check_gender'] = $this->language->get('cons_check_gender');
        $data['cons_check_gender_f'] = $this->language->get('cons_check_gender_f');
        $data['cons_check_gender_m'] = $this->language->get('cons_check_gender_m');
        $data['cons_check_castrated'] = $this->language->get('cons_check_castrated');
        $data['cons_check_castrated_y'] = $this->language->get('cons_check_castrated_y');
        $data['cons_check_castrated_n'] = $this->language->get('cons_check_castrated_n');
        $data['cons_date'] = $this->language->get('cons_date');
        $data['cons_date_d'] = $this->language->get('cons_date_d');
        $data['cons_date_m'] = $this->language->get('cons_date_m');
        $data['cons_date_y'] = $this->language->get('cons_date_y');
        $data['cons_date_month'] = $this->language->get('cons_date_month');
        $data['cons_button'] = $this->language->get('cons_button');
        $data['cons_error'] = $this->language->get('cons_error');

        if ($this->request->post) {

            $data['consultant'] = array();

            if ($this->request->post['dog_name']) {
                $data['consultant']['name'] = $this->request->post['dog_name'];
            } else {
                $data['consultant']['name'] = '';
            }

            if ($this->request->post['rasse_id']) {
                $data['consultant']['rasse_id'] = $this->request->post['rasse_id'];
            } else {
                $data['consultant']['rasse_id'] = '';
            }

            if ($this->request->post['rasse']) {
                $data['consultant']['rasse'] = $this->request->post['rasse'];
            } else {
                $data['consultant']['rasse'] = '';
            }

            if ($this->request->post['geschlecht']) {
                $data['consultant']['geschlecht'] = $this->request->post['geschlecht'];
            } else {
                $data['consultant']['geschlecht'] = '';
            }

            if ($this->request->post['kastriert']) {
                $data['consultant']['kastriert'] = $this->request->post['kastriert'];
            } else {
                $data['consultant']['kastriert'] = '';
            }

            if ($this->request->post['day'] && $this->request->post['month'] && $this->request->post['year']) {
                $data['consultant']['day'] = $this->request->post['day'];
                $data['consultant']['month'] = $this->request->post['month'];
                $data['consultant']['year'] = $this->request->post['year'];
            } else {
                $data['consultant']['day'] = '';
                $data['consultant']['month'] = '';
                $data['consultant']['year'] = '';
            }
        }

        $this->load->model('extension/race');

        $race_dogs = $this->model_extension_race->getRace();

        if ($this->config->get('config_top_race_dogs')) {
            $top_race_dogs_id = $this->config->get('config_top_race_dogs');

            $top_race_dogs = array();
            $temp_array = array();
            foreach ($top_race_dogs_id as $top_race_dog_id) {
                foreach ($race_dogs as $race_dog) {
                    if ($top_race_dog_id == $race_dog['race_id']) {
                        $top_race_dogs[] = $race_dog;
                    }
                }
            }

            foreach ($race_dogs as $race_dog) {
                if (!in_array($race_dog['race_id'], $top_race_dogs_id)) {
                    $temp_array[] = $race_dog;
                }
            }

            $data['race_dogs'] = array_merge($top_race_dogs, $temp_array);

        } else {
            foreach ($race_dogs as $race_dog){
                $data['race_dogs'][] = $race_dog;

            }
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );
		
        $data['breadcrumbs'][] = array(
            'text' => 'Ernährungsberater',
            'href' => $this->url->link('product/consultant/step')
        );		
		
		$this->document->setTitle('Ernährungsberater');


        //$this->document->addStyle('catalog/view/theme/default/css/styles_futterassistent.css');
        //$this->document->addStyle('catalog/view/theme/default/css/styles.css');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
		
        $data['action'] = $this->url->link('product/consultant');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/consultant_step.tpl')) {
            $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/consultant_step.tpl', $data));
        } else {
            $this->response->setOutput($this->load->view('default/template/product/consultant_step.tpl', $data));
        }
    }
	
	public function sendCoupon() {		
		$json = array();

		
		$this->load->model('catalog/consultant');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && utf8_strlen($this->request->post['email']) > 5 ) {
			
			if( $this->model_catalog_consultant->checkEmail($this->request->post['email']) ) {
				$json['message'] = 'Sorry. You have already receive coupon';
			} 
			
			if(!$json) {
				$coupon_code = time();
				
				$products = array();
				if(isset($this->request->post['products'])) {
					$result = explode(',', $this->request->post['products']);
					foreach($result as $product_id) {
						$products[] = (int)$product_id;
					}
				}
				
				$coupon_data = array(
					'name' => 'Ernährungsberater - '.$this->request->post['dogname'],
					'code' => $coupon_code,
					'email' => $this->request->post['email'],
					'type' => 'P',
					'discount' => 10,
					'total' => 0,
					'logged' => 0,
					'shipping' => 0,
					'coupon_product' => $products,
					'coupon_category' => array(),
					'date_start' => date("Y-m-d"),
					'date_end' => date("Y-m-d", strtotime("+ 30 day")),
					'uses_total' => 1,
					'uses_customer' => 1,
					'status' => 1,
				);				

				if( $this->model_catalog_consultant->addCoupon($coupon_data) ) {
					// send email					
					$mail = new Mail();
					$mail->protocol = $this->config->get('config_mail_protocol');
					$mail->parameter = $this->config->get('config_mail_parameter');
					$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
					$mail->smtp_username = $this->config->get('config_mail_smtp_username');
					$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
					$mail->smtp_port = $this->config->get('config_mail_smtp_port');
					$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

					$mail->setTo($this->request->post['email']);
					$mail->setFrom($this->config->get('config_email'));
					$mail->setSender($this->config->get('config_name'));
					$mail->setSubject('Bellfor -Ihr persönlicher Gutscheincode!');
					$mail->setText('Sie erhalten 10 % Rabatt auf Ihren Einkauf! Ihr Gutscheincode lautet '.$coupon_code.' ');
					$mail->send();	
					
					$json['message'] = 'Den Gutschein Code erhalten Sie per Email';
				}

			}
		
		}
		
		
		$fp = fopen('data.txt', 'w');
		fwrite($fp, print_r(json_encode($json), true) );
		fclose($fp);	

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));		
	}

    private function getUrlParams() {
        $url = '';
        if (isset($this->request->get['filter'])) {
            $url .= '&filter=' . $this->request->get['filter'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }

        return $url;
    }
}
