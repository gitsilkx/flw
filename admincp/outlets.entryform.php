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
				if(document.getElementById('outlets_name').value=='')
				{
					txt+="     outlets name should not be empty.\n"
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
	if(!$_REQUEST['outlets_id'])
	{
		$outlets_code=randPass('8',"ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890");
	    $insert_query = "insert into " .TABLE_OUTLETS." set 
		outlets_name='" . $_REQUEST['outlets_name'] .  "',
		outlets_takeaway_status='" . $_REQUEST['outlets_takeaway_status']."',
		outlets_delivery_status='" . $_REQUEST['outlets_delivery_status']."',
		outlets_status='" . $_REQUEST['outlets_status']."',
		outlets_code='$outlets_code'";
		$r=mysql_query($insert_query);
	}
   	else
	{
   		$upd_query = "update " .TABLE_OUTLETS." set 
		outlets_name='" . $_REQUEST['outlets_name'] .  "',
		outlets_takeaway_status='" . $_REQUEST['outlets_takeaway_status']."',
		outlets_delivery_status='" . $_REQUEST['outlets_delivery_status']."',
		outlets_status='" . $_REQUEST['outlets_status']."'
		where outlets_id='".$_REQUEST['outlets_id']."'	";
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
	   
	}
   pageRedirect('outlets.list.php');
 }	
#if product exists /fetch data
if($_REQUEST['outlets_id'])
{
	$outlets_id=$_REQUEST['outlets_id'];
	$r=mysql_query("select * from ".TABLE_OUTLETS." where outlets_id=" . $outlets_id);
	$d=@mysql_fetch_array($r);
	
}

if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="prod_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
	<input type="hidden" name="outlets_id" value="<?=$outlets_id?>">

	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='outlets.list.php' class="header" target="_parent">
	<u>Outlets Management</u></a> > <br /> Add/Modify Outlets : <?=$d['outlets_name']?> </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Outlets Name <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="outlets_name" type="text" id="outlets_name" class="lnk" value="<?=$d['outlets_name']?>" size="40" ></td></tr>
	
	
	      
	<tr bgcolor="#ffffff" class="lnk"> <td bgcolor="#e9e9e9"><b>Status :</b></td><td align="left"><input type="radio" name="outlets_status"  checked="checked" value="Y" <? if($d["outlets_status"]=="Y"){ echo" checked";}?> >Active <input type="radio" name="outlets_status" value="N" <? if($d["outlets_status"]=="N"){echo" checked";}?>> In Active</td></tr>
	
	<tr bgcolor="#ffffff" class="lnk"> <td bgcolor="#e9e9e9"><b>Takeaway :</b></td><td align="left">
	<input type="radio" name="outlets_takeaway_status" checked="checked" value="N" <? if($d["outlets_takeaway_status"]=="N"){echo" checked";}?>> In Active
	<input type="radio" name="outlets_takeaway_status"   value="Y" <? if($d["outlets_takeaway_status"]=="Y"){ echo" checked";}?> >Active </td></tr>
	
	<tr bgcolor="#ffffff" class="lnk"> <td bgcolor="#e9e9e9"><b>Delivery :</b></td><td align="left">
	<input type="radio" name="outlets_delivery_status" checked="checked" value="N" <? if($d["outlets_delivery_status"]=="N"){echo" checked";}?>> In Active
	<input type="radio" name="outlets_delivery_status"   value="Y" <? if($d["outlets_delivery_status"]=="Y"){ echo" checked";}?> >Active </td></tr>
	
	
	<tr bgcolor=<?=$light?> ><td></td>
	<td >
	<input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
</table>
</form>
<?
include("includes/footer.php");
?>
