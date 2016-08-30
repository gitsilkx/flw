<?php
include("includes/access.php");
include("includes/header.php");
if($_REQUEST['del']):
  mysql_query("delete from " .TABLE_COMBO." where combo_id=" . $_REQUEST['combo_id']);
  pageRedirect('combo.list.php');
  exit();
endif;
?>
<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
		<td class="header">Combo List 
	    <input type="button" class="button" onClick="javascritp:window.location.href='combo.entryform.php?combo_id=0&cat_id=<?=$cat_id?>'" value="Add New Combo">		</td><td width="40%" align="right">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr class="lnk">
					<td>
					<select name="parama" size="1" class="lnk">
						<option value="combo_id" <? if($_REQUEST['parama']=="combo_id"){echo" selected";}?>>ID</option>
						<option value="combo_name" <? if($_REQUEST['parama']=="combo_name"){echo" selected";}?>>Name</option>
						<option value="combo_code" <? if($_REQUEST['parama']=="combo_code"){echo" selected";}?>>Code</option>
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
		<td width="20%" height="25"><b>ID</b></td>
		<td  width="20%" height="25"><b>Name</b></td>
		<td width="20" align="center"><b>Code</b></td>
		<td  width="20%" align="center"><b>Status</b></td>
		<td  width="20%" align="center"><b>Action</b></td>
		</tr>
	</thead>
	<tbody>
		<?
		if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
		
		if($_REQUEST[SBMT_SEARCH] && $_REQUEST[parama] && $_REQUEST[search]):
   			$cond=" and ".$_REQUEST[parama] . " ='" . $_REQUEST[search] . "'";
		endif;
		
		$r=mysql_query("select count(*) as total from " .TABLE_COMBO." where 1 " . $cond);
		$total=@mysql_result($r,0,"total");
		
		
		$r=mysql_query("select * from ".TABLE_COMBO." where 1 ". $cond ." order by combo_id desc limit " . ($_REQUEST['limit']-1)*10 . ",10");
	
		if(!$total):
   			?>
				<tr class='lnkred'><td colspan='6' align='center'>No record found.</td></tr>
			<?
		endif;
		$j=0;
		while($d=@mysql_fetch_array($r)):
			
    		if(!($j%2)){$class="even";}else{$class="odd";}
			if($d['combo_status']=="Y"){$combo_status="Active";}else{$combo_status="<span class='lnkred'>In Active</span>";}
			
			
			?>
			<tr  bgcolor='#ffffff' class="<?=$class?>">
				<td width="20%">
				<a href='combo.entryform.php?combo_id=<?=$d['combo_id']?>' class='lnk'><?=$d['combo_id']?></a>				</td>
				<td width="20%"><?=$d['combo_name']?></td>
				<td width="20%"><?=$d['combo_code']?></td>
				<td width="20%"><?=$combo_status?></td>
				<td width="20%" ><a href='combo.entryform.php?combo_id=<?=$d['combo_id']?>' class='lnk'><u>Edit</u></a> |
				<a href='combo.product.list.php?combo_id=<?=$d['combo_id']?>' class='lnk'><u>Add Product</u></a> |
<a href="<?=$_SERVER['PHP_SELF']?>?combo_id=<?=$d['combo_id']?>&del=1" class='lnk'  onclick="return confirm('Are you sure you want to delete?')"><u>Delete</u></a></td>
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