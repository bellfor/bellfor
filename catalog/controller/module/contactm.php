<?php
# @Author: Oleg
# @Date:   Thursday, September 28th 2017, 6:33:32 pm
# @Email:  oleg@webiprog.com
# @Project: http://barcodes.webiprog.com
# @Filename: contactm.php
# @Last modified by:   Oleg
# @Last modified time: Friday, September 29th 2017, 1:40:06 pm
# @License: free
# @Copyright: webiprog.com



class ControllerModuleContactm extends Controller
{
    public function index()
    {
        $this->load->language('module/contactm');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_enquiry'] = $this->language->get('entry_enquiry');
		$data['entry_phone'] = $this->language->get('entry_phone');

        $data['button_submit'] = $this->language->get('button_submit');
        $data['heading_title'] = $this->language->get('heading_title');
        $data['entry_captcha'] = $this->language->get('entry_captcha');

        $data['button_wait'] = $this->language->get('button_wait');
        $data['entry_captcha_title'] = $this->language->get('entry_captcha_title');
        if (empty($data['button_wait'])) {
            $data['button_wait'] = 'wait..';
        }

		/*
		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$data['captcha'] = $this->load->controller('captcha/' . $this->config->get('config_captcha'), $this->error);
		} else {
			$data['captcha'] = '';
		}
		*/
        //return $this->load->view('extension/module/contactm', $data);
		//return $this->load->view('default/template/module/contactm.tpl', $data);

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/contactm.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/module/contactm.tpl', $data);
        } else {
            return $this->load->view('default/template/module/contactm.tpl', $data);
        }


    }

    protected function respond(array $json)
    {
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
        //echo json_encode($respond, JSON_NUMERIC_CHECK);
    }


    public function send()
    {

        //set the level of error reporting
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

        $this->load->language('module/contactm');
        $json = array();
		$ajx_err = false;

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
            $json['error'] = $this->language->get('error_name');
            $json['error_title'] = 'error_name';
			$this->respond($json);
			return;
        }

        if (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
            $json['error'] = $this->language->get('error_email');
            $json['error_title'] = 'error_email';
			$this->respond($json);
			return;
        }

        if ((utf8_strlen($this->request->post['enquiry']) < 10) || (utf8_strlen($this->request->post['enquiry']) > 3000)) {
            $json['error'] = $this->language->get('error_enquiry');
            $json['error_title'] = 'error_enquiry';
			$this->respond($json);
			return;
        }

        /*
        $xhttprequested =
        isset($this->request->server['HTTP_X_REQUESTED_WITH'])
        && (strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

        $captcha = isset($this->request->get['route']) && $this->request->get['route']=='tool/captcha';
        */


		// Captcha
		/*
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				//$this->error['captcha'] = $captcha;
				$json['error'] = $this->language->get('error_captcha');
                $json['error_title'] = 'error_captcha';
			$this->respond($json);
			exit();

			}
		}
		*/

        if (isset($this->request->post['captcha']) && ($this->request->server['HTTP_HOST'] != 'localhost')) {
            if (empty($this->session->data['captcha'])
            ||
            (strtolower($this->session->data['captcha']) != strtolower($this->request->post['captcha']))
        ) {
                $json['error'] = $this->language->get('error_captcha');
                $json['error_title'] = 'error_captcha';
				$this->respond($json);
			    return;
            }
        }

        if (!isset($json['error'])) {
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			// //fixed by oppo webiprog.com  12.07.2018
			// please send the form from https://nl.bellfor.info/ to <nicole.veniger@bellfor.info>
			$stunl = strpos($this->config->get('config_url'), 'nl.bellfor.info', 7);
			if($stunl) {
			$setTo = 'nicole.veniger@bellfor.info';
			}else {
			$setTo = $this->config->get('config_email');
			}

			$new_name = filter_var($this->request->post['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

            $mail->setTo($setTo);
            $mail->setFrom($setTo);
            $mail->setReplyTo($this->request->post['email']);
            $mail->setSender(html_entity_decode($new_name, ENT_QUOTES, 'UTF-8'));
            $mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $new_name), ENT_QUOTES, 'UTF-8'));

			$text = $this->language->get('Name').': '.$new_name.PHP_EOL;
			if(!empty($this->request->post['phone']) ) {
				$text .= $this->language->get('entry_phone').': '.$this->request->post['phone'].PHP_EOL.'------------------
				'.PHP_EOL;
			}
			$text .= $this->request->post['enquiry'];
            $mail->setText($text);
            $mail->send();

            $json['success'] = $this->language->get('text_success');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function captcha()
    {
        $this->load->library('captcha');
        $captcha = new Captcha();
        $this->session->data['captcha'] = $captcha->getCode();
        $captcha->showImage();
    }
}
