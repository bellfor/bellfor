<?php
# @Date:   Wednesday, December 20th 2017, 12:07:04 pm
# @Email:  oleg@webiprog.com
# @Project: belfor
# @Filename: bellfor_youtube.php
# @Last modified by:   Oleg
# @Last modified time: Wednesday, December 20th 2017, 5:04:45 pm
# @License: free




class ControllerModuleBellforYoutube extends Controller
{

    //protected function index($module) {
    public function index($setting)
    {
        static $module = 0;

        $this->language->load('module/bellfor_youtube');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['youtube_extension'] = $this->language->get('youtube_extension');
		$data['module_title'] = $this->language->get('module_title') != 'module_title'?$this->language->get('module_title'):'';

        $youtube_code = $this->config->get('bellfor_youtube_'. $module . '_code') ;

        if (!empty($youtube_code)) {
            $arr_youtube_code = explode(',', $youtube_code);
            $arr_youtube_code = (array_map('trim', $arr_youtube_code));
            $new_code = $arr_youtube_code[rand(0, count($arr_youtube_code) - 1)];
            if (!$new_code) {
                return ;
            }
            $data['code']= html_entity_decode($new_code, ENT_QUOTES);

            $data['id'] = $this->id = 'bellfor_youtube';
        } else {
            $data['code'] = 'You must set text in the module Youtube Module!';
            return ;
        }

        $data['module'] = $module++;

        /*
        $position = $this->config->get('bellfor_youtube_' . $module . '_position') ;
        $layout_id = $this->config->get('bellfor_youtube_' . $module . '_layout_id') ;
        */


        $data['type'] = $data['position'] = false;
        if (!empty($setting) && isset($setting['type']) && isset($setting['position'])) {
            $data['type'] = $setting['type'];
            $data['position'] = $setting['position'];
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/custom_module.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/module/custom_module.tpl', $data);
        } else {
            return $this->load->view('default/template/module/bellfor_youtube.tpl', $data);
        }
    }
}
