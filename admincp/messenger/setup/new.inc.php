<?php
/*
  ListMessenger - Professional Mailing List Management
  Copyright © 2007 Silentweb [http://www.silentweb.ca]

  Developed By: Matt Simpson <msimpson@listmessenger.com>

  For the most recent version, visit the ListMessenger website:
  [http://www.listmessenger.com]

  License Information is found in docs/licence.html
  $Id: new.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

if(!defined("IN_SETUP"))    exit;

$PAGE  = trim($_GET["p"]);

switch($PAGE) {
  case "3" :
    if(!isset($_GET["refresh"])) {
      if(trim($_POST["npassword1"]) != "") {
        if(trim($_POST["npassword2"]) != "") {
          if(trim($_POST["npassword1"]) == trim($_POST["npassword2"])) {
            if(strlen(trim($_POST["npassword1"])) >= 5) {
              $_POST["preferences"][PREF_ADMPASS_ID] = trim($_POST["npassword1"]);
            } else {
              $ERROR++;
              $ERRORSTR[]  = "Your password must be at least five (5) characters long in order to be used. Please re-enter your password.";
            }
          } else {
            $ERROR++;
            $ERRORSTR[] = "The passwords that you've entered do not match. Please re-enter your password.";
          }
        } else {
          $ERROR++;
          $ERRORSTR[] = "Please be sure you re-enter your password in the &quot;Retype Password:&quot; text box.";
        }
      } else {
        $ERROR++;
        $ERRORSTR[] = "You did not enter your ListMessenger Password. Please enter a password that you will use to log into ListMessenger.";
      }
      if(!$ERROR) {
        if((@is_array($_POST["preferences"])) && (@count($_POST["preferences"]) > 0)) {
          foreach($_POST["preferences"] as $preference_id => $preference_value) {
            switch($preference_id) {
              case PREF_ADMUSER_ID :
                if(strlen(trim($preference_value)) < 5) {
                  $ERROR++;
                  $ERRORSTR[] = "Please ensure that the ListMessenger username is longer than five (5) characters in length.";
                }
              break;
              case PREF_ADMPASS_ID :
                // Already checked above.
              break;
              case PREF_FRMNAME_ID :
                if(strlen(trim($preference_value)) < 1) {
                  $ERROR++;
                  $ERRORSTR[] = "Please ensure that you enter the From Name into setup. If you are unsure of what this is, try clicking the field title to display a tooltip!";
                }
              break;
              case PREF_FRMEMAL_ID :
                if(!valid_address($preference_value)) {
                  $ERROR++;
                  $ERRORSTR[] = "Please ensure that the From E-Mail Address is a valid e-mail address. If you are unsure of what this is, try clicking the field title to display a tooltip!";
                }
              break;
              case PREF_PROPATH_ID :
                if(strlen(trim($preference_value)) < 1) {
                  $ERROR++;
                  $ERRORSTR[] = "Please ensure that you enter the ListMessenger Directory Path into setup. If you are unsure of what this is, try clicking the field title to display a tooltip!";
                } else {
                  if(!@is_dir($preference_value)) {
                    $ERROR++;
                    $ERRORSTR[] = "The ListMessenger Directory Path you have entered into setup does not seem to be valid or is not readable by PHP. Please ensure that this directory is accessible and readable by PHP. Maybe try chmodding the ListMessenger directory to 775. If you are unsure of what this is, try clicking the field title to display a tooltip!";
                  }
                }
              break;
              case PREF_PROGURL_ID :
                // Have no idea how to check for this in a completely compatible way. Maybe I'll wait until PHP 5 is standard.
              break;
              case REG_DOMAIN :
                // Doesn't need validating at this time.
              break;
              case REG_SERIAL :
                // Doesn't need validating at this time.
              break;
              case REG_NAME :
                // Doesn't need validating at this time.
              break;
              case REG_EMAIL :
                // Doesn't need validating at this time.
              break;
              default :
                $ERROR++;
                $ERRORSTR[] = "Unrecognized preference ID [".$preference_id."] with a value of [".$preference_value."] was passed to the installer.";
              break;
            }
          }
          if($ERROR) {
            $PAGE = 2;
          } else {
            /*
              This will be changed to ADOdb's XML schema.
            */
            if($LMDATABASE["new"] != "") {
              $search    = array();
              $replace  = array();
              $lmdb    = $LMDATABASE["new"];

              $_POST["preferences"][PREF_RPYEMAL_ID] = $_POST["preferences"][PREF_FRMEMAL_ID];
              $_POST["preferences"][PREF_ABUEMAL_ID] = $_POST["preferences"][PREF_FRMEMAL_ID];
              $_POST["preferences"][PREF_ERREMAL_ID] = $_POST["preferences"][PREF_FRMEMAL_ID];
              $_POST["preferences"][PREF_NOTEMAL_ID] = $_POST["preferences"][PREF_FRMEMAL_ID];

              foreach($_POST["preferences"] as $preference_id => $preference_value) {
                $id        = @count($search);
                $search[$id]  = "%preferences[".$preference_id."]%";
                $replace[$id]  = checkslashes(trim($preference_value));
              }

              $id        = @count($search);
              $search[$id]  = "%TABLES_PREFIX%";
              $replace[$id]  = TABLES_PREFIX;

              $lmdb    = str_replace($search, $replace, $lmdb);
              $lmdb    = str_replace("\r", "\n", $lmdb);
              $lmdb    = trim(str_replace("\n\n", "\n", $lmdb));
              $queries  = explode("\n", $lmdb);

              foreach($queries as $query) {
                if($query != "") {
                  if(!$db->Execute(trim($query))) {
                    $ERROR++;
                    $ERRORSTR[]  = "Unable to execute query. Database server said: ".$db->ErrorMsg();
                    $PAGE    = 2;
                  }
                }
              }
              if(@function_exists("fsockopen")) {
                if(!$ERROR) {
                  require_once("./includes/classes/talkback/class.talkback.php");

                  $talk        = array();
                  $talk["full_name"]    = $_POST["preferences"][REG_NAME];
                  $talk["email_address"]  = $_POST["preferences"][REG_EMAIL];
                  $talk["domain_name"]  = $_POST["preferences"][REG_DOMAIN];
                  $talk["age"]      = $_POST["age"];
                  $talk["serial_number"]  = $_POST["preferences"][REG_SERIAL];
                  $talk["version_number"]  = VERSION_INFO;
                  $talk["version_type"]  = VERSION_TYPE;
                  $talk["server_admin"]  = $_SERVER["SERVER_ADMIN"];
                  $talk["server_ip"]    = $_SERVER["SERVER_ADDR"];
                  $talk["server_host"]  = $_SERVER["HTTP_HOST"];
                  $talk["remote_ip"]    = $_SERVER["REMOTE_ADDR"];
                  if($_POST["environment_status"] == "true") {
                    $talk["php_version"]  = phpversion();
                    $talk["php_safemode"]  = @ini_get("safe_mode");
                    $talk["php_globals"]  = @ini_get("register_globals");
                    $talk["php_maxexec"]  = @ini_get("max_execution_time");
                    $talk["server_soft"]  = $_SERVER["SERVER_SOFTWARE"];
                    $talk["client_browser"]  = $_SERVER["HTTP_USER_AGENT"];
                  }
                  $talking  = new TalkBack("registration", $talk);
                  $result  = @$talking->post();
                  switch($result) {
                    case "0" :
                      $SUCCESS++;
                      $SUCCESSSTR[] = "You have successfully registered your installation of ListMessenger with our registration server. Thank-you very much and we hope you enjoy our product!";
                    break;
                    case "666" :
                      // Successfull Registration
                      $SUCCESS++;
                      $SUCCESSSTR[] = "You have successfully registered your installation of ListMessenger with our registration server. Thank-you very much and we hope you enjoy our product!";
                    break;
                    case "2" :
                      $NOTICE++;
                      $NOTICESTR[] = "Thank-you for re-submitting your registration information; we have successfully received it.\n";
                    break;
                    case "52316" :
                      $query = "DROP TABLE `".TABLES_PREFIX."cdata`, `".TABLES_PREFIX."cfields`, `".TABLES_PREFIX."confirmation`, `".TABLES_PREFIX."groups`, `".TABLES_PREFIX."messages`, `".TABLES_PREFIX."preferences`, `".TABLES_PREFIX."queue`, `".TABLES_PREFIX."sending`, `".TABLES_PREFIX."templates`, `".TABLES_PREFIX."users`;";
                      $db->Execute($query);

                      $ERROR++;
                      $ERRORSTR[]  = "Please remove this attempted installation of ListMessenger from this system immediately, as some data provided to us has been black-listed by our administrators. This issue may stem from previous ListMessenger abuse, compalints or a licence infringement.<br /><br />If you believe you have received this message in error, we sincerely apologize for the inconvenience and would happy to discuss the matter with you; please contact <a>talkback@listmessenger.com</a> for more information.";
                      $PAGE    = 2;
                    break;
                  }
                }
              } else {
                $NOTICE++;
                $NOTICESTR[] = "ListMessenger was unable to register with the registration server because your hosting provider or server administrator has disabled PHP's fsockopen() function.<br /><br />ListMessenger will function normally either way, but we will give you a shiny gold star if you would be so kind as to e-mail it to us: <a>talkback@listmessenger.com</a>.\n";
              }

            } else {
              $ERROR++;
              $ERRORSTR[]  = "It appears as though the ListMessenger database embedded into this file is corrupt or non-existent. Please try unpacking the ListMessenger distribution again.";
              $PAGE    = 2;
            }
          }
        } else {
          $ERROR++;
          $ERRORSTR[]  = "Your preferences do not appear to have been submitted using a http post. Please restart setup and ensure you follow the page by page instructions.";
          $PAGE    = 2;
        }
      } else {
        $PAGE = 2;
      }
    }
  break;
