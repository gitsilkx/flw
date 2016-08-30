<?php
/*
  ListMessenger - Professional Mailing List Management
  Copyright © 2007 Silentweb [http://www.silentweb.ca]

  Developed By: Matt Simpson <msimpson@listmessenger.com>

  For the most recent version, visit the ListMessenger website:
  [http://www.listmessenger.com]

  License Information is found in docs/licence.html
  $Id: index.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

// Setup PHP and start page setup.
  @ini_set("include_path", str_replace("\\", "/", dirname(__FILE__))."/includes");
  @ini_set("allow_url_fopen", 1);
  @ini_set("session.name", "LMSID");
  @ini_set("session.use_trans_sid", 0);
  @ini_set("session.cookie_lifetime", 0);
  @ini_set("session.cookie_secure", 0);
  @ini_set("session.referer_check", "");
  @ini_set("error_reporting",  E_ALL ^ E_NOTICE);
  @ini_set("magic_quotes_runtime", 0);

  $HEAD    = array();
  $ONLOAD    = array();
  $SIDEBAR  = array();

  $ERROR    = 0;
  $ERRORSTR  = array();
  $NOTICE    = 0;
  $NOTICESTR  = array();
  $SUCCESS  = 0;
  $SUCCESSSTR  = array();

  $RTE_ENABLED = false;
  $TRIP    = true;
  $SECTION  = "login";

  require_once("pref_ids.inc.php");
  require_once("config.inc.php");
  require_once("classes/adodb/adodb.inc.php");
  require_once("dbconnection.inc.php");

  session_start();

  require_once("functions.inc.php");
  require_once("loader.inc.php");

  ob_start("on_complete");

// Minor version upgrade.
  switch($_SESSION["config"][PREF_VERSION]) {
    case "2.0.0" :
      minor_version_upgrade("2.0.0");
    break;
    case "2.0.1" :
    case "2.0.2" :
      minor_version_upgrade("2.0.1");
    break;
  }

// Login
  if((isset($_POST["action"])) && ($_POST["action"] == "login")) {
    if((checkslashes($_POST["username"]) == $_SESSION["config"][PREF_ADMUSER_ID]) && (checkslashes($_POST["password"]) == $_SESSION["config"][PREF_ADMPASS_ID])) {
      /**
       * Added security feature for PHP 4.3.6+ users.
       */
      if(version_compare(phpversion(), "4.3.6", ">")) {
        if((PREF_DATABASE_SESSIONS == "yes") && (function_exists("adodb_session_regenerate_id"))) {
          adodb_session_regenerate_id();
        } elseif(function_exists("session_regenerate_id")) {
          session_regenerate_id();
        }
      }

      $_SESSION["isAuthenticated"] = true;

      header("Location: index.php");
      exit;
    } else {
      $ERROR++;
      $ERRORSTR[] = "Your username or password are invalid. Please re-enter your username and password.";
    }
