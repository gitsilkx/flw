<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: compose.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

if(!defined("PARENT_LOADED"))		exit;
if(!$_SESSION["isAuthenticated"])	exit;

$STEP 			= $_GET["step"];
$msg_attachment	= (($_POST["msg_attachment"]) ? $_POST["msg_attachment"] : array());

if($_POST["back"]) {
	$STEP = $_GET["step"] - 2;
}

// Error checking step switch.
switch($STEP) {
	case "2" :
		if(strlen(trim($_POST["online_filename"])) > 0) {
			$STEP = 1; // Back to step 1.
			$filename = checkslashes(trim($_POST["online_filename"]));
			if(@file_exists($_SESSION["config"][PREF_PUBLIC_PATH]."files/".$filename)) {
				if(!@in_array($filename, $msg_attachment)) {
					$msg_attachment[] = $filename;

					$SUCCESS++;
					$SUCCESSSTR[] = "Successfully attached ".$filename." to this message.";
				} else {
					$ERROR++;
					$ERRORSTR[] = "The file that you have selected to be attached to this message already is attached to this message.";
				}
			} else {
				$ERROR++;
				$ERRORSTR[] = "The online file that you have attempted to attach does not exist in your public files directory.";
			}
		} elseif($_POST["attach_file"]) {
			$STEP = 1; // Back to step 1.
			if(@is_writeable($_SESSION["config"][PREF_PUBLIC_PATH]."files")) {
				switch($_FILES["attachment"]["error"]) {
					case 1 :
						$ERROR++;
						$ERRORSTR[] = "The file attachment that you're trying to add is larger than the maximum size that your server will allow you to upload.<br /><br />To correct this problem, either upload a smaller file or modify the &quot;<em>upload_max_filesize</em>&quot; directive in your servers php.ini file.";
					break;
					case 2 :
						$ERROR++;
						$ERRORSTR[] = "The file attachment that you're trying to add is larger than the maximum size that was specified in the HTML form.<br /><br />To correct this problem upload a smaller file attachment.";
					break;
					case 3 :
						$ERROR++;
						$ERRORSTR[] = "The file attachment that you're trying to add was only partially uploaded or your upload was interrupted.<br /><br />To correct this, please try to upload the file attachment again.";
					break;
					case 4 :
						$ERROR++;
						$ERRORSTR[] = "You've clicked the &quot;Attach File&quot; button; however, you have not selected a file on your hard drive to upload to the web server.";
					break;
					default :
						$filename = valid_filename($_FILES["attachment"]["name"]);
						if(!@in_array($filename, $msg_attachment)) {
							if(@move_uploaded_file($_FILES["attachment"]["tmp_name"], $_SESSION["config"][PREF_PUBLIC_PATH]."files/".$filename)) {
								$msg_attachment[] = $filename;
								$SUCCESS++;
								$SUCCESSSTR[] = "Successfully uploaded and attached ".$filename." to this message.";
							} else {
								$ERROR++;
								$ERRORSTR[] = "Unable to move &quot;".$filename."&quot; to the &quot;".$_SESSION["config"][PREF_PUBLIC_PATH]."files&quot; directory.<br /><br />To resolve this, please make sure that PHP has write permissions to the public files directory.";
							}
						} else {
							$ERROR++;
							$ERRORSTR[] = "The file that you have selected to be attached to this message already is attached to this message.";
						}
					break;
				}
			} else {
				$ERROR++;
				$ERRORSTR[] = "Your public files directory is not writeable by PHP, so unfortunately uploading your file will not be possible.<br /><br />To fix this please chmod the ".$_SESSION["config"][PREF_PUBLIC_PATH]."files/ directory to 777.";
			}
		} elseif($_POST["remove_attachment"]) {
			$STEP = 1; // Back to step 1.
			if(count($_POST["attachments"]) > 0) {
				$counter	= 0;
				$names	= array();
				foreach($_POST["attachments"] as $id => $value) {
					if($value == "1") {
						$counter++;
						$names[] = $msg_attachment[$id];
						unset($msg_attachment[$id]);
					}
				}
				$SUCCESS++;
				$SUCCESSSTR[] = "Successfully removed ".implode(", ", $names)." from this message.";
			}
		} elseif($_POST["save_draft"]) {
			$query	= "INSERT INTO `".TABLES_PREFIX."messages` (`message_id`, `message_date`, `message_title`, `message_subject`, `message_from`, `message_reply`, `message_priority`, `text_message`, `text_template`, `html_message`, `html_template`, `attachments`) VALUES (NULL, '".time()."', '".checkslashes($_POST["title"])."', '".checkslashes($_POST["subject"])."', '".checkslashes($_POST["from"])."', '".checkslashes($_POST["reply"])."', '".checkslashes($_POST["priority"])."', '".checkslashes($_POST["text_message"])."', '".checkslashes($_POST["text_template"])."', '".((trim(strip_tags($_POST["html_message"])) != "") ? checkslashes($_POST["html_message"]) : "")."', '".checkslashes($_POST["html_template"])."', '".((is_array($_POST["msg_attachment"])) ? checkslashes(serialize($_POST["msg_attachment"])) : "")."');";
			if($db->Execute($query)) {
				$id = $db->Insert_ID();
				if($id) {
					header("Location: ./index.php?section=message&id=".$id);
					exit;
				} else {
					if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
						@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to retrieve the insert ID of the previous query, redirecting to the Message Centre instead.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
					}
					header("Location: ./index.php?section=message");
					exit;
				}
			} else {
				$STEP = 1;
				if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
					@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to save draft message. Database said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
				}
				$ERROR++;
				$ERRORSTR[] = "Unable to save your message as a draft because there was an error inserting it into the database. The database server said: ".$db->ErrorMsg();
			}
		} elseif($_POST["save_proceed"]) {
			if(strlen(trim($_POST["from"])) < 1) {
				$ERROR++;
				$ERRORSTR[] = "Your from address seems to be empty, please make sure you format it correctly!<br /><strong>Example:</strong> &quot;My Name&quot; &lt;email@domain.com&gt;";
			}
			if(strlen(trim($_POST["reply"])) < 1) {
				$ERROR++;
				$ERRORSTR[] = "Your reply-to address seems to be empty, please make sure you format it correctly!<br /><strong>Example:</strong> &quot;My Name&quot; &lt;email@domain.com&gt;";
			}
			if(strlen(trim($_POST["title"])) < 1) {
				$ERROR++;
				$ERRORSTR[] = "Your internal message title seems to be empty, please enter a title for this message that uniquely identifies it in your message centre.";
			}
			if(strlen(trim($_POST["subject"])) < 1) {
				$_POST["subject"] = "(no subject)";
			}
			if(strlen(trim($_POST["priority"])) < 1) {
				$ERROR++;
				$ERRORSTR[] = "Please be sure to select a priority for this message. By default this is set to Normal and for the most part, probably shouldn't change.";
			}
			if(strlen(trim($_POST["text_message"])) < 1) {
				$ERROR++;
				$ERRORSTR[] = "It seems that you have not entered a text version of your message. ListMessenger requires a text version of your message because it uses a multi-part alternative message format when sending messages. Because it sends in this format, if a text version of the message isn't present and a subscriber's e-mail client isn't configured for HTML messages, the subscriber will see nothing but a blank e-mail.<br /><br />For more information, please visit our <a href=\"http://www.listmessenger.com/index.php/faq\" target=\"_blank\">Frequently Asked Questions</a>.";
			}
			// If there's an error, go back a step.
			if($ERROR) {
				$STEP = 1;
			}
		}
	break;
	case "3" :
		if($_POST["save_proceed"]) {
			if(strlen(trim($_POST["from"])) < 1) {
				$ERROR++;
				$ERRORSTR[] = "Your from address seems to be empty, please make sure you format it correctly!<br /><strong>Example:</strong> &quot;My Name&quot; &lt;email@domain.com&gt;";
			}
			if(strlen(trim($_POST["reply"])) < 1) {
				$ERROR++;
				$ERRORSTR[] = "Your reply-to address seems to be empty, please make sure you format it correctly!<br /><strong>Example:</strong> &quot;My Name&quot; &lt;email@domain.com&gt;";
			}
			if(strlen(trim($_POST["title"])) < 1) {
				$ERROR++;
				$ERRORSTR[] = "Your internal message title seems to be empty, please enter a title for this message that uniquely identifies it in your message centre.";
			}
			if(strlen(trim($_POST["subject"])) < 1) {
				$_POST["subject"] = "(no subject)";
			}
			if(strlen(trim($_POST["priority"])) < 1) {
				$ERROR++;
				$ERRORSTR[] = "Please be sure to select a priority for this message. By default this is set to Normal and for the most part, probably shouldn't change.";
			}
			if(strlen(trim($_POST["text_message"])) < 1) {
				$ERROR++;
				$ERRORSTR[] = "It seems that you have not entered a text version of your message. ListMessenger requires a text version of your message because it uses a multi-part alternative message format when sending messages. Because it sends in this format, if a text version of the message isn't present and a subscriber's e-mail client isn't configured for HTML messages, the subscriber will see nothing but a blank e-mail.<br /><br />For more information, please visit our <a href=\"http://www.listmessenger.com/index.php/faq\" target=\"_blank\">Frequently Asked Questions</a>.";
			}

			if(!$ERROR) {
				$query	= "INSERT INTO `".TABLES_PREFIX."messages` (`message_id`, `message_date`, `message_title`, `message_subject`, `message_from`, `message_reply`, `message_priority`, `text_message`, `text_template`, `html_message`, `html_template`, `attachments`) VALUES (NULL, '".time()."', '".checkslashes($_POST["title"])."', '".checkslashes($_POST["subject"])."', '".checkslashes($_POST["from"])."', '".checkslashes($_POST["reply"])."', '".checkslashes($_POST["priority"])."', '".checkslashes($_POST["text_message"])."', '".checkslashes($_POST["text_template"])."', '".((trim(strip_tags($_POST["html_message"])) != "") ? checkslashes($_POST["html_message"]) : "")."', '".checkslashes($_POST["html_template"])."', '".((is_array($_POST["msg_attachment"])) ? checkslashes(serialize($_POST["msg_attachment"])) : "")."');";
				if($db->Execute($query)) {
					$id = $db->Insert_ID();
					if($id) {
						header("Location: ./index.php?section=message&action=view&id=".$id);
						exit;
					} else {
						if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
							@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to retrieve the insert ID of the previous query, redirecting to the Message Centre instead.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
						}
						header("Location: ./index.php?section=message");
						exit;
					}
				} else {
					$STEP = 1;
					if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
						@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to save draft message. Database said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
					}
					$ERROR++;
					$ERRORSTR[] = "Unable to save your message as a draft because there was an error inserting it into the database. The database server said: ".$db->ErrorMsg();
				}
			} else {
				$STEP = 2;
			}
		}
	break;
	default :
	break;
}

