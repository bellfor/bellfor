<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowmaestro extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowmaestro');
	}

	public function validate() {
		return $this->_validate('sisowmaestro');
	}
}