// Logout
  } elseif((isset($_GET["action"])) && ($_GET["action"] == "logout")) {
    if(PREF_DATABASE_SESSIONS == "yes") {
      @ADOdb_Session::gc(1);
    }

    $_SESSION["isAuthenticated"] = false;
    $_SESSION = array();
    session_unset();
    session_destroy();
// Reload Preferences
  } elseif((isset($_GET["action"])) && ($_GET["action"] == "reload")) {
    reload_configuration();
  }

  if((!isset($_SESSION["isAuthenticated"])) || (!(bool) $_SESSION["isAuthenticated"])) {
    $SECTION = "login";
  } else {
    if((isset($_GET["section"])) && (trim($_GET["section"]) != "")) {
      $SECTION = str_replace(array(" ", "..", "/", "\\"), "", trim($_GET["section"]));
    } else {
      $SECTION = "subscribers";
    }
  }
  ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo (($_SESSION["config"][PREF_DEFAULT_CHARSET] != "") ? $_SESSION["config"][PREF_DEFAULT_CHARSET] : $CHARACTER_SETS[0]); ?>" />
    <title>ListMessenger <?php echo VERSION_TYPE.(((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) ? " ".VERSION_INFO : ""); ?></title>

    <link rel="stylesheet" type="text/css" media="all" href="./css/common.css" title="ListMessenger Style" />

    <style type="text/css">
      @import url('./css/domtt.css');
    </style>

    <script type="text/javascript" src="./javascript/common.js"></script>
    <script type="text/javascript" src="./javascript/domtt/domlib.js"></script>
    <script type="text/javascript" src="./javascript/domtt/domtt.js"></script>

    <link rel="shortcut icon" href="./images/listmessenger.ico" />

    <meta name="MSSmartTagsPreventParsing" content="true" />
    <meta http-equiv="imagetoolbar" content="no" />

    %HEAD%
  </head>
  <body>
  <div align="center">
    <div id="shadow-container" style="width: 85%; min-width: 762px">
          <div class="shadow1">
              <div class="shadow2">
                  <div class="shadow3">
                      <div class="container">
              <table class="listmessenger-window" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td>
                  <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
                  <tr>
                  <?php if((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) : ?>
                    <td style="width: 18%; height: 20px; background-color: <?php echo (($SECTION == "subscribers") ? "#EEEEEE" : "#CCCCCC"); ?>; text-align: center; border-bottom: 1px #848284 solid; border-right: 1px #848284 solid" class="cursor" onmouseout="this.style.backgroundColor='<?php echo (($SECTION == "subscribers") ? "#EEEEEE" : "#CCCCCC"); ?>'" onmouseover="this.style.backgroundColor='#EEEEEE'" onclick="window.location='index.php'">Subscribers</td>
                    <td style="width: 18%; height: 20px; background-color: <?php echo (($SECTION == "compose") ? "#EEEEEE" : "#CCCCCC"); ?>; text-align: center; border-bottom: 1px #848284 solid; border-right: 1px #848284 solid" class="cursor" onmouseout="this.style.backgroundColor='<?php echo (($SECTION == "compose") ? "#EEEEEE" : "#CCCCCC"); ?>'" onmouseover="this.style.backgroundColor='#EEEEEE'" onclick="window.location='index.php?section=compose'">Compose Message</td>
                    <td style="width: 18%; height: 20px; background-color: <?php echo (($SECTION == "message") ? "#EEEEEE" : "#CCCCCC"); ?>; text-align: center; border-bottom: 1px #848284 solid; border-right: 1px #848284 solid" class="cursor" onmouseout="this.style.backgroundColor='<?php echo (($SECTION == "message") ? "#EEEEEE" : "#CCCCCC"); ?>'" onmouseover="this.style.backgroundColor='#EEEEEE'" onclick="window.location='index.php?section=message'">Message Centre</td>
                    <td style="width: 18%; height: 20px; background-color: <?php echo (($SECTION == "queue") ? "#EEEEEE" : "#CCCCCC"); ?>; text-align: center; border-bottom: 1px #848284 solid; border-right: 1px #848284 solid" class="cursor" onmouseout="this.style.backgroundColor='<?php echo (($SECTION == "queue") ? "#EEEEEE" : "#CCCCCC"); ?>'" onmouseover="this.style.backgroundColor='#EEEEEE'" onclick="window.location='index.php?section=queue'">Queue Manager</td>
                    <td style="width: 28%; height: 20px; background-color: #999999; text-align: center; cursor: help; border-bottom: 1px #848284 solid" onclick="openAbout('<?php echo session_id(); ?>')" colspan="2"><span class="titlea">List</span><span class="titleb">Messenger</span> <span class="titlea"><?php echo VERSION_INFO; ?></span></td>
                  <?php else : ?>
                    <td style="width: 72%; height: 20px; background-color: #CCCCCC; border-bottom: 1px #848284 solid; border-right: 1px #848284 solid">
                      <img src="./images/pixel.gif" width="500" height="20" alt="" title="" />
                    </td>
                    <td style="width: 28%; height: 20px; background-color: #999999; border-bottom: 1px #848284 solid; text-align: center">
                      <span class="titlea">List</span><span class="titleb">Messenger</span> <span class="titlea">Login</span>
                    </td>
                  <?php endif; ?>
                  </tr>
                  <?php if((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) : ?>
                  <tr>
                    <td style="width: 72%; height: 20px; padding-left: 8px; border-bottom: 1px #CCCCCC dotted; border-right: 1px #848284 solid; text-align: left" colspan="4">%USERCOUNT%</td>
                    <td style="width: 14%; height: 20px; background-color: <?php echo (($SECTION == "control") ? "#EEEEEE" : "#FFFFFF") ?>; text-align: center; border-bottom: 1px #848284 solid; border-right: 1px #848284 solid" class="cursor" onmouseout="this.style.backgroundColor='<?php echo (($SECTION == "control") ? "#EEEEEE" : "#FFFFFF") ?>'" onmouseover="this.style.backgroundColor='#EEEEEE'" onclick="window.location='index.php?section=control'">Control Panel</td>
                    <td style="width: 14%; height: 20px; text-align: center; border-bottom: 1px #848284 solid"><a href="index.php?action=logout" class="logout"><strong>Logout</strong></a></td>
                  </tr>
                  <?php endif; ?>
                  <tr>
                    <td style="width: 100%; height: <?php echo (((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) ? "512" : "530") ?>px; vertical-align: top" colspan="<?php echo (((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) ? "6" : "2") ?>">
                      <table style="width: 100%; height: <?php echo (((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) ? "512" : "530") ?>px" cellspacing="0" cellpadding="3" border="0">
                      <colgroup>
                        <?php if((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) : ?>
                        <col style="width: 18%" />
                        <col style="width: 82%" />
                        <?php else : ?>
                        <col style="width: 100%" />
                        <?php endif; ?>
                      </colgroup>
                      <tr>
                        <?php if((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) : ?>
                        <td style="vertical-align: top; padding: 5px">
                          <img src="./images/pixel.gif" width="125" height="1" alt="" title="" />
                          %SIDEBAR%
                        </td>
                        <?php endif; ?>
                        <td style="vertical-align: <?php echo (((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) ? "top" : "middle"); ?>; padding: 5px">
                          <img src="./images/pixel.gif" width="595" height="1" alt="" title="" />
                          <?php
                          define("PARENT_LOADED", true);

                          if(($SECTION) && (@file_exists($_SESSION["config"][PREF_PROPATH_ID]."section/".$SECTION.".inc.php"))) {
                            if((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) {
                              $setup_file  = false;
                              $setup_dir  = false;

                              if(@file_exists("./setup.php")) {
                                $setup_file = true;
                              }
                              if(@file_exists("./setup")) {
                                $setup_dir = true;
                              }

                              if(($setup_file) || ($setup_dir)) {
                                echo display_notice(array("Now that you have successfully setup ListMessenger, please delete the:<ol>".(($setup_file) ? "<li>setup.php <strong>file</strong></li>" : "").(($setup_dir) ? "<li>setup <strong>directory</strong></li>" : "")."</ol>from the ListMessenger application directory for application security."));
                              }
                            }
                            require_once($_SESSION["config"][PREF_PROPATH_ID]."section/".$SECTION.".inc.php");
                          } else {
                            if(@file_exists($_SESSION["config"][PREF_PROPATH_ID]."section/error.inc.php")) {
                              require_once($_SESSION["config"][PREF_PROPATH_ID]."section/error.inc.php");
                            } else {
                              /**
                               * This action will reload the preferences from the database
                               * which will hopefully resolve the stale session problems when
                               * directories have changed.
                               */
                              if((!isset($_GET["action"])) || ($_GET["action"] != "reload")) {
                                header("Location: index.php?action=reload");
                                exit;
                              }

                              $ERROR++;
                              $ERRORSTR[0]  = "The path which was provided to ListMessenger is currently not accessible and needs to be corrected prior to login.\n";
                              $ERRORSTR[0] .= "<br /><br />\n";
                              $ERRORSTR[0] .= "ListMessenger is trying to load files out of the following directory:<br />\n";
                              $ERRORSTR[0] .= "<em>".$_SESSION["config"][PREF_PROPATH_ID]."</em><br /><br />\n";
                              if(@file_exists(str_replace("\\", "/", dirname(__FILE__))."/index.php")) {
                                $ERRORSTR[0] .= "It looks as though your path might actually be:<br />\n";
                                $ERRORSTR[0] .= "<em>".str_replace("\\", "/", dirname(__FILE__))."/</em><br /><br />\n";
                              }
                              $ERRORSTR[0] .= "Please correct this problem in the ".TABLES_PREFIX."preferences database table and try again.<br /><br />\n";
                              $ERRORSTR[0] .= "If you require assistance, please consult the <a href=\"http://anonym.to/?http://www.listmessenger.com/index.php/faq\" target=\"_blank\">Frequently Asked Questions</a>.";
                              echo "<blockquote>\n";
                              echo display_error($ERRORSTR);
                              echo "</blockquote>\n";
                            }
                          }
                          ?>
                          <br />
                        </td>
                      </tr>
                      </table>
                    </td>
                  </tr>
                  </table>
                </td>
              </tr>
              </table>
            </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  </body>
  </html>
  <?php
  ob_end_flush();
?>