// Body content step switch.
switch($STEP) {
	case "2" :
		$COLLAPSED = explode(",", $_COOKIE["display"]["compose"]["collapsed"]);

		$i = count($HEAD);
		$HEAD[$i]  = "<script type=\"text/javascript\" src=\"./javascript/tabpane/tabpane.js\"></script>\n";
		$HEAD[$i] .= "<link type=\"text/css\" rel=\"StyleSheet\" href=\"./css/luna/tab.css\" />\n";

		// Turn the HTML message into a session so we can pass it to the preview script.
		if(trim(strip_tags($_POST["html_message"])) != "") {
			$_SESSION["html_message"] = urlencode(checkslashes(trim($_POST["html_message"]), 1));
		} else {
			unset($_SESSION["html_message"]);
		}

		?>
		<h1>Compose Message</h1>
		<?php
		if($ERROR) {
			echo display_error($ERRORSTR);
		}
		?>
		Please confirm the contents of your message by reviewing it below. You can toggle back and forth between Text Version and HTML Version using the tabs.
		<br /><br />
		<table style="width: 100%; margin: 3px" cellspacing="0" cellpadding="1" border="0">
		<tr>
			<td class="form-row-nreq" style="width: 25%">From:&nbsp;</td>
			<td style="width: 75%"><?php echo html_encode(checkslashes($_POST["from"], 1)); ?></td>
		</tr>
		<tr>
			<td class="form-row-nreq" style="width: 25%">Reply-to:&nbsp;</td>
			<td style="width: 75%"><?php echo html_encode(checkslashes($_POST["reply"], 1)); ?></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="form-row-nreq" style="width: 25%">Internal Title:&nbsp;</td>
			<td style="width: 75%"><?php echo html_encode(checkslashes($_POST["title"], 1)); ?></td>
		</tr>
		<tr>
			<td class="form-row-nreq" style="width: 25%">Message Subject:&nbsp;</td>
			<td style="width: 75%"><?php echo html_encode(checkslashes($_POST["subject"], 1)); ?></td>
		</tr>
		<tr>
			<td class="form-row-nreq" style="width: 25%">Priority:&nbsp;</td>
			<td style="width: 75%">
				<?php
				switch($_POST["priority"]) {
					case "1" :
						echo "Highest";
					break;
					case "3" :
						echo "Normal";
					break;
					default :
						echo "Lowest";
					break;
				}
				?>
			</td>
		</tr>
		<?php
		if(count($msg_attachment) > 0) {
			echo "<tr>\n";
			echo "	<td colspan=\"2\">&nbsp;</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "	<td class=\"form-row-nreq\" style=\"vertical-align: top\">File Attachments:&nbsp;</td>\n";
			echo "	<td>\n";
			echo "		<table style=\"width: 100%; text-align: left\" cellspacing=\"0\" cellpadding=\"1\" border=\"0\">\n";
			echo "		<tr>\n";
			echo "			<td style=\"width: 80%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-on.gif'); white-space: nowrap\">File Name</td>\n";
			echo "			<td style=\"width: 20%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap\">File Size</td>\n";
			echo "		</tr>\n";
						natsort($msg_attachment);
						foreach($msg_attachment as $id => $filename) {
							echo "<tr>\n";
							echo "	<td><a href=\"".$_SESSION["config"][PREF_PUBLIC_URL]."files/".$filename."\" target=\"_blank\">".$filename."</a></td>\n";
							echo "	<td>".readable_size(@filesize($_SESSION["config"][PREF_PUBLIC_PATH]."files/".$filename))."</td>\n";
							echo "</tr>\n";
						}
			echo "		</table>\n";
			echo "	</td>\n";
			echo "</tr>\n";
		}
		?>
		</table>
		<br />

		<div class="tab-pane" id="tab-pane-1">
			<div class="tab-page" style="height: 100%">
				<h2 class="tab">Text Version</h2>
				<?php echo checkslashes(wordwrap(nl2br(html_encode($_POST["text_message"])), $_SESSION["config"][PREF_WORDWRAP], "<br />", 1), 1); ?>
			</div>
			<div class="tab-page" style="height: 100%">
				<h2 class="tab">HTML Version</h2>
				<?php
				if((isset($_SESSION["html_message"])) && ($_SESSION["html_message"])) {
					?>
					<iframe src="./preview.php?sid=<?php echo session_id(); ?>" style="border: 1px; width: 100%; height: 400px"></iframe>
					<?php
				} else {
					?>
					<div class="generic-message">
						There is no HTML version of this message available, which is fine, your subscribers will simply receive your message as plain text.
						<br /><br />
						If you would like to add an HTML message you press the back button below.
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<script language="Javascript" type="text/javascript">setupAllTabs(false);</script>
		<br />
		<table style="width: 100%; margin: 3px" cellspacing="0" cellpadding="1" border="0">
		<tr>
			<td style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px" colspan="2">
				<form action="index.php?section=compose&step=3" method="post">
				<input type="hidden" name="from" value="<?php echo html_encode(checkslashes($_POST["from"], 1)); ?>" />
				<input type="hidden" name="reply" value="<?php echo html_encode(checkslashes($_POST["reply"], 1)); ?>" />
				<input type="hidden" name="title" value="<?php echo html_encode(checkslashes($_POST["title"], 1)); ?>" />
				<input type="hidden" name="subject" value="<?php echo html_encode(checkslashes($_POST["subject"], 1)); ?>" />
				<input type="hidden" name="priority" value="<?php echo html_encode(checkslashes($_POST["priority"], 1)); ?>" />
				<input type="hidden" name="text_template" value="<?php echo html_encode(checkslashes($_POST["text_template"], 1)); ?>" />
				<input type="hidden" name="text_message" value="<?php echo html_encode(checkslashes($_POST["text_message"], 1)); ?>" />
				<input type="hidden" name="html_template" value="<?php echo html_encode(checkslashes($_POST["html_template"], 1)); ?>" />
				<input type="hidden" name="html_message" value="<?php echo html_encode(checkslashes($_POST["html_message"], 1)); ?>" />
				<?php
				if(count($msg_attachment) > 0) {
					foreach($msg_attachment as $id => $filename) {
						echo "<input type=\"hidden\" name=\"msg_attachment[".$id."]\" value=\"".$filename."\" />\n";
					}
				}
				?>
				<input type="submit" name="back" class="button" value="Back" />&nbsp;
				<input type="submit" name="save_proceed" class="button" value="Proceed" />
				</form>
			</td>
		</tr>
		</table>
		<?php
	break;
	default :
		if(@function_exists("pspell_new")) {
			$HEAD[] = "<script type=\"text/javascript\" language=\"javascript\" src=\"./javascript/spellcheck/spellcheck.js\"></script>\n";
		}

		$i = count($SIDEBAR);
		$SIDEBAR[$i]  = "<h1>Variables</h1>";
		$SIDEBAR[$i] .= "<div style=\"padding: 3px; background-color: #FFFFFF; border-left: 1px #CCCCCC solid; border-right: 1px #CCCCCC solid; border-bottom: 1px #CCCCCC solid;\">\n";
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
		?>
		<h1>Compose Message</h1>
		<?php
		if($ERROR) {
			echo display_error($ERRORSTR);
		} elseif($SUCCESS) {
			echo display_success($SUCCESSSTR);
		}
		?>
		<form action="index.php?section=compose&step=2" method="post" enctype="multipart/form-data" id="compose_message">
		<input type="hidden" id="online_filename" name="online_filename" value="" />
		<?php
		if(count($msg_attachment) > 0) {
			foreach($msg_attachment as $id => $filename) {
				echo "<input type=\"hidden\" name=\"msg_attachment[".$id."]\" value=\"".$filename."\" />\n";
			}
		}
		?>
		<table style="width: 100%; margin: 3px" cellspacing="0" cellpadding="1" border="0">
		<tr>
			<td class="form-row-req" style="width: 25%"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>From</em></strong><br />This is the from name and e-mail address that the end user will see when viewing your message.<br /><br /><strong>Tip:</strong><br />Make sure you keep the formatting of the from address the same.'));">From:</span>&nbsp;</td>
			<td style="width: 75%"><input type="text" class="text-box" style="width: 250px" name="from" value="<?php echo (($_POST) ? html_encode(checkslashes($_POST["from"], 1)) : html_encode("\"".$_SESSION["config"][PREF_FRMNAME_ID]."\" <".$_SESSION["config"][PREF_FRMEMAL_ID].">")); ?>" onkeypress="return handleEnter(this, event)" /></td>
		</tr>
		<tr>
			<td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Reply-to</em></strong><br />This is the reply-to name and e-mail address that the end user will see when replying to your message.<br /><br /><strong>Tip:</strong><br />Make sure you keep the formatting of the reply-to address the same.'));">Reply-to:</span>&nbsp;</td>
			<td><input type="text" class="text-box" style="width: 250px" name="reply" value="<?php echo (($_POST) ? html_encode(checkslashes($_POST["reply"], 1)) : html_encode("\"".$_SESSION["config"][PREF_FRMNAME_ID]."\" <".$_SESSION["config"][PREF_RPYEMAL_ID].">")); ?>" onkeypress="return handleEnter(this, event)" /></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Internal Title</em></strong><br />This is an internal identifier for you, the administrator, so you can easily identify this message in the Message Centre. This field will never been seen by an end-user, it is available to the administrator.'));">Internal Title:</span>&nbsp;</td>
			<td><input type="text" class="text-box" style="width: 250px" id="title" name="title" value="<?php echo html_encode(checkslashes($_POST["title"], 1)); ?>" onkeypress="return handleEnter(this, event)" /></td>
		</tr>
		<tr>
			<td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Subject</em></strong><br />This is the subject of the message that you are composing.<br /><br /><strong>Tip:</strong><br />Keep in mind, you can use e-mail variables in the subject as well as the body for personalization!'));">Message Subject:</span>&nbsp;</td>
			<td><input type="text" class="text-box" style="width: 250px" name="subject" value="<?php echo html_encode(checkslashes($_POST["subject"], 1)); ?>" onkeypress="return handleEnter(this, event)" /></td>
		</tr>
		<tr>
			<td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Message Priority</em></strong><br />This is the level of priority of the message. Please note, that you will almost always want this set to Normal because if you set it to High, you will have a greater chance of spam filters considering your message as spam.'));">Message Priority:</span>&nbsp;</td>
			<td>
				<select name="priority" onkeypress="return handleEnter(this, event)">
				<option value="1"<?php echo (($_POST) ? (($_POST["priority"] == "1") ? " selected=\"selected\"" : "") : ""); ?>>Highest</option>
				<option value="3"<?php echo (($_POST) ? (($_POST["priority"] == "3") ? " selected=\"selected\"" : "") : " selected=\"selected\""); ?>>Normal</option>
				<option value="5"<?php echo (($_POST) ? (($_POST["priority"] == "5") ? " selected=\"selected\"" : "") : ""); ?>>Lowest</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" style="padding: 0px; margin: 0px">
				<table style="width: 98%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Text Version</em></strong><br />This is the plain text version of your message and it is a required field. If you plan on sending an HTML version, you must include a text version containing either the text of the HTML message or an explanation as to where the user can view the HTML version with their web-browser.'));">Text Version:</span>&nbsp;</td>
					<td style="text-align: right">
						<?php
						$query		= "SELECT `template_id`,`template_name` FROM `".TABLES_PREFIX."templates` WHERE `template_type`='text' ORDER BY `template_name` ASC";
						$results	= $db->GetAll($query);
						if($results) {
							?>
							Text Template:
							<select name="text_template" style="width: 200px">
								<option value="">-- Optional Text Template --</option>
								<?php
								foreach($results as $result) {
									echo "<option value=\"".$result["template_id"]."\"".(($_POST["text_template"] == $result["template_id"]) ? " selected=\"selected\"" : "").">".$result["template_name"]."</option>\n";
								}
								?>
							</select>
							<?php
						} else {
							echo "<span style=\"color: #666666\">There are no <strong>text</strong> templates: <a href=\"index.php?section=templates&action=add&type=text\">Click here</a> to add one.</span>";
						}
						?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea autocomplete="off" name="text_message" style="width: 98%; height: 150px"><?php echo html_encode(checkslashes($_POST["text_message"], 1)); ?></textarea>
			</td>
		</tr>
		<?php if(@function_exists("pspell_new")) : ?>
		<tr>
			<td colspan="2">
				<input type="button" class="button" value="Spell Checking" onclick="spellCheck('compose_message', 'text_message');" />
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" style="padding: 0px; margin: 0px">
				<table style="width: 98%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>HTML Version</em></strong><br />This is the optional HTML version of your message. <?php echo ((($_SESSION["config"][PREF_USERTE] != "disabled") && ($RTE_ENABLED)) ? "You have the Rich Text Editor enabled, so you can just type your message, changing the font size and colour as you would with any text editor." : "You have the Rich Text Editor disabled, so your message must be provided to this box in pre formatted HTML."); ?>'));">HTML Version:</span>&nbsp;</td>
					<td style="text-align: right">
						<?php
						$query	= "SELECT `template_id`,`template_name` FROM `".TABLES_PREFIX."templates` WHERE `template_type`='html' ORDER BY `template_name` ASC";
						$results	= $db->GetAll($query);
						if($results) {
							?>
							HTML Template:
							<select name="html_template" style="width: 200px">
								<option value="">-- Optional HTML Template --</option>
								<?php
								foreach($results as $result) {
									echo "<option value=\"".$result["template_id"]."\"".(($_POST["html_template"] == $result["template_id"]) ? " selected=\"selected\"" : "").">".$result["template_name"]."</option>\n";
								}
								?>
							</select>
							<?php
						} else {
							echo "<span style=\"color: #666666\">There are no <strong>html</strong> templates: <a href=\"index.php?section=templates&action=add&type=html\">Click here</a> to add one.</span>";
						}
						?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea autocomplete="off" id="html_message" name="html_message" style="width: 98%; height: 350px"><?php echo html_encode(trim(checkslashes($_POST["html_message"], 1))); ?></textarea>
				<?php
				if($RTE_ENABLED) {
					rte_display();
				}
				?>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="form-row-nreq" style="white-space: nowrap"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>File Attachment</em></strong><br />You have the option of adding file attachments to your message which will be sent out when you send the message.<br /><br /><strong>Tip:</strong><br />Please keep in mind that sending file attachments may increase the load on your server while sending messages and also may be more taxing on your mail server. Please ensure that you set the &quot;Messages Per Refresh&quot; and &quot;Pause Between Refreshes&quot; accordingly in Preferences.'));">Add File Attachment:</span>&nbsp;</td>
			<td>
				<table style="width: 98%" cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td><input type="file" name="attachment" class="file" size="16" /></td>
					<td style="text-align: right; white-space: nowrap">
						<input type="submit" name="attach_file" class="button" value="Attach File" />&nbsp;
						<input type="button" name="online_file" class="button" value="Online Files" onclick="openAttachements('<?php echo session_id(); ?>')" />
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<?php
		if(@count($msg_attachment) > 0) {
			echo "<tr>\n";
			echo "	<td>&nbsp;</td>\n";
			echo "	<td style=\"padding-top: 5px\">\n";
			echo "		<table style=\"width: 98%; text-align: left\" cellspacing=\"0\" cellpadding=\"1\" border=\"0\">\n";
			echo "		<tr>\n";
			echo "			<td style=\"width: 5%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap\">&nbsp;</td>\n";
			echo "			<td style=\"width: 75%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-on.gif'); white-space: nowrap\">File Name</td>\n";
			echo "			<td style=\"width: 20%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap\">File Size</td>\n";
			echo "		</tr>\n";
						natsort($msg_attachment);
						foreach($msg_attachment as $id => $filename) {
							echo "<tr onmouseout=\"this.style.backgroundColor='#FFFFFF'\" onmouseover=\"this.style.backgroundColor='#F0FFD1'\">\n";
							echo "	<td><input type=\"checkbox\" name=\"attachments[".$id."]\" value=\"1\" /></td>\n";
							echo "	<td><a href=\"".$_SESSION["config"][PREF_PUBLIC_URL]."files/".$filename."\" target=\"_blank\">".$filename."</a></td>\n";
							echo "	<td>".readable_size(@filesize($_SESSION["config"][PREF_PUBLIC_PATH]."files/".$filename))."</td>\n";
							echo "</tr>\n";
						}
			echo "		</table>\n";
			echo "		<div style=\"width: 98%; border-top: 1px #666666 dotted; margin-top: 5px; padding-top: 5px; text-align: right\">\n";
			echo "			<input type=\"submit\" name=\"remove_attachment\" class=\"button\" value=\"Remove\" />\n";
			echo "		</div>\n";
			echo "	</td>\n";
			echo "</tr>\n";
		}
		?>
		<tr>
			<td colspan="2" style="border-bottom: 1px #666666 dotted;">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<div style="width: 98%; padding-top: 5px; text-align: right">
					<input type="submit" name="save_draft" class="button" value="Save as Draft" />&nbsp;
					<input type="submit" name="save_proceed" class="button" value="Proceed" />
				</div>
			</td>
		</tr>
		</table>
		</form>

		<form action="./spellcheck.php?sid=<?php echo session_id(); ?>" method="post" name="spell_form" id="spell_form" target="spellDialogBox">
		<input type="hidden" name="spell_formname"	value="" />
		<input type="hidden" name="spell_fieldname"	value="" />
		<input type="hidden" name="spellstring"		value="" />
		</form>
		<?php
	break;
}
?>