<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowbelfius extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowbelfius');
	}

	public function validate() {
		return $this->_validate('sisowbelfius');
	}
}