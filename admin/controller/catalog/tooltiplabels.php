<?php
# @Date:   Thursday, November 9th 2017, 3:20:26 pm
# @Email:  oleg@webiprog.com
# @Project: tooltiplabels
# @Filename: tooltiplabels.php
# @Last modified by:   Oleg
# @Last modified time: Thursday, November 9th 2017, 4:44:27 pm
# @License: free
# @Copyright: webiprog.com


class ControllerCatalogTooltiplabels extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('catalog/tooltiplabels');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/tooltiplabels');

        $this->getList();
    }

    public function add()
    {
        $this->load->language('catalog/tooltiplabels');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/tooltiplabels');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_tooltiplabels->addTooltiplabel($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

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

            $this->response->redirect($this->url->link('catalog/tooltiplabels', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function edit()
    {
        $this->load->language('catalog/tooltiplabels');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/tooltiplabels');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_tooltiplabels->editTooltiplabel($this->request->get['tooltiplabel_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

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

            $this->response->redirect($this->url->link('catalog/tooltiplabels', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete()
    {
        $this->load->language('catalog/tooltiplabels');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/tooltiplabels');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $tooltiplabel_id) {
                $this->model_catalog_tooltiplabels->deleteTooltiplabels($tooltiplabel_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

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

            $this->response->redirect($this->url->link('catalog/tooltiplabels', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getList();
    }


    protected function getList()
    {
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

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

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/tooltiplabels', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        $data['add'] = $this->url->link('catalog/tooltiplabels/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('catalog/tooltiplabels/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['settings'] = $this->url->link('catalog/tooltiplabels/settings', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['group'] = $this->url->link('catalog/tooltiplabels/group', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data['tooltiplabels'] = array();

        $filter_data = array(
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $tooltiplabels_total = $this->model_catalog_tooltiplabels->getTotalTooltiplabels();

        $results = $this->model_catalog_tooltiplabels->getTooltiplabels($filter_data);

        foreach ($results as $result) {
            $data['tooltiplabels'][] = array(
                'tooltiplabel_id' => $result['tooltiplabel_id'],
                'name'        => $result['name'],
                'count'    => $result['count'],
				'status'    => $result['status'],
                'edit'        => $this->url->link('catalog/tooltiplabels/edit', 'token=' . $this->session->data['token'] . '&tooltiplabel_id=' . $result['tooltiplabel_id'] . $url, 'SSL'),
                'delete'      => $this->url->link('catalog/tooltiplabels/delete', 'token=' . $this->session->data['token'] . '&tooltiplabel_id=' . $result['tooltiplabel_id'] . $url, 'SSL')
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_name'] = $this->language->get('column_name');
        $data['column_count'] = $this->language->get('column_count');
        $data['column_action'] = $this->language->get('column_action');

        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_settings'] = $this->language->get('button_settings');
        $data['button_group'] = $this->language->get('button_group');

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

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_name'] = $this->url->link('catalog/tooltiplabels', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $tooltiplabels_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('catalog/tooltiplabels', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($tooltiplabels_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($tooltiplabels_total - $this->config->get('config_limit_admin'))) ? $tooltiplabels_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $tooltiplabels_total, ceil($tooltiplabels_total / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/tooltiplabels_list.tpl', $data));
    }

    protected function getForm()
    {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['tooltiplabel_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_default'] = $this->language->get('text_default');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_names'] = $this->language->get('entry_names');
        $data['entry_description'] = $this->language->get('entry_description');
        $data['entry_meta_title'] = $this->language->get('entry_meta_title');
        $data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
        $data['entry_keyword'] = $this->language->get('entry_keyword');
        $data['entry_store'] = $this->language->get('entry_store');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_description_top'] = $this->language->get('entry_description_top');
        $data['entry_description_bottom'] = $this->language->get('entry_description_bottom');
        $data['entry_h1'] = $this->language->get('entry_h1');
        $data['entry_category'] = $this->language->get('entry_category');

        $data['help_keyword'] = $this->language->get('help_keyword');
        $data['help_description_top'] = $this->language->get('help_description_top');
        $data['help_description_bottom'] = $this->language->get('help_description_bottom');
        $data['help_h1'] = $this->language->get('help_h1');
        $data['help_category'] = $this->language->get('help_category');
        $data['help_names'] = $this->language->get('help_names');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_data'] = $this->language->get('tab_data');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = array();
        }

        if (isset($this->error['meta_title'])) {
            $data['error_meta_title'] = $this->error['meta_title'];
        } else {
            $data['error_meta_title'] = array();
        }

        if (isset($this->error['keyword'])) {
            $data['error_keyword'] = $this->error['keyword'];
        } else {
            $data['error_keyword'] = '';
        }

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

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/tooltiplabels', 'token=' . $this->session->data['token'] . $url, 'SSL')
        );

        if (!isset($this->request->get['tooltiplabel_id'])) {
            $data['action'] = $this->url->link('catalog/tooltiplabels/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('catalog/tooltiplabels/edit', 'token=' . $this->session->data['token'] . '&tooltiplabel_id=' . $this->request->get['tooltiplabel_id'] . $url, 'SSL');
        }

        $data['cancel'] = $this->url->link('catalog/tooltiplabels', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (isset($this->request->get['tooltiplabel_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $tooltiplabel_info = $this->model_catalog_tooltiplabels->getTooltiplabel($this->request->get['tooltiplabel_id']);
        }

        $data['token'] = $this->session->data['token'];

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['tooltiplabel_description'])) {
            $data['tooltiplabel_description'] = $this->request->post['tooltiplabel_description'];
        } elseif (isset($this->request->get['tooltiplabel_id'])) {
            $data['tooltiplabel_description'] = $this->model_catalog_tooltiplabels->getTooltiplabelDescriptions($this->request->get['tooltiplabel_id']);
        } else {
            $data['tooltiplabel_description'] = array();
        }


        $this->load->model('setting/store');

        $data['stores'] = $this->model_setting_store->getStores();

        if (isset($this->request->post['tooltiplabel_store'])) {
            $data['tooltiplabel_store'] = $this->request->post['tooltiplabel_store'];
        } elseif (isset($this->request->get['tooltiplabel_id'])) {
            /* $data['tooltiplabel_store'] = $this->model_catalog_tooltiplabels->getTooltiplabelStores($this->request->get['tooltiplabel_id']); */
			$data['tooltiplabel_store'] = array(0);
        } else {
            $data['tooltiplabel_store'] = array(0);
        }

        if (isset($this->request->post['keyword'])) {
            $data['keyword'] = $this->request->post['keyword'];
        } elseif (!empty($tooltiplabel_info)) {
            $data['keyword'] = $tooltiplabel_info['keyword'];
        } else {
            $data['keyword'] = '';
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($tooltiplabel_info)) {
            $data['status'] = $tooltiplabel_info['status'];
        } else {
            $data['status'] = true;
        }

        if (isset($this->request->post['category_id'])) {
            $data['category_id'] = $this->request->post['category_id'];
        } elseif (!empty($tooltiplabel_info)) {
            $data['category_id'] = $tooltiplabel_info['category_id'];
        } else {
            $data['category_id'] = 0;
        }

        $this->load->model('catalog/category');
        $data['categories'] = $this->model_catalog_category->getCategories();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/tooltiplabels_form.tpl', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'catalog/tooltiplabels')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        foreach ($this->request->post['tooltiplabel_description'] as $language_id => $value) {
            if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = $this->language->get('error_name');
            }

        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'catalog/tooltiplabels')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function autocomplete()
    {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('catalog/tooltiplabels');

            $filter_data = array(
                'filter_name' => $this->request->get['filter_name'],
                'sort'        => 'name',
                'order'       => 'ASC',
                'start'       => 0,
                'limit'       => 5
            );

            $results = $this->model_catalog_tooltiplabels->getTooltiplabels($filter_data);

            foreach ($results as $result) {
                $json[] = array(
                    'tooltiplabel_id' => $result['tooltiplabel_id'],
                    'name'        => strip_tooltiplabels(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function settings()
    {
        $this->load->language('catalog/tooltiplabels');

        $data['heading_title'] = $this->language->get('heading_title')." - ".$this->language->get('button_settings');
        $this->document->setTitle($data['heading_title']);
        $data['action'] = $this->url->link('catalog/tooltiplabels/save_settins', 'token=' . $this->session->data['token'], 'SSL');

        $data['text_form'] = $this->language->get('button_settings');

        $data['entry_etopd'] = $this->language->get('entry_etopd');
        $data['entry_ebottomd'] = $this->language->get('entry_ebottomd');
        $data['entry_only'] = $this->language->get('entry_only');
        $data['entry_ajax'] = $this->language->get('entry_ajax');
        $data['entry_scategory'] = $this->language->get('entry_scategory');
        $data['entry_count'] = $this->language->get('entry_count');
        $data['entry_related'] = $this->language->get('entry_related');

        $data['help_etopd'] = $this->language->get('help_etopd');
        $data['help_ebottomd'] = $this->language->get('help_ebottomd');
        $data['help_only'] = $this->language->get('help_only');
        $data['help_ajax'] = $this->language->get('help_ajax');
        $data['help_scategory'] = $this->language->get('help_scategory');
        $data['help_count'] = $this->language->get('help_count');
        $data['help_related'] = $this->language->get('help_related');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');

        $data['tab_general'] = $this->language->get('tab_general');

        $data['setting_etopd'] = $this->config->get('newtooltiplabels_etopd');
        $data['setting_ebottomd'] = $this->config->get('newtooltiplabels_ebottomd');
        $data['setting_only'] = $this->config->get('newtooltiplabels_only');
        $data['setting_ajax'] = $this->config->get('newtooltiplabels_ajax');
        $data['setting_scategory'] = $this->config->get('newtooltiplabels_category');
        $data['setting_count'] = $this->config->get('newtooltiplabels_count');
        $data['setting_related'] = $this->config->get('newtooltiplabels_related');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/tooltiplabels', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/tooltiplabels/settings', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['cancel'] = $this->url->link('catalog/tooltiplabels', 'token=' . $this->session->data['token'], 'SSL');

        $data['token'] = $this->session->data['token'];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/tooltiplabels_settings.tpl', $data));
    }

    public function save_settins()
    {
        $this->load->language('catalog/tooltiplabels');

        $data['heading_title'] = $this->language->get('heading_title')." - ".$this->language->get('button_settings');

        $this->load->model('catalog/tooltiplabels');

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->config->set('newtooltiplabels_etopd', $this->request->post['setting_etopd']);
            $this->config->set('newtooltiplabels_ebottomd', $this->request->post['setting_ebottomd']);
            $this->config->set('newtooltiplabels_only', $this->request->post['setting_only']);
            $this->config->set('newtooltiplabels_ajax', $this->request->post['setting_ajax']);
            $this->config->set('newtooltiplabels_category', $this->request->post['setting_scategory']);
            $this->config->set('newtooltiplabels_count', $this->request->post['setting_count']);
            $this->config->set('newtooltiplabels_related', $this->request->post['setting_related']);
            $this->model_catalog_tooltiplabels->setSettings($this->request->post);
            $this->session->data['success'] = $this->language->get('text_success_settings');

            $this->response->redirect($this->url->link('catalog/tooltiplabels', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->response->redirect($this->url->link('catalog/settings', 'token=' . $this->session->data['token'], 'SSL'));
    }
}
