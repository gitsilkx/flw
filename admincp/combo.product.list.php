<?php
include("includes/access.php");
include("includes/header.php");
$combo_id=$_REQUEST['combo_id'];

if($_REQUEST['add']=='add')
{
 	$releted=$_REQUEST['releted'];

	mysql_query("delete from ".TABLE_COMBO_PRODUCT." where combo_id=".$_REQUEST['combo_id']);
	for($i=0;$i<count($releted);$i++)
	{
		mysql_query("insert into ".TABLE_COMBO_PRODUCT." set combo_id='".$_REQUEST['combo_id']."',product_id='".$releted[$i]."'");
	}	
	pageRedirect("combo.list.php");
	exit();
}
$ar=array();
$r_p=mysql_query("select * from ".TABLE_COMBO_PRODUCT." where combo_id=" . $combo_id);
while($d_p=@mysql_fetch_array($r_p))
{
	$ar[]=$d_p['product_id'];
}


?>
<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" name="add" id="add" value="add" />
<input type="hidden" name="combo_id" id="combo_id" value="<?=$_REQUEST['combo_id']?>" />
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
		<td class="header"><a href="combo.list.php" class="header">Combo</a> &raquo; Product List 
	    </td><td width="40%" align="right">&nbsp;
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
		$rr=mysql_query("select * from ".TABLE_PRODUCT." where product_type_id not in (select product_type_id from ".TABLE_PRODUCT_TYPE." where product_type_option='Pizza')");
		
		
		
		while($d=@mysql_fetch_array($rr)):
		
		
			
    		if(!($j%2)){$class="even";}else{$class="odd";}
			
			?>
			<tr  bgcolor='#ffffff' class="<?=$class?>">
			
				<td width="10%" align="center"><input type="checkbox" name="releted[]" id="releted[]"   <? if(in_array($d['product_id'],$ar)){?>  checked="checked" <? }?> value="<?=$d['product_id']?>"></td>
				<?
					$res_type=mysql_query("select * from ".TABLE_PRODUCT_TYPE." where product_type_id='".$d['product_type_id']."' ");
			$row_type=mysql_fetch_array($res_type);
		
				?>
				<td width="30%" align="left"><?=$row_type['product_type_name']?></td>
				
				<td  width="60%"><?=$d['product_name']?></td>
			</tr>
			<?
		
		endwhile;   
		?>
		<tr bgcolor='#ffffff' class="<?=$class?>"><td colspan="3" align="right"><input type="submit" name="save_product" id="save_product" value="SAVE" /></td></tr>
	</tbody>
</table>

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