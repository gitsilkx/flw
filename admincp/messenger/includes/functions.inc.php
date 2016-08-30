<?php
/*
  ListMessenger - Professional Mailing List Management
  Copyright © 2007 Silentweb [http://www.silentweb.ca]

  Developed By: Matt Simpson <msimpson@listmessenger.com>

  For the most recent version, visit the ListMessenger website:
  [http://www.listmessenger.com]

  License Information is found in docs/licence.html
  $Id: functions.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

/**
 * Function loads PHPSniff and checks to see if a Rich Text Editor can be loaded.
 *
 */
function rte_loader() {
  global $RTE_ENABLED;

  if((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) {
    if((isset($_SESSION["config"][PREF_USERTE])) && ($_SESSION["config"][PREF_USERTE] != "disabled")) {
      if(!$RTE_ENABLED) {
        require_once("classes/phpsniff/phpsniff.class.php");
        $client =& new phpSniff();
        if(($client->browser_is("gecko1.3+")) || ($client->browser_is("ie6+")) || ($client->browser_is("mz1.3+")) || ($client->browser_is("ns7+"))) {
          $RTE_ENABLED = true;
        }
      }
    }
  }
}

/**
 * This function loads the code necessary to load the specified rich text editor.
 *
 */
function rte_display() {
  global $HEAD, $ONLOAD;

  $path_details  = pathinfo(html_encode($_SERVER["PHP_SELF"]));
  switch($_SESSION["config"][PREF_USERTE]) {
    case "htmlarea" :
      $i = count($HEAD);
      $HEAD[$i]  = "<script language=\"JavaScript\" type=\"text/javascript\">\n";
      $HEAD[$i] .= "_editor_url = '".$path_details["dirname"]."/javascript/htmlarea/';\n";
      $HEAD[$i] .= "_editor_lang = 'en';\n";
      $HEAD[$i] .= "</script>\n";
      $HEAD[$i] .= "<script language=\"JavaScript\" type=\"text/javascript\" src=\"./javascript/htmlarea/htmlarea.js\"></script>\n";
      $HEAD[$i] .= "<script type=\"text/javascript\" language=\"javascript\">\n";
      $HEAD[$i] .= "HTMLArea.loadPlugin('FullPage');\n";
      $HEAD[$i] .= "HTMLArea.loadPlugin('CharacterMap');\n";
      $HEAD[$i] .= "HTMLArea.loadPlugin('ImageManager');\n";
      $HEAD[$i] .= "function initDocument() {\n";
      $HEAD[$i] .= "\tvar editor = new HTMLArea('html_message');\n";
      $HEAD[$i] .= "\teditor.registerPlugin(FullPage);\n";
      $HEAD[$i] .= "\teditor.registerPlugin(CharacterMap);\n";
      $HEAD[$i] .= "\teditor.registerPlugin(ImageManager);\n";
      $HEAD[$i] .= "\teditor.config.hideSomeButtons(' formatblock ');\n";
      $HEAD[$i] .= "\teditor.generate();\n";
      $HEAD[$i] .= "}\n\n";
      $HEAD[$i] .= "HTMLArea.onload = initDocument;\n";
      $HEAD[$i] .= "</script>\n";
      $ONLOAD[] = "HTMLArea.init()";
    break;
    case "innovastudio" :
    case "yes" :
      $i = count($HEAD);
      $HEAD[$i]  = "<script language=\"JavaScript\" type=\"text/javascript\" src=\"./javascript/innovastudio/scripts/innovaeditor.js\"></script>\n";

      echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
      echo "\tvar oEdit1        = new InnovaEditor('oEdit1');\n";
      echo "\toEdit1.cmdAssetManager  = 'modalDialogShow(\'".$path_details["dirname"]."/javascript/innovastudio/assetmanager/assetmanager.php?sid=".session_id()."\', 640, 472);';\n";
      echo "\toEdit1.mode        = 'XHTML';\n";
      echo "\toEdit1.useTagSelector    = false;\n";
      echo "\toEdit1.btnPasteText    = true;\n";
      echo "\toEdit1.btnSpellCheck    = true;\n";
      echo "\toEdit1.btnClearAll    = true;\n";
      echo "\toEdit1.width      = '100%';\n";
      echo "\toEdit1.height      = '350px';\n";
      echo "\toEdit1.REPLACE('html_message');\n";
      echo "</script>\n";
    break;
    default :
      continue;
    break;
  }
}

/**
 * Function is called by the output buffer upon completion.
 *
 * @param string $buffer
 * @return string
 */
function on_complete($buffer) {
  $output = check_onload($buffer);
  $output = check_sidebar($output);
  $output = check_head($output);
  $output = check_count($output);

  return $output;
}

/**
 * Function is called by on_complete function. It can add any onLoad events to the <body> tag.
 *
 * @param string $output
 * @return string
 */
function check_onload($output) {
  global $ONLOAD;

  if((is_array($ONLOAD)) && (count($ONLOAD))) {
    return str_replace("<body>", "<body onload=\"".implode(", ", $ONLOAD)."\">", $output);
  } else {
    return $output;
  }
}

/**
 * Function is called by on_complete. It can modify the sidebar with any specified content.
 *
 * @param string $output
 * @return string
 */
function check_sidebar($output) {
  global $SIDEBAR;

  if((is_array($SIDEBAR)) && (count($SIDEBAR))) {
    $html = implode("\n", $SIDEBAR);
  } else {
    $html = "";
  }
  return str_replace("%SIDEBAR%", $html, $output);
}

/**
 * Function is called by on_complete. It can add contents to the <head> tags by replacing %HEAD%.
 *
 * @param string $output
 * @return string
 */
function check_head($output) {
  global $HEAD;

  if((is_array($HEAD)) && (count($HEAD))) {
    $html = implode("\n", $HEAD);
  } else {
    $html = "";
  }
  return str_replace("%HEAD%", $html, $output);
}

/**
 *  Function is called by on_complete. It's used to replace the total number of users on the page.
 *
 * @param string $output
 * @return string
 */
function check_count($output) {
  global $db;

  if((is_object($db)) && ($db->IsConnected())) {
    $recount  = total_subscribers();
    $count    = $recount[0];
  } else {
    $count    = "";
  }
  return str_replace("%USERCOUNT%", $count, $output);
}

/**
 * Function checks to ensure that the ListMessenger Licence key exists.
 *
 * @return bool
 */
function check_licence() {
  global $TRIP;

  $TRIP = false;
  if((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) {
    if(@file_exists($_SESSION["config"][PREF_PROPATH_ID]."key.php")) {
      return true;
    } else {
      return false;
    }
  } else {
    return true;
  }
}

/**
 * Function that checks to see if magic_quotes_gpc is enabled or not.
 *
 * Okay, I realize that I do this backward to most people who check for it, then
 * strip the slashes if it is enabled, then check later... but I didn't do that
 * okay, I don't know why. Leave me be ;) ha. I'll do that next time.
 *
 * @param string $value
 * @param int $display
 * @return string
 */
function checkslashes($value = "", $display = 0) {
  switch($display) {
    case 1 :
      if(!@ini_get("magic_quotes_gpc")) {
        return $value;
      } else {
        return stripslashes($value);
      }
    break;
    default :
      if(!@ini_get("magic_quotes_gpc")) {
        return addslashes($value);
      } else {
        return $value;
      }
    break;
  }
}

/**
 * Function checks to ensure the e-mail address is valid.
 *
 * @param string $address
 * @return bool
 */
function valid_address($address) {
  return ((eregi("^[a-zA-Z0-9\+._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$", $address)) ? true : false);
}

/**
 * Removes default linebreaks.
 *
 * @param string $string
 * @return string
 */
function remove_linebreaks($string = "") {
  return str_replace(array("\n", "\r"), "", $string);
}

/**
 * Shows the total number of subscribers in all groups.
 *
 * @return array
 */
function total_subscribers() {
  global $db;

  if((is_object($db)) && ($db->IsConnected())) {
    $query  = "SELECT COUNT(*) AS `total` FROM `".TABLES_PREFIX."users`";
    $result  = $db->GetRow($query);
    if($result) {
      switch((int) $result["total"]) {
        case 0 :
          continue;
        break;
        case 1 :
          return array("<span class=\"small-grey\">1 Subscriber</span>", (int) $result["total"]);
        break;
        default :
          return array("<span class=\"small-grey\">".(int) $result["total"]." Subscribers</span>", (int) $result["total"]);
        break;
      }
    }
  }

  return array("<span class=\"small-grey\">No Subscribers Present</span>", 0);
}

/**
 * Function Loads / Reloads configuration into session array.
 *
 * @param bool $reload
 * @return bool
 */
function load_configuration($reload = false) {
  global $db;

  if($reload) {
    unset($_SESSION["config"]);
  }

  if(!isset($_SESSION["config"])) {
    $query  = "SELECT * FROM `".TABLES_PREFIX."preferences`";
    $results  = $db->GetAll($query);
    if($results) {
      foreach($results as $result) {
        $_SESSION["config"][$result["preference_id"]] = $result["preference_value"];
      }
      return true;
    } else {
      return false;
    }
  } else {
    return true;
  }
}

/**
 * Function will reload the session configuration.
 *
 * @return bool
 */
function reload_configuration() {
  return load_configuration(true);
}

/**
 * Function Loads the end-user tools configuration into an array.
 *
 * @return array
 */
function enduser_configuration() {
  global $db;

  $config    = array();
  $query    = "SELECT * FROM `".TABLES_PREFIX."preferences`";
  $results  = $db->GetAll($query);
  if($results) {
    foreach($results as $result) {
      switch($result["preference_id"]) {
        case PREF_FRMNAME_ID :
        case PREF_FRMEMAL_ID :
        case PREF_RPYEMAL_ID :
        case PREF_ABUEMAL_ID :
        case PREF_NOTEMAL_ID :
        case PREF_ERREMAL_ID :
        case PREF_PROPATH_ID :
        case PREF_PRIVATE_PATH :
        case PREF_PUBLIC_URL :
        case PREF_PUBLIC_PATH :
        case PREF_DEFAULT_CHARSET :
        case PREF_DATEFORMAT :
        case PREF_ERROR_LOGGING :
        case PREF_TIMEZONE :
        case PREF_DAYLIGHT_SAVINGS :
        case PREF_POSTSUBSCRIBE_MSG :
        case PREF_POSTUNSUBSCRIBE_MSG :
        case ENDUSER_UNSUBCON :
        case ENDUSER_SUBCON :
        case ENDUSER_NEWSUBNOTICE :
        case ENDUSER_UNSUBNOTICE :
        case PREF_FOPEN_URL :
        case ENDUSER_MXRECORD :
        case ENDUSER_ARCHIVE :
        case ENDUSER_PROFILE :
        case ENDUSER_LANG_ID :
        case PREF_EXPIRE_CONFIRM :
        case ENDUSER_ARCHIVE_FILENAME :
        case ENDUSER_PROFILE_FILENAME :
        case ENDUSER_CONFIRM_FILENAME :
        case ENDUSER_HELP_FILENAME :
        case ENDUSER_FILENAME :
        case ENDUSER_TEMPLATE :
        case ENDUSER_UNSUB_FILENAME :
        case ENDUSER_CAPTCHA :
        case ENDUSER_AUDIO_CAPTCHA :
        case ENDUSER_FLITE_PATH :
        case PREF_WORDWRAP :
        case PREF_MAILER_BY_ID :
        case PREF_MAILER_BY_VALUE :
        case PREF_MAILER_AUTH_ID :
        case PREF_MAILER_AUTHUSER_ID :
        case PREF_MAILER_AUTHPASS_ID :
        case PREF_ADD_UNSUB_LINK :
        case REG_SERIAL :
        case PREF_MAILER_SMTP_KALIVE :
          $config[$result["preference_id"]]  = $result["preference_value"];
        break;
        case ENDUSER_BANEMAIL :
        case PREF_POSTSUBSCRIBE_MSG :
        case PREF_POSTUNSUBSCRIBE_MSG :
        case ENDUSER_BANDOMS :
          $config[$result["preference_id"]]  = @explode(";", trim(str_replace(" ", "", strtolower($result["preference_value"]))));
        break;
      }
    }

    return $config;
  } else {
    return false;
  }
}

/**
 * If this is before PHP 4.3, then I suppose we'll have to make our own file_get_contents function.
 */
if(!function_exists("file_get_contents")) {
  function file_get_contents($filename, $use_include_path = 0) {
    $data = "";
    $handle = @fopen($filename, "rb", $use_include_path);
    if($handle) {
      while (!@feof($handle)) {
        $data .= @fread($handle, 1024);
      }
      @fclose($handle);
    }

    return $data;
  }
}

/**
 * Function will retrieve the template file and return the HTML as a string if it's found, false if not.
 *
 * @return template file contents.
 */
function get_template() {
  global $config;

  $filename  = (($config[PREF_FOPEN_URL] == "yes") ? $config[PREF_PUBLIC_URL] : $config[PREF_PUBLIC_PATH]).$config[ENDUSER_TEMPLATE];
  if($template = @file_get_contents($filename)) {
    return $template;
  } else {
    return false;
  }
}

/**
 * Function to properly format the error messages for consistency.
 *
 * @param array $errorstr
 * @return string
 */
function display_error($errorstr = array()) {
  $output = "";

  if(is_array($errorstr)) {
    if($errors = count($errorstr)) {
      $output .= "<div class=\"error-message\">\n";
      $output .= "  <strong>You have ".$errors." error".(($errors != 1) ? "s" : "")." for review:</strong>\n";
      $output .= "  <ol>\n";
      foreach($errorstr as $message) {
        $output .= "  <li>".$message."</li>\n";
      }
      $output .= "  </ol>\n";
      $output .= "</div>\n";
    }
  }

  return $output;
}

/**
 * Function to properly format the notice messages for consistency.
 *
 * @param array $noticestr
 * @return string
 */
function display_notice($noticestr = array()) {
  $output = "";

  if(is_array($noticestr)) {
    if($notices = count($noticestr)) {
      $output .= "<div class=\"notice-message\">\n";
      $output .= "  <strong>You have ".$notices." notice".(($notices != 1) ? "s" : "")." for review:</strong>\n";
      $output .= "  <ol>\n";
      foreach($noticestr as $message) {
        $output .= "  <li>".$message."</li>\n";
      }
      $output .= "  </ol>\n";
      $output .= "</div>\n";
    }
  }

  return $output;
}

/**
 * Function to properly format the success messages for consistency.
 *
 * @param array $successstr
 * @return string
 */
function display_success($successstr = array()) {
  $output = "";

  if(is_array($successstr)) {
    if($success = count($successstr)) {
      $output .= "<div class=\"success-message\">\n";
      $output .= "  <strong>Successfully completed ".$success." task".(($success != 1) ? "s" : "").":</strong>\n";
      $output .= "  <ol>\n";
      foreach($successstr as $message) {
        $output .= "  <li>".$message."</li>\n";
      }
      $output .= "  </ol>\n";
      $output .= "</div>\n";
    }
  }

  return $output;
}

/**
 * Function takes the current query string and processes the requested modifications.
 *
 * @param array $modify
 * @return string
 */
function replace_query($modify = array()) {
  $process  = array();
  $tmp_string  = array();

  if(count($modify) > 0) {
    $original  = explode("&", $_SERVER["QUERY_STRING"]);
    if(count($original) > 0) {
      foreach($original as $value) {
        $pieces = explode("=", $value);
        // Gets rid of any unset variables for the URL.
        if(isset($pieces[0]) && isset($pieces[1])) {
          $process[$pieces[0]] = $pieces[1];
        }
      }
    }

    foreach($modify as $key => $value) {
      if(array_key_exists($key, $process)) {
        if(($value === 0) || (($value) && ($value !=""))) {
          $process[$key] = $value;
        } else {
          unset($process[$key]);
        }
      } else {
        if(($value === 0) || (($value) && ($value !=""))) {
          $process[$key] = $value;
        }
      }
    }
    if(count($process) > 0) {
      foreach($process as $var => $value) {
        $tmp_string[] = $var."=".$value;
      }
      $new_query = implode("&", $tmp_string);
    } else {
      $new_query = "";
    }
  } else {
    $new_query = $_SERVER["QUERY_STRING"];
  }

  return (($new_query != "") ?  "?".$new_query : "");
}

// Function to generate the heading links for the User Directory.
function order_link($field, $name, $order, $sort, $islink = true, $att_window = false) {
  if($islink) {
    if(strtolower($sort) == strtolower($field)) {
      if(strtolower($order) == "desc") {
        return "&nbsp;<img src=\"./images/sort-asc.gif\" width=\"9\" height=\"9\" alt=\"Ordered By ".$name."\">&nbsp;<a href=\"".(($att_window) ? "attachments.php" : "index.php").replace_query(array("sort" => $field, "order" => "asc"))."\" class=\"theading-on\" title=\"Order by ".$name." &amp; Sort Ascending\">".$name."</a>\n";
      } else {
        return "&nbsp;<img src=\"./images/sort-desc.gif\" width=\"9\" height=\"9\" alt=\"Ordered By ".$name."\">&nbsp;<a href=\"".(($att_window) ? "attachments.php" : "index.php").replace_query(array("sort" => $field, "order" => "desc"))."\" class=\"theading-on\" title=\"Order by ".$name." &amp; Sort Decending\">".$name."</a>\n";
      }
    } else {
      return "<a href=\"".(($att_window) ? "attachments.php" : "index.php").replace_query(array("sort" => $field))."\" class=\"theading-off\" title=\"Order by ".$name."\">".$name."</a>&nbsp;<img src=\"./images/pixel.gif\" width=\"9\" height=\"9\" alt=\"\">\n";
    }
  } else {
    return "<span class=\"theading-off\">".$name."</span>\n";
  }
}

// Function to chop off a string at the given maximum character length.
function limit_chars($string, $chars) {
  $length  = strlen($string);
  if($length <= $chars) {
    return $string;
  } else {
    return substr(str_pad($string, $chars), 0, ($chars - 3))."...";
  }
}

// Function that will set the date & time format accordingly for a JavaScript-Set cookie.
function javascript_cookie() {
  return gmdate("D, j M Y H:i T", PREF_COOKIE_TIMEOUT);
}

// Function will return all groups below the specified parent_id, as option elements of an input select.
function groups_inselect($parent_id, $current_selected = array(), $indent = 0, $exclude = array()) {
  global $db;

  if($indent > 99) {
    die("Preventing infinite loop");
  }

  $query  = "SELECT `groups_id`, `group_name`, `group_parent` FROM `".TABLES_PREFIX."groups` WHERE `group_parent` = ".$db->qstr((int) $parent_id);
  $results  = $db->GetAll($query);

  $output  = "";
  foreach($results as $result) {
    if((!in_array($result["groups_id"], $exclude)) && (!in_array($parent_id, $exclude))) {
      $output .= "<option value=\"".$result["groups_id"]."\"".((is_array($current_selected)) ? ((in_array($result["groups_id"], $current_selected)) ? " selected=\"selected\"" : "") : "").">".str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $indent).(($indent > 0) ? "&rarr;&nbsp;" : "").$result["group_name"]."</option>\n";
    } else {
      $exclude[] = $result["groups_id"];
    }
    $output .= groups_inselect($result["groups_id"], $current_selected, $indent + 1, $exclude);
  }
  return $output;
}

// Function will return all groups below the specified parent_id, as table rows of a table.
function groups_intable($parent_id, $indent = 0) {
  global $db;

  if($indent > 99) {
    die("Preventing infinite loop");
  }

  $query  = "SELECT `groups_id`, `group_name`, `group_parent` FROM `".TABLES_PREFIX."groups` WHERE `group_parent`='".$parent_id."'";
  $results  = $db->GetAll($query);
  $output  = "";
  foreach($results as $result) {
    $subscribers = users_count($result["groups_id"]);

    $output .= "<tr onmouseout=\"this.style.backgroundColor='#FFFFFF'\" onmouseover=\"this.style.backgroundColor='#F0FFD1'\">\n";
    $output .= "  <td style=\"width: 40px\"><a href=\"./index.php?section=manage-groups&action=edit&id=".$result["groups_id"]."\"><img src=\"./images/icon-edit-groups.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Edit\" title=\"Edit ".$result["group_name"]."\" /></a>&nbsp;<a href=\"./index.php?section=manage-groups&action=delete&id=".$result["groups_id"]."\"><img src=\"./images/icon-del-groups.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"Delete\" title=\"Delete ".$result["group_name"]."\" /></a></td>\n";
    $output .= "  <td style=\"overflow: hidden\">".str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $indent)."<img src=\"./images/record-next-off.gif\" width=\"9\" height=\"9\" border=\"0\" alt=\"View\" />&nbsp;<a href=\"./index.php?section=subscribers&g=".$result["groups_id"]."\">".$result["group_name"]."</a></td>\n";
    $output .= "  <td class=\"small-grey\">Group ID: ".$result["groups_id"]."</td>\n";
    $output .= "  <td class=\"small-grey\">".$subscribers." Subscriber".(($subscribers != 1) ? "s" : "")."</td>\n";
    $output .= "</tr>\n";
    $output .= groups_intable($result["groups_id"], $indent + 1);
  }
  return $output;
}

