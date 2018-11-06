<?php

/**
 * OpenCart Ukrainian Community
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License, Version 3
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email

 *
 * @category   OpenCart
 * @package    Magic Free Shipping
 * @copyright  Copyright (c) 2015 Eugene Lifescale a.k.a. Shaman by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License, Version 3
 */

class ControllerTotalMagicFreeShipping extends Controller {

    private $error = array();

    public function index() {

        $this->load->model('setting/setting');
        $this->load->model('localisation/geo_zone');

        $this->load->language('total/magic_free_shipping');

        $data = $this->language->load('total/magic_free_shipping');

        $this->document->setTitle($this->language->get('heading_title'));

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {

            // Save Settings
            $this->model_setting_setting->editSetting('magic_free_shipping', $this->request->post);

             // Disable Default Shipping Module
            if ($this->request->post['magic_free_shipping_status']) {
                $this->model_setting_setting->editSetting('shipping', array('shipping_estimator' => (int)$this->config->get('shipping_estimator'), 'shipping_sort_order' => (int)$this->config->get('shipping_sort_order'), 'shipping_status' => 0));
            } else {
                $this->model_setting_setting->editSetting('shipping', array('shipping_estimator' => (int)$this->config->get('shipping_estimator'), 'shipping_sort_order' => (int)$this->config->get('shipping_sort_order'), 'shipping_status' => 1));
            }

            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        if (isset($this->request->post['magic_free_shipping_rates'])) {
            $data['magic_free_shipping_rates'] = $this->request->post['magic_free_shipping_rates'];
        } elseif ($this->config->get('magic_free_shipping_rates')) {
            $data['magic_free_shipping_rates'] = $this->config->get('magic_free_shipping_rates');
        } else {
            $data['magic_free_shipping_rates'] = array();
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_total'),
            'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('total/magic_free_shipping', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('total/magic_free_shipping', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->post['magic_free_shipping_status'])) {
            $data['magic_free_shipping_status'] = $this->request->post['magic_free_shipping_status'];
        } else {
            $data['magic_free_shipping_status'] = $this->config->get('magic_free_shipping_status');
        }

        if (isset($this->request->post['magic_free_shipping_sort_order'])) {
            $data['magic_free_shipping_sort_order'] = $this->request->post['magic_free_shipping_sort_order'];
        } else if ($this->config->get('magic_free_shipping_sort_order')) {
            $data['magic_free_shipping_sort_order'] = $this->config->get('magic_free_shipping_sort_order');
        } else {
            $data['magic_free_shipping_sort_order'] = $this->config->get('shipping_sort_order');
        }

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('total/magic_free_shipping.tpl', $data));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'total/magic_free_shipping')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}
