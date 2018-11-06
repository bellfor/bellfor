<?php
class ModelPaymentSisoweps extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/sisoweps');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('sisoweps_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('sisoweps_total') > 0 && $this->config->get('sisoweps_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('sisoweps_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		if ($total) {
			if ($this->config->get('sisoweps_total') && $total < $this->config->get('sisoweps_total')) {
				$status = false;
			}
			if ($this->config->get('sisoweps_totalmax') && $total > $this->config->get('sisoweps_totalmax')) {
				$status = false;
			}
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'sisoweps',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('sisoweps_sort_order')
			);
		}

		return $method_data;
	}
}