<?php
/*
  ListMessenger - Professional Mailing List Management
  Copyright � 2007 Silentweb [http://www.silentweb.ca]

  Developed By: Matt Simpson <msimpson@listmessenger.com>

  For the most recent version, visit the ListMessenger website:
  [http://www.listmessenger.com]

  License Information is found in docs/licence.html
  $Id: control.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

if(!defined("PARENT_LOADED"))    exit;
if(!$_SESSION["isAuthenticated"])  exit;

?>
<h1>Control Panel</h1>
<table style="width: 100%" cellspacing="1" cellpadding="2" border="0">
<tr>
  <td style="width: 25%; text-align: center"><a href="./index.php?section=preferences"><img src="./images/icon-preferences.gif" width="48" height="48" alt="ListMessenger Preferences" title="ListMessenger Preferences" border="0" /></a></td>
  <td style="width: 25%; text-align: center"><a href="./index.php?section=attachments"><img src="./images/icon-files.gif" width="48" height="48" alt="Manage Attachments" title="Manage Attachments" border="0" /></a></td>
  <td style="width: 25%; text-align: center"><a href="./index.php?section=backup-restore"><img src="./images/icon-backup.gif" width="48" height="48" alt="Backup &amp; Restore" title="Backup &amp; Restore" border="0" /></a></td>
  <td style="width: 25%; text-align: center"><a href="./index.php?section=import-export"><img src="./images/icon-data.gif" width="48" height="48" alt="Import &amp; Export" title="Import &amp; Export" border="0" /></a></td>
</tr>
<tr>
  <td style="width: 25%; text-align: center">Preferences</td>
  <td style="width: 25%; text-align: center">Attachments</td>
  <td style="width: 25%; text-align: center">Backup &amp; Restore</td>
  <td style="width: 25%; text-align: center">Import &amp; Export</td>
</tr>

<tr>
  <td style="width: 100%" colspan="4">&nbsp;</td>
</tr>

<tr>
  <td style="width: 25%; text-align: center"><a href="./index.php?section=templates"><img src="./images/icon-template.gif" width="48" height="48" alt="HTML Templates" title="HTML Templates" border="0" /></a></td>
  <td style="width: 25%; text-align: center"><a href="./index.php?section=end-user"><img src="./images/icon-tools.gif" width="48" height="48" alt="End-User Tools" title="End-User Tools" border="0" /></a></td>
  <td style="width: 25%; text-align: center"><a><img src="./images/icon-update.gif" width="48" height="48" alt="Program Updates" title="lol are you crazy?" border="0" /></a></td>
  <td style="width: 25%; text-align: center"><img src="./images/icon-about.gif" width="48" height="48" alt="About ListMessenger" title="About ListMessenger" border="0" onclick="openAbout('<?= session_id() ?>')" class="cursor" /></td>
</tr>
<tr>
  <td style="width: 25%; text-align: center">E-Mail Templates</td>
  <td style="width: 25%; text-align: center">End-User Tools</td>
  <td style="width: 25%; text-align: center">Program Updates</td>
  <td style="width: 25%; text-align: center">About ListMessenger</td>
</tr>
</table>