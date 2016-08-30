<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: loader.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

	// Loads all configuration settings into $_SESSION["config"].
	if(!load_configuration()) {
		if(@file_exists("./setup.php")) {
			header("Location: setup.php");
			exit;
		} else {
			$ERROR++;
			$ERRORSTR[] = "Unable to load your ListMessenger application settings.<br /><br />The most common cause of this error is that you have not yet run the <a href=\"setup.php\" style=\"font-weight: bold\">ListMessenger Setup Program</a>. Please do this now.<br /><br />If you have previously run the setup program, please check to see if changes have been made to your ".DATABASE_TYPE." database server connection or database name.";
		}
		$CONFIG_LOADED	= false;
	} else {
		$CONFIG_LOADED	= true;
	}

	// Check to see if the rich text editor should be loaded.
	rte_loader();

	// Ensure script is not being loaded from the sending engine.
	if(!defined("IN_SENDER")) {
		// Check for licence key. *** DO NOT REMOVE ***
		if(!check_licence()) {
			$ERROR++;
			$ERRORSTR[]						= "Your ListMessenger Licence Key (key.php) does not appear to exist in your ListMessenger program directory. Please ensure that you upload your licence key file (key.php) to the ListMessenger directory and try again.";
			$_SESSION["isAuthenticated"]	= false;
		}

		// Perform routine maintenance once per session.
		perform_maintenance((((isset($_SESSION["doneMaintenance"])) && ((bool) $_SESSION["doneMaintenance"])) ? true : false));
	}

	// This loads the constants based on the emailsettings preferences.
	if (isset($_SESSION["config"][PREF_MAILER_BY_ID])) {
		define("MAIL_BY", $_SESSION["config"][PREF_MAILER_BY_ID]);
	} else {
		define("MAIL_BY", "mail");
	}

	if(MAIL_BY == "sendmail") {
		if (isset($_SESSION["config"][PREF_MAILER_BY_VALUE])) {
			define("SENDMAIL_PATH", $_SESSION["config"][PREF_MAILER_BY_VALUE]);
		} else {
			define("SENDMAIL_PATH", "/usr/bin/sendmail");
		}
	} elseif(MAIL_BY == "smtp") {
		if (isset($_SESSION["config"][PREF_MAILER_BY_VALUE])) {
			define("SMTP_HOSTS", trim($_SESSION["config"][PREF_MAILER_BY_VALUE]));
		} else {
			define("SMTP_HOSTS", "localhost");
		}
		define("SMTP_KEEP_ALIVE", (($_SESSION["config"][PREF_MAILER_SMTP_KALIVE] != "no") ? true : false));

		if (isset($_SESSION["config"][PREF_MAILER_AUTHUSER_ID])) {
			define("SMTP_AUTH", $_SESSION["config"][PREF_MAILER_AUTH_ID]);
			if (isset($_SESSION["config"][PREF_MAILER_AUTHUSER_ID])) {
				define("SMTP_AUTH_USER", $_SESSION["config"][PREF_MAILER_AUTHUSER_ID]);
				if (isset($_SESSION["config"][PREF_MAILER_AUTHPASS_ID])) {
					define("SMTP_AUTH_PASS", $_SESSION["config"][PREF_MAILER_AUTHPASS_ID]);
				} else {
					define("SMTP_AUTH_PASS", "");
				}
			} else {
				define("SMTP_AUTH_USER", "");
			}
		} else {
			define("SMTP_AUTH", "false");
		}
	}

	// Listing of all preferences that contain paths or URL's.
	$PREFERENCES_SKIP		= array();
	$PREFERENCES_SKIP[]		= PREF_PROPATH_ID;
	$PREFERENCES_SKIP[]		= PREF_PROGURL_ID;
	$PREFERENCES_SKIP[]		= PREF_PUBLIC_PATH;
	$PREFERENCES_SKIP[]		= PREF_PUBLIC_URL;
	$PREFERENCES_SKIP[]		= PREF_PRIVATE_PATH;

	// Listing of all available character sets (Thanks to PHPMyAdmin team for the list).
	$CHARACTER_SETS		= array();
	$CHARACTER_SETS[]		= "ISO-8859-1";
//	$CHARACTER_SETS[]		= "ISO-8859-2";
//	$CHARACTER_SETS[]		= "ISO-8859-3";
//	$CHARACTER_SETS[]		= "ISO-8859-4";
//	$CHARACTER_SETS[]		= "ISO-8859-5";
//	$CHARACTER_SETS[]		= "ISO-8859-6";
//	$CHARACTER_SETS[]		= "ISO-8859-7";
//	$CHARACTER_SETS[]		= "ISO-8859-8";
//	$CHARACTER_SETS[]		= "ISO-8859-9";
//	$CHARACTER_SETS[]		= "ISO-8859-10";
//	$CHARACTER_SETS[]		= "ISO-8859-11";
//	$CHARACTER_SETS[]		= "ISO-8859-12";
//	$CHARACTER_SETS[]		= "ISO-8859-13";
//	$CHARACTER_SETS[]		= "ISO-8859-14";
	$CHARACTER_SETS[]		= "ISO-8859-15";
//	$CHARACTER_SETS[]		= "Windows-1250";
	$CHARACTER_SETS[]		= "Windows-1251";
	$CHARACTER_SETS[]		= "Windows-1252";
//	$CHARACTER_SETS[]		= "Windows-1256";
//	$CHARACTER_SETS[]		= "Windows-1257";
	$CHARACTER_SETS[]		= "KOI8-R";
	$CHARACTER_SETS[]		= "BIG5";
	$CHARACTER_SETS[]		= "BIG5-HKSCS";
//	$CHARACTER_SETS[]		= "GB2312";
	$CHARACTER_SETS[]		= "UTF-8";
//	$CHARACTER_SETS[]		= "utf-7";
//	$CHARACTER_SETS[]		= "x-user-defined";
	$CHARACTER_SETS[]		= "EUC-JP";
//	$CHARACTER_SETS[]		= "ks_c_5601-1987";
//	$CHARACTER_SETS[]		= "tis-620";
	$CHARACTER_SETS[]		= "Shift_JIS";
?>
