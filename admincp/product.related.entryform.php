<?php
include("includes/access.php");
include("includes/header.php");
$product_id=$_REQUEST['product_id'];
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
				if(document.getElementById('pro_id').value=='')
				{
					txt+="     product type should not be empty.\n"
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
	if(!$_REQUEST['product_included_id'])
	{
	    $insert_query = "insert into " .TABLE_PRODUCT_INCLUDED." set 
		product_id='" . $_REQUEST['product_id'] .  "',
		pro_id='" . $_REQUEST['pro_id'] .  "'";
		
		$r=mysql_query($insert_query);
	}
   
   pageRedirect("product.related.list.php?product_id=$product_id");
 }	
#if product exists /fetch data
if($_REQUEST['product_included_id'])
{
	$product_included_id=$_REQUEST['product_included_id'];
	$r=mysql_query("select * from ".TABLE_PRODUCT_TYPE_RELATED." where product_included_id=" . $product_included_id);
	$d=@mysql_fetch_array($r);
	
}

$r_p=mysql_query("select * from ".TABLE_PRODUCT." where product_id=" . $product_id);
$d_p=@mysql_fetch_array($r_p);



if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="prod_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
	<input type="hidden" name="product_included_id" value="<?=$product_included_id?>">
	<input type="hidden" name="product_id" value="<?=$product_id?>">

	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='product.related.list.php?product_id=<?=$product_id?>&product_included_id=<?=$product_included_id?>' class="header" target="_parent">
	<u>Product Included Management</u></a> > <br /> Add/Modify Product Included : </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Product Type Name  :</b></td><td width="67%" >
	<?=$d_p['product_name']?></td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b> Product Type Related  :</b></td><td width="67%" >
	
	  
											<select name="pro_id" id="pro_id" style="width:200px;">
											<option value=""></option>
												<?
												$r_r=mysql_query("select * from ".TABLE_PRODUCT." where 1 ");
												
													while($d_r=@mysql_fetch_array($r_r))
													{
													
												?>
												<option value="<?=$d_r['product_id']?>" <? if($d_r['product_id']==$key){ ?>selected="selected"<? }?>  ><?=$d_r['product_name']?></option>
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
