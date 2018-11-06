<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowpp extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowpp');
	}

	public function validate() {
		return $this->_validate('sisowpp');
	}
}