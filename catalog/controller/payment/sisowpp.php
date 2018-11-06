<?php
include 'sisow.php';
class ControllerPaymentSisowpp extends ControllerPaymentSisow {
	public function index() {
		return $this->_index('sisowpp');
	}

	public function notify() {
		$this->_notify('sisowpp');
	}

	public function redirectbank() {
		$this->_redirectbank('sisowpp');
	}
}