<?php
include("includes/access.php");
include("includes/header.php");

?>
 
	<!--Script for validation-->
	
	<script language="javascript">
		<!--
		
			function isEmail(Ml)
			{
			  if(!Ml){return true}
			  if(Ml.indexOf("@")<=0 || Ml.indexOf("@")==Ml.length-1 || Ml.indexOf(".")<=0 || Ml.indexOf(".")==Ml.length-1 || Ml.indexOf("..")!=-1 || Ml.indexOf("@@")!=-1 || Ml.indexOf("@.")!=-1 || Ml.indexOf(".@")!=-1)
			  {
				  return false
			  }
			  else
			  {
				  return true
			  }
			}
		
			function ValidProd()
			{
				var txt="";
				if(document.getElementById('combo_name').value=='')
				{
					txt+="  Combo name should not be empty.\n"
				}
				if(txt)
				{
					alert("Sorry!! you left some mandatory fields :\n\n"+ txt +"\n     Please Check");
					return false;
				}
				return true;	
			}//-->
		</script>
<?php
$msg="";
if($_REQUEST[Update])
{
	if(!$_REQUEST['combo_id'])
	{
		$combo_code=randPass('8',"ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890");
	    $insert_query = "insert into " .TABLE_COMBO." set 
		combo_name='" . $_REQUEST['combo_name'] .  "',
		combo_desc='".$_REQUEST['combo_desc']."',	
		combo_no_pizza='".$_REQUEST['combo_no_pizza']."',	
		combo_status='".$_REQUEST['combo_status']."',		
		combo_code='$combo_code'";
		$r=mysql_query($insert_query);
	}
   	else
	{
   		$upd_query = "update " .TABLE_COMBO." set 
		combo_name='" . $_REQUEST['combo_name'] .  "',
		combo_desc='".$_REQUEST['combo_desc']."',		
		combo_status='".$_REQUEST['combo_status']."',
		combo_no_pizza='".$_REQUEST['combo_no_pizza']."'
		where combo_id='".$_REQUEST['combo_id']."'	";
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
	   
	}
   pageRedirect('combo.list.php');
 }	
#if product exists /fetch data
if($_REQUEST['combo_id'])
{
	$combo_id=$_REQUEST['combo_id'];
	$r=mysql_query("select * from ".TABLE_COMBO." where combo_id=" . $combo_id);
	$d=@mysql_fetch_array($r);
	
}

if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="prod_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
	<input type="hidden" name="combo_id" value="<?=$combo_id?>">

	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='combo.list.php' class="header" target="_parent">
	<u>Combo Management</u></a> > <br /> Add/Modify Combo : <?=$d['combo_name']?> </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Name <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="combo_name" type="text" id="combo_name" class="lnk" value="<?=$d['combo_name']?>" size="40" ></td></tr>

<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>No. Pizza <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="combo_no_pizza" type="text" id="combo_no_pizza" class="lnk" value="<?=$d['combo_no_pizza']?>" size="40" ></td></tr>

<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Description <a class='lnkred'>*</a> :</b></td><td width="67%" ><textarea name="combo_desc" cols="40" class="lnk" id="combo_desc"><?=$d['combo_desc']?></textarea></td></tr>  
	<tr bgcolor="#ffffff" class="lnk"> <td bgcolor="#e9e9e9"><b>Status :</b></td><td align="left"><input type="radio" name="combo_status"  checked="checked" value="Y" <? if($d["combo_status"]=="Y"){ echo" checked";}?> >Active <input type="radio" name="combo_status" value="N" <? if($d["combo_status"]=="N"){echo" checked";}?>> In Active</td></tr>
	
	
	
	
	
	
	<tr bgcolor=<?=$light?> ><td></td>
	<td >
	<input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
</table>
</form>
<?
include("includes/footer.php");
?>