//  case "2" :
//    $c    = @file("./key.php");array_shift($c);array_shift($c);array_shift($c);array_shift($c);array_pop($c)//;array_pop($c);$i=array(trim($c[0]),trim($c[1]),trim($c[2]),trim($c[3]));array_shift($c);array_shift($c);//array_shift($c);array_shift($c);eval(base64_decode(str_replace("\n","",implode("",$c))));if(!function_exists(//"duco")){function duco($string,$key){return $string;}}
//    $AUTHCODE = trim($_POST["authcode"]);
//    $NAME  = ucwords(strtolower(trim(duco($i[0], $AUTHCODE))));
//    $EMAIL  = strtolower(trim(duco($i[2], $AUTHCODE)));
//    $DOMAIN  = strtolower(trim(duco($i[1], $AUTHCODE)));
//    if(valid_address($EMAIL)) {
//      if(($DOMAIN != strtolower($_SERVER["HTTP_HOST"])) && (!@stristr($DOMAIN, $_SERVER["HTTP_HOST"]) && (!@stristr($_SERVER["HTTP_HOST"], $DOMAIN)))//) {
//        $NOTICE++;
//        $NOTICESTR[] = "The domain name in your licence key [".$DOMAIN."] does not match the domain name that your web-server is reporting [".$///_SERVER["HTTP_HOST"]."]. This can be caused by a misconfigured web-server or a mistake in the domain name when you assigned your ListMessenger Licence //Key (i.e. http://www.domain.com instead of domain.com). Please be aware that ListMessenger Pro is licenced on per-domain basis.";
//      }
//    } else {
//      $ERROR++;
//      $ERRORSTR[]  = "The e-mail address [".$EMAIL."] in your licence key does not appear to be valid. This is likely caused because the //authentication code that you have entered was not correct. Please re-enter your authentication code making sure that it is entered exactly how it //appears in your licence key e-mail.";
 //     $PAGE    = 1;
