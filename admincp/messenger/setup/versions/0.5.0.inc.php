<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: 0.5.0.inc.php 107 2007-03-25 19:49:18Z matt.simpson $

	Requirements of 0.9.3 -> 2.1:
	=================================================
	New: cdata			Action: none (new table)
	New: cfields			Action: none (new table)
	New: confirmation		Action: none (new table)
	New: groups			Action: upgrade "user_groups"
	New: messages			Action: upgrade "sent_messages"
	New: preferences		Action: none (already complete)
	New: queue			Action: none (new table)
	New: sending			Action: none (should be empty)
	New: templates			Action: none ("sent_templates" unused)
	New: users			Action: upgrade "user_list"

*/

if(!defined("IN_SETUP"))		exit;

// Groups
$query	= "SELECT * FROM `".TABLES_PREFIX."groups` WHERE `groups_id`='-1';";
$rs		= $db->Execute($query);

$query	= "SELECT * FROM `".TABLES_PREFIX."user_groups` ORDER BY `group_id` ASC";
$results	= $db->GetAll($query);
if($results) {
	foreach($results as $result) {
		$record				= array();
		$record["groups_id"]	= addslashes($result["group_id"]);
		$record["group_name"]	= addslashes($result["group_name"]);
		$record["group_parent"]	= addslashes($result["belongs_to"]);

		$query =  $db->GetInsertSQL($rs, $record, true);
		if($query != "") {
			if(!$db->Execute($query)) {
				echo "Groups: Didn't work [".$result["id"]."]: ".$db->ErrorMsg()."<br />\n";
			}
		}
	}
} else {
	// Nothing to do, great!
}

// Messages & Queue
$query	= "SELECT * FROM `".TABLES_PREFIX."messages` WHERE `message_id`='-1';";
$rs1		= $db->Execute($query);

$query	= "SELECT * FROM `".TABLES_PREFIX."queue` WHERE `queue_id`='-1';";
$rs2		= $db->Execute($query);

$query	= "SELECT * FROM `".TABLES_PREFIX."sent_messages` ORDER BY `email_id` ASC";
$results	= $db->GetAll($query);
if($results) {
	foreach($results as $result) {
		$record					= array();
		$record["message_id"]		= addslashes($result["email_id"]);
		$record["message_date"]		= addslashes($result["email_date"]);
		$record["message_title"]		= addslashes($result["email_subject"]);
		$record["message_subject"]	= addslashes($result["email_subject"]);
		$record["message_from"]		= "\"".addslashes($PREFERENCES[PREF_FRMNAME_ID])."\" <".addslashes($PREFERENCES[PREF_FRMEMAL_ID]).">";
		$record["message_reply"]		= "\"".addslashes($PREFERENCES[PREF_FRMNAME_ID])."\" <".addslashes($PREFERENCES[PREF_RPYEMAL_ID]).">";
		$record["message_priority"]	= "3";
		$record["text_message"]		= addslashes($result["email_text"]);
		$record["html_message"]		= addslashes($result["email_html"]);

		$query =  $db->GetInsertSQL($rs1, $record, true);
		if($query != "") {
			if(!$db->Execute($query)) {
				echo "Messages: Didn't work [".$result["id"]."]: ".$db->ErrorMsg()."<br />\n";
			} else {
				$record				= array();
				$record["queue_id"]		= "";
				$record["message_id"]	= addslashes($result["email_id"]);
				$record["date"]		= addslashes($result["email_date"]);
				$record["touch"]		= addslashes($result["email_date"]);
				$record["target"]		= addslashes(serialize(array(trim($result["email_to"]))));
				$record["progress"]		= addslashes($result["num_sent"]);
				$record["total"]		= addslashes($result["num_sent"]);
				$record["status"]		= "Complete";

				$query =  $db->GetInsertSQL($rs2, $record, true);
				if($query != "") {
					if(!$db->Execute($query)) {
						echo "Queue: Didn't work [".$result["id"]."]: ".$db->ErrorMsg()."<br />\n";
					}
				}
			}
		}
	}
} else {
	// Nothing to do, great!
}

// Users
$query	= "SELECT * FROM `".TABLES_PREFIX."users` WHERE `users_id`='-1';";
$rs		= $db->Execute($query);

$query	= "SELECT * FROM `".TABLES_PREFIX."user_list` ORDER BY `user_id` ASC";
$results	= $db->GetAll($query);
if($results) {
	foreach($results as $result) {
		// Not able to try to figure out when they subscribed, so today it is!
		$signup_date	= time();

		// Try to fix the fullname into first and last name.
		$firstname	= "";
		$lastname		= "";
		if($result["user_name"] != "") {
			$fullname	= explode(" ", $result["user_name"]);
			$pieces	= @count($fullname);
			switch($pieces) {
				case 1 :
					$lastname		= $fullname[0];
				break;
				case 2 :
					$firstname	= $fullname[0];
					$lastname		= $fullname[1];
				break;
				default :
					$firstname	= $fullname[0];
					for($i = 1; $i <= $pieces; $i++) {
						$lastname .= $fullname[$i].(($i < $pieces) ? " " : "");
					}
				break;
			}
		}

		$record					= array();
		$record["users_id"]			= addslashes($result["user_id"]);
		$record["group_id"]			= addslashes($result["group_id"]);
		$record["signup_date"]		= $signup_date;
		$record["firstname"]		= addslashes($firstname);
		$record["lastname"]			= addslashes($lastname);
		$record["email_address"]		= addslashes($result["user_address"]);

		$query =  $db->GetInsertSQL($rs, $record, true);
		if($query != "") {
			if(!$db->Execute($query)) {
				echo "Users: Didn't work [".$result["id"]."]: ".$db->ErrorMsg()."<br />\n";
			}
		}
	}
} else {
	// Nothing to do, great!
}
?>