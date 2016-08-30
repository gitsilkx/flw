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

$Id: foldernew.php 107 2007-03-25 19:49:18Z matt.simpson $
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
		$sMsg = "";

		if(isset($_POST["inpNewFolderName"]))
			{
			$sFolder = $_POST["inpCurrFolder"]."/".$_POST["inpNewFolderName"];

			if(is_dir($sFolder)==1)
				{//folder already exist
				$sMsg = "<script>document.write(getTxt('Folder already exists.'))</script>";
				}
			else
				{
				//if(mkdir($sFolder))
				if(mkdir($sFolder,0755))
					$sMsg = "<script>document.write(getTxt('Folder created.'))</script>";
				else
					$sMsg = "<script>document.write(getTxt('Invalid input.'))</script>";
				}
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
			document.write("<scr"+"ipt src='language/"+sLang+"/foldernew.js'></scr"+"ipt>");
		</script>
		<script>writeTitle()</script>
		<script>
		function doPreSubmit()
			{
			var Form1 = document.forms.Form1;
			if(navigator.appName.indexOf('Microsoft')!=-1)
				Form1.elements.inpCurrFolder.value=dialogArguments.selCurrFolder.value;
			else
				Form1.elements.inpCurrFolder.value=window.opener.document.getElementById("selCurrFolder").value;

			if(Form1.elements.inpNewFolderName.value=="")
				{
				alert(fgetTxt("Invalid input."));
				return false;
				}
			return true;
			}
		function doSubmit()
			{
			if(doPreSubmit())document.forms.Form1.submit()
			}
		</script>
		</head>
		<body onload="loadTxt()" style="overflow:hidden;margin:0;">

		<table width=100% height=100% align=center style="" cellpadding=0 cellspacing=0>
		<tr>
		<td valign=top style="padding-top:5px;padding-left:15px;padding-right:15px;padding-bottom:12px;height=100%">

		<form method=post action="foldernew.php" onsubmit="doPreSubmit()" name="Form1" id="Form1">
			<br>
			<input type="hidden" id="inpCurrFolder" name="inpCurrFolder">
			<span id="txtLang">New Folder Name</span>: <br>
			<input type="text" id="inpNewFolderName" name="inpNewFolderName" class="inpTxt" size=38>
			<div><b><?php echo $sMsg ?>&nbsp;</b></div>
		</form>

		</td>
		</tr>
		<tr>
		<td class="dialogFooter" style="height:40px;padding-right:10px;" align=right valign=middle>
			<input style="width:135" type="button" name="btnCloseAndRefresh" id="btnCloseAndRefresh" value="close & refresh" onclick="if(navigator.appName.indexOf('Microsoft')!=-1){dialogArguments.changeFolder()}else{window.opener.changeFolder()};self.close();" class="inpBtn" onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">&nbsp;<input name="btnCreate" id="btnCreate" type="button" onclick="doSubmit()" value="create" class="inpBtn" onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">
		</td>
		</tr>
		</table>

		</body>
		</html>
		<?php
	}
?>