//    }
//  break;
  case "1" :
  default :
    // No error checking required.
  break;
}


switch($PAGE) {
  case "3" :
    $PASSED = true;
    ?>
    <?php echo (($ERROR) ? display_error($ERRORSTR) : ""); ?>
    <?php echo (($NOTICE) ? display_notice($NOTICESTR) : ""); ?>
    <?php echo (($SUCCESS) ? display_success($SUCCESSSTR) : ""); ?>
    <h2>Installation Successfull</h2>
    You have successfully installed ListMessenger <?php echo VERSION_TYPE." ".VERSION_INFO ?> on your website. One final step is setting up a few directory permissions so as ListMessenger is able to read and write some important data such as backups, restores, imports, exports, etc.
    <br /><br />
    Please ensure the following directories are writable by PHP. In a Unix or Linux environment, you can <tt>chmod 777</tt> the following 5 directories.
    <h2>Directory Permissions:</h2>
    <table style="width: 100%; margin-top: 5px" cellspacing="0" cellpadding="1" border="0">
    <?php
    if(!@is_writable($LMDIRECTORY."private/backups/")) {
      $PASSED  = false;
      echo "<tr>\n";
      echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger Directory: private/backups not writable.\" title=\"ListMessenger Directory: private/backups not writable.\" /></td>\n";
      echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
      echo "    ListMessenger Directory: private/backups is <b style=\"color: #CC0000\">not writable</strong>.<br />\n";
      echo "    <span class=\"setup-error-text\" style=\"font-family: monospace; font-size: 10px\">".$LMDIRECTORY."private/backups/</span>";
      echo "    <br /><br />\n";
      echo "  </td>\n";
      echo "</tr>\n";
    } else {
      echo "<tr>\n";
      echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-checkmark.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger Directory: private/backups writable.\" title=\"ListMessenger Directory: private/backups writable.\" /></td>\n";
      echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">ListMessenger Directory: private/backups is <b style=\"color: #669900\">writable</strong>.</td>\n";
      echo "</tr>\n";
    }

    if(!@is_writable($LMDIRECTORY."private/logs/")) {
      $PASSED  = false;
      echo "<tr>\n";
      echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger Directory: private/logs not writable.\" title=\"ListMessenger Directory: private/logs not writable.\" /></td>\n";
      echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
      echo "    ListMessenger Directory: private/logs is <b style=\"color: #CC0000\">not writable</strong>.<br />\n";
      echo "    <span class=\"setup-error-text\" style=\"font-family: monospace; font-size: 10px\">".$LMDIRECTORY."private/logs/</span>";
      echo "    <br /><br />\n";
      echo "  </td>\n";
      echo "</tr>\n";
    } else {
      echo "<tr>\n";
      echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-checkmark.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger Directory: private/logs writable.\" title=\"ListMessenger Directory: private/logs writable.\" /></td>\n";
      echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">ListMessenger Directory: private/logs is <b style=\"color: #669900\">writable</strong>.</td>\n";
      echo "</tr>\n";
    }

    if(!@is_writable($LMDIRECTORY."private/tmp/")) {
      $PASSED  = false;
      echo "<tr>\n";
      echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger Directory: private/tmp not writable.\" title=\"ListMessenger Directory: private/tmp not writable.\" /></td>\n";
      echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
      echo "    ListMessenger Directory: private/tmp is <b style=\"color: #CC0000\">not writable</strong>.<br />\n";
      echo "    <span class=\"setup-error-text\" style=\"font-family: monospace; font-size: 10px\">".$LMDIRECTORY."private/tmp/</span>";
      echo "    <br /><br />\n";
      echo "  </td>\n";
      echo "</tr>\n";
    } else {
      echo "<tr>\n";
      echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-checkmark.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger Directory: private/tmp writable.\" title=\"ListMessenger Directory: private/tmp writable.\" /></td>\n";
      echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">ListMessenger Directory: private/tmp is <b style=\"color: #669900\">writable</strong>.</td>\n";
      echo "</tr>\n";
    }

    if(!@is_writable($LMDIRECTORY."public/files/")) {
      $PASSED  = false;
      echo "<tr>\n";
      echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger Directory: public/files not writable.\" title=\"ListMessenger Directory: public/files not writable.\" /></td>\n";
      echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
      echo "    ListMessenger Directory: public/files is <b style=\"color: #CC0000\">not writable</strong>.<br />\n";
      echo "    <span class=\"setup-error-text\" style=\"font-family: monospace; font-size: 10px\">".$LMDIRECTORY."public/files/</span>";
      echo "    <br /><br />\n";
      echo "  </td>\n";
      echo "</tr>\n";
    } else {
      echo "<tr>\n";
      echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-checkmark.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger Directory: public/files writable.\" title=\"ListMessenger Directory: public/files writable.\" /></td>\n";
      echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">ListMessenger Directory: public/files is <b style=\"color: #669900\">writable</strong>.</td>\n";
      echo "</tr>\n";
    }

    if(!@is_writable($LMDIRECTORY."public/images/")) {
      $PASSED  = false;
      echo "<tr>\n";
      echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger Directory: public/images not writable.\" title=\"ListMessenger Directory: public/images not writable.\" /></td>\n";
      echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
      echo "    ListMessenger Directory: public/images is <b style=\"color: #CC0000\">not writable</strong>.<br />\n";
      echo "    <span class=\"setup-error-text\" style=\"font-family: monospace; font-size: 10px\">".$LMDIRECTORY."public/images/</span>";
      echo "    <br /><br />\n";
      echo "  </td>\n";
      echo "</tr>\n";
    } else {
      echo "<tr>\n";
      echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-checkmark.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger Directory: public/images writable.\" title=\"ListMessenger Directory: public/images writable.\" /></td>\n";
      echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">ListMessenger Directory: public/images is <b style=\"color: #669900\">writable</strong>.</td>\n";
      echo "</tr>\n";
    }
    ?>
    </table>

    <form action="./setup.php?step=3&type=new&p=3&refresh" method="GET">
    <table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td colspan="2" style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
        <?php
        if($PASSED) {
          echo "<input type=\"button\" value=\"Completed\" class=\"button\" onclick=\"window.location='./index.php'\" />\n";
        } else {
          echo "<input type=\"button\" value=\"Refresh\" class=\"button\" onclick=\"window.location='./setup.php?step=3&type=new&p=3&refresh'\" />\n";
          echo "<input type=\"button\" value=\"Skip\" class=\"button\" onclick=\"window.location='./index.php'\" />\n";
        }
        ?>
      </td>
    </tr>
    </table>
    </form>
    <?php
  break;
  case "2" :
    ?>
    <?php echo (($ERROR) ? display_error($ERRORSTR) : ""); ?>
    <?php echo (($NOTICE) ? display_notice($NOTICESTR) : ""); ?>
    <?php echo (($SUCCESS) ? display_success($SUCCESSSTR) : ""); ?>
    <h2>Preferences and Registration</h2>
    The following basic preferences are required to be set during the installation. The default name and e-mail address were retrieved from your licence key, and you are free to change any of these preferences later by logging into ListMessenger and clicking Control Panel, Preferences, Program Preferences.

    <div class="small-grey" style="text-align: right; margin-top: 5px; margin-bottom: 5px"><strong>Tip!</strong> Clicking the field title may give you help if you get stuck.</div>
    <form action="setup.php?step=3&type=new&p=3" method="post">
    <input type="hidden" name="preferences[<?php echo REG_SERIAL; ?>]" value="<?php echo html_encode($AUTHCODE); ?>" />
    <input type="hidden" name="preferences[<?php echo REG_DOMAIN; ?>]" value="<?php echo html_encode($DOMAIN); ?>" />
    <input type="hidden" name="preferences[<?php echo REG_NAME; ?>]" value="<?php echo html_encode($NAME); ?>" />
    <input type="hidden" name="preferences[<?php echo REG_EMAIL; ?>]" value="<?php echo html_encode($EMAIL); ?>" />
    <fieldset>
    <legend class="page-subheading">Login Information</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>ListMessenger Username</em></strong><br />This username is what you will enter on the ListMessenger login page to access the ListMessenger interface.<br /><br /><strong>Important:</strong><br />If you forget this username, it can be retrieved using PHPMyAdmin or any other database management application and look in the preferences table.'));">ListMessenger Username:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 150px" name="preferences[<?php echo PREF_ADMUSER_ID; ?>]" value="<?php echo (($_POST) ? checkslashes(trim($_POST["preferences"][PREF_ADMUSER_ID]), 1) : ""); ?>" autocomplete="off" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>ListMessenger Password</em></strong><br />This is the password that you will use to log into the ListMessenger interface.<br /><br /><strong>Important:</strong><br />If you forget this password, it can be retrieved using PHPMyAdmin or any other database management application and look in the preferences table.'));">ListMessenger Password:</span></td>
      <td><input type="password" class="text-box" style="width: 150px" name="npassword1" value="" autocomplete="off" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>ListMessenger Password</em></strong><br />This is the password that you will use to log into the ListMessenger interface.<br /><br /><strong>Important:</strong><br />If you forget this password, it can be retrieved using PHPMyAdmin or any other database management application and look in the preferences table.'));">Retype Password:</span></td>
      <td><input type="password" class="text-box" style="width: 150px" name="npassword2" value="" autocomplete="off" /></td>
    </tr>
    </table>
    </fieldset>

    <br />
    <fieldset>
    <legend class="page-subheading">Contact Information</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>From Name</em></strong><br />This is the default name that will show up in from and reply field of any e-mail client when a subscriber receives a newsletter. This would generally be your full name, company name or website title.'));">From Name:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 60%" name="preferences[<?php echo PREF_FRMNAME_ID; ?>]" value="<?php echo (($ERROR) ? checkslashes(trim($_POST["preferences"][PREF_FRMNAME_ID]), 1) : $NAME); ?>" autocomplete="off" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>From E-Mail Address</em></strong><br />This is the default e-mail address that will show up in the from field of any e-mail client when a subscriber receives a newsletter.'));">From E-Mail Address:</span></td>
      <td><input type="text" class="text-box" style="width: 60%" name="preferences[<?php echo PREF_FRMEMAL_ID; ?>]" value="<?php echo (($ERROR) ? checkslashes(trim($_POST["preferences"][PREF_FRMEMAL_ID]), 1) : $EMAIL); ?>" autocomplete="off" /></td>
    </tr>
    </table>
    </fieldset>

    <br />
    <fieldset>
    <legend class="page-subheading">Directory Paths and URLs</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>ListMessenger Directory Path</em></strong><br />This is the full directory path from root to your ListMessenger program directory. This field is <strong>not</strong> a URL, but <strong>is</strong> a directory path.<br /><br /><strong>Example:</strong><br />/home/domain.com/listmessenger/ or D:/domain.com/listmessenger/.<br /><br /><strong>Important:</strong><br />Windows users, please ensure you use forward slashes [/] to input your directory, <strong>not</strong> back slashes [\&#92;].'));">ListMessenger Directory Path:</span></td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 100%" name="preferences[<?php echo PREF_PROPATH_ID; ?>]" value="<?php echo (($ERROR) ? checkslashes(trim($_POST["preferences"][PREF_PROPATH_ID]), 1) : $LMDIRECTORY); ?>" autocomplete="off" /></td>
    </tr>
    <tr>
      <td class="form-row-req"><span class="cursor-help" onclick="return makeTrue(domTT_activate(this, event, 'caption', 'Help Information', 'content', '<strong><em>ListMessenger Program URL</em></strong><br />This is the full URL address to your ListMessenger directory on your web-server.<br /><br /><strong>Example:</strong><br />http://domain.com/listmessenger/'));">ListMessenger Program URL:</span></td>
      <td><input type="text" class="text-box" style="width: 100%" name="preferences[<?php echo PREF_PROGURL_ID; ?>]" value="<?php echo (($ERROR) ? checkslashes(trim($_POST["preferences"][PREF_PROGURL_ID]), 1) : (($_SERVER["HTTPS"] == "On") ? "https://" : "http://").$_SERVER["HTTP_HOST"].str_replace("setup.php", "", $_SERVER["PHP_SELF"])); ?>" autocomplete="off" /></td>
    </tr>
    </table>
    </fieldset>

    <br />
    <fieldset>
    <legend class="page-subheading">ListMessenger Registration</legend>
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="width: 40%" class="form-row-nreq">Registered Name:</td>
      <td style="width: 60%"><?php echo html_encode($NAME); ?></td>
    </tr>
    <tr>
      <td style="width: 40%" class="form-row-req">Enter Age:</td>
      <td style="width: 60%"><input type="text" class="text-box" style="width: 150px" name="age" value="<?php echo (($ERROR) ? checkslashes(trim($_POST["age"]), 1) : ""); ?>" autocomplete="off" /></td>
    </tr>
    <tr>
      <td style="width: 40%" class="form-row-nreq">Registered E-Mail Address:</td>
      <td style="width: 60%"><?php echo html_encode($EMAIL); ?></td>
    </tr>
    <tr>
      <td style="width: 40%" class="form-row-nreq">Registered Domain:</td>
      <td style="width: 60%"><?php echo html_encode($DOMAIN); ?></td>
    </tr>
    <tr>
      <td style="width: 40%" class="form-row-nreq">Provide Environment Information</td>
      <td style="width: 60%"><input type="checkbox" readonly name="environment_status" value=""<?php echo (($ERROR) ? (($_POST["environment_status"] == "true") ? " checked=\"checked\"" : "") : " checked=\"checked\""); ?> /></td>
    </tr>
    <tr>
      <td style="width: 100%; padding-left: 5px" class="small-grey" colspan="2">
         By having this box checked you will be sending the ListMessenger development team the following information: PHP version, PHP safe mode status, PHP register globals status, PHP max execution time, web server software and what browser you use. This information is used by our developers to see how our software is being deployed and rest assured it is not give to any third-parties.
      </td>
    </tr>
    </table>
    </fieldset>

    <br />
    <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
    <tr>
      <td style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
        <input type="submit" name="save" class="button" value="Proceed" />
      </td>
    </tr>
    </table>
    </form>
    <?php
  break;
  case "1" :
  default :
    ?>
    <?php echo (($ERROR) ? display_error($ERRORSTR) : ""); ?>
    <h2>Authentication Code</h2>
    Please enter your authentication code, which you received in your licence key e-mail to proceed.
    <br /><br />
    <form action="./setup.php?step=3&type=new&p=2" method="POST">
    <table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
      <td style="width: 25%" class="form-row-req">Authentication Code:</td>
      <td style="width: 75%"><input type="text" class="text-box" style="width: 250px" name="authcode" value="DGT" readonly autocomplete="off" /></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
        <input type="submit" value="Proceed" class="button" />
      </td>
    </tr>
    </table>
    </form>
    <?php
  break;
}
?>