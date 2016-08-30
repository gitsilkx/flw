<?php
include("configs/path.php");
include("getProducts.php");
$ip = $_SERVER['REMOTE_ADDR'];
$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip;
$details = unserialize(file_get_contents($geopluginURL));
//print_r($details);
/*
mysql_query("INSERT INTO ". TABLE_CITY ." (`id`, `name`, `tag`, `province`, `country`, `state`, `city1`, `city2`, `city3`, `city4`, `city5`, `status`) VALUES (NULL, '".$details['geoplugin_city']."', '".$details['geoplugin_city']."', '".$details['geoplugin_continentCode']."', '".$details['geoplugin_countryName']."', '".$details['geoplugin_region']."', NULL, NULL, NULL, NULL, NULL, 'Y');");
*/

$result = mysql_query("SELECT * FROM ". TABLE_CITY ." WHERE tag LIKE '%".$details['geoplugin_city']."%' AND status='Y' LIMIT 1");
$row= mysql_fetch_object($result);
echo $row->url;



?>