// Function will return all groups below the specified parent_id, as nested list items of a list.
function groups_inlist($parent_id, $indent = 0) {
  global $db;

  if($indent > 99) {
    die("Preventing infinite loop");
  }

  $query  = "SELECT `groups_id`, `group_name`, `group_parent` FROM `".TABLES_PREFIX."groups` WHERE `group_parent`='".$parent_id."'";
  $results  = $db->GetAll($query);

  $output  = "<ul>";
  foreach($results as $result) {
    $output .= "<li>".$result["group_name"]."</li>";
    $output .= groups_inlist($result["groups_id"], $indent + 1);
  }
  return $output."</ul>";
}

// Function will return all group ID's below the specified parent_id, as an array.
function groups_inarray($parent_id = 0, &$groups, $level = 0) {
  global $db;

  if($level > 99) {
    die("Preventing infinite loop");
  }

  $query    = "SELECT * FROM `".TABLES_PREFIX."groups` WHERE `group_parent` = ".$db->qstr((int) $parent_id);
  $results  = $db->GetAll($query);
  if($results) {
    foreach($results as $result) {
      $groups[] = $result["groups_id"];

      groups_inarray($result["groups_id"], $groups, $level + 1);
    }
  }

  return $groups;
}

// Function will return the number of sub-groups under the ID you specify.
function groups_count($parent_id = 0, &$groups, $level = 0) {
  global $db;

  if($level > 99) {
    die("Preventing infinite loop");
  }

  $query    = "SELECT `groups_id` FROM `".TABLES_PREFIX."groups` WHERE `group_parent`='".$parent_id."'";
  $results  = $db->GetAll($query);
  if($results) {
    foreach($results as $result) {
      $groups += 1;
      groups_count($result["groups_id"], $groups, $level + 1);
    }
  }
  return $groups;
}

