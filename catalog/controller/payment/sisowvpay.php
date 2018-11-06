<?php
include 'sisow.php';
class ControllerPaymentSisowvpay extends ControllerPaymentSisow {
	public function index() {
		return $this->_index('sisowvpay');
	}

	public function notify() {
		$this->_notify('sisowvpay');
	}

	public function redirectbank() {
		$this->_redirectbank('sisowvpay');
	}
}