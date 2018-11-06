<?php class ControllerModuleReferafriend extends Controller {
        private $error = array();

        public function index() {
                $this->language->load('module/referafriend');
                $this->document->setTitle($this->language->get('heading_title'));

                $this->load->model('setting/setting');

                if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                        $this->model_setting_setting->editSetting('referafriend', $this->request->post);

                        $this->session->data['success'] = $this->language->get('text_success');

                        $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
                }
                
                $data = array();

                $data['heading_title'] = $this->language->get('heading_title');
		$data['rff_code'] = html_entity_decode($this->config->get('referafriend_code'));
                $data['referafriend_code'] = $this->language->get('referafriend_code');
                $data['button_save'] = $this->language->get('button_save');
                $data['button_cancel'] = $this->language->get('button_cancel');
                $data['button_add_module'] = $this->language->get('button_add_module');
                $data['button_remove'] = $this->language->get('button_remove');
                $data['breadcrumbs'] = array();
                $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                        'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => false
                );
                $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_module'),
                        'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => ' :: '
                );

                $data['action'] = $this->url->link('module/referafriend', 'token=' . $this->session->data['token'], 'SSL');

                $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
				                if (isset($this->request->post['referafriend_code'])) {
                        $data['referafriend_code'] = $this->request->post['referafriend_code'];
                }

				$data['header'] = $this->load->controller('common/header');
					$data['column_left'] = $this->load->controller('common/column_left');
				$data['footer'] = $this->load->controller('common/footer');
				$this->response->setOutput($this->load->view('module/referafriend.tpl', $data));
         }
        }
?>