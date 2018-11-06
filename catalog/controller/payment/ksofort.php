<?php
class ControllerPaymentKsofort extends Controller {
	public function index() {
		$data['text_loading'] = $this->language->get('text_loading');

		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['text_loading'] = $this->language->get('text_loading');

		$data['continue'] = $this->url->link('checkout/success');
		
		$this->load->model('checkout/order');
		
		if(isset($this->session->data['order_id']))
		{
			$order = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		}
		else
		{
			$order = "";
		}

		$data['action'] = $this->url->link('payment/ksofort/checkout', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/ksofort.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/ksofort.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/ksofort.tpl', $data);
		}
	}

	public function checkout() {

		$this->load->model('checkout/order');
		
		if(isset($this->session->data['order_id']))
		{
			$order = $this->model_checkout_order->getOrder($this->session->data['order_id']);
			
		}
		else 
		{
			$order = null;
		}

		if(!isset($order))
		{			
//			header('Location: ' . $this->url->link('checkout/checkout', '', 'SSL'));
			header('Location: ' . $this->url->link('checkout/onepagecheckout', '', 'SSL'));
		}
		else
		{
			require_once(DIR_SYSTEM .'/sofort/payment/sofortLibSofortueberweisung.inc.php');
			
			$configkey = $this->config->get('ksofort_configkey');
			$Sofortueberweisung = new Sofortueberweisung($configkey);

			$Sofortueberweisung->setAmount(round(($order['total'] * $this->currency->getValue($this->config->get('ksofort_currency'))),2));
			$Sofortueberweisung->setCurrencyCode($this->config->get('ksofort_currency'));

			$Sofortueberweisung->setReason($order['order_id']);
			$Sofortueberweisung->setSuccessUrl($this->url->link('checkout/success'), true);
			$Sofortueberweisung->setAbortUrl($this->url->link('payment/ksofort/abort'));
			$Sofortueberweisung->setNotificationUrl($this->url->link('payment/ksofort/confirm'));
		
			$Sofortueberweisung->setVersion('opencart_Karley_1.0');
		
			$Sofortueberweisung->sendRequest();

			if($Sofortueberweisung->isError()) {
				echo $Sofortueberweisung->getError();
			} else {
				$paymentUrl = $Sofortueberweisung->getPaymentUrl();

				header('Location: '.$paymentUrl);
			}
		}
	}
	
	public function abort() {
		$this->load->model('checkout/order');

		if(isset($this->session->data['order_id'])){
			$this->db->query("Update `" . DB_PREFIX . "order` set order_status_id = " . $this->config->get('ksofort_order_status_id_canceled') . " WHERE order_id = " . (int)$this->session->data['order_id']);		
		}
		
		$this->response->redirect($this->url->link('checkout/onepagecheckout', '', 'SSL'));
//		$this->response->redirect($this->url->link('checkout/checkout', '', 'SSL'));
	}
	
	public function confirm() {
		require_once(DIR_SYSTEM .'/sofort/core/sofortLibNotification.inc.php');
		require_once(DIR_SYSTEM .'/sofort/core/sofortLibTransactionData.inc.php');
		
		$configkey = $this->config->get('ksofort_configkey');


		$SofortLib_Notification = new SofortLibNotification();
		$TestNotification = $SofortLib_Notification->getNotification(file_get_contents('php://input'));

		 echo $SofortLib_Notification->getTransactionId();
		 echo '<br />';
		 echo $SofortLib_Notification->getTime();
		 echo '<br />';

		$SofortLibTransactionData = new SofortLibTransactionData($configkey);


		$SofortLibTransactionData->addTransaction($TestNotification);
		$SofortLibTransactionData->setApiVersion('2.0');

		$SofortLibTransactionData->sendRequest();

		$order_id = $SofortLibTransactionData->getReason();
		$sofort_status = $SofortLibTransactionData->getStatus();

		if($SofortLibTransactionData->isError()) {
			$text = $SofortLibTransactionData->getError();
			$email = $this->config->get('config_email');
			mail($email,'Sofort.com - Error',$text);
			
		} else {
			if(isset($order_id) && $sofort_status != "loss" && $sofort_status != "refounded")
			{
				$this->load->model('checkout/order');

				$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('ksofort_order_status_id'));
			}
		}		
	}
}