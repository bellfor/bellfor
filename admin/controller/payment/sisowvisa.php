<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowvisa extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowvisa');
	}

	public function validate() {
		return $this->_validate('sisowvisa');
	}
}