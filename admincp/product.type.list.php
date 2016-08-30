<?php
include("includes/access.php");
include("includes/header.php");

$pid=($_REQUEST['pid']=='')?0:$_REQUEST['pid'];

if($_REQUEST['del']):
  mysql_query("delete from " .TABLE_PRODUCT_TYPE." where product_type_id=" . $_REQUEST['product_type_id']);
  pageRedirect("product.type.list.php");
  exit();
endif;
?>
<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
		<td class="header"><a href="product.type.list.php" class="header">Product Category</a>
	    <input type="button" class="button" onClick="javascritp:window.location.href='product.type.entryform.php?pid=<?=$pid?>'" value="Add New Product Category">		</td><td width="40%" align="right">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr class="lnk">
					<td>
					<select name="parama" size="1" class="lnk">
						<option value="product_type_id" <? if($_REQUEST['parama']=="product_type_id"){echo" selected";}?>>ID</option>
						<option value="product_type_name" <? if($_REQUEST['parama']=="product_type_name"){echo" selected";}?>>Name</option>
					  </select>					</td>
					<td> == <input type="text" size="8" name="search"  value="<?=$_REQUEST[search]?>" class="lnk"> &nbsp;</td>
					<td><input type="submit" class="button" name="SBMT_SEARCH"  value="  Search  "></td>
				</tr>
			</table>		</td>
	</tr>
</table>
<table id="table-1" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
	<thead>
	
		<tr>
		<td width="20" height="25"><b>ID</b></td>
		<td  width=30% height="25"><b>Name</b></td>
		<td ><b>Option</b></td>		<td align=center><b>Toatal Products</b></td>
		<td ><b>Status</b></td>
		<td  width="20%" align="center"><b>Action</b></td>
		</tr>
	</thead>
	<tbody>
		<?
		if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
		
		if($_REQUEST[SBMT_SEARCH] && $_REQUEST[parama] && $_REQUEST[search]):
   			$cond=" and ".$_REQUEST[parama] . " ='" . $_REQUEST[search] . "'";
		endif;
		
		$r=mysql_query("select count(*) as total from " .TABLE_PRODUCT_TYPE." where 1  " . $cond);
		$total=@mysql_result($r,0,"total");
		
		
		$r=mysql_query("select * from ".TABLE_PRODUCT_TYPE." where 1  ". $cond ." order by product_type_id desc limit " . ($_REQUEST['limit']-1)*20 . ",20");
	
		if(!$total):
   			?>
				<tr class='lnkred'><td colspan='4' align='center'>No record found.</td></tr>
			<?
		endif;
		$j=0;
		while($d=@mysql_fetch_array($r)):
			$total=@mysql_num_rows(mysql_query("select * from ".TABLE_PRODUCT." where  product_type_id = ". $d['product_type_id']));
	
    		if(!($j%2)){$class="even";}else{$class="odd";}
			if($d['product_type_status']=="Y"){$status="Active";}else{$status="<span class='lnkred'>In Active</span>";}
			?>
			
			<tr  bgcolor='#ffffff' class="<?=$class?>">
				<td>
				<a href='product.type.entryform.php?product_type_id=<?=$d['product_type_id']?>&pid=<?=$pid?>' class='lnk'><?=$d['product_type_id']?></a>
				</td>
				<td ><?=$d['product_type_name']?></td>
				<td ><?=$d['product_type_option']?></td>
				<td align=center ><?=$total?></td>
				<td ><?=$status?></td>
				<td width="40%" align=center><a href='product.type.entryform.php?product_type_id=<?=$d['product_type_id']?>&pid=<?=$pid?>' class='lnk'><u>Edit</u></a> | <a href='set_attribute.php?product_type_id=<?=$d['product_type_id']?>' class='lnk' onclick="return hs.htmlExpand(this, {objectType: 'iframe', width: 555, height: 470, 
				allowSizeReduction: false, wrapperClassName: 'draggable-header no-footer', 
				preserveContent: false,headingText: 'Set Attributes', objectLoadTime: 'after'})" class='lnk'><u>Set Attributes</u></a> | <a href='product.entryform.php?product_type_id=<?=$d['product_type_id']?>&pid=<?=$pid?>' class='lnk'><u>Add Product</u></a> | <a href='product.list.php?product_type_id=<?=$d['product_type_id']?>&pid=<?=$pid?>' class='lnk'><u>View Products</u></a> |
<a href="<?=$_SERVER['PHP_SELF']?>?product_type_id=<?=$d['product_type_id']?>&del=1&pid=<?=$pid?>" class='lnk'  onclick="return confirm('Are you sure you want to delete?')"><u>Delete</u></a></td>
			</tr>
			<?
    		
			
		
   			$j++;
		endwhile;   
		?>
	</tbody>
	<? if($total>20):?>
	<tr><td align="center" class="lnk" colspan=9 bgcolor=<?=$lightgray?> height=28><?=paging($total,20,"$param","lnk")?></td></tr>
<? endif;?>
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