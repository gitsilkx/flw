<?php
/*
  ListMessenger - Professional Mailing List Management
  Copyright © 2007 Silentweb [http://www.silentweb.ca]

  Developed By: Matt Simpson <msimpson@listmessenger.com>

  For the most recent version, visit the ListMessenger website:
  [http://www.listmessenger.com]

  License Information is found in docs/licence.html
  $Id: import-export.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

if(!defined("PARENT_LOADED"))    exit;
if(!$_SESSION["isAuthenticated"])  exit;

@ini_set("auto_detect_line_endings", 1);
@ini_set("magic_quotes_runtime", 0);
@set_time_limit(1200);

$COLLAPSED  = explode(",", $_COOKIE["display"]["import-export"]["collapsed"]);

if(strlen(trim($_GET["action"])) > 0) {
  $ACTION  = checkslashes(trim($_GET["action"]));
} elseif(strlen(trim($_POST["action"])) > 0) {
  $ACTION  = checkslashes(trim($_POST["action"]));
} else {
  $ACTION  = "default";
}

if(strlen(trim($_GET["step"])) > 0) {
  $STEP  = checkslashes(trim($_GET["step"]));
} elseif(strlen(trim($_POST["step"])) > 0) {
  $STEP  = checkslashes(trim($_POST["step"]));
} else {
  $STEP  = 1;
}

switch($ACTION) {
  case "export" :
    // ERROR CHECKING
    switch($STEP) {
      case "2":
        $HASH      = "";
        $EXPORT_FILENAME  = "";

        if(!@is_dir($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/")) {
          $ERROR++;
          $ERRORSTR[] = "Your private <strong>tmp</strong> directory does not appear to exist or PHP is not able to read the directory. Please go into the <a href=\"index.php?section=preferences&type=program\">ListMessenger Program Preferences</a> and update your private folder directory path and ensure that the &quot;<strong>tmp</strong>&quot; folder exists in that directory.";
        } else {
          if(!@is_writable($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/")) {
            $ERROR++;
            $ERRORSTR[] = "Your private <strong>tmp</strong> directory is currently not writable by PHP, please chmod it to 777 so you are able to upload and create new backup files in this directory.";
          }
        }

        if((!@is_array($_POST["export"]["standard"])) || (@count($_POST["export"]["standard"]) < 1)) {
          $ERROR++;
          $ERRORSTR[]  = "You must select at least one standard ListMessenger field to export to a CSV file.";
          $STEP    = 1;
        }

        if((!@is_array($_POST["group_ids"])) || (@count($_POST["group_ids"]) < 1)) {
          $ERROR++;
          $ERRORSTR[]  = "You must select at least one group to export subscribers from using the group selection box on this page.";
          $STEP    = 1;
        } else {
          $group_ids  = array();
          foreach($_POST["group_ids"] as $group_id) {
            if($group_id = (int) trim($group_id)) {
              $group_ids[] = $group_id;
            }
          }
          if(@count($group_ids)) {
            $query  = "
                SELECT `".implode("`, `", $_POST["export"]["standard"])."`".((@count($_POST["export"]["custom"])) ? ", '' AS `".implode("`, '' AS `", $_POST["export"]["custom"])."`" : "")."
                FROM `".TABLES_PREFIX."users`
                LEFT JOIN `".TABLES_PREFIX."groups`
                ON `".TABLES_PREFIX."groups`.`groups_id` = `".TABLES_PREFIX."users`.`group_id`
                WHERE `".TABLES_PREFIX."users`.`group_id` IN (".implode(", ", $group_ids).")";
            $results  = $db->GetAll($query);
            if($results) {
              $HASH      = md5(uniqid(rand(), 1))."-".time();
              $EXPORT_FILENAME  = "lmexport-".$HASH;
              if($handle = @fopen($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$EXPORT_FILENAME, "w")) {
                @fwrite($handle, csv_record(array_keys($results[0]), $_POST["csv"]["fields_enclosed"], $_POST["csv"]["fields_delimited"])."\n");

                foreach($results as $result) {
                  if(@count($_POST["export"]["custom"])) {
                    //$sub_query  = "SELECT `".TABLES_PREFIX."cfields`.`field_sname`, `".TABLES_PREFIX."cdata`.`value` FROM `".TABLES_PREFIX."cfields` LEFT JOIN `".TABLES_PREFIX."cdata` ON `".TABLES_PREFIX."cdata`.`cfield_id`=`".TABLES_PREFIX."cfields`.`cfields_id` WHERE `".TABLES_PREFIX."cdata`.`user_id`='".$results[$i]["users_id"]."' AND (`".TABLES_PREFIX."cfields`.`field_sname`='".implode("' OR `".TABLES_PREFIX."cfields`.`field_sname`='", $_POST["export"]["custom"])."')";
                    $squery  = "
                        SELECT `".TABLES_PREFIX."cfields`.`field_sname`, `".TABLES_PREFIX."cdata`.`value`
                        FROM `".TABLES_PREFIX."cfields`
                        LEFT JOIN `".TABLES_PREFIX."cdata`
                        ON `".TABLES_PREFIX."cdata`.`cfield_id` = `".TABLES_PREFIX."cfields`.`cfields_id`
                        AND `".TABLES_PREFIX."cdata`.`user_id` = '".(int) $result["users_id"]."'
                        WHERE `".TABLES_PREFIX."cfields`.`field_sname` IN ('".implode("', '", $_POST["export"]["custom"])."')";
                    $sresults  = $db->GetAll($squery);
                    if($sresults) {
                      foreach($sresults as $sresult) {
                        $result[$sresult["field_sname"]] = $sresult["value"];
                      }
                    }
                  }

                  @fwrite($handle, csv_record($result, $_POST["csv"]["fields_enclosed"], $_POST["csv"]["fields_delimited"])."\n");
                }
                @fclose($handle);
              } else {
                $ERROR++;
                $ERRORSTR[]  = "Unable to create a new temporary file in your private tmp directory. Please make sure that PHP has permission to read and write to your private tmp directory.";
                $STEP    = 1;
              }
            } else {
              $ERROR++;
              $ERRORSTR[]  = "There were no rows to export in the groups that you selected, please select a group or groups that contain at least one subscriber.";
              $STEP    = 1;
            }
          } else {
            $ERROR++;
            $ERRORSTR[]  = "You have not selected any valid groups to export subscribers from, please select at least one valid group.";
            $STEP    = 1;
          }
        }
      break;
      default:
        // No error checking for step 1.
      break;
    }

    // PAGE DISPLAY
    switch($STEP) {
      case "2" :
        $HEAD[]    = "<meta http-equiv=\"refresh\" content=\"0; url=".$_SESSION["config"][PREF_PROGURL_ID]."export.php?sid=".session_id()."&hash=".$HASH."\" />\n";
        $ONLOAD[]    = "setTimeout('window.location=\'index.php?section=import-export\'', 10000)";

        $SUCCESS++;
        $SUCCESSSTR[]  = "Your Comma Separated Values (.csv) export file should begin downloading automatically; however, if it does not please <a href=\"".$_SESSION["config"][PREF_PROGURL_ID]."export.php?sid=".session_id()."&hash=".$HASH."\" target=\"_blank\">click here</a> to download it.";
        ?>
        <h1>Export Mailing List</h1>
        <?php
        if($SUCCESS) {
          echo display_success($SUCCESSSTR);
        }
        ?>
        <br /><br />
        Please be advised that this export file is only valid for one download after that, it is automatically removed. If you require it downloaded again, you will need to create a new export.
        <?php
      break;
      default :
        ?>
        <h1>Export Mailing List</h1>
        <img src="images/record-next-on.gif" width="9" height="9" hspace="2" vspace="2"  style="vertical-align: middle" alt="" title="" /> <a href="index.php?section=import-export">Import &amp; Export</a>&nbsp;
        <img src="images/record-next-on.gif" width="9" height="9" hspace="2" vspace="2"  style="vertical-align: middle" alt="" title="" /> Export Mailing List
        <br /><br />
        Please select which fields you would like to be included with this export using the form below:
        <br /><br />
        <?php echo (($ERROR) ? display_error($ERRORSTR) : ""); ?>
        <?php echo (($NOTICE) ? display_notice($NOTICESTR) : ""); ?>

        <h2>Standard Exportable Fields</h2>
        <form action="index.php?section=import-export&action=export&step=2" method="post" id="exportData">
        <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td style="width: 3%">1.</td>
          <td style="width: 3%"><input type="checkbox" name="export[standard][]" value="users_id" onkeypress="return handleEnter(this, event)" onclick="this.checked = true; alert('The subscriber id must be present in all exports, you cannot de-select this field.')" checked="checked" /></td>
          <td style="width: 24%; padding-left: 10px"><strong>subscriber_id</strong></td>
          <td style="width: 70%">ID of the subscriber in the database.</td>
        </tr>
        <tr>
          <td style="width: 3%">2.</td>
          <td style="width: 3%"><input type="checkbox" name="export[standard][]" value="group_id" onkeypress="return handleEnter(this, event)"<?= ((!$_POST || @in_array("group_id", $_POST["export"]["standard"])) ? " checked=\"checked\"" : "") ?> /></td>
          <td style="width: 24%; padding-left: 10px"><strong>group_id</strong></td>
          <td style="width: 70%">ID of the group in the database.</td>
        </tr>
        <tr>
          <td style="width: 3%">3.</td>
          <td style="width: 3%"><input type="checkbox" name="export[standard][]" value="group_name" onkeypress="return handleEnter(this, event)"<?= ((!$_POST || @in_array("group_name", $_POST["export"]["standard"])) ? " checked=\"checked\"" : "") ?> /></td>
          <td style="width: 24%; padding-left: 10px"><strong>group_name</strong></td>
          <td style="width: 70%">Name of the group.</td>
        </tr>
        <tr>
          <td style="width: 3%">4.</td>
          <td style="width: 3%"><input type="checkbox" name="export[standard][]" value="signup_date" onkeypress="return handleEnter(this, event)"<?= ((!$_POST || @in_array("signup_date", $_POST["export"]["standard"])) ? " checked=\"checked\"" : "") ?> /></td>
          <td style="width: 24%; padding-left: 10px"><strong>signup_date</strong></td>
          <td style="width: 70%">Date the subscriber joined your database.</td>
        </tr>
        <tr>
          <td style="width: 3%">5.</td>
          <td style="width: 3%"><input type="checkbox" name="export[standard][]" value="email_address" onkeypress="return handleEnter(this, event)"<?= ((!$_POST || @in_array("email_address", $_POST["export"]["standard"])) ? " checked=\"checked\"" : "") ?> /></td>
          <td style="width: 24%; padding-left: 10px"><strong>email_address</strong></td>
          <td style="width: 70%">E-mail address of the subscriber.</td>
        </tr>
        <tr>
          <td style="width: 3%">6.</td>
          <td style="width: 3%"><input type="checkbox" name="export[standard][]" value="firstname" onkeypress="return handleEnter(this, event)"<?= ((!$_POST || @in_array("firstname", $_POST["export"]["standard"])) ? " checked=\"checked\"" : "") ?> /></td>
          <td style="width: 24%; padding-left: 10px"><strong>firstname</strong></td>
          <td style="width: 70%">Firstname of the subscriber.</td>
        </tr>
        <tr>
          <td style="width: 3%">7.</td>
          <td style="width: 3%"><input type="checkbox" name="export[standard][]" value="lastname" onkeypress="return handleEnter(this, event)"<?= ((!$_POST || @in_array("lastname", $_POST["export"]["standard"])) ? " checked=\"checked\"" : "") ?> /></td>
          <td style="width: 24%; padding-left: 10px"><strong>lastname</strong></td>
          <td style="width: 70%">Lastname of the subscriber.</td>
        </tr>
        <?php
        $query  = "SELECT `cfields_id`, `field_sname`, `field_lname` FROM `".TABLES_PREFIX."cfields` ORDER BY `field_order` ASC";
        $results  = $db->GetAll($query);
        if($results) {
          echo "<tr>\n";
          echo "  <td colspan=\"4\">\n";
          echo "    <h2>Custom Exportable Fields</h2>\n";
          echo "  </td>\n";
          echo "</tr>\n";

          foreach($results as $i => $result) {
            echo "<tr>\n";
            echo "  <td style=\"width: 3%\">".($i + 8).".</td>";
            echo "  <td style=\"width: 3%\"><input type=\"checkbox\" name=\"export[custom][".$result["cfields_id"]."]\" value=\"".$result["field_sname"]."\" onkeypress=\"return handleEnter(this, event)\"".((!$_POST || @in_array($result["field_sname"], $_POST["export"]["custom"])) ? " checked=\"checked\"" : "")." /></td>";
            echo "  <td style=\"width: 24%; padding-left: 10px\"><strong>".$result["field_sname"]."</strong></td>\n";
            echo "  <td style=\"width: 70%\">".$result["field_lname"]."</td>\n";
            echo "</tr>\n";
          }
        }
        ?>
        <tr>
          <td colspan="4">
            <h2>CSV Export Options</h2>
          </td>
        </tr>
        <tr>
          <td></td>
          <td style="padding: 2px" class="form-row-req" colspan="2">Fields Enclosed By:</td>
          <td style="padding: 2px"><input type="text" class="text-box" name="csv[fields_enclosed]" value="<?= (($_POST["type"] == "csv") ? html_encode($_POST["csv"]["fields_enclosed"], ENT_QUOTES) : "&quot;") ?>" style="width: 15px" onkeypress="return handleEnter(this, event)" /></td>
        </tr>
        <tr>
          <td></td>
          <td style="padding: 2px" class="form-row-req" colspan="2">Fields Delimited By:</td>
          <td style="padding: 2px"><input type="text" class="text-box" name="csv[fields_delimited]" value="<?= (($_POST["type"] == "csv") ? html_encode($_POST["csv"]["fields_delimited"], ENT_QUOTES) : ",") ?>" style="width: 15px" onkeypress="return handleEnter(this, event)" /></td>
        </tr>

        <tr>
          <td colspan="4">
            <h2>Export Groups</h2>
          </td>
        </tr>
        <tr>
          <td></td>
          <td colspan="3">
            Please select the group or groups that you would like to export subscribers from:
            <select name="group_ids[]" style="margin-top: 5px; width: 97%" multiple="multiple" size="7" onkeypress="return handleEnter(this, event)">
            <?php echo groups_inselect(0, $_POST["group_ids"]); ?>
            </select>
            <br />
            <span class="small-grey"><strong>Notice:</strong> If a subscriber resides in multiple groups they will be included multiple times.</span>
          </td>
        </tr>
        </table>
        <br /><br />
        <table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
        <tr>
          <td colspan="2" style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
            <input type="button" value="Cancel" class="button" onclick="window.location='index.php?section=control'" />
            <input type="submit" value="Export List" class="button" />
          </td>
        </tr>
        </table>

        <?php
      break;
    }
  break;
  case "import" :
    require_once("classes/lm_mailer.class.php");

    $IMPORT_FILENAME  = "";

    // ERROR CHECKING
    switch($STEP) {
      case "2" :
        $IMPORT_FIELDS    = array();
        $IMPORT_SAMPLE    = array();

        if(!@is_dir($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/")) {
          $ERROR++;
          $ERRORSTR[] = "Your private <strong>tmp</strong> directory does not appear to exist or PHP is not able to read the directory. Please go into the <a href=\"index.php?section=preferences&type=program\">ListMessenger Program Preferences</a> and update your private folder directory path and ensure that the &quot;<strong>tmp</strong>&quot; folder exists in that directory.";
        } else {
          if(!@is_writable($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/")) {
            $ERROR++;
            $ERRORSTR[] = "Your private <strong>tmp</strong> directory is currently not writable by PHP, please chmod it to 777 so you are able to upload and create new backup files in this directory.";
          }
        }

        if((!@is_array($_POST["group_ids"])) || (@count($_POST["group_ids"]) < 1)) {
          $ERROR++;
          $ERRORSTR[] = "You must select at least one group to import these subscribers into under &quot;Imported Data Destination&quot;.";
        }

        if($_POST["options"]["confirmation"] != "1") {
          $NOTICE++;
          $NOTICESTR[] = "As good, honest practice we recommend that you always send the subscribers that you are importing an inclusive opt-in e-mail and allow them to choose whether or not they wish to be included in your mailing list".((@count($_POST["group_ids"]) != 1) ? "s" : "").".<br /><br />We realize that this is not always required; therefore, this is an option. This is not an error, simply a notice for your information.";
        }

        if(!$ERROR) {
          switch($_POST["type"]) {
            case "excel" :
              require_once("classes/xls/xls.class.php");
              if((!$_FILES["xlsfile"]) || ($_FILES["xlsfile"] == "")) {
                $ERROR++;
                $ERRORSTR[]  = "You did not select a Microsoft Excel (.xls) file from your computer to upload and import.";
              } else {
                switch($_FILES["xlsfile"]["error"]) {
                  case "0" :
                    // File was uploaded successfully.
                  break;
                  case "1" :
                    // File exceeds upload_max_file size in php.ini.
                    $ERROR++;
                    $ERRORSTR[] = "The Microsoft Excel (.xls) file that you are trying to upload is a larger filesize than your server currently allows to be uplaoded. Please either modify the &quot;upload_max_file&quot; in your php.ini file or add the appropriate directives to your web-server configuration file.";
                  break;
                  case "2" :
                    // File exceeds MAX_FILE_SIZE directive in form.
                    $ERROR++;
                    $ERRORSTR[] = "The Microsoft Excel (.xls) file that you are trying to upload is a larger filesize than your server currently allows.";
                  break;
                  case "3" :
                    // File was only partially uploaded.
                    $ERROR++;
                    $ERRORSTR[] = "The Microsoft Excel (.xls) file that was uploaded did not complete the upload process or was interrupted. Please try again.";
                  break;
                  case "4" :
                    // There was no file uploaded.
                    $ERROR++;
                    $ERRORSTR[] = "You did not select a Microsoft Excel (.xls) file from your computer to upload and import.";
                  break;
                  default :
                    if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                      @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tAn Excel file was uploaded and PHP returned an unrecognized file upload error [".$_FILES["xlsfile"]["error"]."].\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                    }
                  break;
                }

                if(!$ERROR) {
                  $IMPORT_FILENAME  = valid_filename($_FILES["xlsfile"]["name"]);

                  if(@strlen($IMPORT_FILENAME) < 1) {
                    $ERROR++;
                    $ERRORSTR[]  = "Please revisit the filename of your Microsoft Excel (.xls) file. It seems as though it doesn't contain any valid characters.";
                    $STEP    = 1;
                  } else {
                    if(!@move_uploaded_file($_FILES["xlsfile"]["tmp_name"], $_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME)) {
                      $ERROR++;
                      $ERRORSTR[]  = "ListMessenger was unable to move the Microsoft Excel (.xls) file from your servers temporary storage directory to your private tmp directory at &quot;".$_SESSION["config"][PREF_PRIVATE_PATH]."tmp/&quot;.";
                      $STEP    = 1;
                    } else {
                      if(@file_exists($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME)) {
                        $xls  = new ExcelFileParser((($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") ? $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt" : false), (($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") ? ABC_ERROR : ABC_NO_LOG));
                        $result  = $xls->ParseFromFile($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME);
                        switch($result) {
                          case 0:
                            // Excellent, no errors found. Continue.
                            if(@count($xls->worksheet["name"]) < 1) {
                              $ERROR++;
                              $ERRORSTR[] = "The Excel file that you are trying to import does not contain any worksheets. Please select a new Excel file to import.";
                            }
                          break;
                          case 1:
                            $ERROR++;
                            $ERRORSTR[] = "ListMessenger is unable to open the Microsoft Excel file that you are trying to import.";
                          break;
                          case 2:
                            $ERROR++;
                            $ERRORSTR[] = "The Excel file that you are trying to import is not likely a Microsoft Excel file because the file is just too small.";
                          break;
                          case 3:
                            $ERROR++;
                            $ERRORSTR[] = "ListMessenger is unable to read the headers of the Microsoft Excel file that you are trying to import.";
                          break;
                          case 4:
                            $ERROR++;
                            $ERRORSTR[] = "ListMessenger is unable to read the Microsoft Excel file that you are trying to import.";
                          break;
                          case 5:
                            $ERROR++;
                            $ERRORSTR[] = "The file that you are attempting to import is not a Microsoft Excel (.xls) file or the file was created with an unsupported version of Microsoft Excel.";
                          break;
                          case 6:
                            $ERROR++;
                            $ERRORSTR[] = "It appears as though the Microsoft Excel file that you are attempting to import is corrupt.";
                          break;
                          case 7:
                            $ERROR++;
                            $ERRORSTR[] = "There was no Excel data found in the file that you are attempting to import. Please make sure the file contains valid rows.";
                          break;
                          case 8:
                            $ERROR++;
                            $ERRORSTR[] = "The Excel file that you are trying to import does not appear to be a recognized version of Microsoft Excel. Your file must be from Microsoft Excel version 5.0, 97, 2000 or XP.";
                          break;
                          default:
                            $ERROR++;
                            $ERRORSTR[] = "An unknown Microsoft Excel file import error has occurred, please check your log file for more information.";
                          break;
                        }

                        if(!$ERROR) {
                          $xlsdata = $xls->worksheet["data"][0];  // Just using the first worksheet in the file.
                          if((@is_array($xlsdata)) && (isset($xlsdata["max_row"])) && (isset($xlsdata["max_col"]))) {
                            $start_row = (($_POST["options"]["firstrowfields"] == "1") ? 1 : 0);
                            for($column = 0; $column <= $xlsdata["max_col"]; $column++) {
                              $index = $xlsdata["cell"][0][$column]["data"];
                              $IMPORT_FIELDS[$column]  = (($_POST["options"]["firstrowfields"] == "1") ? (($xls->sst["unicode"][$index]) ? uc2html($xls->sst["data"][$index]) : (($xls->sst["data"][$index]) ? $xls->sst["data"][$index] : (int) $index)) : "");
                            }
                            for($row = $start_row; $row <= ($start_row + 4); $row++) {
                              for($column = 0; $column <= $xlsdata["max_col"]; $column++) {
                                $index = $xlsdata["cell"][$row][$column]["data"];
                                $IMPORT_SAMPLE[$row][$column] = (($xls->sst["unicode"][$index]) ? uc2html($xls->sst["data"][$index]) : (($xls->sst["data"][$index]) ? $xls->sst["data"][$index] : (int) $index));
                              }
                            }
                          } else {
                            $ERROR++;
                            $ERRORSTR[]  = "There has been a problem importing your Microsoft Excel document. Either the file contains no rows or column's or there is no data found. Please select a different Excel document.";
                            $STEP    = 1;
                          }
                        } else {
                          $STEP = 1;
                        }
                      } else {
                        $ERROR++;
                        $ERRORSTR[]  = "The Microsoft Excel (.xls) file that you're trying to import [".$IMPORT_FILENAME."] no longer exists in your private tmp directory.";
                        $STEP    = 1;
                      }
                    }
                  }
                } else {
                  $STEP = 1;
                }
              }
            break;
            case "csv" :
              if((!$_FILES["csvfile"]) || ($_FILES["csvfile"] == "")) {
                $ERROR++;
                $ERRORSTR[]  = "You did not select a Comma Separated Values (.csv) file from your computer to upload and import.";
              } else {
                switch($_FILES["csvfile"]["error"]) {
                  case "0" :
                    // File was uploaded successfully.
                  break;
                  case "1" :
                    // File exceeds upload_max_file size in php.ini.
                    $ERROR++;
                    $ERRORSTR[] = "The Comma Separated Values (.csv) file that you are trying to upload is a larger filesize than your server currently allows to be uplaoded. Please either modify the &quot;upload_max_file&quot; in your php.ini file or add the appropriate directives to your web-server configuration file.";
                  break;
                  case "2" :
                    // File exceeds MAX_FILE_SIZE directive in form.
                    $ERROR++;
                    $ERRORSTR[] = "The Comma Separated Values (.csv) file that you are trying to upload is a larger filesize than your server currently allows.";
                  break;
                  case "3" :
                    // File was only partially uploaded.
                    $ERROR++;
                    $ERRORSTR[] = "The Comma Separated Values (.csv) file that was uploaded did not complete the upload process or was interrupted. Please try again.";
                  break;
                  case "4" :
                    // There was no file uploaded.
                    $ERROR++;
                    $ERRORSTR[] = "You did not select a Comma Separated Values (.csv) file from your computer to upload and import.";
                  break;
                  default :
                    if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                      @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tA CSV file was uploaded to import and PHP returned an unrecognized file upload error [".$_FILES["csvfile"]["error"]."].\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                    }
                  break;
                }

                if(trim($_POST["csv"]["fields_delimited"]) == "") {
                  $ERROR++;
                  $ERRORSTR[] = "You must enter the character that your fields are delimited by. This is commonly a comma or semi-colon in a CSV file or use \\t if you're importing a tab separated values file.";
                }

                if(!$ERROR) {
                  $IMPORT_FILENAME  = valid_filename($_FILES["csvfile"]["name"]);

                  if(@strlen($IMPORT_FILENAME) < 1) {
                    $ERROR++;
                    $ERRORSTR[]  = "Please revisit the filename of your Comma Separated Values (.csv) file. It seems as though it doesn't contain any valid characters.";
                    $STEP    = 1;
                  } else {
                    if(!@move_uploaded_file($_FILES["csvfile"]["tmp_name"], $_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME)) {
                      $ERROR++;
                      $ERRORSTR[]  = "ListMessenger was unable to move the Comma Separated Values (.csv) file from your servers temporary storage directory to your private tmp directory at &quot;".$_SESSION["config"][PREF_PRIVATE_PATH]."tmp/&quot;.";
                      $STEP    = 1;
                    } else {
                      if(@file_exists($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME)) {
                        if(!$handle = @fopen($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME, "rb")) {
                          $ERROR++;
                          $ERRORSTR[]  = "ListMessenger was unable to open your Comma Separated Values (.csv) file, please make sure that PHP has read permissions on your private tmp directory.";
                          $STEP    = 1;
                        } else {
                          $csvdata    = array();
                          $row_count  = 0;
                          while(($row = @fgetcsv($handle, @filesize($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME), checkslashes($_POST["csv"]["fields_delimited"], 1), checkslashes($_POST["csv"]["fields_enclosed"], 1))) !== FALSE) {
                            if($row_count >= 6) {
                              break;
                            } else {
                              $csvdata["row"][]  = $row;
                              $row_count++;
                            }
                          }
                          $csvdata["max_row"] = @count($csvdata["row"]);
                          $csvdata["max_col"]  = @count($row);
                          @fclose($handle);

                          if((@is_array($csvdata)) && (isset($csvdata["max_row"])) && (isset($csvdata["max_col"]))) {
                            $start_row  = (($_POST["options"]["firstrowfields"] == "1") ? 1 : 0);

                            foreach($csvdata["row"][0] as $column => $value) {
                              $IMPORT_FIELDS[$column]  = (($_POST["options"]["firstrowfields"] == "1") ? $value : "");
                            }
                            for($row = $start_row; $row <= ($start_row + 4); $row++) {
                              $IMPORT_SAMPLE[$row] = $csvdata["row"][$row];
                            }
                          } else {
                            $ERROR++;
                            $ERRORSTR[]  = "There has been a problem importing your Comma Separated Values (.csv) document. Either the file contains no rows or column's or there is no data found.";
                            $STEP    = 1;
                          }
                        }
                      } else {
                        $ERROR++;
                        $ERRORSTR[]  = "The Comma Separated Values (.csv) file that you're trying to import [".$IMPORT_FILENAME."] no longer exists in your private tmp directory.";
                        $STEP    = 1;
                      }
                    }
                  }
                } else {
                  $STEP = 1;
                }
              }
            break;
            case "text" :
              if((!$_POST["text"]["data"]) || (trim($_POST["text"]["data"]) == "")) {
                $ERROR++;
                $ERRORSTR[]  = "You did not any CSV text in the provided textarea to import into the system. Please enter some CSV text or use another method to import your list.";
              } else {
                if(trim($_POST["csv"]["fields_delimited"]) == "") {
                  $ERROR++;
                  $ERRORSTR[] = "You must enter the character that your fields are delimited by. This is commonly a comma or semi-colon in a CSV file or use \\t if you're importing a tab separated values file.";
                } else {
                  $IMPORT_FILENAME  = valid_filename("csvtext_".time().".csv");

                  if($handle = @fopen($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME, "w")) {
                    if(@fwrite($handle, trim(checkslashes($_POST["text"]["data"], 1))) === FALSE) {
                      $ERROR++;
                      $ERRORSTR[] = "Unable to write the CSV data to the temporary CSV file [".$IMPORT_FILENAME."]. Please make sure that PHP has write permissions on files in that directory.";
                    }
                    @fclose($handle);
                  } else {
                    $ERROR++;
                    $ERRORSTR[] = "Unable to create the temporary CSV file [".$IMPORT_FILENAME."] to insert the CSV data into. Please make sure that PHP has read and write permissions on your private tmp directory.";
                  }
                }
                if(!$ERROR) {
                  if(@file_exists($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME)) {
                    if(!$handle = @fopen($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME, "rb")) {
                      $ERROR++;
                      $ERRORSTR[]  = "ListMessenger was unable to open your temporary Comma Separated Values (.csv) file, please make sure that PHP has read permissions on your private tmp directory.";
                      $STEP    = 1;
                    } else {
                      $csvdata    = array();
                      $row_count  = 0;
                      while(($row = @fgetcsv($handle, @filesize($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME), checkslashes($_POST["text"]["fields_delimited"], 1), checkslashes($_POST["text"]["fields_enclosed"], 1))) !== FALSE) {
                        if($row_count >= 6) {
                          break;
                        } else {
                          $csvdata["row"][]  = $row;
                          $row_count++;
                        }
                      }
                      $csvdata["max_row"] = @count($csvdata["row"]);
                      $csvdata["max_col"]  = @count($row);
                      @fclose($handle);

                      if((@is_array($csvdata)) && (isset($csvdata["max_row"])) && (isset($csvdata["max_col"]))) {
                        $start_row  = (($_POST["options"]["firstrowfields"] == "1") ? 1 : 0);

                        foreach($csvdata["row"][0] as $column => $value) {
                          $IMPORT_FIELDS[$column]  = (($_POST["options"]["firstrowfields"] == "1") ? $value : "");
                        }
                        for($row = $start_row; $row <= ($start_row + 4); $row++) {
                          $IMPORT_SAMPLE[$row] = $csvdata["row"][$row];
                        }
                      } else {
                        $ERROR++;
                        $ERRORSTR[]  = "There has been a problem importing your Comma Separated Values (.csv) document. Either the file contains no rows or column's or there is no data found.";
                        $STEP    = 1;
                      }
                    }
                  } else {
                    $ERROR++;
                    $ERRORSTR[]  = "The Comma Separated Values (.csv) file that you're trying to import [".$IMPORT_FILENAME."] no longer exists in your private tmp directory.";
                    $STEP    = 1;
                  }
                }
              }
            break;
            default:
              $ERROR++;
              $ERRORSTR[]  = "The selected data source is not a valid &quot;Imported Data Source&quot; type. Please choose from either Microsoft Excel, CSV File or Textarea.";
              $STEP    = 1;
            break;
          }
        }

        if((!$IMPORT_FILENAME) || ($IMPORT_FILENAME == "")) {
          $ERROR++;
          $ERRORSTR[]  = "There is no file in the filesystem to import, please try again.";
          $STEP    = 1;
        }
      break;
      case "3" :
        if((!$_POST["import_filename"]) || (trim($_POST["import_filename"]) == "")) {
          $ERROR++;
          $ERRORSTR[]  = "There is no filename provided to this step to import. Please go back to the first step and go through the process again.";
        } else {
          $IMPORT_FILENAME = valid_filename(trim($_POST["import_filename"]));
          $IMPORT_FILENAME = str_replace(array("..", "/", "\\"), "", $IMPORT_FILENAME);

          if(!@file_exists($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME)) {
            $ERROR++;
            $ERRORSTR[] = "The filename that was provided to step three to import does not exist in your private tmp directory. Please go back to the first step and go through the process again.";
          }
        }

        if((!@is_array($_POST["fields"])) || (@count($_POST["fields"]) < 1)) {
          $ERROR++;
          $ERRORSTR[] = "You did not select any fields to import from your Excel file, please try again but select the proper fields.";
        } else {
          if(((!$_POST["fields"]["email_address"]) && ($_POST["fields"]["email_address"] !== "0")) || ($_POST["fields"]["email_address"] == "")) {
            $ERROR++;
            $ERRORSTR[] = "You did not select a column to import that contains the subscribers e-mail address. Please select this column and try again.";
          }
        }

        if((!@is_array($_POST["group_ids"])) || (@count($_POST["group_ids"]) < 1)) {
          $ERROR++;
          $ERRORSTR[] = "Unable to locate any groups to import these subscribers into, please try again.";
        }

        if(!$ERROR) {
          // If confirmation is requested, setup PHPMailer.
          if($_POST["options"]["confirmation"] == "1") {
            if(@file_exists($_SESSION["config"][PREF_PUBLIC_PATH]."languages/".$_SESSION["config"][ENDUSER_LANG_ID].".lang.php")) {
              require_once($_SESSION["config"][PREF_PUBLIC_PATH]."languages/".$_SESSION["config"][ENDUSER_LANG_ID].".lang.php");
            } elseif(@file_exists($_SESSION["config"][PREF_PUBLIC_PATH]."languages/english.lang.php")) {
              require_once($_SESSION["config"][PREF_PUBLIC_PATH]."languages/english.lang.php");

              $NOTICE++;
              $NOTICESTR[]  = "Your selected language file does not exist in the public languages directory, so the English default file is being used.";
            } else {
              $ERROR++;
              $ERRORSTR[]  = "Your public language directory does not contain your selected language file, or the English language file. Please ensure that you have the proper language files in your public languages directory.";
            }

            @ini_set("sendmail_from", $_SESSION["config"][PREF_ERREMAL_ID]);

            $mail      = new LM_Mailer("private");
            $mail->Priority  = 3;  // Normal
            $mail->CharSet  = $_SESSION["config"][PREF_DEFAULT_CHARSET];
            $mail->Encoding  = "8bit";
            $mail->WordWrap  = $_SESSION["config"][PREF_WORDWRAP];

            $mail->From     = $_SESSION["config"][PREF_FRMEMAL_ID];
            $mail->FromName  = $_SESSION["config"][PREF_FRMNAME_ID];

            $mail->Sender  = $_SESSION["config"][PREF_ERREMAL_ID];

            $mail->AddReplyTo($_SESSION["config"][PREF_RPYEMAL_ID], $_SESSION["config"][PREF_FRMNAME_ID]);

            $mail->AddCustomHeader("X-ListMessenger-Version: ".VERSION_TYPE." [".VERSION_INFO."]");
            $mail->AddCustomHeader("X-Originating-IP: ".$_SERVER["REMOTE_ADDR"]);

            $mail->Subject  = $language_pack["subscribe_confirmation_subject"];
          }

          switch($_POST["type"]) {
            case "excel" :
              require_once("classes/xls/xls.class.php");
              $xls  = new ExcelFileParser((($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") ? $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt" : false), (($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") ? ABC_ERROR : ABC_NO_LOG));
              $result  = $xls->ParseFromFile($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME);
              switch($result) {
                case 0:
                  // Excellent, no errors found. Continue.
                  if(@count($xls->worksheet["name"]) < 1) {
                    $ERROR++;
                    $ERRORSTR[] = "The Excel file that you are trying to import does not contain any worksheets. Please select a new Excel file to import.";
                  }
                break;
                case 1:
                  $ERROR++;
                  $ERRORSTR[] = "ListMessenger is unable to open the Microsoft Excel file that you are trying to import.";
                break;
                case 2:
                  $ERROR++;
                  $ERRORSTR[] = "The Excel file that you are trying to import is not likely a Microsoft Excel file because the file is just too small.";
                break;
                case 3:
                  $ERROR++;
                  $ERRORSTR[] = "ListMessenger is unable to read the headers of the Microsoft Excel file that you are trying to import.";
                break;
                case 4:
                  $ERROR++;
                  $ERRORSTR[] = "ListMessenger is unable to read the Microsoft Excel file that you are trying to import.";
                break;
                case 5:
                  $ERROR++;
                  $ERRORSTR[] = "The file that you are attempting to import is not a Microsoft Excel (.xls) file or the file was created with an unsupported version of Microsoft Excel.";
                break;
                case 6:
                  $ERROR++;
                  $ERRORSTR[] = "It appears as though the Microsoft Excel file that you are attempting to import is corrupt.";
                break;
                case 7:
                  $ERROR++;
                  $ERRORSTR[] = "There was no Excel data found in the file that you are attempting to import. Please make sure the file contains valid rows.";
                break;
                case 8:
                  $ERROR++;
                  $ERRORSTR[] = "The Excel file that you are trying to import does not appear to be a recognized version of Microsoft Excel. Your file must be from Microsoft Excel version 5.0, 97, 2000 or XP.";
                break;
                default:
                  $ERROR++;
                  $ERRORSTR[] = "An unknown Microsoft Excel file import error has occurred, please check your log file for more information.";
                break;
              }

              if(!$ERROR) {
                $xlsdata = $xls->worksheet["data"][0];  // Just using the first worksheet in the file.
                if((@is_array($xlsdata)) && (isset($xlsdata["max_row"])) && (isset($xlsdata["max_col"]))) {
                  $start_row  = (($_POST["options"]["firstrowfields"] == "1") ? 1 : 0);

                  for($row = $start_row; $row <= $xlsdata["max_row"]; $row++) {
                    $skip_row    = false;

                    $email_address  = "";
                    $firstname    = "";
                    $lastname    = "";
                    $groups      = array();
                    $cdata      = array();

                    foreach($_POST["fields"] as $field_name => $column) {
                      if(trim($column) != "") {
                        $result  = "";
                        $index  = $xlsdata["cell"][$row][$column]["data"];

                        if($xls->sst["unicode"][$index]) {
                          $result = trim(uc2html($xls->sst["data"][$index]));
                        } elseif($xls->sst["data"][$index]) {
                          $result = trim($xls->sst["data"][$index]);
                        } elseif((int) $index) {
                          $result = (int) $index;
                        } else {
                          $result = trim($index);
                        }

                        if((@in_array($field_name, $_POST["required_fields"])) && ($result == "")) {
                          $ERROR++;
                          $ERRORSTR[]  = "Row ".($row + (1 - $start_row)).": Required field [".$field_name."] is missing from row.";
                          $skip_row  = true;
                        }

                        switch($field_name) {
                          case "email_address" :
                            $email_address    = $result;
                          break;
                          case "firstname" :
                            $firstname      = $result;
                          break;
                          case "lastname" :
                            $lastname      = $result;
                          break;
                          default:
                            $cdata[$field_name]  = $result;
                          break;
                        }
                      }
                    }

                    if($email_address != "") {
                      if(!valid_address($email_address)) {
                        $ERROR++;
                        $ERRORSTR[]  = "Row ".($row + (1 - $start_row)).": E-mail address [".$email_address."] does not appear to be valid.";
                        $skip_row  = true;
                      } else {
                        if($_POST["options"]["dupecheck"] == "1") {
                          foreach($_POST["group_ids"] as $group_id) {
                            $query  = "SELECT `users_id` FROM `".TABLES_PREFIX."users` WHERE `group_id`='".checkslashes($group_id)."' AND `email_address`='".$email_address."'";
                            $result  = $db->GetRow($query);
                            if($result) {
                              $NOTICE++;
                              $NOTICESTR[]  = "Row ".($row + (1 - $start_row)).": E-mail address [".$email_address."] already exists in ".groups_information(array($group_id), true).".";
                            } else {
                              $groups[]    = $group_id;
                            }
                          }
                        } else {
                          $groups = $_POST["group_ids"];
                        }
                      }
                    }

                    if((@is_array($groups)) && (@count($groups) < 1)) {
                      $ERROR++;
                      $ERRORSTR[]  = "Row ".($row + (1 - $start_row)).": E-mail address [".$email_address."] already exists in all specified groups.";
                      $skip_row  = true;
                    }

                    if(!$skip_row) {
                      if($_POST["options"]["confirmation"] == "1") {
                        $result = users_queue($email_address, $firstname, $lastname, $groups, $cdata, "adm-import");
                        if($result) {
                          $mail->Body = str_replace(array("[name]", "[url]", "[abuse_address]", "[from]"), array($firstname, ($_SESSION["config"][PREF_PUBLIC_URL]."confirm.php?id=".$result["confirm_id"]."&code=".$result["hash"]), $_SESSION["config"][PREF_ABUEMAL_ID], $_SESSION["config"][PREF_FRMNAME_ID]), $language_pack["subscribe_confirmation_message"]);

                          $mail->ClearAddresses();

                          if($firstname != "") {
                            $senders_name = $firstname.(($lastname != "") ? " ".$lastname : "");
                          } else {
                            $senders_name = $email_address;
                          }
                          $mail->AddAddress($email_address, $senders_name);

                          if(@$mail->Send()) {
                            $SUCCESS++;
                            $SUCCESSSTR[]  = "Row ".($row + (1 - $start_row)).": An opt-in request e-mail address was sent to [".$email_address."].";
                          } else {
                            $ERROR++;
                            $ERRORSTR[]    = "Row ".($row + (1 - $start_row)).": An opt-in request could not be sent. Please check your error log for more details.";

                            $query = "DELETE FROM `".TABLES_PREFIX."confirmation` WHERE `confirm_id`='".$result["confirm_id"]."';";
                            if(!$db->Execute($query)) {
                              if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                                @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tRow ".($row + (1 - $start_row)).": Unable to delete the failed confirmation queue request from the confirmation table. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                              }
                            }
                            if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                              @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tRow ".($row + (1 - $start_row)).": Unable to send opt-in request to ".$email_address.". PHPMailer said: ".$mail->ErrorInfo."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                            }
                          }
                        } else {
                          if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                            @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tRow ".($row + (1 - $start_row)).": Unable to add a new subscriber [".$email_address."] to the confirmation queue. The subscriber is already present in all groups.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                          }
                        }
                      } else {
                        $result = users_add($email_address, $firstname, $lastname, $groups, $cdata);
                        if($result) {
                          $query  = "INSERT INTO `".TABLES_PREFIX."confirmation` VALUES (NULL, '".time()."', 'adm-import', '".addslashes($_SERVER["REMOTE_ADDR"])."', '".addslashes($_SERVER["HTTP_REFERER"])."', '".addslashes($_SERVER["HTTP_USER_AGENT"])."', '".$email_address."', '".addslashes($firstname)."', '".addslashes($lastname)."', '".addslashes(serialize($groups))."', '".addslashes(serialize($cdata))."', '', '0');";
                          $db->Execute($query);

                          if($result["failed"] > 0) {
                            $ERROR++;
                            $ERRORSTR[] = "Row ".($row + (1 - $start_row)).": Inserting [".$email_address."] failed for ".$result["failed"]." group".((@count($groups) != 1) ? "s" : "").".";
                          }
                          if($result["semi"] > 0) {
                            $NOTICE++;
                            $NOTICESTR[] = "Row ".($row + (1 - $start_row)).": Inserting custom data for [".$email_address."] failed for ".$result["semi"]." field".(($result["semi"] != 1) ? "s" : "").".";
                          }
                          if($result["success"] > 0) {
                            $SUCCESS++;
                            $SUCCESSSTR[] = "Row ".($row + (1 - $start_row)).": Successfully inserted [".$email_address."] into ".$result["success"]." group".((@count($groups) != 1) ? "s" : "").".";
                          }
                        } else {
                          if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                            @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tRow ".($row + (1 - $start_row)).": Unable to add a new subscriber [".$email_address."] to the database. The subscriber is already present in all groups.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                          }
                        }
                      }
                    } else {
                      if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                        @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tRow ".($row + (1 - $start_row)).": Row was skipped during import.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                      }
                    }
                  }
                } else {
                  $ERROR++;
                  $ERRORSTR[]  = "There has been a problem importing your Microsoft Excel document. Either the file contains no rows or column's or there is no data found. Please select a different Excel document.";
                  $STEP    = 1;
                }
              } else {
                $STEP = 1;
              }
            break;
            case "csv" :
              if(@file_exists($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME)) {
                if(!$handle = @fopen($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME, "rb")) {
                  $ERROR++;
                  $ERRORSTR[]  = "ListMessenger was unable to open your Comma Separated Values (.csv) file, please make sure that PHP has read permissions on your private tmp directory.";
                  $STEP    = 1;
                } else {
                  $csvdata  = array();
                  $row_count  = 0;
                  while(($row = fgetcsv($handle, @filesize($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME), checkslashes($_POST["csv"]["fields_delimited"], 1), checkslashes($_POST["csv"]["fields_enclosed"], 1))) !== FALSE) {
                    $csvdata["row"][]  = $row;
                    if(!isset($csvdata["max_col"])) {
                      $csvdata["max_col"]  = @count($row);
                    }
                  }
                  $csvdata["max_row"] = @count($csvdata["row"]);

                  @fclose($handle);
                }
              }

              if(!$ERROR) {
                if((@is_array($csvdata)) && (isset($csvdata["max_row"])) && (isset($csvdata["max_col"]))) {
                  $start_row  = (($_POST["options"]["firstrowfields"] == "1") ? 1 : 0);
                  for($row = $start_row; $row <= ($csvdata["max_row"] - 1); $row++) {
                    $skip_row    = false;

                    $email_address  = "";
                    $firstname    = "";
                    $lastname    = "";
                    $groups      = array();
                    $cdata      = array();

                    foreach($_POST["fields"] as $field_name => $column) {
                      if(trim($column) != "") {
                        $result  = trim($csvdata["row"][$row][$column]);

                        if((@in_array($field_name, $_POST["required_fields"])) && ($result == "")) {
                          $ERROR++;
                          $ERRORSTR[]    = "Row ".($row + (1 - $start_row)).": Required field [".$field_name."] is missing from this row.";
                          $skip_row    = true;
                        }

                        switch($field_name) {
                          case "email_address" :
                            $email_address    = $result;
                          break;
                          case "firstname" :
                            $firstname      = $result;
                          break;
                          case "lastname" :
                            $lastname      = $result;
                          break;
                          default:
                            $cdata[$field_name]  = $result;
                          break;
                        }
                      }
                    }

                    if($email_address != "") {
                      if(!valid_address($email_address)) {
                        $ERROR++;
                        $ERRORSTR[]  = "Row ".($row + (1 - $start_row)).": E-mail address [".$email_address."] does not appear to be valid.";
                        $skip_row  = true;
                      } else {
                        if($_POST["options"]["dupecheck"] == "1") {
                          foreach($_POST["group_ids"] as $group_id) {
                            $query  = "SELECT `users_id` FROM `".TABLES_PREFIX."users` WHERE `group_id`='".checkslashes($group_id)."' AND `email_address`='".$email_address."'";
                            $result  = $db->GetRow($query);
                            if($result) {
                              $NOTICE++;
                              $NOTICESTR[]  = "Row ".($row + (1 - $start_row)).": E-mail address [".$email_address."] already exists in ".groups_information(array($group_id), true).".";
                            } else {
                              $groups[]    = $group_id;
                            }
                          }
                        } else {
                          $groups = $_POST["group_ids"];
                        }
                      }
                    }

                    if((@is_array($groups)) && (@count($groups) < 1)) {
                      $ERROR++;
                      $ERRORSTR[]    = "Row ".($row + (1 - $start_row)).": E-mail address [".$email_address."] already exists in all specified groups.";
                      $skip_row    = true;
                    }

                    if(!$skip_row) {
                      if($_POST["options"]["confirmation"] == "1") {
                        $result = users_queue($email_address, $firstname, $lastname, $groups, $cdata, "adm-import");
                        if($result) {
                          $mail->Body = str_replace(array("[name]", "[url]", "[abuse_address]", "[from]"), array($firstname, ($_SESSION["config"][PREF_PUBLIC_URL]."confirm.php?id=".$result["confirm_id"]."&code=".$result["hash"]), $_SESSION["config"][PREF_ABUEMAL_ID], $_SESSION["config"][PREF_FRMNAME_ID]), $language_pack["subscribe_confirmation_message"]);

                          $mail->ClearAddresses();

                          if($firstname != "") {
                            $senders_name = $firstname.(($lastname != "") ? " ".$lastname : "");
                          } else {
                            $senders_name = $email_address;
                          }
                          $mail->AddAddress($email_address, $senders_name);

                          if(@$mail->Send()) {
                            $SUCCESS++;
                            $SUCCESSSTR[] = "Row ".($row + (1 - $start_row)).": An opt-in request e-mail address was sent to [".$email_address."].";
                          } else {
                            $ERROR++;
                            $ERRORSTR[] = "Row ".($row + (1 - $start_row)).": An opt-in request could not be sent. Please check your error log for more details.";

                            $query = "DELETE FROM `".TABLES_PREFIX."confirmation` WHERE `confirm_id`='".$result["confirm_id"]."';";
                            if(!$db->Execute($query)) {
                              if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                                @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tRow ".($row + (1 - $start_row)).": Unable to delete the failed confirmation queue request from the confirmation table. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                              }
                            }
                            if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                              @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tRow ".($row + (1 - $start_row)).": Unable to send opt-in request to ".$email_address.". PHPMailer said: ".$mail->ErrorInfo."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                            }
                          }
                        } else {
                          if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                            @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tRow ".($row + (1 - $start_row)).": Unable to add a new subscriber [".$email_address."] to the confirmation queue. The subscriber is already present in all groups.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                          }
                        }
                      } else {
                        $result = users_add($email_address, $firstname, $lastname, $groups, $cdata);
                        if($result) {
                          $query  = "INSERT INTO `".TABLES_PREFIX."confirmation` VALUES (NULL, '".time()."', 'adm-import', '".addslashes($_SERVER["REMOTE_ADDR"])."', '".addslashes($_SERVER["HTTP_REFERER"])."', '".addslashes($_SERVER["HTTP_USER_AGENT"])."', '".$email_address."', '".addslashes($firstname)."', '".addslashes($lastname)."', '".addslashes(serialize($groups))."', '".addslashes(serialize($cdata))."', '', '0');";
                          $db->Execute($query);

                          if($result["failed"] > 0) {
                            $ERROR++;
                            $ERRORSTR[] = "Row ".($row + (1 - $start_row)).": Inserting [".$email_address."] failed for ".$result["failed"]." group".((@count($groups) != 1) ? "s" : "").".";
                          }
                          if($result["semi"] > 0) {
                            $NOTICE++;
                            $NOTICESTR[] = "Row ".($row + (1 - $start_row)).": Inserting custom data for [".$email_address."] failed for ".$result["semi"]." field".(($result["semi"] != 1) ? "s" : "").".";
                          }
                          if($result["success"] > 0) {
                            $SUCCESS++;
                            $SUCCESSSTR[] = "Row ".($row + (1 - $start_row)).": Successfully inserted [".$email_address."] into ".$result["success"]." group".((@count($groups) != 1) ? "s" : "").".";
                          }
                        } else {
                          if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                            @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tRow ".($row + (1 - $start_row)).": Unable to add a new subscriber [".$email_address."] to the database. The subscriber is already present in all groups.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                          }
                        }
                      }
                    } else {
                      if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
                        @error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tRow ".($row + (1 - $start_row)).": Row was skipped during import.\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
                      }
                    }
                  }
                } else {
                  $ERROR++;
                  $ERRORSTR[]  = "There has been a problem importing your Comma Separated Values (.csv) document. Either the file contains no rows or column's or there is no data found. Please select a different Excel document.";
                  $STEP    = 1;
                }
              } else {
                $STEP = 1;
              }
            break;
            case "text" :
            break;
            default:
              $ERROR++;
              $ERRORSTR[]  = "The selected data source is not a valid &quot;Imported Data Source&quot; type. Please choose from either Microsoft Excel, CSV File or Textarea.";
              $STEP    = 1;
            break;
          }

          // If confirmation is requested, close PHPMailer.
          if($_POST["options"]["confirmation"] == "1") {
            if($mail->Mailer == "smtp") $mail->SmtpClose();
            $mail->ClearCustomHeaders();
            @ini_restore("sendmail_from");
          }
        } else {
          $STEP = 1;
        }
      break;
      default :
        // No error checking for Step 1.
      break;
    }

    // PAGE DISPLAY
    switch($STEP) {
      case "2" :
        $field_list  = array();
        $field_list[]  = array("name" => "email_address", "required" => 1);
        $field_list[]  = array("name" => "firstname", "required" => 0);
        $field_list[]  = array("name" => "lastname", "required" => 0);

        $query    = "SELECT `field_sname`, `field_req` FROM `".TABLES_PREFIX."cfields` ORDER BY `field_order` ASC";
        $results    = $db->GetAll($query);
        if($results) {
          foreach($results as $result) {
            $field_list[] = array("name" => $result["field_sname"], "required" => $result["field_req"]);
          }
        }
        ?>
        <script language="JavaScript" type="text/javascript">
        var sample_number = 1;

        function showSample(field_name) {
          if((!sample_number) || (sample_number == 'undefined') || (sample_number == '') || (sample_number < 1) || (sample_number > <?= @count($IMPORT_SAMPLE) ?>)) {
            sample_number = 1;
          }

          var sample_data = new Array();
          <?php
          if(@count($IMPORT_SAMPLE) > 0) {
            foreach($IMPORT_SAMPLE as $example => $sample_data) {
              if((is_array($sample_data)) && (count($sample_data))) {
                $example = (($_POST["options"]["firstrowfields"] == "1") ? $example : ($example + 1));
                echo "sample_data[".$example."] = new Array();\n";
                foreach($sample_data as $column => $data) {
                  echo "sample_data[".$example."][".$column."] = '".(($data != "") ? addslashes(limit_chars($data, 35)) : "-- empty --")."';\n";
                }
                echo "\n";
              }
            }
          }
          ?>
          if (field_name != "") {
            if (document.getElementById(field_name).options[document.getElementById(field_name).selectedIndex].value != "") {
              document.getElementById('sample_'+field_name).innerHTML = sample_data[sample_number][document.getElementById(field_name).options[document.getElementById(field_name).selectedIndex].value];
            } else {
              document.getElementById('sample_'+field_name).innerHTML = '';
            }
          } else {
            return;
          }
        }

        function navigateSamples(number) {
          sample_number = number;
          <?php
          foreach($field_list as $field) {
            echo "showSample('".$field["name"]."');\n";
          }
          ?>
          return;
        }
        </script>
        <h1>Import Mailing List</h1>
        <?php
        if($ERROR) {
          echo display_error($ERRORSTR);
        }

        if($NOTICE) {
          echo display_notice($NOTICESTR);
        }
        ?>
        Please choose the matching column information using the table below. The column on the left hand side is a list of all fields that currently reside within ListMessenger, including any custom fields you've created. The list of columns in the select boxes are a list fields that ListMessenger is able to import based on the data that you're trying to import. You need to match the columns that your importing to the appropriate column on the left.
        <br /><br />
        <form action="index.php?section=import-export&action=import&step=3" method="post">
        <input type="hidden" name="import_filename" value="<?php echo html_encode($IMPORT_FILENAME); ?>" />
        <?php
        switch($_POST["type"]) {
          case "excel" :
            echo "<input type=\"hidden\" name=\"type\" value=\"excel\" />\n";
          break;
          case "csv" :
            echo "<input type=\"hidden\" name=\"type\" value=\"csv\" />\n";
            echo "<input type=\"hidden\" name=\"csv[fields_enclosed]\" value=\"".html_encode(checkslashes($_POST["csv"]["fields_enclosed"], 1))."\" />\n";
            echo "<input type=\"hidden\" name=\"csv[fields_delimited]\" value=\"".html_encode(checkslashes($_POST["csv"]["fields_delimited"], 1))."\" />\n";
          break;
          case "text" :
            echo "<input type=\"hidden\" name=\"type\" value=\"csv\" />\n";
            echo "<input type=\"hidden\" name=\"csv[fields_enclosed]\" value=\"".html_encode(checkslashes($_POST["text"]["fields_enclosed"], 1))."\" />\n";
            echo "<input type=\"hidden\" name=\"csv[fields_delimited]\" value=\"".html_encode(checkslashes($_POST["text"]["fields_delimited"], 1))."\" />\n";
          break;
        }

        foreach($_POST["group_ids"] as $group_id) {
          echo "<input type=\"hidden\" name=\"group_ids[]\" value=\"".$group_id."\" />\n";
        }

        foreach($field_list as $field) {
          if($field["required"] == "1") {
            echo "<input type=\"hidden\" name=\"required_fields[]\" value=\"".$field["name"]."\" />\n";
          }
        }
        ?>
        <input type="hidden" name="options[confirmation]" value="<?= $_POST["options"]["confirmation"] ?>" />
        <input type="hidden" name="options[firstrowfields]" value="<?= $_POST["options"]["firstrowfields"] ?>" />
        <input type="hidden" name="options[dupecheck]" value="<?= $_POST["options"]["dupecheck"] ?>" />
        <table style="width: 100%" cellspacing="1" cellpadding="3" border="0">
        <tr>
          <td style="width: 33%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap"><strong>ListMessenger Field Names</strong></td>
          <td style="width: 1%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap">&nbsp;</td>
          <td style="width: 33%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap"><strong>Imported Column Names</strong></td>
          <td style="width: 33%; height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap"><strong>Sample Output</strong></td>
        </tr>
        <?php
        foreach($field_list as $field) {
          echo "<tr>\n";
          echo "  <td class=\"form-row-".(($field["required"] != 1) ? "n" : "")."req\">".$field["name"]."</td>\n";
          echo "  <td>=</td>\n";
          echo "  <td >\n";
          echo "    <select name=\"fields[".$field["name"]."]\" onkeypress=\"return handleEnter(this, event)\" id=\"".$field["name"]."\" onchange=\"showSample('".$field["name"]."')\">\n";
          echo "    <option value=\"\">-- Do not import --</option>\n";
                foreach($IMPORT_FIELDS as $column_number => $column_name) {
                  echo "<option value=\"".$column_number."\"".(($field["name"] == variable_name($column_name)) ? " selected=\"selected\"" : "").">Column ".($column_number + 1)." ".(($column_name != "") ? "[".$column_name."]" : "")."</option>\n";
                }
          echo "    </select>\n";
          echo "  </td>\n";
          echo "  <td class=\"small-grey\"><div id=\"sample_".$field["name"]."\">&nbsp;</div></td>\n";
          echo "</tr>\n";
        }
        ?>
        <tr>
          <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
          <td style="text-align: right">Show sample output using:</td>
          <td>
            <select onkeypress="return handleEnter(this, event)" onchange="navigateSamples(this.options[selectedIndex].value)">
            <?php
            for($i = 1; $i <= @count($IMPORT_SAMPLE); $i++) {
              echo "<option value=\"".$i."\">Row ".$i."</option>\n";
            }
            ?>
            </select>
          </td>
        </tr>
        </table>
        <br /><br />
        <table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
        <tr>
          <td colspan="2" style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
            <input type="button" value="Cancel" class="button" onclick="window.location='index.php?section=import-export&action=import'" />
            <input type="submit" value="Import List" class="button" />
          </td>
        </tr>
        </table>
        <?php
        $ONLOAD[] = "navigateSamples('1')";
      break;
      case "3" :
        if(!@unlink($_SESSION["config"][PREF_PRIVATE_PATH]."tmp/".$IMPORT_FILENAME)) {
          $NOTICE++;
          $NOTICESTR[] = "ListMessenger was unable to remove the temporary file [".$IMPORT_FILENAME."] it used to import your subscribers. Please remove this file manually from your private tmp directory.";
        }
        ?>
        <h1>Import Mailing List</h1>
        <?= (($ERROR) ? display_error($ERRORSTR) : "") ?>
        <?= (($NOTICE) ? display_notice($NOTICESTR) : "") ?>
        <?= (($SUCCESS) ? display_success($SUCCESSSTR) : "") ?>
        <br /><br />
        <table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
        <tr>
          <td colspan="2" style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
            <input type="button" value="Finished" class="button" onclick="window.location='index.php?section=import-export&action=import'" />
          </td>
        </tr>
        </table>
        <?php
      break;
      default :
        $ONLOAD[]  = "setImportType('".((@in_array($_POST["type"], array("excel", "csv", "text"))) ? $_POST["type"] : "excel")."')";
        $allowall  = true;

        if(version_compare(phpversion(), "4.3.0", "<")) {
          $NOTICE++;
          $NOTICESTR[]  = "Please note that we recommend using PHP 4.3.0 or higher when using the importing system. You are currently running PHP ".phpversion().", please contact your administrator and ask them to upgrade.";
          $allowall    = false;
        }
        ?>
        <div style="display: <?= (in_array("notes", $COLLAPSED) ? "none" : "inline") ?>" id="opened_notes">
          <table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
          <tr>
            <td class="cursor" style="height: 15px; background-image: url('./images/table-head-on.gif'); background-color: #EEEEEE; border-bottom: 1px #CCCCCC solid" onclick="toggle_section('notes', 1, '<?= javascript_cookie(); ?>', 'import-export')">
              <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td style="width: 95%; text-align: left"><span class="search-on">Important Importing Notes</span></td>
                <td style="width: 5%; text-align: right"><a href="javascript: toggle_section('notes', 1, '<?= javascript_cookie(); ?>', 'import-export')"><img src="./images/section-hide.gif" width="9" height="9" alt="Hide" title="Hide Important Notes" border="0" /></a></td>
              </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding: 3px">
              Before you being, please be aware of the following:
              <ol>
                <li>If you are importing a large number of subscribers, we recommend breaking your list into several smaller files of 1500 rows or less. Doing this will prevent server timeouts during the import.</li>
                <li>If you are planning on sending opt-in requests (recommended) to your subscribers during the import we recommend smaller import files of around 500 rows to avoid flooding your mail server.</li>
              </ol>
            </td>
          </tr>
          </table>
        </div>
        <div style="display: <?= (!in_array("notes", $COLLAPSED) ? "none" : "inline") ?>" id="closed_notes">
          <table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
          <tr>
            <td class="cursor" style="height: 15px; background-image: url('./images/table-head-off.gif'); background-color: #EEEEEE" onclick="toggle_section('notes', 0, '<?= javascript_cookie(); ?>', 'import-export')">
              <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td style="width: 95%; text-align: left"><span class="search-off">Important Importing Notes</span></td>
                <td style="width: 5%; text-align: right"><a href="javascript: toggle_section('notes', 0, '<?= javascript_cookie(); ?>', 'import-export')"><img src="./images/section-show.gif" width="9" height="9" alt="Show" title="Show Important Notes" border="0" /></a></td>
              </tr>
              </table>
            </td>
          </tr>
          </table>
        </div>
        <h1>Import Mailing List</h1>
        <img src="images/record-next-on.gif" width="9" height="9" hspace="2" vspace="2"  style="vertical-align: middle" alt="" title="" /> <a href="index.php?section=import-export">Import &amp; Export</a>&nbsp;
        <img src="images/record-next-on.gif" width="9" height="9" hspace="2" vspace="2"  style="vertical-align: middle" alt="" title="" /> Import Mailing List
        <br /><br />
        <?php echo (($ERROR) ? display_error($ERRORSTR) : ""); ?>
        <?php echo (($NOTICE) ? display_notice($NOTICESTR) : ""); ?>
        <h2>Imported Data Source</h2>
        <form action="index.php?section=import-export&action=import&step=2" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo return_bytes(@ini_get("post_max_size")); ?>" />
        <table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
        <colgroup>
          <col style="width: 3%" />
          <col style="width: 97%" />
        </colgroup>
        <thead>
          <tr>
            <td><input type="radio" id="type_excel" name="type" value="excel" onclick="setImportType('excel')" onkeypress="return handleEnter(this, event)"<?= (((!$_POST["type"]) || ($_POST["type"] == "excel")) ? " checked=\"checked\"" : "") ?> /></td>
            <td><label for="type_excel">I would like to upload and import a Microsoft Excel file.</label></td>
          </tr>
          <?php if($allowall) : ?>
          <tr>
            <td><input type="radio" id="type_csv" name="type" value="csv" onclick="setImportType('csv')" onkeypress="return handleEnter(this, event)"<?= (($_POST["type"] == "csv") ? " checked=\"checked\"" : "") ?> /></td>
            <td><label for="type_csv">I would like to upload and import a Comma Separated Values (CSV) file.</label></td>
          </tr>
          <tr>
            <td><input type="radio" id="type_text" name="type" value="text" onclick="setImportType('text')" onkeypress="return handleEnter(this, event)"<?= (($_POST["type"] == "text") ? " checked=\"checked\"" : "") ?> /></td>
            <td><label for="type_text">I would like to paste CSV data into a textarea to import.</label></td>
          </tr>
          <?php endif; ?>
        </thead>
        <tbody id="excel">
          <tr>
            <td>&nbsp;</td>
            <td>
              <table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
              <tr>
                <td style="width: 35%" class="form-row-req">Select Your Local XLS File:</td>
                <td style="width: 65%"><input type="file" name="xlsfile" class="file" size="30" onkeypress="return handleEnter(this, event)" /></td>
              </tr>
              <tr>
                <td class="small-grey" colspan="2">
                  <strong>Important Notice:</strong> Please be aware that your server's maximum upload file size is set to <?= readable_size(return_bytes(@ini_get("upload_max_filesize"))) ?> and that we suggest making your import files small than 1,000 rows at a time to prevent server timeouts.
                </td>
              </tr>
              </table>
            </td>
          </tr>
        </tbody>
        <tbody id="csv" style="display: none">
          <tr>
            <td>&nbsp;</td>
            <td>
              <table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
              <tr>
                <td style="width: 35%" class="form-row-req">Select Your Local CSV File:</td>
                <td style="width: 65%"><input type="file" name="csvfile" class="file" size="30" onkeypress="return handleEnter(this, event)" /></td>
              </tr>
              <tr>
                <td class="small-grey" colspan="2">
                  <strong>Important Notice:</strong> Please be aware that your server's maximum upload file size is set to <?= readable_size(return_bytes(@ini_get("upload_max_filesize"))) ?> and that we suggest making your import files small than 1,000 rows at a time to prevent server timeouts.
                  <br /><br />
                </td>
              </tr>
              <tr>
                <td class="form-row-req">Fields Enclosed By:</td>
                <td><input type="text" class="text-box" name="csv[fields_enclosed]" value="<?= (($_POST["type"] == "csv") ? html_encode($_POST["csv"]["fields_enclosed"], ENT_QUOTES) : "&quot;") ?>" style="width: 15px" onkeypress="return handleEnter(this, event)" /></td>
              </tr>
              <tr>
                <td class="form-row-req">Fields Delimited By:</td>
                <td><input type="text" class="text-box" name="csv[fields_delimited]" value="<?= (($_POST["type"] == "csv") ? html_encode($_POST["csv"]["fields_delimited"], ENT_QUOTES) : ",") ?>" style="width: 15px" onkeypress="return handleEnter(this, event)" /></td>
              </tr>
              </table>
            </td>
          </tr>
        </tbody>
        <tbody id="text" style="display: none">
          <tr>
            <td>&nbsp;</td>
            <td>
              <table style="width: 100%" cellspacing="0" cellpadding="2" border="0">
              <tr>
                <td class="form-row-req" colspan="2">Please Paste CSV Data Below:</td>
              </tr>
              <tr>
                <td colspan="2" style="padding-left: 5px">
                  <textarea name="text[data]" style="width: 97%; height: 125px"><?= (($_POST["type"] == "text") ? checkslashes($_POST["text"]["data"], 1) : "") ?></textarea>
                </td>
              </tr>
              <tr>
                <td class="small-grey" colspan="2">
                  <strong>Important Notice:</strong> Please be aware that your server's maximum post size is set to <?= readable_size(return_bytes(@ini_get("post_max_size"))) ?> and that we suggest importing less than 1,000 rows at a time to prevent server timeouts.
                  <br /><br />
                </td>
              </tr>
              <tr>
                <td style="width: 35%" class="form-row-req">Fields Enclosed By:</td>
                <td style="width: 65%"><input type="text" class="text-box" name="text[fields_enclosed]" value="<?= (($_POST["type"] == "text") ? html_encode($_POST["text"]["fields_enclosed"], ENT_QUOTES) : "&quot;") ?>" style="width: 15px" onkeypress="return handleEnter(this, event)" /></td>
              </tr>
              <tr>
                <td class="form-row-req">Fields Delimited By:</td>
                <td><input type="text" class="text-box" name="text[fields_delimited]" value="<?= (($_POST["type"] == "text") ? html_encode($_POST["text"]["fields_delimited"], ENT_QUOTES) : ",") ?>" style="width: 15px" onkeypress="return handleEnter(this, event)" /></td>
              </tr>
              </table>
            </td>
          </tr>
        </tbody>
        <tr>
          <td colspan="2">
            <h2>Imported Data Destination</h2>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            Please select the group or groups that you would like these importees subscribed to:
            <select name="group_ids[]" style="margin-top: 5px; width: 97%" multiple="multiple" size="7" onkeypress="return handleEnter(this, event)">
            <?php echo groups_inselect(0, $_POST["group_ids"]); ?>
            </select>
            <br />
            <span class="small-grey"><strong>Notice:</strong> The importee will only receive one opt-in message for all groups you select here.</span>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <h2>Import Options</h2>
          </td>
        </tr>
        <tr>
          <td><input type="checkbox" id="options_confirmation" name="options[confirmation]" value="1" onkeypress="return handleEnter(this, event)"<?= (($_POST["options"]["confirmation"] == "1") ? " checked=\"checked\"" : "") ?> /></td>
          <td><label for="options_confirmation">Please send all importees opt-in notices prior to adding them to the selected groups.</label></td>
        </tr>
        <tr>
          <td><input type="checkbox" id="options_firstrowfields" name="options[firstrowfields]" value="1" onkeypress="return handleEnter(this, event)"<?= (((!$_POST) || ($_POST["options"]["firstrowfields"] == "1")) ? " checked=\"checked\"" : "") ?> /></td>
          <td><label for="options_firstrowfields">The first row in the file/data contains the field names; try to match those.</label></td>
        </tr>
        <tr>
          <td><input type="checkbox" id="options_dupecheck" name="options[dupecheck]" value="1" onkeypress="return handleEnter(this, event)"<?= (((!$_POST) || ($_POST["options"]["dupecheck"] == "1")) ? " checked=\"checked\"" : "") ?> /></td>
          <td><label for="options_dupecheck">Check for duplicates to ensure only one e-mail address is in each group.</label></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: right; border-top: 1px #333333 dotted; padding-top: 5px">
            <input type="button" value="Cancel" class="button" onclick="window.location='index.php?section=control'" />
            <input type="submit" value="Next Step" class="button" />
          </td>
        </tr>
        </table>
        </form>
        <?php
      break;
    }
  break;
  default :
    ?>
    <h1>Import &amp; Export</h1>
    Welcome to the import and export wizard for ListMessenger Pro. This wizard will allow you to import Microsoft Excel <em>(Mac &amp; PC)</em> and Comma Separated Values files in ListMessenger Pro, as well as export to a Comma Separated Values format so you are able to manage your mailing list externally.
    <div style="height: 25px">&nbsp;</div>
    <table style="width: 100%" cellspacing="0" cellpadding="5" border="0">
    <tr>
      <td style="width: 10%; text-align: center"><a href="./index.php?section=import-export&action=import"><img src="./images/icon-import.gif" width="48" height="48" alt="Import Mailing List" title="Import Mailing List" border="0" /></a></td>
      <td style="width: 90%; text-align: left">
        <h2>Import Mailing List</h2>
        Please <a href="./index.php?section=import-export&action=import">click here</a> if you wish to import your mailing list into ListMessenger.
      </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td style="width: 10%; text-align: center"><a href="./index.php?section=import-export&action=export"><img src="./images/icon-export.gif" width="48" height="48" alt="Export Mailing List" title="Export Mailing List" border="0" /></a></td>
      <td style="width: 90%; text-align: left">
        <h2>Export Mailing List</h2>
        Please <a href="./index.php?section=import-export&action=export">click here</a> if you wish to export your mailing list from ListMessenger.
      </td>
    </tr>
    </table>
    <?php
  break;
}
?>