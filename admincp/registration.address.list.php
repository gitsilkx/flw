<?php
include("includes/access.php");
include("includes/header.php");
$registration_id=$_REQUEST['registration_id'];
$sql="select * from " .TABLE_REGISTRATION." where registration_id=$registration_id";
$resD=mysql_query($sql);
$rowD=@mysql_fetch_array($resD);
if($_REQUEST['del']):
  mysql_query("delete from " .TABLE_REGISTRATION_ADDRESS." where address_id=" . $_REQUEST['address_id']);
  pageRedirect('registration.address.list.php');
  exit();
endif;
?>
<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" name="registration_id" value="<?=$registration_id?>" />
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
	<td class="header" > 
		<td class="header"><a href="registration.list.php" class="header" >Registration List</a> &raquo;Registration Address List 
	 	</td><td width="40%" align="right">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr class="lnk">
					<td>
					<select name="parama" size="1" class="lnk">
						<option value="address_id" <? if($_REQUEST['parama']=="address_id"){echo" selected";}?>>ID</option>
						<option value="registration_username" <? if($_REQUEST['parama']=="registration_username"){echo" selected";}?>>username</option>
						<option value="address_type" <? if($_REQUEST['parama']=="address_type"){echo" selected";}?>>Address Type</option>
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
		<td width="14%" height="25"><b>ID</b></td>
		<td  width="14%" height="25"><b>Username</b></td>
		<td  width="14%" height="25"><b>Address Type </b></td>
        <td  width="14%" align="center"><b>Phone </b></td>
		<td  width="14%" align="center"><b>Company Name</b></td>
		<td  width="14%" align="center"><b>Remarks</b></td>
		<td  width="14%" align="center"><b>Action</b></td>
		</tr>
	</thead>
	<tbody>
		<?
		if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
		
		if($_REQUEST[SBMT_SEARCH] && $_REQUEST[parama] && $_REQUEST[search]):
   			$cond=" and ".$_REQUEST[parama] . " ='" . $_REQUEST[search] . "'";
		endif;
		
		$r=mysql_query("select count(*) as total from " .TABLE_REGISTRATION_ADDRESS." where 1  and registration_id='$registration_id' " . $cond);
		$total=@mysql_result($r,0,"total");
		
		
		$r=mysql_query("select * from ".TABLE_REGISTRATION_ADDRESS." where 1 and registration_id='$registration_id' ". $cond ." order by address_id desc limit " . ($_REQUEST['limit']-1)*10 . ",10");
	
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
				<td width="14%">
				<a href='registration.address.entryform.php?registration_id=<?=$registration_id?>&address_id=<?=$d['address_id']?>&cat_id=<?=$cat_id?>' class='lnk'><?=$d['address_id']?></a>
				</td>
				
				<td width="14%"><?=$rowD['registration_username']?></td>
				<td width="14%"><?=$d['address_type']?></td>
				<td width="14%"><?=$d['phone']?></td>
				<td width="14%"><?=$d['company_name']?></td>
				
				<td width="14%"><?=$d['remarks']?></td>
				
				<td width="20%"><a href='registration.address.entryform.php?registration_id=<?=$registration_id?>&address_id=<?=$d['address_id']?>&cat_id=<?=$cat_id?>' class='lnk'><u>Edit</u></a> | 
<a href="<?=$_SERVER['PHP_SELF']?>?address_id=<?=$d['address_id']?>&registration_id=<?=$registration_id?>&del=1" class='lnk'  onclick="return confirm('Are you sure you want to delete?')"><u>Delete</u></a></td>
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
