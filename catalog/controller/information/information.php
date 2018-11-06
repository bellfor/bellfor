<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerInformationInformation extends Controller {
	public function index() {
		$this->load->language('information/information');

		$this->load->model('catalog/information');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}
		
		$data['information_id'] = $information_id;
		
		$data['callback_heading_1'] = $this->language->get('callback_heading_1');
		$data['callback_heading_2'] = $this->language->get('callback_heading_2');
		$data['callback_heading_3'] = $this->language->get('callback_heading_3');
		$data['callback_heading_4'] = $this->language->get('callback_heading_4');
		
		$data['callback_text_label_name'] = $this->language->get('callback_text_label_name');
		$data['callback_text_label_phone'] = $this->language->get('callback_text_label_phone');
		$data['callback_text_label_mail'] = $this->language->get('callback_text_label_mail');
		$data['callback_text_label_date'] = $this->language->get('callback_text_label_date');
		
		$data['callback_text_submit'] = $this->language->get('callback_text_submit');

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
		
		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {

            $data['race_id'] = $information_info['race_id'];
            $data['status_consultant'] = $information_info['status_consultant'];

            ////Consultant
            if  ($data['status_consultant']){

                $this->load->model('extension/race');

                $race_dogs = $this->model_extension_race->getRace();

                foreach ($race_dogs as $race_dog){
                    if ($information_info['race_id'] == $race_dog['race_id']){
                        $data['race_dog'] = $race_dog;
                    }
                }
            }
		
			if ($information_info['meta_title']) {
				$this->document->setTitle($information_info['meta_title']);
			} else {
				$this->document->setTitle($information_info['title']);
			}
			
			if ($information_info['noindex'] <= 0) {
				$this->document->setRobots('noindex,follow');
			}
			
			if ($information_info['meta_h1']) {
				$data['heading_title'] = $information_info['meta_h1'];
			} else {
				$data['heading_title'] = $information_info['title'];
			}
			
			$this->document->setDescription($information_info['meta_description']);
			$this->document->setKeywords($information_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $information_info['title'],
				'href' => $this->url->link('information/information', 'information_id=' .  $information_id)
			);

			$data['button_continue'] = $this->language->get('button_continue');

			$data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/information.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/information/information.tpl', $data));
			}
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('information/information', 'information_id=' . $information_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}

	public function agree() {
		$this->load->model('catalog/information');

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$output = '';

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			$output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}

		$this->response->setOutput($output);
	}
}