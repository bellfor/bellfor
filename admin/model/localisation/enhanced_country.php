<?php
class ModelLocalisationEnhancedCountry extends Model {
	public function addCountry($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "country SET name = '" . $this->db->escape($data['name']) . "', iso_code_2 = '" . $this->db->escape($data['iso_code_2']) . "', iso_code_3 = '" . $this->db->escape($data['iso_code_3']) . "', address_format = '" . $this->db->escape($data['address_format']) . "', postcode_required = '" . (int)$data['postcode_required'] . "', status = '" . (int)$data['status'] . "'");

		$this->cache->delete('country');
	}

	public function editCountry($country_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "country SET name = '" . $this->db->escape($data['name']) . "', iso_code_2 = '" . $this->db->escape($data['iso_code_2']) . "', iso_code_3 = '" . $this->db->escape($data['iso_code_3']) . "', address_format = '" . $this->db->escape($data['address_format']) . "', postcode_required = '" . (int)$data['postcode_required'] . "', status = '" . (int)$data['status'] . "' WHERE country_id = '" . (int)$country_id . "'");

		$this->cache->delete('country');
	}

	public function deleteCountry($country_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$country_id . "'");

		$this->cache->delete('country');
	}

//enable disable multiple
	public function enableCountries($country_id) {		
		if (isset($country_id)) {
			$this->db->query("UPDATE " . DB_PREFIX . "country SET status = '1' WHERE country_id = '" . (int)$country_id . "'");
		}
	}

	public function disableCountries($country_id) {
		if (isset($country_id)) {
			$this->db->query("UPDATE " . DB_PREFIX . "country SET status = '0' WHERE country_id = '" . (int)$country_id . "'");
		}
	}
//enable disable multiple

	public function updateStatus($country_id, $column_name, $value){
		$this->db->query("UPDATE " . DB_PREFIX . "country SET " . $column_name . " = '" . (int)$value . "' WHERE country_id = '" . (int)$country_id . "'");
	}

	public function getCountry($country_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "country WHERE country_id = '" . (int)$country_id . "'");

		return $query->row;
	}

	public function getCountries($data = array()) {
		if ($data) {
			if (isset($data['filter_geo_zone_id']) && !is_null($data['filter_geo_zone_id'])) {
				$sql = "SELECT DISTINCT z.country_id AS country_id, c.name AS name, c.iso_code_2 AS iso_code_2, c.iso_code_3 AS iso_code_3, c.status AS status, c.postcode_required AS postcode_required FROM " . DB_PREFIX . "zone_to_geo_zone z LEFT JOIN " . DB_PREFIX . "country c ON (c.country_id = z.country_id)";
				$sql .= " WHERE z.geo_zone_id = '" . (int)$data['filter_geo_zone_id'] . "'";
			} else {
				$sql = "SELECT * FROM " . DB_PREFIX . "country WHERE 1";
			}
			
			if (isset($data['filter_country']) && !is_null($data['filter_country'])) {
				$sql .= " AND name LIKE '" . $this->db->escape($data['filter_country']) . "%'";
			}

			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
			}

			$sort_data = array(
				'name',
				'iso_code_2',
				'iso_code_3',
				'status',
				'postcode_required'
			);

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
		} else {
			$country_data = $this->cache->get('country');

			if (!$country_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country ORDER BY name ASC");

				$country_data = $query->rows;

				$this->cache->set('country', $country_data);
			}

			return $country_data;
		}
	}

	public function getTotalCountries($data = array()) {
		if (isset($data['filter_geo_zone_id']) && !is_null($data['filter_geo_zone_id'])) {
	      	$sql = "SELECT COUNT(DISTINCT country_id) AS total FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$data['filter_geo_zone_id'] . "'";
			$query = $this->db->query($sql);
		} else {
	      	$sql = "SELECT COUNT(*) AS total, status, name FROM " . DB_PREFIX . "country WHERE 1";

			if (isset($data['filter_country']) && !is_null($data['filter_country'])) {
				$sql .= " AND name LIKE '" . $this->db->escape($data['filter_country']) . "%'";
			}
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
			}
			
			$query = $this->db->query($sql);
		}
		
		return $query->row['total'];
	}
}