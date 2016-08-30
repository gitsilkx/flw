<?php
include("includes/access.php");
include("includes/header.php");

?>
 
	<!--Script for validation-->
	
	<script language="javascript">
		
		
		function ValidProd()
			{
				var txt="";
				if(document.getElementById('cont_title').value=='')
				{
					txt+="  	content title should not be empty.\n"
				}
				if(txt)
				{
					alert("Sorry!! you left some mandatory fields :\n\n"+ txt +"\n     Please Check");
					return false;
				}
				return true;	
			}
			
		</script>
<?php
$msg="";
if($_REQUEST[Update])
{
$contents_desc=htmlentities($_REQUEST[contents]);
	if(!$_REQUEST['cont_id'])
	{
		echo $insert_query = "insert into " .$prev."contents set 
		cont_title='".$_REQUEST['cont_title']."',
		contents='".$contents_desc."',	
		status='".$_REQUEST['status']."',
		site_title='".$_REQUEST['site_title']."',
		meta_keys='".$_REQUEST['meta_keys']."',
		meta_desc='".$_REQUEST['meta_desc']."',
		meta_title='".$_REQUEST['meta_title']."',		
		desc_type='".$_REQUEST['desc_type']."'";
		
		$r=mysql_query($insert_query);
		$cont_id=mysql_insert_id();
	}
   	else
	{
   		$upd_query = "update ".$prev."contents set 
		cont_title='".$_REQUEST['cont_title']."',
		contents='".$contents_desc."',	
		status='".$_REQUEST['status']."',
		site_title='".$_REQUEST['site_title']."',
		meta_keys='".$_REQUEST['meta_keys']."',
		meta_desc='".$_REQUEST['meta_desc']."',
		meta_title='".$_REQUEST['meta_title']."',		
		desc_type='".$_REQUEST['desc_type']."'";
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
		
		$cont_id=$_REQUEST['cont_id'];
	   
	}
	if($r)
	{
		$msg = "<font color='green'>Data Updated Successfully</font>";
	}
	else
	{
		$msg = "<font color='red'>Sorry. There is some error.</font>";
	}
   	    
 }	
#if product exists /fetch data
if($_REQUEST['cont_id'])
{
	$cont_id=$_REQUEST['cont_id'];
	$r=mysql_query("select * from ".$prev."contents where cont_id=" . $cont_id);
	$d=@mysql_fetch_array($r);
	
}

if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="prod_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
	<input type="hidden" name="cont_id" value="<?=$cont_id?>">

	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="32" class="header"  style='border-bottom:solid 1px #333333'><a href='mng.contentlist.php?cont_id=<?=$d['cont_id']?>&menuid=<?=$_GET[menuid]?>&menupid=<?=$_GET[menupid]?>' class="header" target="_parent">
	<u>Contents Management</u></a> > <br /> Add/Modify Cuisine : </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>cont_title <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="cont_title" type="text" id="cont_title" class="lnk" value="<?=$d['cont_title']?>" size="40" ></td></tr>
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>contents <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="contents" type="text" id="contents" class="lnk" value="<?=$d['contents']?>" size="40" ></td></tr>
     	<tr  bgcolor="#ffffff" class=lnk><td colspan=2>
 
<?php
// Make sure you are using correct paths here.
include_once '../ckeditor/ckeditor.php';
include_once '../ckfinder/ckfinder.php';
 
$ckeditor = new CKEditor();
$ckeditor->basePath = '../ckeditor/';
$ckfinder = new CKFinder();
$ckfinder->BasePath = '../ckfinder/'; // Note: the BasePath property in the CKFinder class starts with a capital letter.
$ckfinder->SetupCKEditorObject($ckeditor);
$ckeditor->editor('cuisine_desc',html_entity_decode($d[cuisine_desc]));
?>
 
</td></tr>
	
	<tr bgcolor="#ffffff" class="lnk"> <td bgcolor="#e9e9e9"><b>Status :</b></td><td align="left"><input type="radio" name="status"  checked="checked" value="Y" <? if($d["status"]=="Y"){ echo" checked";}?> >Active <input type="radio" name="status" value="N" <? if($d["status"]=="N"){echo" checked";}?>> In Active</td></tr>
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Site Title <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="site_title" type="text" id="site_title" class="lnk" value="<?=$d['site_title']?>" size="40" ></td></tr>
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>	Meta keys <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="meta_keys" type="text" id="meta_keys" class="lnk" value="<?=$d['meta_keys']?>" size="40" ></td></tr>
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>	Meta Desc <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="meta_desc" type="text" id="meta_desc" class="lnk" value="<?=$d['meta_desc']?>" size="40" ></td></tr>
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>	Meta Title <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="meta_title" type="text" id="meta_title" class="lnk" value="<?=$d['meta_title']?>" size="40" ></td></tr>
	<tr bgcolor="#ffffff" class="lnk"> <td bgcolor="#e9e9e9"><b>Description Type :</b></td><td align="left"><input type="radio" name="desc_type"  checked="checked" value="1" <? if($d["desc_type"]=="1"){ echo" checked";}?> >Footer <input type="radio" name="desc_type" value="N" <? if($d["desc_type"]=="2"){echo" checked";}?>> Customer Register</td></tr>
	
	<tr bgcolor=<?=$light?> ><td></td>
	<td >
	<input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
</table>
</form>
<?
include("includes/footer.php");
?>
