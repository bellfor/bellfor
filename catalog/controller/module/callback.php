<?php
class ControllerModuleCallback extends Controller {
	public function index() {
			$this->load->language('module/callback');
			$data['heading_title'] = $this->language->get('heading_title');
			$data['entry_name'] = $this->language->get('entry_name');
			$data['entry_phone'] = $this->language->get('entry_phone');
			$data['entry_submit'] = $this->language->get('entry_submit');
			$data['entry_error'] = $this->language->get('entry_error');
			$data['entry_ok'] = $this->language->get('entry_ok');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/callback.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/callback.tpl', $data);
			} else {
				return $this->load->view('default/template/module/callback.tpl', $data);
			}
	}
}