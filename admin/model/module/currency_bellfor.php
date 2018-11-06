<?php
class ModelModuleCurrencyBellfor extends Model {

	protected $log_instance;

	public function __construct($registry) {
		parent::__construct($registry);

		$this->log_instance = new Log('currency_bellfor.log');
	}

	public function update($force = false) {

		if ($this->config->get('module_currency_bellfor_status') == 0) {
			return false;
		}

		if ($this->config->get('module_currency_bellfor_autoupdate') == 1 || $force) {

			/*
			$comission = $this->config->get('module_currency_bellfor_comission') > 0 ? (float) $this->config->get('module_currency_bellfor_comission') / 100 : false;
			*/

            $comission_array = array();
			$module_info = unserialize($this->config->get('module_currency_bellfor_code'));
			//1,07
			if(is_array($module_info)) {

				foreach($module_info as $key=>$val) {
				$comission_array[$key] = (float)($val / 100);
				}

				/*
				if(isset($comission_array['CHF'])) {
				if((float)$comission_array['CHF']< '1.07') {
					$comission_array['CHF'] = '1.07';
				}
				}
				*/
			}


			$base_currency = $this->config->get('config_currency');

			$sql = "SELECT * FROM " . DB_PREFIX . "currency WHERE code != '" . $this->db->escape($this->config->get('config_currency')) . "'";

			if (!$force) {
				$sql .= " AND date_modified < '" .  $this->db->escape(date('Y-m-d H:i:s', strtotime('-1 day'))) . "'";
			}

			$query = $this->db->query($sql);

			$currency_codes = array();

			foreach ($query->rows as $result) {
				$currency_codes[] = $result['code'];
			}

			// fixer.io
			if ($this->config->get('module_currency_bellfor_source') == 'fixer.io') {

				$response = $this->curlRequest('https://api.fixer.io/latest?base='.$base_currency.'&symbols='.implode(',', $currency_codes));
				if ($response) {
					$json = json_decode($response);

					foreach ($currency_codes as $code) {
						$comission = false;
						if(!empty($comission_array[$code])) {
							$comission = $comission_array[$code];
						}
						$value = $comission ? (float) $json->rates->{$code} + ((float) $json->rates->{$code} * $comission) : $json->rates->{$code};
						$this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '" . $this->db->escape($value) . "', date_modified = '" .  $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($code) . "'");
					}

					$this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '1.00000', date_modified = '" .  $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($base_currency) . "'");
				} else {
					return false;
				}

			// alphavantage.co
			} elseif ($this->config->get('module_currency_bellfor_source') == 'alphavantage.co') {

				$api_key = $this->config->get('module_currency_bellfor_alphavantage_api_key');

				foreach ($currency_codes as $code) {
					$response = $this->curlRequest('https://www.alphavantage.co/query?function=CURRENCY_EXCHANGE_RATE&from_currency='.$base_currency.'&to_currency='.$code.'&apikey='.$api_key);

					if ($response) {
						$json = json_decode($response);

						if (@is_null($json->{"Error Message"})) {
							$value = (float) $json->{"Realtime Currency Exchange Rate"}->{"5. Exchange Rate"};
							$comission = false;
							if(!empty($comission_array[$code])) {
								$comission = $comission_array[$code];
							}
							$value = $comission ? $value + ($value * $comission) : $value;
							$this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '" . $this->db->escape($value) . "', date_modified = '" .  $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($code) . "'");
						} else {
							$this->log('alphavantage error : '.$json->{"Error Message"});
							return false;
						}
					} else {
						return false;
					}
				}

				$this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '1.00000', date_modified = '" .  $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($base_currency) . "'");
			} else {
				return false;
			}

			$this->cache->delete('currency');

			return true;
		}
	}

	private function curlRequest($url, $options = array()) {

		$this->log('Curl init : '.$url);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);
		$info = curl_getinfo($ch);

		if (curl_error($ch)) {
			$this->log('Curl error : '.curl_error($ch));
			return false;
		}

		if (in_array($info['http_code'], array(401,403,404))) {
			$this->log('Curl error : '.$info['http_code'].' header status');
			return false;
		}

		return $result;
	}

	private function log($str) {
		if ($this->config->get('module_currency_bellfor_debug') == 1) {
			$this->log_instance->write($str);
		}
	}
}