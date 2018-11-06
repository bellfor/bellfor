<?php
class ControllerMarketingReorder extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('marketing/reorder');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('marketing/reorder');

		$this->getList();
	}

	public function update() {
		$this->load->language('marketing/reorder');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('marketing/reorder');

		$url = '';

		if(isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if(isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if(isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if(($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_marketing_reorder->updateDiscountRule($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
		}

		$this->response->redirect($this->url->link('marketing/reorder', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}
        
	public function clear() {
/*    		$this->load->language('tool/seomanager');
                $url = '';

                if (isset($this->request->get['sort'])) {
                        $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                        $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['page'])) {
                        $url .= '&page=' . $this->request->get['page'];
                }
                $this->cache->delete('seo_pro');
                $this->cache->delete('seo_url');
                $this->session->data['success'] = $this->language->get('text_success_clear');
		$this->response->redirect($this->url->link('tool/seomanager', 'token=' . $this->session->data['token'] . $url, 'SSL'));*/
        }

	public function delete() {
		$this->load->language('marketing/reorder');
		$this->load->model('marketing/reorder');
		$url = '';

		if(isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if(isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if(isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if(isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach($this->request->post['selected'] as $rule_id) {
				$this->model_marketing_reorder->deleteDiscountRule($rule_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
		}

		$this->response->redirect($this->url->link('marketing/reorder', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}

	private function getList() {
		if(isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'dr.orders_count';
		}

		if(isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if(isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if(isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if(isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if(isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
				
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('marketing/reorder', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['insert'] = $this->url->link('marketing/reorder/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('marketing/reorder/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['save'] = $this->url->link('marketing/reorder/update', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['clear'] = $this->url->link('marketing/reorder/clear', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['discount_rules'] = array();

		$filterdata = array(
			'sort' => $sort, 
			'order' => $order, 
			'start' => ($page - 1) * $this->config->get('config_admin_limit'), 
			'limit' => $this->config->get('config_admin_limit')
		);

		$discount_rules_total = $this->model_marketing_reorder->getTotalDiscountRules();

		$results = $this->model_marketing_reorder->getDiscountRules($filterdata);

		if(count($results)) {
			foreach($results as $result) {
				$data['discount_rules'][] = array(
					'rule_id' => $result['rule_id'],
					'orders_count' => $result['orders_count'],
					'discount_size' => $result['discount_size'],
					'selected' => isset($this->request->post['selected']) && in_array($result['rule_id'], $this->request->post['selected']),
					'action_text' => $this->language->get('text_edit'),
				);
			}
		}
//print_r('<pre>discount_rules: ');print_r($data['discount_rules']);print_r('</pre>');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_no_return'] = $this->language->get('text_no_return');

		$data['column_orders_count'] = $this->language->get('column_orders_count');
		$data['column_discount_size'] = $this->language->get('column_discount_size');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
//		$data['button_clear_cache'] = $this->language->get('button_clear_cache');
		$data['button_edit'] = $this->language->get('button_edit');

		if(isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if(isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if(isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
				
		$data['sort_orders_count'] = $this->url->link('marketing/reorder', 'token=' . $this->session->data['token'] . '&sort=dr.orders_count' . $url, 'SSL');
		$data['sort_discount_size'] = $this->url->link('marketing/reorder', 'token=' . $this->session->data['token'] . '&sort=dr.discount_size' . $url, 'SSL');

		$url = '';

		if(isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if(isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $discount_rules_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('marketing/reorder', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
								
		$this->response->setOutput($this->load->view('marketing/reorder.tpl', $data));
	}

	private function validateForm() {
		if(!$this->user->hasPermission('modify', 'marketing/reorder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if(!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if(!$this->user->hasPermission('modify', 'marketing/reorder')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if(!$this->error) {
			return true;
		} else {
			return false;
		}
	}

        public function install() {
/*                $this->load->model('tool/seomanager');
                $this->model_tool_seomanager->install();*/

        }

        public function uninstall() {
/*                $this->load->model('tool/seomanager');
                $this->model_tool_seomanager->uninstall();*/
        }

}
?>
