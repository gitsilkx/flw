<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: templates.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

if(!defined("PARENT_LOADED"))		exit;
if(!$_SESSION["isAuthenticated"])	exit;

if(($_GET["action"] == "add") || ($_GET["action"] == "edit")) {
	// Add the template varibles sidebar.
	$i = count($SIDEBAR);
	$SIDEBAR[$i]  = "<h1>Variables</h1>";
	$SIDEBAR[$i] .= "<div style=\"padding: 3px; background-color: #FFFFFF; border-left: 1px #CCCCCC solid; border-right: 1px #CCCCCC solid; border-bottom: 1px #CCCCCC solid;\">\n";
	$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Default Field Variables', 'content', '<strong>Variable: <em>[message]</em></strong><br /><em>Message</em><br />This is the place holder for the location that your new message will be inserted when you compose a new message and select this template.'));\"><strong>[message]</strong></div>";
	$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Default Field Variables', 'content', '<strong>Variable: <em>[unsubscribe]</em></strong><br /><em>Unsubscribe</em><br />This will insert the ListMessenber unsubscribe link providing you have <em>Auto-Add Unsubscribe Link</em> enabled in the E-Mail Configuration section of Preferences.'));\">[unsubscribe]</div><br />";
	$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Default Field Variables', 'content', '<strong>Variable: <em>[name]</em></strong><br /><em>Full Name</em><br />This will input the users full name. Example: Tim Bobbins'));\">[name]</div>";
	$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Default Field Variables', 'content', '<strong>Variable: <em>[firstname]</em></strong><br /><em>First Name</em><br />This will input the users first name only. Example: Tim'));\">[firstname]</div>";
	$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Default Field Variables', 'content', '<strong>Variable: <em>[lastname]</em></strong><br /><em>Last Name</em><br />This will input the users last name only. Example: Bobbins'));\">[lastname]</div>";
	$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Default Field Variables', 'content', '<strong>Variable: <em>[email]</em></strong><br /><em>E-Mail Address</em><br />This will input the users e-mail address. Example: email@domain.com'));\">[email]</div>";
	$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Default Field Variables', 'content', '<strong>Variable: <em>[date]</em></strong><br /><em>Date</em><br />This will input the date that this message was sent. Example: ".display_date($_SESSION["config"][PREF_DATEFORMAT], time())."'));\">[date]</div>";
	$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Default Field Variables', 'content', '<strong>Variable: <em>[groupname]</em></strong><br /><em>Group Name</em><br />This will input the name of the group that user belongs to. Example: Default'));\">[groupname]</div>";
	$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Default Field Variables', 'content', '<strong>Variable: <em>[groupid]</em></strong><br /><em>Group ID</em><br />This will input the ID of the group that the user belongs to. Example: 4'));\">[groupid]</div>";
	$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Default Field Variables', 'content', '<strong>Variable: <em>[userid]</em></strong><br /><em>User ID</em><br />This will input the database ID of the user. Example: 354'));\">[userid]</div>";
	$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Default Field Variables', 'content', '<strong>Variable: <em>[messageid]</em></strong><br /><em>Message ID</em><br />This will input the database ID of this message. Example: 25'));\">[messageid]</div>";
	$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Default Field Variables', 'content', '<strong>Variable: <em>[profileurl]</em></strong><br /><em>Profile URL</em><br />This will input the URL of the profile update script so your subscriber is able to click the link and update their contact information.'));\">[profileurl]</div>";
	$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Default Field Variables', 'content', '<strong>Variable: <em>[signupdate]</em></strong><br /><em>Signup Date</em><br />This will input the date that the user signed up to the list. Example: ".display_date($_SESSION["config"][PREF_DATEFORMAT], (time()-172800))."'));\">[signupdate]</div><br />";

	$query	= "SELECT `field_sname`,`field_lname` FROM `".TABLES_PREFIX."cfields` WHERE `field_type`<>'linebreak'";
	$results	= $db->GetAll($query);
	if($results) {
		foreach($results as $result) {
			$SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Custom Field Variables', 'content', '<strong>Variable: <em>[".$result["field_sname"]."]</em></strong><br />".(($result["field_lname"]) ? "<em>".addslashes($result["field_lname"])."</em><br />" : "")."This is a custom variable that can be used in any template, message body or message subject.'));\">[".$result["field_sname"]."]</div>";
		}
	}
	$SIDEBAR[$i] .= "<br />\n";
	$SIDEBAR[$i] .= "</div>\n";
}

