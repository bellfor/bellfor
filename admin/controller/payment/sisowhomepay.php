<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowhomepay extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowhomepay');
	}

	public function validate() {
		return $this->_validate('sisowhomepay');
	}
}