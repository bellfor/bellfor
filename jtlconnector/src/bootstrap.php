<?php

require_once(__DIR__ . "/../vendor/autoload.php");

use jtl\Connector\Application\Application;
use jtl\Connector\OpenCart\Connector;

$connector = Connector::getInstance();
$application = Application::getInstance();

if(isset($_GET['testOrder']))
{
	$order_id = $_GET['testOrder'];

	$co = new \jtl\Connector\OpenCart\Controller\Order\CustomerOrderItem();
	echo "<pre>";
	$data = $co->pullData(array('order_id' => $order_id, 'currency_value' => 1), null);
	var_export($data);

	foreach($data as $date)
	{
		echo $date->getName() . " \t". $date->getQuantity() ."\t". $date->getPrice() ."\t". $date->getVat()."\n";
	}
}
else
{
	$application->register($connector);
	$application->run();
}


