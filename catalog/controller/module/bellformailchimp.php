<?php
# @Author: Oleg
# @Date:   Tuesday, February 6th 2018, 3:31:41 pm
# @Email:  oleg@webiprog.com
# @Project: DEMO
# @Filename: bellformailchimp.php
# @Last modified by:   Oleg
# @Last modified time: Tuesday, February 6th 2018, 7:55:59 pm
# @License: free
# @Copyright: webiprog.com

if (class_exists('MailChimp') != true) {
    $path = rtrim(realpath(str_replace('/catalog/controller/common', '', $root)), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    include_once $path . 'system/mailchimp/MailChimp.php';
    //oleg@webiprog.com
}
$apiKey = "958f826d51c44608e3b6f9ccb0f6be62-us15";
$listId = "bf24e956ac";

use \DrewM\MailChimp\MailChimp;

/**
 * ControllerModuleBellforMailchimp class
 */
class ControllerModuleBellforMailchimp extends Controller
{
    /**
     * index function
     *
     * @return void
     */
    public function index()
    {
        $data = array();
        $data['bellformailchimp_api_key'] = $this->config->get('bellformailchimp_api_key');
        $data['bellformailchimp_list_id'] = $this->config->get('bellformailchimp_list_id');

        $this->load->language('module/bellformailchimp');

        $task = $this->request->post['task'];
        if ($task == 'subscribe') {
            $data = $this->getData();
            $this->subscribe($data);
        } else {
            $response['status'] = 'error';
            $response['message'] = $this->language->get('error_mailchimp_fail');
            $this->sendResponse($response);
        }

        //return $this->load->view('extension/module/bellformailchimp', $data);
    }

    /**
     * getData function
     *
     * @return array data
     */
    private function getData()
    {
        $data = array();
        $data['email'] = $this->request->post['email'];
        $data['firstname'] = $this->request->post['firstname'];
        $data['lastname'] = $this->request->post['lastname'];
        return $data;
    }
    /**
     * checkEmail function
     *
     * @return void
     */
    private function checkEmail()
    {
        if (!filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }
    /**
     * sendResponse function
     *
     * @param [type] $json
     * @return void
     */
    public function sendResponse($json)
    {
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
    /**
     * getlist function
     *
     * @example test
     * @return void
     */
    public function getlist()
    {
        $this->load->language('module/bellformailchimp');

        $apiKey = $this->config->get('bellformailchimp_api_key');
        $listId = $this->config->get('bellformailchimp_list_id');
        echo "<pre>You apiKey:";
        echo "<strong>$apiKey</strong>";
        echo "<br />You listId:";
        echo "<strong>$listId</strong>";
        echo "</pre><hr />";
        $MailChimp = new MailChimp($apiKey);

        $result = $MailChimp->get('lists');

        if ($MailChimp->success()) {
            foreach ($result['lists'] as $key=>$val) {
                echo "<pre>";
                echo "id:<strong>".($val['id'])."</strong>\n".PHP_EOL;
                echo "web_id:".($val['web_id'])."\n".PHP_EOL;
                echo "name:<strong>".($val['name'])."</strong>\n".PHP_EOL;
                echo "text:".($val['permission_reminder']);
                echo "</pre><hr />";
            }
            echo "<pre>";
            var_export($result);
            echo "</pre>";
        } else {
            echo "<pre>";
            var_export($MailChimp->getLastError());
            echo "</pre>";
            // exit;
        }
        exit;
    }

    /**
     * subscribe function
     *
     * @param [type] $data
     * @return void
     */
    public function subscribe($data = null)
    {
        if (is_null($data)) {
            $data = $this->getData();
        }

        $this->load->language('module/bellformailchimp');

        $apiKey = $this->config->get('bellformailchimp_api_key');
        $listId = $this->config->get('bellformailchimp_list_id');

        $response = array();

        if (!$this->checkEmail()) {
            $response['status'] = 'error';
            $response['message'] = $this->language->get('error_mailchimp_email_invalid');
            $this->sendResponse($response);
            return $response;
        }

        $merge_vars = array();

        if ($this->customer->isLogged()) {
            $fname = $this->customer->getFirstName();
            $lname = $this->customer->getLastName();

            $merge_vars = array(
        "FNAME"        => $fname,
        "LNAME"      => $lname,
    );
        }

        $MailChimp = new MailChimp($apiKey);
        $subscriberHash = $MailChimp->subscriberHash($data['email']);
        //$mailchimp = $MailChimp->post("lists/$listId/members", [
        $mailchimp = $MailChimp->put("lists/$listId/members/$subscriberHash", [
            'email_address' => $data['email'],
            'status' => 'subscribed',
            'merge_fields' => $merge_vars,
        ]);

        // var_dump($MailChimp->getLastResponse());

        if ($MailChimp->success()) {
            $response['status'] = 'success';
            $text_mailchimp_success = $this->language->get('text_mailchimp_success');
            $message = $text_mailchimp_success ? $text_mailchimp_success : $mailchimp['message'];
            $response['message'] = $message;
            $this->sendResponse($response);
            return true;
        } else {
            $response['status'] = 'error';
            $response['message'] = $MailChimp->getLastError();
            $this->sendResponse($response);
            return false;
        }
        exit();
    }
    /**
     * UunSubscribe function
     *
     * @param [type] $data
     * @return void
     */
    public function unSubscribe($data = null)
    {
        if (is_null($data)) {
            $data = $this->getData();
        }
        $this->load->language('module/bellformailchimp');

        $response = array();
        if (!$this->checkEmail()) {
            $response['status'] = 'error';
            $response['message'] = $this->language->get('error_mailchimp_email_invalid');
            $this->sendResponse($response);
            return $response;
        }

        $apiKey = $this->config->get('bellformailchimp_api_key');
        $listId = $this->config->get('bellformailchimp_list_id');

        $MailChimp = new MailChimp($apiKey);
        $subscriber_hash = $MailChimp->subscriberHash($data['email']);
        $result = $MailChimp->patch("lists/$listId/members/$subscriber_hash", [
            'status' => 'unsubscribed',
        ]);
        if ($MailChimp->success()) {
            $response['status'] = 'success';
            $response['status'] = 'success';
            $text_mailchimp_success = $this->language->get('text_mailchimp_success');
            $message = $text_mailchimp_success ? $text_mailchimp_success : $mailchimp['message'];
            $response['message'] = $message;
        } else {
            $response['status'] = 'error';
            $response['message'] = $MailChimp->getLastError();
        }
        $this->sendResponse($response);
        return $response;
    }
    /**
     * update function
     *
     * @param [type] $data
     * @return void
     */
    public function update($data = null)
    {
        if (is_null($data)) {
            $data = $this->getData();
        }
        $this->load->language('module/bellformailchimp');

        $apiKey = $this->config->get('bellformailchimp_api_key');
        $listId = $this->config->get('bellformailchimp_list_id');

        $MailChimp = new MailChimp($apiKey);
        $subscriber_hash = $MailChimp->subscriberHash($data['email']);
        $result = $MailChimp->patch("lists/$listId/members/$subscriber_hash", [
            'merge_fields' => ['FNAME' => $data['firstname'], 'LNAME' => $data['lastname'],
            ]]);
        return $result;
    }
    /**
     * delete function
     *
     * @param [type] $data
     * @return void
     */
    public function delete($data)
    {
        if (is_null($data)) {
            $data = $this->getData();
        }

        $this->load->language('module/bellformailchimp');
        if (!$this->checkEmail()) {
            $response['status'] = 'error';
            $response['message'] = $this->language->get('error_mailchimp_email_invalid');
            $this->sendResponse($response);
            return $response;
        }

        $apiKey = $this->config->get('bellformailchimp_api_key');
        $listId = $this->config->get('bellformailchimp_list_id');

        $MailChimp = new MailChimp($apiKey);
        $subscriber_hash = $MailChimp->subscriberHash($data['email']);
        $result = $MailChimp->delete("lists/$listId/members/$subscriber_hash");
        return $result;
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function whitelist()
    {
        $whitelist = array('127.0.0.1', '::1', 'localhost');
        // Skip for localhost testing
        if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     */

    public function test()
    {
        $data['email'] = '22info@webiprog.de';
        $data['firstname'] = '';
        $data['lastname'] = '';
        $this->load->language('module/bellformailchimp');
        /*
        61431625e9d31f45f2a4acc4d7029225-us15
        bf24e956ac
        */
        $apiKey = "958f826d51c44608e3b6f9ccb0f6be62-us15";
        $listId = "033d58b363";

        $response = array();

        $MailChimp = new MailChimp($apiKey);

        /*
        $merge_vars = array(
           "NAME"        => $_POST["name"],
           "STATUS"      => $_POST["status"],
           "STOREURL"    => $_POST["storeURL"],
           "COUNTRYCOD"  => $_POST["countryCode"],
           "STARTDATE"   => $_POST["startDate"],
           "EXPIRDATE"   => $_POST["expirationDate"]
    );
        */

        $merge_vars = array();

        if ($this->customer->isLogged()) {
            $fname = $this->customer->getFirstName();
            $lname = $this->customer->getLastName();

            $merge_vars = array(
        "FNAME"        => $fname,
        "LNAME"      => $lname,
    );
        }

        //$instance = array_merge(array('text' => '', 'title' => ''), $instance);

        $subscriberHash = $MailChimp->subscriberHash($data['email']);
        $result = $MailChimp->get('lists');
        $mailchimp = $MailChimp->put("lists/$listId/members/$subscriberHash", [
            'email_address' => $data['email'],
            'status' => 'subscribed',
            'merge_fields' => $merge_vars,
        ]);

        var_dump($MailChimp->getLastResponse());

        if ($MailChimp->success()) {
            $response['status'] = 'success';
            $text_mailchimp_success = $this->language->get('text_mailchimp_success');
            $message = $text_mailchimp_success ? $text_mailchimp_success : $mailchimp['message'];
            $response['message'] = $message;
            $this->sendResponse($response);
            return true;
        } else {
            $response['status'] = 'error';
            $response['message'] = $MailChimp->getLastError();
            $this->sendResponse($response);
            return false;
        }

        exit();
    }

    public function testRequestTimeout()
    {
        //$this->markTestSkipped('CI server too fast to realistically test.');
        $MC_API_KEY = getenv('MC_API_KEY');
        if (!$MC_API_KEY) {
            //$this->markTestSkipped('No API key in ENV');
        }
        $MailChimp = new MailChimp($MC_API_KEY);
        $result = $MailChimp->get('lists');
        $list_id = $result['lists'][0]['id'];
        $args = array( 'count' => 1000 );
        $timeout = 1;
        $result = $MailChimp->get("lists/$list_id/members", $args, $timeout);

        $error = $MailChimp->getLastError();
    }
}