// Function will return name, parent ID, and login status of the id(s) you specify.
function groups_information($group_ids = array(), $name_only = false, $output_string = true) {
  global $db;

  $output = array();

  if(!is_array($group_ids)) {
    $group_ids = array($group_ids);
  }

  if(@count($group_ids)) {
    if(!$name_only) {
      foreach($group_ids as $group_id) {
        if((int) $group_id) {
          $query  = "SELECT * FROM `".TABLES_PREFIX."groups` WHERE `groups_id`='".$group_id."'";
          $result  = $db->GetRow($query);
          if($result) {
            $output[$result["groups_id"]] =  array(
                          "name"    => $result["group_name"],
                          "parent"  => $result["group_parent"],
                          "login"    => $result["permit_login"]
                          );
          } else {
            $output[$group_id] = false;
          }
        }
      }
    } else {
      foreach($group_ids as $group_id) {
        if((int) $group_id) {
          $query  = "SELECT `group_name` FROM `".TABLES_PREFIX."groups` WHERE `groups_id`=".$db->qstr((int) $group_id);
          $result  = $db->GetRow($query);
          if($result) {
            $output[] = $result["group_name"];
          }
        }
      }

      if((count($output) == 1) && ($output_string)) {
        return $output[0];
      }
    }

    return $output;
  }

  return false;
}

// Function will delete all groups below the specified parent_id. It will also call users_remove to remove all users in the groups it deletes.
function groups_delete($parent_id, $level = 0, $del_users = false) {
  global $db;

  if($level > 99) {
    die("Preventing infinite loop");
  }

  $query  = "SELECT `groups_id` FROM `".TABLES_PREFIX."groups` WHERE `group_parent`='".$parent_id."'";
  $results  = $db->GetAll($query);

  foreach($results as $result) {
    $query = "DELETE FROM `".TABLES_PREFIX."groups` WHERE `groups_id`='".$parent_id."'";
    $db->Execute($query);
    if($del_users) {
      users_delete($result["groups_id"]);
    }
    groups_delete($result["groups_id"], $level + 1, $del_users);
  }
  return true;
}

