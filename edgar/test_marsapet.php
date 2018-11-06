<?php
/*
error_reporting(-1);
ini_set("display_errors", 1);
$lines = file("customers.rpt");

$mysqli = new mysqli("localhost", "bellfor","M5d5D8z3", "bellfor", 3306);

$sql = "SELECT hostId from jtl_connector_link WHERE type = 2";
$statement = $mysqli->prepare($sql);
$statement->execute();

$statement->bind_result($col1);


$counter=0;
$arrayToDelete = array();
while ($statement->fetch()) {
    //printf("%s\n", $col1);
    if(!in_array($col1, $lines))
    {
        echo "NICHT GEFUNDEN " . $col1 . "<br>";
        $arrayToDelete[] = $col1;
        $counter++;
    }
}

echo "COUNTER: $counter";

foreach($arrayToDelete as $element)
{
    $sql2 = "DELETE from jtl_connector_link WHERE type = 2 AND hostId = " . $element;
    $statement2 = $mysqli->prepare($sql2);
    $statement2->execute();
}

$statement->close();


