<?php
include("includes/access.php");
include("includes/header.php");
$combo_id=$_REQUEST['combo_id'];
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
				if(document.getElementById('product_id').value=='')
				{
					txt+="  product name should not be empty.\n"
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
	if(!$_REQUEST['product_combo_id'])
	{
		$insert_query = "insert into " .TABLE_COMBO_PRODUCT." set 
		combo_id='" . $_REQUEST['combo_id'] .  "',
		product_id='" . $_REQUEST['product_id'] .  "'";
		$r=mysql_query($insert_query);
	}
   	
   pageRedirect('combo.product.list.php?combo_id='.$_REQUEST['combo_id']);
 }	
#if product exists /fetch data
if($_REQUEST['product_combo_id'])
{
	$product_id=$_REQUEST['product_combo_id'];
	$r=mysql_query("select * from ".TABLE_COMBO_PRODUCT." where product_combo_id=" . $product_combo_id);
	$d=@mysql_fetch_array($r);
}

if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="prod_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
	<input type="hidden" name="product_combo_id" value="<?=$product_combo_id?>">
	<input type="hidden" name="combo_id" value="<?=$combo_id?>">

	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='combo.product.list.php?' class="header" target="_parent">
	<u>Combo Product Management</u></a> > <br /> Add/Modify Combo Product : <?=$d['product_name']?> </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Product <a class='lnkred'>*</a> :</b></td><td width="67%" >
	
	<select name="product_id" id="product_id" style="width:200px;">
		<option value=""></option>
		<?
		$sql="select * from " .TABLE_PRODUCT." ";
		$resD=mysql_query($sql);
		while($rowD=@mysql_fetch_array($resD))
		{
			?>
			<option value="<?=$rowD['product_id']?>" <? if($d['product_id']==$rowD['product_id']){?> selected="selected" <? }?>><?=$rowD['product_name']?></option>
			<?
		}
		?>
	</select>
	
	</td></tr>
	
	
	
	
	
	<tr bgcolor=<?=$light?> ><td></td>
	<td >
	<input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
</table>
</form>
<?
include("includes/footer.php");
?>
