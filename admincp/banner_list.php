<?php
include("includes/access.php");
include("includes/header.php");
?>

			
<table width="100%" cellpadding="5" cellspacing="0" border="0" class="table" align="center">
  <tr bgcolor="#FFFFFF">
	<td align="left" valign="top">
	<table id="table-content" width="100%" class="sort-table" border="0" cellspacing="1" cellpadding="4">
	  <thead>
	  <tr bgcolor="<?=$graywhite2?>">
		<td height="25" width="5%" align="left"><b>Id</b></td>
		<td height="25" width="10%" align="left"><b>Banner Image</b></td>
		<td height="25" width="15%" align="left"><b>Banner Name</b></td>
			
		<td width="10%" align="center"><b>Status</b></td>
		<td width="15%" align="center"><b>Options</b></td>
	  </tr>
	  </thead>
	  <tbody>
	<?php
	$num_records_per_page = 20;
	$offset = 0;
	$parama = "";
	
	if($_GET['limit'] && $_GET['limit'] != ''){
		$offset = ($_GET['limit'] - 1) * $num_records_per_page;
	}
	
	$where_clause = " WHERE ";
	if($_REQUEST['param'] && $_REQUEST['search']) {
		if($_REQUEST['param'] == "id") {
			$cond = "id = '" . $_REQUEST['search'] . "'";
		}
		else if($_REQUEST['param'] == "id") {
			$cond = "id RLIKE '" . addslashes( $_REQUEST['search'] ) . "'";
		}
		$parama = "&amp;search=" . $_REQUEST[search] . "&amp;param=" . $_REQUEST[param];
	}
	
	if( $cond ) $where_clause .= $cond;
	else $where_clause .= 1;
	
	$total_exe = mysql_query("SELECT COUNT(*) AS `total` FROM ".$prev."banner".$where_clause."");
	$total = @mysql_result($total_exe, 0, "total");
	
	$main_query = "SELECT * FROM ".$prev."banner" .$where_clause. "	ORDER BY id ASC	LIMIT $offset, $num_records_per_page";
	$main_exe = mysql_query($main_query) or die(mysql_error());
	
	if( @mysql_num_rows( $main_exe ) ) {
		$j = 0;
	
		$box_image_name = '';
		$tid_link = '';
		$tids = array();
		
		if($_GET['id']) {
			$tids = explode("|", $_GET['id']);
		}
		
		while( $main_fetch = mysql_fetch_array( $main_exe ) ) {
			$j++;
			if(($j % 2))
				$class = "odd";
			else
				$class = "even";
			
			if($main_fetch['status'] == "Y")
				$status = $main_icon_active_img;
			else
				$status = $main_icon_inactive_img;
			
	?>
	  <tr bgcolor="#ffffff" class="<?=$class?>">
		<td align="left"><?php echo stripslashes($main_fetch['id']);?></td>
		<td align="left"><img src="../viewimage.php?img=<?php echo stripslashes($main_fetch['banner']);?>&width=150&height=50" /></td>
		<td align="left"><?php echo stripslashes($main_fetch['sbtitle']);?></td>
		<td align="center"><?php echo $status;?></td>
		<td align="center">
		 <a class="lnk" href="banner_entry.php?id=<?php echo $main_fetch['id'];?>"><?php echo $main_icon_edit_img; ?></a>
		 <?php if( !@in_array($main_fetch['id'], $no_delete_ids) ) { ?>
	     &nbsp;|&nbsp;
		 <a onClick="javascript:delConfirm('<?php echo $main_fetch['id']; ?>');" href="javascript:void(0);" class="lnk"><?php echo $main_icon_del_img; ?></a>
		 <?php } ?></td>
		</tr>
	<?php
		}
		
		if($total > $num_records_per_page) {
	?>
	  <tr bgcolor="<?=$light?>">
		<td colspan="8" align="center" height="25"><?=paging($total, $num_records_per_page, $parama, "paging");?></td>
	  </tr>
	<?php
		}
	}
	else {
	?>
	  <tr>
		<td align="center" colspan="8" class="lnkred">No Records Found!</td>
	  </tr>
	<?php } ?>
	  </tbody>
	</table></td>
  </tr>
</table>
</form>
</div>
</div>
</div>
</div>
</div>
</div>


<script type="text/javascript">
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
var st = new SortableTable(document.getElementById("table-content"),
	["Number","String","String","None"]);
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

<?php include("includes/footer.php"); ?>