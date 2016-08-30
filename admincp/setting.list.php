<?php
include("includes/access.php");
include("includes/header.php");
if($_REQUEST['del']):
  mysql_query("delete from " .TABLE_SETTINGS." where config_id=" . $_REQUEST['config_id']);
  pageRedirect('setting.list.php');
  exit();
endif;
?>
<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
		<td class="header">Settings List 
	    <input type="button" class="button" onClick="javascritp:window.location.href='setting.entryform.php?config_id=0&cat_id=<?=$cat_id?>'" value="Add New Settings">		</td><td width="40%" align="right">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr class="lnk">
					<td>
					<select name="parama" size="1" class="lnk">
						<option value="config_id" <? if($_REQUEST['parama']=="config_id"){echo" selected";}?>>ID</option>
						<option value="config_variable" <? if($_REQUEST['parama']=="config_variable"){echo" selected";}?>>Variable</option>
						<option value="config_value" <? if($_REQUEST['parama']=="config_value"){echo" selected";}?>>Value</option>
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
		<td width="6" height="25"><b>ID</b></td>
		<td   height="25"><b>Variable</b></td>
		<td width="16" ><b>Value</b></td>
		<td  ><b>Description</b></td>
		<td  width="16%" ><b>Key</b></td>
		<td  width="16%" align="center"><b>Action</b></td>
		</tr>
	</thead>
	<tbody>
		<?
		if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
		
		if($_REQUEST[SBMT_SEARCH] && $_REQUEST[parama] && $_REQUEST[search]):
   			$cond=" and ".$_REQUEST[parama] . " ='" . $_REQUEST[search] . "'";
		endif;
		
		$r=mysql_query("select count(*) as total from " .TABLE_SETTINGS." where 1 " . $cond);
		$total=@mysql_result($r,0,"total");
		
		
		$r=mysql_query("select * from ".TABLE_SETTINGS." where 1 ". $cond ." order by config_id desc limit " . ($_REQUEST['limit']-1)*10 . ",10");
	
		if(!$total):
   			?>
				<tr class='lnkred'><td colspan='7' align='center'>No record found.</td></tr>
			<?
		endif;
		$j=0;
		while($d=@mysql_fetch_array($r)):
			
    		if(!($j%2)){$class="even";}else{$class="odd";}
			
			
			?>
			<tr  bgcolor='#ffffff' class="<?=$class?>">
				<td width="6">
				<a href='setting.entryform.php?config_id=<?=$d['config_id']?>' class='lnk'><?=$d['config_id']?></a>
				</td>
				<td ><?=$d['config_variable']?></td>
				<td width="16%"><?=$d['config_value']?></td>
				<td width="16%"><?=$d['description']?></td>
				<td width="16%"><?=$d['config_key']?></td>
				
				<td width="16%" align=center><a href='setting.entryform.php?config_id=<?=$d['config_id']?>' class='lnk'><u>Edit</u></a> |
<a href="<?=$_SERVER['PHP_SELF']?>?config_id=<?=$d['config_id']?>&del=1" class='lnk'  onclick="return confirm('Are you sure you want to delete?')"><u>Delete</u></a></td>
			</tr>
			<?
    		
			
		
   			$j++;
		endwhile;   
		?>
	</tbody>
	<? if($total>10):?>
	<tr><td align="center" class="lnk" colspan=9 bgcolor=<?=$lightgray?> height=28><?=paging($total,10,"$param","lnk")?></td></tr>
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