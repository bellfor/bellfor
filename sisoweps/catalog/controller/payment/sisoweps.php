<?php
include 'sisow.php';
class ControllerPaymentSisoweps extends ControllerPaymentSisow {
	public function index() {
		return $this->_index('sisoweps');
	}

	public function notify() {
		$this->_notify('sisoweps');
	}

	public function redirectbank() {
		$this->_redirectbank('sisoweps');
	}
}