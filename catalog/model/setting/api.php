<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelSettingApi extends Model {
	public function login($username, $password) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "api WHERE username = '" . $this->db->escape($username) . "' AND password = '" . $this->db->escape($password) . "'");

		return $query->row;
	}
}