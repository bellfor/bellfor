<?php

class ModelModuleCustomShortcodes extends Model {

    const SHORTOCODE_REGEXP = "/(?P<shortcode>(?:(?:\\s?\\[))(?P<name>[\\w\\-]{3,})(?:\\s(?P<attrs>[\\w\\d,\\s=\\\"\\'\\-\\+\\#\\%\\!\\~\\`\\&\\.\\s\\:\\/\\?\\|]+))?(?:\\])(?:(?P<content>[\\w\\d\\,\\!\\@\\#\\$\\%\\^\\&\\*\\(\\\\)\\s\\=\\\"\\'\\-\\+\\&\\.\\s\\:\\/\\?\\|\\<\\>]+)(?:\\[\\/[\\w\\-\\_]+\\]))?)/u";
    const ATTRIBUTE_REGEXP = "/(?<name>\S+)=[\"']?(?P<value>(?:.(?![\"']?\\s+(?:\\S+)=|[>\"']))+.)[\"']?/u";
//    const ATTRIBUTE_REGEXP = "/(?<name>\\S+)=[\"']?(?P<value>(?:.(?![\"']?\\s+(?:\\S+)=|[>\"']))+.)[\"']?/u";
        
    public function getShortcodes() {
        $shortcodes_data = $this->cache->get('shortcodes');

        if(!$shortcodes_data) {                
            $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "custom_shortcodes`");
            $shortcodes_data = $query->rows;
            $this->cache->set('shortcodes', $shortcodes_data);
        }

        return $shortcodes_data;            
    }
    
    public function getShortcode($name) {
        
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "custom_shortcodes` where `name` = '".$name."'" );

        return $query->row;            
    }

    public function parse_shortcodes($text) {
        preg_match_all(self::SHORTOCODE_REGEXP, $text, $matches, PREG_SET_ORDER);
        $shortcodes = array();
        foreach ($matches as $i => $value) {
            $shortcodes[$i]['shortcode'] = $value['shortcode'];
            $shortcodes[$i]['name'] = $value['name'];
            if (isset($value['attrs'])) {
                $attrs = $this->parse_attrs($value['attrs']);
                $shortcodes[$i]['attrs'] = $attrs;
            }
            if (isset($value['content'])) {
                $shortcodes[$i]['content'] = $value['content'];
            }
        }

        return $shortcodes;
    }

    public function parse_attrs($attrs) {
        preg_match(self::ATTRIBUTE_REGEXP, $attrs, $matches, PREG_OFFSET_CAPTURE, 0);
//        preg_match_all(self::ATTRIBUTE_REGEXP, $attrs, $matches, PREG_SET_ORDER);
        $attributes = array();
		$attributes[$matches['name'][0]] = trim($matches['value'][0], "'");
/*        foreach ($matches as $i => $value) {
            $key = $value['name'];
            $attributes[$i][$key] = trim($value['value'], "'");
        }*/
        return $attributes;
    }
}
