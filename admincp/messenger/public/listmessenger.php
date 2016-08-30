<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: listmessenger.php 107 2007-03-25 19:49:18Z matt.simpson $
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

	if(!$ERROR) {
		// Recognized actions for this file. (subscribe || unsubscribe)
		switch($info["action"]) {
			// SUBSCRIBE
			case "subscribe" :
				// Error checking for group information.
				if(((is_array($info["group_ids"])) && (!count($info["group_ids"]))) || ((!is_array($info["group_ids"])) && (!(int) trim($info["group_ids"])))) {
					$ERROR++;
					$TITLE		= $language_pack["error_default_title"];
					$MESSAGE	= $language_pack["error_subscribe_no_groups"];
				} else {
					$groups = array();

					if(is_array($info["group_ids"])) {
						foreach($info["group_ids"] as $group_id) {
							$query	= "SELECT `group_name` FROM `".TABLES_PREFIX."groups` WHERE `groups_id`='".(int) trim($group_id)."'";
							$result	= $db->GetRow($query);
							if($result) {
								$query	= "SELECT `users_id` FROM `".TABLES_PREFIX."users` WHERE `group_id`='".(int) trim($group_id)."' AND `email_address`='".checkslashes(trim(strtolower($info["email_address"])))."'";
								$result	= $db->GetRow($query);
								if((!$result) && (!@in_array((int) trim($group_id), $groups))) {
									$groups[] = (int) trim($group_id);
								}
							} else {
								$ERROR++;
								$TITLE		= $language_pack["error_default_title"];
								$MESSAGE	= $language_pack["error_subscribe_group_not_found"];
							}
						}
						if((!$ERROR) && (@count($groups) < 1)) {
							$ERROR++;
							$TITLE		= $language_pack["error_default_title"];
							$MESSAGE	= $language_pack["error_subscribe_email_exists"];
						}
					} else {
						if((int) trim($info["group_ids"])) {
							$query	= "SELECT `group_name` FROM `".TABLES_PREFIX."groups` WHERE `groups_id`='".(int) trim($info["group_ids"])."'";
							$result	= $db->GetRow($query);
							if($result) {
								$query	= "SELECT `users_id` FROM `".TABLES_PREFIX."users` WHERE `group_id`='".(int) trim($info["group_ids"])."' AND `email_address`='".checkslashes(trim(strtolower($info["email_address"])))."'";
								$result	= $db->GetRow($query);
								if($result) {
									$ERROR++;
									$TITLE		= $language_pack["error_default_title"];
									$MESSAGE	= $language_pack["error_subscribe_email_exists"];
								} else {
									$groups[] 	= (int) trim($info["group_ids"]);
								}
							} else {
								$ERROR++;
								$TITLE		= $language_pack["error_default_title"];
								$MESSAGE	= $language_pack["error_subscribe_group_not_found"];
							}
						}
					}
				}

				if($config[ENDUSER_CAPTCHA] == "yes") {
					if((!isset($info["captcha_code"])) || (!PhpCaptcha::Validate($info["captcha_code"]))) {
						$ERROR++;
						$TITLE		= $language_pack["error_default_title"];
						$MESSAGE	= $language_pack["error_invalid_captcha"];
					}
				}

				// Error checking for e-mail address information.
				if((!$info["email_address"]) || (trim($info["email_address"]) == "")) {
					$ERROR++;
					$TITLE		= $language_pack["error_default_title"];
					$MESSAGE	= $language_pack["error_subscribe_no_email"];
				} else {
					if(!valid_address(trim($info["email_address"]))) {
						$ERROR++;
						$TITLE		= $language_pack["error_default_title"];
						$MESSAGE	= $language_pack["error_subscribe_invalid_email"];
					} else {
						if(@in_array(trim(strtolower($info["email_address"])), $config[ENDUSER_BANEMAIL])) {
							$ERROR++;
							$TITLE		= $language_pack["error_default_title"];
							$MESSAGE	= $language_pack["error_subscribe_banned_email"];
						} else {
							$address = explode("@", trim(strtolower($info["email_address"])));
							if(@in_array($address[1], $config[ENDUSER_BANDOMS])) {
								$ERROR++;
								$TITLE	= $language_pack["error_default_title"];
								$MESSAGE	= $language_pack["error_subscribe_banned_domain"];
							} else {
								if($config[ENDUSER_MXRECORD] == "yes") {
									if((@getmxrr($address[1].".", $mxhosts) == false) && (@gethostbyname($address[1].".") == $address[1].".")) {
										$ERROR++;
										$TITLE	= $language_pack["error_default_title"];
										$MESSAGE	= $language_pack["error_subscribe_invalid_domain"];
									}
								}
							}
						}
					}
				}

				// Error checking for custom field information.
				$query	= "SELECT `field_sname`, `field_lname`, `field_req` FROM `".TABLES_PREFIX."cfields` ORDER BY `field_order` ASC";
				$results	= $db->GetAll($query);
				if($results) {
					$custom_data	= array();
					foreach($results as $result) {
						$field_completed = true;

						if(isset($info[$result["field_sname"]])) {
							if(@is_array($info[$result["field_sname"]])) {
								if(@count($info[$result["field_sname"]]) > 0) {
									$custom_data[$result["field_sname"]] = checkslashes(html_encode(implode(", ", $info[$result["field_sname"]])));
								} else {
									$field_completed = false;
								}
							} else {
								if(strlen(trim($info[$result["field_sname"]])) > 0) {
									$custom_data[$result["field_sname"]] = checkslashes(html_encode($info[$result["field_sname"]]));
								} else {
									$field_completed = false;
								}
							}
						}  else {
							$field_completed = false;
						}

						if(($result["field_req"] == "1") && (!$field_completed)) {
							$ERROR++;
							$TITLE	= $language_pack["error_default_title"];
							$MESSAGE	= str_replace("[cfield_name]", $result["field_lname"], $language_pack["error_subscribe_required_cfield"]);
						}

					}
				}
				if(!$ERROR) {
					if($config[ENDUSER_SUBCON] == "yes") {
						$result = users_queue(trim($info["email_address"]), html_encode(trim($info["firstname"])), html_encode(trim($info["lastname"])), $groups, $custom_data, "usr-subscribe");
						if($result) {
							@ini_set("sendmail_from", $config[PREF_ERREMAL_ID]);

							$mail			= new LM_Mailer("public");
							$mail->Subject	= $language_pack["subscribe_confirmation_subject"];
							$mail->Body		= str_replace(array("[name]", "[url]", "[abuse_address]", "[from]"), array(checkslashes(trim($info["firstname"]), 1), ($config[PREF_PUBLIC_URL].$config[ENDUSER_CONFIRM_FILENAME]."?id=".$result["confirm_id"]."&code=".$result["hash"]), $config[PREF_ABUEMAL_ID], $config[PREF_FRMNAME_ID]), $language_pack["subscribe_confirmation_message"]);

							if(strlen(trim($info["firstname"])) > 1) {
								$senders_name = checkslashes(trim($info["firstname"]), 1).((strlen(trim($info["lastname"])) > 1) ? " ".checkslashes(trim($info["lastname"]), 1) : "");
							} else {
								$senders_name = trim($info["email_address"]);
							}
							$mail->AddAddress(trim($info["email_address"]), $senders_name);

							if((!@$mail->IsError()) && (@$mail->Send())) {
								$TITLE		= $language_pack["success_subscribe_optin_title"];
								$MESSAGE	= $language_pack["success_subscribe_optin_message"];
							} else {
								$ERROR++;
								$TITLE		= $language_pack["error_default_title"];
								$MESSAGE	= $language_pack["error_subscribe_failed_optin"];

								$query = "DELETE FROM `".TABLES_PREFIX."confirmation` WHERE `confirm_id`='".$result["confirm_id"]."';";
								if(!$db->Execute($query)) {
									if($config[PREF_ERROR_LOGGING] == "yes") {
										@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete the failed confirmation queue request from the confirmation table. Database server said: ".$db->ErrorMsg()."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
									}
								}

								if($config[PREF_ERROR_LOGGING] == "yes") {
									@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to confirmation message to ".$email_address.". LM_Mailer responded: ".$mail->ErrorInfo."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
								}
							}

							if($mail->Mailer == "smtp") $mail->SmtpClose();

							$mail->ClearCustomHeaders();
						} else {
							$ERROR++;
							$TITLE		= $language_pack["error_default_title"];
							$MESSAGE	= $language_pack["error_subscribe_email_exists"];

							if($config[PREF_ERROR_LOGGING] == "yes") {
								@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to add a new subscriber to the confirmation queue. The subscriber is already present in all groups.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
							}
						}
					} else {
						$result = users_add(trim($info["email_address"]), html_encode(trim($info["firstname"])), html_encode(trim($info["lastname"])), $groups, $custom_data, "public");
						if($result) {
							$query	= "INSERT INTO `".TABLES_PREFIX."confirmation` VALUES (NULL, '".time()."', 'usr-subscribe', '".addslashes($_SERVER["REMOTE_ADDR"])."', '".addslashes($_SERVER["HTTP_REFERER"])."', '".addslashes($_SERVER["HTTP_USER_AGENT"])."', '".trim($info["email_address"])."', '".html_encode(trim($info["firstname"]))."', '".html_encode(trim($info["lastname"]))."', '".addslashes(serialize($groups))."', '".addslashes(serialize($custom_data))."', '', '0');";
							$db->Execute($query);

							if($config[ENDUSER_NEWSUBNOTICE] == "yes") {
								if(!send_notice("subscribe", array("email_address" => trim($info["email_address"]), "groups" => $groups))) {
									if($config[PREF_ERROR_LOGGING] == "yes") {
										@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to send new subscriber notice to administrator.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
									}
								}
							}

							if($result["failed"] > 0) {
								$ERROR++;
								$TITLE	= $language_pack["error_default_title"];
								$MESSAGE	= $language_pack["error_subscribe_failed"];
							}
							if($result["success"] > 0) {
								$TITLE	= $language_pack["success_subscribe_title"];
								$MESSAGE	= $language_pack["success_subscribe_message"];
							}
						} else {
							$ERROR++;
							$TITLE	= $language_pack["error_default_title"];
							$MESSAGE	= $language_pack["error_subscribe_email_exists"];

							if($config[PREF_ERROR_LOGGING] == "yes") {
								@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to add a new subscriber to the database. The subscriber is already present in all groups.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
							}
						}
					}
				}
			break;

			// UNSUBSCRIBE
			case "unsubscribe" :
				// Error checking for group information.
				if(((is_array($info["group_ids"])) && (!count($info["group_ids"]))) || ((!is_array($info["group_ids"])) && (!(int) trim($info["group_ids"])))) {
					$ERROR++;
					$TITLE		= $language_pack["error_default_title"];
					$MESSAGE	= $language_pack["error_unsubscribe_no_groups"];
				} else {
					$groups			= array();
					$subscriber_ids	= array();
					if(@is_array($info["group_ids"])) {
						foreach($info["group_ids"] as $group_id) {
							$query	= "SELECT `group_name` FROM `".TABLES_PREFIX."groups` WHERE `groups_id`='".(int) trim($group_id)."'";
							$result	= $db->GetRow($query);
							if($result) {
								$query	= "SELECT `users_id` FROM `".TABLES_PREFIX."users` WHERE `group_id`='".(int) trim($group_id)."' AND `email_address`='".checkslashes(trim(strtolower($info["email_address"])))."'";
								$result	= $db->GetRow($query);
								if(($result) && (!@in_array($result["users_id"], $subscriber_ids))) {
									$subscriber_ids[]	= $result["users_id"];
									$groups[]			= (int) trim($group_id);
								}
							} else {
								$ERROR++;
								$TITLE		= $language_pack["error_default_title"];
								$MESSAGE	= $language_pack["error_unsubscribe_group_not_found"];
							}
						}
						if((!$ERROR) && (@count($subscriber_ids) < 1)) {
							$ERROR++;
							$TITLE		= $language_pack["error_default_title"];
							$MESSAGE	= $language_pack["error_unsubscribe_email_not_exists"];
						}
					} else {
						if((trim($info["group_ids"]) != "") && ((int) trim($info["group_ids"]))) {
							$query	= "SELECT `group_name` FROM `".TABLES_PREFIX."groups` WHERE `groups_id`='".(int) trim($info["group_ids"])."'";
							$result	= $db->GetRow($query);
							if($result) {
								$query	= "SELECT `users_id` FROM `".TABLES_PREFIX."users` WHERE `group_id`='".(int) trim($info["group_ids"])."' AND `email_address`='".checkslashes(trim(strtolower($info["email_address"])))."'";
								$result	= $db->GetRow($query);
								if($result) {
									$subscriber_ids[]	= $result["users_id"];
									$groups[]			= (int) trim($info["group_ids"]);
								} else {
									$ERROR++;
									$TITLE		= $language_pack["error_default_title"];
									$MESSAGE	= $language_pack["error_unsubscribe_email_not_exists"];
								}
							} else {
								$ERROR++;
								$TITLE		= $language_pack["error_default_title"];
								$MESSAGE	= $language_pack["error_unsubscribe_group_not_found"];
							}
						}
					}
				}

				if($config[ENDUSER_CAPTCHA] == "yes") {
					if((!isset($info["captcha_code"])) || (!PhpCaptcha::Validate($info["captcha_code"]))) {
						$ERROR++;
						$TITLE		= $language_pack["error_default_title"];
						$MESSAGE	= $language_pack["error_invalid_captcha"];
					}
				}

				// Error checking for e-mail address information.
				if((!$info["email_address"]) || (trim($info["email_address"]) == "")) {
					$ERROR++;
					$TITLE		= $language_pack["error_default_title"];
					$MESSAGE	= $language_pack["error_unsubscribe_no_email"];
				} else {
					if(!valid_address(trim($info["email_address"]))) {
						$ERROR++;
						$TITLE		= $language_pack["error_default_title"];
						$MESSAGE	= $language_pack["error_unsubscribe_invalid_email"];
					}

					if(!$ERROR) {
						if($config[ENDUSER_UNSUBCON] == "yes") {
							$result = users_queue(trim($info["email_address"]), "", "", $groups, array(), "usr-unsubscribe");
							if($result) {
								$mail			= new LM_Mailer("public");
								$mail->Subject	= $language_pack["unsubscribe_confirmation_subject"];
								$mail->Body		= str_replace(array("[url]", "[abuse_address]", "[from]"), array(($config[PREF_PUBLIC_URL].$config[ENDUSER_CONFIRM_FILENAME]."?id=".$result["confirm_id"]."&code=".$result["hash"]), $config[PREF_ABUEMAL_ID], $config[PREF_FRMNAME_ID]), $language_pack["unsubscribe_confirmation_message"]);

								$mail->AddAddress(trim($info["email_address"]), trim($info["email_address"]));

								if((!@$mail->IsError()) && (@$mail->Send())) {
									$TITLE		= $language_pack["success_unsubscribe_optout_title"];
									$MESSAGE	= $language_pack["success_unsubscribe_optout_message"];
								} else {
									$ERROR++;
									$TITLE		= $language_pack["error_default_title"];
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
							} else {
								$ERROR++;
								$TITLE		= $language_pack["error_default_title"];
								$MESSAGE	= $language_pack["error_unsubscribe_email_not_exists"];

								if($config[PREF_ERROR_LOGGING] == "yes") {
									@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to add a new subscriber to the confirmation queue. The subscriber is already present in all groups.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
								}
							}
						} else {
							$result = subscriber_remove($subscriber_ids, "public");
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
					}
				}
			break;
			default :
				$ERROR++;
				$TITLE		= $language_pack["error_default_title"];
				$MESSAGE	= $language_pack["error_invalid_action"];
			break;
		}
	}

	require_once("eu_footer.inc.php");
}
?>