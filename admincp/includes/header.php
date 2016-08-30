<?php
//error_reporting(E_ALL);
ini_set('display_errors','On');
require_once("../configs/path.php");

$dark = "gray";
$light = "silver";
$td_bgcolor = "#F7F7F7";
$lightgray="#b7b5b5";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><?=ucwords($dotcom)?> Control System</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="NOINDEX, NOFOLLOW" />
	<base target="_self" />
	<link href="<?=$vpath?>admincp/css/style.css" rel="stylesheet" type="text/css" />
	<script language="javascript" src="<?=$vpath?>admincp/js/sortabletable.js" type="text/javascript"></script>
	<?php if($_SESSION['admin_id']) { ?>
	<link rel="stylesheet" type="text/css" href="<?=$vpath?>admincp/css/cssverticalmenu.css" />
	<script type="text/javascript" src="<?=$vpath?>admincp/js/cssverticalmenu.js" language="javascript"></script>
	<?php } ?>
	<script type="text/javascript" src="<?=$vpath?>admincp/highslide/highslide-with-html.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=$vpath?>admincp/highslide/highslide.css" />
   
	<script type="text/javascript">
	hs.graphicsDir = 'highslide/graphics/';
	hs.outlineType = 'rounded-white';
	hs.wrapperClassName = 'draggable-header';
	</script>

	<link rel="stylesheet" type="text/css" href="<?=$vpath?>admincp/css/ddsmoothmenu.css" />
	<link rel="stylesheet" type="text/css" href="<?=$vpath?>admincp/css/ddsmoothmenu-v.css" />

	<script type="text/javascript" src="<?=$vpath?>admincp/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?=$vpath?>admincp/js/ddsmoothmenu.js"></script>
        <link rel="stylesheet" href="<?=$vpath?>admincp/css/jquery-ui.css" />
<script src="<?=$vpath?>admincp/js/jquery-ui.js"></script>
    <script type="text/javascript">

	ddsmoothmenu.init({
		mainmenuid: "smoothmenu1", //menu DIV id
		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu', //class added to menu's outer DIV
		//customtheme: ["#1c5a80", "#18374a"],
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
	})

	ddsmoothmenu.init({
		mainmenuid: "smoothmenu2", //Menu DIV id
		orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
		method: 'toggle', // set to 'hover' (default) or 'toggle'
		arrowswap: true, // enable rollover effect on menu arrow images?
		//customtheme: ["#804000", "#482400"],
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
	})
   </script>
    
    

    

	
 <script type="text/javascript" src="<?=$vpath?>DataTables/media/js/jquery.dataTables.js" language="javascript"></script>
	<link href="<?=$vpath?>DataTables/media/css/demo_table.css"  rel="stylesheet" type="text/css">   
   </head>
   <body>

	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" >
	  <tr>
		<td colspan="2" align="left" valign="middle">
		<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center" >
		  <tr>
			<td height="60" valign="middle" >
			<b><span  style="color:#ffffff;font-family:verdana,Arial, Helvetica, sans-serif;font-size:35px;text-shadow: 1px 2px gray;"><?=ucwords($dotcom)?> Administration</span></b></td>
			<td width="225" class="lnk" valign="middle" align="right" style="padding-right:20px;" ><?=copyright("admin_header")?>&nbsp;</td>
		  </tr>
		</table></td>
	  </tr>

	  <tr>
	  <!--today row-->
		<td class="lnk" style="padding-left:10px; color:#000000;border-bottom:solid 1px silver"><strong><?php echo"<font color=white>Today: " . date("dS F, Y"); ?></font></strong></td>
    	<td  align="right" class="lnk" style="border-bottom:solid 1px silver"><?php if($_SESSION['admin_id']) { ?>
		<a href="./index.php" title="Index" ><!--<strong>Admin Home</strong>--><img src="images/home-btn.png"></a>  <?php } ?>
		<a href="../index.php" title="View Site" target="_blank"><!--<strong>View Site</strong>--><img src="images/admin-view-site-btn.png"></a>
		<?php if($_SESSION['admin_id']) { ?>
		<a href="password_change.php" title="Password Change"><!--<strong>Password Change</strong>--><img src="images/admin-update-pwd-btn.png"></a>
		<a href="#" title='Logout' onClick="javascript:if(confirm('You are going to logout?')){window.location = 'logout.php';}"><!--<b>Logout</b>--><img src="images/admin-sign-out-btn.png"></a>
		<?php } else { ?>
		<a href="login.php" title="Sign In"><!--<strong>Sign In</strong>--><img src="images/admin-login-btn.png"></a>
		<?php } ?>
		&nbsp;</td>
	   </tr>
	  </table>
	  <?php if($_SESSION['admin_id']) { ?>
	  <div id="smoothmenu1" class="ddsmoothmenu">
		<ul>
			<?
			$rws=mysql_query("select * from " . $prev . "adminmenu where status='Y' and parent_id=0  order by ord");
			while($rw=mysql_fetch_array($rws))
			{
               if($rw[parent_id]==$_GET[pid]){$bg="selected";}else{$bg='lnk';}
			   echo "<li  style='background-color: #0080C0'><a href='".$rw[url]."?menuid=" . $rw[id] . "&menupid=" . $rw[id] . "' class='" . $bg ."' active><b>".$rw[1]."</b></a>\n";

			   $rs=mysql_query("select * from " . $prev . "adminmenu where status='Y' and parent_id=".$rw[0]." order by ord");
			   if(@mysql_num_rows($rs))
			   {
					echo"<ul>\n";
					while($r=mysql_fetch_array($rs))
					{
						echo "<li><a href='".$r[url]."?menuid=" . $r[id] . "&menupid=" . $r[parent_id] . "' class='left_lnk'>".$r[1]."</a></li>\n";

					}
					echo"</ul>\n";
				}
				echo"</li>\n";

	       }
	       echo"</ul>\n";
	      
	       ?>
		<br style="clear: left" />
		</div>
        <?}?>


	<table border="0" width="100%" cellpadding="0" cellspacing="0" >
	  <tr><td colspan=2 bgcolor=whitesmoke height=10><img width="1" height="1" alt="" src="images/spacer.gif" /></td></tr>
	  <tr>
		<?php if($_SESSION['admin_id'] && $_GET[menuid]){?><td width="200" align="left" valign="top" style="padding-left:10px; padding-top:0px;border-right:solid 1px #c0c0c0;" bgcolor=whitesmoke><?php  require_once("includes/leftmenu.php");  ?></td><?}?>
		<td align="left" valign="top" style="padding-left:10px;  padding-right:10px;height:460px !important;min-height:560px;" bgcolor=whitesmoke>
		<?php if(substr_count($_SERVER['PHP_SELF'], "index.php")) { ?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tr>
			<td align="left"><a href="index.php"><img src="images/adim.png" alt="No Preview" border="0" /></a></td>
			<td align="left" class="lnk" style="padding-bottom:10px; color:#28B0D2;"><span style="font-size:18px;">Hello, Admin!</span><br />
			<span style="font-size:13px;">Welcome to your control panel. Here you can manage and modify every aspect of your this website.<br />
			You will find a quick snapshot of your website including some useful features.</span></td>
		  </tr>
		</table>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td height="4" bgcolor="<?=$dark?>"><img width="1" height="1" alt="" src="images/spacer.gif" /></td>
		  </tr>
		</table><br />
		<?php } ?>
