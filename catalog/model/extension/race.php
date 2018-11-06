<?php
class ModelExtensionRace extends Model {
    public function getRace() {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "race_dogs`");

        return $query->rows;

    }
}