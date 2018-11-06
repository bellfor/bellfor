<?php
# @Author: Oleg
# @Date:   Thursday, November 16th 2017, 4:55:36 pm
# @Email:  oleg@webiprog.com
# @Project: bellfor.info
# @Filename: tooltiplabels.php
# @Last modified by:   Oleg
# @Last modified time: Thursday, November 16th 2017, 6:35:57 pm
# @License: free
# @Copyright: webiprog.com





class ModelCatalogTooltiplabels extends Model
{
    public function getTooltiplabels()
    {
        $tooltiplabel_data = $this->cache->get('tooltiplabel.' . (int)$this->config->get('config_language_id'));

        if (!$tooltiplabel_data) {
            $tooltiplabel_data = array();
            //ORDER BY LCASE(td.name)

            $sql = "SELECT td.name ,td.description_top
			FROM " . DB_PREFIX . "tooltiplabel t
			LEFT JOIN " . DB_PREFIX . "tooltiplabel_description td ON (t.tooltiplabel_id = td.tooltiplabel_id)
			WHERE td.language_id = '" . (int)$this->config->get('config_language_id') . "' AND
			td.name <> ''  AND
			t.status = '1' ";
            $query = $this->db->query($sql);
            $tooltiplabel_data =  $query->rows;

            $this->cache->set('tooltiplabel.' . (int)$this->config->get('config_language_id'), $tooltiplabel_data);
        }

        return $tooltiplabel_data;
    }

    public function replaceTooltiplabels($description)
    {
        if (empty($description)) {
            return ;
        }
        $tooltip_labels = $this->getTooltiplabels();
        /*
        foreach ($tooltip_labels as $prerow) {
            $description = str_replace($prerow['name'], '<tooltip>'.$prerow['name'].'</tooltip>', $description);
        }
        */
        if (!is_array($tooltip_labels)) {
            $tooltip_labels = array();
        }

		$tooltip_find = array();
        foreach ($tooltip_labels as $prerow) {
            if (empty($prerow['name']) || strpos($description, $prerow['name']) === false) {
                continue;
            }



            //$prerow['description_top'] =  htmlentities($prerow['description_top'],ENT_COMPAT,'UTF-8');
            //$prerow['description_top'] = filter_var($prerow['description_top'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

            if ($prerow['description_top']) {
                $prerow['description_top'] = strip_tags($prerow['description_top']);
                $prerow['description_top'] =   htmlspecialchars($prerow['description_top'], ENT_COMPAT, 'UTF-8');
            }

			$tooltip_find[] = array('name'=>$prerow['name'],'description'=>$prerow['description_top']);

			$description = str_replace($prerow['name'], '<tooltip>'.$prerow['name'].'</tooltip>', $description);

        }

		// проблемы с обрезанием тэгов
		if(count($tooltip_find)) {
			foreach($tooltip_find as $key=>$val) {
				$description = str_replace('<tooltip>'.$val['name'].'</tooltip>', '<span class="tooltip-class" data-toggle="tooltip" data-placement="bottom" title="'.$val['description'].'">'.$val['name'].'</span>', $description);
			}

		}


        return $description;
    }

    private function cleanInput($string)
    {
        $pattern[0] = '/\&/';
        $pattern[1] = '/</';
        $pattern[2] = "/>/";
        $pattern[3] = '/\n/';
        $pattern[4] = '/"/';
        $pattern[5] = "/'/";
        $pattern[6] = "/%/";
        $pattern[7] = '/\(/';
        $pattern[8] = '/\)/';
        $pattern[9] = '/\+/';
        $pattern[10] = '/-/';
        $replacement[0] = '&amp;';
        $replacement[1] = '&lt;';
        $replacement[2] = '&gt;';
        $replacement[3] = '<br>';
        $replacement[4] = '&quot;';
        $replacement[5] = '&#39;';
        $replacement[6] = '&#37;';
        $replacement[7] = '&#40;';
        $replacement[8] = '&#41;';
        $replacement[9] = '&#43;';
        $replacement[10] = '&#45;';
        return preg_replace($pattern, $replacement, $string);
    }


    /**
     * Strip only certain tags in the given HTML string
     * @return String
     */
    private function removeTags($html, $tags)
    {
        $existing_tags = $this->getAllTagNames($html);
        $allowable_tags = '<'.implode('><', array_diff($existing_tags, $tags)).'>';
        return strip_tags($html, $allowable_tags);
    }

    /**
     * Get a list of tag names in the provided HTML string
     * @return Array
     */
    private function getAllTagNames($html)
    {
        $tags = array();
        $part = explode("<", $html);
        foreach ($part as $tag) {
            $chunk = explode(" ", $tag);
            if (empty($chunk[0]) || $chunk[0][0] == "/") {
                continue;
            }
            $tag = trim($chunk[0], " >");
            if (!in_array($tag, $tags)) {
                $tags[] = $tag;
            }
        }
        return $tags;
    }
}
