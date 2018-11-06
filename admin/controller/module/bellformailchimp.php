<?php
# @Date:   Wednesday, December 20th 2017, 12:07:04 pm
# @Email:  oleg@webiprog.com
# @Project: belfor
# @Filename: bellformailchimp.php
# @Last modified by:   Oleg
# @Last modified time: Wednesday, December 20th 2017, 5:04:45 pm
# @License: free

class ControllerModuleBellformailchimp extends Controller {

	private $error 						= array();
	private $version 					= '1.0.1';
	private $extension 					= 'bellformailchimp';
	private $type 						= 'module';
	private $db_table					= 'woc_mailchimp';
	private $oc_extension				= '';

	public function index() {
		 //$this->load->language('extension/module/bellformailchimp');
		 $this->language->load('module/bellformailchimp');

		 $this->load->model('setting/setting');

		//Set title from language file
		$this->document->setTitle($this->language->get('heading_title'));

		$data = array();

		//Save settings
		if (isset($this->request->post['bellformailchimp_api_key'])) {
			 $data = $this->request->post;
			 $this->model_setting_setting->editSetting('bellformailchimp', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			/*
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
			*/

			$this->response->redirect($this->url->link('module/bellformailchimp', 'token=' . $this->session->data['token'], 'SSL'));

		} else {
			 $data['bellformailchimp_api_key'] = $this->config->get('bellformailchimp_api_key');
			 $data['bellformailchimp_list_id'] = $this->config->get('bellformailchimp_list_id');
			// $this->log->write($data);
		}

		$text_strings = array(
				'heading_title',
				'button_save',
				'button_cancel',
				'button_add_module',
				'button_remove',
				'placeholder',
		);

		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}

		 // This Block returns the warning if any
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        // This Block returns the error code if any
        if (isset($this->error['code'])) {
            $data['error_code'] = $this->error['code'];
        } else {
            $data['error_code'] = '';
        }

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/bellformailchimp', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		/*
		$data['action'] = $this->url->link('extension/module/bellformailchimp', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');
		*/
		$data['action'] = $this->url->link('module/bellformailchimp', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$data['token'] = $this->session->data['token'];


		$data['session'] = $this->session->data['token'];

		// This block parses the status (enabled / disabled)
        if (isset($this->request->post['bellformailchimp_status'])) {
            $data['bellformailchimp_status'] = $this->request->post['bellformailchimp_status'];
        } else {
            $data['bellformailchimp_status'] = $this->config->get('bellformailchimp_status');
        }

		// This block parses the status (enabled / disabled)
        if (isset($this->request->post['bellformailchimp_api_key'])) {
            $data['bellformailchimp_api_key'] = $this->request->post['bellformailchimp_api_key'];
        } else {
            $data['bellformailchimp_api_key'] = $this->config->get('bellformailchimp_api_key');
        }

		// This block parses the status (enabled / disabled)
        if (isset($this->request->post['bellformailchimp_list_id'])) {
            $data['bellformailchimp_list_id'] = $this->request->post['bellformailchimp_list_id'];
        } else {
            $data['bellformailchimp_list_id'] = $this->config->get('bellformailchimp_list_id');
        }

		if (isset($this->request->post['bellformailchimp_status'])) {
			$data['bellformailchimp_status'] = $this->request->post['bellformailchimp_status'];
		} else {
			$data['bellformailchimp_status'] = $this->config->get('bellformailchimp_status');
		}

		//Prepare for display
		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');


        $this->response->setOutput($this->load->view('module/bellformailchimp.tpl', $data));
	}

    public function uninstall() {
   	$this->load->model('setting/setting');
	$this->model_setting_setting->deleteSetting('bellformailchimp');
   }

	private function validate() {
		//if (!$this->user->hasPermission('modify', 'extension/module/bellformailchimp')) {
		if (!$this->user->hasPermission('modify', 'module/bellformailchimp')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}
?>