// Function will move the groups with the $from_id, to the $to_id.
function groups_move($from_id, $to_id) {
  global $db;

  if((strlen($from_id) > 0) && (strlen($to_id) > 0)) {
    $query = "UPDATE `".TABLES_PREFIX."groups` SET `group_parent`='".$to_id."' WHERE `group_parent`='".$from_id."'";
    if($db->Execute($query)) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

// Function will add the user including custom data to the groups provided.
function users_add($email_address, $firstname, $lastname, $groups_array, $custom_data = array(), $called_from = "private", $send_post_subscribe_message = true) {
  global $db, $config;

  $int_config    = (($called_from == "public") ? ((is_array($config)) ? $config : false) : (((isset($_SESSION["config"])) && (isset($_SESSION["isAuthenticated"]))) ? $_SESSION["config"] : false));

  if(($int_config) && (@count($groups_array) > 0)) {
    $success  = 0;
    $failed    = 0;
    $semi    = 0;

    foreach($groups_array as $group_id) {
      $query  = "SELECT * FROM `".TABLES_PREFIX."users` WHERE `group_id`='".checkslashes($group_id)."' AND `email_address`='".checkslashes($email_address)."'";
      $result  = $db->GetRow($query);
      if(!$result) {
        $query  = "INSERT INTO `".TABLES_PREFIX."users` VALUES (NULL, '".checkslashes($group_id)."', '".time()."', ".$db->qstr($firstname).", ".$db->qstr($lastname).", ".$db->qstr($email_address).");";
        if(($db->Execute($query)) && ($user_id = $db->Insert_Id())) {
          $success++;
          if(@count($custom_data) > 0) {
            foreach($custom_data as $field_sname => $value) {
              $cfield_id  = get_field_id($field_sname);
              if($cfield_id) {
                $query  = "INSERT INTO `".TABLES_PREFIX."cdata` VALUES (NULL, '".$user_id."', '".$cfield_id."', '".((@is_array($value)) ? implode(", ", $value) : checkslashes(trim($value)))."');";
                if(!$db->Execute($query)) {
                  $semi++;
                  if($int_config[PREF_ERROR_LOGGING] == "yes") {
                    @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to insert custom field data into custom field table. Database server said: ".$db->ErrorMsg()."\n", 3, $int_config[PREF_PRIVATE_PATH]."logs/error_log.txt");
                  }
                }
              }
            }
          }
        } else {
          $failed++;
          if($int_config[PREF_ERROR_LOGGING] == "yes") {
            @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to insert user data into subscriber table. Database server said: ".$db->ErrorMsg()."\n", 3, $int_config[PREF_PRIVATE_PATH]."logs/error_log.txt");
          }
        }
      }
    }

    if(($success) && ($int_config[PREF_POSTSUBSCRIBE_MSG]) && ($send_post_subscribe_message)) {
      if(!send_post_action_message("subscribe", array($user_id), $int_config)) {
        if($int_config[PREF_ERROR_LOGGING] == "yes") {
          @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to send new subscriber the post-subscribe message.\n", 3, $int_config[PREF_PRIVATE_PATH]."logs/error_log.txt");
        }
      }
    }

    return array("success" => $success, "semi" => $semi, "failed" => $failed);
  } else {
    if($int_config[PREF_ERROR_LOGGING] == "yes") {
      @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tThere were no groups provided to the users_add function.\n", 3, $int_config[PREF_PRIVATE_PATH]."logs/error_log.txt");
    }
    return false;
  }
}

function send_post_action_message($action = "subscribe", $subscriber_ids = array(), $config = array()) {
  global $db;

  if((@count($subscriber_ids) > 0) && (is_array($config))) {
    $message_id  = (int) (($action == "subscribe") ? $config[PREF_POSTSUBSCRIBE_MSG] : $config[PREF_POSTUNSUBSCRIBE_MSG]);
    if($message_id) {
      $query    = "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_id`=".$db->qstr($message_id);
      $result    = $db->GetRow($query);
      if($result) {
        $language_pack  = array();

        $mail      = new LM_Mailer("public", false);
        $mail->Priority  = $result["message_priority"];
        $mail->CharSet  = $config[PREF_DEFAULT_CHARSET];
        $mail->Encoding  = "8bit";
        $mail->WordWrap  = $config[PREF_WORDWRAP];

        $from_pieces  = explode("\" <", $result["message_from"]);
        $mail->From     = substr($from_pieces[1], 0, (@strlen($from_pieces[1])-1));
        $mail->FromName  = substr($from_pieces[0], 1, (@strlen($from_pieces[0])));

        $mail->Sender  = $config[PREF_ERREMAL_ID];

        $reply_pieces  = explode("\" <", $result["message_reply"]);
        $mail->AddReplyTo(substr($reply_pieces[1], 0, (@strlen($reply_pieces[1])-1)), substr($reply_pieces[0], 1, (@strlen($reply_pieces[0]))));

        $date      = time();
        $subject    = $result["message_subject"];

        $html_template  = $result["html_template"];
        $html_message  = $result["html_message"];

        $text_template  = $result["text_template"];
        $text_message  = $result["text_message"];

        // Look for attachments on this message, if they're there and valid, attach them.
        if($result["attachments"] != "") {
          $attachments = unserialize($result["attachments"]);
          if((@is_array($attachments)) && (@count($attachments) > 0)) {
            foreach($attachments as $filename) {
              if(@file_exists($config[PREF_PUBLIC_PATH]."files/".str_replace(array("..", "/", "\\"), "", $filename))) {
                $mail->AddAttachment($config[PREF_PUBLIC_PATH]."files/".str_replace(array("..", "/", "\\"), "", $filename));
              }
            }
          }
        }

        foreach($subscriber_ids as $subscriber_id) {
          $user_data = get_custom_data($subscriber_id, array("messageid" => $message_id), "public");

          if((is_array($user_data)) && (@count($user_data) > 0) && (valid_address($user_data["email"]))) {
            $mail->ClearAddresses();
            $mail->ClearCustomHeaders();

            $mail->AddCustomHeader("X-ListMessenger-Version: ".VERSION_TYPE." [".VERSION_INFO."]");
            $mail->AddCustomHeader("X-Originating-IP: ".$_SERVER["REMOTE_ADDR"]);
            $mail->AddCustomHeader("List-Help: <".$config[PREF_PUBLIC_URL].$config[ENDUSER_HELP_FILENAME].">");
            $mail->AddCustomHeader("List-Owner: <mailto:".$mail->From."> (".$mail->FromName.")");
            $mail->AddCustomHeader("List-Unsubscribe: <".$config[PREF_PUBLIC_URL].$config[ENDUSER_UNSUB_FILENAME]."?addr=".$user_data["email"].">");
            $mail->AddCustomHeader("List-Archive: <".$config[PREF_PUBLIC_URL].$config[ENDUSER_ARCHIVE_FILENAME].">");
            $mail->AddCustomHeader("List-Post: NO");

            $mail->Subject  = custom_data($user_data, $subject);

            if(strlen(trim($html_message)) > 0) {
              $mail->Body    = custom_data($user_data, unsubscribe_message(insert_template("html", $html_template, $html_message), "html", (($user_data["groupid"]) ? true : false)));
              $mail->AltBody  = custom_data($user_data, unsubscribe_message(insert_template("text", $text_template, $text_message), "text", (($user_data["groupid"]) ? true : false)));
            } else {
              $mail->Body    = custom_data($user_data, unsubscribe_message(insert_template("text", $text_template, $text_message), "text", (($user_data["groupid"]) ? true : false)));
            }

            $mail->AddAddress(trim($user_data["email"]), $user_data["name"]);

            if((!@$mail->IsError()) && (@$mail->Send())) {
              $sent_msg = true;
            } else {
              $sent_msg = false;

              if($config[PREF_ERROR_LOGGING] == "yes") {
                @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to send post-".$action." message to ".$email_address.". LM_Mailer responded: ".$mail->ErrorInfo."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
              }
            }
          }
        }

        if($mail->Mailer == "smtp") $mail->SmtpClose();

        return (($sent_msg) ? true : false);
      } else {
        return false;
      }
    } else {
      return false;
    }
  } else {
    return false;
  }
}

// Function will return the number of users is the specified group.
function users_count($id) {
  global $db;

  if($id) {
    $query  = "SELECT COUNT(*) AS `total` FROM `".TABLES_PREFIX."users` WHERE `group_id`='".$id."'";
    $result  = $db->GetRow($query);
    if($result) {
      return $result["total"];
    } else {
      return false;
    }
  } else {
    return false;
  }
}

// Function will remove all users in the specified group as well as their custom field data.
function users_delete($group_id) {
  global $db;

  if((int) $group_id) {
    $query  = "SELECT `users_id` FROM `".TABLES_PREFIX."users` WHERE `group_id`='".checkslashes($group_id)."'";
    $results  = $db->GetAll($query);
    if(($results) && (@count($results) > 0)) {
      $db->Execute("DELETE FROM `".TABLES_PREFIX."users` WHERE `users_id`=?", $results);
      $db->Execute("DELETE FROM `".TABLES_PREFIX."cdata` WHERE `user_id`=?", $results);
    }
    return true;
  } else {
    return false;
  }
}

// Function will remove all users in the users_array as well as their custom field data.
function users_delete_list($users_array) {
  global $db;

  if((@is_array($users_array)) && (@count($users_array) > 0)) {
    $total_rows = 0;
    foreach($users_array as $users_id) {
      $total_rows++;
      $db->Execute("DELETE FROM `".TABLES_PREFIX."users` WHERE `users_id`='".$users_id."'");
      $db->Execute("DELETE FROM `".TABLES_PREFIX."cdata` WHERE `user_id`='".$users_id."'");
    }
    $db->Execute("OPTIMIZE TABLE `".TABLES_PREFIX."users`, `".TABLES_PREFIX."cdata`");
    return $total_rows;
  } else {
    return false;
  }
}

// Function will move all users in $from_id, to $to_id.
function users_move($from_id, $to_id) {
  global $db;

  if(((int) $from_id) && ((int) $to_id)) {
    $query  = "SELECT `users_id`, `email_address` FROM `".TABLES_PREFIX."users` WHERE `group_id`='".checkslashes($from_id)."'";
    $results  = $db->GetAll($query);
    if($results) {
      foreach($results as $result) {
        $user_id  = $result["users_id"];

        $squery  = "SELECT `users_id` FROM `".TABLES_PREFIX."users` WHERE `group_id`='".checkslashes($to_id)."' AND `email_address`='".$result["email_address"]."'";
        $sresult  = $db->GetRow($squery);
        if(($sresult) && ((int) $user_id)) {
          $db->Execute("DELETE FROM `".TABLES_PREFIX."users` WHERE `users_id`='".$user_id."'");
          $db->Execute("DELETE FROM `".TABLES_PREFIX."cdata` WHERE `user_id`='".$user_id."'");
        }
      }
    }

    $query = "UPDATE `".TABLES_PREFIX."users` SET `group_id`='".$to_id."' WHERE `group_id`='".$from_id."'";
    return (($db->Execute($query)) ? true : false);
  } else {
    return false;
  }
}

// Function will queue the subscribe / unsubscribe confirmation queue including custom data to the groups provided.
function users_queue($email_address, $firstname, $lastname, $groups_array, $custom_data = array(), $queue_type = "adm-subscribe") {
  global $db;

  if(@count($groups_array) > 0) {
    $hash  = md5(uniqid(rand(), 1));
    $query  = "INSERT INTO `".TABLES_PREFIX."confirmation` VALUES (NULL, '".time()."', '".addslashes($queue_type)."', '".addslashes($_SERVER["REMOTE_ADDR"])."', '".addslashes($_SERVER["HTTP_REFERER"])."', '".addslashes($_SERVER["HTTP_USER_AGENT"])."', ".$db->qstr($email_address).", ".$db->qstr($firstname).", ".$db->qstr($lastname).", '".addslashes(serialize($groups_array))."', '".addslashes(serialize($custom_data))."', '".$hash."', '0');";
    if($db->Execute($query)) {
      return array("confirm_id" => $db->Insert_Id(), "hash" => $hash);
    } else {
      if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
        @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to insert subscriber into the confirmation queue. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
      }
      return false;
    }
  } else {
    if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
      @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tThere were no groups provided to the users_queue function.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
    }
    return false;
  }
}

// Function will remove the subscriber including custom data from the groups provided.
function subscriber_remove($subscriber_ids, $called_from = "private", $send_post_unsubscribe_message = true) {
  global $db, $config;

  $int_config = (($called_from == "public") ? ((is_array($config)) ? $config : false) : (((isset($_SESSION["config"])) && (isset($_SESSION["isAuthenticated"]))) ? $_SESSION["config"] : false));
  $success    = 0;
  if(($int_config) && (@is_array($subscriber_ids)) && (@count($subscriber_ids) > 0)) {
    // Send Post Unsubscribe Messages first because if you send them after, you won't have any of the information ;)
    if(($int_config[PREF_POSTUNSUBSCRIBE_MSG]) && ($send_post_unsubscribe_message)) {
      if(!send_post_action_message("unsubscribe", $subscriber_ids, $int_config)) {
        if($int_config[PREF_ERROR_LOGGING] == "yes") {
          @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to send new subscriber the post-subscribe message.\n", 3, $int_config[PREF_PRIVATE_PATH]."logs/error_log.txt");
        }
      }
    }

    foreach($subscriber_ids as $subscriber_id) {
      $query = "DELETE FROM `".TABLES_PREFIX."users` WHERE `users_id`=".$db->qstr($subscriber_id, get_magic_quotes_gpc());
      if($db->Execute($query)) {
        $success++;
        $query = "DELETE FROM `".TABLES_PREFIX."cdata` WHERE `user_id`=".$db->qstr($subscriber_id, get_magic_quotes_gpc());
        if(!$db->Execute($query)) {
          if($int_config[PREF_ERROR_LOGGING] == "yes") {
            @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete custom field data for subscriber id [".$subscriber_id."]. Database server said: ".$db->ErrorMsg()."\n", 3, $int_config[PREF_PRIVATE_PATH]."logs/error_log.txt");
          }
        }
      } else {
        $failed++;
        if($int_config[PREF_ERROR_LOGGING] == "yes") {
          @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete subscriber id [".$subscriber_id."] from the users table. Database server said: ".$db->ErrorMsg()."\n", 3, $int_config[PREF_PRIVATE_PATH]."logs/error_log.txt");
        }
      }
    }

    return true;
  } else {
    if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
      @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tThere were no groups provided to the users_add function.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
    }
    return false;
  }
}

