<?php
include 'sisow.php';
class ControllerPaymentSisowvvv extends ControllerPaymentSisow {
	public function index() {
		return $this->_index('sisowvvv');
	}

	public function notify() {
		$this->_notify('sisowvvv');
	}

	public function redirectbank() {
		$this->_redirectbank('sisowvvv');
	}
}