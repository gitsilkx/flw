<?php
/*
  ListMessenger - Professional Mailing List Management
  Copyright  2007 Silentweb [http://www.silentweb.ca]

  Developed By: Matt Simpson <msimpson@listmessenger.com>

  For the most recent version, visit the ListMessenger website:
  [http://www.listmessenger.com]

  License Information is found in docs/licence.html
  $Id: message.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

if(!defined("PARENT_LOADED"))  exit;
if(!$_SESSION["isAuthenticated"])  exit;

$COLLAPSED  = explode(",", $_COOKIE["display"]["message"]["collapsed"]);
$totalrows  = false;
$seeking  = array();
$seek    = false;
$action    = false;

switch($_GET["action"]) {
  case "cancel" :
    if((($_GET["qid"]) && ((int) trim($_GET["qid"]))) && (($_GET["mid"]) && ((int) trim($_GET["mid"])))) {
      $query  = "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_id`='".checkslashes(trim($_GET["mid"]))."'";
      $result  = $db->GetRow($query);
      if($result) {
        $_SESSION["message_details"]             = array();
        $_SESSION["message_details"]["message_id"]      = $result["message_id"];
        $_SESSION["message_details"]["message_title"]    = $result["message_title"];
        $_SESSION["message_details"]["message_subject"]    = $result["message_subject"];
        $_SESSION["message_details"]["message_from"]    = $result["message_from"];
        $_SESSION["message_details"]["message_reply"]    = $result["message_reply"];
        $_SESSION["message_details"]["message_priority"]  = $result["message_priority"];
        $_SESSION["message_details"]["text_message"]    = $result["text_message"];
        $_SESSION["message_details"]["text_template"]    = $result["text_template"];
        $_SESSION["message_details"]["html_message"]    = $result["html_message"];
        $_SESSION["message_details"]["html_template"]    = $result["html_template"];
        $_SESSION["message_details"]["attachments"]      = $result["attachments"];

        $action  = "cancel";
        $qid  = trim($_GET["qid"]);
        require_once("progress.inc.php");
      } else {
        if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
          @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to retrieve the provided message id [".$_GET["id"]."].\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
        }
        $ERROR++;
        $ERRORSTR[]  = "Unable to find any message in the Message Centre with an ID of [".$_GET["id"]."].<br /><br />Please <a href=\"./index.php?section=message\">click here</a> to return to the Message Centre.";
        echo display_error($ERRORSTR);
      }
    } else {
      header("Location: index.php?section=message");
      exit;
    }
  break;
  case "copy" :
    if(strlen(trim($_POST["id"])) < 1) {
      $ERROR++;
      $ERRORSTR[] = "There was no message id found in the copy request. Please try again, but specify a message id.";
      if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
        @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tNo message id was found in the copy message request.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
      }
    }
    if(strlen(trim($_POST["title"])) < 1) {
      $ERROR++;
      $ERRORSTR[] = "There was no message title found in the copy request. Please try again, but specify a message title.";
      if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
        @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tNo new message title was found in the copy message request.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
      }
    }

    $query  = "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_title`='".checkslashes($_POST["title"])."'";
    $result  = $db->GetRow($query);
    if($result) {
      $ERROR++;
      $ERRORSTR[] = "The new message title that you've entered already exists in the database. Please try again, but specify a unique message title.";
      if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
        @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tThe provided message title was non-unique.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
      }
    }

    $query  = "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_id`='".checkslashes($_POST["id"])."'";
    $result  = $db->GetRow($query);
    if(!$result) {
      $ERROR++;
      $ERRORSTR[] = "The message id that was specified in the copy request could not be found in the database. Please try again, but specify a valid message id.";
      if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
        @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tThe requested message id [".checkslashes($_POST["id"])."] does not exist in the database. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
      }
    }

    ?>
    <h1>Copy Message</h1>
    <?php
    if(!$ERROR) {
      $query  = "INSERT INTO `".TABLES_PREFIX."messages` (`message_id`, `message_date`, `message_title`, `message_subject`, `message_from`, `message_reply`, `message_priority`, `text_message`, `text_template`, `html_message`, `html_template`, `attachments`) VALUES (NULL, '".time()."', '".trim(checkslashes($_POST["title"]))."', '".addslashes($result["message_subject"])."', '".addslashes($result["message_from"])."', '".addslashes($result["message_reply"])."', '".addslashes($result["message_priority"])."', '".addslashes($result["text_message"])."', '".addslashes($result["text_template"])."', '".addslashes($result["html_message"])."', '".addslashes($result["html_template"])."', '".addslashes($result["attachments"])."');";
      if($db->Execute($query)) {
        $ONLOAD[] = "setTimeout('window.location=\'index.php?section=message&action=view&id=".$db->Insert_Id()."\'', 5000)";

        $SUCCESS++;
        $SUCCESSSTR[] = "You have successfully copied <strong>".html_encode(checkslashes($_POST["title"], 1))."</strong>.<br /><br />You will be automatically redirected in 5 seconds, or <a href=\"index.php?section=message&action=view&id=".$db->Insert_Id()."\">click here</a> if you prefer not to wait.";

        echo display_success($SUCCESSSTR);
      } else {
        $ONLOAD[] = "setTimeout('window.location=\'index.php?section=message&action=view&id=".$_POST["id"]."\'', 5000)";

        $ERROR++;
        $ERRORSTR[] = "Unable to copy your message to the new message title. Please check your error log for more information. ".$db->ErrorMsg();

        if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
          @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to copy the old message to the new Message Title. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
        }

        echo display_error($ERRORSTR);
      }
    } else {
      $ONLOAD[] = "setTimeout('window.location=\'index.php?section=message&action=view&id=".$_POST["id"]."\'', 5000)";
      echo display_error($ERRORSTR);
    }
  break;
  case "delete" :
    ?>
    <h1>Message Removal</h1>
    <?php
    if($_POST["confirmed"] == "true") {
      if((@is_array($_POST["ids"])) && (@count($_POST["ids"]) > 0)) {
        $ONLOAD[] = "setTimeout('window.location=\'index.php?section=message\'', 5000)";

        foreach($_POST["ids"] as $message_id) {
          $can_delete = true;
          if($message_id == $_SESSION["config"][PREF_POSTSUBSCRIBE_MSG]) {
            $ERROR++;
            $ERRORSTR[]  = "This message is marked as being the message which will be sent to subscribers after they successfully subscribe to your mailing list.";
            $can_delete  = false;
          } elseif($message_id == $_SESSION["config"][PREF_POSTUNSUBSCRIBE_MSG]) {
            $ERROR++;
            $ERRORSTR[]  = "This message is marked as being the message which will be sent to subscribers after they successfully unsubscribe from your mailing list.";
            $can_delete  = false;
          }

          if($can_delete) {
            $query = "DELETE FROM `".TABLES_PREFIX."messages` WHERE `message_id`='".checkslashes($message_id)."'";
            if(!$db->Execute($query)) {
              if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete message id [".$message_id."]. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
              }
              $ERROR++;
              $ERRORSTR[] = "Unable to delete message id [".$message_id."] from the database.";
            } else {
              $SUCCESS++;
            }
          }
        }
        if($ERROR) {
          echo display_error($ERRORSTR);
        } elseif($SUCCESS) {
          $SUCCESSSTR[] = "You have successfully deleted ".$SUCCESS." message".(($SUCCESS != 1) ? "s" : "")." from the database.<br /><br />You will be automatically redirected in 5 seconds, or <a href=\"index.php?section=message\">click here</a> if you prefer not to wait.";
          echo display_success($SUCCESSSTR);
        }
      } else {
        header("Location: index.php?section=message");
        exit;
      }
    } else {
      if((@is_array($_POST["ids"])) && (@count($_POST["ids"]) > 0)) {
      ?>
      Please confirm that you wish to delete the following <?php echo count($_POST["ids"]); ?> message<?php echo ((count($_POST["ids"]) != 1) ? "s" : ""); ?>:<br />
      <form action="index.php?section=message&action=delete" method="post">
      <input type="hidden" name="confirmed" value="true" />
      <table style="width: 100%; text-align: left" cellspacing="0" cellpadding="1" border="0">
      <tr>
        <td style="width: 4%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap">&nbsp;</td>
        <td style="width: 20%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "date") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("date", "Creation Date", $order, $sort); ?></td>
        <td style="width: 43%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "title") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("title", "Message Title", $order, $sort); ?></td>
        <td style="width: 34%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "subject") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("subject", "Message Subject", $order, $sort); ?></td>
      </tr>
      <?php
      if(isset($_POST["ids"])) {
        foreach($_POST["ids"] as $message_id) {
          $can_delete = true;
          if($message_id == $_SESSION["config"][PREF_POSTSUBSCRIBE_MSG]) {
            $can_delete  = false;
          } elseif($message_id == $_SESSION["config"][PREF_POSTUNSUBSCRIBE_MSG]) {
            $can_delete  = false;
          }

          $query  = "SELECT `message_date`, `message_title`, `message_subject` FROM `".TABLES_PREFIX."messages` WHERE `message_id`='".checkslashes($message_id)."'";
          $result  = $db->GetRow($query);
          if($result) {
            echo "<tr onmouseout=\"this.style.backgroundColor='#FFFFFF'\" onmouseover=\"this.style.backgroundColor='#F0FFD1'\">\n";
            echo "  <td style=\"white-space: nowrap\">".(($can_delete) ? "<input type=\"checkbox\" name=\"ids[]\" value=\"".checkslashes($message_id)."\" checked=\"checked\" />" : "<img src=\"./images/pixel.gif\" alt=\"\" title=\"\" width=\"18\" height=\"18\" />")."</td>\n";
            echo "  <td class=\"cursor\">".display_date("m/d/Y H:i", $result["message_date"])."</td>\n";
            echo "  <td class=\"cursor\">".html_encode(limit_chars($result["message_title"], 38))."</td>\n";
            echo "  <td class=\"cursor\">".html_encode(limit_chars($result["message_subject"], 30))."</td>\n";
            echo "</tr>\n";
          }
        }
      }
      echo "<tr>\n";
      echo "  <td colspan=\"4\" style=\"text-align: right; border-top: 1px #333333 dotted; padding-top: 5px\"><input type=\"button\" value=\"Cancel\" class=\"button\" onclick=\"window.location='index.php?section=message'\" />&nbsp;<input type=\"submit\" value=\"Confirm\" class=\"button\" /></td>\n";
      echo "</tr>\n";
      echo "</table>\n";
      echo "</form>\n";
      } else {
        header("Location: index.php?section=message");
        exit;
      }
    }
  break;
  case "edit" :
    if((isset($_GET["id"])) && ((int) trim($_GET["id"]))) {
      $query  = "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_id`='".checkslashes(trim($_GET["id"]))."'";
      $result  = $db->GetRow($query);
      if($result) {
        $msg_attachment = (($_POST) ? (($_POST["msg_attachment"]) ? $_POST["msg_attachment"] : array()) : (($result["attachments"] != "") ? unserialize($result["attachments"]) : array()));

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
          if(count($_POST["attachments"]) > 0) {
            $counter  = 0;
            $names  = array();
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
        } elseif($_POST["save_changes"]) {
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
            $query  = "UPDATE `".TABLES_PREFIX."messages` SET `message_title`='".checkslashes($_POST["title"])."', `message_subject`='".checkslashes($_POST["subject"])."', `message_from`='".checkslashes($_POST["from"])."', `message_reply`='".checkslashes($_POST["reply"])."', `message_priority`='".checkslashes($_POST["priority"])."', `text_message`='".checkslashes($_POST["text_message"])."', `text_template`='".checkslashes($_POST["text_template"])."', `html_message`='".((trim(strip_tags($_POST["html_message"])) != "") ? checkslashes($_POST["html_message"]) : "")."', `html_template`='".checkslashes($_POST["html_template"])."', `attachments`='".((is_array($_POST["msg_attachment"])) ? checkslashes(serialize($_POST["msg_attachment"])) : "")."' WHERE `message_id`='".checkslashes($_POST["message_id"])."';";
            if($db->Execute($query)) {
              header("Location: ./index.php?section=message&action=view&id=".$_POST["message_id"]);
              exit;
            } else {
              if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to save draft message. Database said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
              }
              $ERROR++;
              $ERRORSTR[] = "Unable to save your changes to this message because there was an error updating the database. The database server said: ".$db->ErrorMsg();
            }
          }
        }

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

        $query  = "SELECT `field_sname`,`field_lname` FROM `".TABLES_PREFIX."cfields` WHERE `field_type`<>'linebreak'";
        $results  = $db->GetAll($query);
        if($results) {
          foreach($results as $sresult) {
            $SIDEBAR[$i] .= "<div class=\"cursor-help\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Custom Field Variables', 'content', '<strong>Variable: <em>[".$sresult["field_sname"]."]</em></strong><br />".(($sresult["field_lname"]) ? "<em>".addslashes($sresult["field_lname"])."</em><br />" : "")."This is a custom variable that can be used in any template, message body or message subject.'));\">[".$sresult["field_sname"]."]</div>";
          }
        }
        $SIDEBAR[$i] .= "<br />\n";
        $SIDEBAR[$i] .= "</div>\n";
        ?>
        <h1>Edit Message <span style="font-size: 11px">[<?php echo html_encode(checkslashes($result["message_title"], 1)); ?>]</span></h1>
        <?php
        if($ERROR) {
          echo display_error($ERRORSTR);
        } elseif($SUCCESS) {
          echo display_success($SUCCESSSTR);
        }
        ?>
        <form action="index.php?section=message&action=edit&id=<?php echo html_encode($_GET["id"]); ?>" method="post" enctype="multipart/form-data" id="compose_message">
        <input type="hidden" name="message_id" value="<?php echo html_encode($_GET["id"]); ?>" />
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
          <td style="width: 75%"><input type="text" class="text-box" style="width: 250px" name="from" value="<?php echo (($_POST) ? html_encode(checkslashes($_POST["from"], 1)) : html_encode(checkslashes($result["message_from"], 1))); ?>" /></td>
        </tr>
        <tr>
          <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Reply-to</em></strong><br />This is the reply-to name and e-mail address that the end user will see when replying to your message.<br /><br /><strong>Tip:</strong><br />Make sure you keep the formatting of the reply-to address the same.'));">Reply-to:</span>&nbsp;</td>
          <td><input type="text" class="text-box" style="width: 250px" name="reply" value="<?php echo (($_POST) ? html_encode(checkslashes($_POST["reply"], 1)) : html_encode(checkslashes($result["message_reply"], 1))); ?>" /></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Internal Title</em></strong><br />This is an internal identifier for you, the administrator, so you can easily identify this message in the Message Centre. This field will never been seen by an end-user, it is available to the administrator.'));">Internal Title:</span>&nbsp;</td>
          <td><input type="text" class="text-box" style="width: 250px" id="title" name="title" value="<?php echo (($_POST) ? html_encode(checkslashes($_POST["title"], 1)) : html_encode(checkslashes($result["message_title"], 1))); ?>" /></td>
        </tr>
        <tr>
          <td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Subject</em></strong><br />This is the subject of the message that you are composing.<br /><br /><strong>Tip:</strong><br />Keep in mind, you can use e-mail variables in the subject as well as the body for personalization!'));">Message Subject:</span>&nbsp;</td>
          <td><input type="text" class="text-box" style="width: 250px" name="subject" value="<?php echo (($_POST) ? html_encode(checkslashes($_POST["subject"], 1)) : html_encode(checkslashes($result["message_subject"], 1))); ?>" /></td>
        </tr>
        <tr>
          <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>Message Priority</em></strong><br />This is the level of priority of the message. Please note, that you will almost always want this set to Normal because if you set it to High, you will have a greater chance of spam filters considering your message as spam.'));">Message Priority:</span>&nbsp;</td>
          <td>
            <select name="priority">
            <option value="1"<?php echo (($_POST) ? (($_POST["priority"] == "1") ? " selected=\"selected\"" : "") : (($result["message_priority"] == "1") ? " selected=\"selected\"" : "")); ?>>Highest</option>
            <option value="3"<?php echo (($_POST) ? (($_POST["priority"] == "3") ? " selected=\"selected\"" : "") : (($result["message_priority"] == "3") ? " selected=\"selected\"" : "")); ?>>Normal</option>
            <option value="5"<?php echo (($_POST) ? (($_POST["priority"] == "5") ? " selected=\"selected\"" : "") : (($result["message_priority"] == "5") ? " selected=\"selected\"" : "")); ?>>Lowest</option>
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
                $query  = "SELECT `template_id`,`template_name` FROM `".TABLES_PREFIX."templates` WHERE `template_type`='text' ORDER BY `template_name` ASC";
                $results  = $db->GetAll($query);
                if($results) {
                  ?>
                  Text Template:
                  <select name="text_template" style="width: 200px">
                    <option value="">-- Optional Text Template --</option>
                    <?php
                    foreach($results as $sresult) {
                      echo "<option value=\"".$sresult["template_id"]."\"".(($_POST) ? (($_POST["text_template"] == $sresult["template_id"]) ? " selected=\"selected\"" : "") : (($result["text_template"] == $sresult["template_id"]) ? " selected=\"selected\"" : "")).">".$sresult["template_name"]."</option>\n";
                    }
                    ?>
                  </select>
                  <?php
                } else {
                  echo "<span style=\"color: #666666\">There are no <strong>text</strong> templates: <a href=\"index.php?section=templates&action=add&type=text\">Click here</a> to add one.</span>";
                  echo "<input type=\"hidden\" name=\"text_template\" value=\"0\" />\n";
                }
                ?>
              </td>
            </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <textarea autocomplete="off" name="text_message" style="width: 98%; height: 150px"><?php echo (($_POST) ? html_encode(checkslashes($_POST["text_message"], 1)) : html_encode(checkslashes($result["text_message"], 1))); ?></textarea>
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
              <td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong>Field Name: <em>HTML Version</em></strong><br />This is the optional HTML version of your message. <?php echo ((($_SESSION["config"][PREF_USERTE] == "yes") && ($RTE_ENABLED)) ? "You have the Rich Text Editor enabled, so you can just type your message, changing the font size and colour as you would with any text editor." : "You have the Rich Text Editor disabled, so your message must be provided to this box in pre formatted HTML."); ?>'));">HTML Version:</span>&nbsp;</td>
              <td style="text-align: right">
                <?php
                $query  = "SELECT `template_id`,`template_name` FROM `".TABLES_PREFIX."templates` WHERE `template_type`='html' ORDER BY `template_name` ASC";
                $results  = $db->GetAll($query);
                if($results) {
                  ?>
                  HTML Template:
                  <select name="html_template" style="width: 200px">
                    <option value="">-- Optional HTML Template --</option>
                    <?php
                    foreach($results as $sresult) {
                      echo "<option value=\"".$sresult["template_id"]."\"".(($_POST) ? (($_POST["html_template"] == $sresult["template_id"]) ? " selected=\"selected\"" : "") : (($result["html_template"] == $sresult["template_id"]) ? " selected=\"selected\"" : "")).">".html_encode($sresult["template_name"])."</option>\n";
                    }
                    ?>
                  </select>
                  <?php
                } else {
                  echo "<span style=\"color: #666666\">There are no <strong>html</strong> templates: <a href=\"index.php?section=templates&action=add&type=html\">Click here</a> to add one.</span>";
                  echo "<input type=\"hidden\" name=\"html_template\" value=\"0\" />\n";
                }
                ?>
              </td>
            </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <textarea autocomplete="off" id="html_message" name="html_message" style="width: 98%; height: 350px"><?php echo html_encode((($_POST) ? checkslashes($_POST["html_message"], 1) : checkslashes($result["html_message"], 1))); ?></textarea>
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
        if(count($msg_attachment) > 0) {
          echo "<tr>\n";
          echo "  <td>&nbsp;</td>\n";
          echo "  <td>\n";
          echo "    <table style=\"width: 98%; text-align: left\" cellspacing=\"0\" cellpadding=\"1\" border=\"0\">\n";
          echo "    <tr>\n";
          echo "      <td style=\"width: 5%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap\">&nbsp;</td>\n";
          echo "      <td style=\"width: 75%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-on.gif'); white-space: nowrap\">File Name</td>\n";
          echo "      <td style=\"width: 20%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap\">File Size</td>\n";
          echo "    </tr>\n";
                natsort($msg_attachment);
                foreach($msg_attachment as $id => $filename) {
                  echo "<tr onmouseout=\"this.style.backgroundColor='#FFFFFF'\" onmouseover=\"this.style.backgroundColor='#F0FFD1'\">\n";
                  echo "  <td><input type=\"checkbox\" name=\"attachments[".$id."]\" value=\"1\" /></td>\n";
                  echo "  <td><a href=\"".$_SESSION["config"][PREF_PUBLIC_URL]."files/".$filename."\" target=\"_blank\">".$filename."</a></td>\n";
                  echo "  <td>".readable_size(@filesize($_SESSION["config"][PREF_PUBLIC_PATH]."files/".$filename))."</td>\n";
                  echo "</tr>\n";
                }
          echo "    </table>\n";
          echo "    <div style=\"width: 98%; border-top: 1px #666666 dotted; margin-top: 5px; padding-top: 5px; text-align: right\">\n";
          echo "      <input type=\"submit\" name=\"remove_attachment\" class=\"button\" value=\"Remove\" />\n";
          echo "    </div>\n";
          echo "  </td>\n";
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
            <input type="button" name="cancel" class="button" value="Cancel" onclick="window.location='index.php?section=message&action=view&id=<?php echo html_encode($_GET["id"]); ?>'" />&nbsp;
            <input type="submit" name="save_changes" class="button" value="Save Changes" />
            </div>
          </td>
        </tr>
        </table>
        </form>
        <form action="./spellcheck.php?sid=<?php echo session_id(); ?>" method="post" name="spell_form" id="spell_form" target="spellDialogBox">
        <input type="hidden" name="spell_formname"  value="" />
        <input type="hidden" name="spell_fieldname"  value="" />
        <input type="hidden" name="spellstring"    value="" />
        </form>
        <?php
       } else {
        if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
          @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to retrieve the provided message id [".$_GET["id"]."].\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
        }
        $ERROR++;
        $ERRORSTR[]  = "Unable to find any message in the Message Centre with an ID of [".$_GET["id"]."].<br /><br />Please <a href=\"./index.php?section=message\">click here</a> to return to the Message Centre.";
        echo display_error($ERRORSTR);
      }
    } else {
      header("Location: index.php?section=message");
      exit;
    }
  break;
  case "resume" :
    if(((isset($_GET["qid"])) && ((int) trim($_GET["qid"]))) && ((isset($_GET["mid"])) && ((int) trim($_GET["mid"])))) {
      $query  = "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_id`='".checkslashes(trim($_GET["mid"]))."'";
      $result  = $db->GetRow($query);
      if($result) {
        $_SESSION["message_details"]             = array();
        $_SESSION["message_details"]["message_id"]      = $result["message_id"];
        $_SESSION["message_details"]["message_title"]    = $result["message_title"];
        $_SESSION["message_details"]["message_subject"]    = $result["message_subject"];
        $_SESSION["message_details"]["message_from"]    = $result["message_from"];
        $_SESSION["message_details"]["message_reply"]    = $result["message_reply"];
        $_SESSION["message_details"]["message_priority"]  = $result["message_priority"];
        $_SESSION["message_details"]["text_message"]    = $result["text_message"];
        $_SESSION["message_details"]["text_template"]    = $result["text_template"];
        $_SESSION["message_details"]["html_message"]    = $result["html_message"];
        $_SESSION["message_details"]["html_template"]    = $result["html_template"];
        $_SESSION["message_details"]["attachments"]      = $result["attachments"];

        $action  = "resume";
        $qid  = trim($_GET["qid"]);
        require_once("progress.inc.php");
      } else {
        if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
          @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to retrieve the provided message id [".$_GET["id"]."].\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
        }
        $ERROR++;
        $ERRORSTR[]  = "Unable to find any message in the Message Centre with an ID of [".$_GET["id"]."].<br /><br />Please <a href=\"./index.php?section=message\">click here</a> to return to the Message Centre.";
        echo display_error($ERRORSTR);
      }
    } else {
      header("Location: index.php?section=message");
      exit;
    }
  break;
  case "send" :
    if((isset($_GET["id"])) && ((int) trim($_GET["id"]))) {
      $query  = "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_id` = '".(int) trim($_GET["id"])."'";
      $result  = $db->GetRow($query);
      if($result) {
        $email_address = checkslashes(trim($_POST["address"]), 1);

        $_SESSION["message_details"]             = array();
        $_SESSION["message_details"]["message_id"]      = $result["message_id"];
        $_SESSION["message_details"]["message_title"]    = $result["message_title"];
        $_SESSION["message_details"]["message_subject"]    = $result["message_subject"];
        $_SESSION["message_details"]["message_from"]    = $result["message_from"];
        $_SESSION["message_details"]["message_reply"]    = $result["message_reply"];
        $_SESSION["message_details"]["message_priority"]  = $result["message_priority"];
        $_SESSION["message_details"]["text_message"]    = $result["text_message"];
        $_SESSION["message_details"]["text_template"]    = $result["text_template"];
        $_SESSION["message_details"]["html_message"]    = $result["html_message"];
        $_SESSION["message_details"]["html_template"]    = $result["html_template"];
        $_SESSION["message_details"]["attachments"]      = $result["attachments"];

        if(strlen($email_address) > 1) { // Assume it's a test message.
		
		$e = explode(",",$email_address);
		foreach($e as $key => $value)
		{
          if(valid_address($value)) {

            require_once("classes/lm_mailer.class.php");

            $language_pack  = array();

            $mail      = new LM_Mailer("private");
            $mail->Priority  = $_SESSION["message_details"]["message_priority"];
            $mail->CharSet  = $_SESSION["config"][PREF_DEFAULT_CHARSET];
            $mail->Encoding  = "8bit";
            $mail->WordWrap  = $_SESSION["config"][PREF_WORDWRAP];

            $from_pieces  = explode("\" <", $_SESSION["message_details"]["message_from"]);
            $mail->From     = substr($from_pieces[1], 0, (@strlen($from_pieces[1])-1));
            $mail->FromName  = substr($from_pieces[0], 1, (@strlen($from_pieces[0])));

            $mail->Sender  = $_SESSION["config"][PREF_ERREMAL_ID];

            $reply_pieces  = explode("\" <", $_SESSION["message_details"]["message_reply"]);
            $mail->AddReplyTo(substr($reply_pieces[1], 0, (@strlen($reply_pieces[1])-1)), substr($reply_pieces[0], 1, (@strlen($reply_pieces[0]))));

            $date      = time();
            $subject    = $_SESSION["message_details"]["message_subject"];

            $html_template  = $_SESSION["message_details"]["html_template"];
            $html_message  = $_SESSION["message_details"]["html_message"];

            $text_template  = $_SESSION["message_details"]["text_template"];
            $text_message  = $_SESSION["message_details"]["text_message"];

            $mail->AddCustomHeader("X-ListMessenger-Version: ".VERSION_TYPE." [".VERSION_INFO."]");
            $mail->AddCustomHeader("X-Originating-IP: ".$_SERVER["REMOTE_ADDR"]);
            $mail->AddCustomHeader("List-Help: <".$_SESSION["config"][PREF_PROGURL_ID]."public/help.php>");
            $mail->AddCustomHeader("List-Owner: <mailto:".$mail->From."> (".$mail->FromName.")");
            $mail->AddCustomHeader("List-Unsubscribe: <".$_SESSION["config"][PREF_PROGURL_ID]."public/unsubscribe.php?addr=".$value.">");
            $mail->AddCustomHeader("List-Archive: <".$_SESSION["config"][PREF_PROGURL_ID]."public/archive.php>");
            $mail->AddCustomHeader("List-Post: NO");

            $mail->Subject  = custom_data(false, $subject, array("email_address" => $value));

            if(strlen(trim($html_message)) > 0) {
              $mail->Body    = custom_data(false, unsubscribe_message(insert_template("html", $html_template, $html_message), "html", true), array("email_address" => $value));
              $mail->AltBody  = custom_data(false, unsubscribe_message(insert_template("text", $text_template, $text_message), "text", true), array("email_address" => $value));
            } else {
              $mail->Body  = custom_data(false, unsubscribe_message(insert_template("text", $text_template, $text_message), "text", true), array("email_address" => $value));
            }

            $mail->AddAddress($value, $mail->FromName);

            // Look for attachments on this message, if they're there and valid, attach them.
            if($_SESSION["message_details"]["attachments"] != "") {
              $attachments = unserialize($_SESSION["message_details"]["attachments"]);
              if((@is_array($attachments)) && (@count($attachments) > 0)) {
                foreach($attachments as $filename) {
                  if(@file_exists($_SESSION["config"][PREF_PUBLIC_PATH]."files/".$filename)) {
                    $mail->AddAttachment($_SESSION["config"][PREF_PUBLIC_PATH]."files/".$filename);
                  }
                }
              }
            }

            if((!@$mail->IsError()) && (@$mail->Send())) {
              $SUCCESS++;
              $SUCCESSSTR[] = "Your test message has been successfully sent to <strong>".$value."</strong>.<br /><br />You will be automatically redirected in 5 seconds, or <a href=\"index.php?section=message&action=view&id=".$_SESSION["message_details"]["message_id"]."\">click here</a> if you prefer not to wait.";
            } else {
              $ERROR++;
              $ERRORSTR[] = "Your message could not be sent, the sending engine responded with:<br /><div style=\"margin: 2px; padding: 3px; border: 1px #666666 solid; background-color: #EEEEEE; font-size: 12px\">".$mail->ErrorInfo."</div><br />You may want try changing the method which ListMessenger uses to send e-mail, if this way isn't working for you. You can do this in the Control Panel > Preferences > E-Mail Settings; <a href=\"index.php?section=message&action=view&id=".$_SESSION["message_details"]["message_id"]."\">Click here</a> to return to your message details.";

              if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to send test message to ".$value.". LM_Mailer responded: ".$mail->ErrorInfo."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
              }
            }

            if($mail->Mailer == "smtp") $mail->SmtpClose();

            $mail->ClearCustomHeaders();
            $mail->ClearAttachments();

            if($ERROR) {
              echo display_error($ERRORSTR);
            } elseif($SUCCESS) {
              $ONLOAD[] = "setTimeout('window.location=\'index.php?section=message&action=view&id=".$_SESSION["message_details"]["message_id"]."\'', 5000)";

              echo display_success($SUCCESSSTR);
            }

          } else {
            $ONLOAD[] = "setTimeout('window.location=\'index.php?section=message&action=view&id=".trim($_GET["id"])."\'', 10000)";

            $ERROR++;
            $ERRORSTR[] = "The e-mail you've entered [<strong>".$email_address."</strong>] is not a valid e-mail address; please correct the address and try again.<br /><br />You will be automatically redirected in 10 seconds, or <a href=\"index.php?section=message&action=view&id=".trim($_GET["id"])."\">click here</a> if you prefer not to wait.";

            echo display_error($ERRORSTR);
          }
		}
          unset($_SESSION["message_details"]);

        } else {
          if((@is_array($_POST["groups"])) && (count($_POST["groups"]))) {
            $all_groups  = array();
            foreach($_POST["groups"] as $group_id) {
              $groups    = array();
              $groups[]  = (int) trim($group_id);
              groups_inarray((int) trim($group_id), $groups);

              foreach($groups as $group_id) {
                if($group_id = (int) $group_id) {
                  $all_groups[] = $group_id;
                }
              }
              unset($groups);
            }
            $all_groups  = array_unique($all_groups);

            $query    = "
                  SELECT COUNT(DISTINCT(`email_address`)) AS `total`
                  FROM `".TABLES_PREFIX."users`
                  WHERE `group_id` IN ('".implode("', '", $all_groups)."')";
            $result    = $db->GetRow($query);
            if(($result) && ((int) $result["total"])) {
              $query  = "INSERT INTO `".TABLES_PREFIX."queue` VALUES (NULL, '".(int) trim($_GET["id"])."', '".time()."', '0', '".addslashes(serialize($all_groups))."', '0', '".checkslashes($result["total"])."', 'Queuing');";
              $result  = $db->Execute($query);
              if(($result) && ($qid = (int) $db->Insert_Id())) {
                require_once("progress.inc.php");
              } else {
                $ERROR++;
                $ERRORSTR[] = "Unable to insert the queue request into the database. Please ensure your database is active and try again. See your error log for more information.<br /><br />You will be automatically redirected in 10 seconds, or <a href=\"index.php?section=message&action=view&id=".trim($_GET["id"])."\">click here</a> if you prefer not to wait.";

                echo display_error($ERRORSTR);

                if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                  @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to the queue request because of a database error. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                }
              }
            } else {
              $ONLOAD[]  = "setTimeout('window.location=\'index.php?section=message&action=view&id=".(int) trim($_GET["id"])."\'', 10000)";

              $ERROR++;
              $ERRORSTR[]  = "The group".((@count($all_groups) != 1) ? "s which you have selected do" : " that you have selected does")." not contain any subscribers. Please select a group which contains subscribers and try again.<br /><br />You will be automatically redirected in 10 seconds, or <a href=\"index.php?section=message&action=view&id=".trim($_GET["id"])."\">click here</a> if you prefer not to wait.";

              echo display_error($ERRORSTR);

              if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to prepare the send because the selected groups didn't contain any users.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
              }
            }
          } else {
            $ONLOAD[] = "setTimeout('window.location=\'index.php?section=message&action=view&id=".trim($_GET["id"])."\'', 10000)";

            $ERROR++;
            $ERRORSTR[] = "If you would like to send a newsletter to a group, please make sure that you select a group or groups in the select box to send it to.<br /><br />You will be automatically redirected in 10 seconds, or <a href=\"index.php?section=message&action=view&id=".trim($_GET["id"])."\">click here</a> if you prefer not to wait.";

            echo display_error($ERRORSTR);
          }
        }
      } else {
        if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
          @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to retrieve the provided message id [".$_GET["id"]."].\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
        }
        $ERROR++;
        $ERRORSTR[]  = "Unable to find any message in the Message Centre with an ID of [".$_GET["id"]."].<br /><br />Please <a href=\"./index.php?section=message\">click here</a> to return to the Message Centre and select a valid message.";
        echo display_error($ERRORSTR);
      }
	  
    } else {
      header("Location: index.php?section=message");
      exit;
    }
  break;
  case "view" :
    if((isset($_GET["id"])) && ((int) trim($_GET["id"]))) {
      $can_delete  = true;
      $query    = "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_id`='".checkslashes(trim($_GET["id"]))."'";
      $result    = $db->GetRow($query);
      if($result) {
        $i = count($HEAD);
        $HEAD[$i]  = "<script type=\"text/javascript\" src=\"./javascript/tabpane/tabpane.js\"></script>\n";
        $HEAD[$i] .= "<link type=\"text/css\" rel=\"StyleSheet\" href=\"./css/luna/tab.css\" />\n";

        if($result["message_id"] == $_SESSION["config"][PREF_POSTSUBSCRIBE_MSG]) {
          $NOTICE++;
          $NOTICESTR[]  = "This message is marked as being the message which will be sent to subscribers after they successfully subscribe to your mailing list.";
          $can_delete  = false;
        } elseif($result["message_id"] == $_SESSION["config"][PREF_POSTUNSUBSCRIBE_MSG]) {
          $NOTICE++;
          $NOTICESTR[]  = "This message is marked as being the message which will be sent to subscribers after they successfully unsubscribe from your mailing list.";
          $can_delete  = false;
        }

        if($result["attachments"]) {
          $msg_attachment = unserialize($result["attachments"]);
        }

        // Turn the HTML message into a session so we can pass it to the preview script.
        if(trim(strip_tags($result["html_message"])) != "") {
          $_SESSION["html_message"] = urlencode(checkslashes(trim(insert_template("html", $result["html_template"], $result["html_message"])), 1));
        } else {
          unset($_SESSION["html_message"]);
        }

        $group_select = groups_inselect(0);
        ?>
        <script language="JavaScript" type="text/javascript">
        function messageDelete() {
          <?php if($can_delete) : ?>
            var is_confirmed = confirm('Are you sure that you want to delete this message?\n\nPress OK to continue with the delete.');
            if (is_confirmed == true) {
              document.deletemessage.submit();
              return;
            }
          <?php else : ?>
            alert('You cannot delete this message because it is marked as being the message that will be sent to a subscriber after a subscribe or unsubcribe action has taken place.\n\nIf you would like to delete this message, please remove this option from Preferences first.');
          <?php endif; ?>
          return;
        }

        function messageCopy() {
          var curTitle  = '<?php echo addslashes($result["message_title"]); ?>';
          var newTitle  = prompt('Please enter the Message Title of the new message you are creating.', curTitle);
          if (newTitle == '') {
            alert('You must enter a Message Title for the new message.\n\nPlease click OK and try again once you enter a title.');
            messageCopy();
            return;
          } else if(newTitle == curTitle) {
            alert('You cannot keep your new Message Title the same as the old one.\n\nPlease click OK and try again with a unique title.');
            messageCopy();
            return;
          } else if(!newTitle) {
            return;
          } else {
            document.copymessage.title.value = newTitle;
            document.copymessage.submit();
            return;
          }
        }

        function messageSend() {
          if(document.getElementById('email').value != '') {
            var testAddress = prompt('Please verify that you wish to send a test message to the following e-mail address.', document.getElementById('email').value);
            if (testAddress == '') {
              alert('You must enter a valid e-mail address to send this test to.\n\nPlease click OK and try again once you enter an address.');
              messageSend();
              return;
            } else if(!testAddress) {
              document.getElementById('email').value = '';
              return;
            } else {
              document.sendtest.address.value = testAddress;
              document.sendtest.submit();
              return;
            }
          } else {
            document.sendmessage.submit();
            return;
          }
        }
        </script>

        <h1>Message Centre <span style="font-size: 11px">[<?php echo html_encode(checkslashes($result["message_title"], 1)); ?>]</span></h1>
        <div style="text-align: right">
          <form>
          <input type="button" name="copy" class="button" value="Copy Message" onclick="messageCopy()" />
          <input type="button" name="edit" class="button" value="Edit Message" onclick="window.location='index.php?section=message&action=edit&id=<?php echo html_encode($_GET["id"]); ?>'" />
          <input type="button" name="delete" class="button" value="Delete Message" onclick="messageDelete()" />
          </form>
        </div>
        <br />
        <?php
        if($ERROR) {
          echo display_error($ERRORSTR);
        }
        ?>
        <div style="display: <?php echo (in_array("msgSend", $COLLAPSED) ? "none" : "inline"); ?>" id="opened_msgSend">
          <table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
          <tr>
            <td class="cursor" style="height: 15px; background-image: url('./images/table-head-on.gif'); background-color: #EEEEEE; border-bottom: 1px #CCCCCC solid" onclick="toggle_section('msgSend', 1, '<?php echo javascript_cookie(); ?>', 'message')">
              <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td style="width: 95%; text-align: left"><span class="search-on">Message Sending Options</span></td>
                <td style="width: 5%; text-align: right"><a href="javascript: toggle_section('msgSend', 1, '<?php echo javascript_cookie(); ?>', 'message')"><img src="./images/section-hide.gif" width="9" height="9" alt="Hide" title="Hide Sending Options" border="0" /></a></td>
              </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding: 5px">
              <form action="index.php?section=message&action=send&id=<?php echo html_encode($_GET["id"]); ?>" method="post" name="sendmessage">
              <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td class="form-row-nreq" style="vertical-align: top"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Send To Address</em></strong><br />This field is supplied so you can input an e-mail address to send a test message to. This address could be your own, your bosses or whomever would like a test message sent to them.'));">Send To Address:</span></td>
                <td><input type="text" id="email" name="email" value="" style="width: 350px" /></td>
              </tr>
              <?php if($group_select != "") : ?>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td class="form-row-nreq" style="vertical-align: top"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Send To Group(s):</em></strong><br />Here you are able to select one or more groups that will receive this message during this send. If you select multiple groups and a specific e-mail address appears more than once, the user will only receive one message.<br /><br /><strong>Functionality Change:</strong><br />In ListMessenger 1.1 and higher, if you select a parent group, all child groups will also receive this message.<br /><br />Users will only receive one copy of the message if they are in multiple child groups.'));">Send To Group(s):</span></td>
                <td>
                  <select name="groups[]" multiple="multiple" size="8" style="width: 354px">
                  <?php echo $group_select; ?>
                  </select>
                </td>
              </tr>
              <?php else : ?>
              <tr>
                <td colspan="2">
                  <br /><br />
                  <?php echo display_notice(array("You currently do not have any groups present in your database to send this message to.<br /><br />Please <a href=\"index.php?section=manage-groups&action=add\" style=\"font-weight: bold\">click here</a> to create a new group, which normally resides under Manage Groups.")); ?>
                </td>
              </tr>
              <?php endif; ?>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" style="text-align: right; padding-top: 5px">
                  <input type="button" value="Send Message" class="button" onclick="messageSend()"/>
                </td>
              </tr>
              </table>
              </form>
              <br />
            </td>
          </tr>
          </table>
        </div>
        <div style="display: <?php echo (!in_array("msgSend", $COLLAPSED) ? "none" : "inline"); ?>" id="closed_msgSend">
          <table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
          <tr>
            <td class="cursor" style="height: 15px; background-image: url('./images/table-head-off.gif'); background-color: #EEEEEE" onclick="toggle_section('msgSend', 0, '<?php echo javascript_cookie(); ?>', 'message')">
              <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td style="width: 95%; text-align: left"><span class="search-off">Message Sending Options</span></td>
                <td style="width: 5%; text-align: right"><a href="javascript: toggle_section('msgSend', 0, '<?php echo javascript_cookie(); ?>', 'message')"><img src="./images/section-show.gif" width="9" height="9" alt="Show" title="Show Sending Options" border="0" /></a></td>
              </tr>
              </table>
            </td>
          </tr>
          </table>
        </div>
        <br />

        <div style="display: <?php echo (in_array("msgContents", $COLLAPSED) ? "none" : "inline"); ?>" id="opened_msgContents">
          <table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
          <tr>
            <td class="cursor" style="height: 15px; background-image: url('./images/table-head-on.gif'); background-color: #EEEEEE; border-bottom: 1px #CCCCCC solid" onclick="toggle_section('msgContents', 1, '<?php echo javascript_cookie(); ?>', 'message')">
              <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td style="width: 95%; text-align: left"><span class="search-on">Message Contents</span></td>
                <td style="width: 5%; text-align: right"><a href="javascript: toggle_section('msgContents', 1, '<?php echo javascript_cookie(); ?>', 'message')"><img src="./images/section-hide.gif" width="9" height="9" alt="Hide" title="Hide Contents" border="0" /></a></td>
              </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding: 5px">
              <table style="width: 100%; margin: 3px" cellspacing="0" cellpadding="1" border="0">
              <tr>
                <td class="form-row-nreq" style="width: 25%">From:&nbsp;</td>
                <td style="width: 75%"><?php echo html_encode(checkslashes($result["message_from"], 1)); ?></td>
              </tr>
              <tr>
                <td class="form-row-nreq" style="width: 25%">Reply-to:&nbsp;</td>
                <td style="width: 75%"><?php echo html_encode(checkslashes($result["message_reply"], 1)); ?></td>
              </tr>
              <tr>
                <td class="form-row-nreq" style="width: 25%">Message Subject:&nbsp;</td>
                <td style="width: 75%"><?php echo html_encode(checkslashes($result["message_subject"], 1)); ?></td>
              </tr>
              <tr>
                <td class="form-row-nreq" style="width: 25%">Priority:&nbsp;</td>
                <td style="width: 75%">
                  <?php
                  switch($result["message_priority"]) {
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
              <?php if(($result["text_template"]) || ($result["html_template"])) : ?>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <?php if($result["text_template"]) : ?>
                <tr>
                  <td class="form-row-nreq" style="width: 25%">Text Template:&nbsp;</td>
                  <td style="width: 75%"><?php echo template_name($result["text_template"]); ?></td>
                </tr>
                <?php endif; ?>
                <?php if($result["html_template"]) : ?>
                <tr>
                  <td class="form-row-nreq" style="width: 25%">HTML Template:&nbsp;</td>
                  <td style="width: 75%"><?php echo template_name($result["html_template"]); ?></td>
                </tr>
                <?php endif; ?>
              <?php endif; ?>
              <?php
              if(count($msg_attachment) > 0) {
                echo "<tr>\n";
                echo "  <td colspan=\"2\">&nbsp;</td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                echo "  <td class=\"form-row-nreq\" style=\"vertical-align: top\">File Attachments:&nbsp;</td>\n";
                echo "  <td>\n";
                echo "    <table style=\"width: 100%; text-align: left\" cellspacing=\"0\" cellpadding=\"1\" border=\"0\">\n";
                echo "    <tr>\n";
                echo "      <td style=\"width: 80%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-on.gif'); white-space: nowrap\">File Name</td>\n";
                echo "      <td style=\"width: 20%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap\">File Size</td>\n";
                echo "    </tr>\n";
                      natsort($msg_attachment);
                      foreach($msg_attachment as $id => $filename) {
                        echo "<tr>\n";
                        echo "  <td><a href=\"".$_SESSION["config"][PREF_PUBLIC_URL]."files/".$filename."\" target=\"_blank\">".$filename."</a></td>\n";
                        echo "  <td>".readable_size(@filesize($_SESSION["config"][PREF_PUBLIC_PATH]."files/".$filename))."</td>\n";
                        echo "</tr>\n";
                      }
                echo "    </table>\n";
                echo "  </td>\n";
                echo "</tr>\n";
              }
              ?>
              </table>
              <br />

              <div class="tab-pane" id="tab-pane-1">
                <div class="tab-page" style="height: 100%">
                  <h2 class="tab">Text Version</h2>
                  <?php echo checkslashes(nl2br(html_encode(trim(insert_template("text", $result["text_template"], $result["text_message"])))), 1); ?>
                </div>
                <div class="tab-page" style="height: 100%">
                  <h2 class="tab">HTML Version</h2>
                  <?php
                  if($_SESSION["html_message"]) {
                    ?>
                    <iframe src="./preview.php?sid=<?php echo session_id(); ?>" style="border: 1px; width: 100%; height: 400px"></iframe>
                    <div style="padding-top: 5px; text-align: right">
                      <form>
                      <input type="button" class="button" value="New Window" onclick="window.open('./preview.php?sid=<?php echo session_id(); ?>')" />
                      </form>
                    </div>
                    <?php
                  } else {
                    echo display_notice(array("There is currently no HTML version of this message present, which is fine; your subscribers will simply receive your message as plain text. If you would like to add an HTML version, simply click the Edit Message button; otherwise, you can ignore this."));
                  }
                  ?>
                </div>
              </div>
              <script language="Javascript" type="text/javascript">setupAllTabs(false);</script>
              <br />
            </td>
          </tr>
          </table>
        </div>
        <div style="display: <?php echo (!in_array("msgContents", $COLLAPSED) ? "none" : "inline"); ?>" id="closed_msgContents">
          <table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
          <tr>
            <td class="cursor" style="height: 15px; background-image: url('./images/table-head-off.gif'); background-color: #EEEEEE" onclick="toggle_section('msgContents', 0, '<?php echo javascript_cookie(); ?>', 'message')">
              <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td style="width: 95%; text-align: left"><span class="search-off">Message Contents</span></td>
                <td style="width: 5%; text-align: right"><a href="javascript: toggle_section('msgContents', 0, '<?php echo javascript_cookie(); ?>', 'message')"><img src="./images/section-show.gif" width="9" height="9" alt="Show" title="Show Message Contents" border="0" /></a></td>
              </tr>
              </table>
            </td>
          </tr>
          </table>
        </div>
        <br />
        <form action="index.php?section=message&action=copy" method="post" name="copymessage">
        <input type="hidden" name="id" value="<?php echo html_encode($_GET["id"]); ?>" />
        <input type="hidden" name="title" value="" />
        </form>
        <form action="index.php?section=message&action=delete" method="post" name="deletemessage">
        <input type="hidden" name="ids[]" value="<?php echo html_encode($_GET["id"]); ?>" />
        <input type="hidden" name="confirmed" value="true" />
        </form>
        <form action="index.php?section=message&action=send&id=<?php echo html_encode($_GET["id"]); ?>" method="post" name="sendtest">
        <input type="hidden" name="address" value="" />
        </form>
        <?php
      } else {
        if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
          @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to retrieve the provided message id [".$_GET["id"]."].\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
        }
        $ERROR++;
        $ERRORSTR[]  = "Unable to find any message in the Message Centre with an ID of [".$_GET["id"]."].<br /><br />Please <a href=\"./index.php?section=message\">click here</a> to return to the Message Centre and select a valid message.";
        echo display_error($ERRORSTR);
      }
    } else {
      header("Location: index.php?section=message");
      exit;
    }
  break;
  default :
    ?>
    <div style="display: <?php echo (in_array("search", $COLLAPSED) ? "none" : "inline"); ?>" id="opened_search">
      <table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
      <tr>
        <td class="cursor" style="height: 15px; background-image: url('./images/table-head-on.gif'); background-color: #EEEEEE; border-bottom: 1px #CCCCCC solid" onclick="toggle_section('search', 1, '<?php echo javascript_cookie(); ?>', 'message')">
          <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td style="width: 95%; text-align: left"><span class="search-on">Quick Search</span></td>
            <td style="width: 5%; text-align: right"><a href="javascript: toggle_section('search', 1, '<?php echo javascript_cookie(); ?>', 'message')"><img src="./images/section-hide.gif" width="9" height="9" alt="Hide" title="Hide Search" border="0" /></a></td>
          </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td>
          <form action="index.php" method="get">
          <input type="hidden" name="section" value="message" />
          <table style="width: 100%; height: 25px" cellspacing="0" cellpadding="2" border="0">
          <tr>
            <td style="width: 100px" class="search-heading">Message Search:</td>
            <td>
              <select name="f">
              <option value="title"<?php echo (($_GET["f"] == "title") ? " selected=\"selected\"" : ""); ?>>Internal Title</option>
              <option value="subject"<?php echo (($_GET["f"] == "subject") ? " selected=\"selected\"" : ""); ?>>Message Subject</option>
              <option value="text"<?php echo (($_GET["f"] == "text") ? " selected=\"selected\"" : ""); ?>>Text Version</option>
              <option value="html"<?php echo (($_GET["f"] == "html") ? " selected=\"selected\"" : ""); ?>>HTML Version</option>
              </select>
            </td>
            <td>
              <select name="t">
              <option value="contains"<?php echo (($_GET["t"] == "contains") ? " selected=\"selected\"" : "") ?>>Contains</option>
              <option value="equals"<?php echo (($_GET["t"] == "equals") ? " selected=\"selected\"" : "") ?>>Equals</option>
              </select>
            </td>
            <td>
              <input type="text" class="text-box" style="width: 150px" name="q" value="<?php echo checkslashes($_GET["q"], 1); ?>" />
            </td>
            <td style="text-align: right">
              <input type="submit" value="Search" class="button" />
            </td>
          </tr>
          </table>
          </form>
        </td>
      </tr>
      </table>
    </div>
    <div style="display: <?php echo (!in_array("search", $COLLAPSED) ? "none" : "inline"); ?>" id="closed_search">
      <table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
      <tr>
        <td class="cursor" style="height: 15px; background-image: url('./images/table-head-off.gif'); background-color: #EEEEEE" onclick="toggle_section('search', 0, '<?php echo javascript_cookie(); ?>', 'message')">
          <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td style="width: 95%; text-align: left"><span class="search-off">Quick Search</span></td>
            <td style="width: 5%; text-align: right"><a href="javascript: toggle_section('search', 0, '<?php echo javascript_cookie(); ?>', 'message')"><img src="./images/section-show.gif" width="9" height="9" alt="Show" title="Show Search" border="0" /></a></td>
          </tr>
          </table>
        </td>
      </tr>
      </table>
    </div>
    <h1>Message Centre</h1>
    <?php
    // Setup "Sort By Field" Information
    if(isset($_GET["sort"])) {
      $_SESSION["display"]["message"]["sort"] = checkslashes($_GET["sort"]);
      setcookie("display[message][sort]", checkslashes($_GET["sort"]), PREF_COOKIE_TIMEOUT);
    } elseif((!isset($_SESSION["display"]["message"]["sort"])) && (isset($_COOKIE["display"]["message"]["sort"]))) {
      $_SESSION["display"]["message"]["sort"] = $_COOKIE["display"]["message"]["sort"];
    } else {
      if(!isset($_SESSION["display"]["message"]["sort"])) {
        $_SESSION["display"]["message"]["sort"] = "date";
        setcookie("display[message][sort]", "date", PREF_COOKIE_TIMEOUT);
      }
    }

    // Setup "Sort Order" Information
    if(isset($_GET["order"])) {
      switch($_GET["order"]) {
        case "asc" :
          $_SESSION["display"]["message"]["order"] = "ASC";
        break;
        case "desc" :
        default :
          $_SESSION["display"]["message"]["order"] = "DESC";
        break;
      }
      setcookie("display[message][order]", $_SESSION["display"]["message"]["order"], PREF_COOKIE_TIMEOUT);
    } elseif((!isset($_SESSION["display"]["message"]["order"])) && (isset($_COOKIE["display"]["message"]["order"]))) {
      $_SESSION["display"]["message"]["order"] = $_COOKIE["display"]["message"]["order"];
    } else {
      if (!isset($_SESSION["display"]["message"]["order"])) {
        $_SESSION["display"]["message"]["order"] = "DESC";
        setcookie("display[message][order]", "DESC", PREF_COOKIE_TIMEOUT);
      }
    }

    // Set the internal variables used for sorting, ordering and in pagination.
    $sort    = $_SESSION["display"]["message"]["sort"];
    $order    = $_SESSION["display"]["message"]["order"];
    $perpage  = (($_SESSION["config"][PREF_PERPAGE_ID] > 0) ? $_SESSION["config"][PREF_PERPAGE_ID] : 25);

    // Begin Query String
    if((strlen($_GET["q"]) > 0) && (strlen($_GET["t"]) > 0) && (strlen($_GET["f"]) > 0)) {
      $seeking["search"] = true;
      switch($_GET["f"]) {
        case "title" :
          $seek .= " WHERE `message_title`";
        break;
        case "subject" :
          $seek .= " WHERE `message_subject`";
        break;
        case "text" :
          $seek .= " WHERE `text_message`";
        break;
        case "html" :
          $seek .= " WHERE `html_message`";
        break;
        default :
          $seek .= " WHERE `message_title`";
        break;
      }
      switch($_GET["t"]) {
        case "contains" :
          $seek .= "LIKE'%".checkslashes($_GET["q"])."%'";
        break;
        case "equals" :
          $seek .= "='".checkslashes($_GET["q"])."'";
        break;
        default :
          $seek .= "LIKE'%".checkslashes($_GET["q"])."%'";
        break;
      }
    }

    $query    = "SELECT COUNT(*) AS `totalrows` FROM `".TABLES_PREFIX."messages`".$seek;
    $result    = $db->GetRow($query);
    $totalrows  = $result["totalrows"];

    // Get the total number of pages that we need to display.
    if($totalrows <= $perpage) {
      $totalpages = 1;
    } elseif (($totalrows % $perpage) == 0) {
      $totalpages = (int) ($totalrows / $perpage);
    } else {
      $totalpages = (int) ($totalrows / $perpage) + 1;
    }

    // Check to see what page to output.
    if(isset($_GET["vp"])) {
      if((int) $_GET["vp"]) {
        if(($_GET["vp"] >= 1) && ($_GET["vp"] <= $totalpages)) {
          $page = $_GET["vp"];
        } else {
          $page = 1;
        }
      } else {
        $page = 1;
      }
    } else {
      $page = 1;
    }

    $prev_page  = $page - 1;
    $next_page  = $page + 1;
    $page_start  = ($perpage * $page) - $perpage;

    // Get the colomn names of the sorted by colomn.
    switch($sort) {
      case "title" :
        $sortby  = "`message_title`";
      break;
      case "subject" :
        $sortby  = "`message_subject`";
      break;
      case "date" :
      default :
        $sortby  = "`message_date`";
      break;
    }

    $query    = "SELECT `message_id`, `message_date`, `message_title`, `message_subject` FROM `".TABLES_PREFIX."messages`".$seek." ORDER BY ".$sortby." ".strtoupper($order)." LIMIT ".$page_start.", ".$perpage;
    $results  = $db->GetAll($query);
    if($results) {
      ?>
      <table style="width: 100%" cellspacing="0" cellpadding="1" border="0">
      <tr>
        <td style="width: 50%; text-align: left">
          <form action="index.php" method="GET">
          <input type="hidden" name="section" value="message" />
          <?php
          if($seeking["search"]) {
            echo "  <input type=\"hidden\" name=\"q\" value=\"".html_encode($_GET["q"])."\" />\n";
            echo "  <input type=\"hidden\" name=\"t\" value=\"".html_encode($_GET["t"])."\" />\n";
            echo "  <input type=\"hidden\" name=\"f\" value=\"".html_encode($_GET["f"])."\" />\n";
          }
          ?>
          <table cellspacing="1" cellpadding="1" border="0">
          <tr>
            <td>Showing Page</td>
            <td><input type="text" name="vp" value="<?php echo html_encode($page); ?>" class="text-box" style="width: 25px" /></td>
            <td>of <?php echo html_encode($totalpages); ?>.</td>
          </tr>
          </table>
          </form>
        </td>
        <td style="width: 50%">
          <div style="float: right">
          <?php
          if($totalpages > 1) {
            ?>
            <table cellspacing="1" cellpadding="1" border="0">
            <tr>
              <td style="width: 22px; text-align: left; white-space: nowrap">
                <?php
                if($prev_page) {
                  echo "<a href=\"index.php".replace_query(array("vp" => 1))."\"><img src=\"./images/record-first-on.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"First Page\" title=\"Back to first page.\" /></a>";
                  echo "<a href=\"index.php".replace_query(array("vp" => $prev_page))."\"><img src=\"./images/record-back-on.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"Page ".$prev_page.".\" title=\"Back to page ".$prev_page.".\" /></a>";
                } else {
                  echo "<img src=\"./images/record-first-off.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"\" />";
                  echo "<img src=\"./images/record-back-off.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"\" />";
                }
                ?>
              </td>
              <td style="white-space: nowrap">
                <div style="float: center">
                <?php
                echo "<form action=\"index.php".replace_query()."\" name=\"changepage\" method=\"GET\">\n";
                echo "<input type=\"hidden\" name=\"section\" value=\"message\" />\n";
                if($seeking["search"]) {
                  echo "  <input type=\"hidden\" name=\"q\" value=\"".html_encode($_GET["q"])."\" />\n";
                  echo "  <input type=\"hidden\" name=\"t\" value=\"".html_encode($_GET["t"])."\" />\n";
                  echo "  <input type=\"hidden\" name=\"f\" value=\"".html_encode($_GET["f"])."\" />\n";
                } elseif($seeking["group"]) {
                  echo "  <input type=\"hidden\" name=\"g\" value=\"".$_GET["g"]."\" />";
                }
                echo "<select name=\"vp\" onchange=\"document.changepage.submit();return;\"".(($totalpages <= 1) ? " DISABLED" : "").">\n";
                if(!$totalpages) {
                  echo "<option value=\"\" selected=\"selected\">Page 1</option>\n";
                } else {
                  for($i = 1; $i < $totalpages; $i++) {
                    if($i == $page) {
                      echo "<option value=\"".$i."\" selected=\"selected\">Viewing Page ".$i."</option>\n";
                    } else {
                      echo "<option value=\"".$i."\">Page ".$i."</option>\n";
                    }
                  }
                  if(($totalrows % $perpage) != 0) {
                    if($i == $page) {
                      echo "<option value=\"".$i."\" selected=\"selected\">Viewing Page ".$i."</option>\n";
                    } else {
                      echo "<option value=\"".$i."\">Page ".$i."</option>\n";
                    }
                  }
                }
                echo "</select>\n";
                echo "</form>\n";
                ?>
                </div>
              </td>
              <td style="width: 22px; text-align: right; white-space: nowrap">
                <?php
                if($page < $totalpages) {
                  echo "<a href=\"index.php".replace_query(array("vp" => $next_page))."\"><img src=\"./images/record-next-on.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"Page ".$next_page.".\" title=\"Forward to page ".$next_page.".\" /></a>";
                  echo "<a href=\"index.php".replace_query(array("vp" => $totalpages))."\"><img src=\"./images/record-last-on.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"Last Page\" title=\"Forward to last page.\" /></a>";
                } else {
                  echo "<img src=\"./images/record-next-off.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"\" />";
                  echo "<img src=\"./images/record-last-off.gif\" border=\"0\" width=\"9\" height=\"9\" alt=\"\" />";
                }
                ?>
              </td>
            </tr>
            </table>
            <?php
          }
          ?>
          </div>
        </td>
      </tr>
      </table>
      <form action="index.php?section=message&action=delete" method="post">
      <table style="width: 100%; text-align: left" cellspacing="0" cellpadding="1" border="0">
      <tr>
        <td style="width: 4%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap">&nbsp;</td>
        <td style="width: 20%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "date") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("date", "Creation Date", $order, $sort); ?></td>
        <td style="width: 43%; height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "title") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("title", "Message Title", $order, $sort); ?></td>
        <td style="width: 34%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "subject") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("subject", "Message Subject", $order, $sort); ?></td>
      </tr>
      <?php
      foreach($results as $result) {
        $can_delete = true;
        if(($result["message_id"] == $_SESSION["config"][PREF_POSTSUBSCRIBE_MSG]) || ($result["message_id"] == $_SESSION["config"][PREF_POSTUNSUBSCRIBE_MSG])) {
          $can_delete = false;
        }
        echo "<tr onmouseout=\"this.style.backgroundColor='#FFFFFF'\" onmouseover=\"this.style.backgroundColor='#F0FFD1'\">\n";
        echo "  <td style=\"white-space: nowrap\">".(($can_delete) ? "<input type=\"checkbox\" name=\"ids[]\" value=\"".$result["message_id"]."\" />" : "<img src=\"./images/pixel.gif\" alt=\"\" title=\"\" width=\"18\" height=\"18\" />")."</td>\n";
        echo "  <td class=\"cursor\" onclick=\"window.location='index.php?section=message&action=view&id=".$result["message_id"]."'\">".display_date("m/d/Y H:i", $result["message_date"])."</td>\n";
        echo "  <td class=\"cursor\" onclick=\"window.location='index.php?section=message&action=view&id=".$result["message_id"]."'\">".html_encode(limit_chars($result["message_title"], 38))."</td>\n";
        echo "  <td class=\"cursor\" onclick=\"window.location='index.php?section=message&action=view&id=".$result["message_id"]."'\">".html_encode(limit_chars($result["message_subject"], 30))."</td>\n";
        echo "</tr>\n";
      }
      echo "<tr>\n";
      echo "  <td colspan=\"4\" style=\"border-top: 1px #333333 dotted; padding-top: 5px\"><input type=\"submit\" value=\"Delete Selected\" class=\"button\" /></td>\n";
      echo "</tr>\n";
      echo "</table>\n";
      echo "</form>\n";

      $_SESSION["display"]["message"]["lastpage"] = $page;

    } else {
      ?>
      <h2>No Messages Found</h2>
      <div class="generic-message">
        There are no composed e-mail messages in your ListMessenger database.
        <br /><br />
        To compose a new message click the <strong>Compose Message</strong> button at the top of the page.
      </div>
      <?php
    }
  break;  // End of default switch.
}
?>