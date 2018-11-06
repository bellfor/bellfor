<?php
include 'sisow.php';
class ControllerPaymentSisowwg extends ControllerPaymentSisow {
	public function index() {
		return $this->_index('sisowwg');
	}

	public function notify() {
		$this->_notify('sisowwg');
	}

	public function redirectbank() {
		$this->_redirectbank('sisowwg');
	}
}