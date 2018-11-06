<?php
/**
 * @file: referral_bellfor.php
 * @package:    d:\openserver7\OpenServer\domains\localhost\bellfor.info_opc\catalog\controller\module
 * @created:    Tue May 08 2018
 * @version:    1.0.0
 * @modified:   Tuesday April 10th 2018 5:29:57 pm
 * @copyright   (c) 2008-2018 Webiprog GmbH, UA. All rights reserved.
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */


class ControllerModuleReferralBellfor extends Controller
{
    public function index($setting)
    {
        $referral_bellfor_status = $this->config->get('referral_bellfor_status');
        if (empty($referral_bellfor_status)) {
            return;
        }


        if (!empty($this->session->data['user_id'])) {
            $data['is_admin'] = $this->session->data['user_id'];
        } else {
            $data['is_admin'] = false;
        }

        $data['lng'] = $this->load->language('module/referral_bellfor');

        $find = array(
      '{sending_reward}',
      '{coupon_redeemed_reward}',
      '{reward_type}',
      '{coupon_discount}',
      '{order_total}',
      '{customer_login}',
      '{expire}',
      '{uses_total}',
      '{uses_customer}'
    );

        $replace = array(
      $this->config->get('referral_bellfor_sending_reward'),
      $this->config->get('referral_bellfor_referrer_reward_for_coupon_used'),
      ($this->config->get('referral_bellfor_reward_type') == 'credit' ? $this->language->get('text_store_credit') : $this->language->get('text_reward_point')),
      ($this->config->get('referral_bellfor_type') == 'P' ? $this->config->get('referral_bellfor_discount') . '%' : $this->currency->format($this->config->get('referral_bellfor_discount'), $this->session->data['currency'])),
      $this->currency->format($this->config->get('referral_bellfor_total'), $this->session->data['currency']),
      ($this->config->get('referral_bellfor_logged') ? $this->language->get('text_yes') : $this->language->get('text_no')),
      $this->config->get('referral_bellfor_expire'),
      $this->config->get('referral_bellfor_uses_total'),
      $this->config->get('referral_bellfor_uses_customer')
    );

        $data['info'] = str_replace($find, $replace, $this->language->get('html_info'));

        $data['is_logged'] = $this->customer->isLogged();

        $data['sending_limit'] = $this->getSendingLimit();

        $data['sample_email'] = $this->getEmailHTML();

        if (version_compare(VERSION, '2.2') >= 0) {
            return $this->load->view('module/referral_bellfor.tpl', $data);
        } else {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/referral_bellfor.tpl')) {
                return $this->load->view($this->config->get('config_template') . '/template/module/referral_bellfor.tpl', $data);
            } else {
                return $this->load->view('default/template/module/referral_bellfor.tpl', $data);
            }
        }
    } //index end

    public function getReferrals()
    {
        if (!$this->customer->isLogged()) {
            return;
        }

        $data['lng'] = $this->load->language('module/referral_bellfor');

        $data['referrals'] = array();

        $page = empty($this->request->get['page']) ? 1 : $this->request->get['page'];
        $limit = 10;
        $start = ($page - 1) * $limit;

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_referral_bellfor WHERE referrer_id = '" . (int)$this->customer->getId() . "' ORDER BY date_added DESC LIMIT " . $start . ', ' . $limit);
        foreach ($query->rows as $r) {
            $data['referrals'][] = array(
        'name' => $r['name'],
        'email' => $r['email'],
        'date_added' => date($this->language->get('date_format_short'), strtotime($r['date_added']))
      );
        }

        $referrals_total = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_referral_bellfor WHERE referrer_id = '" . (int)$this->customer->getId() . "'")->row['total'];

        $pagination = new Pagination();
        $pagination->total = $referrals_total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->url = '{page}';

        $data['pagination'] = str_replace("a href", "a onclick='getReferrals(this.id);' id", $pagination->render());

        $data['results'] = sprintf($this->language->get('text_pagination'), ($referrals_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($referrals_total - $limit)) ? $referrals_total : ((($page - 1) * $limit) + $limit), $referrals_total, ceil($referrals_total / $limit));

        if (version_compare(VERSION, '2.2') >= 0) {
            $html = $this->load->view('module/referral_bellfor_table.tpl', $data);
        } else {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/referral_bellfor_table.tpl')) {
                $html = $this->load->view($this->config->get('config_template') . '/template/module/referral_bellfor_table.tpl', $data);
            } else {
                $html = $this->load->view('default/template/module/referral_bellfor_table.tpl', $data);
            }
        }

        $this->response->setOutput($html);
    } //getReferrals end
    /**
     * Function to check if the request is an AJAX request
     *
     * @return boolean
     */
    public function is_ajax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }


    public function sendReferral()
    {
        $json['error'] = '';

        $ajax=$this->is_ajax();

        $this->load->language('module/referral_bellfor');

        if ($ajax && isset($this->request->get['referee_email']) && is_array($this->request->get['referee_email']) && empty($json['error'])) {
            $referrer_message = $this->request->get['referrer_message'];

            foreach ($this->request->get['referee_email'] as $key => $referee_email) {
                $referee_name = trim($this->request->get['referee_name'][$key]);
                $json['referee'][$key]['name'] = $this->request->get['referee_name'][$key];

                $referee_email = trim($referee_email);
                $json['referee'][$key]['email'] = $referee_email;

                $sending_limit = $this->getSendingLimit();
                $json['referee'][$key]['error']['limit_reached'] = $sending_limit['remain'] <= 0 ? $sending_limit['text'] : '';

                $email_existed = $this->db->query("SELECT email FROM " . DB_PREFIX . "customer_referral_bellfor WHERE email = '" . $this->db->escape($referee_email) . "' UNION SELECT email FROM " . DB_PREFIX . "customer WHERE email='" . $this->db->escape($referee_email) . "'")->num_rows;
                $json['referee'][$key]['error']['email_existed'] = $email_existed ? $this->language->get('error_email_existed') : '';

                if ($sending_limit['remain'] > 0 && !$email_existed) {
                    while (empty($code)) {
                        $code = substr(md5(mt_rand()), 0, 10);
                        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "coupon WHERE code = '" . $this->db->escape($code) . "'");
                        if ($query->num_rows) {
                            $code = '';
                        }
                    }

                    $coupon_name = str_replace('{referee_name}', $referee_name, $this->language->get('coupon_name'));

                    $date_end = ($this->config->get('referral_bellfor_expire')) ? date('Y-m-d', strtotime('today') + ($this->config->get('referral_bellfor_expire') * 86400)) : '0000-00-00';

                    $this->db->query("INSERT INTO " . DB_PREFIX . "coupon SET name = '" . $this->db->escape($coupon_name) . "', code = '" . $this->db->escape($code) . "', type = '" . $this->db->escape($this->config->get('referral_bellfor_type')) . "', discount = '" . (float)$this->config->get('referral_bellfor_discount') . "', total = '" . (float)$this->config->get('referral_bellfor_total') . "', logged = '" . (int)$this->config->get('referral_bellfor_logged') . "', shipping = '" . (int)$this->config->get('referral_bellfor_shipping') . "', date_start = NOW(), date_end = '" . $this->db->escape($date_end) . "', uses_total = '" . (int)$this->config->get('referral_bellfor_uses_total') . "', uses_customer = '" . (int)$this->config->get('referral_bellfor_uses_customer') . "', status = '1', date_added = NOW()");

                    $coupon_id = $this->db->getLastId();

                    $this->db->query("INSERT INTO " . DB_PREFIX . "customer_referral_bellfor SET referrer_id = '" . (int)$this->customer->getId() . "', coupon_id = '" . (int)$coupon_id . "', date_added = NOW(), name = '" . $this->db->escape($referee_name) . "', email = '" . $this->db->escape($referee_email) . "'");

                    // if ($this->config->get('referral_bellfor_referrer_sending_reward')) {
                    //     $description = str_replace('{referee_name}', $referee_name, $this->language->get('text_sending_referral_reward_desc'));
                    //     $this->addReward($this->customer->getId(), 0, $this->config->get('referral_bellfor_referrer_sending_reward'), $description);
                    // }

                    if ($this->config->get('referral_bellfor_from_email') == 'custom') {
                        $from['email'] = $this->config->get('referral_bellfor_from_custom_email');
                        $from['name'] = $this->config->get('referral_bellfor_from_custom_name');
                    } elseif ($this->config->get('referral_bellfor_from_email') == 'referrer') {
                        $from['email'] = $this->customer->getEmail();
                        $from['name'] = $this->customer->getFirstName() . ' ' . $this->customer->getLastName();
                    } else {
                        $from['email'] = $this->config->get('config_email');
                        $from['name'] = $this->config->get('config_name');
                    }

                    $to['email'] = $referee_email;
                    $to['name'] = $referee_name;

                    $subject = str_replace('{referrer_name}', $this->customer->getFirstName() . ' ' . $this->customer->getLastName(), $this->language->get('email_subject'));

                    $body = $this->getEmailHTML($code, $referee_name, $referrer_message);

                    $this->email($from, $to, $subject, $body);

                    $json['referee'][$key]['success'] = $this->language->get('text_sent_success');
                    $this->_last_run=true;
                }
            }
            // end foreach
            if ($this->_last_run===true) {
                $referee_name = $this->customer->getFirstName() . ' ' . $this->customer->getLastName();
                $coupon_name = str_replace('{referee_name}', $referee_name, $this->language->get('coupon_name'));
                $coupon_code = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);
                $expire_date = ($this->config->get('referral_bellfor_expire')) ? date('Y-m-d', strtotime('today') + ($this->config->get('referral_bellfor_expire') * 86400)) : '0000-00-00';
                $customer_id = $this->customer->getId();
                if ($customer_id) {
                    $res_id=$this->AddcouponSender($coupon_name, $coupon_code, $expire_date);
                    //  добавили купон успешно
                    if ($res_id) {
                        // отправить код купона отправителю
                        $this->notifySenderCoupon($this->customer->getId(), $coupon_code, $expire_date);
                    }
                    $this->_last_run=false;
                }
            }
        }
           //trigger_error('Access denied - not an AJAX request...' . ' (' . $script . ')', E_USER_ERROR);


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    } //sendReferral end


    private $_last_run=false;
    private $_coupon_code;
    /**
     * add coupon to sender
     *
     * @return void
     */
    public function AddcouponSender($coupon_name, $code, $date_end)
    {
        //logged = '" . (int)$this->config->get('referral_bellfor_logged') . "',

        $this->db->query(
            "INSERT INTO " . DB_PREFIX . "coupon SET name = '" . $this->db->escape($coupon_name) . "',
                code = '" . $this->db->escape($code) . "',
                type = '" . $this->db->escape($this->config->get('referral_bellfor_referrer_reward_for_coupon_used_type')) . "',
                discount = '" . (float)$this->config->get('referral_bellfor_referrer_reward_for_coupon_used') . "',
                total = '" . (float)$this->config->get('referral_bellfor_total') . "',
                logged = '1',
                shipping = '" . (int)$this->config->get('referral_bellfor_shipping') . "',
                date_start = NOW(), date_end = '" . $this->db->escape($date_end) . "',
                uses_total = '" . (int)$this->config->get('referral_bellfor_uses_total') . "',
                uses_customer = '" . (int)$this->config->get('referral_bellfor_uses_customer') . "',
                status = '1',
                date_added = NOW()"
            );
        $coupon_id = $this->db->getLastId();
        $this->_coupon_code = $code;
        return $coupon_id;
    }

    /**
 * письмо отправка кода купона отправителю
 *
 * @param integer $customer_id
 * @param [type] $coupon_code
 * @return void
 */
    public function notifySenderCoupon($customer_id = 0, $coupon_code, $expire_date)
    {
        $from['email'] = $this->config->get('config_email');
        $from['name'] = $this->config->get('config_name');
        if ($expire_date=='0000-00-00') {
            $expire_date='';
        }

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
        if ($query->num_rows) {
            $to['email'] = $query->row['email'];
            $to['name'] = $query->row['firstname'] . ' ' . $query->row['lastname'];

            if ($this->config->get('referral_bellfor_reward_type') == 'credit') {
                $reward_type = $this->language->get('text_store_credit');
            } else {
                $reward_type = $this->language->get('text_reward_point');
            }

            $reward =(float)$this->config->get('referral_bellfor_referrer_reward_for_coupon_used');
            $img_config_logo = $this->config->get('config_logo')?$this->config->get('config_logo'):'catalog/logo.png';
            $store_link = HTTP_SERVER;
            $reward_total=0;

            $store_logo = $store_link . 'image/' . $img_config_logo;
            // $store_name = $this->config->get('config_name');
            $coupon_discount = ($this->config->get('referral_bellfor_referrer_reward_for_coupon_used_type') == 'P' ? $this->config->get('referral_bellfor_referrer_reward_for_coupon_used') . '%' : $this->currency->format($this->config->get('referral_bellfor_referrer_reward_for_coupon_used'), $this->session->data['currency']));

            $subject = str_replace(
        array('{reward}', '{reward_type}', '{store_name}','{coupon_discount}'),
        array($reward, $reward_type, $this->config->get('config_name'),$coupon_discount),
        $this->language->get('email_subject_customer')
      );

            $body = str_replace(
        array('{reward}', '{reward_type}', '{reward_total}', '{store_name}', '{customer}','{coupon_code}', '{reward_type}','{coupon_discount}',
        '{expire_date}'),
        array($reward, $reward_type, $reward_total, $this->config->get('config_name'), $to['name'],$coupon_code,$reward_type,$coupon_discount,$expire_date),
        $this->language->get('email_body_customer_coupon_notification')
      );

            $this->email($from, $to, $subject, $body);
        }
    } //notifySenderCoupon end

    public function getEmailHTML($coupon_code = '{coupon_code}', $referee_name = '{referee_name}', $referrer_message = '{referrer_message}')
    {
        $this->load->language('module/referral_bellfor');

        $reward_type = $this->config->get('referral_bellfor_reward_type') == 'credit' ? $this->language->get('text_store_credit') : $this->language->get('text_reward_point');
        $expire_date = ($this->config->get('referral_bellfor_expire')) ? date($this->language->get('date_format_short'), strtotime('today') + ($this->config->get('referral_bellfor_expire') * 86400)) : '';
        $order_total = $this->currency->format($this->config->get('referral_bellfor_total'), $this->session->data['currency']);
        $customer_login = ($this->config->get('referral_bellfor_logged') ? $this->language->get('text_yes') : $this->language->get('text_no'));
        $uses_total = $this->config->get('referral_bellfor_uses_total');
        $uses_customer = $this->config->get('referral_bellfor_uses_customer');
        $referrer_name = $this->customer->getFirstName() . ' ' . $this->customer->getLastName();
        $store_link = HTTP_SERVER;

        //fixed by oppo 11.04.2018
        $img_config_logo = $this->config->get('config_logo')?$this->config->get('config_logo'):'catalog/logo.png';
        $store_logo = $store_link . 'image/' . $img_config_logo;
        $store_name = $this->config->get('config_name');
        $coupon_discount = ($this->config->get('referral_bellfor_type') == 'P' ? $this->config->get('referral_bellfor_discount') . '%' : $this->currency->format($this->config->get('referral_bellfor_discount'), $this->session->data['currency']));

        $html = str_replace(
      array('{referee_name}', '{referrer_message}', '{coupon_code}', '{reward_type}', '{expire_date}', '{order_total}', '{customer_login}', '{uses_total}', '{uses_customer}', '{referrer_name}', '{store_link}', '{store_logo}', '{store_name}', '{coupon_discount}'),
      array($referee_name, $referrer_message, $coupon_code, $reward_type, $expire_date, $order_total, $customer_login, $uses_total, $uses_customer, $referrer_name, $store_link, $store_logo, $store_name, $coupon_discount),
      $this->language->get('email_body')
    );

        return $html;
    } //getEmailHTML end

    public function email($from = array(), $to = array(), $subject = '', $body = '')
    {
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

        $mail->setFrom($from['email']);
        $mail->setSender(html_entity_decode($from['name'], ENT_QUOTES, 'UTF-8'));
        $mail->setTo($to['email']);
        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setHtml($body);
        $res=$mail->send();
        return $res;
    } //email end

    public function getSendingLimit()
    {
        $this->load->language('module/referral_bellfor');

        $data['text'] = '';
        $data['remain'] = 1;

        if ($this->config->get('referral_bellfor_limit') && $this->config->get('referral_bellfor_period')) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_referral_bellfor WHERE referrer_id = '" . (int)$this->customer->getId() . "' AND date_added > DATE_SUB(NOW(), INTERVAL " . (int)$this->config->get('referral_bellfor_period') . " HOUR) ORDER BY date_added ASC");

            $data['remain'] = $this->config->get('referral_bellfor_limit') - $query->num_rows;
            if ($data['remain'] <= 0) {
                $time = date('H:i:s', strtotime($query->row['date_added']) + (3600 * (int)$this->config->get('referral_bellfor_period')));
                $data['text'] = str_replace('{time}', $time, $this->language->get('error_sending_limit_reached'));
            } else {
                $find = array(
          '{referrals}',
          '{hours}',
          '{remain}'
        );

                $replace = array(
          $this->config->get('referral_bellfor_limit'),
          $this->config->get('referral_bellfor_period'),
          $data['remain']
        );

                $data['text'] = str_replace($find, $replace, $this->language->get('error_sending_limit_reached'));
            }
        }

        return $data;
    } //getSendingLimit end

    public function updateOrder($route = '', $output = '', $order_id = 0, $order_status_id = 0)
    {
        $this->couponUsedReward($order_id);
    } //updateOrder end
    /**
     * disabled function
     * отключил потом разберусь
     *
     * @param integer $order_id
     * @return void
     */
    public function couponUsedReward($order_id = 0)
    {
        if (!$this->config->get('referral_bellfor_referrer_reward_for_coupon_used')) {
            return;
        }

        // отключил потом разберусь
        return;

        $this->load->language('module/referral_bellfor');

        if (isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];
        }

        $query = $this->db->query("SELECT *, ch.customer_id AS referee_id FROM " . DB_PREFIX . "coupon_history ch JOIN " . DB_PREFIX . "customer_referral_bellfor crc ON ch.coupon_id = crc.coupon_id JOIN `" . DB_PREFIX . "order` o ON o.order_id = ch.order_id WHERE crc.referrer_id != o.customer_id AND ch.order_id = '" . (int)$order_id . "'");

        if ($query->num_rows) {
            $referrer_id = $query->row['referrer_id'];
            $reward = 0;

            $description = str_replace(
        array('{order_id}', '{referee_name}', '{referee_email}'),
        array($order_id, $query->row['firstname'] . ' ' . $query->row['lastname'], $query->row['email']),
        $this->language->get('text_coupon_used_reward_desc')
      );

            if ($this->config->get('referral_bellfor_referrer_reward_for_coupon_used_type') == 'F') {
                $reward = $this->config->get('referral_bellfor_referrer_reward_for_coupon_used');
            } else {
                $ot_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' AND code = 'sub_total'");
                if ($ot_query->num_rows) {
                    $reward = $this->config->get('referral_bellfor_referrer_reward_for_coupon_used') * $ot_query->row['value'] / 100;
                }
            }

            if ($referrer_id && $reward && $order_id) {
                if (in_array($query->row['order_status_id'], $this->config->get('config_complete_status'))) {
                    $this->addReward($referrer_id, $order_id, $reward, $description);
                } else {
                    $this->db->query("DELETE FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$order_id . "' AND referral_reward = '1'");
                    $this->db->query("DELETE FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int)$order_id . "' AND referral_reward = '1'");
                }
            }
        }
    } //couponUsedReward end
    /**
     * addReward function
     *
     * disabled
     * @param integer $customer_id
     * @param integer $order_id
     * @param integer $reward
     * @param string $description
     * @return void
     */
    public function addReward($customer_id = 0, $order_id = 0, $reward = 0, $description = '')
    {
        if (!$customer_id || !$reward) {
            return;
        }
        // отключил потом разберусь
        return;

        $this->load->language('module/referral_bellfor');

        if ($this->config->get('referral_bellfor_reward_type') == "point") {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "' AND order_id = '" . (int)$order_id . "' AND order_id != '0'");
            if ($query->num_rows) {
                return;
            }

            $this->db->query("INSERT INTO " . DB_PREFIX . "customer_reward SET customer_id = '" . (int)$customer_id . "', order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($description) . "', points = '" . (int)$reward . "', date_added = NOW(), referral_reward = '1'");
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "' AND order_id = '" . (int)$order_id . "' AND order_id != '0'");
            if ($query->num_rows) {
                return;
            }

            $this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int)$customer_id . "', order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($description) . "', amount = '" . (int)$reward . "', date_added = NOW(), referral_reward = '1'");
        }

        if ($this->config->get('referral_bellfor_notify')) {
            $this->notifyReward($customer_id, $reward);
        }
    } //addReward end


    public function notifyReward($customer_id = 0, $reward = 0)
    {
        $from['email'] = $this->config->get('config_email');
        $from['name'] = $this->config->get('config_name');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
        if ($query->num_rows) {
            $to['email'] = $query->row['email'];
            $to['name'] = $query->row['firstname'] . ' ' . $query->row['lastname'];

            if ($this->config->get('referral_bellfor_reward_type') == 'credit') {
                $reward_type = $this->language->get('text_store_credit');
                $reward_total = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "'")->row['total'];
            } else {
                $reward_type = $this->language->get('text_reward_point');
                $reward_total = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$customer_id . "'")->row['total'];
            }

            $subject = str_replace(
        array('{reward}', '{reward_type}', '{store_name}'),
        array($reward, $reward_type, $this->config->get('config_name')),
        $this->language->get('email_subject_reward_notification')
      );

            $body = str_replace(
        array('{reward}', '{reward_type}', '{reward_total}', '{store_name}', '{customer}'),
        array($reward, $reward_type, $reward_total, $this->config->get('config_name'), $to['name']),
        $this->language->get('email_body_reward_notification')
      );

            $this->email($from, $to, $subject, $body);
        }
    } //notifyReward end

    /**
     * Get the value of _coupon_code
     */
    public function get_coupon_code()
    {
        return $this->_coupon_code;
    }
} //class end
