<?php
include 'sisow.php';
class ControllerPaymentSisowovb extends ControllerPaymentSisow {
	public function index() {
		return $this->_index('sisowovb');
	}

	public function notify() {
		$this->_notify('sisowovb');
	}

	public function redirectbank() {
		$this->_redirectbank('sisowovb');
	}
}