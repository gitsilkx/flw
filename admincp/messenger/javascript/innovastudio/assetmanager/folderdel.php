<?php
/*
IMPORTANT APPLICATION USAGE NOTICE TO ANYONE WHO READS THIS:
==========================================================================
This application may NOT be used outside of ListMessenger Pro. It was
specifically licenced to me, for exclusive use within ListMessenger and
you may not use or include this class with any other application or script.

If you would like to purchase InnovaStudio for use within your
own applications, please do so by visiting the InnovaStudio website
[http://www.innovastudio.com].

If you do not adhere to this warning, you are stealing. Not just that, but
you're taking money out of another developers pocket. Someone worked very
hard to bring this script to existance and they should be paid for their
work, so please purchase this class if you intend on using it. They even
have a free trial on their website that you can test out, so do not even
test out something with this version. Thank-you for your understanding.

$Id: folderdel.php 107 2007-03-25 19:49:18Z matt.simpson $
*/
	@ini_set("include_path", "../../../includes");
	@ini_set("allow_url_fopen", 1);
	@ini_set("session.name", "LMSID");
	@ini_set("session.use_trans_sid", 0);
	@ini_set("session.cookie_lifetime", 0);
	@ini_set("session.cookie_secure", 0);
	@ini_set("session.referer_check", "");
	@ini_set("error_reporting",  E_ALL ^ E_NOTICE);
	@ini_set("magic_quotes_runtime", 0);

	if((!isset($_GET["sid"])) || (!trim($_GET["sid"]))) {
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
		echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
		echo "<body>\n";
		echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		echo "alert('It appears as though you are either not currently logged into ListMessenger or your session has expired. You will now be taken to the ListMessenger login page; please re-login.');\n";
		echo "if(window.opener) {\n";
		echo "	window.opener.location = './index.php?action=logout';\n";
		echo "	top.window.close();\n";
		echo "} else {\n";
		echo "	window.location = './index.php?action=logout';\n";
		echo "}\n";
		echo "</script>\n";
		echo "</body>\n";
		echo "</html>\n";
		exit;
	}

	require_once("pref_ids.inc.php");
	require_once("config.inc.php");
	require_once("classes/adodb/adodb.inc.php");
	require_once("dbconnection.inc.php");

	session_start(trim($_GET["sid"]));

	if((!isset($_SESSION["isAuthenticated"])) || (!(bool) $_SESSION["isAuthenticated"])) {
		$path_details	= pathinfo(htmlentities($_SERVER["PHP_SELF"]));

		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
		echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
		echo "<body>\n";
		echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		echo "alert('It appears as though you are either not currently logged into ListMessenger or your session has expired. You will now be taken to the ListMessenger login page; please re-login.');\n";
		echo "if(window.opener) {\n";
		echo "	window.opener.location = '".str_replace("/javascript/innovastudio/assetmanager", "", $path_details["dirname"])."/index.php?action=logout';\n";
		echo "	top.window.close();\n";
		echo "} else {\n";
		echo "	window.location = '".str_replace("/javascript/innovastudio/assetmanager", "", $path_details["dirname"])."/index.php?action=logout';\n";
		echo "}\n";
		echo "</script>\n";
		echo "</body>\n";
		echo "</html>\n";
		exit;
	} else {
		switch($_GET["action"]) {
			case "delete" :
				$sMsg = "";

				if(isset($_POST["inpCurrFolder"]))
					{
					$sDestination = pathinfo($_POST["inpCurrFolder"]);

					//DELETE ALL FILES IF FOLDER NOT EMPTY
				    $dir = $_POST["inpCurrFolder"];
				    $handle = opendir($dir);
				    while($file = readdir($handle)) if($file != "." && $file != "..") unlink($dir . "/" . $file);
				    closedir($handle);

					if(rmdir($_POST["inpCurrFolder"])==0)
						$sMsg = "";
					else
						$sMsg = "<script>document.write(getTxt('Folder deleted.'))</script>";
					}
				?>
				<base target="_self">
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<link href="style.css" rel="stylesheet" type="text/css">
				<script>
					if(navigator.appName.indexOf('Microsoft')!=-1)
						var sLang=dialogArguments.sLang;
					else
						var sLang=window.opener.sLang;
					document.write("<scr"+"ipt src='language/"+sLang+"/folderdel_.js'></scr"+"ipt>");
				</script>
				<script>writeTitle()</script>
				<script>
				function refresh()
					{
					if(navigator.appName.indexOf('Microsoft')!=-1)
						dialogArguments.refreshAfterDelete(inpDest.value);
					else
						window.opener.refreshAfterDelete(document.getElementById("inpDest").value);
					}
				</script>
				</head>
				<body onload="loadTxt()" style="overflow:hidden;margin:0px;">

				<table width=100% height=100% align=center style="" cellpadding=0 cellspacing=0 ID="Table1">
				<tr>
				<td valign=top style="padding-top:5px;padding-left:15px;padding-right:15px;padding-bottom:12px;height=100%">

					<br>
					<input type="hidden" ID="inpDest" NAME="inpDest" value="<?php echo $sDestination['dirname']; ?>">
					<div><b><?php echo $sMsg; ?>&nbsp;</b></div>

				</td>
				</tr>
				<tr>
				<td class="dialogFooter" style="height:45px;padding-right:10px;" align=right valign=middle>
					<input type="button" name="btnCloseAndRefresh" id="btnCloseAndRefresh" value="close & refresh" onclick="refresh();self.close();" class="inpBtn" onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">
				</td>
				</tr>
				</table>


				</body>
				</html>
				<?php
			break;
			default :
				?>
				<base target="_self">
				<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<link href="style.css" rel="stylesheet" type="text/css">
				<script>
					if(navigator.appName.indexOf('Microsoft')!=-1)
						var sLang=dialogArguments.sLang;
					else
						var sLang=window.opener.sLang;
					document.write("<scr"+"ipt src='language/"+sLang+"/folderdel.js'></scr"+"ipt>");
				</script>
				<script>writeTitle()</script>
				<script>
				function del()
					{
					var Form1 = document.forms.Form1;
					if(navigator.appName.indexOf('Microsoft')!=-1)
						Form1.elements.inpCurrFolder.value=dialogArguments.selCurrFolder.value;
					else
						Form1.elements.inpCurrFolder.value=window.opener.document.getElementById("selCurrFolder").value;
					Form1.submit();
					}
				</script>
				</head>
				<body onload="loadTxt()" style="overflow:hidden;margin:0px;">

				<table width=100% height=100% align=center style="" cellpadding=0 cellspacing=0>
				<tr>
				<td valign=top style="padding-top:5px;padding-left:15px;padding-right:15px;padding-bottom:12px;height=100%">

				<form action="folderdel.php?sid=<?= session_id() ?>&action=delete" name="Form1" id="Form1" method="post">
					<br>
					<input type="hidden" id="inpCurrFolder" name="inpCurrFolder">
					<div><b><span id=txtLang>Are you sure you want to delete this folder?</span></b></div>
				</form>

				</td>
				</tr>
				<tr>
				<td class="dialogFooter" style="height:45px;padding-right:10px;" align=right valign=middle>
					<input type="button" name="btnClose" id="btnClose" value="close" onclick="self.close();" class="inpBtn" onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">&nbsp;<input type="button" name="btnDelete" id="btnDelete" value="delete" onclick="del()" class="inpBtn" onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">
				</td>
				</tr>
				</table>

				</body>
				</html>
				<?php
			break;
		}
	}
?>