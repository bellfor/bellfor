<?php

# @Date:   Thursday, November 9th 2017, 3:20:26 pm
# @Email:  oleg@webiprog.com
# @Project: tooltiplabels
# @Filename: tooltiplabels.php
# @Last modified by:   Oleg
# @Last modified time: Thursday, November 9th 2017, 4:47:35 pm
# @License: free
# @Copyright: webiprog.com



class ModelCatalogTooltiplabels extends Model
{
    public function addTooltiplabel($data)
    {
        $this->event->trigger('pre.admin.tooltiplabel.add', $data);

        $this->db->query("INSERT INTO " . DB_PREFIX . "tooltiplabel SET status = '" . (int)$data['status'] . "'");

        $tooltiplabel_id = $this->db->getLastId();

        foreach ($data['tooltiplabel_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "tooltiplabel_description SET
				tooltiplabel_id = '" . (int)$tooltiplabel_id . "',
				language_id = '" . (int)$language_id . "',
				name = '" . $this->db->escape($value['name']) . "',
				description_top = '" . $this->db->escape($value['description_top']) . "'
				");
        }

        $this->cache->delete('tooltiplabel');

        $this->event->trigger('post.admin.tooltiplabel.add', $tooltiplabel_id);

        return $tooltiplabel_id;
    }

    public function editTooltiplabel($tooltiplabel_id, $data)
    {
        $this->event->trigger('pre.admin.tooltiplabel.edit', $data);

        $this->db->query("UPDATE " . DB_PREFIX . "tooltiplabel SET
			status = '" . (int)$data['status'] . "'
			WHERE tooltiplabel_id = '" . (int)$tooltiplabel_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "tooltiplabel_description WHERE tooltiplabel_id = '" . (int)$tooltiplabel_id . "'");

        foreach ($data['tooltiplabel_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "tooltiplabel_description SET
				tooltiplabel_id = '" . (int)$tooltiplabel_id . "',
				language_id = '" . (int)$language_id . "',
				name = '" . $this->db->escape($value['name']) . "',
				description_top = '" . $this->db->escape($value['description_top']) . "'
				ON DUPLICATE KEY UPDATE name = ' " . $this->db->escape($value['name']) . "-".$language_id."'
				");
        }

				/*
				name_short = '" . $this->db->escape($value['name_short']) . "',
				description_bottom = '" . $this->db->escape($value['description_bottom']) . "',
				h1 = '" . $this->db->escape($value['h1']) . "',
				meta_title = '" . $this->db->escape($value['meta_title']) . "',
				meta_description = '" . $this->db->escape($value['meta_description']) . "',
				meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'
				*/

        $this->cache->delete('tooltiplabel');

        $this->event->trigger('post.admin.tooltiplabel.edit', $tooltiplabel_id);
    }

    public function deleteTooltiplabels($tooltiplabel_id)
    {
        $this->event->trigger('pre.admin.tooltiplabel.delete', $tooltiplabel_id);

        $this->db->query("DELETE FROM " . DB_PREFIX . "tooltiplabel WHERE tooltiplabel_id = '" . (int)$tooltiplabel_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "tooltiplabel_description WHERE tooltiplabel_id = '" . (int)$tooltiplabel_id . "'");

        $this->cache->delete('tooltiplabel');

        $this->event->trigger('post.admin.tooltiplabel.delete', $tooltiplabel_id);
    }

    public function getTooltiplabel($tooltiplabel_id)
    {
        $query = $this->db->query("SELECT DISTINCT *,
			 						null AS keyword,
			 						null AS category_id
			 	FROM " . DB_PREFIX . "tooltiplabel t
			 	LEFT JOIN " . DB_PREFIX . "tooltiplabel_description td ON (t.tooltiplabel_id = td.tooltiplabel_id)
			 	WHERE t.tooltiplabel_id = '" . (int)$tooltiplabel_id . "' AND
			 		td.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getTotalTooltiplabels()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tooltiplabel");

        return $query->row['total'];
    }

    public function getTooltiplabels($data = array())
    {
        $sql = "SELECT *, null as count
				FROM " . DB_PREFIX . "tooltiplabel t
				LEFT JOIN " . DB_PREFIX . "tooltiplabel_description td ON (t.tooltiplabel_id = td.tooltiplabel_id)
				WHERE td.language_id = '" . (int)$this->config->get('config_language_id')."'";

        if (!empty($data['filter_name'])) {
            $sql .= " AND td.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        $sql .= " GROUP BY t.tooltiplabel_id";

        $sort_data = array(
            'td.name'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY t.tooltiplabel_id";
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

    public function getTooltiplabelDescriptions($tooltiplabel_id)
    {
        $tooltiplabel_description_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tooltiplabel_description WHERE tooltiplabel_id = '" . (int)$tooltiplabel_id . "'");

        foreach ($query->rows as $result) {
            $tooltiplabel_description_data[$result['language_id']] = array(
                'name'             => $result['name'],
                'name_short'             => $result['name_short'],
                'meta_title'       => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword'     => $result['meta_keyword'],
                'description_top'      => $result['description_top'],
                'description_bottom'      => $result['description_bottom'],
                'h1'                => $result['h1']
            );
        }

        return $tooltiplabel_description_data;
    }

    public function getTooltiplabelStores($tooltiplabel_id)
    {
        $tooltiplabel_store_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tooltiplabel_to_store WHERE tooltiplabel_id = '" . (int)$tooltiplabel_id . "'");

        foreach ($query->rows as $result) {
            $tooltiplabel_store_data[] = $result['store_id'];
        }

        return $tooltiplabel_store_data;
    }


    public function setSettings($data)
    {
        $query = $this->db->query("UPDATE " . DB_PREFIX . "setting set value = '".$data['setting_etopd']."' where `key` = 'newtooltiplabels_etopd'");
        $query = $this->db->query("UPDATE " . DB_PREFIX . "setting set value = '".$data['setting_ebottomd']."' where `key` = 'newtooltiplabels_ebottomd'");
        $query = $this->db->query("UPDATE " . DB_PREFIX . "setting set value = '".$data['setting_only']."' where `key` = 'newtooltiplabels_only'");
        $query = $this->db->query("UPDATE " . DB_PREFIX . "setting set value = '".$data['setting_ajax']."' where `key` = 'newtooltiplabels_ajax'");
        $query = $this->db->query("UPDATE " . DB_PREFIX . "setting set value = '".$data['setting_scategory']."' where `key` = 'newtooltiplabels_category'");
        $query = $this->db->query("UPDATE " . DB_PREFIX . "setting set value = '".$data['setting_count']."' where `key` = 'newtooltiplabels_count'");
        $query = $this->db->query("UPDATE " . DB_PREFIX . "setting set value = '".$data['setting_related']."' where `key` = 'newtooltiplabels_related'");
    }
}
