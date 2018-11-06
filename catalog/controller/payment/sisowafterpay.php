<?php
include 'sisow.php';
class ControllerPaymentSisowafterpay extends ControllerPaymentSisow {
	public function index() {
		return $this->_index('sisowafterpay');
	}

	public function notify() {
		$this->_notify('sisowafterpay');
	}

	public function redirectbank() {
		$this->_redirectbank('sisowafterpay');
	}
}