/**
 * This is the default HTML used to generate a CAPTCHA image.
 * If you want to modify this go ahead, or you can just modify the output.
 *
 * @param string $url
 * @return string
 */
function generate_captcha_html($url = "") {
  $html  = "<tr>\n";
  $html .= "  <td rowspan=\"2\" style=\"vertical-align: top\">\n";
  $html .= "    <label for=\"captcha_code\">Security Code:</label>\n";
  $html .= "  </td>\n";
  $html .= "  <td>\n";
  $html .= "    <input type=\"text\" id=\"captcha_code\" name=\"captcha_code\" value=\"\" />\n";
  $html .= "  </td>\n";
  $html .= "</tr>\n";
  $html .= "<tr>\n";
  $html .= "  <td style=\"padding-bottom: 15px\">\n";
  $html .= "    <img src=\"".(($url) ? $url : "%URL%")."?action=captcha&r=".substr(md5(uniqid(rand(), 1)), 0, 10)."\" width=\"172\" height=\"45\" alt=\"CAPTCHA Image\" title=\"CAPTCHA Image\" />\n";
  $html .= "  </td>\n";
  $html .= "</tr>\n";

  return $html;
}

// Function will generate the proper HTML to display custom form field. If you want it to output the HTML, then set $output to html.
function generate_cfields($action = "", $output = "display", $cfields_id = 0) {
  global $db;

  $html = "";

  if((int) $cfields_id) {
    $query  = "SELECT * FROM `".TABLES_PREFIX."cfields` WHERE `cfields_id` = ".$db->qstr((int) $cfields_id)." ORDER BY `field_order` ASC";
  } else {
    $query  = "SELECT * FROM `".TABLES_PREFIX."cfields` ORDER BY `field_order` ASC";
  }
  $results  = $db->GetAll($query);

  $html .= "<form".(($action != "") ? " action=\"".$action."\"" : "")." method=\"post\">\n";
  $html .= "<input type=\"hidden\" name=\"group_ids[]\" value=\"ENTER_GROUP_ID_HERE\" />\n";
  $html .= "<table style=\"width: 100%\" cellspacing=\"0\" cellpadding=\"1\" border=\"0\">\n";
  $html .= "<tbody>\n";
  if(!(int) $cfields_id) {
    $html .= "\t<tr>\n";
    $html .= "\t\t<td style=\"color: #CC0000\"><label for=\"email_address\">E-Mail Address:</label></td>\n";
    $html .= "\t\t<td><input type=\"text\" id=\"email_address\" name=\"email_address\" value=\"\" maxlength=\"128\" /></td>\n";
    $html .= "\t</tr>\n";
    $html .= "\t<tr>\n";
    $html .= "\t\t<td><label for=\"firstname\">Firstname:</label></td>\n";
    $html .= "\t\t<td><input type=\"text\" id=\"firstname\" name=\"firstname\" value=\"\" maxlength=\"32\" /></td>\n";
    $html .= "\t</tr>\n";
    $html .= "\t<tr>\n";
    $html .= "\t\t<td><label for=\"lastname\">Lastname:</label></td>\n";
    $html .= "\t\t<td><input type=\"text\" id=\"lastname\" name=\"lastname\" value=\"\" maxlength=\"32\" /></td>\n";
    $html .= "\t</tr>\n";
  }
  if($results) {
    foreach($results as $result) {
      if($result["field_type"] == "linebreak") {
        $html .= "\t<tr>\n";
        $html .= "\t\t<td colspan=\"2\">&nbsp;</td>\n";
        $html .= "\t</tr>\n";
      } else {
        $html .= "\t<tr>\n";
        $html .= "\t\t<td style=\"vertical-align: top".(($result["field_req"] == 1) ? "; color: #CC0000" : "")."\">".html_encode($result["field_lname"])."</td>\n";
        $html .= "\t\t<td>\n";
        switch($result["field_type"]) {
          case "textbox" :
            $html .= "\t\t\t<input type=\"text\" id=\"".html_encode($result["field_sname"])."\" name=\"".html_encode($result["field_sname"])."\" value=\"\"".(((int) $result["field_length"]) ? " maxlength=\"".$result["field_length"]."\"" : "")." />\n";
          break;
          case "textarea" :
            $html .= "\t\t\t<textarea id=\"".html_encode($result["field_sname"])."\" name=\"".html_encode($result["field_sname"])."\"></textarea>\n";
          break;
          case "select" :
            if($result["field_options"] != "") {
              $options = explode("\n", $result["field_options"]);
              $html .= "\t\t\t<select id=\"".html_encode($result["field_sname"])."\" name=\"".html_encode($result["field_sname"])."\">\n";
              foreach($options as $option) {
                $pieces = explode("=", $option);
                $html .= "\t\t\t<option value=\"".html_encode($pieces[0])."\">".html_encode($pieces[1])."</option>\n";
              }
              $html .= "\t\t\t</select>\n";
            }
          break;
          case "hidden" :
            $html .= "\t\t\t<input type=\"hidden\" name=\"".html_encode($result["field_sname"])."\" value=\"".html_encode($result["field_options"])."\" />\n";
          break;
          case "checkbox" :
            if($result["field_options"] != "") {
              $options = explode("\n", $result["field_options"]);
              foreach($options as $key => $option) {
                $pieces = explode("=", $option);
                $html .= "\t\t\t<input type=\"checkbox\" id=\"".html_encode($result["field_sname"])."_".$key."\" name=\"".html_encode($result["field_sname"])."[]\" value=\"".html_encode($pieces[0])."\"> <label for=\"".html_encode($result["field_sname"])."_".$key."\">".html_encode($pieces[1])."</label><br />\n";
              }
            }
          break;
          case "radio" :
            if($result["field_options"] != "") {
              $options = explode("\n", $result["field_options"]);
              foreach($options as $key => $option) {
                $pieces = explode("=", $option);
                $html .= "\t\t\t<input type=\"radio\" id=\"".html_encode($result["field_sname"])."_".$key."\" name=\"".html_encode($result["field_sname"])."\" value=\"".html_encode($pieces[0])."\"> <label for=\"".html_encode($result["field_sname"])."_".$key."\">".html_encode($pieces[1])."</label><br />\n";
              }
            }
          break;
          default :
            $html .= "&nbsp;";
          break;
        }
        $html .= "\t</td>\n";
        $html .= "</tr>\n";
      }
    }
  }
  if(!(int) $cfields_id) {
    if($_SESSION["config"][ENDUSER_CAPTCHA] == "yes") {
      $html .= generate_captcha_html($_SESSION["config"][PREF_PUBLIC_URL].$_SESSION["config"][ENDUSER_FILENAME]);
    }
    $html .= "\t<tr>\n";
    $html .= "\t\t<td style=\"color: #CC0000\"><label for=\"action\">Subscriber Action:</label></td>\n";
    $html .= "\t\t<td>\n";
    $html .= "\t\t\t<select id=\"action\" name=\"action\">\n";
    $html .= "\t\t\t<option value=\"subscribe\">Subscribe</option>\n";
    $html .= "\t\t\t<option value=\"unsubscribe\">Unsubscribe</option>\n";
    $html .= "\t\t\t</select>\n";
    $html .= "\t\t</td>\n";
    $html .= "\t</tr>\n";
    $html .= "\t<tr>\n";
    $html .= "\t\t<td colspan=\"2\" style=\"text-align: right\">\n";
    $html .= "\t\t\t<input type=\"submit\" value=\"Submit\" />\n";
    $html .= "\t\t</td>\n";
    $html .= "\t</tr>\n";
  }
  $html .= "</tbody>\n";
  $html .= "</table>\n";
  $html .= "</form>\n";

  return (($output == "html") ? html_encode($html) : $html);
}

// Function will return a human readable friendly filesize.
function readable_size($bytes) {
  $kb = 1024;      // Kilobyte
  $mb = 1048576;      // Megabyte
  $gb = 1073741824;    // Gigabyte
  $tb = 1099511627776;  // Terabyte

  if($bytes < $kb) {
    return $bytes." b";
  } else if($bytes < $mb) {
    return round($bytes/$kb, 2)." KB";
  } else if($size < $gb) {
    return round($bytes/$mb, 2)." MB";
  } else if($size < $tb) {
    return round($bytes/$gb, 2)." GB";
  } else {
    return round($bytes/$tb, 2)." TB";
  }
}

// Function will return in bytes the values used in php.ini
function return_bytes($string) {
  $string  = trim($string);
  $last  = strtolower($string{strlen($string)-1});

  switch($last) {
    case "g":
      $string *= 1024;
    case "m":
      $string *= 1024;
    case "k":
      $string *= 1024;
    break;
  }

  return $string;
}

// Function will return an unicode character into an HTML special character.
function uc2html($character) {
  $output  = "";
  for($i = 0; $i < (strlen($character) / 2); $i++) {
    $charcode   = (ord($character[($i * 2)]) + 256 * ord($character[($i * 2 + 1)]));
    $output  .= "&#".$charcode;
  }

  return $output;
}

// Function will process the data and get what you need from the string.
function get_data($tag_name, $contents) {
  unset($num, $s, $e, $exp, $data);
  $num    = strlen($tag_name);
  $s    = ($num + 2);
  $e    = ($num - (($num * 2) + 3));
  $exp    = "/\[".$tag_name."\](.*)\[\/".$tag_name."\]/si";
  $data  = preg_match($exp, $contents, $matches);
  $data  = substr($matches[0], $s, $e);
  $data  = trim($data);
  $data  = explode("\n", $data);

  return $data;
}

// Function will add the variable wrapper to the variable.
function variable_wrapper(&$string) {
  $string = "[".$string."]";
}

