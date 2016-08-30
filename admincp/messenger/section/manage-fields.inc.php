<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: manage-fields.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

if(!defined("PARENT_LOADED"))		exit;
if(!$_SESSION["isAuthenticated"])	exit;

$i = count($SIDEBAR);
$SIDEBAR[$i]  = "<table style=\"width: 100%\" cellspacing=\"0\" cellpadding=\"1\" border=\"0\">\n";
$SIDEBAR[$i] .= "<tr>\n";
$SIDEBAR[$i] .= "	<td><img src=\"./images/icon-man-users.gif\" width=\"16\" height=\"16\" alt=\"Manage Users\" title=\"Manage Users\" /></td>\n";
$SIDEBAR[$i] .= "	<td><a href=\"index.php?section=subscribers&action=add\">Add Subscriber</a></td>\n";
$SIDEBAR[$i] .= "</tr>\n";
$SIDEBAR[$i] .= "<tr>\n";
$SIDEBAR[$i] .= "	<td><img src=\"./images/icon-del-users.gif\" width=\"16\" height=\"16\" alt=\"Bulk Removal Tool\" title=\"Bulk Removal Tool\" /></td>\n";
$SIDEBAR[$i] .= "	<td><a href=\"index.php?section=subscribers&action=bulkremoval\" style=\"white-space: nowrap\">Bulk Removal Tool</a></td>\n";
$SIDEBAR[$i] .= "</tr>\n";
$SIDEBAR[$i] .= "<tr>\n";
$SIDEBAR[$i] .= "	<td><img src=\"./images/icon-man-groups.gif\" width=\"16\" height=\"16\" alt=\"Manage Groups\" title=\"Manage Groups\" /></td>\n";
$SIDEBAR[$i] .= "	<td><a href=\"index.php?section=manage-groups\">Manage Groups</a></td>\n";
$SIDEBAR[$i] .= "</tr>\n";
$SIDEBAR[$i] .= "<tr>\n";
$SIDEBAR[$i] .= "	<td><img src=\"./images/icon-man-fields.gif\" width=\"16\" height=\"16\" alt=\"Manage Fields\" title=\"Manage Fields\" /></td>\n";
$SIDEBAR[$i] .= "	<td><a href=\"index.php?section=manage-fields\">Manage Fields</a></td>\n";
$SIDEBAR[$i] .= "</tr>\n";
$SIDEBAR[$i] .= "</table>\n";

$ACTION = false;

if(strlen($_GET["action"]) > 0) {
	$ACTION = checkslashes($_GET["action"]);
} else {
	$ACTION = checkslashes($_POST["action"]);
}

