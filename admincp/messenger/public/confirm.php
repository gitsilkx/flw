<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: confirm.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

// Change the $LM_PATH variable in the eu_config.inc.php file in this directory.
require_once("./public_config.inc.php");

if(!@file_exists($LM_PATH."includes/config.inc.php")) {
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
	echo "<head>\n";
	echo "	<title>ListMessenger Path Error</title>\n";
	echo "	<style type=\"text/css\">\n";
	echo "	div.error-message {\n";
	echo "		background-color:	#FFD9D0;\n";
	echo "		border:				1px #CC0000 solid;\n";
	echo "		padding:			8px;\n";
	echo "		color:				#333333;\n";
	echo "		font-family:		Verdana, Arial, Helvetica, sans-serif;\n";
	echo "		font-size:			12px;\n";
	echo "		margin-bottom:		10px;\n";
	echo "	}\n";
	echo "	</style>\n";
	echo "</head>\n";
	echo "<body>\n";
	echo "<div class=\"error-message\">\n";
	echo "	The path to the ListMessenger directory that you've provided [<strong>".$LM_PATH."</strong>] appears to be invalid or PHP does not have permission to read files from this directory. Please ensure that you provide the full path from root to your ListMessenger program directory in the \$LM_PATH variable within this file [<strong>".__FILE__."</strong>].";
	echo "</div>\n";
	echo "</body>\n";
	echo "</html>\n";
	exit;
} else {
	@ini_set("include_path", str_replace("\\", "/", $LM_PATH."/includes"));
	@ini_set("allow_url_fopen", 1);
	@ini_set("error_reporting",  E_ALL ^ E_NOTICE);
	@ini_set("magic_quotes_runtime", 0);

	define("TOOLS_LOADED",	true);
	require_once("eu_header.inc.php");

	if((trim($info["id"]) == "") || (!(int) trim($info["id"]))) {
		$ERROR++;
		$TITLE		= $language_pack["error_default_title"];
		$MESSAGE	= $language_pack["error_confirm_invalid_request"];
	} else {
		if((trim($info["code"]) == "") || (!$info["code"])) {
			$ERROR++;
			$TITLE		= $language_pack["error_default_title"];
			$MESSAGE	= $language_pack["error_confirm_invalid_request"];
		} else {
			$query		= "SELECT * FROM `".TABLES_PREFIX."confirmation` WHERE `confirm_id`='".checkslashes(trim($info["id"]))."' AND `hash`='".checkslashes(trim($info["code"]))."'";
			$confirm	= $db->GetRow($query);
			if($confirm) {
				if($confirm["confirmed"] != "0") {
					$ERROR++;
					$TITLE		= $language_pack["error_default_title"];
					$MESSAGE	= $language_pack["error_confirm_completed"];
				}
			} else {
				$ERROR++;
				$TITLE		= $language_pack["error_default_title"];
				$MESSAGE	= $language_pack["error_confirm_invalid_request"];
			}
		}
	}

	if(!$ERROR) {
		switch($info["action"]) {
			case "confirm" :
				$query	= "UPDATE `".TABLES_PREFIX."confirmation` SET `confirmed`='1' WHERE `confirm_id`='".checkslashes(trim($info["id"]))."'";
				if(($db->Execute($query)) && ($db->Affected_Rows())) {
					switch($confirm["action"]) {
						case "adm-import" :
						case "adm-subscribe" :
						case "usr-subscribe" :
							$groups	= unserialize($confirm["group_ids"]);
							$cdata	= unserialize($confirm["cdata"]);
							$result	= users_add($confirm["email_address"], $confirm["firstname"], $confirm["lastname"], $groups, $cdata, "public");
							if($result) {
								if($result["failed"] > 0) {
									$ERROR++;
									$TITLE		= $language_pack["error_default_title"];
									$MESSAGE	= $language_pack["error_subscribe_failed"];
								}
								if($result["success"] > 0) {
		 							if($config[ENDUSER_NEWSUBNOTICE] == "yes") {
										if(!send_notice("subscribe", array("firstname" => $confirm["firstname"], "lastname" => $confirm["lastname"], "email_address" => $confirm["email_address"], "groups" => $groups))) {
											if($config[PREF_ERROR_LOGGING] == "yes") {
												@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to send new subscriber notice to administrator.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
											}
										}
									}

									$TITLE		= $language_pack["success_subscribe_title"];
									$MESSAGE	= $language_pack["success_subscribe_message"];
								}
							} else {
								$ERROR++;
								$TITLE		= $language_pack["error_default_title"];
								$MESSAGE	= $language_pack["error_subscribe_email_exists"];

								if($config[PREF_ERROR_LOGGING] == "yes") {
									@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to add a new subscriber to the database. The subscriber is already present in all groups.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
								}
							}
						break;
						case "adm-unsubscribe" :
						case "usr-unsubscribe" :
							$subscriber_ids	= array();
							$group_ids		= unserialize($confirm["group_ids"]);

							if(@is_array($group_ids)) {
								foreach($group_ids as $group_id) {
									$query	= "SELECT `users_id` FROM `".TABLES_PREFIX."users` WHERE `group_id`='".checkslashes(trim($group_id))."' AND `email_address`='".checkslashes(trim(strtolower($confirm["email_address"])))."'";
									$result	= $db->GetRow($query);
									if(($result) && (!@in_array($result["users_id"], $subscriber_ids))) {
										$subscriber_ids[] = $result["users_id"];
									}
								}
								if((!$ERROR) && (@count($subscriber_ids) < 1)) {
									$ERROR++;
									$TITLE		= $language_pack["error_default_title"];
									$MESSAGE	= $language_pack["error_unsubscribe_email_not_exists"];
								}
							} else {
								$ERROR++;
								$TITLE		= $language_pack["error_default_title"];
								$MESSAGE	= $language_pack["error_confirm_unable_request"];
							}

							if(!$ERROR) {
								$result = subscriber_remove($subscriber_ids, "public");
								if($result) {
									if($config[ENDUSER_UNSUBNOTICE] == "yes") {
										if(!send_notice("unsubscribe", array("firstname" => $confirm["firstname"], "lastname" => $confirm["lastname"], "email_address" => $confirm["email_address"], "groups" => $group_ids))) {
											if($config[PREF_ERROR_LOGGING] == "yes") {
												@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to send unsubscribe notice to administrator.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
											}
										}
									}

									$TITLE		= $language_pack["success_unsubscribe_title"];
									$MESSAGE	= $language_pack["success_unsubscribe_message"];
								} else {
									$ERROR++;
									$TITLE		= $language_pack["error_default_title"];
									$MESSAGE	= $language_pack["error_unsubscribe_email_not_exists"];

									if($config[PREF_ERROR_LOGGING] == "yes") {
										@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to remove subscriber from the database. They do not appear to be subscribed to the system.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
									}
								}
							}
						break;
						default :
							$ERROR++;
							$TITLE		= $language_pack["error_default_title"];
							$MESSAGE	= $language_pack["error_confirm_unable_request"];
						break;
					}
				} else {
					$ERROR++;
					$TITLE		= $language_pack["error_default_title"];
					$MESSAGE	= $language_pack["error_confirm_unable_request"];
				}
			break;
			default :
				$groups_info	= groups_information(unserialize($confirm["group_ids"]));

				if((@is_array($groups_info)) && (@count($groups_info) > 0)) {
					$TITLE	= $language_pack["page_confirm_title"];

					$MESSAGE  = "";
					$MESSAGE .= $language_pack["page_confirm_message_sentence"];
					$MESSAGE .= "<div style=\"height: 5px\">&nbsp;</div>\n";
					$MESSAGE .= "<form action=\"".$config[PREF_PUBLIC_URL].$config[ENDUSER_CONFIRM_FILENAME]."\" method=\"get\">\n";
					$MESSAGE .= "<input type=\"hidden\" name=\"action\" value=\"confirm\" />\n";
					$MESSAGE .= "<input type=\"hidden\" name=\"id\" value=\"".trim($info["id"])."\" />\n";
					$MESSAGE .= "<input type=\"hidden\" name=\"code\" value=\"".trim($info["code"])."\" />\n";
					$MESSAGE .= "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\">\n";
					if($confirm["firstname"] != "") {
						$MESSAGE .= "<tr>\n";
						$MESSAGE .= "	<td style=\"white-space: nowrap\">".$language_pack["page_confirm_firstname"]."</td>\n";
						$MESSAGE .= "	<td style=\"padding-left: 5px; font-weight: bold\">".$confirm["firstname"]."</td>\n";
						$MESSAGE .= "</tr>\n";
					}
					if($confirm["lastname"] != "") {
						$MESSAGE .= "<tr>\n";
						$MESSAGE .= "	<td style=\"white-space: nowrap\">".$language_pack["page_confirm_lastname"]."</td>\n";
						$MESSAGE .= "	<td style=\"padding-left: 5px; font-weight: bold\">".$confirm["lastname"]."</td>\n";
						$MESSAGE .= "</tr>\n";
					}
					$MESSAGE .= "<tr>\n";
					$MESSAGE .= "	<td style=\"white-space: nowrap\">".$language_pack["page_confirm_email_address"]."</td>\n";
					$MESSAGE .= "	<td style=\"padding-left: 5px; font-weight: bold\">".$confirm["email_address"]."</td>\n";
					$MESSAGE .= "</tr>\n";

					$MESSAGE .= "<tr>\n";
					$MESSAGE .= "	<td style=\"vertical-align: top; white-space: nowrap\">".$language_pack["page_confirm_group_info"]."</td>\n";
					$MESSAGE .= "	<td style=\"padding-left: 5px; font-weight: bold\">\n";
					foreach($groups_info as $group_info) {
						$MESSAGE .= "&rarr; ".$group_info["name"]."<br />\n";
					}
					$MESSAGE .= "	</td>\n";
					$MESSAGE .= "</tr>\n";
					$MESSAGE .= "<tr>\n";
					$MESSAGE .= "	<td colspan=\"2\" style=\"text-align: right; padding-top: 5px\">\n";
					$MESSAGE .= "		<input type=\"button\" value=\"".$language_pack["page_confirm_cancel_button"]."\" onclick=\"window.location='".$config[PREF_PUBLIC_URL].$config[ENDUSER_HELP_FILENAME]."'\" />\n";
					$MESSAGE .= "		<input type=\"submit\" value=\"".$language_pack["page_confirm_submit_button"]."\" />\n";
					$MESSAGE .= "	</td>\n";
					$MESSAGE .= "</tr>\n";
					$MESSAGE .= "</table>\n";
					$MESSAGE .= "</form>\n";
				} else {
					$ERROR++;
					$TITLE		= $language_pack["error_default_title"];
					$MESSAGE	= $language_pack["error_confirm_unable_find_info"];
				}
			break;
		}
	}

	require_once("eu_footer.inc.php");
}
?>