<?
include("includes/access.php");
include("includes/header.php");
?>
<Script Language="JavaScript">
<!--
function isValid(T)
{
    if(!Trim(T.co_name.value))
    {
        alert("adminmenu Name is empty");
        return false;
    }
}

function Trim (s)
{
    var iLen = s.length;
    var sOut = "";
    var chr = "";
    for (var i=0; i<iLen; i++)
    {
        chr = s.charAt (i); 
        if (chr!=" ")
            sOut = sOut + chr; 
    }
    return sOut;
}
-->
</Script>
<?
$msg="";
if($_POST[Update]):
   if(!$_POST[id]):
       $r=mysql_query("insert into " . $prev . "adminmenu(name,status,url,ord,parent_id,menu_desc) values (\"" . $_POST[name] . "\",\"" .$_POST[status] . "\",\"" .$_POST[url] . "\",\"" . $_POST[ord] . "\",\"" . $_POST[parent_id] . "\",\"" . $_POST[menu_desc] . "\")");
	  // echo"insert into " . $prev . "adminmenu(name,status,url,ord,parent_id,menu_desc) values (\"" . $_POST[name] . "\",\"" .$_POST[status] . "\",\"" .$_POST[url] . "\",\"" . $_POST[ord] . "\",\"" . $_POST[parent_id] . "\",\"" . $_POST[menu_desc] . "\")";
	   $id=mysql_insert_id();
	   
	   if($_FILES[icon][name]!=""):
		   $file_name=$_FILES[icon][tmp_name];
		   $filename_name=$_FILES[icon][name];
		   //echo ":::".$filename_name;
	       $ext=substr($filename_name,-3,3);
		   //echo "menuPics/1" . $id. "." . $ext;
	       copy($file_name,"menuPics/" . $id. "." . $ext);
		   $r=mysql_query("update " . $prev . "adminmenu set pic='menuPics/" . $id. "." . $ext."' where id='".$id."'");
		endif;
   else:
   
    	if($_FILES[icon][name]!=""):
	
		  
	
			$id=$_POST['id'];
			  $file_name=$_FILES[icon][tmp_name];
		   $filename_name=$_FILES[icon][name];
		  // echo ":::".$filename_name;
	       $ext=substr($filename_name,-3,3);
		  // echo "menuPics/" . $id. "." . $ext;
		       copy($file_name,"menuPics/" . $id. "." . $ext);
		   $r=mysql_query("update " . $prev . "adminmenu set pic='menuPics/" . $id. "." . $ext."' where id=" . $_POST[id]);
		endif;
			
       $r=mysql_query("update " . $prev . "adminmenu set name=\"" . $_POST[name] . "\",status=\"" . $_POST[status] . "\",url=\"" . $_POST[url] . "\",parent_id=\"" . $_POST[parent_id] . "\",ord=\"" . $_POST[ord] . "\",menu_desc=\"" . $_POST[menu_desc] . "\" where id=" . $_POST[id]);
	   $id=$_POST[id];
	   //$r=mysql_query("update " . $prev . "adminmenu set pic='menuPics/" . $id. "." . $ext."' where id='".$id."'");
   endif;
   if($r):
   	   $msg="<font face=verdana size=1 color=#111111><b>Update Successful.</b></font>";
        /*?>echo"<script>window.location.href='adminmenu.list.php?tid=" . $_REQUEST[tid] . "';</script>";<?php */
   else: 
       $msg="<font face=verdana size=1 color=red><b>Update Failure.</b></font>";
   endif;		
elseif($_POST[DELT]):
   $r=mysql_query("select * from " . $prev . "adminmenu where parent_id=" . $_POST[id]);
   if(@mysql_num_rows($r)):
      $msg="<font face=verdana size=1 color=red><b>You Can't delete.Sub adminmenu exists there.</b></font>";	  
   else:
   	  $r=mysql_query("select * from  " . $prev . "adminmenu where id=" . $_POST[id]);
   	  $d=mysql_fetch_array($r);
      echo"<script>window.location.href='adminmenu.list.php?tid=" . $_REQUEST[tid] . "';</script>";
   endif;
endif;
if($_REQUEST[id]):
   $r=mysql_query("select * from  " . $prev . "adminmenu where id=" . $_REQUEST[id]);
   $d=mysql_fetch_array($r);
endif;
if($_REQUEST[parent_id]):
   $r=mysql_query("select * from  " . $prev . "adminmenu where id=" . $_REQUEST[parent_id]);
   $dd=mysql_fetch_array($r);
endif;

if($msg){echo"<div align=center class=lnk>" . $msg . "</div>";}
if(!$d["status"]){$d["status"]="Y";}

if($_POST['id'])
{
?>
<script>document.location.href="adminmenu.list.php"</script>
<?
}
?>

<form action="<?=$_SERVER[PHP_SELF]?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="parent_id" value=<?=$_REQUEST[parent_id]?>>
<input type="hidden" name="id" value="<?=$_REQUEST[id]?>">
<input type="hidden" name="tid" value="<?=$_REQUEST[tid]?>">
<table width="100%" border="0" align="center" cellpadding=3 cellspacing=1 bgcolor="<?=$light?>">

<tr class=header_tr>
  <td height=25 colspan=2><a href='adminmenu.list.php?tid=<?=$_REQUEST[tid]?>' class=header><b><u>Admin Menu List</u></b></a> > <b>Add/Modify Admin Menu <? if($_REQUEST[parent_id]){echo"(Under : " . $dd[name] . ")";}?>  : <?=$d["name"]?></b></td>
</tr>
<tr class=lnk bgcolor=#ffffff><td valign=top>Name</td><td><input type="text" size=55 name="name" value="<?=$d[name]?>" class=lnk></td></tr>
<tr class=lnk bgcolor=#ffffff><td valign=top>Url</td><td><input type="text" size=55 name="url" value="<?=$d[url]?>" class=lnk></td></tr>
<tr class=lnk bgcolor=#ffffff><td valign=top>Menu Order</td><td><input type="text" size=5 name="ord" value="<?=$d[ord]?>" class=lnk> [Example. 2]</td></tr>
<tr bgcolor=#ffffff class=lnk><td>Status</td><td><input type=radio name=status value="Y" <? if($d["status"]=="Y"){echo" checked";}?> >Online <input type=radio name=status value="N" <? if($d["status"]=="N"){echo" checked";}?>> Offline </td></tr>
<tr class=lnk bgcolor=#ffffff><td valign=top>Menu Icon</td><td>
<?php

if($d["pic"]!='')
{
	echo "<img src=".$d["pic"]." width=16 height=16>";
}
?>
<input name="icon" type="file" id="icon" /></td>
</tr>
<tr><td align=center  colspan=2 ><input type="submit" name="Update" value="Update" class=lnk>&nbsp;&nbsp;<? if($_REQUEST[id]){?><?}?>&nbsp;&nbsp;<input type="Button"  value="Back" onClick="JavaScript:window.location.href='adminmenu.list.php';" class=lnk></td></tr>

</form>
</table><br>
</form>

<?
include("includes/footer.php");
?>