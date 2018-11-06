<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowvvv extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowvvv');
	}

	public function validate() {
		return $this->_validate('sisowvvv');
	}
}