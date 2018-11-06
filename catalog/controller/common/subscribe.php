<?php
include($_SERVER['DOCUMENT_ROOT'].'/system/mailchimp/MailChimp.php');
use \DrewM\MailChimp\MailChimp; 
class ControllerCommonSubscribe extends Controller {

	public function index() {


$MailChimp = new MailChimp('958f826d51c44608e3b6f9ccb0f6be62-us15');




$result = $MailChimp->post("lists/bf24e956ac/members", [
                'email_address' => $_POST['email'],
                'status'        => 'subscribed',
            ]);



		
}		
}