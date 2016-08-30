<?php
include("includes/access.php");
include("includes/header_pop.php");

$product_id=($_REQUEST['product_id']=='')?0:$_REQUEST['product_id'];
if($_REQUEST['save_product'])
{
 	$releted=$_REQUEST['releted'];
    $default_set=$_REQUEST['default_set'];
	mysql_query("delete from ".TABLE_PRODUCT_INCLUDED." where product_id=".$_REQUEST['product_id']);
	for($i=0;$i<count($releted);$i++)
	{
		$default_id=0;
		if($default_set[$i]==$releted[$i]){$default_id=1;}
		mysql_query("insert into ".TABLE_PRODUCT_INCLUDED." set product_id='".$_REQUEST['product_id']."',pro_id='".$releted[$i]."',default_set='" .$default_id . "'");
	    echo"insert into ".TABLE_PRODUCT_INCLUDED." set product_id='".$_REQUEST['product_id']."',pro_id='".$releted[$i]."',default_set='" .$default_id . "'";
	}	
	echo"<p align=center>Update Successful.</p>";
}
$ar=array();$dr=array();
$r_p=mysql_query("select * from ".TABLE_PRODUCT_INCLUDED." where product_id=" . $product_id);
while($d_p=@mysql_fetch_array($r_p))
{
	$ar[]=$d_p['pro_id'];
	if($d_p['default_set']){$dr[]=$d_p['pro_id'];}
	
}



?>
<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" name="add" id="add" value="add" />
<input type="hidden" name="product_id" id="product_id" value="<?=$_REQUEST['product_id']?>" />

<table id="table-1" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
	<thead>
	
		<tr>
		<td height="10" colapsn=2><b>Select</b></td><td height="10"><b>Topping Name</b></td>
		<td  width="30%" height="25" align="center" ><strong>Default</strong> </td><td align=right><input type="submit" name="save_product" id="save_product" value="SAVE" /></b></td>
		
		</tr>
	</thead>
	<tbody>
		<?
		$rr=mysql_query("select * from ".TABLE_PRODUCT." where product_type_id=5 order by product_name");
		
		
		
		while($d=@mysql_fetch_array($rr)):
		
		
			
    		if(!($j%2)){$class="even";}else{$class="odd";}
			
			?>
			<tr  bgcolor='#ffffff' class="<?=$class?>">
			
				<td width="10%" align="center"><input type="checkbox" name="releted[]" id="releted[]"   <? if(in_array($d['product_id'],$ar)){?>  checked="checked" <? }?> value="<?=$d['product_id']?>"></td>
							
				
				<td  width="80%"><?=$d['product_name']?></td><td  colspan=2 ><input type=checkbox name=default_set[] value=<?=$d['product_id']?> <? if(in_array($d['product_id'],$dr)){?>  checked="checked" <? }?> /></td>
			</tr>
			<?
		    $j++;
		endwhile;   
		?>

	</tbody>
</table>


</form>
<p align=center><a href="javascript:;" onclick="closeAndReload()">Close and reload parent</a></p>
</body></html>
