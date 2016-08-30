<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: queue.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

if(!defined("PARENT_LOADED"))		exit;
if(!$_SESSION["isAuthenticated"])	exit;

$COLLAPSED	= explode(",", $_COOKIE["display"]["queue"]["collapsed"]);

if((isset($_GET["action"])) && (trim($_GET["action"]) != "")) {
	$ACTION = checkslashes($_GET["action"]);
} elseif((isset($_POST["action"])) && (trim($_POST["action"]) != "")) {
	$ACTION = checkslashes($_POST["action"]);
} else {
	$ACTION	= "";
}

switch($ACTION) {
	case "remove" :
		if((isset($_POST["remove"])) && (is_array($_POST["remove"])) && (count($_POST["remove"]))) {
			if((!isset($_POST["confirmed"])) || (!(int) $_POST["confirmed"])) {
				$queue_ids	= array();

				foreach($_POST["remove"] as $queue_id) {
					if($queue_id = (int) $queue_id) {
						$queue_ids[] = $queue_id;
					}
				}

				if(!count($queue_ids)) {
					header("Location: index.php?section=queue");
					exit;
				}
				?>
				<h1>Removing Queue Item<?php echo ((count($_POST["remove"]) != 1) ? "s" : "") ?></h1>
				Please review the list of messages that will be removed from the ListMessenger queue. If you are sure you would like these messages removed click the &quot;Confirmed&quot; button.
				<br /><br />
				<form action="index.php?section=queue&action=remove" method="post">
				<input type="hidden" name="confirmed" value="1" />
				<table style="width: 100%; text-align: left" cellspacing="0" cellpadding="1" border="0">
				<colgroup>
					<col style="width: 4%" />
					<col style="width: 20%" />
					<col style="width: 41%" />
					<col style="width: 13%" />
					<col style="width: 22%" />
				</colgroup>
				<thead>
					<tr>
						<td style="height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap">&nbsp;</td>
						<td style="height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "date") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("date", "Send Date", $order, $sort); ?></td>
						<td style="height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "title") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("title", "Message Title", $order, $sort); ?></td>
						<td style="height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "progress") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("progress", "Progress", $order, $sort); ?></td>
						<td style="height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "status") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("status", "Status", $order, $sort); ?></td>
					</tr>
				</thead>
				<?php
				$query		= "
							SELECT `queue_id`, `".TABLES_PREFIX."queue`.`message_id`, `date`, (CEILING((`progress` / `total`) * 100)) AS `percentage`, `total`, `status`, `".TABLES_PREFIX."messages`.`message_title`
							FROM `".TABLES_PREFIX."queue`
							LEFT JOIN `".TABLES_PREFIX."messages`
								ON `".TABLES_PREFIX."queue`.`message_id` = `".TABLES_PREFIX."messages`.`message_id`
							WHERE `".TABLES_PREFIX."queue`.`queue_id` IN ('".implode("', '", $queue_ids)."')
							ORDER BY `date` DESC";
				$results	= $db->GetAll($query);
				if($results) {
					foreach($results as $result) {
						echo "<tr>\n";
						echo "	<td style=\"height: 20px; white-space: nowrap\"><input type=\"checkbox\" name=\"remove[]\" value=\"".$result["queue_id"]."\" checked=\"checked\" /></td>";
						echo "	<td>".display_date("m/d/Y H:i", $result["date"])."</td>\n";
						echo "	<td>".html_encode(limit_chars($result["message_title"], 38))."</td>\n";
						echo "	<td>".$result["percentage"]."%</td>\n";
						echo "	<td>".$result["status"]." ".(($result["status"] == "Complete") ? "<span class=\"small-grey\">(".$result["total"].")</span>" : "")."</td>\n";
						echo "</tr>\n";
					}
				}
				?>
				<tr>
					<td colspan="5" style="border-top: 1px #333333 dotted; padding-top: 5px; text-align: right">
						<input type="button" value="Cancel" class="button" onclick="window.location='index.php?section=queue'" />
						<input type="submit" value="Confirmed" class="button" />
					</td>
				</tr>
				</table>
				</form>
				<?php
			} else {
				$queue_ids	= array();

				foreach($_POST["remove"] as $queue_id) {
					if($queue_id = (int) $queue_id) {
						$queue_ids[] = $queue_id;
					}
				}

				if(!count($queue_ids)) {
					header("Location: index.php?section=queue");
					exit;
				}

				$query	= "DELETE FROM `".TABLES_PREFIX."queue` WHERE `queue_id` IN ('".implode("', '", $queue_ids)."')";
				if($db->Execute($query)) {
					$ONLOAD[] = "setTimeout('window.location=\'index.php?section=queue\'', 5000)";

					$SUCCESS++;
					$SUCCESSSTR[] = "You have successfully removed the selected queue item".((@count($queue_ids) != 1) ? "s" : "")." from the ListMessenger database and you will be automatically returned to the Queue Mangaer in 5 seconds. <a href=\"index.php?section=queue\">Click here</a> if you prefer not to wait.";

					echo display_success($SUCCESSSTR);
				} else {
					$ONLOAD[] = "setTimeout('window.location=\'index.php?section=queue\'', 5000)";

					$ERROR++;
					$ERRORSTR[] = "Unable to remove the selected queue item".((@count($queue_ids) != 1) ? "s" : "")." from the ListMessenger database. Plase check your ListMessenger error_log for more details.";

					if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
						@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete the selected queue items. Database said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
					}
				}
			}
		} else {
			$ONLOAD[] = "setTimeout('window.location=\'index.php\'', 5000)";

			$ERROR++;
			$ERRORSTR[] = "You did not select any subscribers you wish to delete from the database. To delete a subscriber, click the checkbox beside their name and try again. You will be automatically returned to the subscriber directory in 5 seconds. <a href=\"index.php\">Click here</a> if you prefer not to wait.";

			echo display_error($ERRORSTR);
		}
	break;
	case "resume" :
		$query	= "SELECT `message_id` FROM `".TABLES_PREFIX."queue` WHERE `queue_id`='".checkslashes($_POST["qid"])."'";
		$result	= $db->GetRow($query);
		if($result) {
			header("Location: index.php?section=message&action=resume&qid=".(int) trim($_POST["qid"])."&mid=".$result["message_id"]);
			exit;
		} else {
			$ERROR++;
			$ERRORSTR[] = "The queue item that you are trying to resume cannot be found in the ListMessenger database. Please select a valid queue item to resume sending.";

			echo display_error($ERRORSTR);
		}
	break;
	case "cancel" :
		$query	= "SELECT `message_id` FROM `".TABLES_PREFIX."queue` WHERE `queue_id`='".checkslashes($_POST["qid"])."'";
		$result	= $db->GetRow($query);
		if($result) {
			header("Location: index.php?section=message&action=cancel&qid=".(int) trim($_POST["qid"])."&mid=".$result["message_id"]);
			exit;
		} else {
			$ERROR++;
			$ERRORSTR[] = "The queue item that you are trying to cancel cannot be found in the ListMessenger database. Please select a valid queue item to cancel sending.";

			echo display_error($ERRORSTR);
		}
	break;
	case "prune" :
		if(isset($_GET["prune"])) {
			switch($_GET["prune"]) {
				case "1" :	// Cancelled
					$query	= "DELETE FROM `".TABLES_PREFIX."queue` WHERE `status`='Cancelled'";
					if(!$db->Execute($query)) {
						if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
							@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete queue items with a status of Cancelled. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
						}
					}
				break;
				case "2" :	// Complete
					$query	= "DELETE FROM `".TABLES_PREFIX."queue` WHERE `status`='Complete'";
					if(!$db->Execute($query)) {
						if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
							@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete queue items with a status of Complete. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
						}
					}
				break;
				case "3" :	// Complete
					$query	= "DELETE FROM `".TABLES_PREFIX."queue` WHERE `status`='Preparing'";
					if(!$db->Execute($query)) {
						if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
							@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete queue items with a status of Preparing. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
						}
					}
				break;
				case "4" :	//Queuing
					$query	= "DELETE FROM `".TABLES_PREFIX."queue` WHERE `status`='Queuing'";
					if(!$db->Execute($query)) {
						if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
							@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to delete queue items with a status of Queuing. Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
						}
					}
				break;
				default :
					continue;
				break;
			}
		}
		header("Location: index.php?section=queue");
		exit;
	break;
	default :
		/**
		 * Check for messages which have timed out.
		 */
		$query		= "SELECT `queue_id` FROM `".TABLES_PREFIX."queue` WHERE `touch` < '".(time() - $_SESSION["config"][PREF_QUEUE_TIMEOUT])."' AND `status` = 'Sending'";
		$results	= $db->GetAll($query);
		if($results) {
			foreach($results as $result) {
				$query = "UPDATE `".TABLES_PREFIX."queue` SET `status` = 'Stalled' WHERE `queue_id` = ".$db->qstr($result["queue_id"]);
				if(!$db->Execute($query)) {
					if($_SESSION["config"][PREF_ERROR_LOGGING] == "yes") {
						@error_log(display_date("r", time())."\t".__FILE__." [Line: ".__LINE__."]\tUnable to update queue status to stalled for queue id ".$result["queue_id"].". Database server said: ".$db->ErrorMsg()."\n", 3, $_SESSION["config"][PREF_PRIVATE_PATH]."logs/error_log.txt");
					}
				} else {
					$NOTICE++;
					$NOTICESTR[] = "It appears as though queue id <strong>".(int) $result["queue_id"]."</strong> has stalled. Please resume sending or cancel this message.";
				}
			}
		}
		?>
		<script language="JavaScript" type="text/javascript">
		function pruneQueue() {
			var prunetype = document.getElementById('selectPrune')[document.getElementById('selectPrune').selectedIndex].value;
			switch (prunetype) {
				case '1' :
					pruning = 'Cancelled';
				break;
				case '2' :
					pruning = 'Complete';
				break;
				case '3' :
					pruning = 'Preparing';
				break;
				case '4' :
					pruning = 'Queuing';
				break;
				default :
					alert('Please select a status indicator to prune from the queue.');
					return;
				break;
			}

			Confirmation = confirm('Pressing OK will permanently remove all queues with the status of "'+pruning+'".');
			if (Confirmation == true) {
				document.getElementById('pruneForm').submit();
				return;
			} else {
				return;
			}
		}

		function deSelect(field) {
			if(!field.length) {
				field.checked = false;
			} else {
				for (i = 0; i < field.length; i++) {
					field[i].checked = false;
				}
			}
			return;
		}

		function selectOption(field, type) {
			if(type == 'resume') {
				if(field) {
					deSelect(field);
				}

				document.getElementById('pageAction').value = 'resume';
			} else {
				if(field) {
					deSelect(field);
				}

				document.getElementById('pageAction').value = 'remove';
			}
			return;
		}
		</script>

		<div style="display: <?php echo (in_array("prune", $COLLAPSED) ? "none" : "inline"); ?>" id="opened_prune">
			<table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
			<tr>
				<td class="cursor" style="height: 15px; background-image: url('./images/table-head-on.gif'); background-color: #EEEEEE; border-bottom: 1px #CCCCCC solid" onclick="toggle_section('prune', 1, '<?= javascript_cookie(); ?>', 'queue')">
					<table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td style="width: 95%; text-align: left"><span class="search-on">Queue Pruning</span></td>
						<td style="width: 5%; text-align: right"><a href="javascript: toggle_section('prune', 1, '<?= javascript_cookie(); ?>', 'queue')"><img src="./images/section-hide.gif" width="9" height="9" alt="Hide" title="Hide Pruning" border="0" /></a></td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<form action="index.php" method="get" id="pruneForm">
					<input type="hidden" name="action" value="prune" />
					<input type="hidden" name="section" value="queue" />
					<table style="width: 100%; height: 25px" cellspacing="0" cellpadding="2" border="0">
					<tr>
						<td>
							Prune your queue of sends with the status of:
							<select name="prune" id="selectPrune">
							<option value="">-- Select Status --</option>
							<option value="1">cancelled.</option>
							<option value="2">complete.</option>
							<option value="3">preparing.</option>
							<option value="4">queuing.</option>
							</select>
						</td>
						<td style="text-align: right">
							<input type="button" value="Prune" class="button" onclick="pruneQueue()" />
						</td>
					</tr>
					</table>
					</form>
				</td>
			</tr>
			</table>
		</div>
		<div style="display: <?php echo (!in_array("prune", $COLLAPSED) ? "none" : "inline"); ?>" id="closed_prune">
			<table style="width: 100%; border: 1px #CCCCCC solid" cellspacing="0" cellpadding="1">
			<tr>
				<td class="cursor" style="height: 15px; background-image: url('./images/table-head-off.gif'); background-color: #EEEEEE" onclick="toggle_section('prune', 0, '<?= javascript_cookie(); ?>', 'queue')">
					<table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td style="width: 95%; text-align: left"><span class="search-off">Queue Pruning</span></td>
						<td style="width: 5%; text-align: right"><a href="javascript: toggle_section('prune', 0, '<?= javascript_cookie(); ?>', 'queue')"><img src="./images/section-show.gif" width="9" height="9" alt="Show" title="Show Pruning" border="0" /></a></td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</div>

		<?php
		if($NOTICE) {
			echo display_notice($NOTICESTR);
		}
		?>
		<h1>Queue Manager</h1>
		<?php
		// Setup "Sort By Field" Information
		if(isset($_GET["sort"])) {
			$_SESSION["display"]["queue"]["sort"] = checkslashes($_GET["sort"]);
			setcookie("display[queue][sort]", checkslashes($_GET["sort"]), PREF_COOKIE_TIMEOUT);
		} elseif((!isset($_SESSION["display"]["queue"]["sort"])) && (isset($_COOKIE["display"]["queue"]["sort"]))) {
			$_SESSION["display"]["queue"]["sort"] = $_COOKIE["display"]["queue"]["sort"];
		} else {
			if(!isset($_SESSION["display"]["queue"]["sort"])) {
				$_SESSION["display"]["queue"]["sort"] = "date";
				setcookie("display[queue][sort]", "date", PREF_COOKIE_TIMEOUT);
			}
		}

		// Setup "Sort Order" Information
		if(isset($_GET["order"])) {
			switch($_GET["order"]) {
				case "asc" :
					$_SESSION["display"]["queue"]["order"] = "ASC";
				break;
				case "desc" :
				default :
					$_SESSION["display"]["queue"]["order"] = "DESC";
				break;
			}
			setcookie("display[queue][order]", $_SESSION["display"]["queue"]["order"], PREF_COOKIE_TIMEOUT);
		} elseif((!isset($_SESSION["display"]["queue"]["order"])) && (isset($_COOKIE["display"]["queue"]["order"]))) {
			$_SESSION["display"]["queue"]["order"] = $_COOKIE["display"]["queue"]["order"];
		} else {
			if (!isset($_SESSION["display"]["queue"]["order"])) {
				$_SESSION["display"]["queue"]["order"] = "DESC";
				setcookie("display[queue][order]", "DESC", PREF_COOKIE_TIMEOUT);
			}
		}

		// Set the internal variables used for sorting, ordering and in pagination.
		$sort		= $_SESSION["display"]["queue"]["sort"];
		$order		= $_SESSION["display"]["queue"]["order"];
		$perpage	= (($_SESSION["config"][PREF_PERPAGE_ID] > 0) ? $_SESSION["config"][PREF_PERPAGE_ID] : 25);

		$query		= "SELECT COUNT(*) AS `totalrows` FROM `".TABLES_PREFIX."queue`";
		$result		= $db->GetRow($query);
		$totalrows	= $result["totalrows"];

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

		$prev_page	= $page - 1;
		$next_page	= $page + 1;
		$page_start	= ($perpage * $page) - $perpage;

		// Get the colomn names of the sorted by colomn.
		switch($sort) {
			case "date" :
				$sortby	= "`date`";
			break;
			case "title" :
				$sortby	= "`message_title`";
			break;
			case "progress" :
				$sortby	= "`percentage`";
			break;
			case "status" :
				$sortby	= "`status`";
			break;
			default :
				$sortby	= "`date`";
			break;
		}

		$query		= "
					SELECT `queue_id`, `".TABLES_PREFIX."queue`.`message_id`, `date`, (CEILING((`progress` / `total`) * 100)) AS `percentage`, `total`, `status`, `".TABLES_PREFIX."messages`.`message_title`
					FROM `".TABLES_PREFIX."queue`
					LEFT JOIN `".TABLES_PREFIX."messages`
						ON `".TABLES_PREFIX."queue`.`message_id` = `".TABLES_PREFIX."messages`.`message_id`
					ORDER BY ".$sortby." ".strtoupper($order)."
					LIMIT ".$page_start.", ".$perpage;
		$results	= $db->GetAll($query);
		if($results) {
			?>
			<table style="width: 100%" cellspacing="0" cellpadding="1" border="0">
			<tr>
				<td style="width: 50%; text-align: left">
					<form action="index.php" method="get">
					<input type="hidden" name="section" value="queue" />
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
							<td style="white-space: nowrap; width: 22px; text-align: left">
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
							<td style="white-space: nowrap; text-align: center">
								<?php
								echo "<form action=\"index.php\" name=\"changepage\" method=\"get\">\n";
								echo "<input type=\"hidden\" name=\"section\" value=\"queue\" />\n";
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
			<form action="index.php?section=queue" method="post" id="queueList">
			<table style="width: 100%; text-align: left" cellspacing="0" cellpadding="1" border="0">
			<colgroup>
				<col style="width: 4%" />
				<col style="width: 20%" />
				<col style="width: 41%" />
				<col style="width: 13%" />
				<col style="width: 22%" />
			</colgroup>
			<thead>
				<tr>
					<td style="height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-off.gif'); white-space: nowrap">&nbsp;</td>
					<td style="height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "date") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("date", "Send Date", $order, $sort); ?></td>
					<td style="height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "title") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("title", "Message Title", $order, $sort); ?></td>
					<td style="height: 15px; padding-left: 2px; border-top: 1px #9D9D9D solid; border-left: 1px #9D9D9D solid; border-bottom: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "progress") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("progress", "Progress", $order, $sort); ?></td>
					<td style="height: 15px; padding-left: 2px; border: 1px #9D9D9D solid; background-image: url('./images/table-head-<?php echo (($sort == "status") ? "on" : "off"); ?>.gif'); white-space: nowrap"><?php echo order_link("status", "Status", $order, $sort); ?></td>
				</tr>
			</thead>
			<?php
			$remove_checkbox	= false;
			$buttons_enabled	= false;
			foreach($results as $result) {
				switch($result["status"]) {
					case "Paused" :
						$colour				= "#FFFFCC";
					break;
					case "Stalled" :
						$colour				= "#FFD9D0";
					break;
					default :
						$colour				= "#FFFFFF";
					break;
				}

				echo "<tr style=\"background-color: ".$colour."\" onmouseout=\"this.style.backgroundColor='".$colour."'\" onmouseover=\"this.style.backgroundColor='#F0FFD1'\">\n";
				echo "	<td style=\"height: 20px; white-space: nowrap\">";
				if(($result["status"] == "Paused") || ($result["status"] == "Stalled")) {
					$buttons_enabled = true;
					echo "<input type=\"radio\" name=\"qid\" value=\"".$result["queue_id"]."\" onclick=\"selectOption(this.form['remove[]'], 'resume')\" />";
				} else {
					$remove_checkbox = true;
					echo "<input type=\"checkbox\" name=\"remove[]\" value=\"".$result["queue_id"]."\" onclick=\"selectOption(this.form['qid'], 'remove')\" />\n";
				}
				echo "	</td>\n";
				echo "	<td class=\"cursor\" onclick=\"window.location='index.php?section=message&action=view&id=".$result["message_id"]."'\">".display_date("m/d/Y H:i", $result["date"])."</td>\n";
				echo "	<td class=\"cursor\" onclick=\"window.location='index.php?section=message&action=view&id=".$result["message_id"]."'\">".html_encode(limit_chars($result["message_title"], 38))."</td>\n";
				echo "	<td class=\"cursor\" onclick=\"window.location='index.php?section=message&action=view&id=".$result["message_id"]."'\">".$result["percentage"]."%</td>\n";
				echo "	<td class=\"cursor\" onclick=\"window.location='index.php?section=message&action=view&id=".$result["message_id"]."'\">".$result["status"]." ".(($result["status"] == "Complete") ? "<span class=\"small-grey\">(".$result["total"].")</span>" : "")."</td>\n";
				echo "</tr>\n";
			}
			?>
			<tr>
				<td colspan="5" style="border-top: 1px #333333 dotted; padding-top: 5px">
					<input type="checkbox" id="selectall" name="selectall" value="1" style="vertical-align: middle" onclick="<?php echo (($remove_checkbox) ? (($buttons_enabled) ? "selectOption(this.form['qid'], 'remove'); " : "")."selection(this.form['remove[]'])" : "this.checked=false"); ?>" />&nbsp;
					<select id="pageAction" name="action" style="width: 125px; vertical-align: middle">
						<?php if($remove_checkbox) : ?>
						<option value="remove">Delete Selected</option>
						<?php endif; ?>
						<?php if($buttons_enabled) : ?>
						<option value="resume">Resume Selected</option>
						<option value="cancel">Cancel Selected</option>
						<?php endif; ?>
					</select>
					<input type="submit" value="Proceed" class="button" style="vertical-align: middle" />
				</td>
			</tr>
			</table>
			</form>
			<?php
		} else {
			?>
			<h2>No Queue Messages</h2>
			<div class="generic-message">
				There are no messages in your ListMessenger Queue.
				<br /><br />
				This means that you have not yet sent any e-mail messages to your subscribers.
			</div>
			<?php
		}
	break;
}
?>