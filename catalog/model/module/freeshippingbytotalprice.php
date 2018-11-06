<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelModuleFreeShippingByTotalprice extends Model
{
    public function getFreeshippingCustomer($customer)
    {
        $price_free = array();

        
        $this->load->model('account/address');
        $shipping_address = $this->model_account_address->getAddress((int)$customer->getAddressId());
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE  country_id = '" . (int)$shipping_address['country_id'] . "' AND (zone_id = '" . (int)$shipping_address['zone_id'] . "' OR zone_id = '0')");


        /*
        array (
          'address_id' => '2583',
          'firstname' => 'max',
          'lastname' => 'msq',
          'company' => 'webiprog',
          'address_1' => 'berlin demo Street Address, 11',
          'address_2' => '11',
          'postcode' => '12345',
          'city' => 'demo Suburb',
          'zone_id' => '2338',
          'zone' => 'Utrecht',
          'zone_code' => 'UT',
          'country_id' => '150',
          'country' => 'Niederlande',
          'iso_code_2' => 'NL',
          'iso_code_3' => 'NLD',
          'address_format' => '',
          'custom_field' => NULL,
        )
        */


        if (isset($query) && $query->num_rows) {
            foreach ($query->rows as $result) {
                if ($this->config->get('weight_' . $result['geo_zone_id'] . '_status')) {
                    $free = false;
                    if (!empty($this->config->get('weight_' . $result['geo_zone_id'] . '_free')) && intval($this->config->get('weight_' . $result['geo_zone_id'] . '_free')) > 0
                        ) {
                        $price_free[$result['geo_zone_id']]=intval($this->config->get('weight_' . $result['geo_zone_id'] . '_free'));
                    }
                }
            }
        }

        return $price_free;
    }

    public function getFreeshippingGuest($customer=null)
    {
        $price_free = array();

        if (isset($this->session->data['country_id']) && $this->session->data['country_id'] != '') {
            $country_id = $this->session->data['country_id'];
        } else {
            $country_id = $this->session->data['country_id'] = $this->config->get('config_country_id');
        }

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");

        foreach ($query->rows as $result) {
            if ($this->config->get('weight_' . $result['geo_zone_id'] . '_status')) {
                if (!empty($this->config->get('weight_' . $result['geo_zone_id'] . '_free')) && intval($this->config->get('weight_' . $result['geo_zone_id'] .'_free')) > 0
                        ) {
                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$country_id . "'");

                    if ($query->num_rows) {
                        $price_free[$result['geo_zone_id']]=intval($this->config->get('weight_' . $result['geo_zone_id'] . '_free'));
                    }
                }
            }
        }
        return $price_free;
    }


    public function log($data)
    {
        if ($this->config->get('pp_login_debug')) {
            $backtrace = debug_backtrace();
            $this->log->write('Log In with PayPal debug (' . $backtrace[1]['class'] . '::' . $backtrace[1]['function'] . ') - ' . $data);
        }
    }
}
