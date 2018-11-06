<?php
/**
 * @filesource: notice_add.php
 * @package:    bellfor.info\admin\controller\module
 * @created:    Wed Apr 04 2018
 * @author:     Kamenskiy
 * @fix:     oppo, webiprog.com
 * @version:    1.0.0
 * @modified:   Tuesday April 3rd 2018 8:00:51 pm
 * @copyright   (c) 2008-2018 Webiprog GmbH, UA. All rights reserved.
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */


class ControllerModuleNoticeAdd extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('module/notice_add');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('notice_add', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'] . '&type=module', true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');


        $data['entry_status'] = $this->language->get('entry_status');

        $data['layout_noty'] = $this->language->get('layout_noty');

        $data['layout_bottomRight'] = $this->language->get('layout_bottomRight');
        $data['layout_bottomLeft'] = $this->language->get('layout_bottomLeft');
        $data['layout_bottomCenter'] = $this->language->get('layout_bottomCenter');
        $data['layout_bottom'] = $this->language->get('layout_bottom');

        $data['layout_center'] = $this->language->get('layout_center');
        $data['layout_centerRight'] = $this->language->get('layout_centerRight');
        $data['layout_centerLeft'] = $this->language->get('layout_centerLeft');

        $data['layout_top'] = $this->language->get('layout_top');
        $data['layout_topRight'] = $this->language->get('layout_topRight');
        $data['layout_topLeft'] = $this->language->get('layout_topLeft');
        $data['layout_topCenter'] = $this->language->get('layout_topCenter');

        $data['noty_timeout'] = $this->language->get('noty_timeout');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('Module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/notice_add', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('module/notice_add', 'token=' . $this->session->data['token'], true);

		$data['update'] = $this->url->link('module/notice_add/update', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);


        if (isset($this->request->post['notice_add_status'])) {
            $data['notice_add_status'] = $this->request->post['notice_add_status'];
        } else {
            $data['notice_add_status'] = $this->config->get('notice_add_status');
        }

        if (isset($this->request->post['notice_add_layout'])) {
            $data['notice_add_layout'] = $this->request->post['notice_add_layout'];
        } else {
            $data['notice_add_layout'] = $this->config->get('notice_add_layout');
        }

        if (isset($this->request->post['notice_add_timeout'])) {
            $data['notice_add_timeout'] = $this->request->post['notice_add_timeout'];
        } else {
            $data['notice_add_timeout'] = $this->config->get('notice_add_timeout');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/notice_add.tpl', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'module/notice_add')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
