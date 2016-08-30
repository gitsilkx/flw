<?php
include("includes/access.php");
include("includes/header.php");
if($_REQUEST['del']):
  mysql_query("delete from " .TABLE_PRODUCT_MENU." where product_menu_id=" . $_REQUEST['product_menu_id']);
  pageRedirect('menu.list.php');
  exit();
endif;
?>
<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
		<td class="header">Menu List 
	    <input type="button" class="button" onClick="javascritp:window.location.href='menu.entryform.php?product_menu_id=0'" value="Add New Menu">		</td><td width="40%" align="right">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr class="lnk">
					<td>
					<select name="parama" size="1" class="lnk">
						<option value="product_menu_id" <? if($_REQUEST['parama']=="product_menu_id"){echo" selected";}?>>ID</option>
						<option value="product_menu_name" <? if($_REQUEST['parama']=="product_menu_name"){echo" selected";}?>>Name</option>
						
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
		<td width="10" height="25"><b>ID</b></td>
		<td  height="25"><b>Name</b></td>
		<td width="16" ><b>Code</b></td>
		<td  width="16%" ><b>Type</b></td>
		<td  width="16%" ><b>Status</b></td>
		<td  width="16%" align="center"><b>Action</b></td>
		</tr>
	</thead>
	<tbody>
		<?
		if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
		
		if($_REQUEST[SBMT_SEARCH] && $_REQUEST[parama] && $_REQUEST[search]):
   			$cond=" and ".$_REQUEST[parama] . " ='" . $_REQUEST[search] . "'";
		endif;
		
		$r=mysql_query("select count(*) as total from " .TABLE_PRODUCT_MENU." where 1 " . $cond);
		$total=@mysql_result($r,0,"total");
		
		
		$r=mysql_query("select * from ".TABLE_PRODUCT_MENU." where 1 ". $cond ." order by product_menu_id desc limit " . ($_REQUEST['limit']-1)*10 . ",10");
	
		if(!$total):
   			?>
				<tr class='lnkred'><td colspan='6' align='center'>No record found.</td></tr>
			<?
		endif;
		$j=0;
		while($d=@mysql_fetch_array($r)):
			
    		if(!($j%2)){$class="even";}else{$class="odd";}
			if($d['product_menu_status']=="Y"){$product_menu_status="Active";}else{$product_menu_status="<span class='lnkred'>In Active</span>";}
			
			
			?>
			<tr  bgcolor='#ffffff' class="<?=$class?>">
				<td >
				<a href='menu.entryform.php?product_menu_id=<?=$d['product_menu_id']?>' class='lnk'><?=$d['product_menu_id']?></a>				</td>
				<td ><?=$d['product_menu_name']?></td>
				<td width="16%"><?=$d['product_menu_code']?></td>
				<td width="16%"><?=$d['product_menu_option']?></td>
				<td width="16%"><?=$product_menu_status?></td>
				<td width="16%" align=center><a href='menu.entryform.php?product_menu_id=<?=$d['product_menu_id']?>' class='lnk'><u>Edit</u></a> |
				<a href='menu.related.list.php?product_menu_id=<?=$d['product_menu_id']?>' class='lnk'><u>Included</u></a> |
<a href="<?=$_SERVER['PHP_SELF']?>?product_menu_id=<?=$d['product_menu_id']?>&del=1" class='lnk'  onclick="return confirm('Are you sure you want to delete?')"><u>Delete</u></a></td>
			</tr>
			<?
    		
			
		
   			$j++;
		endwhile;   
		?>
	</tbody>
	<? if($total>10):?>
	<tr><td align="center" class="lnk" colspan=8 bgcolor=<?=$lightgray?> height=28><?=paging($total,10,"$param","lnk")?></td></tr>
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