switch($_GET["action"]) {
	case "add" :
		// Check which type of template we're creating.
		switch($_GET["type"]) {
			case "html" :
				if($_POST) {
					$PROCESSED = array();
					if($_POST["template_type"] != "html") {
						$ERROR++;
						$ERRORSTR[] = "You are attempting to add a new html template; however, the template type does not equal html in the form.";
					} else {
						$PROCESSED["template_type"] = "html";
					}
					if(strlen(trim($_POST["template_name"])) < 1) {
						$ERROR++;
						$ERRORSTR[] = "You must enter a name for this template in order to add it to ListMessenger.";
					} else {
						$query	= "SELECT * FROM `".TABLES_PREFIX."templates` WHERE `template_name`='".checkslashes(trim($_POST["template_name"]))."' AND `template_type`='html'";
						$result	= $db->GetRow($query);
						if($result) {
							$ERROR++;
							$ERRORSTR[] = "Your html template name should be unique, and there is already one by this name in your database.";
						} else {
							$PROCESSED["template_name"] = trim($_POST["template_name"]);
						}
					}
					if(strlen(trim($_POST["template_description"])) > 0) {
						$PROCESSED["template_description"] = trim($_POST["template_description"]);
					}
					if(strlen(trim($_POST["template_content"])) < 1) {
						$ERROR++;
						$ERRORSTR[] = "Your template contents are empty. Please be sure you enter your text template in the template content box.";
					} else {
						if(!strstr($_POST["template_content"], "[message]")) {
							$ERROR++;
							$ERRORSTR[] = "Your template does not contain the required [message] variable place holder. Please enter [message] in your template where you would like the contents of a newly composed message inserted.";
						} else {
							$PROCESSED["template_content"] = trim($_POST["template_content"]);
						}
					}
					if(!$ERROR) {
						$query	= "SELECT * FROM `".TABLES_PREFIX."templates` WHERE `template_id`=-1";
						$fields	= $db->Execute($query);

						$query	= $db->GetInsertSQL($fields, $PROCESSED, ini_get("magic_quotes_gpc"));
						if($query != "") {
							if($db->Execute($query)) {
								header("Location: index.php?section=templates");
								exit;
							} else {
								$ERROR++;
								$ERRORSTR[] = "ListMessenger was unable to insert your template into the database. Please check your error log for more detailed information.";

								if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
									@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to insert template data into database. ADODB returned: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
								}
							}
						} else {
							$ERROR++;
							$ERRORSTR[] = "The automatically generated insert query was empty. ADODB returned: ".$db->ErrorMsg();

							if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
								@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tThe automatically generated insert query was empty. ADODB returned: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
							}
						}
					}
				}
				?>
				<h1>New HTML Template</h1>
				This section allows you to add a new <strong>HTML</strong> template to ListMessenger, which can be used when you compose a new message. Keep in mind you can use message variables within templates as well!
				<br /><br />
				<?= (($ERROR > 0) ? display_error($ERRORSTR) : "") ?>
				<form action="index.php?section=templates&action=add&type=html" method="post">
				<table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
				<tr>
					<td class="form-row-req" style="vertical-align: top">Template Type:</td>
					<td>
						<select id="template_type" name="template_type" onkeypress="return handleEnter(this, event)" onchange="window.location='index.php?section=templates&action=add&type=text'">
						<option value="text">Text Template</option>
						<option value="html" selected="selected">HTML Template</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="form-row-req" style="width: 35%">Template Name:</td>
					<td style="width: 65%"><input type="text" class="text-box" style="width: 250px" name="template_name" value="<?= checkslashes($_POST["template_name"], 1) ?>" onkeypress="return handleEnter(this, event)" /></td>
				</tr>
				<tr>
					<td class="form-row-nreq" colspan="2">Template Description:</td>
				</tr>
				<tr>
					<td colspan="2">
						<textarea name="template_description" style="width: 98%; height: 50px"><?= checkslashes($_POST["template_description"], 1) ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td class="form-row-req" colspan="2">Template HTML Content: <span class="small-grey">Note: The [message] variable must be present in your template.</span></td>
				</tr>
				<tr>
					<td colspan="2">
						<textarea name="template_content" style="width: 98%; height: 300px"><?= checkslashes($_POST["template_content"], 1) ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
						<input type="button" value="Cancel" class="button" onclick="window.location='index.php?section=templates'" />
						<input type="submit" value="Add Template" class="button" />
					</td>
				</tr>
				</table>
				</form>
				<?php
			break;
			default :
				if($_POST) {
					$PROCESSED = array();
					if($_POST["template_type"] != "text") {
						$ERROR++;
						$ERRORSTR[] = "You are attempting to add a new text template; however, the template type does not equal text in the form.";
					} else {
						$PROCESSED["template_type"] = "text";
					}
					if(strlen(trim($_POST["template_name"])) < 1) {
						$ERROR++;
						$ERRORSTR[] = "You must enter a name for this template in order to add it to ListMessenger.";
					} else {
						$query	= "SELECT * FROM `".TABLES_PREFIX."templates` WHERE `template_name`='".checkslashes(trim($_POST["template_name"]))."' AND `template_type`='text'";
						$result	= $db->GetRow($query);
						if($result) {
							$ERROR++;
							$ERRORSTR[] = "Your text template name should be unique, and there is already one by this name in your database.";
						} else {
							$PROCESSED["template_name"] = trim($_POST["template_name"]);
						}
					}
					if(strlen(trim($_POST["template_description"])) > 0) {
						$PROCESSED["template_description"] = trim($_POST["template_description"]);
					}
					if(strlen(trim($_POST["template_content"])) < 1) {
						$ERROR++;
						$ERRORSTR[] = "Your template contents are empty. Please be sure you enter your text template in the template content box.";
					} else {
						if(!strstr($_POST["template_content"], "[message]")) {
							$ERROR++;
							$ERRORSTR[] = "Your template does not contain the required [message] variable place holder. Please enter [message] in your template where you would like the contents of a newly composed message inserted.";
						} else {
							$PROCESSED["template_content"] = trim($_POST["template_content"]);
						}
					}
					if(!$ERROR) {
						$query	= "SELECT * FROM `".TABLES_PREFIX."templates` WHERE `template_id`=-1";
						$fields	= $db->Execute($query);

						$query	= $db->GetInsertSQL($fields, $PROCESSED, ini_get("magic_quotes_gpc"));
						if($query != "") {
							if($db->Execute($query)) {
								header("Location: index.php?section=templates");
								exit;
							} else {
								$ERROR++;
								$ERRORSTR[] = "ListMessenger was unable to insert your template into the database. Please check your error log for more detailed information.";

								if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
									@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to insert template data into database. ADODB returned: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
								}
							}
						} else {
							$ERROR++;
							$ERRORSTR[] = "The automatically generated insert query was empty. ADODB returned: ".$db->ErrorMsg();

							if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
								@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tThe automatically generated insert query was empty. ADODB returned: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
							}
						}
					}
				}
				?>
				<h1>New Text Template</h1>
				This section allows you to add a new <strong>text</strong> template to ListMessenger, which can be used when you compose a new message. Keep in mind you can use message variables within templates as well!
				<br /><br />
				<?= (($ERROR > 0) ? display_error($ERRORSTR) : "") ?>
				<form action="index.php?section=templates&action=add&type=text" method="post">
				<table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
				<tr>
					<td class="form-row-req" style="vertical-align: top">Template Type:</td>
					<td>
						<select id="template_type" name="template_type" onkeypress="return handleEnter(this, event)" onchange="window.location='index.php?section=templates&action=add&type=html'">
						<option value="text" selected="selected">Text Template</option>
						<option value="html">HTML Template</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="form-row-req" style="width: 35%">Template Name:</td>
					<td style="width: 65%"><input type="text" class="text-box" style="width: 250px" name="template_name" value="<?= checkslashes($_POST["template_name"], 1) ?>" onkeypress="return handleEnter(this, event)" /></td>
				</tr>
				<tr>
					<td class="form-row-nreq" colspan="2">Template Description:</td>
				</tr>
				<tr>
					<td colspan="2">
						<textarea name="template_description" style="width: 98%; height: 50px"><?= checkslashes($_POST["template_description"], 1) ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td class="form-row-req" colspan="2">Template Text Content: <span class="small-grey">Note: The [message] variable must be present in your template.</span></td>
				</tr>
				<tr>
					<td colspan="2">
						<textarea name="template_content" style="width: 98%; height: 300px"><?= checkslashes($_POST["template_content"], 1) ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
						<input type="button" value="Cancel" class="button" onclick="window.location='index.php?section=templates'" />
						<input type="submit" value="Add Template" class="button" />
					</td>
				</tr>
				</table>
				</form>
				<?php
			break;
		}
	break;
	case "delete" :
		?>
		<h1>Template Removal</h1>
		<?php
		if($_POST["confirmed"] == "true") {
			if((@is_array($_POST["deltemplates"])) && (@count($_POST["deltemplates"]) > 0)) {
				$ONLOAD[] = "setTimeout('window.location=\'index.php?section=templates\'', 5000)";

				foreach($_POST["deltemplates"] as $template_id) {
					$query = "DELETE FROM `".TABLES_PREFIX."templates` WHERE `template_id`='".checkslashes($template_id)."'";
					if(!$db->Execute($query)) {
						if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
							@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete template id [".$template_id."]. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
						}
						$ERROR++;
						$ERRORSTR[] = "Unable to delete template id [".$template_id."] from the database.";
					} else {
						$SUCCESS++;
					}
				}
				if($ERROR) {
					echo display_error($ERRORSTR);
				} elseif($SUCCESS) {
					$SUCCESSSTR[] = "You have successfully deleted ".$SUCCESS." template".(($SUCCESS != 1) ? "s" : "")." from the database.<br /><br />You will be automatically redirected in 5 seconds, or <a href=\"index.php?section=templates\">click here</a> if you prefer not to wait.";
					echo display_success($SUCCESSSTR);
				}
			} else {
				header("Location: index.php?section=templates");
				exit;
			}
		} else {
			if((@is_array($_POST["deltemplates"])) && (@count($_POST["deltemplates"]) > 0)) {
				?>
				<div style="padding-bottom: 5px">
					Please confirm that you wish to remove the following <?= count($_POST["deltemplates"]) ?> template<?= ((count($_POST["deltemplates"]) != 1) ? "s" : "") ?>:
				</div>
				<form action="index.php?section=templates&action=delete" method="post">
				<input type="hidden" name="confirmed" value="true" />
				<table style="width: 100%; text-align: left" cellspacing="0" cellpadding="1" border="0">
				<tr>
					<td style="width: 4%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap">&nbsp;</td>
					<td style="width: 18%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap"><?= order_link("", "Template Type", $order, $sort, false) ?></td>
					<td style="width: 30%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap"><?= order_link("", "Template Name", $order, $sort, false) ?></td>
					<td style="width: 48%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap"><?= order_link("", "Template Description", $order, $sort, false) ?></td>
				</tr>
				<?php
				foreach($_POST["deltemplates"] as $template_id) {
					$query	= "SELECT `template_type`, `template_name`, `template_description` FROM `".TABLES_PREFIX."templates` WHERE `template_id`='".checkslashes($template_id)."'";
					$result	= $db->GetRow($query);
					if($result) {
						echo "<tr onmouseout=\"this.style.backgroundColor='#FFFFFF'\" onmouseover=\"this.style.backgroundColor='#F0FFD1'\">\n";
						echo "	<td style=\"white-space: nowrap\"><input type=\"checkbox\" name=\"deltemplates[]\" value=\"".checkslashes($template_id)."\" checked=\"checked\" /></td>\n";
						echo "	<td class=\"cursor\">".ucwords($result["template_type"])." Template</td>\n";
						echo "	<td class=\"cursor\">".html_encode(limit_chars($result["template_name"], 38))."</td>\n";
						echo "	<td class=\"cursor\">".html_encode(limit_chars($result["template_description"], 48))."</td>\n";
						echo "</tr>\n";
					}
				}
				echo "<tr>\n";
				echo "	<td colspan=\"4\" style=\"text-align: right; border-top: 1px #333333 dotted; padding-top: 5px\"><input type=\"button\" value=\"Cancel\" class=\"button\" onclick=\"window.location='index.php?section=templates'\" />&nbsp;<input type=\"submit\" value=\"Confirm\" class=\"button\" /></td>\n";
				echo "</tr>\n";
				echo "</table>\n";
				echo "</form>\n";
			} else {
				header("Location: index.php?section=template");
				exit;
			}
		}
	break;
	case "edit" :
		if((int) trim($_GET["id"])) {
			$query	= "SELECT * FROM `".TABLES_PREFIX."templates` WHERE `template_id`='".checkslashes(trim($_GET["id"]))."'";
			$result	= $db->GetRow($query);
			if($result) {
				if($_POST) {
					$PROCESSED = array();
					switch($_POST["template_type"]) {
						case "html" :
							$PROCESSED["template_type"] = "html";
						break;
						default :
							$PROCESSED["template_type"] = "text";
						break;
					}
					if(strlen(trim($_POST["template_name"])) < 1) {
						$ERROR++;
						$ERRORSTR[] = "You must enter a name for this template in order to add it to ListMessenger.";
					} else {
						if(trim($_POST["template_name"]) != trim($_POST["otemplate_name"])) {
							$squery	= "SELECT * FROM `".TABLES_PREFIX."templates` WHERE `template_name`='".checkslashes(trim($_POST["template_name"]))."' AND `template_type`='".$PROCESSED["template_type"]."'";
							$sresult	= $db->GetRow($squery);
							if($sresult) {
								$ERROR++;
								$ERRORSTR[] = "Your ".$PROCESSED["template_type"]." template name should be unique, and there is already one by this name in your database.";
							} else {
								$PROCESSED["template_name"] = trim($_POST["template_name"]);
							}
						}
					}
					if(strlen(trim($_POST["template_description"])) > 0) {
						$PROCESSED["template_description"] = trim($_POST["template_description"]);
					}
					if(strlen(trim($_POST["template_content"])) < 1) {
						$ERROR++;
						$ERRORSTR[] = "Your template contents are empty. Please be sure you enter your ".$PROCESSED["template_type"]." template in the template content box.";
					} else {
						if(!strpos($_POST["template_content"], "[message]")) {
							$ERROR++;
							$ERRORSTR[] = "Your template does not contain the required [message] variable place holder. Please enter [message] in your template where you would like the contents of a newly composed message inserted.";
						} else {
							$PROCESSED["template_content"] = trim($_POST["template_content"]);
						}
					}
					if(!$ERROR) {
						$query	= "SELECT * FROM `".TABLES_PREFIX."templates` WHERE `template_id`='".checkslashes(trim($_GET["id"]))."'";
						$fields	= $db->Execute($query);

						$query	= $db->GetUpdateSQL($fields, $PROCESSED, false, ini_get("magic_quotes_gpc"));
						if($query != "") {
							if($db->Execute($query)) {
								header("Location: index.php?section=templates");
								exit;
							} else {
								$ERROR++;
								$ERRORSTR[] = "ListMessenger was unable to update your template information. Please check your error log for more detailed information.";

								if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
									@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to update template data in database. ADODB returned: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
								}
							}
						} else {
							header("Location: index.php?section=templates");
							exit;
						}
					}
				}
				?>
				<h1>Editing <?= ucwords($result["template_type"]) ?> Template <small>[<?= html_encode(checkslashes($result["template_name"], 1)) ?>]</small></h1>
				<?= (($ERROR > 0) ? display_error($ERRORSTR) : "") ?>
				<form action="index.php?section=templates&action=edit&id=<?= checkslashes(trim($_GET["id"])) ?>" method="post">
				<input type="hidden" name="otemplate_name" value="<?= html_encode(trim($result["template_name"])) ?>" />
				<table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
				<tr>
					<td class="form-row-req" style="vertical-align: top">Template Type:</td>
					<td>
						<select id="template_type" name="template_type" onkeypress="return handleEnter(this, event)">
						<option value="text"<?= (($_POST) ? (($_POST["template_type"] == "text") ? " selected=\"selected\"" : "") : (($result["template_type"] == "text") ? " selected=\"selected\"" : "")) ?>>Text Template</option>
						<option value="html"<?= (($_POST) ? (($_POST["template_type"] == "html") ? " selected=\"selected\"" : "") : (($result["template_type"] == "html") ? " selected=\"selected\"" : "")) ?>>HTML Template</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="form-row-req" style="width: 35%">Template Name:</td>
					<td style="width: 65%"><input type="text" class="text-box" style="width: 250px" name="template_name" value="<?= (($_POST) ? checkslashes($_POST["template_name"], 1) : checkslashes($result["template_name"], 1)) ?>" onkeypress="return handleEnter(this, event)" /></td>
				</tr>
				<tr>
					<td class="form-row-nreq" colspan="2">Template Description:</td>
				</tr>
				<tr>
					<td colspan="2">
						<textarea name="template_description" style="width: 98%; height: 50px"><?= (($_POST) ? checkslashes($_POST["template_description"], 1) : checkslashes($result["template_description"], 1)) ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td class="form-row-req" colspan="2">Template Content: <span class="small-grey">Note: The [message] variable must be present in your template.</span></td>
				</tr>
				<tr>
					<td colspan="2">
						<textarea name="template_content" style="width: 98%; height: 300px"><?= (($_POST) ? checkslashes($_POST["template_content"], 1) : checkslashes($result["template_content"], 1)) ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
						<input type="button" value="Cancel" class="button" onclick="window.location='index.php?section=templates'" />
						<input type="submit" value="Save Template" class="button" />
					</td>
				</tr>
				</table>
				</form>
				<?php
			} else {

			}
		} else {

		}
	break;
	case "view" :
		if((int) trim($_GET["id"])) {
			$query	= "SELECT * FROM `".TABLES_PREFIX."templates` WHERE `template_id`='".checkslashes(trim($_GET["id"]))."'";
			$result	= $db->GetRow($query);
			if($result) {
				?>
				<h1>Viewing <?php echo ucwords($result["template_type"]); ?> Template <small>[<?php echo html_encode(checkslashes($result["template_name"], 1)); ?>]</small></h1>
				<form>
				<table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
				<tr>
					<td style="width: 30%" class="form-row-req" style="vertical-align: top">Template Type:</td>
					<td style="width: 70%"><?= ucwords($result["template_type"]) ?> Template</td>
				</tr>
				<tr>
					<td class="form-row-req">Template Name:</td>
					<td><?= html_encode($result["template_name"]) ?></td>
				</tr>
				<tr>
					<td class="form-row-nreq" style="vertical-align: top">Template Description:</td>
					<td><?= html_encode($result["template_description"]) ?></td>
				</tr>
				<tr>
					<td class="form-row-req" colspan="2">Template Content:</td>
				</tr>
				<tr>
					<td colspan="2" style="padding-left: 5px">
						<?php
						switch($result["template_type"]) {
							case "html" :
								echo "<div align=\"right\" style=\"padding-bottom: 5px\">\n";
								echo "	<a href=\"./preview.php?sid=".session_id()."\" target=\"_blank\">Open in New Window</a>\n";
								echo "</div>\n";
								if(trim(strip_tags($result["template_content"])) != "") {
									$_SESSION["html_message"] = urlencode(checkslashes(trim($result["template_content"]), 1));
								} else {
									unset($_SESSION["html_message"]);
								}
								echo "<iframe src=\"./preview.php?sid=".session_id()."\" style=\"border: 1px; width: 100%; height: 400px\"></iframe>\n";
							break;
							default :
								echo wordwrap(nl2br(html_encode($result["template_content"])), $_SESSION["config"][PREF_WORDWRAP], "<br />", 1);
							break;
						}
						?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
						<input type="button" value="Close" class="button" onclick="window.location='index.php?section=templates'" />
						<input type="button" class="button" value="Edit Template" onclick="window.location='index.php?section=templates&action=edit&id=<?= checkslashes(trim($_GET["id"])) ?>'" />
					</td>
				</tr>
				</table>
				</form>
				<?php
			} else {

			}
		} else {

		}
	break;
	default :
		$i = count($HEAD);
		$HEAD[$i]  = "<script type=\"text/javascript\" src=\"./javascript/tabpane/tabpane.js\"></script>\n";
		$HEAD[$i] .= "<link type=\"text/css\" rel=\"StyleSheet\" href=\"./css/luna/tab.css\" />\n";

		// Setup "Sort By Field" Information
		if(strlen($_GET["sort"]) > 0) {
			$_SESSION["display"]["templates"]["sort"] = checkslashes($_GET["sort"]);
			setcookie("display[templates][sort]", checkslashes($_GET["sort"]), PREF_COOKIE_TIMEOUT);
		} elseif((!isset($_SESSION["display"]["templates"]["sort"])) && (isset($_COOKIE["display"]["templates"]["sort"]))) {
			$_SESSION["display"]["templates"]["sort"] = $_COOKIE["display"]["templates"]["sort"];
		} else {
			if(!isset($_SESSION["display"]["templates"]["sort"])) {
				$_SESSION["display"]["templates"]["sort"] = "name";
				setcookie("display[templates][sort]", "name", PREF_COOKIE_TIMEOUT);
			}
		}

		// Setup "Sort Order" Information
		if($_GET["order"]) {
			switch($_GET["order"]) {
				case "asc" :
					$_SESSION["display"]["templates"]["order"] = "ASC";
				break;
				case "desc" :
					$_SESSION["display"]["templates"]["order"] = "DESC";
				break;
				default :
					$_SESSION["display"]["templates"]["order"] = "ASC";
				break;
			}
			setcookie("display[templates][order]", $_SESSION["display"]["templates"]["order"], PREF_COOKIE_TIMEOUT);
		} elseif((!isset($_SESSION["display"]["templates"]["order"])) && (isset($_COOKIE["display"]["templates"]["order"]))) {
			$_SESSION["display"]["templates"]["order"] = $_COOKIE["display"]["templates"]["order"];
		} else {
			if (!isset($_SESSION["display"]["templates"]["order"])) {
				$_SESSION["display"]["templates"]["order"] = "ASC";
				setcookie("display[templates][order]", "ASC", PREF_COOKIE_TIMEOUT);
			}
		}

		// Set the internal variables used for sorting, ordering and in pagination.
		$sort	= $_SESSION["display"]["templates"]["sort"];
		$order	= $_SESSION["display"]["templates"]["order"];

		// Get the colomn names of the sorted by colomn.
		switch($sort) {
			case "name" :
				$sortby	= "`template_name`";
			break;
			case "desc" :
				$sortby	= "`template_description`";
			break;
			default :
				$sortby	= "`template_name`";
			break;
		}
		?>
		<h1>E-Mail Templates</h1>
		<div class="tab-pane" id="tab-pane-1">
			<div class="tab-page">
				<h2 class="tab">Text Templates</h2>
				<form action="index.php?section=templates&action=delete" method="post" name="text_templates">
				<div align="right">
					<input type="button" class="button" value="New Template" onclick="window.location='index.php?section=templates&action=add&type=text'" />
				</div>
				<br />
				<?php
				$query	= "SELECT `template_id`, `template_name`, `template_description` FROM `".TABLES_PREFIX."templates` WHERE `template_type`='text' ORDER BY ".$sortby." ".strtoupper($order);
				$results	= $db->GetAll($query);
				if($results) {
					?>
					<table style="width: 100%; text-align: left" cellspacing="0" cellpadding="1" border="0">
					<tr>
						<td style="width: 8%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap">&nbsp;</td>
						<td style="width: 32%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?= (($sort == "name") ? "on" : "off") ?>.gif'); white-space: nowrap"><?= order_link("name", "Text Template Name", $order, $sort) ?></td>
						<td style="width: 50%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?= (($sort == "desc") ? "on" : "off") ?>.gif'); white-space: nowrap"><?= order_link("desc", "Description", $order, $sort) ?></td>
						<td style="width: 10%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap"><?= order_link("use", "In Use", $order, $sort, false) ?></td>
					</tr>
					<?php
					foreach($results as $result) {
						echo "<tr style=\"background-color: ".$colour."\"onmouseout=\"this.style.backgroundColor='".$colour."'\" onmouseover=\"this.style.backgroundColor='#F0FFD1'\">\n";
						echo "	<td style=\"white-space: nowrap\"><input type=\"checkbox\" name=\"deltemplates[]\" value=\"".$result["template_id"]."\" />&nbsp;<a href=\"index.php?section=templates&action=edit&id=".$result["template_id"]."\"><img src=\"./images/icon-edit-users.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Edit\" title=\"Edit ".html_encode($result["template_name"])."\" /></a></td>\n";
						echo "	<td class=\"cursor\" onclick=\"window.location='index.php?section=templates&action=view&id=".$result["template_id"]."'\">".html_encode($result["template_name"])."</td>\n";
						echo "	<td class=\"cursor\" onclick=\"window.location='index.php?section=templates&action=view&id=".$result["template_id"]."'\">".limit_chars(html_encode($result["template_description"]), 48)."</td>\n";
						echo "	<td class=\"cursor\" onclick=\"window.location='index.php?section=templates&action=view&id=".$result["template_id"]."'\">".template_count($result["template_id"])."</td>\n";
						echo "</tr>\n";
					}
					echo "<tr>\n";
					echo "	<td colspan=\"5\" style=\"border-top: 1px #333333 dotted; padding-top: 5px\"><input type=\"checkbox\" name=\"selectall\" value=\"1\" onclick=\"selection(this.form['deltemplates[]'])\" />&nbsp;<input type=\"submit\" value=\"Delete Selected\" class=\"button\" /></td>\n";
					echo "</tr>\n";
					echo "</table>\n";
					echo "</form>\n";
				} else {
					?>
					<div class="generic-message">
						There are no text message templates in your ListMessenger database.
						<br /><br />
						To add a new text template, click the <strong>New Template</strong> button above.
					</div>
					<?php
				}
				?>
			</div>
			<div class="tab-page">
				<h2 class="tab">HTML Templates</h2>
				<form action="index.php?section=templates&action=delete" method="post" name="html_templates">
				<div align="right">
					<input type="button" class="button" value="New Template" onclick="window.location='index.php?section=templates&action=add&type=html'" />
				</div>
				<br />
				<?php
				$query	= "SELECT `template_id`, `template_name`, `template_description` FROM `".TABLES_PREFIX."templates` WHERE `template_type`='html' ORDER BY ".$sortby." ".strtoupper($order);
				$results	= $db->GetAll($query);
				if($results) {
					?>
					<table style="width: 100%; text-align: left" cellspacing="0" cellpadding="1" border="0">
					<tr>
						<td style="width: 8%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap">&nbsp;</td>
						<td style="width: 32%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?= (($sort == "name") ? "on" : "off") ?>.gif'); white-space: nowrap"><?= order_link("name", "HTML Template Name", $order, $sort) ?></td>
						<td style="width: 50%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?= (($sort == "desc") ? "on" : "off") ?>.gif'); white-space: nowrap"><?= order_link("desc", "Description", $order, $sort) ?></td>
						<td style="width: 10%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap"><?= order_link("use", "In Use", $order, $sort, false) ?></td>
					</tr>
					<?php
					foreach($results as $result) {
						echo "<tr style=\"background-color: ".$colour."\"onmouseout=\"this.style.backgroundColor='".$colour."'\" onmouseover=\"this.style.backgroundColor='#F0FFD1'\">\n";
						echo "	<td style=\"white-space: nowrap\"><input type=\"checkbox\" name=\"deltemplates[]\" value=\"".$result["template_id"]."\" />&nbsp;<a href=\"index.php?section=templates&action=edit&id=".$result["template_id"]."\"><img src=\"./images/icon-edit-users.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Edit\" title=\"Edit ".html_encode($result["template_name"])."\" /></a></td>\n";
						echo "	<td class=\"cursor\" onclick=\"window.location='index.php?section=templates&action=view&id=".$result["template_id"]."'\">".html_encode($result["template_name"])."</td>\n";
						echo "	<td class=\"cursor\" onclick=\"window.location='index.php?section=templates&action=view&id=".$result["template_id"]."'\">".limit_chars(html_encode($result["template_description"]), 48)."</td>\n";
						echo "	<td class=\"cursor\" onclick=\"window.location='index.php?section=templates&action=view&id=".$result["template_id"]."'\">".template_count($result["template_id"])."</td>\n";
						echo "</tr>\n";
					}
					echo "<tr>\n";
					echo "	<td colspan=\"5\" style=\"border-top: 1px #333333 dotted; padding-top: 5px\"><input type=\"checkbox\" name=\"selectall\" value=\"1\" onclick=\"selection(this.form['deltemplates[]'])\" />&nbsp;<input type=\"submit\" value=\"Delete Selected\" class=\"button\" /></td>\n";
					echo "</tr>\n";
					echo "</table>\n";
					echo "</form>\n";
				} else {
					?>
					<div class="generic-message">
						There are no HTML message templates in your ListMessenger database.
						<br /><br />
						To add a new HTML template, click the <strong>New Template</strong> button above.
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<script language="Javascript" type="text/javascript">setupAllTabs(true);</script>
		<?php
	break;
}
?>
