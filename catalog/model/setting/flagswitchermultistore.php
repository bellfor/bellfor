<?php
# @Author: Oleg
# @Date:   Thursday, November 23rd 2017, 12:29:30 pm
# @Email:  oleg@webiprog.com
# @Project: bellfor.info
# @Filename: flagswitchermultistore.php
# @Last modified by:   Oleg
# @Last modified time: Thursday, November 23rd 2017, 12:37:13 pm
# @License: free
# @Copyright: webiprog.com





class ModelSettingFlagSwitcherMultistore extends Model
{
    public function flagSwitcherMultistore()
    {
        /*
          0 =>
          array (
            'store_id' => '0',
            'img_name' => 'de',
            'store_name' => 'Bellfor',
            'store_url' => 'http://localhost/bellfor.info_opc/',
            'store_ssl' => 'https://localhost/bellfor.info_opc/',
            'country_id' => '81',
            'country_name' => 'Deutschland',
            'iso_code_2' => 'DE',
          ),
          1 =>
          array (
            'store_id' => '1',
            'img_name' => 'au',
            'store_name' => 'Bellfor Austria',
            'store_url' => 'http://at.bellfor.info/',
            'store_ssl' => 'https://at.bellfor.info/',
            'country_id' => '13',
            'country_name' => 'Australia',
            'iso_code_2' => 'AU',
          ),
        */

        //$key = 'store.flag'.__METHOD__;
		$key = 'BellforStore.flagSwitcher';
		// error in header if not cache->get('store')
		//$store_data = $this->cache->get('store');
		$store_data = NULL;
		if(!$store_data) {
		//$key = 'store.flagSwitcher'.uniqid();
		$flagswitcher_data = null;
		$admin_cache_store = null;
		$this->cache->delete($key);
		}else {
        $flagswitcher_data = $this->cache->get($key);
		$admin_cache_store = true;
		}

        if (!$flagswitcher_data) {
            $q = $this->db->query("SELECT `value` FROM " . DB_PREFIX . "setting WHERE store_id = '0' AND `key` = 'config_name' LIMIT 1");

            $store_name_default = 'Store';
            if (!empty($q->row) && is_array($q->row)) {
                $store_name_default = $q->row['value'];
            }

            $sql = 'SELECT
			`s`.`store_id`,
			LOWER(`c`.`iso_code_2`) as img_name,
			COALESCE(`mag`.`name` , "'.$store_name_default.'" ) as store_name,
			COALESCE(`mag`.`url` , "'.HTTP_SERVER.'" ) as store_url,
			COALESCE(`mag`.`ssl` , "'.HTTPS_SERVER.'" ) as store_ssl,
			`c`.`country_id`,
			`c`.`name` as country_name,
			`c`.`iso_code_2`
			FROM `' . DB_PREFIX . 'setting` s
			LEFT JOIN `' . DB_PREFIX . 'country` c ON (s.value = c.country_id)
			LEFT JOIN `' . DB_PREFIX . 'store` mag ON (s.store_id = mag.store_id)
			WHERE `s`.`key` = "config_country_id"
			ORDER BY `s`.`store_id`
			';
//            var_dump($sql); die();
            $query = $this->db->query($sql);

            $flagswitcher_data = $query->rows;

            if($admin_cache_store) {
			$this->cache->set($key, $flagswitcher_data);
            }

        }

        return $flagswitcher_data;
    }
}
