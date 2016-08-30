<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: backup.php 107 2007-03-25 19:49:18Z matt.simpson $
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

	$filename = str_replace(array(" ", "..", "/", "\\"), "", trim($_GET["file"]));

	if((strlen($filename) > 0) && (@file_exists($_SESSION["config"][PREF_PRIVATE_PATH]."backups/".$filename))) {
		$filesize	= @filesize($_SESSION["config"][PREF_PRIVATE_PATH]."backups/".$filename);
		$handle	= @fopen($_SESSION["config"][PREF_PRIVATE_PATH]."backups/".$filename, "rb");

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/x-zip-compressed");
		header("Content-Disposition: attachment; filename=\"".$filename."\"");
		header("Content-Length: ".$filesize);
		header("Content-Transfer-Encoding: binary");
		while(!@feof($handle)) {
			echo @fread($handle, 10240);
		}
		@fclose($handle);
	} else {
		$ERROR++;
		$ERRORSTR[] = "The backup file that you have requested does not exist on the server. This request has been logged, please look for more information in the log file.";

		echo display_error($ERRORSTR);

		if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
			@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to locate the requested backup file [Original: ".checkslashes($_GET["file"])."] in the file system. This request was made by ".$_SERVER["REMOTE_ADDR"].", please ensure this was not a hack attempt.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
		}
	}
	ob_end_flush();
?>