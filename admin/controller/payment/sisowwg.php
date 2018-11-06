<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowwg extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowwg');
	}

	public function validate() {
		return $this->_validate('sisowwg');
	}
}