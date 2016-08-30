<?php
// Setup PHP and start page setup.
	@ini_set("include_path", "../../../../includes");
	@ini_set("allow_url_fopen", 1);
	@ini_set("session.name", "LMSID");
	@ini_set("session.use_trans_sid", 0);
	@ini_set("session.cookie_lifetime", 0);
	@ini_set("session.cookie_secure", 0);
	@ini_set("session.referer_check", "");
	@ini_set("error_reporting",  E_ALL ^ E_NOTICE);
	@ini_set("magic_quotes_runtime", 0);

	require_once("pref_ids.inc.php");
	require_once("config.inc.php");
	require_once("classes/adodb/adodb.inc.php");
	require_once("dbconnection.inc.php");

	session_start();
	if((!isset($_SESSION["isAuthenticated"])) || (!(bool) $_SESSION["isAuthenticated"])) {
		$path_details = pathinfo(htmlentities($_SERVER["PHP_SELF"]));

		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
		echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
		echo "<body>\n";
		echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		echo "alert('It appears as though you are either not currently logged into ListMessenger or your session has expired. You will now be taken to the ListMessenger login page; please re-login.');\n";
		echo "if(window.opener) {\n";
		echo "	window.opener.location = '".str_replace("/javascript/htmlarea/plugins/ImageManager", "", $path_details["dirname"])."/index.php?action=logout';\n";
		echo "	top.window.close();\n";
		echo "} else {\n";
		echo "	window.location = '".str_replace("/javascript/htmlarea/plugins/ImageManager", "", $path_details["dirname"])."/index.php?action=logout';\n";
		echo "}\n";
		echo "</script>\n";
		echo "</body>\n";
		echo "</html>\n";
		exit;
	} else {
		/**
		 * The main GUI for the ImageManager.
		 * @author $Author: Wei Zhuo $
		 * @version $Id: manager.php 112 2007-03-25 20:57:44Z matt.simpson $
		 * @package ImageManager
		 */

		define("IM_INCLUDED", true);

		require_once('./config.inc.php');
		require_once('./Classes/ImageManager.php');

		$manager = new ImageManager($IMConfig);
		$dirs = $manager->getDirs();

		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

		<html>
		<head>
			<title>Insert Image</title>
		  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		 <link href="assets/manager.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="assets/popup.js"></script>
		<script type="text/javascript" src="assets/dialog.js"></script>
		<script type="text/javascript">
		/*<![CDATA[*/
			window.resizeTo(600, 460);

			if(window.opener)
				I18N = window.opener.ImageManager.I18N;

			var thumbdir = "<?php echo $IMConfig['thumbnail_dir']; ?>";
			var base_url = "<?php echo $manager->getBaseURL(); ?>";
		/*]]>*/
		</script>
		<script type="text/javascript" src="assets/manager.js"></script>
		</head>
		<body>
		<div class="title">Insert Image</div>
		<form action="images.php" id="uploadForm" method="post" enctype="multipart/form-data">
		<fieldset><legend>Image Manager</legend>
		<div class="dirs">
			<label for="dirPath">Directory</label>
			<select name="dir" class="dirWidth" id="dirPath" onchange="updateDir(this)">
			<option value="/">/</option>
		<?php foreach($dirs as $relative=>$fullpath) { ?>
				<option value="<?php echo rawurlencode($relative); ?>"><?php echo $relative; ?></option>
		<?php } ?>
			</select>
			<a href="#" onclick="javascript: goUpDir();" title="Directory Up"><img src="img/btnFolderUp.gif" height="15" width="15" alt="Directory Up" /></a>
		<?php if($IMConfig['safe_mode'] == false && $IMConfig['allow_new_dir']) { ?>
			<a href="#" onclick="newFolder();" title="New Folder"><img src="img/btnFolderNew.gif" height="15" width="15" alt="New Folder" /></a>
		<?php } ?>
			<div id="messages" style="display: none;"><span id="message"></span><img SRC="img/dots.gif" width="22" height="12" alt="..." /></div>
			<iframe src="images.php" name="imgManager" id="imgManager" class="imageFrame" scrolling="auto" title="Image Selection" frameborder="0"></iframe>
		</div>
		</fieldset>
		<!-- image properties -->
			<table class="inputTable">
				<tr>
					<td align="right"><label for="f_url">Image File</label></td>
					<td><input type="text" id="f_url" class="largelWidth" value="" /></td>
					<td rowspan="3" align="right">&nbsp;</td>
					<td align="right"><label for="f_width">Width</label></td>
					<td><input type="text" id="f_width" class="smallWidth" value="" onchange="javascript:checkConstrains('width');"/></td>
					<td rowspan="2" align="right"><img src="img/locked.gif" id="imgLock" width="25" height="32" alt="Constrained Proportions" /></td>
					<td rowspan="3" align="right">&nbsp;</td>
					<td align="right"><label for="f_vert">V Space</label></td>
					<td><input type="text" id="f_vert" class="smallWidth" value="" /></td>
				</tr>
				<tr>
					<td align="right"><label for="f_alt">Alt</label></td>
					<td><input type="text" id="f_alt" class="largelWidth" value="" /></td>
					<td align="right"><label for="f_height">Height</label></td>
					<td><input type="text" id="f_height" class="smallWidth" value="" onchange="javascript:checkConstrains('height');"/></td>
					<td align="right"><label for="f_horiz">H Space</label></td>
					<td><input type="text" id="f_horiz" class="smallWidth" value="" /></td>
				</tr>
				<tr>
				<?php
				if($IMConfig['allow_upload'] == true) {
					?>
					<td align="right"><label for="upload">Upload</label></td>
					<td>
						<table cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><input type="file" name="upload" id="upload"/></td>
							<td><button type="submit" name="submit" onclick="doUpload();">Upload</button></td>
						</tr>
						</table>
					</td>
					<?php
				} else {
					?>
					<td colspan="2"></td>
					<?php
				}
				?>
					<td align="right"><label for="f_align">Align</label></td>
					<td colspan="2">
						<select size="1" id="f_align"  title="Positioning of this image">
						  <option value=""                             >Not Set</option>
						  <option value="left"                         >Left</option>
						  <option value="right"                        >Right</option>
						  <option value="texttop"                      >Texttop</option>
						  <option value="absmiddle"                    >Absmiddle</option>
						  <option value="baseline" selected="selected" >Baseline</option>
						  <option value="absbottom"                    >Absbottom</option>
						  <option value="bottom"                       >Bottom</option>
						  <option value="middle"                       >Middle</option>
						  <option value="top"                          >Top</option>
						</select>
					</td>
					<td align="right"><label for="f_border">Border</label></td>
					<td><input type="text" id="f_border" class="smallWidth" value="" /></td>
				</tr>
				<tr>
		         <td colspan="4" align="right">
						<input type="hidden" id="orginal_width" />
						<input type="hidden" id="orginal_height" />
		            <input type="checkbox" id="constrain_prop" checked="checked" onclick="javascript:toggleConstrains(this);" />
		          </td>
		          <td colspan="5"><label for="constrain_prop">Constrain Proportions</label></td>
		      </tr>
			</table>
		<!--// image properties -->
			<div style="text-align: right;">
		          <hr />
				  <button type="button" class="buttons" onclick="return refresh();">Refresh</button>
		          <button type="button" class="buttons" onclick="return onOK();">OK</button>
		          <button type="button" class="buttons" onclick="return onCancel();">Cancel</button>
		    </div>
		</form>
		</body>
		</html>
		<?php
	}
?>