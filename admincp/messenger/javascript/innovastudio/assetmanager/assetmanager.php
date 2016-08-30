<?php
/*
IMPORTANT APPLICATION USAGE NOTICE TO ANYONE WHO READS THIS:
==========================================================================
This application may NOT be used outside of ListMessenger Pro. It was
specifically licenced to me, for exclusive use within ListMessenger and
you may not use or include this class with any other application or script.

If you would like to purchase InnovaStudio for use within your
own applications, please do so by visiting the InnovaStudio website
[http://www.innovastudio.com].

If you do not adhere to this warning, you are stealing. Not just that, but
you're taking money out of another developers pocket. Someone worked very
hard to bring this script to existance and they should be paid for their
work, so please purchase this class if you intend on using it. They even
have a free trial on their website that you can test out, so do not even
test out something with this version. Thank-you for your understanding.

$Id: assetmanager.php 107 2007-03-25 19:49:18Z matt.simpson $
*/
	@ini_set("include_path", "../../../includes");
	@ini_set("allow_url_fopen", 1);
	@ini_set("session.name", "LMSID");
	@ini_set("session.use_trans_sid", 0);
	@ini_set("session.cookie_lifetime", 0);
	@ini_set("session.cookie_secure", 0);
	@ini_set("session.referer_check", "");
	@ini_set("error_reporting",  E_ALL ^ E_NOTICE);
	@ini_set("magic_quotes_runtime", 0);

	if((!isset($_GET["sid"])) || (!trim($_GET["sid"]))) {
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
		echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
		echo "<body>\n";
		echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		echo "alert('It appears as though you are either not currently logged into ListMessenger or your session has expired. You will now be taken to the ListMessenger login page; please re-login.');\n";
		echo "if(window.opener) {\n";
		echo "	window.opener.location = './index.php?action=logout';\n";
		echo "	top.window.close();\n";
		echo "} else {\n";
		echo "	window.location = './index.php?action=logout';\n";
		echo "}\n";
		echo "</script>\n";
		echo "</body>\n";
		echo "</html>\n";
		exit;
	}

	require_once("pref_ids.inc.php");
	require_once("config.inc.php");
	require_once("classes/adodb/adodb.inc.php");
	require_once("dbconnection.inc.php");

	session_start(trim($_GET["sid"]));

	if((!isset($_SESSION["isAuthenticated"])) || (!(bool) $_SESSION["isAuthenticated"])) {
		$path_details = pathinfo(htmlentities($_SERVER["PHP_SELF"]));

		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
		echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
		echo "<body>\n";
		echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		echo "alert('It appears as though you are either not currently logged into ListMessenger or your session has expired. You will now be taken to the ListMessenger login page; please re-login.');\n";
		echo "if(window.opener) {\n";
		echo "	window.opener.location = '".str_replace("/javascript/innovastudio/assetmanager", "", $path_details["dirname"])."/index.php?action=logout';\n";
		echo "	top.window.close();\n";
		echo "} else {\n";
		echo "	window.location = '".str_replace("/javascript/innovastudio/assetmanager", "", $path_details["dirname"])."/index.php?action=logout';\n";
		echo "}\n";
		echo "</script>\n";
		echo "</body>\n";
		echo "</html>\n";
		exit;
	} else {
		$public_relative	= substr($_SESSION["config"][PREF_PUBLIC_URL], strpos($_SESSION["config"][PREF_PUBLIC_URL], "/", 8), strlen($_SESSION["config"][PREF_PUBLIC_URL]));
		$bReturnAbsolute	= true;

		$sBaseVirtual0		= $public_relative."images";
		$sBase0			= $_SESSION["config"][PREF_PUBLIC_PATH]."images";
		$sName0			= "Image Assets";

		$sBaseVirtual1		= $public_relative."files";
		$sBase1			= $_SESSION["config"][PREF_PUBLIC_PATH]."files";
		$sName1			= "File Assets";

		$sBaseVirtual2		= "";
		$sBase2			= "";
		$sName2			= "";

		$sBaseVirtual3		= "";
		$sBase3			= "";
		$sName3			= "";

		/*** Permission ***/
		$bReadOnly0=false;
		$bReadOnly1=false;
		$bReadOnly2=false;
		$bReadOnly3=false;
		/*** /Permission ***/

		$sBaseRoot0="";
		$sBaseRoot1="";
		$sBaseRoot2="";
		$sBaseRoot3="";
		$sBaseRoot0=ereg_replace($sBaseVirtual0,"",$sBase0); //output: "c:/inetpub/wwwroot"
		if($sBase1!="")$sBaseRoot1=ereg_replace($sBaseVirtual1,"",$sBase1);
		if($sBase2!="")$sBaseRoot2=ereg_replace($sBaseVirtual2,"",$sBase2);
		if($sBase3!="")$sBaseRoot3=ereg_replace($sBaseVirtual3,"",$sBase3);

		$sMsg = "";
		$currFolder=$sBase0;
		$ffilter="";
		$sUploadedFile="";

		$MaxFileSize = 3000000;
		//$AllowedTypes = "gif|jpg";
		$AllowedTypes = "*";

		function isTypeAllowed($sFileName)
			{
			global $AllowedTypes;
			if($AllowedTypes=="*") return true;

			echo ereg($AllowedTypes,getExt($sFileName));

			if( ereg($AllowedTypes,getExt($sFileName)) )
				return true;
			else
				return false;
			}

		if(isset($_FILES["File1"]))
			{
			if(isset($_POST["inpCurrFolder2"]))$currFolder=$_POST['inpCurrFolder2'];
			if(isset($_REQUEST["inpFilter"]))$ffilter=$_REQUEST["inpFilter"];

			if($MaxFileSize && ($_FILES['File1']['size'] > $MaxFileSize))
				{
				$sMsg = "The file exceeds the maximum size allowed.";
				}
			else if(!isTypeAllowed($_FILES['File1']['name']))
				{
				$sMsg = "The File Type is not allowed.";
				}
			else if (move_uploaded_file($_FILES['File1']['tmp_name'], $currFolder."/".basename($_FILES['File1']['name'])))
				{
				$sMsg = "";
				$sUploadedFile=$_FILES['File1']['name'];
				@chmod($currFolder."/".basename($_FILES['File1']['name']), 0644);
				}
			else
				{
				$sMsg = "Upload failed.";
				}
			}
		else
			{
			if(isset($_POST["inpCurrFolder"]))$currFolder=$_POST['inpCurrFolder'];
			if(isset($_REQUEST["ffilter"]))$ffilter=$_REQUEST["ffilter"];
			}

		if(isset($_POST["inpFileToDelete"]))
			{
			$filename=pathinfo($_POST["inpFileToDelete"]);
			$filename=$filename['basename'];
			if($filename!="")
				unlink($currFolder . "/" . $filename);
			$sMsg = "";
			}


		/*** Permission ***/
		$bWriteFolderAdmin=false;
		if($sBase0!="")
			{
			if(strtolower($currFolder)!=ereg_replace(strtolower($sBase0),"",strtolower($currFolder)) AND $bReadOnly0==true) $bWriteFolderAdmin=true;
			}
		if($sBase1!="")
			{
			if(strtolower($currFolder)!=ereg_replace(strtolower($sBase1),"",strtolower($currFolder)) AND $bReadOnly1==true) $bWriteFolderAdmin=true;
			}
		if($sBase2!="")
			{
			if(strtolower($currFolder)!=ereg_replace(strtolower($sBase2),"",strtolower($currFolder)) AND $bReadOnly2==true) $bWriteFolderAdmin=true;
			}
		if($sBase3!="")
			{
			if(strtolower($currFolder)!=ereg_replace(strtolower($sBase3),"",strtolower($currFolder)) AND $bReadOnly3==true) $bWriteFolderAdmin=true;
			}
		$sFolderAdmin="";
		if($bWriteFolderAdmin)$sFolderAdmin="style='display:none'";
		/*** /Permission ***/


		Function writeFolderSelections()
			{
			global $sBase0;
			global $sBase1;
			global $sBase2;
			global $sBase3;
			global $sName0;
			global $sName1;
			global $sName2;
			global $sName3;
			global $currFolder;

			echo "<select name='selCurrFolder' id='selCurrFolder' onchange='changeFolder()' class='inpSel'>";
			recursive($sBase0,$sBase0,$sName0);
			if($sBase1!="")recursive($sBase1,$sBase1,$sName1);
			if($sBase2!="")recursive($sBase2,$sBase2,$sName2);
			if($sBase3!="")recursive($sBase3,$sBase3,$sName3);
			echo "</select>";
			}

		Function recursive($sPath,$sPath_base,$sName)
			{
			global $sBase0;
			global $sBase1;
			global $sBase2;
			global $sBase3;
			global $currFolder;

			if($sPath==$sBase0 ||$sPath==$sBase1 ||$sPath==$sBase2 ||$sPath==$sBase3)
				{
				if($currFolder==$sPath)
					echo "<option value='$sPath' selected>$sName</option>";
				else
					echo "<option value='$sPath'>$sName</option>";
				}

			$oItem=opendir($sPath);
			while($sItem=readdir($oItem))
				{
				if($sItem=="."||$sItem=="..")
					{
					}
				else
					{
					$sCurrent=$sPath."/".$sItem;
					$fIsDirectory=is_dir($sCurrent);

					$sDisplayed=ereg_replace($sBase0,"",$sCurrent);
					if($sBase1<>"") $sDisplayed=ereg_replace($sBase1,"",$sDisplayed);
					if($sBase2<>"") $sDisplayed=ereg_replace($sBase2,"",$sDisplayed);
					if($sBase3<>"") $sDisplayed=ereg_replace($sBase3,"",$sDisplayed);
					$sDisplayed=$sName.$sDisplayed;

					if($fIsDirectory)
						{
						if($currFolder==$sCurrent)
							echo "<option value='$sCurrent' selected>$sDisplayed</option>";
						else
							echo "<option value='$sCurrent'>$sDisplayed</option>";

						recursive($sCurrent,$sPath,$sName);
						}
					}
				}
			closedir($oItem);
			}

		function getExt($sFileName)//ffilter
			{
			$sTmp=$sFileName;
			while($sTmp!="")
				{
				$sTmp=strstr($sTmp,".");
				if($sTmp!="")
					{
					$sTmp=substr($sTmp,1);
					$sExt=$sTmp;
					}
				}
			return strtolower($sExt);
			}

		function writeFileSelections()
			{
			global $sFolderAdmin;
			global $ffilter;
			global $sUploadedFile;
			global $sBaseRoot0;
			global $sBaseRoot1;
			global $sBaseRoot2;
			global $sBaseRoot3;
			global $currFolder;
			global $bWriteFolderAdmin;

			$nIndex=0;
			$bFileFound=false;
			$iSelected="";

			echo "<div style='overflow:auto;height:222px;width:100%;margin-top:3px;margin-bottom:2px;'>";
			echo "<table border=0 cellpadding=2 cellspacing=0 width=100% height=100% >";
			$sColor = "#e7e7e7";

			$oItem=opendir($currFolder);
			while($sItem=readdir($oItem))
				{
				if($sItem=="."||$sItem=="..")
					{
					}
				else
					{
					$sCurrent=$currFolder."/".$sItem;
					$fIsDirectory=is_dir($sCurrent);


					if(!$fIsDirectory)
						{

						//ffilter ~~~~~~~~~~
						$bDisplay=false;
						$sExt=getExt($sItem);
						if($ffilter=="flash")
							{
							if($sExt=="swf")$bDisplay=true;
							}
						else if($ffilter=="media")
							{
							if ($sExt=="avi" || $sExt=="wmv" || $sExt=="mpg" || $sExt=="mpeg" || $sExt=="wav" || $sExt=="wma" || $sExt=="mid" || $sExt=="mp3") $bDisplay=true;
							}
						else if($ffilter=="image")
							{
							if ($sExt=="gif" || $sExt=="jpg" || $sExt=="png") $bDisplay=true;
							}
						else //all
							{
							$bDisplay=true;
							}
						//~~~~~~~~~~~~~~~~~~

						if($bDisplay)
							{
							$nIndex=$nIndex+1;
							$bFileFound=true;

							//echo $sBaseRoot0; //		c:/inetpub/wwwroot
							//echo $sCurrent; //		c:/inetpub/wwwroot/Editor/assets/bullet.gif
							//echo $sBaseVirtual0;//	/Editor/assets
							$sCurrent_virtual=ereg_replace($sBaseRoot0,"",$sCurrent);
							if($sBaseRoot1!="")$sCurrent_virtual=ereg_replace($sBaseRoot1,"",$sCurrent_virtual);
							if($sBaseRoot2!="")$sCurrent_virtual=ereg_replace($sBaseRoot2,"",$sCurrent_virtual);
							if($sBaseRoot3!="")$sCurrent_virtual=ereg_replace($sBaseRoot3,"",$sCurrent_virtual);

							if($sColor=="#EFEFF5")
								$sColor = "";
							else
								$sColor = "#EFEFF5";

							//icons
							$sIcon="ico_unknown.gif";
							if($sExt=="asp")$sIcon="ico_asp.gif";
							if($sExt=="bmp")$sIcon="ico_bmp.gif";
							if($sExt=="css")$sIcon="ico_css.gif";
							if($sExt=="doc")$sIcon="ico_doc.gif";
							if($sExt=="exe")$sIcon="ico_exe.gif";
							if($sExt=="gif")$sIcon="ico_gif.gif";
							if($sExt=="htm")$sIcon="ico_htm.gif";
							if($sExt=="html")$sIcon="ico_htm.gif";
							if($sExt=="jpg")$sIcon="ico_jpg.gif";
							if($sExt=="js")$sIcon="ico_js.gif";
							if($sExt=="mdb")$sIcon="ico_mdb.gif";
							if($sExt=="mov")$sIcon="ico_mov.gif";
							if($sExt=="mp3")$sIcon="ico_mp3.gif";
							if($sExt=="pdf")$sIcon="ico_pdf.gif";
							if($sExt=="png")$sIcon="ico_png.gif";
							if($sExt=="ppt")$sIcon="ico_ppt.gif";
							if($sExt=="mid")$sIcon="ico_sound.gif";
							if($sExt=="wav")$sIcon="ico_sound.gif";
							if($sExt=="wma")$sIcon="ico_sound.gif";
							if($sExt=="swf")$sIcon="ico_swf.gif";
							if($sExt=="txt")$sIcon="ico_txt.gif";
							if($sExt=="vbs")$sIcon="ico_vbs.gif";
							if($sExt=="avi")$sIcon="ico_video.gif";
							if($sExt=="wmv")$sIcon="ico_video.gif";
							if($sExt=="mpeg")$sIcon="ico_video.gif";
							if($sExt=="mpg")$sIcon="ico_video.gif";
							if($sExt=="xls")$sIcon="ico_xls.gif";
							if($sExt=="zip")$sIcon="ico_zip.gif";

							$sTmp1=strtolower($sItem);
							$sTmp2=strtolower($sUploadedFile);
							if($sTmp1==$sTmp2)
								{
								$sColorResult="yellow";
								$iSelected=$nIndex;
								}
							else
								{
								$sColorResult=$sColor;
								}

							echo "<tr style='background:".$sColorResult."'>";
							echo "<td><img src='images/".$sIcon."'></td>";
							echo "<td valign=top width=100% ><u id=\"idFile".$nIndex."\" style='cursor:pointer;' onclick=\"selectFile(".$nIndex.")\">".$sItem."</u>&nbsp;&nbsp;<img style='cursor:pointer;' onclick=\"downloadFile(".$nIndex.")\" src='images/download.gif'></td>";
							echo "<input type=hidden name=inpFile".$nIndex." id=inpFile".$nIndex." value=\"".$sCurrent_virtual."\">";
							echo "<td valign=top align=right nowrap>".round(filesize($sCurrent)/1024,1)." kb&nbsp;</td>";
							echo "<td valign=top nowrap onclick=\"deleteFile(".$nIndex.")\"><u style='font-size:10px;cursor:pointer;color:crimson' ".$sFolderAdmin.">";
							if(!$bWriteFolderAdmin)
								{
								echo "<script>document.write(getTxt('del'))</script>";
								}
							echo "</u></td>";



							echo "</tr>";
							}
						}
					}
				}

			if($bFileFound==false)
				echo "<tr><td colspan=4 height=100% align=center><script>document.write(getTxt('Empty...'))</script></td></tr></table></div>";
			else
				echo "<tr><td colspan=4 height=100% ></td></tr></table></div>";

			echo "<input type=hidden name=inpUploadedFile id=inpUploadedFile value='".$iSelected."'>";
			echo "<input type=hidden name=inpNumOfFiles id=inpNumOfFiles value='".$nIndex."'>";

			closedir($oItem);
			}
		?>
		<base target="_self">
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text-html; charset=Windows-1252">
		<link href="style.css" rel="stylesheet" type="text/css">
		<?php
		$sLang="english";
		if(isset($_REQUEST["lang"]))
			{
			$sLang=$_REQUEST["lang"];
			if($sLang=="")$sLang="english";
			}
		?>
		<script>
			var sLang="<?php  echo $sLang ?>";
			document.write("<scr"+"ipt src='language/"+sLang+"/asset.js'></scr"+"ipt>");
		</script>
		<script>writeTitle()</script>
		<script>
		var bReturnAbsolute=<?php  if($bReturnAbsolute){echo "true";} else{echo "false";} ?>;
		var activeModalWin;

		function getAction()
			{
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			//Clean previous ffilter=...
			sQueryString=window.location.search.substring(1)
			sQueryString=sQueryString.replace(/ffilter=media/,"")
			sQueryString=sQueryString.replace(/ffilter=image/,"")
			sQueryString=sQueryString.replace(/ffilter=flash/,"")
			sQueryString=sQueryString.replace(/ffilter=/,"")
			if(sQueryString.substring(sQueryString.length-1)=="&")
				sQueryString=sQueryString.substring(0,sQueryString.length-1)

			if(sQueryString.indexOf("=")==-1)
				{//no querystring
				sAction="assetmanager.php?ffilter="+document.getElementById("selFilter").value;
				}
			else
				{
				sAction="assetmanager.php?"+sQueryString+"&ffilter="+document.getElementById("selFilter").value
				}
			//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
			return sAction;
			}

		function applyFilter()//ffilter
			{
			var Form1 = document.forms.Form1;

			Form1.elements.inpCurrFolder.value=document.getElementById("selCurrFolder").value;
			Form1.elements.inpFileToDelete.value="";

			Form1.action=getAction()
			Form1.submit()
			}
		function refreshAfterDelete(sDestination)
			{
			var Form1 = document.forms.Form1;

			Form1.elements.inpCurrFolder.value=sDestination;
			Form1.elements.inpFileToDelete.value="";

			Form1.action=getAction()
			Form1.submit();
			}
		function changeFolder()
			{
			var Form1 = document.forms.Form1;

			Form1.elements.inpCurrFolder.value=document.getElementById("selCurrFolder").value;
			Form1.elements.inpFileToDelete.value="";

			Form1.action=getAction();
			Form1.submit();
			}

		function upload()
			{
			var Form2 = document.forms.Form2;

			if(Form2.elements.File1.value == "")return;

			var sFile=Form2.elements.File1.value.substring(Form2.elements.File1.value.lastIndexOf("\\")+1);
			for(var i=0;i<document.getElementById("inpNumOfFiles").value;i++)
				{
				if(sFile==document.getElementById("idFile"+(i*1+1)).innerHTML)
					{
					if(confirm(getTxt("File already exists. Do you want to replace it?"))!=true)return;
					}
				}

			Form2.elements.inpCurrFolder2.value=document.getElementById("selCurrFolder").value;
			document.getElementById("idUploadStatus").innerHTML=getTxt("Uploading...")

			Form2.action=getAction()
			Form2.submit();
			}
		function modalDialogShow(url,width,height)//moz
		    {
		    var left = screen.availWidth/2 - width/2;
		    var top = screen.availHeight/2 - height/2;
		    activeModalWin = window.open(url, "", "width="+width+"px,height="+height+",left="+left+",top="+top);
		    window.onfocus = function(){if (activeModalWin.closed == false){activeModalWin.focus();};};
		    }
		function newFolder()
			{
			if(navigator.appName.indexOf('Microsoft')!=-1)
				window.showModalDialog("foldernew.php",window,"dialogWidth:250px;dialogHeight:192px;edge:Raised;center:Yes;help:No;resizable:No;");
			else
				modalDialogShow("foldernew.php", 250, 150);
			}
		function deleteFolder()
			{
			var selCurrFolder = document.getElementById("selCurrFolder");

			if(selCurrFolder.value.toLowerCase()==document.getElementById("inpAssetBaseFolder0").value.toLowerCase() ||
			selCurrFolder.value.toLowerCase()==document.getElementById("inpAssetBaseFolder1").value.toLowerCase() ||
			selCurrFolder.value.toLowerCase()==document.getElementById("inpAssetBaseFolder2").value.toLowerCase() ||
			selCurrFolder.value.toLowerCase()==document.getElementById("inpAssetBaseFolder3").value.toLowerCase())
				{
				alert(getTxt("Cannot delete Asset Base Folder."));
				return;
				}

			if(navigator.appName.indexOf('Microsoft')!=-1)
				window.showModalDialog("folderdel.php?sid=<?= session_id() ?>",window,"dialogWidth:250px;dialogHeight:192px;edge:Raised;center:Yes;help:No;resizable:No;");
			else
				modalDialogShow("folderdel.php?sid=<?= session_id() ?>", 250, 150);
			}
		function downloadFile(index)
			{
			sFile_RelativePath = document.getElementById("inpFile"+index).value;
			window.open(sFile_RelativePath)
			}
		function selectFile(index)
			{
			sFile_RelativePath = document.getElementById("inpFile"+index).value;

			//This will make an Absolute Path
			if(bReturnAbsolute)
				{
				sFile_RelativePath = window.location.protocol + "//" + window.location.host.replace(/:80/,"") + sFile_RelativePath
				//Ini input dr yg pernah pake port:
				//sFile_RelativePath = window.location.protocol + "//" + window.location.host.replace(/:80/,"") + "/" + sFile_RelativePath.replace(/\.\.\//g,"")
				}

			document.getElementById("inpSource").value=sFile_RelativePath;

			var arrTmp = sFile_RelativePath.split(".");
			var sFile_Extension = arrTmp[arrTmp.length-1]
			var sHTML="";

			//Image
			if(sFile_Extension.toUpperCase()=="GIF" || sFile_Extension.toUpperCase()=="JPG" || sFile_Extension.toUpperCase()=="PNG")
				{
				sHTML = "<img src=\"" + sFile_RelativePath + "\" >"
				}
			//SWF
			else if(sFile_Extension.toUpperCase()=="SWF")
				{
				sHTML = "<object "+
					"classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' " +
					"width='100%' "+
					"height='100%' " +
					"codebase='http://active.macromedia.com/flash6/cabs/swflash.cab#version=6.0.0.0'>"+
					"	<param name=movie value='"+sFile_RelativePath+"'>" +
					"	<param name=quality value='high'>" +
					"	<embed src='"+sFile_RelativePath+"' " +
					"		width='100%' " +
					"		height='100%' " +
					"		quality='high' " +
					"		pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'>" +
					"	</embed>"+
					"</object>";
				}
			//Video
			else if(sFile_Extension.toUpperCase()=="WMV"||sFile_Extension.toUpperCase()=="AVI"||sFile_Extension.toUpperCase()=="MPG")
				{
				sHTML = "<embed src='"+sFile_RelativePath+"' hidden=false autostart='true' type='video/avi' loop='true'></embed>";
				}
			//Sound
			else if(sFile_Extension.toUpperCase()=="WMA"||sFile_Extension.toUpperCase()=="WAV"||sFile_Extension.toUpperCase()=="MID")
				{
				sHTML = "<embed src='"+sFile_RelativePath+"' hidden=false autostart='true' type='audio/wav' loop='true'></embed>";
				}
			//Files (Hyperlinks)
			else
				{
				sHTML = "<br><br><br><br><br><br>Not Available"
				}

			document.getElementById("idPreview").innerHTML = sHTML;
			}
		function deleteFile(index)
			{
			if (confirm(getTxt("Delete this file ?")) == true)
				{
				sFile_RelativePath = document.getElementById("inpFile"+index).value;

				var Form1 = document.getElementById("Form1");
				Form1.elements.inpCurrFolder.value=document.getElementById("selCurrFolder").value;
				Form1.elements.inpFileToDelete.value=sFile_RelativePath;

				Form1.action=getAction()
				Form1.submit();
				}
			}
		bOk=false;
		function doOk()
			{
			if(navigator.appName.indexOf('Microsoft')!=-1)
				window.returnValue=inpSource.value;
			else
				window.opener.setAssetValue(document.getElementById("inpSource").value);
			bOk=true;
			self.close();
			}
		function doUnload()
			{
			if(navigator.appName.indexOf('Microsoft')!=-1)
				if(!bOk)window.returnValue="";
			else
				if(!bOk)window.opener.setAssetValue("");
			}
		</script>
		</head>
		<body onunload="doUnload()" onload="loadTxt();this.focus();if(document.getElementById('inpUploadedFile').value!='')selectFile(document.getElementById('inpUploadedFile').value);" style="overflow:hidden;margin:0px;">

		<input type="hidden" name="inpAssetBaseFolder0" id="inpAssetBaseFolder0" value="<?php  echo $sBase0 ?>">
		<input type="hidden" name="inpAssetBaseFolder1" id="inpAssetBaseFolder1" value="<?php  echo $sBase1 ?>">
		<input type="hidden" name="inpAssetBaseFolder2" id="inpAssetBaseFolder2" value="<?php  echo $sBase2 ?>">
		<input type="hidden" name="inpAssetBaseFolder3" id="inpAssetBaseFolder3" value="<?php  echo $sBase3 ?>">

		<table width="100%" height="100%" align=center style="" cellpadding=0 cellspacing=0 border=0 >
		<tr>
		<td valign=top style="background:url('images/bg.gif') no-repeat right bottom;padding-top:5px;padding-left:5px;padding-right:5px;padding-bottom:0px;">
				<!--ffilter-->
				<form method=post name="Form1" id="Form1">
						<input type="hidden" name="inpFileToDelete">
						<input type="hidden" name="inpCurrFolder">
				</form>

				<table width=100% border="0">
				<tr>
				<td>
						<table cellpadding="2" cellspacing="2" border="0">
						<tr>
						<td valign=center nowrap><?php  writeFolderSelections(); ?>&nbsp;</td>
						<td nowrap>
							<span onclick="newFolder()" style="cursor:pointer;"><u><span name="txtLang" id="txtLang" <?php echo $sFolderAdmin;?>>New&nbsp;Folder</span></u></span>&nbsp;
							<span onclick="deleteFolder()" style="cursor:pointer;"><u><span name="txtLang" id="txtLang" <?php echo $sFolderAdmin;?>>Del&nbsp;Folder</span></u></span>
						</td>
						<td  width=100% align="right">

						<?php
						//ffilter~~~~~~~~~
							$sHTMLFilter = "<select name=selFilter id=selFilter onchange='applyFilter()' class='inpSel'>"; //ffilter
							$sAll="";
							$sMedia="";
							$sImage="";
							$sFlash="";
							if($ffilter=="") $sAll="selected";
							if($ffilter=="media") $sMedia="selected";
							if($ffilter=="image") $sImage="selected";
							if($ffilter=="flash") $sFlash="selected";
							$sHTMLFilter = $sHTMLFilter."	<option name=optLang id=optLang value='' ".$sAll."></option>";
							$sHTMLFilter = $sHTMLFilter."	<option name=optLang id=optLang value='media' ".$sMedia."></option>";
							$sHTMLFilter = $sHTMLFilter."	<option name=optLang id=optLang value='image' ".$sImage."></option>";
							$sHTMLFilter = $sHTMLFilter."	<option name=optLang id=optLang value='flash' ".$sFlash."></option>";
							$sHTMLFilter = $sHTMLFilter."</select>";
							echo $sHTMLFilter;
						//~~~~~~~~~
						?>

						</td>
						</tr>
						</table>
				</td>
				</tr>
				<tr>
				<td valign=top align="center">

						<table width=100% cellpadding=0 cellspacing=0>
						<tr>
						<td>
							<div id="idPreview" style="text-align:center;overflow:auto;width:297;height:245;border:#d7d7d7 5px solid;border-bottom:#d7d7d7 3px solid;background:#ffffff;margin-right:2;"></div>
							<div align=center><input type="text" id="inpSource" name="inpSource" style="border:#cfcfcf 1px solid;width:295" class="inpTxt"></div>
						</td>
						<td valign=top width=100%>
							<?php  writeFileSelections(); ?>
						</td>
						</tr>
						</table>

				</td>
				</tr>
				<tr>
				<td>
						<div <?php echo $sFolderAdmin;?>>
						<div style="height:12">
						<font color=red><?php  echo $sMsg ?></font>
						<span style="font-weight:bold" id=idUploadStatus></span>
						</div>


						<form enctype="multipart/form-data" method="post" runat="server" name="Form2" id="Form2">
						<input type="hidden" name="inpCurrFolder2" ID="inpCurrFolder2">
						<!--ffilter-->
						<input type="hidden" name="inpFilter" ID="inpFilter" value="<?php  echo $ffilter ?>">
						<span name="txtLang" id="txtLang">Upload File</span>: <input type="file" id="File1" name="File1" class="inpTxt">&nbsp;
						<input name="btnUpload" id="btnUpload" type="button" value="upload" onclick="upload()" class="inpBtn" onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">
						</form>
						</div>
				</td>
				</tr>
				</table>

		</td>
		</tr>
		<tr>
		<td class="dialogFooter" style="height:40px;padding-right:15px;" align=right valign=middle>
			<table cellpadding=0 cellspacing=0 ID="Table2">
			<tr>
			<td>
			<input name="btnOk" id="btnOk" type="button" value=" ok " onclick="doOk()" class="inpBtn" onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">
			</td>
			</tr>
			</table>
		</td>
		</tr>
		</table>

		</body>
		</html>
		<?php
	}
?>