switch($ACTION) {
	case "add" :
		if($_POST) {
			if(strlen(trim($_POST["field_type"])) < 1) {
				$ERROR++;
				$ERRORSTR[] = "You did not select what type of field this new field will be.";
			} else {
				switch($_POST["field_type"]) {
					case "checkbox" :
						if(strlen(trim($_POST["field_sname"])) < 1) {
							$ERROR++;
							$ERRORSTR[] = "A &quot;Field Short Name&quot; is required when the field type is a checkbox. This will be the HTML name attribute in the form, so make this lowercase and no special characters/spaces.";
						} else {
							$varcheck = check_variable($_POST["field_sname"]);
							if(!$varcheck[0]) {
								$ERROR++;
								$ERRORSTR[] = $varcheck[1];
							} else {
								if($_POST["field_sname"] != $varcheck[1]) {
									$_POST["field_sname"] = $varcheck[1];
								}
							}
						}
						if(strlen(trim($_POST["field_options"])) < 1) {
							$ERROR++;
							$ERRORSTR[] = "&quot;Field Options&quot; are required when the field type is a checkbox. This is how the program generates the checkboxs. Use the following as an example:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
						} else {
							$fix_lf	= str_replace("\r", "\n", trim($_POST["field_options"]));
							$fix_lf	= str_replace("\n\n", "\n", $fix_lf);
							$options	= explode("\n", $fix_lf);
							if(@count($options) < 1) {
								$ERROR++;
								$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this checkbox. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
							} else {
								foreach($options as $option) {
									$pieces = explode("=", $option);
									if(@count($pieces) < 1) {
										$ERROR++;
										$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this checkbox. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
									} else {
										if(strlen(trim($pieces[0])) < 1) {
											$ERROR++;
											$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this checkbox. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
										} else {
											if(strlen(trim($pieces[1])) < 1) {
												$ERROR++;
												$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this checkbox. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />;black=Black Ball";
											}
										}
									}
								}
							}
						}
					break;
					case "hidden" :
						if(strlen(trim($_POST["field_sname"])) < 1) {
							$ERROR++;
							$ERRORSTR[] = "A &quot;Field Short Name&quot; is required when the field type is a hidden field. This will be the HTML name attribute in the form.";
						} else {
							$varcheck = check_variable($_POST["field_sname"]);
							if(!$varcheck[0]) {
								$ERROR++;
								$ERRORSTR[] = $varcheck[1];
							} else {
								if($_POST["field_sname"] != $varcheck[1]) {
									$_POST["field_sname"] = $varcheck[1];
								}
							}
						}
						if(strlen(trim($_POST["field_options"])) < 1) {
							$ERROR++;
							$ERRORSTR[] = "&quot;Field Options&quot; are required when the field type is a hidden field. This will be the hidden fields HTML value attribute in the form.";
						}
					break;
					case "linebreak" :
					break;
					case "radio" :
						if(strlen(trim($_POST["field_sname"])) < 1) {
							$ERROR++;
							$ERRORSTR[] = "A &quot;Field Short Name&quot; is required when the field type is a radio box. This will be the HTML name attribute in the form, so make this lowercase and no special characters/spaces.";
						} else {
							$varcheck = check_variable($_POST["field_sname"]);
							if(!$varcheck[0]) {
								$ERROR++;
								$ERRORSTR[] = $varcheck[1];
							} else {
								if($_POST["field_sname"] != $varcheck[1]) {
									$_POST["field_sname"] = $varcheck[1];
								}
							}
						}
						if(strlen(trim($_POST["field_options"])) < 1) {
							$ERROR++;
							$ERRORSTR[] = "&quot;Field Options&quot; are required when the field type is a radio box. This is how the program generates the radio boxes. Use the following as an example:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
						} else {
							$fix_lf	= str_replace("\r", "\n", trim($_POST["field_options"]));
							$fix_lf	= str_replace("\n\n", "\n", $fix_lf);
							$options	= explode("\n", $fix_lf);
							if(@count($options) < 1) {
								$ERROR++;
								$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this radio box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
							} else {
								foreach($options as $option) {
									$pieces = explode("=", $option);
									if(@count($pieces) < 1) {
										$ERROR++;
										$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this radio box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
									} else {
										if(strlen(trim($pieces[0])) < 1) {
											$ERROR++;
											$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this radio box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
										} else {
											if(strlen(trim($pieces[1])) < 1) {
												$ERROR++;
												$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this radio box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
											}
										}
									}
								}
							}
						}
					break;
					case "select" :
						if(strlen(trim($_POST["field_sname"])) < 1) {
							$ERROR++;
							$ERRORSTR[] = "A &quot;Field Short Name&quot; is required when the field type is a select box. This will be the HTML name attribute in the form, so make this lowercase and no special characters/spaces.";
						} else {
							$varcheck = check_variable($_POST["field_sname"]);
							if(!$varcheck[0]) {
								$ERROR++;
								$ERRORSTR[] = $varcheck[1];
							} else {
								if($_POST["field_sname"] != $varcheck[1]) {
									$_POST["field_sname"] = $varcheck[1];
								}
							}
						}
						if(strlen(trim($_POST["field_options"])) < 1) {
							$ERROR++;
							$ERRORSTR[] = "&quot;Field Options&quot; are required when the field type is a select box. This is how the program generates the HTML select options. Use the following as an example:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
						} else {
							$fix_lf	= str_replace("\r", "\n", trim($_POST["field_options"]));
							$fix_lf	= str_replace("\n\n", "\n", $fix_lf);
							$options	= explode("\n", $fix_lf);
							if(@count($options) < 1) {
								$ERROR++;
								$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this select box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
							} else {
								foreach($options as $option) {
									$pieces = explode("=", $option);
									if(@count($pieces) < 1) {
										$ERROR++;
										$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this select box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
									} else {
										if(strlen(trim($pieces[0])) < 1) {
											$ERROR++;
											$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this select box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
										} else {
											if(strlen(trim($pieces[1])) < 1) {
												$ERROR++;
												$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this select box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
											}
										}
									}
								}
							}
						}
					break;
					case "textarea" :
						if(strlen(trim($_POST["field_sname"])) < 1) {
							$ERROR++;
							$ERRORSTR[] = "A &quot;Field Short Name&quot; is required when the field type is a textarea. This will be the HTML name attribute in the form, so make this lowercase and no special characters/spaces.";
						} else {
							$varcheck = check_variable($_POST["field_sname"]);
							if(!$varcheck[0]) {
								$ERROR++;
								$ERRORSTR[] = $varcheck[1];
							} else {
								if($_POST["field_sname"] != $varcheck[1]) {
									$_POST["field_sname"] = $varcheck[1];
								}
							}
						}
					break;
					case "textbox" :
						if(strlen(trim($_POST["field_sname"])) < 1) {
							$ERROR++;
							$ERRORSTR[] = "A &quot;Field Short Name&quot; is required when the field type is a text box. This will be the HTML name attribute in the form, so make this lowercase and no special characters/spaces.";
						} else {
							$varcheck = check_variable($_POST["field_sname"]);
							if(!$varcheck[0]) {
								$ERROR++;
								$ERRORSTR[] = $varcheck[1];
							} else {
								if($_POST["field_sname"] != $varcheck[1]) {
									$_POST["field_sname"] = $varcheck[1];
								}
							}
						}
					break;
				}

				if(!$ERROR) {
					$query	= "SELECT MAX(`field_order`) AS `max` FROM `".TABLES_PREFIX."cfields`";
					$result	= $db->GetRow($query);
					if($result) {
						$max = $result["max"]+1;
					} else {
						$max = 1;
					}
					$query = "INSERT INTO `".TABLES_PREFIX."cfields` (`cfields_id`, `field_type`, `field_options`, `field_sname`, `field_lname`, `field_length`, `field_req`, `field_order`) VALUES (NULL, '".checkslashes($_POST["field_type"])."', '".checkslashes(trim($_POST["field_options"]))."', '".checkslashes($_POST["field_sname"])."', '".checkslashes($_POST["field_lname"])."', '".checkslashes($_POST["field_length"])."', '".checkslashes($_POST["field_req"])."', '".$max."');";
					if($db->Execute($query)) {
						header("Location: index.php?section=manage-fields");
						exit;
					} else {
						if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
							@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to add field to database. Database said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
						}

						$ERROR++;
						$ERRORSTR[] = "Sorry, but we were unable to add the new field due to a database error. Please check your ListMessenger error_log for more information if you have logging enabled.";
					}
				}
			}
		}
		?>
		<h1>New Field</h1>
		After you add this custom field, don't forget that you will need to update the HTML on your web-page so that your users can fill in the new field information.
		<br /><br />
		<?= (($ERROR > 0) ? display_error($ERRORSTR) : "") ?>
		<form action="index.php?section=manage-fields&action=add" method="post">
		<table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
		<tr>
			<td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Field Type</em></strong><br />This is the type of custom field that you are looking at adding. Currently you can select a number of different HTML field types as well as a linebreak.<br /><br /><strong>Example:</strong><br />&quot;Radio Buttons&quot;'));">Field Type:</span></td>
			<td>
				<select name="field_type" style="width: 129px">
				<option value="checkbox"<?= (($_POST["field_type"] == "checkbox") ? " selected=\"selected\"" : "") ?>>Checkbox</option>
				<option value="hidden"<?= (($_POST["field_type"] == "hidden") ? " selected=\"selected\"" : "") ?>>Hidden Field</option>
				<option value="linebreak"<?= (($_POST["field_type"] == "linebreak") ? " selected=\"selected\"" : "") ?>>Linebreak</option>
				<option value="radio"<?= (($_POST["field_type"] == "radio") ? " selected=\"selected\"" : "") ?>>Radio Buttons</option>
				<option value="select"<?= (($_POST["field_type"] == "select") ? " selected=\"selected\"" : "") ?>>Select Box</option>
				<option value="textarea"<?= (($_POST["field_type"] == "textarea") ? " selected=\"selected\"" : "") ?>>Textarea</option>
				<option value="textbox"<?= (($_POST["field_type"] == "textbox") ? " selected=\"selected\"" : "") ?>>Textbox</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Field Short Name</em></strong><br />This is a short name for the field that must be all lowercase, all one word and no special characters. This field must also be unique because it is what you will use to call this field in a custom e-mail variable!<br /><br /><strong>Example:</strong><br />&quot;favcolour&quot;'));">Field Short Name:</span><br /><span class="small-grey">(should be all lower case, one word; no spaces or strange characters)</span></td>
			<td><input type="text" class="text-box" style="width: 125px" name="field_sname" value="<?= checkslashes($_POST["field_sname"], 1) ?>" maxlength="16" /></td>
		</tr>
		<tr>
			<td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Display Name</em></strong><br />This is the title or longer name for your custom field. This could also be a question.<br /><br /><strong>Example:</strong><br />&quot;What is your favourite colour?&quot;'));">Field Display Name:</span></td>
			<td><input type="text" class="text-box" style="width: 360px" name="field_lname" value="<?= checkslashes($_POST["field_lname"], 1) ?>" maxlength="64"/></td>
		</tr>
		<tr>
			<td class="form-row-nreq" style="vertical-align: top"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Field Options</em></strong><br />This is the options or defined value(s) of your custom field. If you are using a checkbox, radio button or select box you will want to specify your options here.<br /><br /><strong>Example:</strong><br />blue=Blue<br />red=Red<br />green=Green'));">Field Options:</span><br /><span class="small-grey">(required for radio buttons, select boxes, check boxes and hidden field valued only.)</span></td>
			<td><textarea name="field_options" style="width: 360px; height: 125px"><?= checkslashes($_POST["field_options"], 1) ?></textarea></td>
		</tr>
		<tr>
			<td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Maxlength</em></strong><br />This is only used if your Field Type is a textbox. This will limit the subscriber to typing X number of characters in your textbox.<br /><br /><strong>Example:</strong><br />&quot;64&quot;'));">Maxlength:</span><br /><span class="small-grey">(used only for text boxes)</span></td>
			<td><input type="text" class="text-box" style="width: 50px" name="field_length" value="<?= checkslashes($_POST["field_length"], 1) ?>" maxlength="12" /></td>
		</tr>
		<tr>
			<td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Required Field</em></strong><br />Specify whether you want this custom field to be a required field or you can have it set to be optional.'));">Required Field:</span><br /><span class="small-grey">(is this field required when users sign-up?)</span></td>
			<td>
				<select name="field_req" style="width: 54px">
				<option value="1"<?= (($_POST["field_req"] == "1") ? " selected=\"selected\"" : "") ?>>Yes</option>
				<option value="0"<?= (($_POST["field_req"] == "0") ? " selected=\"selected\"" : "") ?>>No</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
				<input type="button" value="Cancel" class="button" onclick="window.location='index.php?section=manage-fields'" />
				<input type="submit" value="Add Field" class="button" />
			</td>
		</tr>
		</table>
		</form>
		<?php
	break;
	case "delete" :
		if(strlen($_GET["id"]) < 1) {
			$ERROR++;
			$ERRORSTR[] = "There was no custom field ID provided to delete.";
			echo (($ERROR > 0) ? display_error($ERRORSTR) : "");
			if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
				@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tThere was no custom field ID provided to delete.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
			}
		} else {
			if($_POST["confirmed"] == "true") {
				if($_POST["cfields_id"] != $_GET["id"]) {
					$ERROR++;
					$ERRORSTR[] = "The field ID in the URL does not match the posted field ID.";
				}

				if($ERROR) {
					echo display_error($ERRORSTR);
				} else {
					$query = "DELETE FROM `".TABLES_PREFIX."cfields` WHERE `cfields_id`='".checkslashes($_POST["cfields_id"])."'";
					if(!$db->Execute($query)) {
						$ERROR++;
						$ERRORSTR[] = "Unable to delete the custom field from the custom fields table. Please check the error_log for more information.";
						if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
							@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete the custom field from the custom fields table. MySQL reported: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
						}
					} else {
						$query = "DELETE FROM `".TABLES_PREFIX."cdata` WHERE `cfield_id`='".checkslashes($_POST["cfields_id"])."'";
						if(!$db->Execute($query)) {
							$ERROR++;
							$ERRORSTR[] = "Unable to delete the custom field data from the users table. Please check the error_log for more information.";
							if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
								@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete the custom field data from the users table. MySQL reported: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
							}
						}
					}

					if($ERROR) {
						echo display_error($ERRORSTR);
					} else {
						header("Location: index.php?section=manage-fields");
						exit;
					}
				}
			} else {
				?>
				<h1>Deleting Custom Field</h1>
				<?php echo (($ERROR > 0) ? display_error($ERRORSTR) : ""); ?>
				Please confirm that you wish to delete the following custom field. Please note that if you delete this custom field, it will remove all pertaining custom user data as well.
				<br /><br />
				<div style="border-bottom: 1px #CC0000 dotted; padding: 3px; margin: 3px">
				<?php echo generate_cfields("", "display", checkslashes($_GET["id"])); ?>
				</div>
				<span class="small-grey" style="color: #CC0000">*</span> <span class="small-grey">If you are deleting a <strong>linebreak</strong> or <strong>hidden field</strong>, you will not see anything above.</span>
				<br /><br />
				<form action="index.php?section=manage-fields&action=delete&id=<?php echo checkslashes($_GET["id"]); ?>" method="post">
				<input type="hidden" name="confirmed" value="true" />
				<input type="hidden" name="cfields_id" value="<?php echo checkslashes($_GET["id"]); ?>" />
				<table style="width: 100%" cellspacing="0" cellpadding="3" border="0">
				<tr>
					<td style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
						<input type="button" value="Cancel" class="button" onclick="window.location='index.php?section=manage-fields'" />
						<input type="submit" value="Confirm" class="button" />
					</td>
				</tr>
				</table>
				</form>
				<?php
			}
		}
	break;
	case "edit" :
		if(strlen($_GET["id"]) < 1) {
			$ERROR++;
			$ERRORSTR[] = "There was no custom field ID provided to edit.";
			echo (($ERROR > 0) ? display_error($ERRORSTR) : "");
			if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
				@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tThere was no custom field ID provided to edit.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
			}
		} else {
			$query	= "SELECT * FROM `".TABLES_PREFIX."cfields` WHERE `cfields_id`='".checkslashes($_GET["id"])."'";
			$result	= $db->GetRow($query);
			if($result) {
				if($_POST) {
					if($_POST["cfields_id"] != $_GET["id"]) {
						$ERROR++;
						$ERRORSTR[] = "The field ID in the URL does not match the posted field ID.";
					}
					if(strlen(trim($_POST["field_type"])) < 1) {
						$ERROR++;
						$ERRORSTR[] = "You did not select what type of field this new field will be.";
					} else {
						switch($_POST["field_type"]) {
							case "checkbox" :
								if(strlen(trim($_POST["field_sname"])) < 1) {
									$ERROR++;
									$ERRORSTR[] = "A &quot;Field Short Name&quot; is required when the field type is a checkbox. This will be the HTML name attribute in the form, so make this lowercase and no special characters/spaces.";
								} else {
									$varcheck = check_variable(checkslashes($_POST["field_sname"]), true);
									if(!$varcheck[0]) {
										$ERROR++;
										$ERRORSTR[] = $varcheck[1];
									} else {
										if($_POST["field_sname"] != $varcheck[1]) {
											$_POST["field_sname"] = $varcheck[1];
										}
									}
								}
								if(strlen(trim($_POST["field_options"])) < 1) {
									$ERROR++;
									$ERRORSTR[] = "&quot;Field Options&quot; are required when the field type is a checkbox. This is how the program generates the checkboxs. Use the following as an example:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
								} else {
									$fix_lf	= str_replace("\r", "\n", trim($_POST["field_options"]));
									$fix_lf	= str_replace("\n\n", "\n", $fix_lf);
									$options	= explode("\n", $fix_lf);
									if(@count($options) < 1) {
										$ERROR++;
										$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this checkbox. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
									} else {
										foreach($options as $option) {
											$pieces = explode("=", $option);
											if(@count($pieces) < 1) {
												$ERROR++;
												$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this checkbox. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
											} else {
												if(strlen(trim($pieces[0])) < 1) {
													$ERROR++;
													$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this checkbox. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
												} else {
													if(strlen(trim($pieces[1])) < 1) {
														$ERROR++;
														$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this checkbox. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
													}
												}
											}
										}
									}
								}
							break;
							case "hidden" :
								if(strlen(trim($_POST["field_sname"])) < 1) {
									$ERROR++;
									$ERRORSTR[] = "A &quot;Field Short Name&quot; is required when the field type is a hidden field. This will be the HTML name attribute in the form.";
								} else {
									$varcheck = check_variable($_POST["field_sname"], true);
									if(!$varcheck[0]) {
										$ERROR++;
										$ERRORSTR[] = $varcheck[1];
									} else {
										if($_POST["field_sname"] != $varcheck[1]) {
											$_POST["field_sname"] = $varcheck[1];
										}
									}
								}
								if(strlen(trim($_POST["field_options"])) < 1) {
									$ERROR++;
									$ERRORSTR[] = "&quot;Field Options&quot; are required when the field type is a hidden field. This will be the hidden fields HTML value attribute in the form.";
								}
							break;
							case "linebreak" :
							break;
							case "radio" :
								if(strlen(trim($_POST["field_sname"])) < 1) {
									$ERROR++;
									$ERRORSTR[] = "A &quot;Field Short Name&quot; is required when the field type is a radio box. This will be the HTML name attribute in the form, so make this lowercase and no special characters/spaces.";
								} else {
									$varcheck = check_variable($_POST["field_sname"], true);
									if(!$varcheck[0]) {
										$ERROR++;
										$ERRORSTR[] = $varcheck[1];
									} else {
										if($_POST["field_sname"] != $varcheck[1]) {
											$_POST["field_sname"] = $varcheck[1];
										}
									}
								}
								if(strlen(trim($_POST["field_options"])) < 1) {
									$ERROR++;
									$ERRORSTR[] = "&quot;Field Options&quot; are required when the field type is a radio box. This is how the program generates the radio boxes. Use the following as an example:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
								} else {
									$fix_lf	= str_replace("\r", "\n", trim($_POST["field_options"]));
									$fix_lf	= str_replace("\n\n", "\n", $fix_lf);
									$options	= explode("\n", $fix_lf);
									if(@count($options) < 1) {
										$ERROR++;
										$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this radio box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
									} else {
										foreach($options as $option) {
											$pieces = explode("=", $option);
											if(@count($pieces) < 1) {
												$ERROR++;
												$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this radio box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
											} else {
												if(strlen(trim($pieces[0])) < 1) {
													$ERROR++;
													$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this radio box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
												} else {
													if(strlen(trim($pieces[1])) < 1) {
														$ERROR++;
														$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this radio box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
													}
												}
											}
										}
									}
								}
							break;
							case "select" :
								if(strlen(trim($_POST["field_sname"])) < 1) {
									$ERROR++;
									$ERRORSTR[] = "A &quot;Field Short Name&quot; is required when the field type is a select box. This will be the HTML name attribute in the form, so make this lowercase and no special characters/spaces.";
								} else {
									$varcheck = check_variable($_POST["field_sname"], true);
									if(!$varcheck[0]) {
										$ERROR++;
										$ERRORSTR[] = $varcheck[1];
									} else {
										if($_POST["field_sname"] != $varcheck[1]) {
											$_POST["field_sname"] = $varcheck[1];
										}
									}
								}
								if(strlen(trim($_POST["field_options"])) < 1) {
									$ERROR++;
									$ERRORSTR[] = "&quot;Field Options&quot; are required when the field type is a select box. This is how the program generates the HTML select options. Use the following as an example:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
								} else {
									$fix_lf	= str_replace("\r", "\n", trim($_POST["field_options"]));
									$fix_lf	= str_replace("\n\n", "\n", $fix_lf);
									$options	= explode("\n", $fix_lf);

									if(@count($options) < 1) {
										$ERROR++;
										$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this select box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
									} else {
										foreach($options as $option) {
											$pieces	= explode("=", $option);
											if(@count($pieces) < 1) {
												$ERROR++;
												$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this select box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
											} else {
												if(strlen(trim($pieces[0])) < 1) {
													$ERROR++;
													$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this select box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
												} else {
													if(strlen(trim($pieces[1])) < 1) {
														$ERROR++;
														$ERRORSTR[] = "It looks as though you've formatted &quot;Field Options&quot; incorrectly for this select box. Use the following as an example of proper usage:<br />blue=Blue Ball<br />red=Red Ball<br />yellow=Yellow Ball<br />black=Black Ball";
													}
												}
											}
										}
									}
								}
							break;
							case "textarea" :
								if(strlen(trim($_POST["field_sname"])) < 1) {
									$ERROR++;
									$ERRORSTR[] = "A &quot;Field Short Name&quot; is required when the field type is a textarea. This will be the HTML name attribute in the form, so make this lowercase and no special characters/spaces.";
								} else {
									$varcheck = check_variable($_POST["field_sname"], true);
									if(!$varcheck[0]) {
										$ERROR++;
										$ERRORSTR[] = $varcheck[1];
									} else {
										if($_POST["field_sname"] != $varcheck[1]) {
											$_POST["field_sname"] = $varcheck[1];
										}
									}
								}
							break;
							case "textbox" :
								if(strlen(trim($_POST["field_sname"])) < 1) {
									$ERROR++;
									$ERRORSTR[] = "A &quot;Field Short Name&quot; is required when the field type is a text box. This will be the HTML name attribute in the form, so make this lowercase and no special characters/spaces.";
								} else {
									$varcheck = check_variable($_POST["field_sname"], true);
									if(!$varcheck[0]) {
										$ERROR++;
										$ERRORSTR[] = $varcheck[1];
									} else {
										if($_POST["field_sname"] != $varcheck[1]) {
											$_POST["field_sname"] = $varcheck[1];
										}
									}
								}
							break;
						}

						if(!$ERROR) {
							$query = "UPDATE `".TABLES_PREFIX."cfields` SET `field_type`='".checkslashes(trim($_POST["field_type"]))."', `field_options`='".checkslashes(trim($_POST["field_options"]))."', `field_sname`='".checkslashes(trim($_POST["field_sname"]))."', `field_lname`='".checkslashes(trim($_POST["field_lname"]))."', `field_length`='".checkslashes(trim($_POST["field_length"]))."', `field_req`='".checkslashes(trim($_POST["field_req"]))."' WHERE `cfields_id`='".checkslashes($_POST["cfields_id"])."'";
							if($db->Execute($query)) {
								header("Location: index.php?section=manage-fields");
								exit;
							} else {
								if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
									@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to edit custom field in database. Database said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
								}

								$ERROR++;
								$ERRORSTR[] = "Sorry, but we were unable to edit the custom field due to a database error. Please check your ListMessenger error_log for more information if you have logging enabled.";
							}
						}
					}
				}
				?>
				<h1>Edit Field</h1>
				After you edit this custom field, don't forget that you will need to update the HTML on your web-page so that your users will see the updated field information.
				<br /><br />
				<?= (($ERROR > 0) ? display_error($ERRORSTR) : "") ?>

				<form action="index.php?section=manage-fields&action=edit&id=<?= checkslashes($_GET["id"]) ?>" method="post">
				<input type="hidden" name="cfields_id" value="<?= checkslashes($_GET["id"]) ?>" />
				<table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
				<tr>
					<td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Field Type</em></strong><br />This is the type of custom field that you are looking at adding. Currently you can select a number of different HTML field types as well as a linebreak.<br /><br /><strong>Example:</strong><br />&quot;Radio Buttons&quot;'));">Field Type:</span></td>
					<td>
						<select name="field_type" style="width: 129px">
						<option value="checkbox"<?= (($_POST) ? (($_POST["field_type"] == "checkbox") ? " selected=\"selected\"" : "") : (($result["field_type"] == "checkbox") ? " selected=\"selected\"" : "")) ?>>Checkbox</option>
						<option value="hidden"<?= (($_POST) ? (($_POST["field_type"] == "hidden") ? " selected=\"selected\"" : "") : (($result["field_type"] == "hidden") ? " selected=\"selected\"" : "")) ?>>Hidden Field</option>
						<option value="linebreak"<?= (($_POST) ? (($_POST["field_type"] == "linebreak") ? " selected=\"selected\"" : "") : (($result["field_type"] == "linebreak") ? " selected=\"selected\"" : "")) ?>>Linebreak</option>
						<option value="radio"<?= (($_POST) ? (($_POST["field_type"] == "radio") ? " selected=\"selected\"" : "") : (($result["field_type"] == "radio") ? " selected=\"selected\"" : "")) ?>>Radio Buttons</option>
						<option value="select"<?= (($_POST) ? (($_POST["field_type"] == "select") ? " selected=\"selected\"" : "") : (($result["field_type"] == "select") ? " selected=\"selected\"" : "")) ?>>Select Box</option>
						<option value="textarea"<?= (($_POST) ? (($_POST["field_type"] == "textarea") ? " selected=\"selected\"" : "") : (($result["field_type"] == "textarea") ? " selected=\"selected\"" : "")) ?>>Textarea</option>
						<option value="textbox"<?= (($_POST) ? (($_POST["field_type"] == "textbox") ? " selected=\"selected\"" : "") : (($result["field_type"] == "textbox") ? " selected=\"selected\"" : "")) ?>>Textbox</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Field Short Name</em></strong><br />This is a short name for the field that must be all lowercase, all one word and no special characters. This field must also be unique because it is what you will use to call this field in a custom e-mail variable!<br /><br /><strong>Example:</strong><br />&quot;favcolour&quot;'));">Field Short Name:</span><br /><span class="small-grey">(should be all lower case, one word; no spaces or strange characters)</span></td>
					<td><input type="text" class="text-box" style="width: 125px" name="field_sname" value="<?= (($_POST) ? checkslashes($_POST["field_sname"], 1) : $result["field_sname"]) ?>" maxlength="16" /></td>
				</tr>
				<tr>
					<td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Display Name</em></strong><br />This is the title or longer name for your custom field. This could also be a question.<br /><br /><strong>Example:</strong><br />&quot;What is your favourite colour?&quot;'));">Field Display Name:</span></td>
					<td><input type="text" class="text-box" style="width: 360px" name="field_lname" value="<?= (($_POST) ? checkslashes($_POST["field_lname"], 1) : $result["field_lname"]) ?>" maxlength="64"/></td>
				</tr>
				<tr>
					<td class="form-row-nreq" style="vertical-align: top"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Field Options</em></strong><br />This is the options or defined value(s) of your custom field. If you are using a checkbox, radio button or select box you will want to specify your options here.<br /><br /><strong>Example:</strong><br />blue=Blue<br />red=Red<br />green=Green'));">Field Options:</span><br /><span class="small-grey">(required for radio buttons, select boxes, check boxes and hidden field valued only)</span></td>
					<td><textarea name="field_options" style="width: 360px; height: 125px"><?= (($_POST) ? checkslashes($_POST["field_options"], 1) : $result["field_options"]) ?></textarea></td>
				</tr>
				<tr>
					<td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Maxlength</em></strong><br />This is only used if your Field Type is a textbox. This will limit the subscriber to typing X number of characters in your textbox.<br /><br /><strong>Example:</strong><br />&quot;64&quot;'));">Maxlength:</span><br /><span class="small-grey">(used only for text boxes)</span></td>
					<td><input type="text" class="text-box" style="width: 50px" name="field_length" value="<?= (($_POST) ? checkslashes($_POST["field_length"], 1) : $result["field_length"]) ?>" maxlength="12" /></td>
				</tr>
				<tr>
					<td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Required Field</em></strong><br />Specify whether you want this custom field to be a required field or you can have it set to be optional.'));">Required Field:</span><br /><span class="small-grey">(is this field required when users sign-up?)</span></td>
					<td>
						<select name="field_req" style="width: 54px">
						<option value="1"<?= (($_POST) ? (($_POST["field_req"] == "1") ? " selected=\"selected\"" : "") : (($result["field_req"] == "1") ? " selected=\"selected\"" : "")) ?>>Yes</option>
						<option value="0"<?= (($_POST) ? (($_POST["field_req"] == "0") ? " selected=\"selected\"" : "") : (($result["field_req"] == "0") ? " selected=\"selected\"" : "")) ?>>No</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
						<input type="button" value="Cancel" class="button" onclick="window.location='index.php?section=manage-fields'" />
						<input type="submit" value="Edit Field" class="button" />
					</td>
				</tr>
				</table>
				</form>
				<?php
			} else {
				$ERROR++;
				$ERRORSTR[] = "The custom field ID specified in the URL [".checkslashes($_GET["id"])."] does not exist in the database.";
				echo (($ERROR > 0) ? display_error($ERRORSTR) : "");
				if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
					@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tThe custom field ID specified in the URL [".checkslashes($_GET["id"])."] does not exist in the database.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
				}
			}
		}
	break;
	case "view" :
		switch($_GET["mode"]) {
			case "html" :
				?>
				<h1>Manage Fields (Get HTML Code)</h1>
				This HTML code segment can be used directly on your website or it can be modified to suit the look and feel of your site. Keep in mind this is just an example of what you can do, also <strong>do not forget</strong> to replace the &quot;ENTER_GROUPIDS_HERE&quot; with the actual group id(s) you want this inserted into.
				<br /><br />
				<?php
				echo "<a href=\"index.php?section=manage-fields\">Edit Mode</a>&nbsp;|&nbsp;<a href=\"index.php?section=manage-fields&action=view\">Preview Form</a>&nbsp;|&nbsp;<strong>Get HTML Code</strong><br />\n";
				echo "<form>\n";
				echo "<textarea name=\"html\" style=\"width: 575px; height: 375px\" wrap=\"off\">";
				echo generate_cfields($_SESSION["config"][PREF_PUBLIC_URL].$_SESSION["config"][ENDUSER_FILENAME], "html");
				echo "</textarea>\n";
				echo "</form>\n";
				echo "<br />\n";
			break;
			default :
				?>
				<h1>Manage Fields (Preview Form)</h1>
				The following is a preview of how your form will look &quot;out-of-the-box&quot; when you put it on your web-site. You may wish to add other details which is fine, this is just an example. You can find more of what you can do in the documentation section available on the <a href="http://www.listmessenger.com" target="_blank">ListMessenger</a> website.
				<br /><br />
				<?php
				echo "<a href=\"index.php?section=manage-fields\">Edit Mode</a>&nbsp;|&nbsp;<strong>Preview Form</strong>&nbsp;|&nbsp;<a href=\"index.php?section=manage-fields&action=view&mode=html\">Get HTML Code</a><br />\n";
				echo "<div style=\"border: 1px #666666 solid; padding: 6px; margin: 0px\">\n";
				echo generate_cfields($_SESSION["config"][PREF_PUBLIC_URL].$_SESSION["config"][ENDUSER_FILENAME]);
				echo "</div>\n";
			break;
		}
	break;
	default :	// List Custom Fields
		$i = count($SIDEBAR);
		$SIDEBAR[$i] = "<br /><div align=\"center\"><input type=\"button\" value=\"New Field\" class=\"button\" onclick=\"window.location='index.php?section=manage-fields&action=add'\" /></div>";

		if($_POST) {
			if(count($_POST["order"]) > 0) {
				foreach($_POST["order"] as $cfields_id => $field_order) {
					$query = "UPDATE `".TABLES_PREFIX."cfields` SET `field_order`='".checkslashes(trim($field_order))."' WHERE `cfields_id`='".checkslashes(trim($cfields_id))."'";
					$db->Execute($query);
				}
			}
		}
		?>
		<h1>Manage Fields (Edit Mode)</h1>
		In the Manage Fields section, you can create custom fields that your subscribers can fill out in addition to their name and e-mail address. These fields could be for example, Address, City, Province, Postal Code, etc. Custom fields are great for collecting more information about your users.
		<br /><br />
		<?php
		$query	= "SELECT MAX(`field_order`) AS `max` FROM `".TABLES_PREFIX."cfields`";
		$result	= $db->GetRow($query);
		if($result) {
			$max = $result["max"] + 1;
		}

		$query	= "SELECT * FROM `".TABLES_PREFIX."cfields` ORDER BY `field_order` ASC";
		$results	= $db->GetAll($query);
		if(!$results) {
			echo "<div class=\"generic-message\">\n";
			echo "	There are no custom fields your Listmessenger database.\n";
			echo "	<br /><br />\n";
			echo "	To create a custom field, click <strong>New Field</strong> button to the left.</span>";
			echo "</div>\n";
		}

		echo "<strong>Edit Mode</strong>&nbsp;|&nbsp;<a href=\"index.php?section=manage-fields&action=view\">Preview Form</a>&nbsp;|&nbsp;<a href=\"index.php?section=manage-fields&action=view&mode=html\">Get HTML Code</a><br />\n";
		echo "<form action=\"index.php?section=manage-fields\" method=\"post\">\n";
		echo "<table style=\"width: 100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">\n";
		echo "<tr>\n";
		echo "	<td style=\"width: 8%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap\">&nbsp;</td>\n";
		echo "	<td style=\"width: 35%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap\"><strong>Field Name</strong></td>\n";
		echo "	<td style=\"width: 47%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap\"><strong>Field Preview</strong></td>\n";
		echo "	<td style=\"width: 10%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap\"><strong>Order</strong></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "	<td style=\"width: 8%; vertical-align: top; text-align: center; border: 1px #CCCCCC dotted\">&nbsp;</td>\n";
		echo "	<td style=\"width: 35%; vertical-align: top; border: 1px #CCCCCC dotted\" class=\"form-row-req\">E-Mail Address:</td>\n";
		echo "	<td style=\"width: 47%; border: 1px #CCCCCC dotted\" colspan=\"2\"><input type=\"text\" name=\"email_address\" value=\"\" maxlength=\"128\" /></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "	<td style=\"width: 8%; vertical-align: top; text-align: center; border: 1px #CCCCCC dotted\">&nbsp;</td>\n";
		echo "	<td style=\"width: 35%; vertical-align: top; border: 1px #CCCCCC dotted\" class=\"form-row-nreq\">First Name:</td>\n";
		echo "	<td style=\"width: 47%; border: 1px #CCCCCC dotted\" colspan=\"2\"><input type=\"text\" name=\"firstname\" value=\"\" maxlength=\"32\" /></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "	<td style=\"width: 8%; vertical-align: top; text-align: center; border: 1px #CCCCCC dotted\">&nbsp;</td>\n";
		echo "	<td style=\"width: 35%; vertical-align: top; border: 1px #CCCCCC dotted\" class=\"form-row-nreq\">Last Name:</td>\n";
		echo "	<td style=\"width: 47%; border: 1px #CCCCCC dotted\" colspan=\"2\"><input type=\"text\" name=\"lastname\" value=\"\" maxlength=\"32\" /></td>\n";
		echo "</tr>\n";
		if($results) {
			foreach($results as $result) {
				echo "<tr>\n";
				echo "	<td style=\"width: 8%; vertical-align: top; text-align: center; border: 1px #CCCCCC dotted\"><a href=\"./index.php?section=manage-fields&action=edit&id=".$result["cfields_id"]."\"><img src=\"./images/icon-edit-fields.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Edit\" title=\"Edit ".$result["field_lname"]."\" /></a>&nbsp;<a href=\"./index.php?section=manage-fields&action=delete&id=".$result["cfields_id"]."\"><img src=\"./images/icon-del-fields.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Delete\" title=\"Delete ".$result["field_lname"]."\" /></a></td>\n";
				echo "	<td style=\"width: 35%; vertical-align: top; border: 1px #CCCCCC dotted\" class=\"".(($result["field_req"] == 1) ? "form-row-req" : "form-row-nreq")."\">".(($result["field_lname"]) ? checkslashes($result["field_lname"], 1) : "&nbsp;")."</td>\n";
				echo "	<td style=\"width: 47%; border: 1px #CCCCCC dotted\">\n";
				switch($result["field_type"]) {
					case "checkbox" :
						if($result["field_options"] != "") {
							$options = explode("\n", $result["field_options"]);
							foreach($options as $option) {
								$pieces = explode("=", $option);
								echo "<input type=\"checkbox\" name=\"".$result["field_sname"]."\" value=\"".$pieces[0]."\">- ".$pieces[1]."<br />\n";
							}
						}
					break;
					case "hidden" :
						echo "<span class=\"small-grey\">-- HIDDEN FIELD -- (".$result["field_sname"]." = ".$result["field_options"].")</span>\n";
					break;
					case "linebreak" :
						echo "<span class=\"small-grey\">-- LINEBREAK --</span>\n";
					break;
					case "radio" :
						if($result["field_options"] != "") {
							$options = explode("\n", $result["field_options"]);
							foreach($options as $option) {
								$pieces = explode("=", $option);
								echo "<input type=\"radio\" name=\"".$result["field_sname"]."\" value=\"".$pieces[0]."\">- ".$pieces[1]."<br />\n";
							}
						}
					break;
					case "select" :
						if($result["field_options"] != "") {
							$options = explode("\n", $result["field_options"]);
							echo "<select name=\"".$result["field_sname"]."\">\n";
							foreach($options as $option) {
								$pieces = explode("=", $option);
								echo "<option value=\"".trim($pieces[0])."\">".trim($pieces[1])."</option>\n";
							}
							echo "</select>\n";
						}
					break;
					case "textarea" :
						echo "<textarea name=\"".$result["field_sname"]."\" style=\"width: 98%; height: 75px\"></textarea>\n";
					break;
					case "textbox" :
						echo "<input type=\"text\" name=\"".$result["field_sname"]."\" value=\"\"".((strlen($result["field_length"]) > 0) ? " maxlength=\"".$result["field_length"]."\"" : "")." />\n";
					break;
					default :
						echo "&nbsp;";
					break;
				}
				echo "	</td>\n";
				echo "	<td style=\"width: 10%; vertical-align: top; border: 1px #CCCCCC dotted\">\n";
				echo "		<select name=\"order[".$result["cfields_id"]."]\">\n";
				for($i = 1; $i <= (($max) ? $max : (count($results)+1)); $i++) {
					echo "	<option value=\"".$i."\"".(($i == $result["field_order"]) ? " selected=\"selected\"" : "").">".$i."</option>\n";
				}
				echo "		</select>\n";
				echo "	</td>\n";
				echo "</tr>\n";
			}
		}
		echo "<tr>\n";
		echo "	<td style=\"width: 8%; vertical-align: top; text-align: center; border: 1px #CCCCCC dotted\">&nbsp;</td>\n";
		echo "	<td style=\"width: 35%; vertical-align: top; border: 1px #CCCCCC dotted\" class=\"form-row-req\">Subscriber Action:</td>\n";
		echo "	<td style=\"width: 47%; border: 1px #CCCCCC dotted\" colspan=\"2\">\n";
		echo "		<select name=\"action\">\n";
		echo "		<option value=\"subscribe\">Subscribe</option>\n";
		echo "		<option value=\"unsubscribe\">Unsubscribe</option>\n";
		echo "		</select>\n";
		echo "	</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "	<td style=\"width: 8%; vertical-align: top; text-align: center; border: 1px #CCCCCC dotted\">&nbsp;</td>\n";
		echo "	<td style=\"width: 35%; vertical-align: top; border: 1px #CCCCCC dotted\" class=\"form-row-req\">&nbsp;</td>\n";
		echo "	<td style=\"width: 47%; border: 1px #CCCCCC dotted\" colspan=\"2\"><span class=\"small-grey\">-- HIDDEN FIELD -- (group_ids[] = GROUP_IDS_HERE)</span></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "	<td style=\"text-align: right; padding-top: 5px\" colspan=\"4\"><input type=\"submit\" value=\"Update Order\" class=\"button\" /></td>\n";
		echo "</tr>\n";
		echo "</table>\n";
		echo "</form>\n";

	break;
}
?>
