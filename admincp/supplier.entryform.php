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
	if(!$_REQUEST['supplier_id'])
	{
	    $insert_query = "insert into ".TABLE_SUPPLIERS." set 
		supplier_name='" . $_REQUEST['supplier_name'] .  "',
                supplier_code='" . $_REQUEST['supplier_code'] .  "',    
		status='" . $_REQUEST['status'] .  "'";
		
		$r=mysql_query($insert_query);
	}
   	else
	{
   		$upd_query = "update ".TABLE_SUPPLIERS." set
		supplier_name='" . $_REQUEST['supplier_name'] .  "',
                supplier_code='" . $_REQUEST['supplier_code'] .  "',    
		status='" . $_REQUEST['status'] .  "'
			where supplier_id='".$_REQUEST['supplier_id']."'	";
		
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
	   
	}
   pageRedirect("supplier.list.php?pid=$pid");
 }	
if($_REQUEST['supplier_id'])
{
	$supplier_id=$_REQUEST['supplier_id'];
	$r=mysql_query("select * from ".TABLE_SUPPLIERS." where supplier_id=" . $supplier_id);
	$d=@mysql_fetch_array($r);
	
}

if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="attribute_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
	<input type="hidden" name="supplier_id" value="<?=$supplier_id?>">
<input type="hidden" name="pid" value="<?=$pid?>">
		<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
		<tr bgcolor=<?=$light?>>
			<td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='supplier.list.php?pid=<?=$pid?>' class="header" target="_parent">
	<u>Supplier Management</u></a> > <br /> Add/Modify Supplier : <?=$d['supplier_name']?> </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Supplier Name <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="supplier_name" type="text" id="supplier_name" class="lnk" value="<?=$d['supplier_name']?>" size="40" ></td></tr>
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Supplier Code <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="supplier_code" type="text" id="supplier_code" class="lnk" value="<?=$d['supplier_code']?>" size="40" ></td></tr>
	    
	<tr bgcolor="#ffffff" class="lnk"> <td bgcolor="#e9e9e9"><b>Supplier Status :</b></td><td align="left"><input type="radio" name="status"  checked="checked" value="Y" <? if($d["status"]=="Y"){ echo" checked";}?> >Active <input type="radio" name="status" value="N" <? if($d["status"]=="N"){echo" checked";}?>> In Active</td></tr>
	
	<tr bgcolor=<?=$light?> ><td></td>
	<td >
	<input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
</table>
</form>
<?
include("includes/footer.php");
?>
