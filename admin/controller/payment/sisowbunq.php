<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowbunq extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowbunq');
	}

	public function validate() {
		return $this->_validate('sisowbunq');
	}
}