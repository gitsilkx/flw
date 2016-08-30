<?php
include("includes/access.php");
include("includes/header.php");
$pid=($_REQUEST['pid']=='')?0:$_REQUEST['pid'];
if($_REQUEST[del]):
   mysql_query("delete from " . $prev . "products where id=" . $_REQUEST[id]);
endif;
?>

<?php
$msg="";
if($_REQUEST[Update])
{
	if(!$_REQUEST[id])
	{
	    $insert_query = "insert into products set
		name=\"" . $_REQUEST[name] .  "\",
		product_no=\"" . $_REQUEST[product_no] .  "\",
                page_id=\"" . $_REQUEST[page_id] .  "\",    
		supplier_id=\"" . $_REQUEST[supplier_id] .  "\",		
		description=\"".$_REQUEST[description]."\",
                category=\"" . $_REQUEST[category] .  "\",
		price=\"" .$_REQUEST[price] . "\",
                status=\"" . $_REQUEST[status] . "\",
                ord=\"" . $_REQUEST[ord] . "\",    
		created=\"" . date("Y-m-d") . "\"";
		
		$r=mysql_query($insert_query);

	   	$id=mysql_insert_id();
		$_REQUEST[id]=$id;
                //pageRedirect("product.list.php?pid=$pid");
	}
   	else
	{
	//print_r($_REQUEST);die();
   		$upd_query = "update products set
		name=\"" . $_REQUEST[name] .  "\",
		product_no=\"" . $_REQUEST[product_no] .  "\",
                page_id=\"" . $_REQUEST[page_id] .  "\",     
		supplier_id=\"" . $_REQUEST[supplier_id] .  "\",		
		description=\"".$_REQUEST[description]."\",
                category=\"" . $_REQUEST[category] .  "\",
		price=\"" .$_REQUEST[price] . "\",
                ord=\"" . $_REQUEST[ord] . "\",
		status=\"" . $_REQUEST[status] . "\"
		where id=" . $_REQUEST[id];
        //echo $upd_query;
	   
		$r=mysql_query($upd_query) or die("Error :". mysql_error());		
                $id=$_REQUEST[id];
                //pageRedirect("product.list.php?pid=$pid");
	}
        pageRedirect("product.list.php?menuid=119&menupid=117");
} 


