<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelDesignBanner extends Model
{
    public function getBanner($banner_id)
    {

		//fixed by oppo webiprog.com  05.03.2018 MAR-217
		// MAR-217 see \admin\controller\design\banner.php
		if (isset($this->request->get['store_id'])) {
            $store_id = $this->request->get['store_id'];
        } elseif ($this->config->get('config_store_id')) {
            $store_id = $this->config->get('config_store_id');
        } else {
            $store_id = 0;
        }

        // 4 = Bellfor CH	https://ch.bellfor.info/
        if ($store_id == 4) {
            $config_language_id = 8 ;
        } else {
            $config_language_id = (int)$this->config->get('config_language_id');
        }
		//end fixed by oppo webiprog.com  05.03.2018 MAR-217



        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "banner_image bi LEFT JOIN " . DB_PREFIX . "banner_image_description bid ON (bi.banner_image_id  = bid.banner_image_id) WHERE bi.banner_id = '" . (int)$banner_id . "' AND bid.language_id = '" . $config_language_id. "' ORDER BY bi.sort_order ASC");

        return $query->rows;
    }
}
