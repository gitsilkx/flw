<?php
if(substr_count($_SERVER['HTTP_HOST'],"localhost")):
    $dbh=mysql_connect("localhost","root","") or die ('I cannot connect to the database because 1: ' . mysql_error());
    $db=mysql_select_db("myfooding",$dbh) or die ('I cannot connect to the database because 2: ' . mysql_error());
	$vpath="http://localhost/myfooding/";
elseif(substr_count($_SERVER['HTTP_HOST'],"serverl")):
    $dbh=mysql_connect("localhost","admin","admin") or die ('I cannot connect to the database because 1: ' . mysql_error());
    $db=mysql_select_db("myfooding",$dbh) or die ('I cannot connect to the database because 2: ' . mysql_error());
	$vpath="http://serverl/m/myfooding/";
else:
	$dbh=@mysql_connect ("localhost", "oneoutso_source", "eH1BIlbB7dgz") or die ('I cannot connect to the database because: ' . mysql_error());
    $db=@mysql_select_db ("oneoutso_outsource"); 
	$vpath="http://www.oneoutsource.com/";
	$apath=$_SERVER['DOCUMENT_ROOT']."/";
endif;
$prev="mf_";
$dotcom="myfooding.com"; 
?>