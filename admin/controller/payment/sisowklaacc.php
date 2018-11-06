<?php
include 'sisow/sisow.php';
class ControllerPaymentSisowklaacc extends ControllerPaymentSisow {
	public function index() {
		$this->_index('sisowklaacc');
	}

	public function validate() {
		return $this->_validate('sisowklaacc');
	}
}