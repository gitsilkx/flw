<?php
include("includes/access.php");
include("includes/header.php");
$district_id=$_REQUEST['district_id'];
$road_id=$_REQUEST['road_id'];

$sql="select * from " .TABLE_DISTRICT." where district_id=$district_id";
$resD=mysql_query($sql);
$rowD=@mysql_fetch_array($resD);

$sql="select * from " .TABLE_ROAD." where road_id=$road_id";
$resR=mysql_query($sql);
$rowR=@mysql_fetch_array($resR);


if($_REQUEST['del']):
  mysql_query("delete from " .TABLE_ALLEY." where alley_id=" . $_REQUEST['alley_id']);
  pageRedirect("subsoi.list.php?district_id=$district_id&road_id=$road_id");
  exit();
endif;
?>
<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" name="district_id" value="<?=$district_id?>" />
<input type="hidden" name="road_id" value="<?=$road_id?>" />

<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
		<td class="header" ><a href="district.list.php" class="header" >District</a> &raquo; <a href="road.list.php?district_id=<?=$district_id?>" class="header" >Road List</a> &raquo; SubSoi
	    <input type="button" class="button" onClick="javascritp:window.location.href='subsoi.entryform.php?district_id=<?=$district_id?>&road_id=<?=$road_id?>&alley_id=<?=$alley_id?>&cat_id=<?=$cat_id?>'" value="Add New SubSoi">		</td><td width="40%" align="right">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr class="lnk">
					<td>
					<select name="parama" size="1" class="lnk">
						<option value="alley_id" <? if($_REQUEST['parama']=="alley_id"){echo" selected";}?>>ID</option>
						<option value="alley_name" <? if($_REQUEST['parama']=="alley_name"){echo" selected";}?>>Name</option>
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
		<td width="10%" height="25"><b>ID</b></td>
		
		<td  width="20%" height="25"><b>District</b></td>
		<td  width="25%" height="25"><b>Road</b></td>
		<td  width="25%" height="25"><b>Name</b></td>
		<td width="10%" align="center"><b>Status</b></td>
		<td  width="10%" align="center"><b>Action</b></td>
		</tr>
	</thead>
	<tbody>
		<?
		if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
		
		if($_REQUEST[SBMT_SEARCH] && $_REQUEST[parama] && $_REQUEST[search]):
   			$cond=" and ".$_REQUEST[parama] . " ='" . $_REQUEST[search] . "'";
		endif;
		
		$r=mysql_query("select count(*) as total from " .TABLE_ALLEY." where 1  and road_id='$road_id' " . $cond);
		$total=@mysql_result($r,0,"total");
		
		
		$r=mysql_query("select * from ".TABLE_ALLEY." where 1 and road_id='$road_id' ". $cond ." order by alley_id desc limit " . ($_REQUEST['limit']-1)*10 .",10");
	
		if(!$total):
   			?>
				<tr class='lnkred'><td colspan='4' align='center'>No record found.</td></tr>
			<?
		endif;
		$j=0;
		while($d=@mysql_fetch_array($r)):
			
    		if(!($j%2)){$class="even";}else{$class="odd";}
			if($d['alley_status']=="Y"){$status="Active";}else{$status="<span class='lnkred'>In Active</span>";}
			?>
			<tr  bgcolor='#ffffff' class="<?=$class?>">
				<td width="10%">
				<a href='subsoi.entryform.php?district_id=<?=$district_id?>&road_id=<?=$d['alley_id']?>&cat_id=<?=$cat_id?>' class='lnk'><?=$d['road_id']?></a>
				</td>
				<td width="20%"><?=$rowD['district_name']?></td>
				<td width="25%"><?=$rowR['road_name']?></td>
				<td width="25%"><?=$d['alley_name']?></td>
				<td width="10%"><?=$status?></td>
				<td width="10%"><a href='subsoi.entryform.php?district_id=<?=$district_id?>&road_id=<?=$road_id?>&alley_id=<?=$d['alley_id']?>&cat_id=<?=$cat_id?>' class='lnk'><u>Edit</u></a> |  
<a href="<?=$_SERVER['PHP_SELF']?>?alley_id=<?=$d['alley_id']?>&district_id=<?=$district_id?>&road_id=<?=$road_id?>&del=1" class='lnk'  onclick="return confirm('Are you sure you want to delete?')"><u>Delete</u></a></td>
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