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
		 * The frame that contains the image to be edited.
		 * @author $Author: Wei Zhuo $
		 * @version $Id: editorFrame.php 112 2007-03-25 20:57:44Z matt.simpson $
		 * @package ImageManager
		 */

		define("IM_INCLUDED", true);

		require_once('./config.inc.php');
		require_once('./Classes/ImageManager.php');
		require_once('./Classes/ImageEditor.php');

		$manager = new ImageManager($IMConfig);
		$editor = new ImageEditor($manager);
		$imageInfo = $editor->processImage();

		?>

		<html>
		<head>
			<title></title>
		<link href="assets/editorFrame.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="assets/wz_jsgraphics.js"></script>
		<script type="text/javascript" src="assets/EditorContent.js"></script>
		<script type="text/javascript">
		if(window.top)
			I18N = window.top.I18N;

		function i18n(str) {
			if(I18N)
				return (I18N[str] || str);
			else
				return str;
		};

			var mode = "<?php echo $editor->getAction(); ?>" //crop, scale, measure

		var currentImageFile = "<?php if(count($imageInfo)>0) echo rawurlencode($imageInfo['file']); ?>";

		<?php if ($editor->isFileSaved() == 1) { ?>
			alert(i18n('File saved.'));
		<?php } else if ($editor->isFileSaved() == -1) { ?>
			alert(i18n('File was not saved.'));
		<?php } ?>

		</script>
		<script type="text/javascript" src="assets/editorFrame.js"></script>
		</head>

		<body>
		<div id="status"></div>
		<div id="ant" class="selection" style="visibility:hidden"><img src="img/spacer.gif" width="0" height="0" border="0" alt="" id="cropContent"></div>
		<?php if ($editor->isGDEditable() == -1) { ?>
			<div style="text-align:center; padding:10px;"><span class="error">GIF format is not supported, image editing not supported.</span></div>
		<?php } ?>
		<table height="100%" width="100%">
			<tr>
				<td>
		<?php if(count($imageInfo) > 0 && is_file($imageInfo['fullpath'])) { ?>
			<span id="imgCanvas" class="crop"><img src="<?php echo $imageInfo['src']; ?>" <?php echo $imageInfo['dimensions']; ?> alt="" id="theImage" name="theImage"></span>
		<?php } else { ?>
			<span class="error">No Image Available</span>
		<?php } ?>
				</td>
			</tr>
		</table>
		</body>
		</html>
		<?php
	}
?>