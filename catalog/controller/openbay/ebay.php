<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerOpenbayEbay extends Controller {
	public function eventAddOrder($order_id) {

	}

	public function eventAddOrderHistory($order_id) {
		if (!empty($order_id)) {
			$this->load->model('openbay/ebay_order');

			$this->model_openbay_ebay_order->addOrderHistory($order_id);
		}
	}
}