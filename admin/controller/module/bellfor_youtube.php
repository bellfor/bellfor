<?php
# @Date:   Wednesday, December 20th 2017, 12:07:04 pm
# @Email:  oleg@webiprog.com
# @Project: belfor
# @Filename: bellfor_youtube.php
# @Last modified by:   Oleg
# @Last modified time: Wednesday, December 20th 2017, 5:04:45 pm
# @License: free

class ControllerModuleBellforYoutube extends Controller {
	private $error = array();

	public function index() {

		$this->language->load('module/bellfor_youtube');


		$this->load->model('setting/setting');


		$this->document->setTitle = $this->language->get('heading_title');


		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {

        $this->model_setting_setting->editSetting('bellfor_youtube', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			//$this->redirect(HTTPS_SERVER .'index.php?route=extension/module&token=' . $this->session->data['token']);
			$this->response->redirect($this->url->link('module/bellfor_youtube', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_left'] = $this->language->get('text_left');
		$data['text_right'] = $this->language->get('text_right');
        $data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');

		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_help'] = $this->language->get('entry_help');
		$data['entry_version_status'] = $this->language->get('entry_version_status');
        $data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_author'] = $this->language->get('entry_author');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');

		$data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

 		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		    unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['sort_order'])) {
			$data['error_sort_order'] = $this->error['sort_order'];
		} else {
			$data['error_sort_order'] = '';
		}
		if (isset($this->error['code'])) {
			$data['error_code'] = $this->error['code'];
		} else {
			$data['error_code'] = '';
		}

		// Languages
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Modules',
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/bellfor_youtube', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('module/bellfor_youtube', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$data['token'] = $this->session->data['token'];

		$data['modules'] = array();


		if (isset($this->request->post['bellfor_youtube_position'])) {
			$data['bellfor_youtube_position'] = $this->request->post['bellfor_youtube_position'];
		} else {
			$data['bellfor_youtube_position'] = $this->config->get('bellfor_youtube_position');
		}


		if (isset($this->request->post['bellfor_youtube_status'])) {
			$data['bellfor_youtube_status'] = $this->request->post['bellfor_youtube_status'];
		} else {
			$data['bellfor_youtube_status'] = $this->config->get('bellfor_youtube_status');
		}


		if (isset($this->request->post['bellfor_youtube_sort_order'])) {
			$data['bellfor_youtube_sort_order'] = $this->request->post['bellfor_youtube_sort_order'];
		} else {
			$data['bellfor_youtube_sort_order'] = $this->config->get('bellfor_youtube_sort_order');
		}

		if (isset($this->request->post['bellfor_youtube_code'])) {
			$data['bellfor_youtube_code'] = $this->request->post['bellfor_youtube_code'];
		} else {
			$data['bellfor_youtube_code'] = $this->config->get('bellfor_youtube_code');
		}

        if (isset($this->request->post['bellfor_youtube_module'])) {
			$modules = explode(',', $this->request->post['bellfor_youtube_module']);
			$modules = (array_map('trim', $modules));
		} elseif ($this->config->get('bellfor_youtube_module') != '') {
			$modules = explode(',', $this->config->get('bellfor_youtube_module'));
			$modules = (array_map('trim', $modules));
		} else {
			$modules = array();
		}

		// Layouts
		$this->load->model('design/layout');
		$data['layouts'] = $this->model_design_layout->getLayouts();

		foreach ($modules as $module) {
			if (isset($this->request->post['bellfor_youtube_' . $module . '_image_width'])) {
				$data['bellfor_youtube_' . $module . '_image_width'] = $this->request->post['bellfor_youtube_' . $module . '_image_width'];
			} else {
				$data['bellfor_youtube_' . $module . '_image_width'] = $this->config->get('bellfor_youtube_' . $module . '_image_width');
			}

			if (isset($this->request->post['bellfor_youtube_' . $module . '_image_height'])) {
				$data['bellfor_youtube_' . $module . '_image_height'] = $this->request->post['bellfor_youtube_' . $module . '_image_height'];
			} else {
				$data['bellfor_youtube_' . $module . '_image_height'] = $this->config->get('bellfor_youtube_' . $module . '_image_height');
			}

			if (isset($this->request->post['bellfor_youtube_' . $module . '_layout_id'])) {
				$data['bellfor_youtube_' . $module . '_layout_id'] = $this->request->post['bellfor_youtube_' . $module . '_layout_id'];
			} else {
				$data['bellfor_youtube_' . $module . '_layout_id'] = $this->config->get('bellfor_youtube_' . $module . '_layout_id');
			}

			if (isset($this->request->post['bellfor_youtube_' . $module . '_position'])) {
				$data['bellfor_youtube_' . $module . '_position'] = $this->request->post['bellfor_youtube_' . $module . '_position'];
			} else {
				$data['bellfor_youtube_' . $module . '_position'] = $this->config->get('bellfor_youtube_' . $module . '_position');
			}

			if (isset($this->request->post['bellfor_youtube_' . $module . '_status'])) {
				$data['bellfor_youtube_' . $module . '_status'] = $this->request->post['bellfor_youtube_' . $module . '_status'];
			} else {
				$data['bellfor_youtube_' . $module . '_status'] = $this->config->get('bellfor_youtube_' . $module . '_status');
			}

			if (isset($this->request->post['bellfor_youtube_' . $module . '_sort_order'])) {
				$data['bellfor_youtube_' . $module . '_sort_order'] = $this->request->post['bellfor_youtube_' . $module . '_sort_order'];
			} else {
				$data['bellfor_youtube_' . $module . '_sort_order'] = $this->config->get('bellfor_youtube_' . $module . '_sort_order');
			}

            if (isset($this->request->post['bellfor_youtube_' . $module . '_code'])) {
				$data['bellfor_youtube_' . $module . '_code'] = $this->request->post['bellfor_youtube_' . $module . '_code'];
			} else {
				$data['bellfor_youtube_' . $module . '_code'] = $this->config->get('bellfor_youtube_' . $module . '_code');
			}

		}

		$data['modules'] = $modules;

		if (isset($this->request->post['bellfor_youtube_module'])) {
			$data['bellfor_youtube_module'] = $this->request->post['bellfor_youtube_module'];
		} else {
			$data['bellfor_youtube_module'] = $this->config->get('bellfor_youtube_module');
		}

		if (isset($this->request->post['bellfor_youtube_status'])) {
			$data['bellfor_youtube_status'] = $this->request->post['bellfor_youtube_status'];
		} else {
			$data['bellfor_youtube_status'] = $this->config->get('bellfor_youtube_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/bellfor_youtube.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/bellfor_youtube')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

}
?>