<?php
ini_set('display_errors', 1);
set_time_limit(0);

$mapping = array (
0 => 4,
1 => 5, 
 2 => 1,
  3 => 6, 
   4 => 3,
	5 => 7,
	 6 => 2,
	  7 => 8,
	   8 => 9, 
		9 => 10, 
		 10 => 11
);

try {
  $db2 = new PDO('mysql:host=localhost;dbname=bellfor', 'bellfor', 'M5d5D8z3', array(
PDO::ATTR_PERSISTENT => true
));
  $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db2->query("SET CHARACTER SET utf8");
}
catch(PDOException $e) {
    echo $e->getMessage();
}


$cs_array = file('customers_ids.txt');
$customers = array();
 
 foreach ($cs_array as $cs_str)
 {

$cs_arr = explode("|", trim($cs_str));
$customers[$cs_arr[0]] = $cs_arr[1];
	
 } 

$stmt2 = $db2->query("SELECT * FROM customers");
$rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows2 as $row)
{
	
//$customer = $customers[$row['customers_id']];	
//$group = $mapping[$row['customers_status']];

//print $customer." ".$group."<br>";
	
	

$stmt_cg = $db2->query("UPDATE oc_customer SET customer_group_id=".$mapping[$row['customers_status']]." WHERE customer_id=".$customers[$row['customers_id']]);

	
}

$db2 = null;

?>