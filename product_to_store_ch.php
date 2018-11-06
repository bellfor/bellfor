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

//$config->set('config_product_id', 1);
// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

$del = false;
if ($del) {
    $db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE  `store_id` = '4' ");
    $db->query("OPTIMIZE TABLE " . DB_PREFIX . "product_to_store");
}
/* CREATE TABLE `oc_product_to_store` (
	`product_id` INT(11) NOT NULL,
    `store_id` INT(11) NOT NULL DEFAULT '0',

CREATE TABLE `oc_information_to_store` (
	`information_id` INT(11) NOT NULL,
	`store_id` INT(11) NOT NULL,

 */
$store_ids = array ();
$query = $db->query("SELECT `product_id`  FROM " . DB_PREFIX . "product_to_store WHERE `store_id` = '0' ");

foreach ($query->rows as $result) {
    $store_ids[$result['product_id']] = $result['product_id'];
}
$rab = array();
foreach ($store_ids as $key => $value) {

    $product_id = $key;

    $query = $db->query("SELECT * FROM " . DB_PREFIX . "product_to_store WHERE
		`product_id` = '" . $product_id . "' AND  `store_id` = '4' ");
    $tut = (bool)$query->row;
    if ($tut === false) {

        $db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET
			`product_id` = '" . (int)$key . "',
            `store_id` = '4'
            ");
        $rab[] = "Added : Query: " . $key;
    } else {
           //echo "<pre>!!!"; var_export($db->escape($value['query'])); echo "</pre>";
// exit;
    }

}

/*
CREATE TABLE `oc_product_to_layout` (
	`product_id` INT(11) NOT NULL,
	`store_id` INT(11) NOT NULL,
	`layout_id` INT(11) NOT NULL,
*/
$store_ids = array ();
$query = $db->query("SELECT *  FROM " . DB_PREFIX . "product_to_layout WHERE `store_id` = '0' ");

foreach ($query->rows as $result) {
    $store_ids[$result['product_id']] = $result;
}
$rab = array();
foreach ($store_ids as $value) {

    $product_id = $value['product_id'];
    $layout_id = $value['layout_id'];

    $query = $db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE
		`product_id` = '" . $product_id . "' AND `layout_id` = '" . $layout_id . "' AND  `store_id` = '4' ");
    $tut = (bool)$query->row;
    if ($tut === false) {

        $db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET
            `product_id` = '" . (int)$product_id . "',
            `layout_id` = '" . $layout_id . "',
            `store_id` = '4'
            ");
        $rab[] = "Added : Query: " . $product_id;
    } 

}

////////////////////////////////////////////////////////////////////////////////
/*
CREATE TABLE `oc_information_to_store` (
	`information_id` INT(11) NOT NULL,
	`store_id` INT(11) NOT NULL,
 */
$store_ids = array ();
$query = $db->query("SELECT `information_id`  FROM " . DB_PREFIX . "information_to_store WHERE `store_id` = '0' ");

foreach ($query->rows as $result) {
    $store_ids[$result['information_id']] = $result['information_id'];
}
$rab = array();
foreach ($store_ids as $key => $value) {

    $information_id = $key;

    $query = $db->query("SELECT * FROM " . DB_PREFIX . "information_to_store WHERE
		`information_id` = '" . $information_id . "' AND  `store_id` = '4' ");
    $tut = (bool)$query->row;
    if ($tut === false) {

        $db->query("INSERT INTO " . DB_PREFIX . "information_to_store SET
			`information_id` = '" . (int)$key . "',
            `store_id` = '4'
            ");
        $rab[] = "Added : Query: " . $key;
    }
}

/*
CREATE TABLE `oc_information_to_layout` (
	`information_id` INT(11) NOT NULL,
	`store_id` INT(11) NOT NULL,
	`layout_id` INT(11) NOT NULL,
	PRIMARY KEY (`information_id`, `store_id`)
*/
$store_ids = array ();
$query = $db->query("SELECT *  FROM " . DB_PREFIX . "information_to_layout WHERE `store_id` = '0' ");

foreach ($query->rows as $result) {
    $store_ids[$result['information_id']] = $result;
}
$rab = array();
foreach ($store_ids as $value) {

    $information_id = $value['information_id'];
    $layout_id = $value['layout_id'];

    $query = $db->query("SELECT * FROM " . DB_PREFIX . "information_to_layout WHERE
		`information_id` = '" . $information_id . "' AND `layout_id` = '" . $layout_id . "' AND  `store_id` = '4' ");
    $tut = (bool)$query->row;
    if ($tut === false) {

        $db->query("INSERT INTO " . DB_PREFIX . "information_to_layout SET
            `information_id` = '" . (int)$information_id . "',
            `layout_id` = '" . $layout_id . "',
            `store_id` = '4'
            ");
        $rab[] = "Added : Query: " . $information_id;
    } 

}


echo 'Update: ' . count($rab) . PHP_EOL;
echo "<br />-------------------------------------<br />";
//echo (implode(PHP_EOL . '<hr />', $rab));