// Function will add the variable wrapper to the variable.
function example_wrapper(&$string) {
  $string = "(Sample".(($string != "") ? ": ".$string : "").")";
}

// Function will return a formated unsubscribe link for the user.
function unsubscribe_link($type, $email_address = "") {
  return $email_address;
}

// Function will wrap the template code around the string and return the output.
function insert_template($type, $template_id, $string) {
  global $db;
  if($template_id) {
    $query  = "SELECT `template_content` from `".TABLES_PREFIX."templates` WHERE `template_type`='".checkslashes($type)."' AND `template_id`='".checkslashes($template_id)."'";
    $result  = $db->GetRow($query);
    if($result) {
      return str_replace("[message]", $string, $result["template_content"]);
    } else {
      return $string;
    }
  } else {
    return $string;
  }
}

/**
 * Function will return the custom field ID of the custom field short name.
 *
 * @param string $field_sname
 * @return int
 */
function get_field_id($field_sname = "") {
  global $db;

  if(trim($field_sname)) {
    $query  = "SELECT `cfields_id` FROM `".TABLES_PREFIX."cfields` WHERE `field_sname` = '".checkslashes(trim($field_sname))."'";
    $result  = $db->GetRow($query);
    if($result) {
      return (int) $result["cfields_id"];
    }
  }
  return 0;
}

/**
 * Function will retreive customized data for a specific e-mail address and return an array.
 *
 * @param int $users_id
 * @param array $external_custom_data
 * @param string $called_from
 * @return array
 */
function get_custom_data($users_id = 0, $external_custom_data = array(), $called_from = "private") {
  global $db, $config;

  $int_config = (($called_from == "public") ? ((is_array($config)) ? $config : false) : (((isset($_SESSION["config"])) && (isset($_SESSION["isAuthenticated"]))) ? $_SESSION["config"] : false));

  if(($int_config) && ($users_id = (int) $users_id)) {
    $subscriber  = array();
    $query    = "
          SELECT *, CONCAT_WS(' ', `firstname`, `lastname`) as `fullname`
          FROM `".TABLES_PREFIX."users`
          WHERE `users_id` = ".$db->qstr($users_id);
    $result    = $db->GetRow($query);
    if($result) {
      $subscriber["name"]      = $result["fullname"];
      $subscriber["firstname"]  = $result["firstname"];
      $subscriber["lastname"]    = $result["lastname"];
      $subscriber["email"]    = $result["email_address"];
      $subscriber["date"]      = display_date($int_config[PREF_DATEFORMAT], (((is_array($external_custom_data)) && (isset($external_custom_data["date"]))) ? $external_custom_data["date"] : time()));
      $subscriber["groupname"]  = groups_information(array($result["group_id"]), true);
      $subscriber["groupid"]    = $result["group_id"];
      $subscriber["messageid"]  = (((is_array($external_custom_data)) && (isset($external_custom_data["messageid"]))) ? $external_custom_data["messageid"] : 0);
      $subscriber["userid"]    = $result["users_id"];
      $subscriber["profileurl"]  = $int_config[PREF_PUBLIC_URL].$int_config[ENDUSER_PROFILE_FILENAME]."?addr=".rawurlencode($result["email_address"]);
      $subscriber["signupdate"]  = display_date($int_config[PREF_DATEFORMAT], $result["signup_date"]);

      $squery    = "
            SELECT `field_sname`, `value`
            FROM `".TABLES_PREFIX."cdata`
            LEFT JOIN `".TABLES_PREFIX."cfields`
              ON `".TABLES_PREFIX."cdata`.`cfield_id` = `".TABLES_PREFIX."cfields`.`cfields_id`
            WHERE `user_id` = ".$db->qstr((int) $result["users_id"])."
            ORDER BY `field_order` ASC";
      $sresults  = $db->GetAll($squery);
      if($sresults) {
        foreach($sresults as $sresult) {
          /**
           * Special custom field variables.
           */
          if(trim($sresult["value"])) {
            switch($sresult["field_sname"]) {
              case "firstname_suffix" :
                $subscriber["firstname"] .= " ".trim($sresult["value"]);
                $subscriber["name"]      = $subscriber["firstname"]." ".$subscriber["lastname"];
              break;
              case "firstname_prefix" :
                $subscriber["firstname"] = trim($sresult["value"])." ".$subscriber["firstname"];
                $subscriber["name"]     = $subscriber["firstname"]." ".$subscriber["lastname"];
              break;
              case "lastname_suffix" :
                $subscriber["lastname"] .= " ".trim($sresult["value"]);
                $subscriber["name"]    .= " ".trim($sresult["value"]);
              break;
              case "lastname_prefix" :
                $subscriber["lastname"]  = trim($sresult["value"])." ".$subscriber["lastname"];
                $subscriber["name"]    = $subscriber["firstname"]." ".$subscriber["lastname"];
              break;
              default :
                continue;
              break;
            }
          }

          $subscriber[$sresult["field_sname"]] = $sresult["value"];
        }
      }

      return $subscriber;
    }
  }

  return false;
}

// Function will replace the string with customized data to the user.
function custom_data($user_data, $string, $details = array()) {
  global $db, $RESERVED_VARIABLES;

  $values        = array();
  $extras_key      = array();
  $extras_val      = array();
  $arranged_search  = array();
  $arranged_replace  = array();

  if(((!$user_data) || (!@is_array($user_data))) && (valid_address($details["email_address"]))) {
    $values["name"]      = "Jane Doe";
    $values["firstname"]  = "Jane";
    $values["lastname"]    = "Doe";
    $values["email"]    = $details["email_address"];
    $values["date"]      = display_date($_SESSION["config"][PREF_DATEFORMAT], time());
    $values["groupname"]  = "Newsletter 101";
    $values["groupid"]    = "6";
    $values["userid"]    = "789";
    $values["messageid"]  = (((isset($_SESSION["message_details"]["message_id"])) && ((int) $_SESSION["message_details"]["message_id"])) ? $_SESSION["message_details"]["message_id"] : 0);
    $values["profileurl"]  = $_SESSION["config"][PREF_PUBLIC_URL].$_SESSION["config"][ENDUSER_PROFILE_FILENAME]."?addr=".rawurlencode($details["email_address"]);
    $values["signupdate"]  = display_date($_SESSION["config"][PREF_DATEFORMAT], ($details["date"]-(172800)));
  } elseif(@is_array($user_data)) {
    $values["name"]      = $user_data["name"];
    $values["firstname"]  = $user_data["firstname"];
    $values["lastname"]    = $user_data["lastname"];
    $values["email"]    = $user_data["email"];
    $values["date"]      = $user_data["date"];
    $values["groupname"]  = $user_data["groupname"];
    $values["groupid"]    = $user_data["groupid"];
    $values["userid"]    = $user_data["userid"];
    $values["messageid"]  = $user_data["messageid"];
    $values["profileurl"]  = $user_data["profileurl"];
    $values["signupdate"]  = $user_data["signupdate"];
  }

  $query    = "SELECT `field_sname` FROM `".TABLES_PREFIX."cfields` WHERE `field_sname`<>'' ORDER BY `field_order` ASC";
  $results  = $db->GetAll($query);
  if($results) {
    for($i = 0; $i < @count($results); $i++) {
      $extras_key[$i]                = $results[$i]["field_sname"];
      $extras_val[$results[$i]["field_sname"]]  = $user_data[$results[$i]["field_sname"]];
    }
  }

  $search    = array_merge($RESERVED_VARIABLES, $extras_key);
  $replace  = array_merge($values, $extras_val);

  if(!$user_data) {
    array_walk($replace, "example_wrapper");
  }

  for($i = 0; $i < count($search); $i++) {
    $arranged_search[$i]  = $search[$i];
    $arranged_replace[$i]  = $replace[$search[$i]];
  }
  array_walk($arranged_search, "variable_wrapper");

  return str_replace($arranged_search, $arranged_replace, $string);
}

// Function will return the properly formatted, ready-to-go Automated Unsubscribe Message.
function unsubscribe_message($string, $type = "text", $use_groupid = false, $called_from = "private") {
  global $config, $language_pack;

  $int_config = (($called_from == "public") ? ((is_array($config)) ? $config : false) : (((isset($_SESSION["config"])) && (isset($_SESSION["isAuthenticated"]))) ? $_SESSION["config"] : false));

  if($int_config) {
    if(($int_config[PREF_ADD_UNSUB_LINK] == "yes") || (strpos($string, "[unsubscribe]"))) {
      if((!is_array($language_pack)) || ((is_array($language_pack)) && (!@count($language_pack)))) {
        if(@file_exists($int_config[PREF_PUBLIC_PATH]."languages/".$int_config[ENDUSER_LANG_ID].".lang.php")) {
          require_once($int_config[PREF_PUBLIC_PATH]."languages/".$int_config[ENDUSER_LANG_ID].".lang.php");
        } elseif(@file_exists($int_config[PREF_PUBLIC_PATH]."languages/english.lang.php")) {
          require_once($int_config[PREF_PUBLIC_PATH]."languages/english.lang.php");
        }
      }

      if(($language_pack["unsubscribe_message"]) && ($language_pack["unsubscribe_message"] != "")) {
        $unsubscribe_message = $language_pack["unsubscribe_message"];
      } else {
        $unsubscribe_message = "Please click the following link to unsubscribe: [unsubscribe_url]";
      }

      $unsubscribe_url  = $int_config[PREF_PUBLIC_URL].$int_config[ENDUSER_UNSUB_FILENAME]."?".(($use_groupid) ? "g=[groupid]&" : "")."addr=[email]";
      $unsubscribe_url  = (($type == "html") ? "<a href=\"".$unsubscribe_url."\">".$unsubscribe_url."</a>" : $unsubscribe_url);
      if(strpos($string, "[unsubscribe]")) {
        $string  = str_replace("[unsubscribe]", (($type == "html") ? nl2br($unsubscribe_message) : $unsubscribe_message), $string);
        $string  = str_replace("[unsubscribe_url]", $unsubscribe_url, $string);
      } else {
        $message  = "\n\n".str_replace("[unsubscribe_url]", $unsubscribe_url, $unsubscribe_message);
        $string  = $string.(($type == "html") ? nl2br($message) : $message);
      }
    }
  }
  return $string;
}

