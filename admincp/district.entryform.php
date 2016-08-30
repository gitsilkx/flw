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
				if(document.getElementById('district_name').value=='')
				{
					txt+="     district name should not be empty.\n"
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
	if(!$_REQUEST['district_id'])
	{
	    $insert_query = "insert into " .TABLE_DISTRICT." set 
		district_name='" . $_REQUEST['district_name'] .  "',
		district_status='" . $_REQUEST['district_status'] .  "'";
		$r=mysql_query($insert_query);
	}
   	else
	{
   		$upd_query = "update " .TABLE_DISTRICT." set
		district_name='" . $_REQUEST['district_name'] .  "',
		district_status='" . $_REQUEST['district_status'] . "'
		where district_id='".$_REQUEST['district_id']."'	";
		
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
	   
	}
   pageRedirect('district.list.php');
 }	
#if product exists /fetch data
if($_REQUEST['district_id'])
{
	$district_id=$_REQUEST['district_id'];
	$r=mysql_query("select * from ".TABLE_DISTRICT." where district_id=" . $district_id);
	$d=@mysql_fetch_array($r);
	
}

if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="prod_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
	<input type="hidden" name="district_id" value="<?=$district_id?>">

	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='district.list.php' class="header" target="_parent">
	<u>District Management</u></a> > <br /> Add/Modify District : <?=$d['district_name']?> </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>District Name <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="district_name" type="text" id="district_name" class="lnk" value="<?=$d['district_name']?>" size="40" ></td></tr>
	
	
	      
	<tr bgcolor="#ffffff" class="lnk"> <td bgcolor="#e9e9e9"><b>District Status :</b></td><td align="left"><input type="radio" name="district_status"  checked="checked" value="Y" <? if($d["district_status"]=="Y"){ echo" checked";}?> >Active <input type="radio" name="district_status" value="N" <? if($d["district_status"]=="N"){echo" checked";}?>> In Active</td></tr>
	
	<tr bgcolor=<?=$light?> ><td></td>
	<td >
	<input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
</table>
</form>
<?
include("includes/footer.php");
?>
