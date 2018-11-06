<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowgiropay extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowgiropay');
	}

	public function validate() {
		return $this->_validate('sisowgiropay');
	}
}