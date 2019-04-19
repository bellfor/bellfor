<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelReportActivity extends Model {
	public function getActivities() {
		$query = $this->db->query("SELECT a.key, a.data, a.date_added
FROM (
       (SELECT CONCAT('customer_', ca.key) AS `key`, ca.data, ca.date_added
        FROM `" . DB_PREFIX . "customer_activity` ca
        ORDER BY ca.date_added DESC
        LIMIT 0,5)
       UNION
       (SELECT CONCAT('affiliate_', aa.key) AS `key`, aa.data, aa.date_added
        FROM `" . DB_PREFIX . "affiliate_activity` aa
        ORDER BY aa.date_added DESC
        LIMIT 0,5)
     ) a
ORDER BY a.date_added DESC
LIMIT 0,5");

		return $query->rows;
	}
}