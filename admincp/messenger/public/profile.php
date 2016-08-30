<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: profile.php 107 2007-03-25 19:49:18Z matt.simpson $

	----

	CREDITS:
	Profile update logic written by James Collins.
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
	$info["email_address"]	= $info["addr"];
	unset($info["addr"]);

	if($config[ENDUSER_PROFILE] =="yes") {
		$TITLE = $language_pack["page_profile_opened_title"];

		if((!isset($info["code"])) && (!isset($info["id"]))) {
			// we are probably doing step 1
			if (strlen($info["email_address"]) == 0) {
				$MESSAGE  = $language_pack["page_profile_instructions"];
				$MESSAGE .= "<div style=\"padding: 15px\">\n";
				$MESSAGE .= "	<form action=\"".$config[PREF_PUBLIC_URL].$config[ENDUSER_PROFILE_FILENAME]."\" method=\"get\">\n";
				$MESSAGE .= "		<label for=\"addr\">".$language_pack["page_profile_email_address"]."</label> <input type=\"text\" id=\"addr\" name=\"addr\" value=\"\" /> <input type=\"submit\" value=\"".$language_pack["page_profile_submit_button"]."\" />\n";
				$MESSAGE .= "	</form>\n";
				$MESSAGE .= "</div>\n";
			} else if(!valid_address(trim($info["email_address"]))) {
				// Invalid Email Address
				$ERROR++;
				$TITLE		= $language_pack["error_default_title"];
				$MESSAGE	= $language_pack["error_unsubscribe_invalid_email"];
			} else {
				// We have a valid email address
				$query	= "SELECT COUNT(*) AS num FROM `".TABLES_PREFIX."users` WHERE `email_address`='".checkslashes(trim($info["email_address"]))."'";
				$result	= $db->GetRow($query);
				if($result) {
					if((int) $result["num"]) {
						$update_id	= 0;

						$insert_array					= array();
						$insert_array["date"]			= time();
						$insert_array["email_address"]	= checkslashes(trim($info["email_address"]));
						$insert_array["completed"]		= 0;
						$insert_array["hash"]			= md5(uniqid(rand(), 1));

						$result = $db->AutoExecute(TABLES_PREFIX."user_updates", $insert_array, "INSERT");
						if(($result) && ($db->Affected_Rows())) {
							$update_id = $db->Insert_Id();
						} else {
							$attempt = 0;
							while(((!$result) || (!$db->Affected_Rows())) && ($attempt < 10)) {
								$attempt++;
								$insert_array["hash"]	= md5(uniqid(rand(), 1));
								$result					= $db->AutoExecute(TABLES_PREFIX."user_updates", $insert_array, "INSERT");
							}

							if(($result) && ($db->Affected_Rows())) {
								$update_id = $db->Insert_Id();
							}
						}

						if($update_id) {
							$query	= "SELECT `firstname`, `lastname` FROM `".TABLES_PREFIX."users` WHERE `email_address`='".checkslashes(trim($info["email_address"]))."'";
							$result	= $db->GetRow($query);
							if($result) {
								$firstname		= $result["firstname"];
								$lastname		= $result["lastname"];

								$mail			= new LM_Mailer("public");
								$mail->Subject	= $language_pack["update_profile_confirmation_subject"];
								$mail->Body		= str_replace(array("[name]", "[url]", "[abuse_address]", "[from]"), array($firstname, ($config[PREF_PUBLIC_URL].$config[ENDUSER_PROFILE_FILENAME]."?id=".$update_id."&code=".$insert_array["hash"]), $config[PREF_ABUEMAL_ID], $config[PREF_FRMNAME_ID]), $language_pack["update_profile_confirmation_message"]);

								if(strlen($firstname . $lastname) > 1) {
									$senders_name = checkslashes(trim($firstname)." ".trim($lastname), 1);
								} else {
									$senders_name = trim($info["email_address"]);
								}
								$mail->AddAddress(trim($info["email_address"]), $senders_name);

								if((!@$mail->IsError()) && (@$mail->Send())) {
									$MESSAGE = $language_pack["page_profile_step1_complete"];
								} else {
									// Error sending the email --> Delete the recent row from the user_updates table.
									if(!$db->Execute("DELETE FROM `" . TABLES_PREFIX . "user_updates` WHERE `updates_id` = ".$db->qstr((int) $update_id))) {
										if($config[PREF_ERROR_LOGGING] == "yes") {
											@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete the failed update profile request from the user_updates table. Database server said: ".$db->ErrorMsg()."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
										}
									}

									$ERROR++;
									$TITLE		= $language_pack["error_default_title"];
									$MESSAGE	= $language_pack["error_update_profile"];

									if($config[PREF_ERROR_LOGGING] == "yes") {
										@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to send profile update e-mail. LM_Mailer responded: ".$mail->ErrorInfo."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
									}
								}

								if($mail->Mailer == "smtp") $mail->SmtpClose();

								$mail->ClearCustomHeaders();
								$mail->ClearAttachments();
							} else {
								$ERROR++;
								$TITLE		= $language_pack["error_default_title"];
								$MESSAGE	= $language_pack["error_update_profile"];
							}
						} else {
							$ERROR++;
							$TITLE		= $language_pack["error_default_title"];
							$MESSAGE	= $language_pack["error_update_profile"];
						}
					} else {
						$ERROR++;
						$TITLE		= $language_pack["error_default_title"];
						$MESSAGE	= $language_pack["error_unsubscribe_email_not_found"];
					}
				} else {
					$ERROR++;
					$TITLE		= $language_pack["error_default_title"];
					$MESSAGE	= $language_pack["error_unsubscribe_email_not_found"];
				}
			}
		} else {
			if(($info["id"] = (int) trim($info["id"])) && (strlen($info["code"]) == 32)) {
				$query	= "SELECT * FROM `".TABLES_PREFIX."user_updates` WHERE `updates_id` = ".$db->qstr($info["id"])." AND `hash` = '".checkslashes(trim($info["code"]))."' LIMIT 1";
				$result	= $db->GetRow($query);
				if($result) {
					if($result["date"] < strtotime("+".(((int) $config[PREF_EXPIRE_CONFIRM]) ? (int) $config[PREF_EXPIRE_CONFIRM] : 7)." days")) {
						if($result["completed"] == 0) {
							$users_ids	= array();
							$query		= "SELECT * FROM `".TABLES_PREFIX."users` WHERE `email_address` = '".checkslashes(trim($result["email_address"]))."'";
							$sresults	= $db->GetAll($query);
							if($sresults) {
								foreach($sresults as $sresult) {
									$users_ids[] = (int) $sresult["users_id"];
								}
							}

							if((is_array($users_ids)) && (count($users_ids))) {
								if((isset($info["action"])) && ($info["action"] == "save")) {
									$query		= "SELECT `field_sname`, `field_lname` FROM `".TABLES_PREFIX."cfields` WHERE `field_req` = '1' ORDER BY `field_order` ASC";
									$results	= $db->GetAll($query);
									if($results) {
										foreach($results as $result) {
											if(!$info["cdata"][$result["field_sname"]]) {
												$ERROR++;
												$ERRORSTR[] = str_replace("[cfield_name]", html_encode($result["field_lname"]), $language_pack["error_subscribe_required_cfield"]);
											}
										}
									}

									if(!$ERROR) {
										$query = "UPDATE `".TABLES_PREFIX."users` SET `firstname` = '".checkslashes(trim($info["firstname"]))."', `lastname` = '".checkslashes(trim($info["lastname"]))."' WHERE `users_id` IN (".implode(", ", $users_ids).")";
										if($db->Execute($query)) {
											if((is_array($info["cdata"])) && (count($info["cdata"]))) {
												foreach($info["cdata"] as $field_sname => $value) {
													if($cfield_id = get_field_id($field_sname)) {
														$query		= "SELECT `cdata_id` FROM `".TABLES_PREFIX."cdata` WHERE `cfield_id` = '".$cfield_id."' AND `user_id` IN (".implode(", ", $users_ids).")";
														$sresults	= $db->GetAll($query);
														if($sresults) {
															foreach($sresults as $sresult) {
																$query	= "UPDATE `".TABLES_PREFIX."cdata` SET `value` = '".checkslashes(trim(((is_array($value)) ? implode(", ", $value) : $value)))."' WHERE `cdata_id` = '".(int) $sresult["cdata_id"]."'";
																if(!$db->Execute($query)) {
																	if($config[PREF_ERROR_LOGGING] == "yes") {
																		@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to update custom field data in the custom field table. [MULTIPLE] Database server said: ".$db->ErrorMsg()."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
																	}
																}
															}
														} else {
															foreach($users_ids as $users_id) {
																$query	= "INSERT INTO `".TABLES_PREFIX."cdata` VALUES (NULL, '".(int) $users_id."', '".(int) $cfield_id."', '".checkslashes(trim(((is_array($value)) ? implode(", ", $value) : $value)))."');";
																if(!$db->Execute($query)) {
																	if($config[PREF_ERROR_LOGGING] == "yes") {
																		@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to insert custom field data in the custom field table during this update. [MULTIPLE] Database server said: ".$db->ErrorMsg()."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
																	}
																}
															}
														}
													} else {
														if($config[PREF_ERROR_LOGGING] == "yes") {
															@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tAn invalid custom field name [".$field_sname."] was passed to the profile.php script. Database said: ".$db->ErrorMsg()."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
														}
													}
												}
											}

											$query = "UPDATE `".TABLES_PREFIX."user_updates` SET `completed` = '1' WHERE `updates_id` = ".(int) trim($info['id']);
											if(!$db->Execute($query)) {
												if($config[PREF_ERROR_LOGGING] == "yes") {
													@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to set the completed flag in the user_updates table. Database server said: ".$db->ErrorMsg()."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
												}
											} else {
												$TITLE		= $language_pack["page_profile_opened_title"];
												$MESSAGE	= $language_pack["page_profile_step2_complete"];
											}
										} else {
											$ERROR++;
											$ERRORSTR[] = $language_pack["error_confirm_unable_request"];

											if($config[PREF_ERROR_LOGGING] == "yes") {
												@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to update subscriber data in group ".$group_name.". Database server said: ".$db->ErrorMsg()."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
											}
										}
									}
								} else {
									$TITLE		= $language_pack["page_profile_opened_title"];
									$MESSAGE	= $language_pack["page_profile_step2_instructions"];

									$query		= "SELECT * FROM `".TABLES_PREFIX."users` WHERE `users_id` IN (".implode(", ", $users_ids).") LIMIT 1";
									$userData	= $db->GetRow($query);
									if($userData) {
										$MESSAGE .= "<div style=\"width: 60%; padding: 15px\">";
										$MESSAGE .= "	<form action=\"".$config[PREF_PUBLIC_URL].$config[ENDUSER_PROFILE_FILENAME]."\" method=\"post\">\n";
										$MESSAGE .= "	<input type=\"hidden\" name=\"id\" value=\"".html_encode($info["id"])."\" />\n";
										$MESSAGE .= "	<input type=\"hidden\" name=\"code\" value=\"".html_encode($info["code"])."\" />\n";
										$MESSAGE .= "	<input type=\"hidden\" name=\"action\" value=\"save\" />\n";
										$MESSAGE .= "	<table style=\"width: 100%\" cellspacing=\"0\" cellpadding=\"2\" border=\"0\">\n";
										$MESSAGE .= "	<colgroup>\n";
										$MESSAGE .= "		<col style=\"width: 35%\" />\n";
										$MESSAGE .= "		<col style=\"width: 65%\" />\n";
										$MESSAGE .= "	</colgroup>\n";
										$MESSAGE .= "	<tbody>\n";
										$MESSAGE .= "		<tr>\n";
										$MESSAGE .= "			<td>".$language_pack["page_profile_email_address"]."</td>\n";
										$MESSAGE .= "			<td><strong>".html_encode($userData["email_address"])."</strong></td>\n";
										$MESSAGE .= "		</tr>\n";
										$MESSAGE .= "		<tr>\n";
										$MESSAGE .= "			<td><label for=\"firstname\">".$language_pack["page_confirm_firstname"]."</label></td>\n";
										$MESSAGE .= "			<td><input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"".html_encode(((isset($info["firstname"])) ? checkslashes($info["firstname"], 1) : $userData["firstname"]))."\" /></td>\n";
										$MESSAGE .= "		</tr>\n";
										$MESSAGE .= "		<tr>\n";
										$MESSAGE .= "			<td><label for=\"lastname\">".$language_pack["page_confirm_lastname"]."</label></td>\n";
										$MESSAGE .= "			<td><input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"".html_encode(((isset($info["lastname"])) ? checkslashes($info["lastname"], 1) : $userData["lastname"]))."\" /></td>\n";
										$MESSAGE .= "		</tr>\n";
										$MESSAGE .= "		<tr>\n";
										$MESSAGE .= "			<td colspan=\"2\">&nbsp;</td>\n";
										$MESSAGE .= "		</tr>\n";

										$query		= "SELECT * FROM `".TABLES_PREFIX."cfields` ORDER BY `field_order` ASC";
										$results	= $db->GetAll($query);
										if($results) {
											foreach($results as $result) {
												$squery	= "SELECT * FROM `".TABLES_PREFIX."cdata` WHERE `user_id` = '".checkslashes(trim($userData["users_id"]))."' AND `cfield_id` = '".(int) $result["cfields_id"]."'";
												$cdata	= $db->GetRow($squery);

												$MESSAGE .= "<tr>\n";
												$MESSAGE .= "	<td style=\"vertical-align: top; ".(($result["field_req"] == 1) ? " color: #CC0000" : "")."\">".(($result["field_lname"]) ? html_encode(checkslashes($result["field_lname"], 1)) : "&nbsp;")."</td>\n";
												$MESSAGE .= "	<td>\n";
												switch($result["field_type"]) {
													case "checkbox" :
														if($result["field_options"] != "") {
															$options	= explode("\n", $result["field_options"]);
															$values		= ((isset($cdata["value"])) ? explode(", ", $cdata["value"]) : array());
															foreach($options as $option) {
																$pieces = explode("=", $option);
																$MESSAGE .= "<input type=\"checkbox\" id=\"cdata_".$result["field_sname"]."_".html_encode($pieces[0])."\" name=\"cdata[".$result["field_sname"]."][]\" value=\"".html_encode($pieces[0])."\"".((@in_array($pieces[0], ((is_array($info["cdata"][$result["field_sname"]])) ? $info["cdata"][$result["field_sname"]] : $values))) ? " checked=\"checked\"" : "")."> ".html_encode($pieces[1])."<br />\n";
															}
														}
													break;
													case "radio" :
														if($result["field_options"] != "") {
															$options = explode("\n", $result["field_options"]);
															foreach($options as $option) {
																$pieces = explode("=", $option);
																$MESSAGE .= "<input type=\"radio\" id=\"cdata_".$result["field_sname"]."_".html_encode($pieces[0])."\" name=\"cdata[".$result["field_sname"]."]\" value=\"".html_encode($pieces[0])."\"".((((isset($info["cdata"][$result["field_sname"]])) ? $info["cdata"][$result["field_sname"]] : $cdata["value"]) == $pieces[0]) ? " checked=\"checked\"" : "")."> ".html_encode($pieces[1])."<br />\n";
															}
														}
													break;
													case "select" :
														if($result["field_options"] != "") {
															$options = explode("\n", $result["field_options"]);
															$MESSAGE .= "<select id=\"cdata_".$result["field_sname"]."\" name=\"cdata[".$result["field_sname"]."]\">\n";
															foreach($options as $option) {
																$pieces = explode("=", $option);
																$MESSAGE .= "<option value=\"".html_encode($pieces[0])."\"".((((isset($info["cdata"][$result["field_sname"]])) ? $info["cdata"][$result["field_sname"]] : $cdata["value"]) == $pieces[0]) ? " selected=\"selected\"" : "").">".html_encode($pieces[1])."</option>\n";
															}
															$MESSAGE .= "</select>\n";
														}
													break;
													case "textarea" :
														$MESSAGE .= "<textarea id=\"cdata_".$result["field_sname"]."\" name=\"cdata[".$result["field_sname"]."]\" style=\"width: 98%; height: 75px\">".html_encode(((isset($info["cdata"][$result["field_sname"]])) ? $info["cdata"][$result["field_sname"]] : $cdata["value"]))."</textarea>\n";
													break;
													case "textbox" :
														$MESSAGE .= "<input type=\"text\" id=\"cdata_".$result["field_sname"]."\" name=\"cdata[".$result["field_sname"]."]\" value=\"".html_encode(((isset($info["cdata"][$result["field_sname"]])) ? $info["cdata"][$result["field_sname"]] : $cdata["value"]))."\"  maxlength=\"".(((int) $result["field_length"]) ? (int) $result["field_length"] : "12")."\" />\n";
													break;
													default :
														$MESSAGE .= "&nbsp;";
													break;
												}
												$MESSAGE .= "	</td>\n";
												$MESSAGE .= "</tr>\n";
											}
										}
										$MESSAGE .= "	<tr>\n";
										$MESSAGE .= "		<td colspan=\"2\">&nbsp;</td>\n";
										$MESSAGE .= "	</tr>\n";
										$MESSAGE .= "	<tr>\n";
										$MESSAGE .= "		<td colspan=\"2\" style=\"border-top: 1px #333333 dotted; padding-top: 5px; text-align: right\">\n";
										$MESSAGE .= "			<input type=\"button\" value=\"".(($SUCCESS) ? $language_pack["page_profile_close_button"] : $language_pack["page_profile_cancel_button"])."\" class=\"button\" onclick=\"window.location='".$config[PREF_PUBLIC_URL].$config[ENDUSER_HELP_FILENAME]."'\" />\n";
										$MESSAGE .= "			<input type=\"submit\" value=\"".$language_pack["page_profile_update_button"]."\" class=\"button\" />\n";
										$MESSAGE .= "		</td>\n";
										$MESSAGE .= "	</tr>\n";
										$MESSAGE .= "</tbody>\n";
										$MESSAGE .= "</table>\n";
										$MESSAGE .= "</form>\n";
									} else {
										$TITLE		= $language_pack["error_default_title"];
										$MESSAGE	= $language_pack["error_unsubscribe_email_not_found"];
									}
								}
							} else {
								$TITLE		= $language_pack["error_default_title"];
								$MESSAGE	= $language_pack["error_confirm_invalid_request"];
							}
						} else {
							$TITLE		= $language_pack["error_default_title"];
							$MESSAGE	= $language_pack["error_confirm_completed"];
						}
					} else {
						$TITLE		= $language_pack["error_default_title"];
						$MESSAGE	= $language_pack["error_expired_code"];
					}
				} else {
					$TITLE		= $language_pack["error_default_title"];
					$MESSAGE	= $language_pack["error_confirm_invalid_request"];
				}
			} else {
				$TITLE		= $language_pack["error_default_title"];
				$MESSAGE	= $language_pack["error_confirm_invalid_request"];
			}
		}
	} else {
		$abuse		= encode_address($config[PREF_ABUEMAL_ID]);
		$TITLE		= $language_pack["page_profile_closed_title"];
		$MESSAGE	= $language_pack["page_profile_closed_message_sentence"];
		$MESSAGE	= str_replace("[abuse_address]", "<a href=\"mailto:".$abuse["address"]."\" style=\"font-weight: strong\">".$abuse["text"]."</a>", $MESSAGE);
	}

	require_once("eu_footer.inc.php");
}
?>