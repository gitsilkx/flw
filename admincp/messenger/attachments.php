<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: attachments.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

// Setup PHP and start page setup.
	@ini_set("include_path", str_replace("\\", "/", dirname(__FILE__))."/includes");
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

	ob_start();

	require_once("pref_ids.inc.php");
	require_once("config.inc.php");
	require_once("classes/adodb/adodb.inc.php");
	require_once("dbconnection.inc.php");

	session_start(trim($_GET["sid"]));

	if((!isset($_SESSION["isAuthenticated"])) || (!(bool) $_SESSION["isAuthenticated"])) {
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

	$ERROR		= 0;
	$ERRORSTR	= array();
	$NOTICE		= 0;
	$NOTICESTR	= array();
	$SUCCESS	= 0;
	$SUCCESSSTR	= array();

	require_once("functions.inc.php");
	require_once("loader.inc.php");

	// Setup "Sort By Field" Information
	if((isset($_GET["sort"])) && (trim($_GET["sort"]) != "")) {
		$_SESSION["display"]["attachments"]["sort"] = checkslashes($_GET["sort"]);
		setcookie("display[attachments][sort]", checkslashes($_GET["sort"]), PREF_COOKIE_TIMEOUT);
	} elseif((!isset($_SESSION["display"]["attachments"]["sort"])) && (isset($_COOKIE["display"]["attachments"]["sort"]))) {
		$_SESSION["display"]["attachments"]["sort"] = $_COOKIE["display"]["attachments"]["sort"];
	} else {
		if(!isset($_SESSION["display"]["attachments"]["sort"])) {
			$_SESSION["display"]["attachments"]["sort"] = "name";
			setcookie("display[attachments][sort]", "name", PREF_COOKIE_TIMEOUT);
		}
	}

	// Setup "Sort Order" Information
	if(isset($_GET["order"])) {
		switch($_GET["order"]) {
			case "asc" :
				$_SESSION["display"]["attachments"]["order"] = "ASC";
			break;
			case "desc" :
				$_SESSION["display"]["attachments"]["order"] = "DESC";
			break;
			default :
				$_SESSION["display"]["attachments"]["order"] = "ASC";
			break;
		}
		setcookie("display[attachments][order]", $_SESSION["display"]["attachments"]["order"], PREF_COOKIE_TIMEOUT);
	} elseif((!isset($_SESSION["display"]["attachments"]["order"])) && (isset($_COOKIE["display"]["attachments"]["order"]))) {
		$_SESSION["display"]["attachments"]["order"] = $_COOKIE["display"]["attachments"]["order"];
	} else {
		if (!isset($_SESSION["display"]["attachments"]["order"])) {
			$_SESSION["display"]["attachments"]["order"] = "ASC";
			setcookie("display[attachments][order]", "ASC", PREF_COOKIE_TIMEOUT);
		}
	}

	// Set the internal variables used for sorting, ordering and in pagination.
	$sort		= $_SESSION["display"]["attachments"]["sort"];
	$order		= $_SESSION["display"]["attachments"]["order"];
	$filecount	= 0;

	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION["config"][PREF_DEFAULT_CHARSET]; ?>" />

		<title>ListMessenger <?php echo VERSION_TYPE." ".(($_SESSION["isAuthenticated"]) ? VERSION_INFO : ""); ?></title>

		<link rel="stylesheet" type="text/css" href="./css/common.css" title="ListMessenger Style" />

		<style>
			@import url(./css/domtt.css);
		</style>

		<script type="text/javascript" language="javascript" src="./javascript/common.js"></script>

		<link rel="shortcut icon" href="./images/listmessenger.ico" />

		<meta name="MSSmartTagsPreventParsing" content="true" />
		<meta http-equiv="imagetoolbar" content="no" />
	</head>

	<h1>List Attachments</h1>
	<?php
	if(@is_dir($_SESSION["config"][PREF_PUBLIC_PATH]."files/")) {
		if($handle = @opendir($_SESSION["config"][PREF_PUBLIC_PATH]."files/")) {
			$filenames	= array();
			$filesizes	= array();
			$totalsize	= 0;

			while(($filename = @readdir($handle)) !== false) {
				if(($filename != ".") && ($filename != "..")) {
					$filesize		= @filesize($_SESSION["config"][PREF_PUBLIC_PATH]."files/".$filename);

					$i			= @count($filenames);
					$filenames[$i] = $filename;
					$filesizes[$i] = $filesize;

					$totalsize += $filesize;
				}
			}
			@closedir($handle);

			$filecount = @count($filenames);

			if($filecount > 0) {
				?>
				<form action="attachments.php" method="post" name="attachment_list">
				<table style="width: 100%; text-align: left" cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td style="width: 3%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap">&nbsp;</td>
					<td style="width: 80%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "name") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("name", "Filename", $order, $sort, true, true); ?></td>
					<td style="width: 17%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "size") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("size", "Filesize", $order, $sort, true, true); ?></td>
				</tr>
				<?php
				if($sort == "name") {
					if($order == "ASC") {
						@asort($filenames);
					} else {
						@arsort($filenames);
					}
					foreach($filenames as $key => $filename) {
						echo "<tr>\n";
						echo "	<td><input type=\"radio\" name=\"online_file\" value=\"".$filename."\" /></td>\n";
						echo "	<td style=\"padding-left: 5px\"><a href=\"".$_SESSION["config"][PREF_PUBLIC_URL]."files/".$filename."\">".$filename."</a></td>\n";
						echo "	<td style=\"padding-left: 5px\">".readable_size($filesizes[$key])."</td>\n";
						echo "</tr>\n";
					}
				} else {
					if($order == "ASC") {
						@asort($filesizes);
					} else {
						@arsort($filesizes);
					}
					foreach($filesizes as $key => $filesize) {
						echo "<tr>\n";
						echo "	<td><input type=\"radio\" name=\"online_file\" value=\"".$filenames[$key]."\" /></td>\n";
						echo "	<td style=\"padding-left: 5px\"><a href=\"".$_SESSION["config"][PREF_PUBLIC_URL]."files/".$filenames[$key]."\">".$filenames[$key]."</a></td>\n";
						echo "	<td style=\"padding-left: 5px\">".readable_size($filesize)."</td>\n";
						echo "</tr>\n";
					}
				}
				echo "<tr>\n";
				echo "	<td colspan=\"3\" style=\"height: 4px\"></td>\n";
				echo "</tr>\n";
				echo "<tr>\n";
				echo "	<td colspan=\"3\" style=\"border-top: 1px #333333 dotted; padding-top: 5px\">\n";
				echo "		<table style=\"width: 100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
				echo "		<tr>\n";
				echo "			<td style=\"width: 50%; text-align: left\"><input type=\"button\" value=\"Attach File\" class=\"button\" onclick=\"submitOnlineFile()\" /></td>\n";
				echo "			<td style=\"width: 50%; text-align: right\"><input type=\"button\" value=\"Close Window\" class=\"button\" onclick=\"parent.window.focus();top.window.close()\" /></td>\n";
				echo "		</tr>\n";
				echo "		</table>\n";
				echo "	</td>\n";
				echo "</tr>\n";
				echo "<tr>\n";
				echo "	<td colspan=\"3\">\n";
				echo "		<h2>Directory Statistics:</h2>\n";
				echo "		There ".(($filecount != 1) ? "are" : "is")." currently <strong>".$filecount."</strong> file".(($filecount != 1) ? "s" : "")." in your public files directory.<br />";
				echo "		Your public files directory constains a total of <strong>".readable_size($totalsize)."</strong> worth of files.";
				echo "	</td>\n";
				echo "</tr>\n";
				echo "</table>\n";
				echo "</form>\n";
			} else {
				$NOTICE++;
				$NOTICESTR[] = "There are currently no files in your public files directory. Either add a file using the Control Panel &gt; Attachments, or use the Add File Attachment in the Compose Window.";

				echo display_notice($NOTICESTR);
			}

		}
	} else {
		$ERROR++;
		$ERRORSTR[] = "Your public files directory does not appear to exist or PHP is not able to read the directory. Please go into the <a href=\"index.php?section=preferences&type=program\">ListMessenger Program Preferences</a> and update your public folder directory path.";

		echo display_error($ERRORSTR);
	}
	echo "</body>\n";
	echo "</html>\n";
	ob_end_flush();
?>