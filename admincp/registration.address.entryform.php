<?php
include("includes/access.php");
include("includes/header.php");
$registration_id=$_REQUEST['registration_id'];

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
				if(document.getElementById('address_type').value=='')
				{
					txt+="     address type name should not be empty.\n"
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
	if(!$_REQUEST['address_id'])
	{
	    $insert_query = "insert into " .TABLE_REGISTRATION_ADDRESS." set 
		road_name='" . $_REQUEST['road_name'] .  "',
		road_status='" . $_REQUEST['road_status'] .  "',
		district_id='" . $_REQUEST['district_id'] .  "'";
		$r=mysql_query($insert_query);
	}   	
	else  
	{$upd_query = "update  " .TABLE_REGISTRATION_ADDRESS." set 
		address_type='" . $_REQUEST['address_type']."',
		phone='" . $_REQUEST['phone']."',
		company_name='" . $_REQUEST['company_name']."',
		building_name='" . $_REQUEST['building_name']."',
		tower='" . $_REQUEST['tower']."',
		floor='" . $_REQUEST['floor']."',
		unit='" . $_REQUEST['unit']."',
		district_id='" . $_REQUEST['district_id']."',
	
		road_id='" . $_REQUEST['road_id']."',
	    alley_id='" . $_REQUEST['alley_id']."',
		house='" . $_REQUEST['house']."',
		delivery='" . $_REQUEST['delivery']."',
	    remarks='" . $_REQUEST['remarks']."'
		where address_id='".$_REQUEST['address_id']."'	";
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
	   
	}
   pageRedirect("registration.address.list.php?registration_id=$registration_id");
 }	
#if product exists /fetch data
if($_REQUEST['address_id'])
{
	$address_id=$_REQUEST['address_id'];
	$r=mysql_query("select * from ".TABLE_REGISTRATION_ADDRESS." where address_id=" . $address_id);
	$d=@mysql_fetch_array($r);
	
}

if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" . $msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="prod_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
<input type="hidden" name="registration_id" value="<?=$registration_id?>">
<input type="hidden" name="address_id" value="<?=$address_id?>">
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='registration.address.list.php?registration_id=<?=$registration_id?>' class="header" target="_parent">
	<u>Registration Address Management</u></a> > <br /> Add/Modify Registration Address : <?=$d['address_type']?> </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	
	
	
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Address Type  :</b></td><td width="67%" ><input name="address_type" type="text" id="address_type" class="lnk" value="<?=$d['address_type']?>" size="40" ></td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Phone :</b></td><td width="67%" ><input name="phone" type="text" id="phone" class="lnk" value="<?=$d['phone']?>" size="40" ></td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Company Name:</b></td><td width="67%" ><input name="company_name" type="text" id="company_name" class="lnk" value="<?=$d['company_name']?>" size="40" ></td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Building Name:</b></td><td width="67%" ><input name="building_name" type="text" id="building_name" class="lnk" value="<?=$d['building_name']?>" size="40" ></td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Tower:</b></td><td width="67%" ><input name="tower" type="text" id="tower" class="lnk" value="<?=$d['tower']?>" size="40" ></td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Floor:</b></td><td width="67%" ><input name="floor" type="text" id="floor" class="lnk" value="<?=$d['floor']?>" size="40" ></td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Unit:</b></td><td width="67%" ><input name="unit" type="text" id="unit" class="lnk" value="<?=$d['unit']?>" size="40" ></td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>District ID:</b></td><td width="67%" >
	
	<select name="district_id" id="district_1">
										<option value=""></option>
										<?
											$sql="select * from ".TABLE_DISTRICT." where district_status ='Y'";
											$res=mysql_query($sql);
											while($row=mysql_fetch_array($res))
											{
										?>
										<option value="<?=$row['district_id']?>" <? if($d['district_id']==$row['district_id']){?>selected="selected" <? }?> ><?=$row['district_name']?></option>
										<?
											}
										?>
								</select>
</td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b> Road ID:</b></td><td width="67%" >
	<select name="road_id" id="road_1"  >
										<option value=""></option>
										<?
											$sql="select * from ".TABLE_ROAD." where district_id='".$d['district_id']."' and  road_status ='Y'";
											$res=mysql_query($sql);
											while($row=mysql_fetch_array($res))
											{
										?>
										<option value="<?=$row['road_id']?>" <? if($d['road_id']==$row['road_id']){?>selected="selected" <? }?> ><?=$row['road_name']?></option>
										<?
											}
										?>
								</select>
	</td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b> Alley ID:</b></td><td width="67%" >
	<select name="alley_id" id="subsoi_1">
										<option value=""></option>
										<?
											$sql="select * from ".TABLE_ALLEY." where road_id='".$d['road_id']."' and  alley_status ='Y'";
											$res=mysql_query($sql);
											while($row=mysql_fetch_array($res))
											{
										?>
										<option value="<?=$row['alley_id']?>" <? if($d['alley_id']==$row['alley_id']){?>selected="selected" <? }?> ><?=$row['alley_name']?></option>
										<?
											}
										?>
								</select>
	
</td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b> House/Building:</b></td><td width="67%" ><input name="house" type="text" id="house" class="lnk" value="<?=$d['house']?>" size="40" ></td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b> Delivery Directions:</b></td><td width="67%" ><input name="delivery" type="text" id="delivery" class="lnk" value="<?=$d['delivery']?>" size="40" ></td></tr>
		
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Remarks:</b></td><td width="67%" ><input name="remarks" type="text" id="remarks" class="lnk" value="<?=$d['remarks']?>" size="40" ></td></tr>
	
<input type="hidden" name="address_id" value="<? echo $_REQUEST[address_id];?>" />
	<tr bgcolor=<?=$light?> ><td></td>
	<td >
	<input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
</table>
</form>
<?
include("includes/footer.php");
?>
