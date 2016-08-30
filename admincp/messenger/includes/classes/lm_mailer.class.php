<?php
/*
  ListMessenger - Professional Mailing List Management
  Copyright © 2007 Silentweb [http://www.silentweb.ca]

  Developed By: Matt Simpson <msimpson@listmessenger.com>

  For the most recent version, visit the ListMessenger website:
  [http://www.listmessenger.com]

  License Information is found in docs/licence.html
  $Id: lm_mailer.class.php 107 2007-03-25 19:49:18Z matt.simpson $

  ----

  CREDITS:
  ListMessenger's PHPMailer extension class written by James Collins.
*/

require_once("classes/phpmailer/class.phpmailer.php");

class LM_Mailer extends PHPMailer {
  /**
   * Primary object constructor which loads the required PHPMailer object.
   *
   * @param string $called_from
   * @return LM_Mailer
   */
  function LM_Mailer($called_from = "public", $extra_details = true) {
    if(($called_from == "private") && ($_SESSION["isAuthenticated"])) {
      $this->private_constructor();
    } else {
      $this->public_constructor((bool) $extra_details);
    }
  }

  /**
   * If LM_Mailer is called from within ListMessenger, then the private
   * constructor is called which uses session data.
   *
   * @return unknown
   */
  function private_constructor() {
    @ini_set("sendmail_from", $_SESSION["config"][PREF_ERREMAL_ID]);

    if(!@is_dir($_SESSION["config"][PREF_PROPATH_ID])) {
      $this->SetError("The ListMessenger Program Path does not exist.");
      return false;
    } else {
      if(!@defined("MAIL_BY")) {
        $this->SetError("The MAIL_BY constant is not defined which means the loader wasn't called.");
        return false;
      }
    }

    $this->PluginDir = $_SESSION["config"][PREF_PROPATH_ID]."includes/classes/phpmailer/";
    $this->SetLanguage("en", $_SESSION["config"][PREF_PROPATH_ID]."includes/classes/phpmailer/language/");

    switch(MAIL_BY) {
      case "mail" :
        $this->IsMail();
      break;
      case "smtp" :
        $this->IsSMTP();
        $this->Host         = SMTP_HOSTS;
        $this->SMTPAuth     = SMTP_AUTH;
        if($this->SMTPAuth) {
          $this->Username   = SMTP_AUTH_USER;
          $this->Password   = SMTP_AUTH_PASS;
        }
        $this->SMTPKeepAlive  = SMTP_KEEP_ALIVE;
      break;
      case "sendmail" :
        $this->IsSendmail();
        $this->Sendmail = SENDMAIL_PATH;
      break;
    }

    $this->ClearAddresses();
  }

  /**
   * If LM_Mailer is called from the end-user tools, then the public
   * constructor is called which uses the $config and $LM_PATH variable.
   *
   * @return unknown
   */
  function public_constructor($extra_details = true) {
    global $config, $LM_PATH;

    @ini_set("sendmail_from", $config[PREF_ERREMAL_ID]);

    if((!isset($config[PREF_DEFAULT_CHARSET])) ||
    (!isset($config[PREF_WORDWRAP])) ||
    (!isset($config[PREF_FRMEMAL_ID])) ||
    (!isset($config[PREF_FRMNAME_ID])) ||
    (!isset($config[PREF_ERREMAL_ID])) ||
    (!isset($config[PREF_RPYEMAL_ID])) ||
    (!isset($config[PREF_FRMNAME_ID])) ||
    (!isset($config[REG_SERIAL]))) {
      $this->SetError("The required ListMessenger configuration was not provided.");
      return false;
    }

    $this->PluginDir = $LM_PATH."includes/classes/phpmailer/";
    $this->SetLanguage("en", $LM_PATH."includes/classes/phpmailer/language/");

    switch($config[PREF_MAILER_BY_ID]) {
      case "mail" :
        $this->IsMail();
        break;
      case "smtp" :
        $this->IsSMTP();
        $this->Host         = $config[PREF_MAILER_BY_VALUE];
        $this->SMTPAuth     = $config[PREF_MAILER_AUTH_ID];
        if($this->SMTPAuth) {
          $this->Username   = $config[PREF_MAILER_AUTHUSER_ID];
          $this->Password   = $config[PREF_MAILER_AUTHPASS_ID];
        }
        $this->SMTPKeepAlive  = $config[PREF_MAILER_SMTP_KALIVE];
        break;
      case "sendmail" :
        $this->IsSendmail();
        $this->Sendmail = $config[PREF_MAILER_BY_VALUE];
        break;
    }

    if($extra_details) {
      $this->Priority  = 3;  // Normal
      $this->CharSet    = $config[PREF_DEFAULT_CHARSET];
      $this->Encoding  = "8bit";
      $this->WordWrap  = $config[PREF_WORDWRAP];

      $this->From       = $config[PREF_FRMEMAL_ID];
      $this->FromName  = $config[PREF_FRMNAME_ID];

      $this->Sender    = $config[PREF_ERREMAL_ID];

      $this->AddReplyTo($config[PREF_RPYEMAL_ID], $config[PREF_FRMNAME_ID]);

      $this->AddCustomHeader("X-ListMessenger-Version: ".VERSION_TYPE." [".VERSION_INFO."]");
      $this->AddCustomHeader("X-Originating-IP: ".$_SERVER["REMOTE_ADDR"]);
    }
    $this->ClearAddresses();
  }
}
?>