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
		 * Show a list of images in a long horizontal table.
		 * @author $Author: Wei Zhuo $
		 * @version $Id: images.php 112 2007-03-25 20:57:44Z matt.simpson $
		 * @package ImageManager
		 */

		define("IM_INCLUDED", true);

		require_once('./config.inc.php');

		require_once('./Classes/ImageManager.php');

		//default path is /
		$relative = '/';

		$manager = new ImageManager($IMConfig);

		//process any file uploads
		$manager->processUploads();

		$manager->deleteFiles();

		$refreshDir = false;
		//process any directory functions
		if($manager->deleteDirs() || $manager->processNewDir())
			$refreshDir = true;

		//check for any sub-directory request
		//check that the requested sub-directory exists
		//and valid
		if(isset($_REQUEST['dir']))
		{
			$path = rawurldecode($_REQUEST['dir']);
			if($manager->validRelativePath($path))
				$relative = $path;
		}


		$manager = new ImageManager($IMConfig);


		//get the list of files and directories
		$list = $manager->getFiles($relative);


		/* ================= OUTPUT/DRAW FUNCTIONS ======================= */

		/**
		 * Draw the files in an table.
		 */
		function drawFiles($list, &$manager) {
			global $relative;

			foreach($list as $entry => $file) {
				?>
				<td>
					<table width="100" cellpadding="0" cellspacing="0">
					<tr>
						<td class="block">
							<a href="javascript:;" onclick="selectImage('<?php echo $file['relative'];?>', '<?php echo $entry; ?>', <?php echo $file['image'][0];?>, <?php echo $file['image'][1]; ?>);"title="<?php echo $entry; ?> - <?php echo Files::formatSize($file['stat']['size']); ?>"><img src="<?php echo $manager->getThumbnail($file['relative']); ?>" alt="<?php echo $entry; ?> - <?php echo Files::formatSize($file['stat']['size']); ?>"/></a>
						</td>
					</tr>
					<tr>
						<td class="edit">
							<a href="images.php?dir=<?php echo $relative; ?>&amp;delf=<?php echo rawurlencode($file['relative']);?>" title="Trash" onclick="return confirmDeleteFile('<?php echo $entry; ?>');"><img src="img/edit_trash.gif" height="15" width="15" alt="Trash"/></a><a href="javascript:;" title="Edit" onclick="editImage('<?php echo rawurlencode($file['relative']);?>');"><img src="img/edit_pencil.gif" height="15" width="15" alt="Edit"/></a>
							<?php if($file['image']) {
								echo $file['image'][0].'x'.$file['image'][1];
							} else {
								echo $entry;
							}
							?>
						</td>
					</tr>
					</table>
				</td>
			  	<?php
			}//foreach
		}//function drawFiles


		/**
		 * Draw the directory.
		 */
		function drawDirs($list, &$manager)
		{
			global $relative;

			foreach($list as $path => $dir)
			{ ?>
				<td><table width="100" cellpadding="0" cellspacing="0"><tr><td class="block">
				<a href="images.php?dir=<?php echo rawurlencode($path); ?>" onclick="updateDir('<?php echo $path; ?>')" title="<?php echo $dir['entry']; ?>"><img src="img/folder.gif" height="80" width="80" alt="<?php echo $dir['entry']; ?>" /></a>
				</td></tr><tr>
				<td class="edit">
					<a href="images.php?dir=<?php echo $relative; ?>&amp;deld=<?php echo rawurlencode($path); ?>" title="Trash" onclick="return confirmDeleteDir('<?php echo $dir['entry']; ?>', <?php echo $dir['count']; ?>);"><img src="img/edit_trash.gif" height="15" width="15" alt="Trash"/></a>
					<?php echo $dir['entry']; ?>
				</td>
				</tr></table></td>
			  <?php
			} //foreach
		}//function drawDirs


		/**
		 * No directories and no files.
		 */
		function drawNoResults()
		{
		?>
		<table width="100%">
		  <tr>
		    <td class="noResult">No Images Found</td>
		  </tr>
		</table>
		<?
		}

		/**
		 * No directories and no files.
		 */
		function drawErrorBase(&$manager)
		{
		?>
		<table width="100%">
		  <tr>
		    <td class="error">Invalid base directory: <?php echo $manager->config['base_dir']; ?></td>
		  </tr>
		</table>
		<?
		}

		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

		<html>
		<head>
			<title>Image List</title>
		  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<link href="assets/imagelist.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="assets/dialog.js"></script>
		<script type="text/javascript">
		/*<![CDATA[*/

			if(window.top)
				I18N = window.top.I18N;

			function hideMessage()
			{
				var topDoc = window.top.document;
				var messages = topDoc.getElementById('messages');
				if(messages)
					messages.style.display = "none";
			}

			init = function()
			{
				hideMessage();
				var topDoc = window.top.document;

		<?php
			//we need to refesh the drop directory list
			//save the current dir, delete all select options
			//add the new list, re-select the saved dir.
			if($refreshDir)
			{
				$dirs = $manager->getDirs();
		?>
				var selection = topDoc.getElementById('dirPath');
				var currentDir = selection.options[selection.selectedIndex].text;

				while(selection.length > 0)
				{	selection.remove(0); }

				selection.options[selection.length] = new Option("/","<?php echo rawurlencode('/'); ?>");
				<?php foreach($dirs as $relative=>$fullpath) { ?>
				selection.options[selection.length] = new Option("<?php echo $relative; ?>","<?php echo rawurlencode($relative); ?>");
				<?php } ?>

				for(var i = 0; i < selection.length; i++)
				{
					var thisDir = selection.options[i].text;
					if(thisDir == currentDir)
					{
						selection.selectedIndex = i;
						break;
					}
				}
		<?php } ?>
			}

			function editImage(image)
			{
				var url = "editor.php?img="+image;
				Dialog(url, function(param)
				{
					if (!param) // user must have pressed Cancel
						return false;
					else
					{
						return true;
					}
				}, null);
			}

		/*]]>*/
		</script>
		<script type="text/javascript" src="assets/images.js"></script>
		</head>

		<body>
		<?php if ($manager->isValidBase() == false) { drawErrorBase($manager); }
			elseif(count($list[0]) > 0 || count($list[1]) > 0) { ?>
		<table>
			<tr>
			<?php drawDirs($list[0], $manager); ?>
			<?php drawFiles($list[1], $manager); ?>
			</tr>
		</table>
		<?php } else { drawNoResults(); } ?>
		</body>
		</html>
		<?php
	}
?>