<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: unsubscribe.php 107 2007-03-25 19:49:18Z matt.simpson $
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

	// Copy smaller variable names to standard naming convention.
	$info["group_ids"]		= $info["g"];
	$info["email_address"]	= $info["addr"];
	unset($info["g"], $info["addr"]);

	// Error checking for e-mail address information.
	if((!$info["email_address"]) || (trim($info["email_address"]) == "")) {
		$ERROR++;
		$TITLE	= $language_pack["error_default_title"];
		$MESSAGE	= $language_pack["error_unsubscribe_no_email"];
	} else {
		if(!valid_address(trim($info["email_address"]))) {
			$ERROR++;
			$TITLE	= $language_pack["error_default_title"];
			$MESSAGE	= $language_pack["error_unsubscribe_invalid_email"];
		} else {
			$groups			= array();
			$subscriber_ids	= array();
			$groups_requested	= false;

			if((isset($info["group_ids"])) && (((@is_array($info["group_ids"])) && (@count($info["group_ids"]) > 0)) || (trim($info["group_ids"]) != "") || ((int) trim($info["group_ids"])))) {
				$groups_requested	= true;

				if(@is_array($info["group_ids"])) {
					foreach($info["group_ids"] as $group_id) {
						$query	= "SELECT `group_name` FROM `".TABLES_PREFIX."groups` WHERE `groups_id`='".checkslashes(trim($group_id))."'";
						$result	= $db->GetRow($query);
						if($result) {
							$query	= "SELECT `users_id` FROM `".TABLES_PREFIX."users` WHERE `group_id`='".checkslashes(trim($group_id))."' AND `email_address`='".checkslashes(trim(strtolower($info["email_address"])))."'";
							$result	= $db->GetRow($query);
							if(($result) && (!@in_array($result["users_id"], $subscriber_ids))) {
								$subscriber_ids[]	= $result["users_id"];
								$groups[]			= $group_id;
							}
						} else {
							$ERROR++;
							$TITLE	= $language_pack["error_default_title"];
							$MESSAGE	= $language_pack["error_unsubscribe_group_not_found"];
						}
					}
					if((!$ERROR) && (@count($subscriber_ids) < 1)) {
						$ERROR++;
						$TITLE	= $language_pack["error_default_title"];
						$MESSAGE	= $language_pack["error_unsubscribe_email_not_exists"];
					}
				} else {
					if((trim($info["group_ids"]) != "") && ((int) $info["group_ids"])) {
						$query	= "SELECT `group_name` FROM `".TABLES_PREFIX."groups` WHERE `groups_id`='".checkslashes(trim($info["group_ids"]))."'";
						$result	= $db->GetRow($query);
						if($result) {
							$query	= "SELECT `users_id` FROM `".TABLES_PREFIX."users` WHERE `group_id`='".checkslashes(trim($info["group_ids"]))."' AND `email_address`='".checkslashes(trim(strtolower($info["email_address"])))."'";
							$result	= $db->GetRow($query);
							if($result) {
								$subscriber_ids[]	= $result["users_id"];
								$groups[]			= checkslashes(trim($info["group_ids"]));
							} else {
								$ERROR++;
								$TITLE	= $language_pack["error_default_title"];
								$MESSAGE	= $language_pack["error_unsubscribe_email_not_exists"];
							}
						} else {
							$ERROR++;
							$TITLE	= $language_pack["error_default_title"];
							$MESSAGE	= $language_pack["error_unsubscribe_group_not_found"];
						}
					}
				}
			} elseif($info["action"] != "confirm") {
				$query	= "SELECT `users_id`, `group_id` FROM `".TABLES_PREFIX."users` WHERE `email_address`='".checkslashes(trim($info["email_address"]))."'";
				$results	= $db->GetAll($query);
				if($results) {
					foreach($results as $result) {
						$subscriber_ids[]	= $result["users_id"];
						$groups[]			= $result["group_id"];
					}
				}

				if((!$ERROR) && (@count($subscriber_ids) < 1)) {
					$ERROR++;
					$TITLE	= $language_pack["error_default_title"];
					$MESSAGE	= $language_pack["error_unsubscribe_email_not_found"];
				}
			}

			if(!$ERROR) {
				switch($info["action"]) {
					case "confirm" :
						if(@count($groups) > 0) {
							if($config[ENDUSER_UNSUBCON] == "yes") {
								$result = users_queue(trim($info["email_address"]), "", "", $groups, array(), "usr-unsubscribe");
								if($result) {
									$mail		= new LM_Mailer("public");
									$mail->Subject	= $language_pack["unsubscribe_confirmation_subject"];
									$mail->Body	= str_replace(array("[url]", "[abuse_address]", "[from]"), array(($config[PREF_PUBLIC_URL].$config[ENDUSER_CONFIRM_FILENAME]."?id=".$result["confirm_id"]."&code=".$result["hash"]), $config[PREF_ABUEMAL_ID], $config[PREF_FRMNAME_ID]), $language_pack["unsubscribe_confirmation_message"]);

									$mail->AddAddress(trim($info["email_address"]), trim($info["email_address"]));

									if((!@$mail->IsError()) && (@$mail->Send())) {
										$TITLE	= $language_pack["success_unsubscribe_optout_title"];
										$MESSAGE	= $language_pack["success_unsubscribe_optout_message"];
									} else {
										$ERROR++;
										$TITLE	= $language_pack["error_default_title"];
										$MESSAGE	= $language_pack["error_unsubscribe_failed_optout"];

										$query = "DELETE FROM `".TABLES_PREFIX."confirmation` WHERE `confirm_id`='".$result["confirm_id"]."';";
										if(!$db->Execute($query)) {
											if($config[PREF_ERROR_LOGGING] == "yes") {
												@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete the failed confirmation queue request from the confirmation table. Database server said: ".$db->ErrorMsg()."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
											}
										}

										if($config[PREF_ERROR_LOGGING] == "yes") {
											@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to send confirmation message to ".$email_address.". LM_Mailer responded: ".$mail->ErrorInfo."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
										}
									}

									if($mail->Mailer == "smtp") $mail->SmtpClose();

									$mail->ClearCustomHeaders();

									@ini_restore("sendmail_from");
								} else {
									$ERROR++;
									$TITLE	= $language_pack["error_default_title"];
									$MESSAGE	= $language_pack["error_unsubscribe_email_not_exists"];

									if($config[PREF_ERROR_LOGGING] == "yes") {
										@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to add a new subscriber to the confirmation queue. The subscriber is already present in all groups.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
									}
								}
							} else {
								$result = subscriber_remove($subscriber_ids);
								if($result) {
									$query	= "INSERT INTO `".TABLES_PREFIX."confirmation` VALUES (NULL, '".time()."', 'usr-unsubscribe', '".addslashes($_SERVER["REMOTE_ADDR"])."', '".addslashes($_SERVER["HTTP_REFERER"])."', '".addslashes($_SERVER["HTTP_USER_AGENT"])."', '".trim($info["email_address"])."', '', '', '".addslashes(serialize($groups))."', '', '', '0');";
									$db->Execute($query);

									if($config[ENDUSER_UNSUBNOTICE] == "yes") {
										if(!send_notice("unsubscribe", array("email_address" => trim($info["email_address"]), "groups" => $groups))) {
											if($config[PREF_ERROR_LOGGING] == "yes") {
												@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to send unsubscribe notice to administrator.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
											}
										}
									}

									$TITLE	= $language_pack["success_unsubscribe_title"];
									$MESSAGE	= $language_pack["success_unsubscribe_message"];
								} else {
									$ERROR++;
									$TITLE	= $language_pack["error_default_title"];
									$MESSAGE	= $language_pack["error_unsubscribe_email_not_exists"];

									if($config[PREF_ERROR_LOGGING] == "yes") {
										@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to remove subscriber from the database. They do not appear to be subscribed to the system.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
									}
								}
							}
						} else {
							$ERROR++;
							$TITLE	= $language_pack["error_default_title"];
							$MESSAGE	= $language_pack["error_unsubscribe_no_groups"];

							if($config[PREF_ERROR_LOGGING] == "yes") {
								@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnsubscribe action was confirm but there were no groups specified to unsubscribe from.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
							}
						}
					break;
					default:
						$groups_info = groups_information($groups);

						$TITLE	= $language_pack["page_unsubscribe_title"];

						$MESSAGE	= "<br />\n";
						$MESSAGE .= $language_pack["page_unsubscribe_message_sentence"];
						$MESSAGE .= "<div style=\"height: 5px\">&nbsp;</div>\n";
						$MESSAGE .= "<form action=\"".$config[PREF_PUBLIC_URL].$config[ENDUSER_UNSUB_FILENAME]."\" method=\"get\">\n";
						$MESSAGE .= "<input type=\"hidden\" name=\"action\" value=\"confirm\" />\n";
						$MESSAGE .= "<input type=\"hidden\" name=\"addr\" value=\"".trim($info["email_address"])."\" />\n";
						$MESSAGE .= "<table cellspacing=\"0\" cellpadding=\"2\" border=\"0\">\n";
						foreach($groups_info as $group_id => $group_info) {
							$MESSAGE .= "<tr>\n";
							$MESSAGE .= "	<td><input type=\"checkbox\" name=\"g[]\" value=\"".$group_id."\"".(($groups_requested) ? " checked=\"checked\"" : "")." /></td>";
							$MESSAGE .= "	<td style=\"padding-left: 5px\">".str_replace(array("[email]", "[groupname]"), array(trim($info["email_address"]), $group_info["name"]), $language_pack["page_unsubscribe_list_groups"])."</td>";
							$MESSAGE .= "</tr>\n";
						}
						$MESSAGE .= "<tr>\n";
						$MESSAGE .= "	<td colspan=\"2\" style=\"text-align: right; padding-top: 5px\">\n";
						$MESSAGE .= "		<input type=\"button\" value=\"".$language_pack["page_unsubscribe_cancel_button"]."\" onclick=\"window.location='".$config[PREF_PUBLIC_URL].$config[ENDUSER_HELP_FILENAME]."'\" />\n";
						$MESSAGE .= "		<input type=\"submit\" value=\"".$language_pack["page_unsubscribe_submit_button"]."\" />\n";
						$MESSAGE .= "	</td>\n";
						$MESSAGE .= "</tr>\n";
						$MESSAGE .= "</table>\n";
						$MESSAGE .= "</form>\n";
					break;
				}
			}
		}
	}

	require_once("eu_footer.inc.php");
}
?>