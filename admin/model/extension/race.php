<?php
class ModelExtensionRace extends Model {
    public function getRace($data) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "race_dogs` rd";

        if (!empty($data['race_dogs'])) {
            $sql .= " WHERE rd.race LIKE '" . $this->db->escape($data['race_dogs']) . "%'";
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

    public function getRaces($data) {

        $row_id = null;

        foreach ($data as $race_id) {
            $row_id .= $race_id . ',';

        }

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "race_dogs` WHERE race_id IN (" . substr($row_id, 0, -1) . ")");

        return $query->rows;

    }
}