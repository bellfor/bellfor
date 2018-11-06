<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowafterpay extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowafterpay');
	}

	public function validate() {
		return $this->_validate('sisowafterpay');
	}
}