<?php
# @Author: Oleg
# @Date:   Friday, September 29th 2017, 11:27:55 am
# @Email:  oleg@webiprog.com
# @Project: Set opencart url_alias
# @Filename: seo-url-autofill.php
# @Last modified by:   Oleg
# @Last modified time: Friday, September 29th 2017, 4:40:59 pm
# @License: free
# @Copyright: webiprog.com

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
//error_reporting(E_ALL);
define('_PARSER_DIR', dirname(__FILE__));

define('DS', DIRECTORY_SEPARATOR);

include _PARSER_DIR . DS . 'admin' . DS . 'config.php';
// Startup
include DIR_SYSTEM . 'startup.php';

// Registry
$registry = new Registry();
// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);
// Config
$config = new Config();
$registry->set('config', $config);

//$config->set('config_language_id', 1);
// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

$languages = array();

$query = $db->query("SELECT language_id FROM " . DB_PREFIX . "language WHERE status = '1' AND language_id != 3");

foreach ($query->rows as $result) {
    $languages[$result['language_id']] = $result['language_id'];
}

/*
	`url_alias_id` INT(11) NOT NULL AUTO_INCREMENT,
	`query` VARCHAR(255) NOT NULL,
	`keyword` VARCHAR(255) NOT NULL,
	`seomanager` INT(1) NULL DEFAULT '0',
	`alias_language` INT(11) NOT NULL DEFAULT '0',
*/

//"2974"	"product_id=116"	"Hirsch-Lungenwuerfel-39.html"	"0"	"3"
$query = $db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE  `alias_language` = 3 order by url_alias_id");

$url_alias = $query->rows;

$rab = array();
foreach ($url_alias as $key => $value) {
    foreach ($languages as $l) {
        $url_alias_id = $value['url_alias_id'];
		$url_query = $value['query'];
		$keyword = $value['keyword'];

        $query = $db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE
		`query` = '" . $url_query . "' AND alias_language = '" . (int) $l . "'");
        $tut = (bool) $query->row;
        if ($tut === false) {

            $db->query("INSERT INTO " . DB_PREFIX . "url_alias SET
			query = '" . $db->escape($value['query']) . "',
			alias_language = '" . (int) $l . "',
			keyword = '" . $db->escape($value['keyword']) . "'");


            $rab[] = "Added : Query: " . $db->escape($value['query']) . " | Alias_language = " . (int) $l . " | Keyword = " . $db->escape($value['keyword']) . "";
        }else {
           //echo "<pre>!!!"; var_export($db->escape($value['query'])); echo "</pre>";
// exit;
        }
    }
}
echo 'Update: ' . count($rab) . PHP_EOL;
echo "<br />-------------------------------------<br />";
echo (implode(PHP_EOL.'<hr />', $rab));
//exit;

//echo "<pre>"; var_export($url_alias); echo "</pre>";
//exit;