// Function will return a properly formatted variable name.
function variable_name($var_name) {
  return strtolower(preg_replace("/[^a-z0-9_\-]/i", "_", $var_name));
}

// Function will check to ensure that the variable name used is unique and format it properly.
function check_variable($variable_name, $is_edit = false) {
  global $db, $RESERVED_VARIABLES;

  $variable_name = variable_name($variable_name);

  if(@in_array($variable_name, $RESERVED_VARIABLES)) {
    return array(false, "The &quot;Field Short Name&quot; that you've used is a reserved word, please use a different field short name.");
  } else {
    if(!$is_edit) {
      $query  = "SELECT `field_sname` FROM `".TABLES_PREFIX."cfields` WHERE `field_sname`='".checkslashes($variable_name)."'";
      $result  = $db->GetRow($query);
      if($result) {
        return array(false, "The &quot;Field Short Name&quot; that you've used is already in use, please use a unique field short name.");
      }
    }
  }
  return array(true, $variable_name);
}

/**
 * Function will return a nice English formatted action for the subscriber history.
 *
 * @param string $action
 * @return string
 */
function display_action($action) {
  switch($action) {
    case "adm-import" :
      return "Administrator Imported";
    break;
    case "adm-subscribe" :
      return "Administrator Subscribed";
    break;
    case "adm-unsubscribe" :
      return "Administrator Unsubscribed";
    break;
    case "usr-subscribe" :
      return "Self Subscribed";
    break;
    case "usr-unsubscribe" :
      return "Self Unsubscribed";
    break;
  }
}

/**
 * Function will return a properly formatted filename.
 *
 * @param string $filename
 * @return string
 */
function valid_filename($filename) {
  return strtolower(preg_replace("/[^a-z0-9_\-\.]/i", "_", $filename));
}

/**
 * Function will return the number of times the provided template is in use.
 *
 * @param int $template_id
 * @param bool $return_list
 * @return string
 */
function template_count($template_id, $return_list = true) {
  global $db;

  $output  = "";
  $query  = "SELECT `message_id`, `message_title` FROM `".TABLES_PREFIX."messages` WHERE `text_template`='".$template_id."' OR `html_template`='".$template_id."' ORDER BY `message_title` ASC";
  $results  = $db->GetAll($query);
  if($results) {
    foreach($results as $result) {
      $output .= "- <a href=\"index.php?section=message&action=view&id=".$result["message_id"]."\" style=\"font-weight: normal\">".$result["message_title"]."</a><br />";
    }
    return "<a href=\"#\" onclick=\"return makeTrue(domTT_activate(this, event, 'caption', 'Used In', 'content', 'This template is being used within the following messages:<br />".addslashes(html_encode($output))."'));\" class=\"cursor-help\" style=\"font-size: 12px\">".@count($results)."</a>";
  } else {
    return "0";
  }
}

/**
 * Function will return the name of the provided template id.
 *
 * @param int $template_id
 * @return string
 */
function template_name($template_id) {
  global $db;

  $output  = "";
  $query  = "SELECT `template_name` FROM `".TABLES_PREFIX."templates` WHERE `template_id`='".checkslashes($template_id)."'";
  $result  = $db->GetRow($query);
  if($result) {
    return $result["template_name"];
  } else {
    return "-Unknown Template-";
  }
}

/**
 * Function will display the date in the timezone provided by the user.
 *
 * @param string $format
 * @param int $timestamp
 * @param bool $session_available
 * @return string
 */
function display_date($format, $timestamp, $session_available = true) {
  global $config;

  $timezone  = (($session_available) ? $_SESSION["config"][PREF_TIMEZONE] : $config[PREF_TIMEZONE]);
  $daylight  = (($session_available) ? $_SESSION["config"][PREF_DAYLIGHT_SAVINGS] : $config[PREF_DAYLIGHT_SAVINGS]);
  $timestamp  = ($timestamp + ($timezone * 3600));

  return gmdate($format, ((($daylight == "yes") && (date("I", $timestamp))) ? ($timestamp + 3600) : $timestamp));
}

/**
 * Function will set the starting element of the XML data.
 *
 * @param string $parser
 * @param string $name
 * @param string $attrs
 */
function backup_stag($parser, $name, $attrs) {
  global $backup;

  $tag = array("name" => strtolower($name), "attributes" => $attrs);
  array_push($backup, $tag);
}

/**
 * Function will set the result set from the XML data.
 *
 * @param string $parser
 * @param string $cdata
 */
function backup_data($parser, $cdata) {
  global $backup;

  if(trim($cdata) != "") {
    if(isset($backup[count($backup) - 1]["result"])) {
      $backup[count($backup) - 1]["result"] .= trim($cdata);
    } else {
      $backup[count($backup) - 1]["result"] = trim($cdata);
    }
  }
}

/**
 * Function will set the ending element of the XML data.
 *
 * @param string $parser
 * @param string $name
 */

function backup_etag($parser, $name) {
  global $backup;

  $backup[(count($backup) - 2)]["tables"][] = $backup[(count($backup) - 1)];
  array_pop($backup);
}

/**
 * Function will take an array and create a CSV row out of it.
 *
 * @param string $fields
 * @param string $enclosed
 * @param string $delimited
 * @return string
 */
function csv_record($fields, $enclosed = "\"", $delimited = ",") {
  $row  = array();
  if(@is_array($fields)) {
    foreach($fields as $field) {
      $enclose  = false;
      if(stristr($field, $enclosed)) {
        $enclose  = true;
        $field  = str_replace($enclosed, $enclosed.$enclosed, $field);
      }
      if(stristr($field, $delimited)) {
        $enclose  = true;
      }
      if($enclose) {
        $field  = $enclosed.$field.$enclosed;
      }
      $row[]  = $field;
    }
  }
  return implode($delimited, $row);
}

/**
 * Function is responsible for sending notifications to administrator.
 *
 * @param string $notice_type
 * @param array $information
 * @return bool
 */
function send_notice($notice_type, $information) {
  global $config, $db, $language_pack, $LM_PATH;

  if((isset($information["email_address"])) && (@is_array($information["groups"]))) {
    @ini_set("sendmail_from", $config[PREF_ERREMAL_ID]);
    $group_list  = array();

    foreach($information["groups"] as $group_id) {
      $group_list[]  = groups_information($group_id, true);
    }

    $mail = new LM_Mailer("public");
    $mail->AddAddress($config[PREF_NOTEMAL_ID], $config[PREF_FRMNAME_ID]);

    switch($notice_type) {
      case "subscribe" :
        $mail->Subject  = $language_pack["subscribe_notification_subject"];
        $mail->Body    = str_replace(array("[firstname]", "[lastname]", "[email_address]", "[group_ids]"), array($information["firstname"], $information["lastname"], $information["email_address"], "\t- ".implode("\n\t- ", $group_list)), $language_pack["subscribe_notification_message"]);
      break;
      case "unsubscribe" :
        $mail->Subject  = $language_pack["unsubscribe_notification_subject"];
        $mail->Body    = str_replace(array("[firstname]", "[lastname]", "[email_address]", "[group_ids]"), array($information["firstname"], $information["lastname"], $information["email_address"], "\t- ".implode("\n\t- ", $group_list)), $language_pack["unsubscribe_notification_message"]);
      break;
      default :
        return false;

        if($config[PREF_ERROR_LOGGING] == "yes") {
          @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to determine notice type to send to administrator.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
        }
      break;
    }

    if((!@$mail->IsError()) && (@$mail->Send())) {
      return true;
    } else {
      return false;

      if($config[PREF_ERROR_LOGGING] == "yes") {
        @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to notice to administrator. LM_Mailer responded: ".$mail->ErrorInfo."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
      }
    }

    if($mail->Mailer == "smtp") $mail->SmtpClose();

    $mail->ClearCustomHeaders();
  } else {
    if($config[PREF_ERROR_LOGGING] == "yes") {
      @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tEither the e-mail address or the group information was not set to be able to send a notice to the administrator.\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
    }

    return false;
  }
}

/**
 * Function will hex encode an e-mail address and optionally text. Credits to Monte Ohrt and Jason Sweat.
 *
 * @param string $address
 * @param string $text
 * @return string
 */
function encode_address($address, $text = "") {
  $address_encode  = "";
  $text_encode    = "";
  $text      = ((trim($text) == "") ? str_replace("@", " at ", $address) : $text);

  preg_match("!^(.*)(\?.*)$!", $address, $match);
  if(!empty($match[2])) {
    return array("address" => $address, "text" => $text);
  }
  for ($x = 0; $x < strlen($address); $x++) {
    if(preg_match("!\w!", $address[$x])) {
      $address_encode .= "%".bin2hex($address[$x]);
    } else {
      $address_encode .= $address[$x];
    }
  }

  for ($x = 0; $x < strlen($text); $x++) {
    $text_encode .= "&#x".bin2hex($text[$x]).";";
  }

  return array("address" => $address_encode, "text" => $text_encode);
}

/**
 * Function checks to see if the trip has been activiated.
 *
 * @return true
 */
function check_trip() {
  global $TRIP;

  if($TRIP) {
    require_once("classes/talkback/class.talkback.php");

    $talk        = array();
    $talk["current_version"]  = VERSION_INFO;
    $talk["version_type"]  = VERSION_TYPE;
    $talk["host_name"]    = $_SERVER["HTTP_HOST"];
    $talk["directory_path"]  = dirname(__FILE__);
    $talk["directory_url"]  = $_SERVER["PHP_SELF"];
    $talk["email_addr"]    = $_SESSION["config"][REG_EMAIL];
    $talk["domain_name"]  = $_SESSION["config"][REG_DOMAIN];
    $talk["serial_number"]  = $_SESSION["config"][REG_SERIAL];
    $talk["timestamp"]    = time();

    $talkback  = new TalkBack("trip", $talk);
    $send  = @$talkback->post();

    return true;
  }
}

