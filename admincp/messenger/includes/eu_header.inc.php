<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: eu_header.inc.php 107 2007-03-25 19:49:18Z matt.simpson $

	THIS IS A HEADER FILE.
*/

	if(!defined("TOOLS_LOADED"))	exit;

	$ERROR		= 0;
	$ERRORSTR	= array();

	$DATAERROR	= false;

	$TITLE		= "";
	$MESSAGE	= "";

	require_once("pref_ids.inc.php");
	require_once("config.inc.php");
	require_once("classes/adodb/adodb.inc.php");
	require_once("dbconnection.inc.php");
	require_once("functions.inc.php");
	require_once("classes/lm_mailer.class.php");
	require_once("classes/captcha/class.captcha.php");

	$config	= @enduser_configuration();
	$info	= array();

	if($config) {
		if(($_GET["action"] == "captcha") && ($config[ENDUSER_CAPTCHA] == "yes")) {
			$fonts = array();
			$fonts[] = $config[PREF_PROPATH_ID]."includes/fonts/vera.ttf";
			$fonts[] = $config[PREF_PROPATH_ID]."includes/fonts/verabd.ttf";
			$captcha = new PhpCaptcha($fonts, 172, 40);
			$captcha->UseColour(false);
			$captcha->Create();
			exit;
		} elseif(($_GET["action"] == "audiocaptcha") && ($config[ENDUSER_AUDIO_CAPTCHA] == "yes") && (is_executable($config[PREF_FLITE_PATH]))) {
			$captcha = new AudioPhpCaptcha(PREF_FLITE_PATH, $config[PREF_PRIVATE_PATH]."tmp/");
			$captcha->Create();
			exit;
		} else {
			// Note: General system errors are in English only.
			if(!$TEMPLATE = get_template()) {
				$ERROR++;
				$ERRORSTR[] = "Unable to retrieve the template file to display the output properly. Please contact the website administrator and make them aware that their ListMessenger template file is unreachable.";

				if($config[PREF_ERROR_LOGGING] == "yes") {
					@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to retrieve the template file.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
				}
			} else {
				if(!strstr($TEMPLATE, "[title]")) {
					$ERROR++;
					$ERRORSTR[] = "The retrieved template file does not contain a &quot;[title]&quot; variable. Please ensure your template has the string &quot;[title]&quot; somewhere in the file, usually between your &lt;title&gt;&lt/title&gt; tags.";

					if($config[PREF_ERROR_LOGGING] == "yes") {
						@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tTemplate file does not have [title] variable within the file.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
					}
				}
				if(!strstr($TEMPLATE, "[message]")) {
					$ERROR++;
					$ERRORSTR[] = "The retrieved template file does not contain a &quot;[message]&quot; variable. Please ensure your template has the string &quot;[message]&quot; somewhere in the file where you would like status messages displayed.";

					if($config[PREF_ERROR_LOGGING] == "yes") {
						@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tTemplate file does not have [message] variable within the file.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
					}
				}
			}

			if(!empty($_GET)) {
				$info	= $_GET;
			} else {
				$info	= $_POST;
			}
			unset($_GET, $_POST);

			if((@isset($info["language"])) || (@isset($_COOKIE["lm_language"]))) {
				$language_file = trim(str_replace(array(" ", "..", "/", "\\"), "", ((@isset($info["language"])) ? $info["language"] : $_COOKIE["lm_language"])));
			}

			if((@isset($info["language"])) && (@file_exists($config[PREF_PUBLIC_PATH]."languages/".$language_file.".lang.php"))) {
				@setcookie("lm_language", $language_file, PREF_COOKIE_TIMEOUT);
				require_once($config[PREF_PUBLIC_PATH]."languages/".$language_file.".lang.php");
			} elseif((@isset($_COOKIE["lm_language"])) && (@file_exists($config[PREF_PUBLIC_PATH]."languages/".$language_file.".lang.php"))) {
				require_once($config[PREF_PUBLIC_PATH]."languages/".$language_file.".lang.php");
			} elseif(@file_exists($config[PREF_PUBLIC_PATH]."languages/".$config[ENDUSER_LANG_ID].".lang.php")) {
				require_once($config[PREF_PUBLIC_PATH]."languages/".$config[ENDUSER_LANG_ID].".lang.php");
			} elseif(@file_exists($config[PREF_PUBLIC_PATH]."languages/english.lang.php")) {
				require_once($config[PREF_PUBLIC_PATH]."languages/english.lang.php");
			} else {
				$ERROR++;
				$ERRORSTR[] = "The public language directory does not contain the proposed language file, or the English language file. Please notify the website administrator that their ListMessenger language files need to be examined.";
			}
		}
	} else {
		$ERROR++;
		$ERRORSTR[] = "Unable to load ListMessenger's configuration data. Please information the website administrator of this error so it can be resolved.";
	}
?>