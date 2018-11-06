<?php
include 'sisow.php';
class ControllerPaymentSisowde extends ControllerPaymentSisow {
	public function index() {
		return $this->_index('sisowde');
	}

	public function notify() {
		$this->_notify('sisowde');
	}

	public function redirectbank() {
		$this->_redirectbank('sisowde');
	}
}