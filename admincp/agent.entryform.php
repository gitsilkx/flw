<?php
include("includes/access.php");
include("includes/header.php");

$pid=($_REQUEST['pid']=='')?0:$_REQUEST['pid'];
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
				if(document.getElementById('attributes_name').value=='')
				{
					txt+="     district name should not be empty.\n"
				}
				if(txt)
				{
					alert("Sorry!! you left some mandatory fields :\n\n"+ txt +"\n Please Check");
					return false;
				}
				return true;	
			}//-->
		</script>
<?php
$msg="";
if($_REQUEST[Update])
{
	if(!$_REQUEST['agent_id'])
	{
	    $insert_query = "insert into ".TABLE_AGENT_IP." set 
		agent_ip='" . $_REQUEST['agent_ip'] .  "'
               ";
		
		$r=mysql_query($insert_query);
	}
   	else
	{
   		$upd_query = "update ".TABLE_AGENT_IP." set
		agent_ip='" . $_REQUEST['agent_ip'] .  "'
			where id='".$_REQUEST['agent_id']."'	";		
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
	   
	}
   pageRedirect("agent.list.php?pid=$pid");
 }	
if($_REQUEST['agent_id'])
{
	$agent_id=$_REQUEST['agent_id'];
	$r=mysql_query("select * from ".TABLE_AGENT_IP." where id=" . $agent_id);
	$d=@mysql_fetch_array($r);
	
}

if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="attribute_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
	<input type="hidden" name="agent_id" value="<?=$agent_id?>">
<input type="hidden" name="pid" value="<?=$pid?>">
		<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
		<tr bgcolor=<?=$light?>>
			<td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='agent.list.php?pid=<?=$pid?>' class="header" target="_parent">
	<u>Agent IP Management</u></a> > <br /> Add/Modify Agent Ip : <?=$d['agent_ip']?> </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Agent IP <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="agent_ip" type="text" id="agent_ip" class="lnk" value="<?=$d['agent_ip']?>" size="40" ></td></tr>	
	<tr bgcolor=<?=$light?> ><td></td>
	<td >
	<input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
</table>
</form>
<?
include("includes/footer.php");
?>
