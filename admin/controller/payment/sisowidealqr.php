<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowidealqr extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowidealqr');
	}

	public function validate() {
		return $this->_validate('sisowidealqr');
	}
}