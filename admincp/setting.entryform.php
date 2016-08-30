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
				if(document.getElementById('config_variable').value=='')
				{
					txt+="  variable should not be empty.\n"
				}
				if(document.getElementById('config_value').value=='')
				{
					txt+="  value should not be empty.\n"
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
	if(!$_REQUEST['config_id'])
	{
		
	    $insert_query = "insert into " .TABLE_SETTINGS." set 
		config_variable='" . $_REQUEST['config_variable'] .  "',
		config_value='".$_REQUEST['config_value']."',
		description='".$_REQUEST['description']."',
		config_key='".$_REQUEST['config_key']."'";
		$r=mysql_query($insert_query);
	}
   	else
	{
   		$upd_query = "update " .TABLE_SETTINGS." set 
		config_variable='" . $_REQUEST['config_variable'] .  "',
		config_value='".$_REQUEST['config_value']."',
		description='".$_REQUEST['description']."',
		config_key='".$_REQUEST['config_key']."'		
		where config_id='".$_REQUEST['config_id']."'";
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
	   
	}
   pageRedirect('setting.list.php');
 }	
#if product exists /fetch data
if($_REQUEST['config_id'])
{
	$config_id=$_REQUEST['config_id'];
	$r=mysql_query("select * from ".TABLE_SETTINGS." where config_id=" . $config_id);
	$d=@mysql_fetch_array($r);
	
}

if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="prod_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
	<input type="hidden" name="config_id" value="<?=$config_id?>">

	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='setting.list.php' class="header" target="_parent">
	<u>Settings Management</u></a> > <br /> Add/Modify Settings : <?=$d['config_variable']?> </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Variable <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="config_variable" type="text" id="config_variable" class="lnk" value="<?=$d['config_variable']?>" size="40" ></td></tr>

	    <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Value <a class='lnkred'>*</a> :</b></td><td width="67%" >
	<input name="config_value" type="text" id="config_value" class="lnk" value="<?=$d['config_value']?>" size="40" >
	</td></tr>
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Key  :</b></td><td width="67%" >
	<input name="config_key" type="text" id="config_key" class="lnk" value="<?=$d['config_key']?>" size="40" >
	</td></tr>
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Description  :</b></td><td width="67%" ><textarea name="description" cols="40" class="lnk" id="description"><?=$d['description']?></textarea></td></tr>
	<tr bgcolor=<?=$light?> ><td></td>
	<td >
	<input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
</table>
</form>
<?
include("includes/footer.php");
?>
