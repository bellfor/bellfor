<?php
ini_set('log_errors', 1);
ini_set('error_log', __DIR__.'/php-error.log');

include('../config.php');

if(DB_PORT != '') {
	$connector = DB_HOSTNAME.':'.DB_PORT;
} else {
	$connector = DB_HOSTNAME;
}

$connector = DB_HOSTNAME;

$link_source = mysqli_connect($connector, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die ("Error " . mysqli_error($link_source)); 
if(!$link_source) {
	die('Ошибка соединения: ' . mysqli_error());
}

echo '<p>Успешно соединились '.DB_DATABASE.'</p>';

// en
$sql = 'SELECT p.`model`, p.`product_id`, pd.`language_id`, pd.`description` FROM `oc_product` AS p LEFT JOIN `oc_product_description` AS pd ON pd.`product_id` = p.`product_id` WHERE pd.`language_id` = 4';
$enPack = fetchAll($link_source, $sql);
if(count($enPack)) {
	foreach($enPack as $descriptionLine) {
		$handle = fopen('en_' . $descriptionLine['model'] . '.txt', 'w');
		fwrite($handle, $descriptionLine['description'] . "\n");
		fclose($handle);
	}
}

// nl
$sql = 'SELECT p.`model`, p.`product_id`, pd.`language_id`, pd.`description` FROM `oc_product` AS p LEFT JOIN `oc_product_description` AS pd ON pd.`product_id` = p.`product_id` WHERE pd.`language_id` = 5';
$nlPack = fetchAll($link_source, $sql);
if(count($nlPack)) {
	foreach($nlPack as $descriptionLine) {
		$handle = fopen('nl_' . $descriptionLine['model'] . '.txt', 'w');
		fwrite($handle, $descriptionLine['description'] . "\n");
		fclose($handle);
	}
}

function fetchAll($link_source, $sql) {
	$result = mysqli_query($link_source, $sql);
/*	$sth = $link_source->prepare($sql);
	$sth->execute();
	$result = array();
	while($row = $sth->fetch_assoc()) {
		$result[] = $row;
	}
	return $result;*/
	$return = array();
	while($row = mysqli_fetch_assoc($result)) {
		$return[] = $row;
    }

    /* free result set */
    mysqli_free_result($result);

	return $return;
}

?>
