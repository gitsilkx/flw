<?php
include("includes/access.php");
include("includes/header.php");
$product_menu_id=$_REQUEST['product_menu_id'];
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
				if(document.getElementById('product_type_id').value=='')
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
	if(!$_REQUEST['product_menu_type_id'])
	{
	    $insert_query = "insert into " .TABLE_PRODUCT_MENU_TYPE." set 
		product_menu_id='" . $_REQUEST['product_menu_id'] .  "',
		product_type_id='" . $_REQUEST['product_type_id'] .  "'";
		
		$r=mysql_query($insert_query);
	}
   	
   pageRedirect("menu.related.list.php?product_menu_id=$product_menu_id");
 }	
#if product exists /fetch data
if($_REQUEST['product_menu_type_id'])
{
	$product_menu_type_id=$_REQUEST['product_menu_type_id'];
	$r=mysql_query("select * from ".TABLE_PRODUCT_MENU_TYPE." where product_menu_type_id=" . $product_menu_type_id);
	$d=@mysql_fetch_array($r);
	
}

$r_p=mysql_query("select * from ".TABLE_PRODUCT_MENU." where product_menu_id=" . $product_menu_id);
$d_p=@mysql_fetch_array($r_p);



if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="prod_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
	<input type="hidden" name="product_menu_type_id" value="<?=$product_menu_type_id?>">
	<input type="hidden" name="product_menu_id" value="<?=$product_menu_id?>">

	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='menu.related.list.php?product_menu_id=<?=$product_menu_id?>&product_menu_type_id=<?=$product_menu_type_id?>' class="header" target="_parent">
	<u>Menu Included Management</u></a> > <br /> Add/Modify Menu Included : </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Menu Name  :</b></td><td width="67%" >
	<?=$d_p['product_menu_name']?></td></tr>
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b> Product Type Related  :</b></td><td width="67%" >
	
	  
											<select name="product_type_id" id="product_type_id" style="width:200px;">
											<option value=""></option>
												<?
												$r_r=mysql_query("select * from ".TABLE_PRODUCT_TYPE." where 1 ");
												
													while($d_r=@mysql_fetch_array($r_r))
													{
													
												?>
												<option value="<?=$d_r['product_type_id']?>" <? if($d_r['product_type_id']==$key){ ?>selected="selected"<? }?>  ><?=$d_r['product_type_name']?></option>
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
