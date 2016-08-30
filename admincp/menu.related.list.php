<?php
include("includes/access.php");
include("includes/header.php");

$product_menu_id=($_REQUEST['product_menu_id']=='')?0:$_REQUEST['product_menu_id'];
if($_REQUEST['add']=='add')
{
 	$releted=$_REQUEST['releted'];

	mysql_query("delete from ".TABLE_PRODUCT_MENU_TYPE." where product_menu_id=".$_REQUEST['product_menu_id']);
	for($i=0;$i<count($releted);$i++)
	{
		mysql_query("insert into ".TABLE_PRODUCT_MENU_TYPE." set product_menu_id='".$_REQUEST['product_menu_id']."',product_type_id='".$releted[$i]."'");
	}	
	pageRedirect("menu.list.php");
	exit();
}
$ar=array();
$r_p=mysql_query("select * from ".TABLE_PRODUCT_MENU_TYPE." where product_menu_id=" . $product_menu_id);
while($d_p=@mysql_fetch_array($r_p))
{
	$ar[]=$d_p['product_type_id'];
}


?>
<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" name="add" id="add" value="add" />
<input type="hidden" name="product_menu_id" id="product_menu_id" value="<?=$_REQUEST['product_menu_id']?>" />
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
		<td class="header">
		<a href="menu.list.php" class="header">Menu List</a>
		&nbsp;&raquo;&nbsp;
		
		<a href="menu.related.list.php?product_menu_id=<?=$product_menu_id?>" class="header">Menu Included  List</a>	</td><td width="40%" align="right">
					</td>
	</tr>
</table>
<table id="table-1" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
	<thead>
	
		<tr>
		<td height="10"><b>Select</b></td>
		<td  width="30%" height="25" align="left"><b>Type</b></td>
		<td width="60%" align="left"><b>Related Type</b><b>Action</b></td>
		</tr>
	</thead>
	<tbody>
	
	<?
		$rr=mysql_query("select * from ".TABLE_PRODUCT_TYPE." ");
		
		
		
		while($d=@mysql_fetch_array($rr)):
		
		
			
    		if(!($j%2)){$class="even";}else{$class="odd";}
			
			?>
			<tr  bgcolor='#ffffff' class="<?=$class?>">
			
				<td width="10%" align="center"><input type="checkbox" name="releted[]" id="releted[]"   <? if(in_array($d['product_type_id'],$ar)){?>  checked="checked" <? }?> value="<?=$d['product_type_id']?>"></td>
				
				<td width="30%" align="left"><?=$d['product_type_option']?></td>
				
				<td  width="60%"><?=$d['product_type_name']?></td>
			</tr>
			<?
		
		endwhile;   
		?>
		<tr bgcolor='#ffffff' class="<?=$class?>"><td colspan="3" align="right"><input type="submit" name="save_product" id="save_product" value="SAVE" /></td></tr>
	</tbody>
</table>
<?
if($_REQUEST[cat_id]):
	$param="&cat_id=" . $_REQUEST[cat_id];
elseif($_REQUEST[cat_id]):
	$param="&cat_id=" . $_REQUEST[cat_id];
else:
	$param="";
endif;
?>

</form>
<script cat_id="text/javascript">
//<![CDATA[
function addClassName(el, sClassName) {
	var s = el.className;
	var p = s.split(" ");
	var l = p.length;
	for (var i = 0; i < l; i++) {
		if (p[i] == sClassName)
			return;
	}
	p[p.length] = sClassName;
	el.className = p.join(" ");

}

function removeClassName(el, sClassName) {
	var s = el.className;
	var p = s.split(" ");
	var np = [];
	var l = p.length;
	var j = 0;
	for (var i = 0; i < l; i++) {
		if (p[i] != sClassName)
			np[j++] = p[i];
	}
	el.className = np.join(" ");
}
var st = new SortableTable(document.getElementById("table-1"),
	["Number","None","String","String","Number","date","date","String","None"]);
	// restore the class names
st.onsort = function () {
	var rows = st.tBody.rows;
	var l = rows.length;
	for (var i = 0; i < l; i++) {
		removeClassName(rows[i], i % 2 ? "odd" : "even");
		addClassName(rows[i], i % 2 ? "even" : "odd");
	}
};
//]]>
</script>
<?
include("includes/footer.php");
?>