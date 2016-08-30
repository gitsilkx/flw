<?php
//error_reporting(E_ALL);
ini_set('display_errors','On');
require_once("../configs/path.php");
$currentPageName = basename($_SERVER['PHP_SELF']); 
$dark = "#333333";
$light = "#b7b5b5";/*#A8D3FF*/
$td_bgcolor = "#F7F7F7";
$lightgray="#b7b5b5"
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><?=ucwords($dotcom)?> Control System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="NOINDEX, NOFOLLOW" />
	<base target="_self" />
	<link href="css/style.css" rel="stylesheet" type="text/css" />
    <script language="javascript" src="../js/script.js" type="text/javascript"></script>
	<script language="javascript" src="js/sortabletable.js" type="text/javascript"></script>
	
	<?php if($_SESSION['admin_id']) { ?>
	<link rel="stylesheet" type="text/css" href="css/cssverticalmenu.css" />
	<script type="text/javascript" src="js/cssverticalmenu.js" language="javascript"></script>	
	<?php } ?>
	
	<script src="<?=$calendar_new_path?>js/jscal2.js" type="text/javascript"></script>
	<script src="<?=$calendar_new_path?>js/lang/en.js" type="text/javascript"></script>
	<link type="text/css" rel="stylesheet" href="<?=$calendar_new_path?>css/jscal2.css" />
	<link type="text/css" rel="stylesheet" href="<?=$calendar_new_path?>css/border-radius.css" />
	<link type="text/css" rel="stylesheet" href="<?=$calendar_new_path?>css/steel/steel.css" />
	<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
	<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
	<script type="text/javascript">
	hs.graphicsDir = 'highslide/graphics/';
	hs.outlineType = 'rounded-white';
	hs.wrapperClassName = 'draggable-header';
	</script>
	 <script type="text/javascript">
function closeAndReload() {
    parent.window.hs.close();
    setTimeout(function() {
        try {
            parent.location.reload();
        } catch (e) {}
    }, 400);
};
</script>
</head>

<body >

