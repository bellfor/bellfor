<?php
class ModelMarketingReorder extends Model {

	// Get complete orders count
	public function getTotalOrders() {
		if((int)$this->customer->getId()) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o WHERE customer_id = '" . (int)$this->customer->getId() . "' AND o.order_status_id IN (" . implode(',', $this->config->get('config_complete_status')) . ") AND o.store_id = '" . (int)$this->config->get('config_store_id') . "'");
			return $query->row['total'];
		} else {
			return 0;
		}
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
}
?>
