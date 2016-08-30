<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: archive.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

// Change the $LM_PATH variable in the eu_config.inc.php file in this directory.
require_once("./public_config.inc.php");

if(!@file_exists($LM_PATH."includes/config.inc.php")) {
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
	echo "<head>\n";
	echo "	<title>ListMessenger Path Error</title>\n";
	echo "	<style type=\"text/css\">\n";
	echo "	div.error-message {\n";
	echo "		background-color:	#FFD9D0;\n";
	echo "		border:				1px #CC0000 solid;\n";
	echo "		padding:			8px;\n";
	echo "		color:				#333333;\n";
	echo "		font-family:		Verdana, Arial, Helvetica, sans-serif;\n";
	echo "		font-size:			12px;\n";
	echo "		margin-bottom:		10px;\n";
	echo "	}\n";
	echo "	</style>\n";
	echo "</head>\n";
	echo "<body>\n";
	echo "<div class=\"error-message\">\n";
	echo "	The path to the ListMessenger directory that you've provided [<strong>".$LM_PATH."</strong>] appears to be invalid or PHP does not have permission to read files from this directory. Please ensure that you provide the full path from root to your ListMessenger program directory in the \$LM_PATH variable within this file [<strong>".__FILE__."</strong>].";
	echo "</div>\n";
	echo "</body>\n";
	echo "</html>\n";
	exit;
} else {
	@ini_set("include_path", str_replace("\\", "/", $LM_PATH."/includes"));
	@ini_set("allow_url_fopen", 1);
	@ini_set("error_reporting",  E_ALL ^ E_NOTICE);
	@ini_set("magic_quotes_runtime", 0);

	define("TOOLS_LOADED",	true);
	require_once("eu_header.inc.php");

	if($config[ENDUSER_ARCHIVE] =="yes") {
		switch($info["view"]) {
			case "html" :
				$displayed = false;

				if((isset($info["id"])) && ((int) $info["id"])) {
					$query	= "
							SELECT a.`html_template`, a.`html_message`, a.`text_template`, a.`text_message`
							FROM `".TABLES_PREFIX."messages` AS a
							LEFT JOIN `".TABLES_PREFIX."queue` AS b
							ON b.`message_id` = a.`message_id`
							WHERE a.`message_id` = ".$db->qstr((int) $info["id"], get_magic_quotes_gpc())."
							AND b.`status` = 'Complete'";
					$result	= $db->GetRow($query);
					if($result) {
						$html_version = insert_template("html", $result["html_template"], $result["html_message"])."\n";
						if(trim(strip_tags($html_version))) {
							echo $html_version;
							$displayed = true;
						} else {
							$text_version = insert_template("text", $result["text_template"], $result["text_message"])."\n";
							if(trim(strip_tags($text_version))) {
								echo nl2br($text_version);
								$displayed = true;
							}
						}
					}
				}

				if(!$displayed) {
					echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
					echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
					echo "<head>\n";
					echo "	<title>".$language_pack["page_archive_error_html_title"]."</title>\n";
					echo "</head>\n";
					echo "<body>\n";
					echo "<div style=\"font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; background-color: #FFFFCC; border: 1px #FFCC00 solid; padding: 5px\">\n";
					echo "	".$language_pack["page_archive_error_no_message"]."\n";
					echo "</div>\n";
					echo "</body>\n";
					echo "</html>\n";
				}
				exit;
			break;
			case "rss" :
				require_once("classes/feedcreator/feedcreator.class.php");

				$rss = new UniversalFeedCreator();
				$rss->useCached();

				$rss->title				= $language_pack["page_archive_rss_title"];
				$rss->description		= $language_pack["page_archive_rss_description"];
				$rss->link				= (($language_pack["page_archive_rss_link"]) ? $language_pack["page_archive_rss_link"] : $config[PREF_PUBLIC_URL].$config[ENDUSER_HELP_FILENAME]);
				$rss->syndicationURL	= $config[PREF_PUBLIC_URL].$config[ENDUSER_ARCHIVE]."?view=rss";

				$query		= "
							SELECT a.*, b.*
							FROM `".TABLES_PREFIX."messages` AS a
							LEFT JOIN `".TABLES_PREFIX."queue` AS b
								ON b.`message_id` = a.`message_id`
							WHERE b.`status` = 'Complete'
							GROUP BY a.`message_id`
							ORDER BY b.`date` DESC";
				$results	= $db->GetAll($query);
				if($results) {
					foreach($results as $result) {
						if(trim(strip_tags($result["html_message"]))) {
							$rss_description = insert_template("html", $result["html_template"], $result["html_message"]);
						} else {
							$rss_description = nl2br(insert_template("text", $result["text_template"], $result["text_message"]));
						}

						$item = new FeedItem();
						$item->title		= $result["message_subject"];
						$item->link			= $config[PREF_PUBLIC_URL].$config[ENDUSER_ARCHIVE_FILENAME]."?view=html&id=".$result["message_id"];
						$item->description	= $rss_description;
						$item->date			= date("r", $result["date"]);
						$item->author		= $result["message_reply"];
						$rss->addItem($item);
					}
				}
				echo $rss->createFeed();
				exit;
			break;
			default :
				if((isset($info["id"])) && ((int) $info["id"])) {
					$TITLE		= $language_pack["page_archive_view_title"];
					$MESSAGE	= "";

					$query	= "
							SELECT a.*, b.*
							FROM `".TABLES_PREFIX."messages` AS a
							LEFT JOIN `".TABLES_PREFIX."queue` AS b
							ON b.`message_id` = a.`message_id`
							WHERE a.`message_id` = ".$db->qstr((int) $info["id"], get_magic_quotes_gpc())."
							AND b.`status` = 'Complete'";
					$result	= $db->GetRow($query);
					if($result) {
						$groups			= array();
						$to				= unserialize($result["target"]);
						$attachments	= unserialize($result["attachments"]);

						if(is_array($to)) {
							$groups		= groups_information($to);
						} else {
							$groups[]	= array("name" => "Unknown Receiver");
						}

						$MESSAGE .= "<table style=\"width: 100%\" cellspacing=\"0\" cellpadding=\"2\" border=\"0\">\n";
						$MESSAGE .= "<tbody>\n";
						$MESSAGE .= "	<tr>\n";
						$MESSAGE .= "		<td style=\"width: 12%; white-space: nowrap; text-align: right; padding-right: 5px; color: #666666; font-weight: bold\">".$language_pack["page_archive_view_from"]."</td>\n";
						$MESSAGE .= "		<td style=\"width: 88%; padding-left: 3px\">".html_encode($result["message_from"])."</td>\n";
						$MESSAGE .= "	</tr>\n";
						$MESSAGE .= "	<tr>\n";
						$MESSAGE .= "		<td style=\"white-space: nowrap; text-align: right; padding-right: 5px; color: #666666; font-weight: bold\">".$language_pack["page_archive_view_subject"]."</td>\n";
						$MESSAGE .= "		<td style=\"padding-left: 3px; font-weight: bold\">".html_encode($result["message_subject"])."</td>\n";
						$MESSAGE .= "	</tr>\n";
						$MESSAGE .= "	<tr>\n";
						$MESSAGE .= "		<td style=\"white-space: nowrap; text-align: right; padding-right: 5px; color: #666666; font-weight: bold\">".$language_pack["page_archive_view_date"]."</td>\n";
						$MESSAGE .= "		<td style=\"padding-left: 3px\">".display_date($config[PREF_DATEFORMAT], $result["date"], false)."</td>\n";
						$MESSAGE .= "	</tr>\n";
						$MESSAGE .= "	<tr>\n";
						$MESSAGE .= "		<td style=\"white-space: nowrap; text-align: right; padding-right: 5px; color: #666666; font-weight: bold; vertical-align: top\">".$language_pack["page_archive_view_to"]."</td>\n";
						$MESSAGE .= "		<td style=\"padding-left: 3px\">\n";
						foreach($groups as $group) {
							$MESSAGE .= "		&rarr; ".$group["name"]."<br />\n";
						}
						$MESSAGE .= "		</td>\n";
						$MESSAGE .= "	</tr>\n";
						if((@is_array($attachments)) && (@count($attachments) > 0)) {
							$MESSAGE .= "<tr>\n";
							$MESSAGE .= "	<td style=\"white-space: nowrap; text-align: right; padding-right: 5px; color: #666666; font-weight: bold; vertical-align: top\">".$language_pack["page_archive_view_attachments"]."</td>\n";
							$MESSAGE .= "	<td style=\"padding-left: 3px\">\n";
							foreach($attachments as $attachment) {
								if(@file_exists($config[PREF_PUBLIC_PATH]."files/".$attachment)) {
									$MESSAGE .= "&rarr; <a href=\"".$config[PREF_PUBLIC_URL]."files/".html_encode($attachment)."\">".html_encode($attachment)."</a> <span style=\"color: #666666; font-style: oblique\">(".readable_size(@filesize($config[PREF_PUBLIC_PATH]."files/".$attachment)).")</span><br />\n";
								} else {
									$MESSAGE .= "<div style=\"background-color: #FFFFCC; border: 1px #FFCC00 solid; padding: 2px\">".$language_pack["page_archive_view_missing_attachment"]." (".$attachment.").</div>\n";
								}
							}
							$MESSAGE .= "	</td>\n";
							$MESSAGE .= "</tr>\n";
						}
						$MESSAGE .= "<tr>\n";
						$MESSAGE .= "	<td colspan=\"2\" style=\"border-bottom: 1px #CCCCCC solid\">&nbsp;</td>\n";
						$MESSAGE .= "</tr>\n";
						$MESSAGE .= "<tr>\n";
						$MESSAGE .= "	<td colspan=\"2\" style=\"padding-top: 10px\">\n";
						if(trim(strip_tags($result["html_message"])) == "") {
							$MESSAGE .= checkslashes(nl2br(html_encode(trim(insert_template("text", $result["text_template"], $result["text_message"])))), 1);
						} else {
							$MESSAGE .= "<iframe name=\"HTMLMessage\" style=\"width: 100%; height: 400px; margin: 0px; padding: 0px; border: 0px\" src=\"".$config[PREF_PUBLIC_URL].$config[ENDUSER_ARCHIVE_FILENAME]."?view=html&id=".$result["message_id"]."\"></iframe>\n";
						}
						$MESSAGE .= "	</td>\n";
						$MESSAGE .= "</tr>\n";
						$MESSAGE .= "</table>\n";
					} else {
						$MESSAGE .= "<div class=\"error-message\">\n";
						$MESSAGE .= "	".$language_pack["page_archive_error_no_message"]."\n";
						$MESSAGE .= "</div>\n";
						$MESSAGE .= "<script language=\"JavaScript\" type=\"text/javascript\">\n";
						$MESSAGE .= "setTimeout('window.location=\'".$config[PREF_PUBLIC_URL].$config[ENDUSER_ARCHIVE_FILENAME]."\'', 5000);\n";
						$MESSAGE .= "</script>\n";
					}

				} else {
					$TITLE		= $language_pack["page_archive_opened_title"];
					$MESSAGE	= str_replace("[rssfeed_url]", "<a href=\"".$config[PREF_PUBLIC_URL].$config[ENDUSER_ARCHIVE_FILENAME]."?view=rss\">".$language_pack["page_archive_rss_title"]."</a>", $language_pack["page_archive_opened_message_sentence"])."<br /><br />";
					$query		= "
								SELECT a.*, b.*
								FROM `".TABLES_PREFIX."messages` AS a
								LEFT JOIN `".TABLES_PREFIX."queue` AS b
								ON b.`message_id` = a.`message_id`
								WHERE b.`status` = 'Complete'
								GROUP BY a.`message_id`
								ORDER BY b.`date` DESC";
					$results	= $db->GetAll($query);
					if($results) {
						$MESSAGE .= "<table style=\"width: 100%\" cellspacing=\"0\" cellpadding=\"2\" border=\"0\">\n";
						$MESSAGE .= "<colgroup>\n";
						$MESSAGE .= "	<col style=\"width: 50%\" />\n";
						$MESSAGE .= "	<col style=\"width: 25%\" />\n";
						$MESSAGE .= "	<col style=\"width: 25%\" />\n";
						$MESSAGE .= "</colgroup>\n";
						$MESSAGE .= "<thead>\n";
						$MESSAGE .= "	<tr>\n";
						$MESSAGE .= "		<td style=\"border-bottom: 2px #CCCCCC solid; padding-left: 3px; font-weight: bold\">".$language_pack["page_archive_view_message_subject"]."</td>\n";
						$MESSAGE .= "		<td style=\"border-bottom: 2px #CCCCCC solid; padding-left: 3px; font-weight: bold\">".$language_pack["page_archive_view_message_from"]."</td>\n";
						$MESSAGE .= "		<td style=\"border-bottom: 2px #CCCCCC solid; padding-left: 3px; font-weight: bold\">".$language_pack["page_archive_view_message_sent"]."</td>\n";
						$MESSAGE .= "	</tr>\n";
						$MESSAGE .= "</thead>\n";
						$MESSAGE .= "<tbody>\n";
						foreach($results as $result) {
							$pieces		= explode("\" <", $result["message_from"]);
							$name		= substr($pieces[0], 1);
							$address	= substr($pieces[1], 0, -1);

							$MESSAGE .= "<tr>\n";
							$MESSAGE .= "	<td style=\"padding-left: 3px; cursor: pointer; cursor: hand\" onclick=\"window.location='".$config[PREF_PUBLIC_URL].$config[ENDUSER_ARCHIVE_FILENAME]."?id=".$result["message_id"]."'\"><a href=\"".$config[PREF_PUBLIC_URL].$config[ENDUSER_ARCHIVE_FILENAME]."?id=".$result["message_id"]."\">".html_encode($result["message_subject"])."</a></td>\n";
							$MESSAGE .= "	<td style=\"padding-left: 3px; cursor: pointer; cursor: hand\" onclick=\"window.location='".$config[PREF_PUBLIC_URL].$config[ENDUSER_ARCHIVE_FILENAME]."?id=".$result["message_id"]."'\"><a href=\"".$config[PREF_PUBLIC_URL].$config[ENDUSER_ARCHIVE_FILENAME]."?id=".$result["message_id"]."\">".html_encode($name)."</a></td>\n";
							$MESSAGE .= "	<td style=\"padding-left: 3px; cursor: pointer; cursor: hand\" onclick=\"window.location='".$config[PREF_PUBLIC_URL].$config[ENDUSER_ARCHIVE_FILENAME]."?id=".$result["message_id"]."'\">".display_date($config[PREF_DATEFORMAT], $result["date"], false)."</td>\n";
							$MESSAGE .= "</tr>\n";
						}
						$MESSAGE .= "</tbody>\n";
						$MESSAGE .= "</table>\n";
					} else {
						$MESSAGE .= "<div style=\"background-color: #FFFFCC; border: 1px #FFCC00 solid; padding: 5px\">\n";
						$MESSAGE .= "	".$language_pack["page_archive_error_no_messages"]."\n";
						$MESSAGE .= "</div>\n";
					}

				}
			break;
		}
	} else {
		$abuse		= encode_address($config[PREF_ABUEMAL_ID]);
		$TITLE		= $language_pack["page_archive_closed_title"];
		$MESSAGE	= $language_pack["page_archive_closed_message_sentence"];
		$MESSAGE	= str_replace("[abuse_address]", "<a href=\"mailto:".$abuse["address"]."\" style=\"font-weight: strong\">".$abuse["text"]."</a>", $MESSAGE);
	}

	require_once("eu_footer.inc.php");
}
?>