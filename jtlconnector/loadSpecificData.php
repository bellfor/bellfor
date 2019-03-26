<?php
require_once(getcwd() . "/../admin/config.php");

defined('CONNECTOR_DIR') || define('CONNECTOR_DIR', __DIR__);
defined('LOG_DIR') || define('LOG_DIR', DIR_LOGS . 'jtlconnector/');

$application = null;

require_once(__DIR__ . "/vendor/autoload.php");

use jtl\Connector\Application\Application;
use jtl\Connector\OpenCart\Connector;

$connector = Connector::getInstance();
$application = Application::getInstance();

if($_GET['pass'] == 'm4rs4p3t')
{
	$co = new \jtl\Connector\OpenCart\Controller\Product\Product();

	$data = $co->pullSpecificData([], null);
	echo json_encode($data);
}







