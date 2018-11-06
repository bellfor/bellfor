<?php
class ModelLocalisationEnhancedZone extends Model {
	public function addZone($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "zone SET status = '" . (int)$data['status'] . "', name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', country_id = '" . (int)$data['country_id'] . "'");

		$this->cache->delete('zone');
	}

	public function editZone($zone_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "zone SET status = '" . (int)$data['status'] . "', name = '" . $this->db->escape($data['name']) . "', code = '" . $this->db->escape($data['code']) . "', country_id = '" . (int)$data['country_id'] . "' WHERE zone_id = '" . (int)$zone_id . "'");

		$this->cache->delete('zone');
	}

	public function deleteZone($zone_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "zone WHERE zone_id = '" . (int)$zone_id . "'");

		$this->cache->delete('zone');
	}

//enable disable multiple
	public function enableZones($zone_id) {		
		if (isset($zone_id)) {
			$this->db->query("UPDATE " . DB_PREFIX . "zone SET status = '1' WHERE zone_id = '" . (int)$zone_id . "'");
		}
	}

	public function disableZones($zone_id) {
		if (isset($zone_id)) {
			$this->db->query("UPDATE " . DB_PREFIX . "zone SET status = '0' WHERE zone_id = '" . (int)$zone_id . "'");
		}
	}
//enable disable multiple

	public function updateStatus($zone_id, $column_name, $value){
		$this->db->query("UPDATE " . DB_PREFIX . "zone SET " . $column_name . " = '" . (int)$value . "' WHERE zone_id = '" . (int)$zone_id . "'");
	}

	public function getZone($zone_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "zone WHERE zone_id = '" . (int)$zone_id . "'");

		return $query->row;
	}

	public function getZones($data = array()) {
		$sql = "SELECT *, z.name, z.status AS status, c.country_id, c.name AS country FROM " . DB_PREFIX . "zone z LEFT JOIN " . DB_PREFIX . "country c ON (z.country_id = c.country_id) WHERE 1";
		
		if (isset($data['filter_country']) && !is_null($data['filter_country'])) {
			$sql .= " AND c.name LIKE '" . $this->db->escape($data['filter_country']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND z.status = '" . (int)$data['filter_status'] . "'";
		}

		$sort_data = array(
			'c.name',
			'z.status',
			'z.name',
			'z.code',
			'z.zone_id',
			'c.country_id'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY c.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getZonesByCountryId($country_id) {
		$zone_data = $this->cache->get('zone.' . (int)$country_id);

		if (!$zone_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone WHERE country_id = '" . (int)$country_id . "' AND status = '1' ORDER BY name");

			$zone_data = $query->rows;

			$this->cache->set('zone.' . (int)$country_id, $zone_data);
		}

		return $zone_data;
	}

	public function getTotalZones($data = array()) {
		$sql = "SELECT COUNT(*) AS total, z.status, c.name FROM " . DB_PREFIX . "zone z";
		$sql .= " LEFT JOIN " . DB_PREFIX . "country c ON (z.country_id = c.country_id)";
		

		$sql .= " WHERE 1";
		
		if (isset($data['filter_country']) && !is_null($data['filter_country'])) {
			$sql .= " AND c.name LIKE '" . $this->db->escape($data['filter_country']) . "%'";
		}
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND z.status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalZonesByCountryId($country_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "zone WHERE country_id = '" . (int)$country_id . "'");

		return $query->row['total'];
	}

	public function getCountries($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "country";
		$sql .= " WHERE 1=1";		
		if (isset($data['filter_country']) && !is_null($data['filter_country'])) {
			$sql .= " AND name LIKE '" . $this->db->escape($data['filter_country']) . "%'";
		}

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);
		return $query->rows;
	}
}