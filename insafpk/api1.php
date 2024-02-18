<?php 
$fData = file_get_contents("Data/constituancyData.json");
header('Content-Type: application/json; charset=utf-8');
echo $fData;
?>