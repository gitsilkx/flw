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
				if(document.getElementById('product_type_name').value=='')
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
	if(!$_REQUEST['product_type_id'])
	{
	    $insert_query = "insert into " .TABLE_PRODUCT_TYPE." set 
		product_type_name='" . $_REQUEST['product_type_name'] .  "',
		product_type_option='" . $_REQUEST['product_type_option'] .  "',
		product_type_status='" . $_REQUEST['product_type_status'] .  "'";
		$r=mysql_query($insert_query);
	}
   	else
	{
   		$upd_query = "update " .TABLE_PRODUCT_TYPE." set
		product_type_name='" . $_REQUEST['product_type_name'] .  "',
		product_type_option='" . $_REQUEST['product_type_option'] .  "',
		product_type_status='" . $_REQUEST['product_type_status'] .  "'
		where product_type_id='".$_REQUEST['product_type_id']."'	";
		
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
	   
	}
   pageRedirect("product.type.list.php");
 }	
if($_REQUEST['product_type_id'])
{
	$product_type_id=$_REQUEST['product_type_id'];
	$r=mysql_query("select * from ".TABLE_PRODUCT_TYPE." where product_type_id=" . $product_type_id);
	$d=@mysql_fetch_array($r);
	
}

if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="prod_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
	<input type="hidden" name="product_type_id" value="<?=$product_type_id?>">
	
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='product.type.list.php?pid=<?=$pid?>' class="header" target="_parent">
	<u>Product Catgory Management</u></a> >   Add/Modify Product Category : <?=$d['district_name']?> </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	<tr class="lnk" bgcolor="#ffffff"><td width="23%" bgcolor="#e9e9e9"><b>Product Type Name <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="product_type_name" type="text" id="product_type_name" class="lnk" value="<?=$d['product_type_name']?>" size="40" ></td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="23%" bgcolor="#e9e9e9"><b> Type  :</b></td><td width="67%" >
	
	  
											<select name="product_type_option" id="product_type_option" style="width:200px;">
												<?
												$mon=array("Normal"=>"Normal","Pizza"=>"Pizza");
												
													foreach($mon as $key=>$value)
													{
													
												?>
												<option value="<?=$key?>" <? if($d['product_type_option']==$key){ ?>selected="selected"<? }?>  ><?=$value?></option>
												<?
													}
												?>
											</select>
	
	</td></tr>
	
	
	      
	<tr bgcolor="#ffffff" class="lnk"> <td bgcolor="#e9e9e9"><b>Product Type Status :</b></td><td align="left"><input type="radio" name="product_type_status"  checked="checked" value="Y" <? if($d["product_type_status"]=="Y"){ echo" checked";}?> >Active <input type="radio" name="product_type_status" value="N" <? if($d["product_type_status"]=="N"){echo" checked";}?>> In Active</td></tr>
	
	<tr bgcolor=<?=$light?> ><td></td>
	<td >
	<input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
</table>
</form>
<?
include("includes/footer.php");
?>
