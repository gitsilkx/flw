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
				if(document.getElementById('product_menu_name').value=='')
				{
					txt+="  menu name should not be empty.\n"
				}
				if(document.getElementById('product_menu_option').value=='')
				{
					txt+="  menu option should  be selected.\n"
				}
								
				if(txt)
				{
					alert("Sorry!! you left some mandatory fields :\n\n"+ txt +"\n     Please Check");
					return false;
				}
				return true;	
			}
			
			//-->
		</script>
<?php
$msg="";
if($_REQUEST[Update])
{
	if(!$_REQUEST['product_menu_id'])
	{
		$product_menu_code=randPass('8',"ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890");
				
	    $insert_query = "insert into " .TABLE_PRODUCT_MENU." set 
		product_menu_name='" . $_REQUEST['product_menu_name'] .  "',
		product_menu_no_pizza='".$_REQUEST['product_menu_no_pizza']."',
		product_menu_no_free_pizza='".$_REQUEST['product_menu_no_free_pizza']."',
		product_menu_option='".$_REQUEST['product_menu_option']."',
		product_menu_status='".$_REQUEST['product_menu_status']."',
		product_menu_code='".$product_menu_code."',
		product_menu_color='".$_REQUEST['product_menu_color']."'";
				
		$r=mysql_query($insert_query);
	}
   	else
	{
   		$upd_query = "update " .TABLE_PRODUCT_MENU." set 
		product_menu_name='" . $_REQUEST['product_menu_name'] .  "',
		product_menu_no_pizza='".$_REQUEST['product_menu_no_pizza']."',
		product_menu_no_free_pizza='".$_REQUEST['product_menu_no_free_pizza']."',
		product_menu_option='".$_REQUEST['product_menu_option']."',
		product_menu_status='".$_REQUEST['product_menu_status']."',
		product_menu_color='".$_REQUEST['product_menu_color']."'
		where product_menu_id='".$_REQUEST['product_menu_id']."'";
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
	   
	}
   pageRedirect('menu.list.php');
 }	

if($_REQUEST['product_menu_id'])
{
	$product_menu_id=$_REQUEST['product_menu_id'];
	$r=mysql_query("select * from ".TABLE_PRODUCT_MENU." where product_menu_id=" . $product_menu_id);
	$d=@mysql_fetch_array($r);
	
}

if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
	<form method="post" name="prod_entry" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onSubmit="return ValidProd()">
	<input type="hidden" name="product_menu_id" value="<?=$product_menu_id?>">

	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='menu.list.php' class="header" target="_parent">
	<u>Menu Management</u></a> > <br /> Add/Modify Menu : </td>
	
	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Name <a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="product_menu_name" type="text" id="product_menu_name" class="lnk" value="<?=$d['product_menu_name']?>" size="40" ></td></tr>



	
	
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Price Type <a class='lnkred'>*</a> :</b></td><td width="67%" >
	<?
		$product_menu_option=array("Pizza"=>"Pizza","Normal"=>"Normal");
	?>
	<select name="product_menu_option" id="product_menu_option" style="width:200px;">
		<option value=""></option>
		<?
		foreach($product_menu_option as $key=>$value)
		{
			?>
			<option value="<?=$key?>" <? if($d['product_menu_option']==$key){?> selected="selected" <? }?>><?=$value?></option>
			<?
		}
		?>
	</select>
	
	</td></tr>
	
	    <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Menu Color  :</b></td><td width="67%" >
	<input name="product_menu_color" type="text" id="product_menu_color" class="lnk" value="<?=$d['product_menu_color']?>" size="40" >
	</td></tr>
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>No. Pizza  :</b></td><td width="67%" >
	<input name="product_menu_no_pizza" type="text" id="product_menu_no_pizza" class="lnk" value="<?=$d['product_menu_no_pizza']?>" size="40" >
	</td></tr>
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Free Pizza  :</b></td><td width="67%" >
	<input name="product_menu_no_free_pizza" type="text" id="product_menu_no_free_pizza" class="lnk" value="<?=$d['product_menu_no_free_pizza']?>" size="40" >
	</td></tr>
	
	  
	<tr bgcolor="#ffffff" class="lnk"> <td bgcolor="#e9e9e9"><b>Status :</b></td><td align="left"><input type="radio" name="product_menu_status"  checked="checked" value="Y" <? if($d["product_menu_status"]=="Y"){ echo" checked";}?> >Active <input type="radio" name="product_menu_status" value="N" <? if($d["product_menu_status"]=="N"){echo" checked";}?>> In Active</td></tr>
	
	
	
	
	
	
	<tr bgcolor=<?=$light?> ><td></td>
	<td >
	<input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
</table>
</form>
<?
include("includes/footer.php");
?>
