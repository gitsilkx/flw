<?php
include("includes/access.php");
include("includes/header.php");
$msg="";
if($_POST[Update]):
   if(!$_POST[cat_id]):

      $r=mysql_query("insert into " . $prev . "categories(cat_name,cat_code,cat_desc,status,ord,parent_id,meta_keys,site_title,meta_desc) values(\"" . $_POST[cat_name] . "\",\"" . $_POST[cat_code] . "\",\"" . $_POST[cat_desc] . "\",\"" .$_POST[status] . "\",\"" .$_POST[ord] . "\",\"" .$_POST[parent_id] . "\",\"" .$_POST[meta_keys] . "\",\"" .$_POST[site_title] . "\",\"" .$_POST[meta_desc] . "\")");
	   $cat_id=mysql_insert_id();

   else:
       $r=mysql_query("update " . $prev . "categories set cat_name=\"" . $_POST[cat_name] . "\",cat_code=\"" . $_POST[cat_code] . "\",cat_desc=\"" . $_POST[cat_desc] . "\",status=\"" . $_POST[status] . "\",ord=\"" . $_POST[ord] . "\",parent_id=\"" .$_POST[parent_id] . "\",meta_keys=\"".$_REQUEST[meta_keys]."\",
	   site_title=\"".$_REQUEST[site_title]."\",meta_desc=\"".$_REQUEST[meta_desc]."\" where cat_id=" . $_POST[cat_id]);

	   $cat_id=$_POST[cat_id];
   endif;
   if($r):
   	   if($_FILES[pic][name]!=""):
		 	 $ext=substr($_FILES[pic][name],-3,3);
			 copy($_FILES[pic][tmp_name],"../cat_pic/" . $cat_id . "." . $ext);
             mysql_query("update " . $prev . "categories set pic='product_photo/cat_" . $cat_id . "." . $ext . "' where cat_id=" . $cat_id);
        endif;
       $msg="<font face='verdana' size='1' color='#ffffff'><b>Update Successful.</b></font>";
       echo"<script>window.location.href='category.list.php';</script>";
   else:
       $msg="<font face='verdana' size='1' color='#ffffff'><b>Update Failure.</b></font>";
   endif;
elseif($_POST[DELT]):
   $r=mysql_query("select * from " . $prev . "product_cat where cat_id=" . $_POST[cat_id]);
   if(@mysql_num_rows($r)):
      $msg="<font face='verdana' size='1' color='#ffffff'><b>You Can't delete.Products is there.</b></font>";
   else:
      $r=mysql_query("delete from " . $prev . "categories where cat_id=\"" . $_POST[cat_id] . "\"");
      echo"<script>window.location.href='category.list.php';</script>";
   endif;
endif;
if($_REQUEST[parent_id]):
   $r=mysql_query("select * from  " . $prev . "categories where cat_id=" . $_REQUEST[parent_id]);
   $dd=mysql_fetch_array($r);
endif;
if($_REQUEST[cat_id] && !$_POST[del]):
   $r=mysql_query("select * from  " . $prev . "categories where cat_id=" . $_GET[cat_id]);
   $d=mysql_fetch_array($r);
endif;
?>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
<input type="hidden" name="cat_id" value="<?=$_REQUEST[cat_id]?>">
<input type="hidden" name="parent_id" value="<?=$_REQUEST[parent_id]?>">
<table width="100%" border="0" align="center" cellpadding=4 cellspacing="1" bgcolor="<?=$light?>">
	<tr class="header"><td height="26" colspan="2" style='border-bottom:solid 1px #333333'><b>Add/Modify Category <? if($_REQUEST[parent_id]){echo"(Under : " . $dd[cat_name] . ")";}?> : <?=stripslashes($d["cat_name"])?></b></td></tr>
	<tr class="lnk" bgcolor="#ffffff"><td>Category Name</td><td><input type="text" size="35" name="cat_name" value='<?=stripslashes($d[cat_name])?>' class="lnk"></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td>Category Code</td><td><input type="text" size="35" name="cat_code" value='<?=stripslashes($d[cat_code])?>' class="lnk"></td></tr>

	<tr bgcolor="#ffffff"><td valign="top" class="lnk">Picture</td><td>
	<?
	if($d[photo]=='Y'):
		echo@resize("../". $d[pic],150);
		echo"<br>";
	endif;
	?>
	<input type="file" name="pic" class="lnk" size="20"></td></tr>

	<tr class="lnk" bgcolor="#ffffff"><td valign="top">Description</td><td><textarea cols="60" rows="6" class="lnk" name="cat_desc"><?=$d[cat_desc]?></textarea></td></tr>
    <tr bgcolor="#ffffff" class="lnk">
		<td bgcolor="#e9e9e9" valign="top" ><b>Product Page Title :</b></td>

		<td><input type=text class="lnk" name="site_title" value="<?=$d[site_title]?>"  style='width:400px;height:22px' /></td>
	</tr>
	<tr bgcolor="#ffffff" class="lnk">
		<td bgcolor="#e9e9e9" valign="top" ><b>Meta Keywords :</b></td>

		<td><textarea class="lnk" name="meta_keys" style='width:400px;height:70px'><?=$d[meta_keys]?></textarea><br>You have to put a comma(,) between two keywords</td>
	</tr>
	<tr bgcolor="#ffffff" class="lnk">
		<td bgcolor="#e9e9e9" valign="top" ><b>Meta Description :</b></td>

		<td><textarea class="lnk" name="meta_desc" style='width:400px;height:70px'><?=$d[meta_desc]?></textarea><br></td>
	</tr>

	<tr bgcolor="#ffffff" class="lnk"><td valign="top">Order By </td><td><input type=text name=ord value="<?=$d[ord]?>" size=5>&nbsp;[Exa. 4]</td></tr>
	<tr bgcolor="#ffffff" class="lnk"><td>Status</td><td ><input type="radio" name="status"  checked="checked" value="Y" <?if($d["status"]=="Y"){echo" checked";}?> >Online <input type="radio" name="status" value="N" <?if($d["status"]=="N"){echo" checked";}?>> Offline</td></tr>
	<tr><td></td><td ><input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<? if($d[cat_id]){?><input type="submit" name="DELT" value="Delete" class="button">&nbsp;&nbsp;<? }?><input type="Button"  value="Back" onClick="JavaScript:window.location.href='category.list.php';" class="button">&nbsp;&nbsp;<Blnk><?=$msg?></Blnk></td></tr>
</table>
</form>
<?php
include("includes/footer.php");
?>