#if product exists /fetch data
if($_REQUEST[id])
{
	$id=$_REQUEST[id];
	$r=mysql_query("select * from products where id=" . $id);
	$d=@mysql_fetch_array($r);
}
/*$today=date("Y-m-d H:i:s");
$t=mysql_query("select DATE_ADD('$today',INTERVAL " . $setting[num_days] . " DAY) as finishdate");
$finishdate=@mysql_result($t,0,"finishdate");  */
if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>";
endif;
?>
	<form method="post" name="prod_entry" action="" enctype="multipart/form-data" onSubmit="javscript:return ValidProd(this);">
	<input type="hidden" name="id" value="<?=$id?>">

	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
	<tr bgcolor=<?=$light?>><td height="32"  class="header"  style='border-bottom:solid 1px #333333'><a href='product.list.php' class="header" target="_parent">
	<u>Product Management</u></a> > <br /> Add/Modify Product : <?=$d[name]?> </td>

	</tr>
  </table>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?=$light?>">
	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Product Tilte<a class='lnkred'>*</a> :</b></td><td width="67%" ><input name="name" type="text" class="lnk" value="<?=$d[name]?>" size="40" ></td></tr>
	<tr class="lnk" bgcolor="#ffffff">
	  <td bgcolor="#e9e9e9"><b>Product Code. <a class='lnkred'>*</a> :</b></td>
	  <td><input type="text" name="product_no"  class="lnk" value="<?=$d[product_no];?>">	</td>
	  </tr>
          <tr class="lnk" bgcolor="#ffffff">
		<td bgcolor="#e9e9e9"><b>Page Name <a class='lnkred'>*</a> :</b></td>
		<td>
		<select name="page_id" size="1" class="lnk" style=" width:250px;">
		<option value="">Select Page</option>
		<?
		$page=mysql_query("select * from " . $prev . "contents where  1   order by id");
		while($pages=mysql_fetch_array($page)):

			   if( $pages['id']==$d['page_id']):
   				  echo"<option value='" .  $pages['id'] . "' selected>" . $pages['cont_title'] . "</option>\n";
			   else:
				  echo"<option value='" .  $pages['id'] . "' >" . $pages['cont_title'] . "</option>\n";
			   endif;

		endwhile;
		?>
		</select>		</td>
	</tr>
              <?php ?>		<tr class="lnk" bgcolor="#ffffff">
		<td bgcolor="#e9e9e9"><b>Supplier Name <a class='lnkred'>*</a> :</b></td>
		<td>
		<select name="supplier_id" size="1" class="lnk" style=" width:250px;">
		<option value="">Select Supplier</option>
		<?
		$r1=mysql_query("select * from " . TABLE_SUPPLIERS . " where  1   order by supplier_id");
		while($rows1=mysql_fetch_array($r1)):

			   if( $rows1['supplier_id']==$d['supplier_id']):
   				  echo"<option value='" .  $rows1['supplier_id'] . "' selected>" . $rows1['supplier_name'] . "</option>\n";
			   else:
				  echo"<option value='" .  $rows1['supplier_id'] . "' >" . $rows1['supplier_name'] . "</option>\n";
			   endif;

		endwhile;
		?>
		</select>		</td>
	</tr><?php ?>

	<tr class="lnk" bgcolor="#ffffff">
		<td bgcolor="#e9e9e9"><b>Category<a class='lnkred'>*</a> :</b></td>
		<td>
                    <select name="category" size="1" class="lnk" style=" width:250px;">
				<option value="0">Select Category</option>
				<?
				$rrr=mysql_query("select * from " . $prev . "categories where parent_id='0' order by cat_name");
				while($rows=mysql_fetch_array($rrr)):
				   if($rows[cat_code]==$d[category]):
				   		echo"<option value='" .$rows[cat_code] . "' selected>" . strtoupper($rows[cat_name]) . "</option>";
				   else:
				   		echo"<option value='" .$rows[cat_code] . "'>" . strtoupper($rows[cat_name]) . "</option>";
				   endif;
				   $rr=mysql_query("select * from " . $prev . "categories where parent_id=" . $rows[cat_id] . " order by cat_name");
				   while($row=mysql_fetch_array($rr)):
				      if($row[cat_code]=$d[category]):
				          echo "<option value='" . $row[cat_code] . "' selected>|__" . trim($row[cat_name]) . "</option>";
				      else:
				         echo "<option value='" . $row[cat_code] . "'>|__" . trim($row[cat_name]) . "</option>";
				      endif;
                                      $r=mysql_query("select * from " . $prev . "categories where parent_id=" . $row[cat_id] . " order by cat_name");
                                      while($ro=mysql_fetch_array($r)):
				      if($ro[cat_code]==$d[category]):
				          echo "<option value='" . $ro[cat_code] . "' selected>  |_____" . trim($ro[cat_name]) . "</option>";
				      else:
				         echo "<option value='" . $ro[cat_code] . "'>  |_____" . trim($ro[cat_name]) . "</option>";
				      endif;
				   endwhile;
				   endwhile;
				endwhile;
				?>
			</select>
		
                </td></tr>


	<tr class="lnk" bgcolor="#ffffff">
	  <td bgcolor="#e9e9e9"><strong>Product Price (Rs.)<a class='lnkred'>*</a> :</strong> </td>
	  <td><input type="text" name="price" value="<?=$d[price];?>" class="lnk" size="15">
	  [eg: 2.00] </td>
	</tr>

	<tr class="lnk" bgcolor="#e9e9e9" ><td valign=top colspan=2><b>Description</b></td></tr>
	<tr  bgcolor="#ffffff" class=lnk><td colspan=2> 
	<?php
	// Make sure you are using correct paths here.
	include_once '../ckeditor/ckeditor.php';
	include_once '../ckfinder/ckfinder.php';
	 
	$ckeditor = new CKEditor();
	$ckeditor->basePath = '../ckeditor/';
	$ckfinder = new CKFinder();
	$ckfinder->BasePath = '../ckfinder/'; // Note: the BasePath property in the CKFinder class starts with a capital letter.
	$ckfinder->SetupCKEditorObject($ckeditor);
	$ckeditor->editor('description',html_entity_decode($d[description]));
	?> 
	</td></tr>


	<tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Order  :</b></td><td width="67%" >
	 <input name="ord" type="text" id="product_code" class="lnk" value="<?=$d[ord]?>" style='width:300px' >
	 </td></tr>


	<tr bgcolor="#ffffff" class="lnk"><td bgcolor="#e9e9e9"><b>Status :</b></td><td align="left"><input type="radio" name="status"  checked="checked" value="Y" <?if($d["status"]=="Y"){echo" checked";}?> >Online <input type="radio" name="status" value="N" <?if($d["status"]=="N"){echo" checked";}?>> Offline</td></tr>


<tr bgcolor=<?=$light?>><td></td><td ><input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
</table>
</form>
<?
include("includes/footer.php");
?>