/**
 * Function takes care of general maintenance within ListMessenger once per session.
 *
 * @param bool $skip
 * @return bool
 */
function perform_maintenance($skip = false) {
  global $TRIP, $db;

  if($skip) {
    return true;
  } else {
    if((isset($_SESSION["isAuthenticated"])) && ((bool) $_SESSION["isAuthenticated"])) {
      if($_SESSION["config"][ENDUSER_SUBCON] == "yes") {
        if($_SESSION["config"][MAINTENANCE_PERFORMED] < (time() - 86400)) {
          $expiration  = (int) (time() - ($_SESSION["config"][PREF_EXPIRE_CONFIRM] * 86400));

          $query    = "DELETE FROM `".TABLES_PREFIX."confirmation` WHERE (`action`='usr-subscribe' OR `action`='usr-unsubscribe') AND `confirmed`='0' AND `date`<'".$expiration."'";
          @$db->Execute($query);

          $query    = "DELETE FROM `".TABLES_PREFIX."user_updates` WHERE `date`<'".$expiration."'";
          @$db->Execute($query);

          $query    = "OPTIMIZE TABLE `".TABLES_PREFIX."confirmation`, `".TABLES_PREFIX."user_updates`, `".TABLES_PREFIX."sending`";
          @$db->Execute($query);

          $timestamp  = time();
          $query    = "UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='".$timestamp."' WHERE `preference_id`='".MAINTENANCE_PERFORMED."'";
          $result    = @$db->Execute($query);
          if((!$result) || (!$db->Affected_Rows())) {
            if($config[PREF_ERROR_LOGGING] == "yes") {
              @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to update last maintenance run preference. Database server said: ".$db->ErrorMsg()."\n", 3, $config[PREF_PRIVATE_PATH]."logs/error_log.txt");
            }
          }

          if(@function_exists("fsockopen")) check_trip();

          $_SESSION["config"][MAINTENANCE_PERFORMED]  = $timestamp;
          $_SESSION["doneMaintenance"]        = true;

          return true;
        }
      } else {
        return true;
      }
    } else {
      return true;
    }
  }
}

/**
 * Function will encode html with it's special character representation.
 *
 * @param string $string
 * @return html encoded string.
 */
function html_encode($string) {
  return htmlentities($string, ENT_QUOTES, (($_SESSION["config"][PREF_DEFAULT_CHARSET] != "") ? $_SESSION["config"][PREF_DEFAULT_CHARSET] : "ISO-8859-1"));
}

/**
 * Function will decode the encoded HTML special characters.
 *
 * @param string $string
 * @return html decoded string.
 */
function html_decode($string) {
  if(version_compare(phpversion(), "4.3.0", ">")) {
    return html_entity_decode($string, ENT_QUOTES, (($_SESSION["config"][PREF_DEFAULT_CHARSET] != "") ? $_SESSION["config"][PREF_DEFAULT_CHARSET] : "ISO-8859-1"));
  } else {
    $htmltable = get_html_translation_table(HTML_ENTITIES);
    foreach($htmltable as $key => $value) {
      $string = ereg_replace(addslashes($value), $key, $string);
    }

    return $string;
  }
}

/**
 * This function is for PHP 4.1 users who do not have the ob_flush() function.
 */
if(!function_exists("ob_flush")) {
  function ob_flush() {
    return;
  }
}

/**
 * Function will perform 2.0+ version upgrades.
 *
 * @param string $old_version
 */
function minor_version_upgrade($old_version) {
  global $db, $ERROR, $ERRORSTR, $SUCCESS, $SUCCESSSTR;

  switch($old_version) {
    case "2.0.0" :
      $query = "DROP TABLE `".TABLES_PREFIX."sending`";
      if($db->Execute($query)) {
        $query = "CREATE TABLE `".TABLES_PREFIX."sending` (`sending_id` int(12) NOT NULL auto_increment, `email_address` varchar(128) NOT NULL default '', `users_id` int(12) NOT NULL default '0', `queue_id` int(12) NOT NULL default '0', `sent` tinyint(1) NOT NULL default '0', PRIMARY KEY  (`sending_id`)) TYPE=MyISAM AUTO_INCREMENT=1;";
        if($db->Execute($query)) {
          $query = "UPDATE `".TABLES_PREFIX."preferences` SET `preference_value`='2.0.1' WHERE `preference_id`='".PREF_VERSION."';";
          if($db->Execute($query)) {
            if(!reload_configuration()) {
              $ERROR++;
              $ERRORSTR[] = "Unable to reload your configuration into your session. Please restart your web-browser to reload session data.";
            } else {
              minor_version_upgrade("2.0.1");
            }
          } else {
            $ERROR++;
            $ERRORSTR[] = "Unable to set the ListMessenger version number to ".VERSION_INFO." in the ListMessenger database. Please seek technical assistance in the forum: <a>http://forum.listmessenger.com</a>";
          }
        } else {
          $ERROR++;
          $ERRORSTR[] = "Unable to create the new ListMessenger sending table. Please restore the &quot;sending&quot; table from a backup or seek technical assistance in the forum: <a>http://forum.listmessenger.com</a>";
        }
      } else {
        $ERROR++;
        $ERRORSTR[] = "Unable to &quot;DROP&quot; the ListMessenger 2.0.0 sending table; therefore, the installer is unable to apply the required changes to the sending table. Does your MySQL user have drop permissions?";
      }
    break;
    case "2.0.1" :
    case "2.0.2" :
      $query = "CREATE TABLE `".TABLES_PREFIX."user_updates` (`updates_id` int(12) NOT NULL auto_increment, `hash` varchar(32) NOT NULL default '', `date` bigint(64) NOT NULL default '0', `email_address` varchar(128) NOT NULL default '0', `completed` int(1) NOT NULL default '0', PRIMARY KEY (`updates_id`), UNIQUE KEY `hash` (`hash`)) TYPE=MyISAM AUTO_INCREMENT=1;";
      if($db->Execute($query)) {
        $query = "CREATE TABLE `".TABLES_PREFIX."sessions` (`sesskey` VARCHAR( 64 ) NOT NULL DEFAULT '', `expiry` TIMESTAMP NOT NULL, `expireref` VARCHAR( 250 ) DEFAULT '', `created` TIMESTAMP NOT NULL, `modified` TIMESTAMP NOT NULL, `sessdata` LONGTEXT DEFAULT '', PRIMARY KEY (`sesskey`), INDEX sess2_expiry(`expiry`), INDEX sess2_expireref(`expireref`)) TYPE=MyISAM;";
        if($db->Execute($query)) {
          $query  = "INSERT INTO `".TABLES_PREFIX."preferences` (`preference_id`, `preference_value`) VALUES (54, '0'), (55, '0'), (56, 'no'), (57, 'profile.php'), (58, 'no'), (59, 'no'), (60, ''), (61, 'yes')";
          if($db->Execute($query)) {
            if($db->AutoExecute(TABLES_PREFIX."preferences", array("preference_value" => "2.1.0"), "UPDATE", "preference_id='".PREF_VERSION."'")) {
              if(!reload_configuration()) {
                $ERROR++;
                $ERRORSTR[] = "Unable to reload your configuration into your session. Please restart your web-browser to reload session data.";
              } else {
                $index  = array();
                $index[]  = "ALTER TABLE `".TABLES_PREFIX."users` ADD INDEX (`group_id`);";
                $index[]  = "ALTER TABLE `".TABLES_PREFIX."users` ADD INDEX (`signup_date`);";
                $index[]  = "ALTER TABLE `".TABLES_PREFIX."users` ADD INDEX (`email_address`);";
                $index[]  = "ALTER TABLE `".TABLES_PREFIX."templates` ADD INDEX (`template_type`);";
                $index[]  = "ALTER TABLE `".TABLES_PREFIX."cdata` ADD INDEX (`user_id`);";
                $index[]  = "ALTER TABLE `".TABLES_PREFIX."cdata` ADD INDEX (`cfield_id`);";
                $index[]  = "ALTER TABLE `".TABLES_PREFIX."cfields` ADD INDEX (`field_sname`);";
                $index[]  = "ALTER TABLE `".TABLES_PREFIX."cfields` ADD INDEX (`field_lname`);";
                $index[]  = "ALTER TABLE `".TABLES_PREFIX."cfields` ADD INDEX (`field_type`);";
                $index[]  = "ALTER TABLE `".TABLES_PREFIX."cfields` ADD INDEX (`field_req`);";
                $index[]  = "ALTER TABLE `".TABLES_PREFIX."cfields` ADD INDEX (`field_order`);";

                foreach($index as $query) {
                  @$db->Execute(trim($query));
                }

                $SUCCESS++;
                $SUCCESSSTR[] = "Congratulations, you have successfully upgraded to ListMessenger ".VERSION_INFO." (".VERSION_BUILD.").";
              }
            } else {
              $ERROR++;
              $ERRORSTR[] = "Unable to set the ListMessenger version number to ".VERSION_INFO." in the ListMessenger database. Please seek technical assistance in the forum: <a>http://forum.listmessenger.com</a>";
            }
          } else {
            $ERROR++;
            $ERRORSTR[] = "Unable to insert the new system preferences into the ListMessenger database. Please execute the following query:<blockquote style=\"font-family: monospace\">".$query."</blockquote>";
          }
        } else {
          $ERROR++;
          $ERRORSTR[] = "Unable to create the new sessions table in your ListMessenger database, please make sure that the database user has permission to create and alter tables in your ListMessenger database.";
        }
      } else {
        $ERROR++;
        $ERRORSTR[] = "Unable to create the new user_updates table in your ListMessenger database, please make sure that the database user has permission to create and alter tables in your ListMessenger database.";
      }
    break;
    default :
      continue;
    break;
  }

  return true;
}
?>