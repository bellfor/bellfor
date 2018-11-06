<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelCheckoutMarketing extends Model {
	public function getMarketingByCode($code) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "marketing WHERE code = '" . $this->db->escape($code) . "'");

		return $query->row;
	}
}