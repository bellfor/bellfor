<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowvpay extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowvpay');
	}

	public function validate() {
		return $this->_validate('sisowvpay');
	}
}
