<?php
class ModelMarketingReorder extends Model {

	public function deleteDiscountRule($rule_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "discount_rules` WHERE `rule_id` = '" . (int)$rule_id . "'");
//		$this->cache->delete('seo_pro');
//		$this->cache->delete('seo_url');
	}

	public function updateDiscountRule($data) {
		if((int)$data['orders_count'] == 0) {
			return false;
		}
		if($data['rule_id'] != 0) {
			$this->db->query("UPDATE `" . DB_PREFIX . "discount_rules` SET `orders_count` = '" . $this->db->escape($data['orders_count']) . "', `discount_size` = '" . $data['discount_size'] . "' WHERE `rule_id` = '" . (int)$data['rule_id'] . "'");
		} else {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "discount_rules` SET 
				`orders_count` = '" .  $this->db->escape($data['orders_count']) . "', 
				`discount_size` = '" . $this->db->escape($data['discount_size']) . "'");
		}
//		$this->cache->delete('seo_pro');
//		$this->cache->delete('seo_url');
		return true;
	}
	
	// Get List discount rules
	public function getDiscountRules($data = array()) {
		if($data) {
			$sql = "SELECT * FROM `" . DB_PREFIX . "discount_rules` AS dr WHERE 1";

			$sort_data = array('dr.orders_count', 'dr.discount_size');

			if(isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY dr.orders_count";
			}

			if(isset($data['order']) && ($data['order'] == 'ASC')) {
				$sql .= " ASC";
			} else {
				$sql .= " DESC";
			}

			if(isset($data['start']) || isset($data['limit'])) {
				if($data['start'] < 0) {
					$data['start'] = 0;
				}

				if($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "discount_rules` AS dr WHERE 1 ORDER BY dr.orders_count");
			return $query->rows;
		}
	}

	// Total discount rules
	public function getTotalDiscountRules() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "discount_rules` WHERE 1;");
		return $query->row['total'];
	}
}
?>
