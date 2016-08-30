<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: login.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

if(!defined("PARENT_LOADED"))		exit;

$ONLOAD[] = "document.getElementById('username').focus()";
?>
<table style="width: 100%; height: 450px" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td style="width: 40%; text-align: right; vertical-align: middle">
		<img src="images/listmessenger.gif" width="139" height="167" alt="ListMessenger <?php echo html_encode(trim(VERSION_TYPE." ".VERSION_INFO)); ?>" />
	</td>
	<td style="width: 60%; text-align: left; vertical-align: middle">
		<?php
		/**
		 * Check if the configuration has been successfully loaded in includes/loader.inc.php.
		 */
		if($CONFIG_LOADED) {
			?>
			<div style="margin-bottom: 15px">
				Welcome to <span class="titlea-positive">List</span><span class="titleb-positive">Messenger</span> <span class="titlea-positive"><?php echo html_encode(trim(VERSION_TYPE)); ?></span>
			</div>
			<?php echo (($SUCCESS) ? display_success($SUCCESSSTR) : ""); ?>
			<?php echo (($ERROR) ? display_error($ERRORSTR) : ""); ?>
			<form action="index.php?section=login" method="post">
			<input type="hidden" name="action" value="login" />
			<input type="hidden" name="goto" value="<?php echo ((isset($_GET["section"])) ? html_encode(trim($_GET["section"])) : ""); ?>" />
			<table style="width: 250px" border="0" cellspacing="1" cellpadding="1">
			<tr>
				<td><label for="username">Username:</label></td>
				<td style="text-align: right"><input type="text" class="text-box" style="width: 150px" id="username" name="username" value="<?php echo ((isset($_POST["username"])) ? html_encode(trim($_POST["username"])) : ""); ?>" /></td>
			</tr>
			<tr>
				<td><label for="password">Password:</label></td>
				<td style="text-align: right"><input type="password" class="pass-box" style="width: 150px" id="password" name="password" value="" /></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: right; padding-top: 10px">
					<input type="submit" value="Login" class="button" />
				</td>
			</tr>
			</table>
			</form>
			<?php
		} else {
			echo "<div style=\"margin: 25px\">\n";
			echo (($ERROR) ? display_error($ERRORSTR) : "");
			echo "</div>\n";
		}
		?>
	</td>
</tr>
</table>
