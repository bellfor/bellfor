<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowde extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowde');
	}

	public function validate() {
		return $this->_validate('sisowde');
	}
}