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
		 * On the fly Thumbnail generation.
		 * Creates thumbnails given by thumbs.php?img=/relative/path/to/image.jpg
		 * relative to the base_dir given in config.inc.php
		 * @author $Author: Wei Zhuo $
		 * @version $Id: thumbs.php 112 2007-03-25 20:57:44Z matt.simpson $
		 * @package ImageManager
		 */
		define("IM_INCLUDED", true);

		require_once('./config.inc.php');
		require_once('./Classes/ImageManager.php');
		require_once('./Classes/Thumbnail.php');

		//check for img parameter in the url
		if(!isset($_GET['img']))
			exit();


		$manager = new ImageManager($IMConfig);

		//get the image and the full path to the image
		$image = rawurldecode($_GET['img']);
		$fullpath = Files::makeFile($manager->getBaseDir(),$image);

		//not a file, so exit
		if(!is_file($fullpath))
			exit();

		$imgInfo = @getImageSize($fullpath);

		//Not an image, send default thumbnail
		if(!is_array($imgInfo))
		{
			//show the default image, otherwise we quit!
			$default = $manager->getDefaultThumb();
			if($default)
			{
				header('Location: '.$default);
				exit();
			}
		}
		//if the image is less than the thumbnail dimensions
		//send the original image as thumbnail
		if ($imgInfo[0] <= $IMConfig['thumbnail_width']
		 && $imgInfo[1] <= $IMConfig['thumbnail_height'])
		 {
			 header('Location: '.$manager->getFileURL($image));
			 exit();
		 }

		//Check for thumbnails
		$thumbnail = $manager->getThumbName($fullpath);
		if(is_file($thumbnail))
		{
			//if the thumbnail is newer, send it
			if(filemtime($thumbnail) >= filemtime($fullpath))
			{
				header('Location: '.$manager->getThumbURL($image));
				exit();
			}
		}

		//creating thumbnails
		$thumbnailer = new Thumbnail($IMConfig['thumbnail_width'],$IMConfig['thumbnail_height']);
		$thumbnailer->createThumbnail($fullpath, $thumbnail);

		//Check for NEW thumbnails
		if(is_file($thumbnail))
		{
			//send the new thumbnail
			header('Location: '.$manager->getThumbURL($image));
			exit();
		}
		else
		{
			//show the default image, otherwise we quit!
			$default = $manager->getDefaultThumb();
			if($default)
				header('Location: '.$default);
		}
	}
?>