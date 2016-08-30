<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: progress.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/
?>
<iframe id="workerFrame" style="width: 0px; height: 0px; border: 0px #000000 solid; margin: 0px" src="./sender.php?sid=<?php echo session_id(); ?>&qid=<?php echo trim($qid).((trim($action) != "") ? "&action=".trim($action) : ""); ?>"></iframe>
<h1>Sending Message <span style="font-size: 11px">[<?php echo html_encode(checkslashes($_SESSION["message_details"]["message_title"], 1)); ?>]</span></h1>
<div id="progressBar" style="width: 95%; height: 15px; background-color: #EEEEEE; border: 1px #CCCCCC solid">
	<div id="progressStatus" style="width: 0%; height: 15px; background-color: #666666; font-weight: bold; color: #EEEEEE; text-align: right"></div>
</div>
<div id="progressText" style="width: 95%" class="progress-text"></div>
<br />
<div id="buttonHTML" style="width: 95%; text-align: right; height: 25px"></div>
<br /><br />
<form>
	<textarea id="errorText" style="display: none; width: 95%; height: 200px; border: 0px; margin: 0px" class="progress-error" readonly="readonly"></textarea>
</form>