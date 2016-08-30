<?php
/*
  ListMessenger - Professional Mailing List Management
  Copyright © 2007 Silentweb [http://www.silentweb.ca]

  Developed By: Matt Simpson <msimpson@listmessenger.com>

  For the most recent version, visit the ListMessenger website:
  [http://www.listmessenger.com]

  License Information is found in docs/licence.html
  $Id: setup.php 107 2007-03-25 19:49:18Z matt.simpson $
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

  @set_time_limit(0);

  $HEAD        = array();
  $ONLOAD        = array();
  $SIDEBAR      = array();

  $ERROR        = 0;
  $ERRORSTR      = array();
  $NOTICE        = 0;
  $NOTICESTR      = array();
  $SUCCESS      = 0;
  $SUCCESSSTR      = array();

  $LMDIRECTORY    = str_replace("\\", "/", dirname(__FILE__))."/";
  $PREVIOUS_VERSIONS  = array("0.5.0", "0.9.3", "0.9.4", "0.9.5", "1.0.0");

  $TYPE        = ((isset($_GET["type"])) ? $_GET["type"] : $_POST["type"]);
  $STEP        = ((isset($_GET["step"])) ? $_GET["step"] : $_POST["step"]);

  define("IN_SETUP",   true);

  if(isset($_SESSION)) {
    $_SESSION["isAuthenticated"]  = false;
    $_SESSION            = array();
    @session_unset();
    @session_destroy();
  }

  require_once("./setup/databases.inc.php");
  require_once("./setup/preference_map.inc.php");

  require_once("./includes/pref_ids.inc.php");
  require_once("./includes/config.inc.php");
  require_once("./includes/classes/adodb/adodb.inc.php");

  require_once("./includes/functions.inc.php");

  ob_start("on_complete");
  ?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title>ListMessenger <?php echo VERSION_TYPE." ".VERSION_INFO ?> Setup [build <?php echo VERSION_BUILD; ?>]</title>

    <link rel="stylesheet" type="text/css" media="all" href="./css/common.css" title="ListMessenger Style" />

    <style type="text/css">
      @import url('./css/domtt.css');
    </style>

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
                    <td style="width: 72%; height: 20px; background-color: #CCCCCC; border-bottom: 1px #848284 solid; border-right: 1px #848284 solid">
                      <img src="./images/pixel.gif" width="500" height="20" alt="" title="" />
                    </td>
                    <td style="width: 28%; height: 20px; background-color: #999999; border-bottom: 1px #848284 solid; text-align: center">
                      <span class="titlea">List</span><span class="titleb">Messenger</span> <span class="titlea">Setup</span>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 100%; height: 530px; vertical-align: top" colspan="2">
                      <table style="width: 100%; height: 530px" cellspacing="0" cellpadding="3" border="0">
                      <colgroup>
                        <col style="width: 18%" />
                        <col style="width: 82%" />
                      </colgroup>
                      <tr>
                        <td style="vertical-align: top; padding: 5px">
                          <img src="./images/pixel.gif" width="125" height="1" alt="" title="" />
                          %SIDEBAR%
                        </td>
                        <td style="vertical-align: top; padding: 5px">
                          <img src="./images/pixel.gif" width="595" height="1" alt="" title="" />
                          <h1>ListMessenger <?php echo VERSION_TYPE." ".VERSION_INFO ?> Setup</h1>
                          <?php
                          switch($STEP) {
                            case "3" :
                              if(@file_exists("./includes/dbconnection.inc.php")) {
                                require_once("./includes/dbconnection.inc.php");

                                switch($TYPE) {
                                  case "new" :
                                    if(@file_exists("./setup/new.inc.php")) {
                                      require_once("./setup/new.inc.php");
                                    } else {
                                      $ERROR++;
                                      $ERRORSTR[] = "You are missing some installer files. Please re-upload the contents of the setup directory from your ListMessenger distribution file.";
                                      echo display_error($ERRORSTR);
                                    }
                                  break;
                                  case "reinstall" :
                                    if(@file_exists("./setup/reinstall.inc.php")) {
                                      require_once("./setup/reinstall.inc.php");
                                    } else {
                                      $ERROR++;
                                      $ERRORSTR[] = "You are missing some installer files. Please re-upload the contents of the setup directory from your ListMessenger distribution file.";
                                      echo display_error($ERRORSTR);
                                    }
                                  break;
                                  case "upgrade" :
                                    if(@file_exists("./setup/upgrade.inc.php")) {
                                      require_once("./setup/upgrade.inc.php");
                                    } else {
                                      $ERROR++;
                                      $ERRORSTR[] = "You are missing some installer files. Please re-upload the contents of the setup directory from your ListMessenger distribution file.";
                                      echo display_error($ERRORSTR);
                                    }
                                  break;
                                  case "installed" :
                                    header("Location: index.php");
                                    exit;
                                  break;
                                  default :
                                    $ERROR++;
                                    $ERRORSTR[] = "You have submitted in invalid installation type to this installer. Please re-start the installer and follow the on-page instructions. For more details, please view the installation log file.";
                                    echo display_error($ERRORSTR);
                                  break;
                                }
                              } else {
                                $ERROR++;
                                $ERRORSTR[] = "You are missing the database connection file in your includes directory. Please re-upload the contents of the includes directory from your ListMessenger distribution file and re-edit your ./includes/config.inc.php file.";
                                echo display_error($ERRORSTR);
                              }
                            break;
                            case "2" :
                              $PASSED  = true;
                              $short_open_tags  = (bool) @ini_get("short_open_tag");
                              $register_globals  = (bool) @ini_get("register_globals");
                              $php_version    = phpversion();
                              ?>
                              Welcome to the ListMessenger <?php echo VERSION_TYPE." ".VERSION_INFO ?> setup program that will help you install ListMessenger for the first time or upgrade your current ListMessenger database to this new version.
                              <h2>Requirements Check:</h2>
                              <table style="width: 100%; margin-top: 5px" cellspacing="0" cellpadding="1" border="0">
                              <?php
                              if(version_compare($php_version, "4.1.2", "<")) {
                                $PASSED  = false;
                                echo "<tr>\n";
                                echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"PHP Version: unsupported.\" title=\"PHP Version: unsupported.\" /></td>\n";
                                echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                echo "    PHP Version: PHP ".$php_version." is <b style=\"color: #CC0000\">unsupported</b>.<br />\n";
                                echo "    <span class=\"setup-error-text\">Your server is currently running PHP ".$php_version." which must be upgraded to at least PHP 4.1.2 in order to properly run ListMessenger. Please speak with your hosting provider or your server administrator about upgrading to a newer version of PHP so that you can install and run ListMessenger.</span>";
                                echo "    <br /><br />\n";
                                echo "  </td>\n";
                                echo "</tr>\n";
                              } elseif(version_compare($php_version, "4.3.0", "<")) {
                                echo "<tr>\n";
                                echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-exclamation.gif\" width=\"20\" height=\"20\" alt=\"PHP Version: supported.\" title=\"PHP Version: supported.\" /></td>\n";
                                echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                echo "    PHP Version: PHP ".$php_version." is <b style=\"color: #FF9900\">supported</b>.<br />\n";
                                echo "    <span class=\"setup-error-text\">You are using PHP ".$php_version." which this version of ListMessenger does support; however, some features (i.e. Backup & Restore, Import & Export) will not be available to you. For this reason we recommend that you use PHP 4.3.0 or higher. Please speak with your hosting provider or server administrator about upgrading PHP to a newer version.</span>\n";
                                echo "    <br /><br />\n";
                                echo "  </td>\n";
                                echo "</tr>\n";
                              } else {
                                echo "<tr>\n";
                                echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-checkmark.gif\" width=\"20\" height=\"20\" alt=\"PHP Version: valid.\" title=\"PHP Version: valid.\" /></td>\n";
                                echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">PHP Version: PHP ".$php_version." is <b style=\"color: #669900\">supported</b>.</td>\n";
                                echo "</tr>\n";
                              }

                              if(!@function_exists("ini_get")) {
                                $PASSED  = false;
                                echo "<tr>\n";
                                echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"PHP Function: ini_get disabled.\" title=\"PHP Function: ini_get disabled.\" /></td>\n";
                                echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                echo "    PHP Function: ini_get() is <b style=\"color: #CC0000\">disabled</b>.<br />\n";
                                echo "    <span class=\"setup-error-text\">It appears as though your hosting provider has disabled the ini_get() function in PHP. ListMessenger requires that this function be enabled so it is able to read information about how your environment is setup.</span>";
                                echo "    <br /><br />\n";
                                echo "  </td>\n";
                                echo "</tr>\n";
                              } else {
                                echo "<tr>\n";
                                echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-checkmark.gif\" width=\"20\" height=\"20\" alt=\"PHP Function: ini_get enabled.\" title=\"PHP Function: ini_get enabled.\" /></td>\n";
                                echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">PHP Function: ini_get() is <b style=\"color: #669900\">enabled</b>.</td>\n";
                                echo "</tr>\n";
                              }

                              if(!@function_exists("ini_set")) {
                                $PASSED  = false;
                                echo "<tr>\n";
                                echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"PHP Function: ini_set disabled.\" title=\"PHP Function: ini_set disabled.\" /></td>\n";
                                echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                echo "    PHP Function: ini_set() is <b style=\"color: #CC0000\">disabled</b>.<br />\n";
                                echo "    <span class=\"setup-error-text\">It appears as though your hosting provider has disabled the ini_set() function in PHP. ListMessenger requires that this function be enabled so it is able to set up your environment to run the application.</span>\n";
                                echo "    <br /><br />\n";
                                echo "  </td>\n";
                                echo "</tr>\n";
                              } else {
                                echo "<tr>\n";
                                echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-checkmark.gif\" width=\"20\" height=\"20\" alt=\"PHP Function: ini_set enabled.\" title=\"PHP Function: ini_set enabled.\" /></td>\n";
                                echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">PHP Function: ini_set() is <b style=\"color: #669900\">enabled</b>.</td>\n";
                                echo "</tr>\n";
                              }

                              if($PASSED) {
                                if(!@function_exists("file_exists")) {
                                  $PASSED  = false;
                                  echo "<tr>\n";
                                  echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"PHP Function: file_exists disabled.\" title=\"PHP Function: file_exists disabled.\" /></td>\n";
                                  echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                  echo "    PHP Function: fopen() is <b style=\"color: #CC0000\">disabled</b>.<br />\n";
                                  echo "    <span class=\"setup-error-text\">It appears as though your hosting provider has disabled the file_exists() function in PHP. ListMessenger uses the file_exists() function, so it needs to be re-enabled in PHP.</span>";
                                  echo "    <br /><br />\n";
                                  echo "  </td>\n";
                                  echo "</tr>\n";
                                }

                                if(!@function_exists("fopen")) {
                                  $PASSED  = false;
                                  echo "<tr>\n";
                                  echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"PHP Function: fopen disabled.\" title=\"PHP Function: fopen disabled.\" /></td>\n";
                                  echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                  echo "    PHP Function: fopen() is <b style=\"color: #CC0000\">disabled</b>.<br />\n";
                                  echo "    <span class=\"setup-error-text\">It appears as though your hosting provider has disabled the fopen() function in PHP. ListMessenger uses the fopen() function, so it needs to be re-enabled in PHP.</span>";
                                  echo "    <br /><br />\n";
                                  echo "  </td>\n";
                                  echo "</tr>\n";
                                }

                                if(!@function_exists("fwrite")) {
                                  $PASSED  = false;
                                  echo "<tr>\n";
                                  echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"PHP Function: fwrite disabled.\" title=\"PHP Function: fwrite disabled.\" /></td>\n";
                                  echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                  echo "    PHP Function: fwrite() is <b style=\"color: #CC0000\">disabled</b>.<br />\n";
                                  echo "    <span class=\"setup-error-text\">It appears as though your hosting provider has disabled the fwrite() function in PHP. ListMessenger uses the fwrite() function, so it needs to be re-enabled in PHP.</span>";
                                  echo "    <br /><br />\n";
                                  echo "  </td>\n";
                                  echo "</tr>\n";
                                }

                                if(!$short_open_tags) {
                                  $PASSED  = false;
                                  echo "<tr>\n";
                                  echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"PHP Setting: short_open_tags disabled.\" title=\"PHP Setting: short_open_tags disabled.\" /></td>\n";
                                  echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                  echo "    PHP Setting: short_open_tags is <b style=\"color: #CC0000\">disabled</b>.<br />\n";
                                  echo "    <span class=\"setup-error-text\">It appears as though your hosting provider has disabled the short_open_tags setting in PHP. This version of ListMessenger requires that they be enabled to run.</span>";
                                  echo "    <br /><br />\n";
                                  echo "  </td>\n";
                                  echo "</tr>\n";
                                } else {
                                  echo "<tr>\n";
                                  echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-checkmark.gif\" width=\"20\" height=\"20\" alt=\"PHP Setting: short_open_tags enabled.\" title=\"PHP Setting: short_open_tags enabled.\" /></td>\n";
                                  echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">PHP Setting: short_open_tags is <b style=\"color: #669900\">enabled</b>.</td>\n";
                                  echo "</tr>\n";
                                }

                                if(!@function_exists("fsockopen")) {
                                  echo "<tr>\n";
                                  echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-exclamation.gif\" width=\"20\" height=\"20\" alt=\"PHP Function: fsockopen disabled.\" title=\"PHP Function: fsockopen disabled.\" /></td>\n";
                                  echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                  echo "    PHP Function: fsockopen() is <b style=\"color: #FF9900\">disabled</b>.<br />\n";
                                  echo "    <span class=\"setup-error-text\">It appears as though your hosting provider has disabled the fsockopen() function in PHP. You can still run ListMessenger but some features (i.e. Program Update, PHP Support in Template Files, Sending messages by SMTP) will not function correctly.</span>\n";
                                  echo "    <br /><br />\n";
                                  echo "  </td>\n";
                                  echo "</tr>\n";
                                }

                                if(!@function_exists("pspell_new")) {
                                  echo "<tr>\n";
                                  echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-exclamation.gif\" width=\"20\" height=\"20\" alt=\"PHP Extension: pSpell is unavailable.\" title=\"PHP Extension: pSpell is unavailable.\" /></td>\n";
                                  echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                  echo "    PHP Extension: pSpell support is <b style=\"color: #FF9900\">not available</b>.<br />\n";
                                  echo "    <span class=\"setup-error-text\">You are still able to use ListMessenger and will not run into any issues; however, you do not have pSpell support compiled with PHP so the only thing you can't use is text-based spell checking.</span>\n";
                                  echo "    <br /><br />\n";
                                  echo "  </td>\n";
                                  echo "</tr>\n";
                                } else {
                                  echo "<tr>\n";
                                  echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-checkmark.gif\" width=\"20\" height=\"20\" alt=\"PHP Extension: pSpell is available.\" title=\"PHP Extension: pSpell is available.\" /></td>\n";
                                  echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">PHP Extension: pSpell support is <b style=\"color: #669900\">available</b>.</td>\n";
                                  echo "</tr>\n";
                                }

                                if($PASSED) {
                                  if((!@file_exists(dirname(__FILE__)."/key.php")) || (!@is_readable(dirname(__FILE__)."/key.php"))){
                                    $PASSED  = false;
                                    echo "<tr>\n";
                                    echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger: key unavailable.\" title=\"ListMessenger: key unavailable.\" /></td>\n";
                                    echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                    echo "    ListMessenger: Licence Key file is <b style=\"color: #CC0000\">unavailable</b>.<br />\n";
                                    echo "    <span class=\"setup-error-text\">Your ListMessenger key file (key.php) does not exist in your ListMessenger program directory or the key file is not readable by PHP. Please ensure that the key file is present and readable before continuing.</span>";
                                    echo "    <br /><br />\n";
                                    echo "  </td>\n";
                                    echo "</tr>\n";
                                  } else {
                                    echo "<tr>\n";
                                    echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-checkmark.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger: key available.\" title=\"ListMessenger: key available.\" /></td>\n";
                                    echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">ListMessenger: Licence Key file is <b style=\"color: #669900\">available</b>.</td>\n";
                                    echo "</tr>\n";
                                  }

                                  if((strlen(trim(DATABASE_TYPE)) < 1) || (!stristr(DATABASE_TYPE, "mysql"))) {
                                    $PASSED  = false;
                                    echo "<tr>\n";
                                    echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger: invalid database type.\" title=\"ListMessenger: invalid database type.\" /></td>\n";
                                    echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                    echo "    ListMessenger: Database type is <b style=\"color: #CC0000\">invalid</b>.<br />\n";
                                    echo "    <span class=\"setup-error-text\">You have either not set or the DATABASE_TYPE constant in ./includes/config.inc.php or set it to something other than mysql, mysqli or mysqlt. Currently only the MySQL database is supported in ListMessenger; although, more databases are planned for support in the future.</span>";
                                    echo "    <br /><br />\n";
                                    echo "  </td>\n";
                                    echo "</tr>\n";
                                  }
                                  if(strlen(trim(DATABASE_HOST)) < 1) {
                                    $PASSED  = false;
                                    echo "<tr>\n";
                                    echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger: invalid database host.\" title=\"ListMessenger: invalid database host.\" /></td>\n";
                                    echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                    echo "    ListMessenger: Database host is <b style=\"color: #CC0000\">invalid</b>.<br />\n";
                                    echo "    <span class=\"setup-error-text\">Please ensure that you edit the ./includes/config.inc.php file and set the DATABASE_HOST constant to the hostname or IP address of your database server.</span>";
                                    echo "    <br /><br />\n";
                                    echo "  </td>\n";
                                    echo "</tr>\n";
                                  }
                                  if(strlen(trim(DATABASE_NAME)) < 1) {
                                    $PASSED  = false;
                                    echo "<tr>\n";
                                    echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger: invalid database name.\" title=\"ListMessenger: invalid database name.\" /></td>\n";
                                    echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                    echo "    ListMessenger: Database name is <b style=\"color: #CC0000\">invalid</b>.<br />\n";
                                    echo "    <span class=\"setup-error-text\">Please ensure that you edit the ./includes/config.inc.php file and set the DATABASE_NAME constant to the name of the database you wish to install the tables into.</span>";
                                    echo "    <br /><br />\n";
                                    echo "  </td>\n";
                                    echo "</tr>\n";
                                  }
                                  if(strlen(trim(DATABASE_USER)) < 1) {
                                    $PASSED  = false;
                                    echo "<tr>\n";
                                    echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger: invalid database username.\" title=\"ListMessenger: invalid database username.\" /></td>\n";
                                    echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                    echo "    ListMessenger: Database username is <b style=\"color: #CC0000\">invalid</b>.<br />\n";
                                    echo "    <span class=\"setup-error-text\">Please ensure that you edit the ./includes/config.inc.php file and set the DATABASE_USER constant to the username that can connect to your database server.</span>";
                                    echo "    <br /><br />\n";
                                    echo "  </td>\n";
                                    echo "</tr>\n";
                                  }
                                  if(strlen(trim(DATABASE_PASS)) < 1) {
                                    $PASSED  = false;
                                    echo "<tr>\n";
                                    echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger: invalid database password.\" title=\"ListMessenger: invalid database password.\" /></td>\n";
                                    echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                    echo "    ListMessenger: Database password is <b style=\"color: #CC0000\">invalid</b>.<br />\n";
                                    echo "    <span class=\"setup-error-text\">Please ensure that you edit the ./includes/config.inc.php file and set the DATABASE_PASS constant to the password of the username that can connect to your database server. If you have your database username setup without a password then that is a security risk, please set the password prior to installation.</span>";
                                    echo "    <br /><br />\n";
                                    echo "  </td>\n";
                                    echo "</tr>\n";
                                  }
                                  if($PASSED) {
                                    @$db = NewADOConnection(DATABASE_TYPE);
                                    if(DATABASE_PCONNECT == true) {
                                      if(!@$db->PConnect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME)) {
                                        $PASSED  = false;
                                        echo "<tr>\n";
                                        echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger: invalid database connection.\" title=\"ListMessenger: invalid database connection.\" /></td>\n";
                                        echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                        echo "    ListMessenger: Database connection is <b style=\"color: #CC0000\">unavailable</b>.<br />\n";
                                        echo "    <span class=\"setup-error-text\">Unable to connect to your database server using a persistent connection. Please resolve the problem and click the &quot;Refresh&quot; button below.<br /><br /><b>Database Server Responsed:</b><br />".$db->ErrorMsg()."</span>";
                                        echo "    <br /><br />\n";
                                        echo "  </td>\n";
                                        echo "</tr>\n";
                                      } else {
                                        echo "<tr>\n";
                                        echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-checkmark.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger: valid database connection.\" title=\"ListMessenger: valid database connection.\" /></td>\n";
                                        echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">ListMessenger: Persistent database connection is <b style=\"color: #669900\">valid</b>.</td>\n";
                                        echo "</tr>\n";
                                      }
                                    } else {
                                      if(!@$db->Connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME)) {
                                        $PASSED  = false;
                                        echo "<tr>\n";
                                        echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-cross.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger: invalid database connection.\" title=\"ListMessenger: invalid database connection.\" /></td>\n";
                                        echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">\n";
                                        echo "    ListMessenger: Database connection is <b style=\"color: #CC0000\">unavailable</b>.<br />\n";
                                        echo "    <span class=\"setup-error-text\">Unable to connect to your database server. Please resolve the problem and click the &quot;Refresh&quot; button below.<br /><br /><b>Database Server Responsed:</b><br />".$db->ErrorMsg()."</span>";
                                        echo "    <br /><br />\n";
                                        echo "  </td>\n";
                                        echo "</tr>\n";
                                      } else {
                                        echo "<tr>\n";
                                        echo "  <td style=\"width: 15%; vertical-align: top; text-align: center\"><img src=\"./images/icon-checkmark.gif\" width=\"20\" height=\"20\" alt=\"ListMessenger: valid database connection.\" title=\"ListMessenger: valid database connection.\" /></td>\n";
                                        echo "  <td style=\"width: 85%; vertical-align: top; text-align: left\">ListMessenger: Database connection is <b style=\"color: #669900\">valid</b>.</td>\n";
                                        echo "</tr>\n";
                                      }
                                    }
                                  }
                                }
                              }
                              ?>
                              </table>

                              <form action="./setup.php?step=3" method="post">
                              <?php
                              if($PASSED) {

                                $install_type  = "new";
                                $version    = "";
                                $db_tables  = $db->MetaTables("TABLES");

                                if(@in_array(TABLES_PREFIX."preferences", $db_tables)) {
                                  $query    = "SELECT `preference_value` FROM `".TABLES_PREFIX."preferences` WHERE `preference_id`='".PREF_VERSION."'";
                                  $result    = $db->GetRow($query);
                                  if($result) {
                                    $version  = $result["preference_value"];
                                    if(version_compare($version, VERSION_INFO, "<") == 1) {
                                      $install_type  = "upgrade";
                                    } else {
                                      $install_type  = "installed";
                                    }
                                  } else {
                                    $install_type  = "upgrade";
                                    if((@in_array(TABLES_PREFIX."sent_messages", $db_tables)) && (@in_array(TABLES_PREFIX."sent_templates", $db_tables))) {
                                      $version = "0.5.0";
                                    } elseif((@in_array(TABLES_PREFIX."email_messages", $db_tables)) && (@in_array(TABLES_PREFIX."email_queues", $db_tables)) && (@in_array(TABLES_PREFIX."email_sending", $db_tables))) {
                                      $version = "0.9.3";
                                    }
                                  }
                                }
                                ?>
                                <input type="hidden" name="type" value="<?php echo $install_type; ?>" />
                                <h2>Installation Type:</h2>
                                <table style="width: 100%" cellspacing="0" cellpadding="1" border="0">
                                <?php
                                // New ListMessenger Installation
                                if($install_type == "new") : ?>
                                  <tr>
                                    <td style="width: 5%; text-align: center"><img src="./images/section-show.gif" width="9" height="9" alt="" title="" /></td>
                                    <td style="width: 95%; font-weight: bold; color: #000000">ListMessenger First Time Installation</td>
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td style="padding-bottom: 10px">
                                      The ListMessenger setup program will be creating the following database tables in the <span style="border-bottom: 1px #669900 dotted"><?php echo DATABASE_NAME; ?></span> database that you've supplied in the ./includes/config.inc.php file.
                                      <ol style="margin-bottom: 0px">
                                        <li><?php echo TABLES_PREFIX; ?>cdata</li>
                                        <li><?php echo TABLES_PREFIX; ?>cfields</li>
                                        <li><?php echo TABLES_PREFIX; ?>confirmation</li>
                                        <li><?php echo TABLES_PREFIX; ?>groups</li>
                                        <li><?php echo TABLES_PREFIX; ?>messages</li>
                                        <li><?php echo TABLES_PREFIX; ?>preferences</li>
                                        <li><?php echo TABLES_PREFIX; ?>queue</li>
                                        <li><?php echo TABLES_PREFIX; ?>sending</li>
                                        <li><?php echo TABLES_PREFIX; ?>sessions</li>
                                        <li><?php echo TABLES_PREFIX; ?>templates</li>
                                        <li><?php echo TABLES_PREFIX; ?>users</li>
                                        <li><?php echo TABLES_PREFIX; ?>user_updates</li>
                                      </ol>
                                    </td>
                                  </tr>
                                <?php
                                // Not A New Installation
                                else : ?>
                                  <tr>
                                    <td style="width: 5%; text-align: center"><img src="./images/section-hide.gif" width="9" height="9" alt="" title="" /></td>
                                    <td style="width: 95%; color: #666666">ListMessenger First Time Installation</td>
                                  </tr>
                                <?php
                                endif; ?>

                                <?php
                                // Upgrading ListMessenger
                                if($install_type == "upgrade") : ?>
                                  <tr>
                                    <td style="text-align: center"><img src="./images/section-show.gif" alt="" title="" /></td>
                                    <td style="font-weight: bold; color: #000000">Upgrade ListMessenger Database</td>
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td style="padding-bottom: 10px">
                                      <table style="width: 100%" cellspacing="0" cellpadding="1" border="0">
                                      <tr>
                                        <td style="white-space: nowrap">Please verify your current version of ListMessenger:</td>
                                        <td>
                                          <select class="select" name="previous_version">
                                          <?php
                                          foreach($PREVIOUS_VERSIONS as $value) {
                                            echo "<option value=\"".$value."\"".(($value == $version) ? " SELECTED" : "").">ListMessenger ".$value."</option>\n";
                                          }
                                          ?>
                                          </select>
                                        </td>
                                      </tr>
                                      </table>
                                    </td>
                                  </tr>
                                <?php
                                // Not Upgrading ListMessenger
                                else : ?>
                                  <tr>
                                    <td style="text-align: center"><img src="./images/section-hide.gif" width="9" height="9" alt="" title="" /></td>
                                    <td style="color: #666666">Upgrade ListMessenger Database</td>
                                  </tr>
                                <?php
                                endif; ?>

                                <?php
                                // Already Installed
                                if($install_type == "installed") : ?>
                                  <tr>
                                    <td style="text-align: center"><img src="./images/section-show.gif" width="9" height="9" alt="" title="" /></td>
                                    <td style="font-weight: bold; color: #000000">Completed ListMessenger <?php echo VERSION_INFO; ?> Database</td>
                                  </tr>
                                  <tr>
                                    <td></td>
                                    <td style="padding-bottom: 10px">
                                      It appears that you have ListMessenger <?php echo VERSION_INFO; ?> already installed and there is no need to run the ListMessenger setup program at this time.
                                    </td>
                                  </tr>
                                <?php
                                // Not Already Installed
                                else : ?>
                                  <tr>
                                    <td style="text-align: center"><img src="./images/section-hide.gif" width="9" height="9" alt="" title="" /></td>
                                    <td style="color: #666666">Completed ListMessenger <?php echo VERSION_INFO; ?> Database</td>
                                  </tr>
                                <?php
                                endif; ?>
                                </table>
                                <?php
                              }
                              ?>

                              <br /><br />
                              <table style="width: 100%; margin-top: 5px" cellspacing="0" cellpadding="1" border="0">
                              <tr>
                                <td style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px" colspan="2">
                                  <?php
                                  if($PASSED) {
                                    echo "<input type=\"submit\" value=\"Continue\" class=\"button\" />";
                                  } else {
                                    echo "<input type=\"button\" value=\"Refresh\" class=\"button\" onclick=\"window.location='./setup.php?step=2'\" />";
                                  }
                                  ?>
                                </td>
                              </tr>
                              </table>
                              </form>
                              <?php
                            break;
                            default :
                              ?>
                              <h2>Licence Agreement:</h2>
                              Before we begin you must <b>agree</b> to the following licence agreement:
                              <iframe style="width: 99%; height: 350px; border: 1px #CCCCCC dotted; margin: 5px; margin-left: 0px" src="./docs/licence.html"></iframe>
                              <div style="text-align: right; border-top: 1px #333333 dotted; margin-top: 5px; padding-top: 5px">
                                <input type="button" value="Do Not Agree" class="button" />
                                <input type="button" value="I Agree" class="button" onclick="window.location='setup.php?step=2'" />
                              </div>
                              <?php
                            break;
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