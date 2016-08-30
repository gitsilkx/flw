<?php
include("includes/access.php");
include("includes/header.php");
$district_id=$_REQUEST['district_id'];

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
				if(document.getElementById('road_name').value=='')
				{
					txt+="     road name should not be empty.\n"
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
	if(!$_REQUEST['road_id'])
	{
	    $insert_query = "insert into " .TABLE_ROAD." set 
		road_name='" . $_REQUEST['road_name'] .  "',
		road_status='" . $_REQUEST['road_status'] .  "',
		district_id='" . $_REQUEST['district_id'] .  "'";
		$r=mysql_query($insert_query);
	}
   	else
	{
   		$upd_query = "update  " .TABLE_ROAD." set 
		road_name='" . $_REQUEST['road_name'] .  "',
		road_status='" . $_REQUEST['road_status'] .  "',
		district_id='" . $_REQUEST['district_id'] .  "'
		where road_id='".$_REQUEST['road_id']."'	";
		
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
	   
	}
   pageRedirect("road.list.php?district_id=$district_id");
 }	
#if product exists /fetch data
if($_REQUEST['road_id'])
{
	$road_id=$_REQUEST['road_id'];
	$r=mysql_query("select * from ".TABLE_ROAD." where road_id=" . $road_id);
	$d=@mysql_fetch_array($r);
	
}

if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="prod_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
	<input type="hidden" name="district_id" value="<?=$district_id?>">
		<input type="hidden" name="road_id" value="<?=$road_id?>">

	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='road.list.php?district_id=<?=$district_id?>' class="header" target="_parent">
	<u>Road Management</u></a> > <br /> Add/Modify Road : <?=$d['road_name']?> </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Road Name <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="road_name" type="text" id="road_name" class="lnk" value="<?=$d['road_name']?>" size="40" ></td></tr>
	
	
	      
	<tr bgcolor="#ffffff" class="lnk"> <td bgcolor="#e9e9e9"><b>Road Status :</b></td><td align="left"><input type="radio" name="road_status"  checked="checked" value="Y" <? if($d["road_status"]=="Y"){ echo" checked";}?> >Active <input type="radio" name="road_status" value="N" <? if($d["road_status"]=="N"){echo" checked";}?>> In Active</td></tr>
	
	<tr bgcolor=<?=$light?> ><td></td>
	<td >
	<input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
</table>
</form>
<?
include("includes/footer.php");
?>
