<?PHP
ob_start();
error_reporting(E_ALL & ~E_NOTICE);
//header("X-Powered-By: Silkrouters.com");

@session_start();

$prev = "flowerwyz_";


if (substr_count($_SERVER['HTTP_HOST'], "localhost")) {

    $vpath = "http://localhost/flowerwyz/";
    $apath = $_SERVER['DOCUMENT_ROOT'] . "/flowerwyz/";
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $calendar_new_path = "/calendar_new/";
    $captcha_path = "/captcha/";
    $fckapath = $apath . "fckeditor/";
    $fckbasepath = $vpath . "fckeditor/";
    define("USERNAME", 'root');
    define("PASSWORD", '');
    define("DBNAME", 'flower');
    define("HOST", 'localhost');
} else {

    $vpath = "https://" . $_SERVER['HTTP_HOST'] . "/Flower/";
    $apath = $_SERVER['DOCUMENT_ROOT'] . "/Flower/";
	$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $fckapath = $_SERVER['DOCUMENT_ROOT'] . "/Flower/fckeditor/";
    $fckbasepath = $vpath . "fckeditor/Flower/";
  
    
    define("USERNAME", 'onlyvzxy_flwyzer');
    define("PASSWORD", 'flwyzer123');
    define("DBNAME", 'onlyvzxy_flwyzer');
    define("HOST", 'localhost');
}



$dbh = @mysql_connect(HOST, USERNAME, PASSWORD) or die('I cannot connect to the database because: ' . mysql_error());
$db = @mysql_select_db(DBNAME, $dbh) or die('I cannot connect to the database because: ' . mysql_error());



// Site Name ( not Site Title )

$dotcom = "flowerwyz.com";

$dark2 = "#344743";

$dark = "#38b3dc";

$light = "#e9f3fb";

$lightgray = "#c0c0c0";

$graywhite = "#D6C6C5";

$graywhite2 = "#e9e9e9";

/* * *****

  Tables

 * ****** */

define("TABLE_PRODUCT", 'products');
define("TABLE_IMAGE", 'images');
define("TABLE_LOG", 'log');
define("TABLE_ADD_PRODUCT", 'add_products');
define("TABLE_DELETE_PRODUCT", 'delete_products');
define("TABLE_STATIC_DELETE_PRODUCT", 'delete_static_products');
define("TABLE_STATIC_ADD_PRODUCT", 'add_static_products');
define("TABLE_AGENT_IP", 'agent_ips');
define("TABLE_PERMISSION",'permission');
define("TABLE_CITY",'cities');
define("TABLE_SUPPLIERS",'flowerwyz_supplier');
/*
 * API Set
 */
define("API_USER",'312495');
define("API_PASSWORD",'vIC6Lk');

?>