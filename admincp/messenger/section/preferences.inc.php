<?php
/*
  ListMessenger - Professional Mailing List Management
  Copyright © 2007 Silentweb [http://www.silentweb.ca]

  Developed By: Matt Simpson <msimpson@listmessenger.com>

  For the most recent version, visit the ListMessenger website:
  [http://www.listmessenger.com]

  License Information is found in docs/licence.html
  $Id: preferences.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

if(!defined("PARENT_LOADED"))    exit;
if(!$_SESSION["isAuthenticated"])  exit;

switch($_GET["type"]) {
  case "program" :
    if($_POST) {
      if(trim($_POST["npassword1"]) != "") {
        if(trim($_POST["npassword2"]) != "") {
          if(trim($_POST["npassword1"]) == trim($_POST["npassword2"])) {
            if(strlen(trim($_POST["npassword1"])) >= 5) {
              $_POST["preferences"][PREF_ADMPASS_ID] = trim($_POST["npassword1"]);
            } else {
              $ERROR++;
              $ERRORSTR[] = "Your new password must be at least five (5) characters long in order to be used. Please re-enter your new password.";
            }
          } else {
            $ERROR++;
            $ERRORSTR[] = "The new passwords that you've entered do not match. Please re-enter your new password.";
          }
        } else {
          $ERROR++;
          $ERRORSTR[] = "If you're trying to enter a new password, please re-enter your new password in the &quot;Retype New Password&quot; text box.";
        }
      }
      if(!$ERROR) {
        if((@is_array($_POST["preferences"])) && (@count($_POST["preferences"]) > 0)) {
          foreach($_POST["preferences"] as $preference_id => $preference_value) {
            $preference_value  = trim($preference_value);
            $skip_query    = false;

            switch($preference_id) {
              case PREF_ADMUSER_ID :
                if(strlen($preference_value) < 5) {
                  $ERROR++;
                  $ERRORSTR[] = "The ListMessenger Username that you have entered did not exceed 5 characters. Please enter a username that exceeds 5 characters and try again.";
                  $skip_query = true;
                }
              break;
              case PREF_FRMNAME_ID :
                if(strlen($preference_value) < 1) {
                  $ERROR++;
                  $ERRORSTR[] = "The From Name is a required setting, please enter the name you would like your messages to be sent from to update this preference.";
                  $skip_query = true;
                }
              break;
              case PREF_FRMEMAL_ID :
                if(!valid_address($preference_value)) {
                  $ERROR++;
                  $ERRORSTR[] = "The From E-Mail Address you have entered does not appear to be valid. Please enter a valid From E-Mail Address to update this preference.";
                  $skip_query = true;
                }
              break;
              case PREF_RPYEMAL_ID :
                if(!valid_address($preference_value)) {
                  $ERROR++;
                  $ERRORSTR[] = "The Reply E-Mail Address you have entered does not appear to be valid. Please enter a valid Reply E-Mail Address to update this preference.";
                  $skip_query = true;
                }
              break;
              case PREF_ABUEMAL_ID :
                if(!valid_address($preference_value)) {
                  $ERROR++;
                  $ERRORSTR[] = "The Abuse E-Mail Address you have entered does not appear to be valid. Please enter a valid Abuse E-Mail Address to update this preference.";
                  $skip_query = true;
                }
              break;
              case PREF_ERREMAL_ID :
                if(!valid_address($preference_value)) {
                  $ERROR++;
                  $ERRORSTR[] = "The Bounces Sent To E-Mail Address you have entered does not appear to be valid. Please enter a valid Bounces Sent To E-Mail Address to update this preference.";
                  $skip_query = true;
                }
              break;
              case PREF_NOTEMAL_ID :
                if(!valid_address($preference_value)) {
                  $ERROR++;
                  $ERRORSTR[] = "The Notices Sent To E-Mail Address you have entered does not appear to be valid. Please enter a valid Notices Sent To E-Mail Address to update this preference.";
                  $skip_query = true;
                }
              break;
              case PREF_PROPATH_ID :
                if(!@is_dir($preference_value)) {
                  $ERROR++;
                  $ERRORSTR[] = "The ListMessenger Directory Path you have entered does not exist or is unreadable by PHP. Please enter the full directory path from root, to your ListMessenger directory to update this preference.";
                  $skip_query = true;
                }
              break;
              case PREF_PUBLIC_PATH :
                if(!@is_dir($preference_value)) {
                  $ERROR++;
                  $ERRORSTR[] = "The Public Folder Directory Path you have entered does not exist or is unreadable by PHP. Please enter the full directory path from root, to the public folder directory to update this preference.";
                  $skip_query = true;
                }
              break;
              case PREF_PRIVATE_PATH :
                if(!@is_dir($preference_value)) {
                  $ERROR++;
                  $ERRORSTR[] = "The Private Folder Directory Path you have entered does not exist or is unreadable by PHP. Please enter the full directory path from root, to the private directory to update this preference.";
                  $skip_query = true;
                }
              break;
              case PREF_PROGURL_ID :
                if(strlen($preference_value) < 1) {
                  $ERROR++;
                  $ERRORSTR[] = "You have failed to enter the ListMessenger Program URL. Please enter the valid URL to your ListMessenger directory to update this preference.";
                  $skip_query = true;
                }
              break;
              case PREF_PUBLIC_URL :
                if(strlen($preference_value) < 1) {
                  $ERROR++;
                  $ERRORSTR[] = "You have failed to enter the ListMessenger Public Folder URL. Please enter the valid URL to your Public Folder directory to update this preference.";
                  $skip_query = true;
                }
              break;
              case PREF_DEFAULT_CHARSET :
                if(strlen($preference_value) < 1) {
                  $ERROR++;
                  $ERRORSTR[] = "You must provide a Character Encoding type in order for ListMessenger to function properly. The default encoding type is ISO-8859-1.";
                  $skip_query = true;
                } else {
                  if($preference_value != $_SESSION["config"][PREF_DEFAULT_CHARSET]) {
                    $NOTICE++;
                    $NOTICESTR[] = "You have changed ListMessenger's default character set, please do not forget that you must manually change the character set in your public/template file as well or the text from your language file may not be displayed correctly when viewing the template in your web-browser.";
                  }
                }
              break;
              case PREF_DATEFORMAT :
                if(strlen($preference_value) < 1) {
                  $ERROR++;
                  $ERRORSTR[] = "You must enter a valid date format that you would like ListMessenger to use to display the date and time. If you would like to change the default date format &quot;M jS Y g:ia&quot; to something else, please make sure you read up on <a href=\"http://www.php.net/date\" target=\"_blank\">PHP's date() function</a>.";
                  $skip_query = true;
                }
              break;
              case PREF_PERPAGE_ID :
                if(!(int) $preference_value) {
                  $ERROR++;
                  $ERRORSTR[] = "Please enter a valid integer for &quot;Display Rows Per Page&quot; to update this setting.";
                  $skip_query = true;
                }
              break;
              case PREF_USERTE :
                switch($preference_value) {
                  case "htmlarea" :
                    $preference_value = "htmlarea";
                  break;
                  case "disabled" :
                  case "no" :
                    $preference_value = "disabled";
                  break;
                  case "innovastudio" :
                  case "yes" :
                  default :
                    $preference_value = "innovastudio";
                  break;
                }
              break;
              case PREF_ERROR_LOGGING :
                if($preference_value != "yes") {
                  $preference_value = "no";
                }
              break;
              case PREF_TIMEZONE :
                if(($preference_value < -12) || ($preference_value > 12)) {
                  $ERROR++;
                  $ERRORSTR[] = "Please choose a timezone offset between -12 and 12 hours from GMT.";
                  $skip_query = true;
                }
              break;
              case PREF_DAYLIGHT_SAVINGS :
                if($preference_value != "yes") {
                  $preference_value = "no";
                }
              break;
              case PREF_ADMPASS_ID :
                // Already done this error checking above.
              break;
              default :
                $ERROR++;
                $ERRORSTR[] = "Unrecognized preference ID [".$preference_id."] with a value of [".$preference_value."] was passed to preferences updater.";
                $skip_query = true;
              break;
            }

            // Only change modified preferences.
            if($_SESSION["config"][$preference_id] == $preference_value) {
              $skip_query = true;
            }

            if(!$skip_query) {
              $query = "UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='".checkslashes($preference_value)."' WHERE `preference_id`='".$preference_id."'";
              if(!$db->Execute($query)) {
                $ERROR++;
                $ERRORSTR[] = "Unable to update preference ID ".$preference_id.". Please check your error log for more information.";
                if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                  @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tPreference ID ".$preference_id." was not updated. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                }
              }
            }
          }

          if(!reload_configuration()) {
            $ERROR++;
            $ERRORSTR[] = "Unable to reload your configuration into your session. Please check your error log for more information, but you'll have to close and then re-open your web-browser to load the changed settings.";

            if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
              @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to reload the settings from the database. The load_settings() function returned false.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
            }
          } else {
            $SUCCESS++;
            $SUCCESSSTR[] = "You have successfully reloaded the ListMessenger configuration information.";
          }
        }
      }
    }

    if(!@is_dir($_SESSION["config"][PREF_PROPATH_ID])) {
      $NOTICE++;
      $NOTICESTR[] = "Your ListMessenger Directory Path does not exist at ".$_SESSION["config"][PREF_PROPATH_ID].". Please enter the proper path to your ListMessenger directory.";
    }
    if(!@is_dir($_SESSION["config"][PREF_PUBLIC_PATH])) {
      $NOTICE++;
      $NOTICESTR[] = "Your Public Folder Directory Path does not exist at ".$_SESSION["config"][PREF_PUBLIC_PATH]." or is not readable by PHP. Please enter the proper path to your Public folder directory.";
    }
    if(!@is_dir($_SESSION["config"][PREF_PRIVATE_PATH])) {
      $NOTICE++;
      $NOTICESTR[] = "Your Private Folder Directory Path does not exist at ".$_SESSION["config"][PREF_PRIVATE_PATH]." or is not readable by PHP. Please enter the proper path to your Private folder directory.";
    }
    ?>
    <h1>Program Preferences</h1>
    <img src="images/record-next-on.gif" width="9" height="9" hspace="2" vspace="2" style="vertical-align: middle" alt="" title="" /> <a href="index.php?section=preferences">Preferences and Configuration</a>&nbsp;
    <img src="images/record-next-on.gif" width="9" height="9" hspace="2" vspace="2" style="vertical-align: middle" alt="" title="" /> Program Preferences
    <br /><br />
    <?= (($ERRORSTR > 0) ? display_error($ERRORSTR) : "") ?>
    <?php echo (($NOTICE) ? display_notice($NOTICESTR) : ""); ?>
    <?php echo (($SUCCESS) ? display_success($SUCCESSSTR) : ""); ?>
    <form action="index.php?section=preferences&type=program" method="post">
    <fieldset>
    <legend class="page-subheading">Login Information</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>ListMessenger Username</em></strong><br />This username is what you will enter on the ListMessenger login page to access the ListMessenger interface.<br /><br /><strong>Important:</strong><br />If you forget this password, it can be retrieved using PHPMyAdmin or any other database management application and look in the preferences table.'));">ListMessenger Username:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 150px" name="preferences[<?= PREF_ADMUSER_ID ?>]" value="<?= $_SESSION["config"][PREF_ADMUSER_ID] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>New ListMessenger Password</em></strong><br />If you would like to change the password that you will use to log into the ListMessenger administration interface, you can simply type the new password here.'));">New ListMessenger Password:</span></td>
      <td><input type="password" class="text-box" style="width: 150px" name="npassword1" value="" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Retype New Password</em></strong><br />If you are entering a new password, please verify the new password by entering it again in this box.'));">Retype New Password:</span></td>
      <td><input type="password" class="text-box" style="width: 150px" name="npassword2" value="" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    </table>
    </fieldset>

    <br />
    <fieldset>
    <legend class="page-subheading">Contact Information</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>From Name</em></strong><br />This is the default name that will show up in from and reply field of any e-mail client when a subscriber receives a newsletter. This would generally be your full name, company name or website title.'));">From Name:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 60%" name="preferences[<?= PREF_FRMNAME_ID ?>]" value="<?= $_SESSION["config"][PREF_FRMNAME_ID] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>From E-Mail Address</em></strong><br />This is the default e-mail address that will show up in the from field of any e-mail client when a subscriber receives a newsletter.'));">From E-Mail Address:</span></td>
      <td><input type="text" class="text-box" style="width: 60%" name="preferences[<?= PREF_FRMEMAL_ID ?>]" value="<?= $_SESSION["config"][PREF_FRMEMAL_ID] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Reply E-Mail Address</em></strong><br />This is the default e-mail address that will show up in the reply field of any e-mail client when a subscriber receives a newsletter.'));">Reply E-Mail Address:</span></td>
      <td><input type="text" class="text-box" style="width: 60%" name="preferences[<?= PREF_RPYEMAL_ID ?>]" value="<?= $_SESSION["config"][PREF_RPYEMAL_ID] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Abuse E-Mail Address</em></strong><br />This important e-mail address will provide subscribers with an address that enables them to contact you if they feel there is an instance of abuse.'));">Abuse E-Mail Address:</span></td>
      <td><input type="text" class="text-box" style="width: 60%" name="preferences[<?= PREF_ABUEMAL_ID ?>]" value="<?= $_SESSION["config"][PREF_ABUEMAL_ID] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Bounces Sent To</em></strong><br />This e-mail address will instruct remote mail servers where to send bounce messages to if the subscribers e-mail address no longer exists, is full or if there is any other problems with delivery of your newsletter.'));">Bounces Sent To:</span></td>
      <td><input type="text" class="text-box" style="width: 60%" name="preferences[<?= PREF_ERREMAL_ID ?>]" value="<?= $_SESSION["config"][PREF_ERREMAL_ID] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Notices Sent To</em></strong><br />This e-mail address will receive any notices such as when a subscriber joins, unsubscribes, etc. This is an administrative e-mail account that is only used by ListMessenger to send information to the program owner and will never been seen by subscribers.'));">Notices Sent To:</span></td>
      <td><input type="text" class="text-box" style="width: 60%" name="preferences[<?= PREF_NOTEMAL_ID ?>]" value="<?= $_SESSION["config"][PREF_NOTEMAL_ID] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    </table>
    </fieldset>

    <br />
    <fieldset>
    <legend class="page-subheading">Directory Paths and URLs</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>ListMessenger Directory Path</em></strong><br />This is the full directory path from root to your ListMessenger program directory. This field is <strong>not</strong> a URL, but <strong>is</strong> a directory path.<br /><br /><strong>Example:</strong><br />/home/domain.com/listmessenger/ or D:/domain.com/listmessenger/.<br /><br /><strong>Important:</strong><br />Windows users, please ensure you use forward slashes [/] to input your directory, <strong>not</strong> back slashes [\&#92;].'));">ListMessenger Directory Path:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 100%" name="preferences[<?= PREF_PROPATH_ID ?>]" value="<?= $_SESSION["config"][PREF_PROPATH_ID] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Public Folder Directory Path</em></strong><br />This is the full directory path from root to your ListMessenger &quot;public&quot; directory. This field is <strong>not</strong> a URL, but <strong>is</strong> a directory path.<br /><br /><strong>Example:</strong><br />/home/domain.com/lmpublic/ or D:/domain.com/lmpublic/.<br /><br /><strong>Important:</strong><br />Windows users, please ensure you use forward slashes [/] to input your directory, <strong>not</strong> back slashes [\&#92;].'));">Public Folder Directory Path:</span></td>
      <td><input type="text" class="text-box" style="width: 100%" name="preferences[<?= PREF_PUBLIC_PATH ?>]" value="<?= $_SESSION["config"][PREF_PUBLIC_PATH] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Private Folder Directory Path</em></strong><br />This is the full directory path from root to your ListMessenger &quot;private&quot; directory. This field is <strong>not</strong> a URL, but <strong>is</strong> a directory path.<br /><br /><strong>Example:</strong><br />/home/lmprivate/ or D:/lmprivate/.<br /><br /><strong>Important:</strong><br />Windows users, please ensure you use forward slashes [/] to input your directory, <strong>not</strong> back slashes [\&#92;].<br /><br /><strong>Security Notice:</strong><br />This directory should <strong>not</strong> be web accessible, meaning that you should <strong>not</strong> be able to access this folder with your web-browser. This is especially true if you are not using the Apache web-server or if your web-server does not read .htaccess files.'));">Private Folder Directory Path:</span></td>
      <td><input type="text" class="text-box" style="width: 100%" name="preferences[<?= PREF_PRIVATE_PATH ?>]" value="<?= $_SESSION["config"][PREF_PRIVATE_PATH] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>ListMessenger Program URL</em></strong><br />This is the full URL address to your ListMessenger directory on your web-server.<br /><br /><strong>Example:</strong><br />http://domain.com/listmessenger/'));">ListMessenger Program URL:</span></td>
      <td><input type="text" class="text-box" style="width: 100%" name="preferences[<?= PREF_PROGURL_ID ?>]" value="<?= $_SESSION["config"][PREF_PROGURL_ID] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Public Folder URL</em></strong><br />This is the full URL address to your ListMessenger &quot;public&quot; directory on your web-server.<br /><br /><strong>Example:</strong><br />http://domain.com/lmpublic/'));">Public Folder URL:</span></td>
      <td><input type="text" class="text-box" style="width: 100%" name="preferences[<?= PREF_PUBLIC_URL ?>]" value="<?= $_SESSION["config"][PREF_PUBLIC_URL] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    </table>
    </fieldset>

    <br />
    <fieldset>
    <legend class="page-subheading">ListMessenger Options</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Character Encoding Type</em></strong><br />Some languages other than English will require you to change the character encoding type so that multi-byte characters can be properly displayed.<br /><br /><strong>Important:</strong><br />Most users will not be required to change this; however, if you do change it, make sure you select the proper encoding type. Also note that this encoding type will be what is used not only throughout the ListMessenger interface, but also in all e-mail messages that you send out.'));">Character Encoding Type:</span></td>
      <td style="width: 60%">
        <select style="width: 154px" name="preferences[<?= PREF_DEFAULT_CHARSET ?>]" onkeypress="return handleEnter(this, event)">
        <?php
        foreach($CHARACTER_SETS as $charset) {
          echo "<option value=\"".$charset."\"".(($_SESSION["config"][PREF_DEFAULT_CHARSET] == $charset) ? " selected=\"selected\"" : "").">".$charset.(($charset == "ISO-8859-1") ? " (default)" : "")."</option>\n";
        }
        ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Display Rows Per Page</em></strong><br />This setting allows you to adjust the number of rows are displayed per page throughout the ListMessenger interface. The default is 25 rows per page.'));">Display Rows Per Page:</span></td>
      <td><input type="text" class="text-box" style="width: 150px" name="preferences[<?= PREF_PERPAGE_ID ?>]" value="<?= $_SESSION["config"][PREF_PERPAGE_ID] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Use Rich Text Editor</em></strong><br />This option allows you to specify whether or not your would like to display the Rich Text Editor when composing and editing messages. If your browser does not support the rendering of the rich text editor you may receive a JavaScript alert stating that it may not be loadable.'));">Use Rich Text Editor:</span></td>
      <td>
        <select style="width: 154px" name="preferences[<?= PREF_USERTE ?>]" onkeypress="return handleEnter(this, event)">
        <option value="innovastudio"<?= ((($_SESSION["config"][PREF_USERTE] == "innovastudio") || ($_SESSION["config"][PREF_USERTE] == "yes")) ? " selected=\"selected\"" : "") ?>>Enabled [InnovaStudio]</option>
        <option value="htmlarea"<?= (($_SESSION["config"][PREF_USERTE] == "htmlarea") ? " selected=\"selected\"" : "") ?>>Enabled [HTMLArea]</option>
        <option value="disabled"<?= ((($_SESSION["config"][PREF_USERTE] == "disabled") || ($_SESSION["config"][PREF_USERTE] == "no")) ? " selected=\"selected\"" : "") ?>>Disabled</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Log Error Messages</em></strong><br />This option allows you to specify whether or not you should log error messages to your private/log directory.<br /><br /><strong>Important:</strong><br />Logging can be very beneficial to see what exactly the problem is if something goes wrong; however, you may wish to disable to save a bit of disk space or if ListMessenger is working fine for you.'));">Log Error Messages:</span></td>
      <td>
        <select style="width: 154px" name="preferences[<?= PREF_ERROR_LOGGING ?>]" onkeypress="return handleEnter(this, event)">
        <option value="yes"<?= (($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") ? " selected=\"selected\"" : "") ?>>Yes</option>
        <option value="no"<?= (($_SESSION["config"][PREF_ERROR_LOGGING] == "no") ? " selected=\"selected\"" : "") ?>>No</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>PHP Date Format</em></strong><br />This is a PHP compatible date format that will be used in most cases to display the current date and time throughout the ListMessenger interface as well as in newsletters that contain the [date] variable.<br /><br /><strong>Important:</strong><br />If you change this, make sure that the date format you enter is valid or your dates will not be displayed properly.'));">PHP Date Format:</span></td>
      <td><input type="text" class="text-box" style="width: 150px" name="preferences[<?= PREF_DATEFORMAT ?>]" value="<?= $_SESSION["config"][PREF_DATEFORMAT] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Timezone Offset</em></strong><br />This option allows you to specify the number of hours difference between the timezone you are located in and Greenwich Mean Time (GMT).<br /><br /><strong>Example:</strong><br />GMT -5:00 hours is Eastern Standard Time (EST)'));">Timezone Offset:</span></td>
      <td>
        <select style="width: 154px" name="preferences[<?= PREF_TIMEZONE ?>]" onkeypress="return handleEnter(this, event)">
        <option value="-12"<?= (($_SESSION["config"][PREF_TIMEZONE] == "-12") ? " selected=\"selected\"" : "") ?>>GMT - 12:00 hours</option>
        <option value="-11"<?= (($_SESSION["config"][PREF_TIMEZONE] == "-11") ? " selected=\"selected\"" : "") ?>>GMT - 11:00 hours</option>
        <option value="-10"<?= (($_SESSION["config"][PREF_TIMEZONE] == "-10") ? " selected=\"selected\"" : "") ?>>GMT - 10:00 hours</option>
        <option value="-9"<?= (($_SESSION["config"][PREF_TIMEZONE] == "-9") ? " selected=\"selected\"" : "") ?>>GMT - 9:00 hours</option>
        <option value="-8"<?= (($_SESSION["config"][PREF_TIMEZONE] == "-8") ? " selected=\"selected\"" : "") ?>>GMT - 8:00 hours</option>
        <option value="-7"<?= (($_SESSION["config"][PREF_TIMEZONE] == "-7") ? " selected=\"selected\"" : "") ?>>GMT - 7:00 hours</option>
        <option value="-6"<?= (($_SESSION["config"][PREF_TIMEZONE] == "-6") ? " selected=\"selected\"" : "") ?>>GMT - 6:00 hours</option>
        <option value="-5"<?= (($_SESSION["config"][PREF_TIMEZONE] == "-5") ? " selected=\"selected\"" : "") ?>>GMT - 5:00 hours</option>
        <option value="-4"<?= (($_SESSION["config"][PREF_TIMEZONE] == "-4") ? " selected=\"selected\"" : "") ?>>GMT - 4:00 hours</option>
        <option value="-3.5"<?= (($_SESSION["config"][PREF_TIMEZONE] == "-3.5") ? " selected=\"selected\"" : "") ?>>GMT - 3:30 hours</option>
        <option value="-3"<?= (($_SESSION["config"][PREF_TIMEZONE] == "-3") ? " selected=\"selected\"" : "") ?>>GMT - 3:00 hours</option>
        <option value="-2"<?= (($_SESSION["config"][PREF_TIMEZONE] == "-2") ? " selected=\"selected\"" : "") ?>>GMT - 2:00 hours</option>
        <option value="-1"<?= (($_SESSION["config"][PREF_TIMEZONE] == "-1") ? " selected=\"selected\"" : "") ?>>GMT - 1:00 hour</option>
        <option value="0"<?= (($_SESSION["config"][PREF_TIMEZONE] == "0") ? " selected=\"selected\"" : "") ?>>GMT</option>
        <option value="1"<?= (($_SESSION["config"][PREF_TIMEZONE] == "1") ? " selected=\"selected\"" : "") ?>>GMT + 1:00 hour</option>
        <option value="2"<?= (($_SESSION["config"][PREF_TIMEZONE] == "2") ? " selected=\"selected\"" : "") ?>>GMT + 2:00 hours</option>
        <option value="3"<?= (($_SESSION["config"][PREF_TIMEZONE] == "3") ? " selected=\"selected\"" : "") ?>>GMT + 3:00 hours</option>
        <option value="3.5"<?= (($_SESSION["config"][PREF_TIMEZONE] == "3.5") ? " selected=\"selected\"" : "") ?>>GMT + 3:30 hours</option>
        <option value="4"<?= (($_SESSION["config"][PREF_TIMEZONE] == "4") ? " selected=\"selected\"" : "") ?>>GMT + 4:00 hours</option>
        <option value="4.5"<?= (($_SESSION["config"][PREF_TIMEZONE] == "4.5") ? " selected=\"selected\"" : "") ?>>GMT + 4:30 hours</option>
        <option value="5"<?= (($_SESSION["config"][PREF_TIMEZONE] == "5") ? " selected=\"selected\"" : "") ?>>GMT + 5:00 hours</option>
        <option value="5.5"<?= (($_SESSION["config"][PREF_TIMEZONE] == "5.5") ? " selected=\"selected\"" : "") ?>>GMT + 5:30 hours</option>
        <option value="6"<?= (($_SESSION["config"][PREF_TIMEZONE] == "6") ? " selected=\"selected\"" : "") ?>>GMT + 6:00 hours</option>
        <option value="7"<?= (($_SESSION["config"][PREF_TIMEZONE] == "7") ? " selected=\"selected\"" : "") ?>>GMT + 7:00 hours</option>
        <option value="8"<?= (($_SESSION["config"][PREF_TIMEZONE] == "8") ? " selected=\"selected\"" : "") ?>>GMT + 8:00 hours</option>
        <option value="9"<?= (($_SESSION["config"][PREF_TIMEZONE] == "9") ? " selected=\"selected\"" : "") ?>>GMT + 9:00 hours</option>
        <option value="9.5"<?= (($_SESSION["config"][PREF_TIMEZONE] == "9.5") ? " selected=\"selected\"" : "") ?>>GMT + 9:30 hours</option>
        <option value="10"<?= (($_SESSION["config"][PREF_TIMEZONE] == "10") ? " selected=\"selected\"" : "") ?>>GMT + 10:00 hours</option>
        <option value="11"<?= (($_SESSION["config"][PREF_TIMEZONE] == "11") ? " selected=\"selected\"" : "") ?>>GMT + 11:00 hours</option>
        <option value="12"<?= (($_SESSION["config"][PREF_TIMEZONE] == "12") ? " selected=\"selected\"" : "") ?>>GMT + 12:00 hours</option>
        </select>
        <span class="small-grey">(<?= display_date($_SESSION["config"][PREF_DATEFORMAT], time()) ?>)</span>
      </td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Adjust Daylight Savings Time</em></strong><br />This option allows you to specify whether or not you would like ListMessenger to try to automatically adjust for daylight savings time.<br /><br /><strong>Note:</strong><br />There are many countries on Earth who do not use Daylight Savings Time, and many countries who\'s daylight savings time starts on different hours or different days.'));">Adjust Daylight Savings Time:</span></td>
      <td>
        <select style="width: 154px" name="preferences[<?= PREF_DAYLIGHT_SAVINGS ?>]" onkeypress="return handleEnter(this, event)">
        <option value="yes"<?= (($_SESSION["config"][PREF_DAYLIGHT_SAVINGS] == "yes") ? " selected=\"selected\"" : "") ?>>Yes</option>
        <option value="no"<?= (($_SESSION["config"][PREF_DAYLIGHT_SAVINGS] == "no") ? " selected=\"selected\"" : "") ?>>No</option>
        </select>
      </td>
    </tr>
    </table>
    </fieldset>

    <br />
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
        <input type="button" class="button" value="Close" onclick="window.location='index.php?section=preferences'" />&nbsp;
        <input type="submit" name="save" class="button" value="Save" />
      </td>
    </tr>
    </table>
    </form>
    <?php
  break;
  case "enduser" :
    if($_POST) {
      if((@is_array($_POST["preferences"])) && (@count($_POST["preferences"]) > 0)) {
        foreach($_POST["preferences"] as $preference_id => $preference_value) {
          $preference_value  = trim($preference_value);
          $skip_query    = false;
          switch($preference_id) {
            case ENDUSER_CAPTCHA :
              if($preference_value != "yes") {
                $preference_value = "no";
              }
            break;
            case ENDUSER_UNSUBCON :
              if($preference_value != "yes") {
                $preference_value = "no";
              }
            break;
            case ENDUSER_SUBCON :
              if($preference_value != "yes") {
                $preference_value = "no";
              }
            break;
            case PREF_EXPIRE_CONFIRM :
              if(!(int) $preference_value) {
                $ERROR++;
                $ERRORSTR[] = "Please select a valid number of days that you would like confirmation notices to expire.";
                $skip_query = true;
              }
            break;
            case PREF_POSTSUBSCRIBE_MSG :
              $preference_value = (int) $preference_value;
            break;
            case PREF_POSTUNSUBSCRIBE_MSG :
              $preference_value = (int) $preference_value;
            break;
            case ENDUSER_NEWSUBNOTICE :
              if($preference_value != "yes") {
                $preference_value = "no";
              }
            break;
            case ENDUSER_UNSUBNOTICE :
              if($preference_value != "yes") {
                $preference_value = "no";
              }
            break;
            case PREF_FOPEN_URL :
              if($preference_value != "yes") {
                $preference_value = "no";
              }
            break;
            case ENDUSER_MXRECORD :
              if($preference_value != "yes") {
                $preference_value = "no";
              }
            break;
            case ENDUSER_ARCHIVE :
              if($preference_value != "yes") {
                $preference_value = "no";
              }
            break;
            case ENDUSER_PROFILE :
              if($preference_value != "yes") {
                $preference_value = "no";
              }
            break;
            case ENDUSER_LANG_ID :
              if(!@file_exists($_SESSION["config"][PREF_PUBLIC_PATH]."languages/".$preference_value.".lang.php")) {
                $ERROR++;
                $ERRORSTR[] = "The language file [".$preference_value.".lang.php] that you have selected does not exist in ".$_SESSION["config"][PREF_PUBLIC_PATH]."languages/".".";
                $skip_query = true;
              }
            break;
            case ENDUSER_ARCHIVE_FILENAME :
              if(!@file_exists($_SESSION["config"][PREF_PUBLIC_PATH].$preference_value)) {
                $ERROR++;
                $ERRORSTR[] = "The Archive Script Filename [".$preference_value."] that you have specified does not exist in ".$_SESSION["config"][PREF_PUBLIC_PATH].".";
                $skip_query = true;
              }
            break;
            case ENDUSER_PROFILE_FILENAME :
              if(!@file_exists($_SESSION["config"][PREF_PUBLIC_PATH].$preference_value)) {
                $ERROR++;
                $ERRORSTR[] = "The Profile Script Filename [".$preference_value."] that you have specified does not exist in ".$_SESSION["config"][PREF_PUBLIC_PATH].".";
                $skip_query = true;
              }
            break;
            case ENDUSER_CONFIRM_FILENAME :
              if(!@file_exists($_SESSION["config"][PREF_PUBLIC_PATH].$preference_value)) {
                $ERROR++;
                $ERRORSTR[] = "The Confirmation Script Filename [".$preference_value."] that you have specified does not exist in ".$_SESSION["config"][PREF_PUBLIC_PATH].".";
                $skip_query = true;
              }
            break;
            case ENDUSER_HELP_FILENAME :
              if(!@file_exists($_SESSION["config"][PREF_PUBLIC_PATH].$preference_value)) {
                $ERROR++;
                $ERRORSTR[] = "The Help Page Filename [".$preference_value."] that you have specified does not exist in ".$_SESSION["config"][PREF_PUBLIC_PATH].".";
                $skip_query = true;
              }
            break;
            case ENDUSER_FILENAME :
              if(!@file_exists($_SESSION["config"][PREF_PUBLIC_PATH].$preference_value)) {
                $ERROR++;
                $ERRORSTR[] = "The End-User Script Filename [".$preference_value."] that you have specified does not exist in ".$_SESSION["config"][PREF_PUBLIC_PATH].".";
                $skip_query = true;
              }
            break;
            case ENDUSER_TEMPLATE :
              if(!@file_exists($_SESSION["config"][PREF_PUBLIC_PATH].$preference_value)) {
                $ERROR++;
                $ERRORSTR[] = "The End-User Template Filename [".$preference_value."] that you have specified does not exist in ".$_SESSION["config"][PREF_PUBLIC_PATH].".";
                $skip_query = true;
              }
            break;
            case ENDUSER_UNSUB_FILENAME :
              if(!@file_exists($_SESSION["config"][PREF_PUBLIC_PATH].$preference_value)) {
                $ERROR++;
                $ERRORSTR[] = "The Unsubscribe Script [".$preference_value."] that you have specified does not exist in ".$_SESSION["config"][PREF_PUBLIC_PATH].".";
                $skip_query = true;
              }
            break;
            case ENDUSER_BANEMAIL :
              if($preference_value != "") {
                $value  = str_replace("\r", "\n", $preference_value);
                $banned  = str_replace("\n\n", "\n", $value);
                $preference_value  = str_replace("\n", ";", $banned);
              } else {
                $preference_value  = "";
              }
            break;
            case ENDUSER_BANDOMS :
              if($preference_value != "") {
                $value  = str_replace("\r", "\n", $preference_value);
                $banned  = str_replace("\n\n", "\n", $value);
                $preference_value  = str_replace("\n", ";", $banned);
              } else {
                $preference_value  = "";
              }
            break;
            default :
              $ERROR++;
              $ERRORSTR[] = "Unrecognized preference ID [".$preference_id."] with a value of [".$preference_value."] was passed to preferences updater.";
              $skip_query = true;
            break;
          }

          // Only change modified preferences.
          if($_SESSION["config"][$preference_id] == $preference_value) {
            $skip_query = true;
          }

          if(!$skip_query) {
            $query = "UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='".checkslashes($preference_value)."' WHERE `preference_id`='".$preference_id."'";
            if(!$db->Execute($query)) {
              $ERROR++;
              $ERRORSTR[] = "Unable to update preference ID ".$preference_id.". Please check your error log for more information.";
              if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tPreference ID ".$preference_id." was not updated. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
              }
            }
          }
        }

        if(!reload_configuration()) {
          $ERROR++;
          $ERRORSTR[] = "Unable to reload your configuration into your session. Please check your error log for more information, but you'll have to close and then re-open your web-browser to load the changed settings.";

          if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
            @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to reload the settings from the database. The load_settings() function returned false.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
          }
        } else {
          $SUCCESS++;
          $SUCCESSSTR[] = "You have successfully updated and reloaded the ListMessenger End-User Preferences.";
        }
      }
    }

    if(!@is_dir($_SESSION["config"][PREF_PUBLIC_PATH])) {
      $NOTICE++;
      $NOTICESTR[] = "Your Public Folder Directory Path does not exist at ".$_SESSION["config"][PREF_PUBLIC_PATH]." or is not readable by PHP. Please log into the ListMessenger Program Preferences and update the Public Folder Directory Path.";
    }

    ?>
    <h1>End-User Preferences</h1>
    <img src="images/record-next-on.gif" width="9" height="9" hspace="2" vspace="2" style="vertical-align: middle" alt="" title="" /> <a href="index.php?section=preferences">Preferences and Configuration</a>&nbsp;
    <img src="images/record-next-on.gif" width="9" height="9" hspace="2" vspace="2" style="vertical-align: middle" alt="" title="" /> End-User Preferences
    <br /><br />
    <?php echo (($ERROR) ? display_error($ERRORSTR) : ""); ?>
    <?php echo (($NOTICE) ? display_notice($NOTICESTR) : ""); ?>
    <?php echo (($SUCCESS) ? display_success($SUCCESSSTR) : ""); ?>
    <form action="index.php?section=preferences&type=enduser" method="post">
    <fieldset>
    <legend class="page-subheading">Confirmation Settings</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Require CAPTCHA Image Confirmation</em></strong><br />Require subscribers to enter the text in a CAPTCHA image code before being able to subscribe to your list.<br /><br />This requires GD Image Library to be compiled with PHP, as well as Freetype support.'));">Require <acronym title="Completely Automated Public Turing test to tell Computers and Humans Apart">CAPTCHA</acronym> Image Confirmation:</span></td>
      <td style="width: 60%">
        <?php
        if((!function_exists("gd_info")) || (!function_exists("imagettftext"))) {
          echo "<input type=\"hidden\" name=\"preferences[".ENDUSER_CAPTCHA."]\" value=\"no\" />\n";
          $allow_captcha = false;
        } else {
          $allow_captcha = true;
        }
        ?>
        <select style="width: 154px" name="preferences[<?php echo ENDUSER_CAPTCHA; ?>]" onkeypress="return handleEnter(this, event)"<?php echo ((!$allow_captcha) ? " disabled=\"disabled\"" : ""); ?>>
          <option value="yes"<?php echo ((($allow_captcha) && ($_SESSION["config"][ENDUSER_CAPTCHA] == "yes")) ? " selected=\"selected\"" : "") ?>>Yes</option>
          <option value="no"<?php echo (((!$allow_captcha) || ($_SESSION["config"][ENDUSER_CAPTCHA] == "no")) ? " selected=\"selected\"" : "") ?>>No</option>
        </select>
      </td>
    </tr>
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Send Opt-In Confirmation</em></strong><br />Send a confirmation e-mail prior to potential subscribers prior to adding them to your mailing list.<br /><br /><strong>Important:</strong><br />This option in most all cases should be set to Yes. If you do not require users to confirm their subscriptions then you run the risk of being accused of being named a spammer.'));">Send Opt-In Confirmation:</span></td>
      <td style="width: 60%">
        <select style="width: 154px" name="preferences[<?= ENDUSER_SUBCON ?>]" onkeypress="return handleEnter(this, event)">
        <option value="yes"<?= (($_SESSION["config"][ENDUSER_SUBCON] == "yes") ? " selected=\"selected\"" : "") ?>>Yes</option>
        <option value="no"<?= (($_SESSION["config"][ENDUSER_SUBCON] == "no") ? " selected=\"selected\"" : "") ?>>No</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Send Opt-Out Confirmation</em></strong><br />Send a confirmation e-mail prior to removing subscribers from your mailing list.'));">Send Opt-Out Confirmation:</span></td>
      <td>
        <select style="width: 154px" name="preferences[<?= ENDUSER_UNSUBCON ?>]" onkeypress="return handleEnter(this, event)">
        <option value="yes"<?= (($_SESSION["config"][ENDUSER_UNSUBCON] == "yes") ? " selected=\"selected\"" : "") ?>>Yes</option>
        <option value="no"<?= (($_SESSION["config"][ENDUSER_UNSUBCON] == "no") ? " selected=\"selected\"" : "") ?>>No</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Confirmation Expiry</em></strong><br />This is the number of days that the Opt-In and Opt-Out Confirmation links are valid for. After the expiry date, confirmations are no longer valid and will be removed.<br /><br /><strong>Notice:</strong><br />This option is only valid if Send Opt-In or Opt-Out Confirmation is set to yes.'));">Confirmation Expiry:</span></td>
      <td>
        <select style="width: 154px" name="preferences[<?= PREF_EXPIRE_CONFIRM ?>]" onkeypress="return handleEnter(this, event)">
        <option value="1"<?= (($_SESSION["config"][PREF_EXPIRE_CONFIRM] == "1") ? " selected=\"selected\"" : "") ?>>1 Day</option>
        <option value="3"<?= (($_SESSION["config"][PREF_EXPIRE_CONFIRM] == "3") ? " selected=\"selected\"" : "") ?>>3 Days</option>
        <option value="5"<?= (($_SESSION["config"][PREF_EXPIRE_CONFIRM] == "5") ? " selected=\"selected\"" : "") ?>>5 Days</option>
        <option value="7"<?= (($_SESSION["config"][PREF_EXPIRE_CONFIRM] == "7") ? " selected=\"selected\"" : "") ?>>7 Days</option>
        <option value="14"<?= (($_SESSION["config"][PREF_EXPIRE_CONFIRM] == "14") ? " selected=\"selected\"" : "") ?>>14 Days</option>
        <option value="31"<?= (($_SESSION["config"][PREF_EXPIRE_CONFIRM] == "31") ? " selected=\"selected\"" : "") ?>>31 Days</option>
        </select>
      </td>
    </tr>
    </table>
    </fieldset>

    <br />
    <fieldset>
    <legend class="page-subheading">Notification &amp; Message Options</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>New Subscriber Notification</em></strong><br />Enable this if you want to be notified every time a new subscriber subscribes to a list in ListMessenger.'));">New Subscriber Notification:</span></td>
      <td style="width: 60%">
        <select style="width: 154px" name="preferences[<?= ENDUSER_NEWSUBNOTICE ?>]" onkeypress="return handleEnter(this, event)">
        <option value="yes"<?= (($_SESSION["config"][ENDUSER_NEWSUBNOTICE] == "yes") ? " selected=\"selected\"" : "") ?>>Enabled</option>
        <option value="no"<?= (($_SESSION["config"][ENDUSER_NEWSUBNOTICE] == "no") ? " selected=\"selected\"" : "") ?>>Disabled</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Unsubscribe Notification</em></strong><br />Enable this if you want to be notified every time a subscriber unsubscribes from a list in ListMessenger.'));">Unsubscribe Notification:</span></td>
      <td>
        <select style="width: 154px" name="preferences[<?= ENDUSER_UNSUBNOTICE ?>]" onkeypress="return handleEnter(this, event)">
        <option value="yes"<?= (($_SESSION["config"][ENDUSER_UNSUBNOTICE] == "yes") ? " selected=\"selected\"" : "") ?>>Enabled</option>
        <option value="no"<?= (($_SESSION["config"][ENDUSER_UNSUBNOTICE] == "no") ? " selected=\"selected\"" : "") ?>>Disabled</option>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Post Subscription Message</em></strong><br />You can enable this option if you would like your subscribers to receive an e-mail which resides in your Message Centre automatically after they subscribe to your mailing list.<br /><br /><strong>Tip:</strong><br />You can use this to send your subscribers a post subscription welcome message!'));">Post Subscription Message:</span></td>
      <td>
        <select style="width: 100%" name="preferences[<?= PREF_POSTSUBSCRIBE_MSG ?>]" onkeypress="return handleEnter(this, event)">
        <option value="0"<?= (($_SESSION["config"][PREF_POSTSUBSCRIBE_MSG] == "0") ? " selected=\"selected\"" : "") ?>>-- No Post Subscribe Message Sent --</option>
        <?php
        $query  = "SELECT `message_id`, `message_title` FROM `".TABLES_PREFIX."messages` ORDER BY `message_date` DESC";
        $results  = $db->GetAll($query);
        if($results) {
          foreach($results as $result) {
            echo "<option value=\"".$result["message_id"]."\"".(($_SESSION["config"][PREF_POSTSUBSCRIBE_MSG] == $result["message_id"]) ? " selected=\"selected\"" : "").">".html_encode($result["message_title"])."</option>\n";
          }
        }
        ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Post Unsubscribe Message</em></strong><br />You can enable this option if you would like your subscribers a message which resides in your Message Centre automatically after remove themselves from your mailing list.<br /><br /><strong>Tip:</strong><br />You can use this to send your subscribers a sorry-to-see-you-go, message or something to that effect.'));">Post Unsubscribe Message:</span></td>
      <td>
        <select style="width: 100%" name="preferences[<?= PREF_POSTUNSUBSCRIBE_MSG ?>]" onkeypress="return handleEnter(this, event)">
        <option value="0"<?= (($_SESSION["config"][PREF_POSTUNSUBSCRIBE_MSG] == "0") ? " selected=\"selected\"" : "") ?>>-- No Post Unsubscribe Message Sent --</option>
        <?php
        $query  = "SELECT `message_id`, `message_title` FROM `".TABLES_PREFIX."messages` ORDER BY `message_date` DESC";
        $results  = $db->GetAll($query);
        if($results) {
          foreach($results as $result) {
            echo "<option value=\"".$result["message_id"]."\"".(($_SESSION["config"][PREF_POSTUNSUBSCRIBE_MSG] == $result["message_id"]) ? " selected=\"selected\"" : "").">".html_encode($result["message_title"])."</option>\n";
          }
        }
        ?>
        </select>
      </td>
    </tr>
    </table>
    </fieldset>

    <br />
    <fieldset>
    <legend class="page-subheading">Display Options</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Allow URL Fopening</em></strong><br />Set this to yes if you want ListMessenger to open your template file using using the full URL instead of the path. This is useful if your template file is a PHP file that needs to be parsed by PHP.<br /><br /><strong>Important:</strong><br />You must have &quot;allow_url_fopen&quot; enabled in your php.ini file, your server must properly resolve your domain name and any load-balancers must properly be configured.'));">Allow URL Fopening:</span></td>
      <td style="width: 60%">
        <select style="width: 154px" name="preferences[<?= PREF_FOPEN_URL ?>]" onkeypress="return handleEnter(this, event)"<?= (((!@ini_get("allow_url_fopen")) || (@ini_get("allow_url_fopen") == "Off")) ? " DISABLED" : "") ?>>
        <option value="yes"<?= ((((@ini_get("allow_url_fopen")) || (@ini_get("allow_url_fopen") == "On")) && ($_SESSION["config"][PREF_FOPEN_URL] == "yes")) ? " selected=\"selected\"" : "") ?>>Yes</option>
        <option value="no"<?= (((!@ini_get("allow_url_fopen")) || (@ini_get("allow_url_fopen") == "Off") || ($_SESSION["config"][PREF_FOPEN_URL] == "no")) ? " selected=\"selected\"" : "") ?>>No</option>
        </select>
        <?= (((!@ini_get("allow_url_fopen")) || (@ini_get("allow_url_fopen") == "Off")) ? " <input type=\"hidden\" name=\"preferences[".PREF_FOPEN_URL."]\" value=\"no\" />" : "") ?>
      </td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>MX Record Lookup</em></strong><br />Set this to yes if you want the subscribers e-mail address domain name to be checked for validity when they are subscribing.<br /><br /><strong>Important:</strong><br />This option is not available if ListMessenger is installed on a Windows server.'));">MX Record Lookup:</span></td>
      <td>
        <select style="width: 154px" name="preferences[<?= ENDUSER_MXRECORD ?>]" onkeypress="return handleEnter(this, event)"<?= ((@preg_match("/([^dar]win[dows]*)[\s]?([0-9a-z]*)[\w\s]?([a-z0-9.]*)/i", PHP_OS, $matches)) ? " DISABLED" : "") ?>>
        <option value="yes"<?= (($_SESSION["config"][ENDUSER_MXRECORD] == "yes") ? " selected=\"selected\"" : "") ?>>Yes</option>
        <option value="no"<?= (($_SESSION["config"][ENDUSER_MXRECORD] == "no") ? " selected=\"selected\"" : "") ?>>No</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Enable Public Archive</em></strong><br />If you would like to enable people to view a list of all messages you have sent out in the past through their web-browser, you can set this to yes.'));">Enable Public Archive:</span></td>
      <td>
        <select style="width: 154px" name="preferences[<?= ENDUSER_ARCHIVE ?>]" onkeypress="return handleEnter(this, event)">
        <option value="yes"<?= (($_SESSION["config"][ENDUSER_ARCHIVE] == "yes") ? " selected=\"selected\"" : "") ?>>Yes</option>
        <option value="no"<?= (($_SESSION["config"][ENDUSER_ARCHIVE] == "no") ? " selected=\"selected\"" : "") ?>>No</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Enable Profile Updates</em></strong><br />If you would like to allow subscribers to update their subscriber profile, you can set this to yes.'));">Enable Profile Updates:</span></td>
      <td>
        <select style="width: 154px" name="preferences[<?= ENDUSER_PROFILE ?>]" onkeypress="return handleEnter(this, event)">
        <option value="yes"<?= (($_SESSION["config"][ENDUSER_PROFILE] == "yes") ? " selected=\"selected\"" : "") ?>>Yes</option>
        <option value="no"<?= (($_SESSION["config"][ENDUSER_PROFILE] == "no") ? " selected=\"selected\"" : "") ?>>No</option>
        </select>
      </td>
    </tr>
    <?php
    $language_directory  = $_SESSION["config"][PREF_PUBLIC_PATH]."languages/";
    if(@is_dir($language_directory)) {
      $handle = @opendir($language_directory);
      if($handle) {
        ?>
        <tr>
          <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Default End-User Language File</em></strong><br />This list shows all of the language files that currently reside in the languages folder which is located in the Public directory.'));">Default End-User Language File:</span></td>
          <td>
          <?php
          echo "<select style=\"width: 154px\" name=\"preferences[".ENDUSER_LANG_ID."]\" onkeypress=\"return handleEnter(this, event)\">\n";
          while(false !== ($file = @readdir($handle))) {
            if(!@is_dir($file)) {
              $pieces = explode(".", strtolower($file));
              if(($pieces[1] == "lang") && (count($pieces) == 3) && (@filesize($language_directory.$file) > 0)) {
                echo "<option value=\"".$pieces[0]."\"".(($_SESSION["config"][ENDUSER_LANG_ID] == $pieces[0]) ? " selected=\"selected\"" : "").">".ucwords($pieces[0])."</option>\n";
              }
            }
          }
          echo "</select>\n";
          ?>
          <span class="small-grey">(Latest language files: <a style="font-size: 11px; font-weight: normal">click here</a>)</span>
          </td>
        </tr>
        <?php
      } else {
        $ERROR++;
        $ERRORSTR[] = "Unable to read any language files in your languages directory. Please ensure that there are valid language files in your public/languages directory.";
        echo "<tr>\n";
        echo "  <td colspan=\"2\">\n";
        echo   display_error($ERRORSTR);
        echo "  </td>\n";
        echo "</tr>\n";
      }
    } else {
      $ERROR++;
      $ERRORSTR[] = "Unable to read find your languages directory at ".$language_directory.". Please ensure that the language directory exists and contains valid ListMessenger language files.";
      echo "<tr>\n";
      echo "  <td colspan=\"2\">\n";
      echo   display_error($ERRORSTR);
      echo "  </td>\n";
      echo "</tr>\n";
    }
    ?>
    </table>
    </fieldset>

    <br />
    <fieldset>
    <legend class="page-subheading">End-User Files</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Archive Script Filename</em></strong><br />This file is called archive.php by default and is responsible for displaying the public archive of messages sent.<br /><br /><strong>Tip:</strong><br />This script can be enabled or disabled in the Display Options category.'));">Archive Script Filename:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 150px" name="preferences[<?= ENDUSER_ARCHIVE_FILENAME ?>]" value="<?= $_SESSION["config"][ENDUSER_ARCHIVE_FILENAME] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Confirm Script Filename</em></strong><br />This file is called confirm.php by default and is responsible for handling all confirmations for both unsubscribing and subscribing.'));">Confirmation Script Filename:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 150px" name="preferences[<?= ENDUSER_CONFIRM_FILENAME ?>]" value="<?= $_SESSION["config"][ENDUSER_CONFIRM_FILENAME] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Help Page Filename</em></strong><br />This file is called help.php by default and displays basic help information for subscribers who wish to know more about a list they are on.'));">Help Page Filename:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 150px" name="preferences[<?= ENDUSER_HELP_FILENAME ?>]" value="<?= $_SESSION["config"][ENDUSER_HELP_FILENAME] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>End-User Script Filename</em></strong><br />This file is called listmessenger.php by default and generally takes care of all end-user transactions.'));">End-User Script Filename:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 150px" name="preferences[<?= ENDUSER_FILENAME ?>]" value="<?= $_SESSION["config"][ENDUSER_FILENAME] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Profile Script Filename</em></strong><br />This file is called profile.php by default and allows subscribers to update their profile on the mailing list.'));">Profile Script Filename:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 150px" name="preferences[<?= ENDUSER_PROFILE_FILENAME ?>]" value="<?= $_SESSION["config"][ENDUSER_PROFILE_FILENAME] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>End-User Template Filename</em></strong><br />This file is called template.html by default and is wrapped around the end-user output. This file <strong>must</strong> include a [title] variable, and [message] variable to function properly.'));">End-User Template Filename:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 150px" name="preferences[<?= ENDUSER_TEMPLATE ?>]" value="<?= $_SESSION["config"][ENDUSER_TEMPLATE] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Unsubscribe Script Filename</em></strong><br />This file is called unsubscribe.php by default and generally takes care of all unsubscribe actions.'));">Unsubscribe Script Filename:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 150px" name="preferences[<?= ENDUSER_UNSUB_FILENAME ?>]" value="<?= $_SESSION["config"][ENDUSER_UNSUB_FILENAME] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td colspan="2">
        <br />
        <div style="background-color: #FFFFCC; border: 1px #FFCC00 solid; padding: 5px">These files <strong>must</strong> be present in your Public Folder directory.</div>
      </td>
    </tr>
    </table>
    </fieldset>

    <br />
    <fieldset>
    <legend class="page-subheading">Banned Subscribers</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%; vertical-align: top" class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Banned E-Mail Addresses</em></strong><br />If you would like to ban an e-mail address from being able to subscribe to any and all of your mailing lists, simply enter the address, one per line in this textarea.'));">Banned E-Mail Addresses:</span></td>
      <td style="width: 60%">
        <textarea style="width: 100%; height: 75px" name="preferences[<?= ENDUSER_BANEMAIL ?>]"><?= str_replace(";", "\n", $_SESSION["config"][ENDUSER_BANEMAIL]) ?></textarea>
      </td>
    </tr>
    <tr>
      <td style="width: 40%; vertical-align: top" class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Banned Domain Names</em></strong><br />If you would like to ban all e-mail addresses from a specific domain name (ie, hotmail.com), simply enter the FQDN (ie, hotmail.com), one per line in this textarea.'));">Banned Domain Names:</span></td>
      <td style="width: 60%">
        <textarea style="width: 100%; height: 75px" name="preferences[<?= ENDUSER_BANDOMS ?>]"><?= str_replace(";", "\n", $_SESSION["config"][ENDUSER_BANDOMS]) ?></textarea>
      </td>
    </tr>
    </table>
    </fieldset>

    <br />
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
        <input type="button" class="button" value="Close" onclick="window.location='index.php?section=preferences'" />&nbsp;
        <input type="submit" name="save" class="button" value="Save" />
      </td>
    </tr>
    </table>
    </form>
    <?php
  break;
  case "email" :
    if($_POST) {
      if((@is_array($_POST["preferences"])) && (@count($_POST["preferences"]) > 0)) {
        foreach($_POST["preferences"] as $preference_id => $preference_value) {
          $preference_value  = trim($preference_value);
          $skip_query    = false;
          switch($preference_id) {
            case PREF_WORDWRAP :
              if(!(int) $preference_value) {
                $ERROR++;
                $ERRORSTR[] = "Please enter a valid number of characters you would like ListMessenger to wrap your outgoing messages to.";
                $skip_query = true;
              }
            break;
            case PREF_ADD_UNSUB_LINK :
              if($preference_value != "yes") {
                $preference_value = "no";
              }
            break;
            case PREF_MSG_PER_REFRESH :
              if(!(int) $preference_value) {
                $ERROR++;
                $ERRORSTR[] = "Please enter a valid number of messages you would like ListMessenger to send per refresh.";
                $skip_query = true;
              }
            break;
            case PREF_PAUSE_BETWEEN :
              if(!(int) $preference_value) {
                $ERROR++;
                $ERRORSTR[] = "Please enter a valid number of seconds you would like ListMessenger pause between refreshes.";
                $skip_query = true;
              }
            break;
            case PREF_QUEUE_TIMEOUT :
              if(!(int) $preference_value) {
                $ERROR++;
                $ERRORSTR[] = "Please enter a valid number of seconds that ListMessenger will consider your sending process stalled after.";
                $skip_query = true;
              }
            break;
            case PREF_MAILER_BY_ID :
              $skip_query = true;
              switch ($preference_value) {
                case "mail" :
                  $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='mail' WHERE `preference_id`='".$preference_id."'");
                  $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='' WHERE `preference_id`='".PREF_MAILER_BY_VALUE."'");
                  $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='yes' WHERE `preference_id`='".PREF_MAILER_SMTP_KALIVE."'");
                  $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='false' WHERE `preference_id`='".PREF_MAILER_AUTH_ID."'");
                  $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='' WHERE `preference_id`='".PREF_MAILER_AUTHUSER_ID."'");
                  $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='' WHERE `preference_id`='".PREF_MAILER_AUTHPASS_ID."'");
                break;
                case "smtp" :
                  if(strlen(trim($_POST["smtp_servers"])) > 1) {
                    $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='smtp' WHERE `preference_id`='".$preference_id."'");
                    $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='".checkslashes(trim($_POST["smtp_servers"]))."' WHERE `preference_id`='".PREF_MAILER_BY_VALUE."'");
                    $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='".(((isset($_POST["smtp_keep_alive"])) && (trim($_POST["smtp_keep_alive"]) != "no")) ? "yes" : "no")."' WHERE `preference_id`='".PREF_MAILER_SMTP_KALIVE."'");
                    if($_POST["smtp_authentication"] == "true") {
                      $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='true' WHERE `preference_id`='".PREF_MAILER_AUTH_ID."'");
                      $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='".checkslashes(trim($_POST["auth_username"]))."' WHERE `preference_id`='".PREF_MAILER_AUTHUSER_ID."'");
                      $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='".checkslashes(trim($_POST["auth_password"]))."' WHERE `preference_id`='".PREF_MAILER_AUTHPASS_ID."'");
                    } else {
                      $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='false' WHERE `preference_id`='".PREF_MAILER_AUTH_ID."'");
                      $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='' WHERE `preference_id`='".PREF_MAILER_AUTHUSER_ID."'");
                      $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='' WHERE `preference_id`='".PREF_MAILER_AUTHPASS_ID."'");
                    }
                  } else {
                    $ERROR++;
                    $ERRORSTR[] = "If you select to send mail using SMTP you must provide a valid SMTP server to send mail through.";
                  }
                break;
                case "sendmail" :
                  if(strlen(trim($_POST["sendmail_path"])) > 1) {
                    $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='sendmail' WHERE `preference_id`='".$preference_id."'");
                    $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='yes' WHERE `preference_id`='".PREF_MAILER_SMTP_KALIVE."'");
                    $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='false' WHERE `preference_id`='".PREF_MAILER_AUTH_ID."'");
                    $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='' WHERE `preference_id`='".PREF_MAILER_AUTHUSER_ID."'");
                    $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='' WHERE `preference_id`='".PREF_MAILER_AUTHPASS_ID."'");
                    $db->Execute("UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='".checkslashes(trim($_POST["sendmail_path"]))."' WHERE `preference_id`='".PREF_MAILER_BY_VALUE."'");
                  } else {
                    $ERROR++;
                    $ERRORSTR[] = "If you select to send mail using Sendmail you must provide a valid path to the Sendmail executable.";
                  }
                break;
              }
            break;
            case PREF_MAILER_BY_VALUE :
              $skip_query = true;
            break;
            case PREF_MAILER_AUTH_ID :
              $skip_query = true;
            break;
            case PREF_MAILER_AUTHUSER_ID :
              $skip_query = true;
            break;
            case PREF_MAILER_AUTHPASS_ID :
              $skip_query = true;
            break;
            default :
              $ERROR++;
              $ERRORSTR[] = "Unrecognized preference ID [".$preference_id."] with a value of [".$preference_value."] was passed to preferences updater.";
              $skip_query = true;
            break;
          }

          if(!$skip_query) {
            $query  = "UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='".checkslashes($preference_value)."' WHERE `preference_id`='".$preference_id."'";
            if(!$db->Execute($query)) {
              $ERROR++;
              $ERRORSTR[] = "Unable to update preference ID ".$preference_id.". Please check your error log for more information.";
              if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tPreference ID ".$preference_id." was not updated. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
              }
            }
          }
        }

        if(!reload_configuration()) {
          $ERROR++;
          $ERRORSTR[] = "Unable to reload your configuration into your session. Please check your error log for more information, but you'll have to close and then re-open your web-browser to load the changed settings.";

          if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
            @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to reload the settings from the database. The load_settings() function returned false.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
          }
        } else {
          if(!$ERROR) {
            $SUCCESS++;
            $SUCCESSSTR[] = "You have successfully updated and reloaded the ListMessenger E-Mail Configuration.";
          }
        }
      }
    }

    if(!@is_dir($_SESSION["config"][PREF_PUBLIC_PATH])) {
      $NOTICE++;
      $NOTICESTR[] = "Your Public Folder Directory Path does not exist at ".$_SESSION["config"][PREF_PUBLIC_PATH]." or is not readable by PHP. Please log into the ListMessenger Program Preferences and update the Public Folder Directory Path.";
    }

    ?>
    <script language="JavaScript" type="text/javascript">
    function optionsDisplay(sendType) {
      switch (sendType) {
        case 'mail' :
          div_hide(element_type('smtpOptions'));
          div_hide(element_type('sendmailOptions'));
        break;
        case 'smtp' :
          div_show(element_type('smtpOptions'));
          div_hide(element_type('sendmailOptions'));
        break;
        case 'sendmail' :
          div_hide(element_type('smtpOptions'));
          div_show(element_type('sendmailOptions'));
        break;
        default :
          return;
        break;
      }
    }

    function optionsAuth(status) {
      switch (status) {
        case 'true' :
          div_show(element_type('authUsername'));
          div_show(element_type('authPassword'));
        break;
        case 'false' :
          div_hide(element_type('authUsername'));
          div_hide(element_type('authPassword'));
        break;
        default :
          return;
        break;
      }
    }
    </script>
    <h1>E-Mail Configuration</h1>
    <img src="images/record-next-on.gif" width="9" height="9" hspace="2" vspace="2" style="vertical-align: middle" alt="" title="" /> <a href="index.php?section=preferences">Preferences and Configuration</a>&nbsp;
    <img src="images/record-next-on.gif" width="9" height="9" hspace="2" vspace="2" style="vertical-align: middle" alt="" title="" /> E-Mail Configuration
    <br /><br />
    <?php echo (($ERROR) ? display_error($ERRORSTR) : ""); ?>
    <?php echo (($NOTICE) ? display_notice($NOTICESTR) : ""); ?>
    <?php echo (($SUCCESS) ? display_success($SUCCESSSTR) : ""); ?>
    <form action="index.php?section=preferences&type=email" method="post">
    <fieldset>
    <legend class="page-subheading">Message Options</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Character Wordwrap</em></strong><br />This is the maximum number of characters per line that will exist when you send out your message.<br /><br /><strong>Important:</strong><br />There are a lot of spam filters that will increase the spam score if lines are longer than 76 characters; therefore, it is suggested to not increase this number higher then 76.'));">Character Wordwrap:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 150px" name="preferences[<?= PREF_WORDWRAP ?>]" value="<?= $_SESSION["config"][PREF_WORDWRAP] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Auto-Add Unsubscribe Link</em></strong><br />Select whether or not you wish to have ListMessenger automatically add an unsubscribe link to every newsletter that you send out.'));">Auto-Add Unsubscribe Link:</span></td>
      <td>
        <select style="width: 154px" name="preferences[<?= PREF_ADD_UNSUB_LINK ?>]" onkeypress="return handleEnter(this, event)">
        <option value="yes"<?= (($_SESSION["config"][PREF_ADD_UNSUB_LINK] == "yes") ? " selected=\"selected\"" : "") ?>>Yes</option>
        <option value="no"<?= (($_SESSION["config"][PREF_ADD_UNSUB_LINK] == "no") ? " selected=\"selected\"" : "") ?>>No</option>
        </select>
      </td>
    </tr>
    </table>
    </fieldset>

    <br />
    <fieldset>
    <legend class="page-subheading">Sending Options</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Messages Per Refresh</em></strong><br />This is the number of messages that ListMessenger will send before it pauses and then refreshes. The default setting is 50 messages and this number should be increased or decreased based on the load of your server.<br /><br /><strong>Important:</strong><br />ListMessenger works by delivering X number of messages, then pausing X number of seconds. This process is called a cycle and is used to help you prevent your mail server from being overwhelmed and to prevent PHP timeouts.'));">Messages Per Refresh:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 50px" name="preferences[<?= PREF_MSG_PER_REFRESH ?>]" value="<?= $_SESSION["config"][PREF_MSG_PER_REFRESH] ?>" onkeypress="return handleEnter(this, event)" /></td>
    </tr>
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Pause Between Refreshes</em></strong><br />This is the number of seconds that ListMessenger will pause between refreshes. The default setting is 1 second; however, you are free to increase or decrease this based on the load of your server.<br /><br /><strong>Important:</strong><br />ListMessenger has the ability to pause between refreshes to allow you to prevent your mail server from being overwhelmed and to prevent PHP timeouts.'));">Pause Between Refreshes:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 50px" name="preferences[<?= PREF_PAUSE_BETWEEN ?>]" value="<?= $_SESSION["config"][PREF_PAUSE_BETWEEN] ?>" onkeypress="return handleEnter(this, event)" /> <span class="small-grey">second(s)</span></td>
    </tr>
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Queue Timeout</em></strong><br />This is the number of seconds that ListMessenger will consider your sending queue still active. After this number, ListMessenger will assume that your sending process has stalled at it will allow you to resume the stalled send.<br /><br /><strong>Important:</strong><br />This number <em>must</em> be higher than your &quot;Pause Between Refreshes&quot; number or ListMessenger will consider your active sending queue stalled when it is not.'));">Queue Timeout:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 50px" name="preferences[<?= PREF_QUEUE_TIMEOUT ?>]" value="<?= $_SESSION["config"][PREF_QUEUE_TIMEOUT] ?>" onkeypress="return handleEnter(this, event)" /> <span class="small-grey">second(s)</span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Message Delivery Method</em></strong><br />ListMessenger provides you with the option of choosing what method you use to deliver your messages to your subscribers.'));">Message Delivery Method:</span></td>
      <td>
        <select style="width: 154px" name="preferences[<?= PREF_MAILER_BY_ID ?>]" onchange="optionsDisplay(this.form['preferences[<?= PREF_MAILER_BY_ID ?>]'].value)" onkeypress="return handleEnter(this, event)">
        <option value="mail"<?= (($_SESSION["config"][PREF_MAILER_BY_ID] == "mail") ? " selected=\"selected\"" : "") ?>>PHP mail()</option>
        <option value="smtp"<?= (($_SESSION["config"][PREF_MAILER_BY_ID] == "smtp") ? " selected=\"selected\"" : "") ?>>SMTP Server</option>
        <option value="sendmail"<?= (($_SESSION["config"][PREF_MAILER_BY_ID] == "sendmail") ? " selected=\"selected\"" : "") ?>>Sendmail</option>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan="2" style="padding: 10px">
        <div id="smtpOptions" style="display: none">
          <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
          <colgroup>
            <col style="width: 40%" />
            <col style="width: 60%" />
          </colgroup>
          <tbody>
            <tr>
              <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>SMTP Server Address</em></strong><br />Please specify the SMTP server, or servers that you wish to send mail through. You can specify more than one mail server by seperating them with a semi-colon.<br /><br />You can also specify an SMTP server port by following your server name with a colon and the port number:<br />e.g. mail.domain.com:25'));">SMTP Server Address:</span></td>
              <td><input type="text" class="text-box" style="width: 100%" id="smtp_servers" name="smtp_servers" value="<?php echo (($_SESSION["config"][PREF_MAILER_BY_ID] == "smtp") ? html_encode($_SESSION["config"][PREF_MAILER_BY_VALUE]) : ""); ?>" onkeypress="return handleEnter(this, event)" /></td>
            </tr>
            <tr>
              <td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>SMTP Keep Alive</em></strong><br />If you would like ListMessenger to connect then disconnect to your SMTP server for every e-mail that is sent you can disable SMTP Keep Alive here.<br /><br />Please be advised that disabling this setting is not recommended unless you have a specific reason for doing so.'));">SMTP Keep Alive:</span></td>
              <td>
                <select style="width: 154px" id="preferences[<?php echo PREF_MAILER_SMTP_KALIVE; ?>]" name="smtp_keep_alive" onkeypress="return handleEnter(this, event)">
                <option value="yes"<?php echo (($_SESSION["config"][PREF_MAILER_SMTP_KALIVE] == "yes") ? " selected=\"selected\"" : ""); ?>>Enabled</option>
                <option value="no"<?php echo (($_SESSION["config"][PREF_MAILER_SMTP_KALIVE] == "no") ? " selected=\"selected\"" : ""); ?>>Disabled</option>
                </select>
              </td>
            </tr>
            <tr>
              <td class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>SMTP Authentication Enabled</em></strong><br />Chances are you will be required to authenticate as a user on the remote mail server. If you are required to do this, set this value to yes.'));">SMTP Authentication Enabled:</span></td>
              <td>
                <select style="width: 154px" id="preferences[<?php echo PREF_MAILER_AUTH_ID; ?>]" name="smtp_authentication" onchange="optionsAuth(this.form['preferences[<?= PREF_MAILER_AUTH_ID ?>]'].value)" onkeypress="return handleEnter(this, event)">
                <option value="true"<?php echo (($_SESSION["config"][PREF_MAILER_AUTH_ID] == "true") ? " selected=\"selected\"" : ""); ?>>Yes</option>
                <option value="false"<?php echo (($_SESSION["config"][PREF_MAILER_AUTH_ID] == "false") ? " selected=\"selected\"" : ""); ?>>No</option>
                </select>
              </td>
            </tr>
            <tr id="authUsername" style="display: none">
              <td style="width: 40%" class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>SMTP Username</em></strong><br />This is the username that ListMessenger will use to authenticate you at the SMTP server you provided.'));">SMTP Username:</span></td>
              <td style="width: 60%"><input type="text" class="text-box" style="width: 150px" name="auth_username" value="<?php echo $_SESSION["config"][PREF_MAILER_AUTHUSER_ID]; ?>" onkeypress="return handleEnter(this, event)" /></td>
            </tr>
            <tr id="authPassword" style="display: none">
              <td style="width: 40%" class="form-row-nreq"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>SMTP Password</em></strong><br />This is the password that ListMessenger will use to authenticate you at the SMTP server you provided.'));">SMTP Password:</span></td>
              <td style="width: 60%"><input type="password" class="text-box" style="width: 150px" name="auth_password" value="<?= $_SESSION["config"][PREF_MAILER_AUTHPASS_ID] ?>" onkeypress="return handleEnter(this, event)" /></td>
            </tr>
          </tbody>
          </table>
        </div>
        <div id="sendmailOptions" style="display: none">
          <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
          <tr>
            <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>Path to Sendmail</em></strong><br />Please specify the full path to your Sendmail executable as well as any switches you would like ListMessenger to pass to sendmail.<br /><br /><strong>Example:</strong><br />/usr/sbin/sendmail'));">Path to Sendmail:</span></td>
            <td style="width: 60%"><input type="text" class="text-box" style="width: 100%" id="sendmail_path" name="sendmail_path" value="<?= (($_SESSION["config"][PREF_MAILER_BY_ID] == "sendmail") ? $_SESSION["config"][PREF_MAILER_BY_VALUE] : "") ?>" onkeypress="return handleEnter(this, event)" /></td>
          </tr>
          </table>
        </div>
      </td>
    </tr>
    </table>
    </fieldset>

    <br />
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
        <input type="button" class="button" value="Close" onclick="window.location='index.php?section=preferences'" />&nbsp;
        <input type="submit" name="save" class="button" value="Save" />
      </td>
    </tr>
    </table>
    </form>
    <?php
    $ONLOAD[] = "optionsDisplay('".$_SESSION["config"][PREF_MAILER_BY_ID]."')";
    if($_SESSION["config"][PREF_MAILER_BY_ID] == "smtp") {
      $ONLOAD[] = "optionsAuth('".$_SESSION["config"][PREF_MAILER_AUTH_ID]."')";
    }
  break;
  default:
    ?>
    <h1>Preferences and Configuration</h1>
    <table style="width: 100%" cellspacing="3" cellpadding="1" border="0">
    <tr>
      <td style="text-align: center; vertical-align: top"><a href="index.php?section=preferences&type=program"><img src="images/icon-preferences-sm.gif" width="36" height="36" alt="Program Preferences Icon" title="ListMessenger Program Preferences" border="0"></a></td>
      <td>
        <img src="images/record-next-on.gif" width="9" height="9" hspace="2" vspace="2" style="vertical-align: middle" alt="" title="" /><a href="index.php?section=preferences&type=program" class="preferences-title">Program Preferences</a><br />
        These are the main program preferences that allow you set things like the username and password, as well as directory paths and date formats.
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>

    <tr>
      <td style="text-align: center; vertical-align: top"><a href="index.php?section=preferences&type=enduser"><img src="images/icon-preferences-sm.gif" width="36" height="36" alt="End-User Preferences Icon" title="ListMessenger End-User Preferences" border="0"></a></td>
      <td>
        <img src="images/record-next-on.gif" width="9" height="9" hspace="2" vspace="2" style="vertical-align: middle" alt="" title="" /><a href="index.php?section=preferences&type=enduser" class="preferences-title">End-User Preferences</a><br />
        The end-user preferences allow you to modify settings directed towards your subscribers experience; such as, default display language, banned domain and e-mail addresses, etc.
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>

    <tr>
      <td style="text-align: center; vertical-align: top"><a href="index.php?section=preferences&type=email"><img src="images/icon-preferences-sm.gif" width="36" height="36" alt="E-Mail Configuration Icon" title="ListMessenger E-Mail Configuration" border="0"></a></td>
      <td>
        <img src="images/record-next-on.gif" width="9" height="9" hspace="2" vspace="2" style="vertical-align: middle" alt="" title="" /><a href="index.php?section=preferences&type=email" class="preferences-title">E-Mail Configuration</a><br />
        The e-mail configuration settings allow you to change how ListMessenger delivers e-mail to your subscribers. You can the delivery method, messages per refersh, pause between refreshes, etc.
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    </table>
    <?php
  break;
}
?>