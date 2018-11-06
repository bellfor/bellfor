<?php
include 'sisow.php';
class ControllerPaymentSisowmaestro extends ControllerPaymentSisow {
	public function index() {
		return $this->_index('sisowmaestro');
	}

	public function notify() {
		$this->_notify('sisowmaestro');
	}

	public function redirectbank() {
		$this->_redirectbank('sisowmaestro');
	}
}