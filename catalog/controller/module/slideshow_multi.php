<?php
class ControllerModuleSlideshowMulti extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner_multi');
		$this->load->model('tool/image');


		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');
		$this->document->addScript('catalog/view/javascript/slideshow_multi.js');

		//$this->document->addStyle('catalog/view/theme/default/style/banner_multi.css');

		$data['banners_plus'] = array();

		$results = $this->model_design_banner_multi->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners_multi'][] = array(
					'title' 	  => $result['title'],
					'button' 	  => $result['button'],
					'link'  	  => $result['link'],
					'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
					'image' 	  => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['module'] = $module++;

		$data['banner_id'] 						   = $setting['banner_id'];
		$data['arrows'][$setting['banner_id']]     = $setting['arrows_status'];
		$data['pagination'][$setting['banner_id']] = $setting['paginations_status'];

		$data['autoplay'][$setting['banner_id']] = isset($setting['autoplay'])?$setting['autoplay']:'';



		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/slideshow_multi.tpl')) {

			if($module==1) {
			$this->document->addStyle('catalog/view/theme/'. $this->config->get('config_template') . '/style/banner_multi.css');
			}

			return $this->load->view($this->config->get('config_template') . '/template/module/slideshow_multi.tpl', $data);
		} else {
			if($module==1) {
			$this->document->addStyle('catalog/view/theme/default/style/banner_multi.css');
			}
			return $this->load->view('default/template/module/slideshow_multi.tpl', $data);
		}
	}
}