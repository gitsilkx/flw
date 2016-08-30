<?
require_once("includes/access.php");
require_once("includes/header.php");
if($_GET[del]):
   $r=mysql_query("delete from " . $prev . "contents where id=" . $_GET[id]);   
endif;
//if($_REQUEST['langs']==""){$langs="english";}else{$langs=$_REQUEST['langs'];}
?>

<form method=post action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">

<table width="100%" border="0" align="center" cellspacing="0" cellpadding="4" bgcolor="<?=$light?>" class="table">
<tr bgcolor="<?=$light?>"><td width="54%" height="28" class="header">Content Management&nbsp;
</td>
<td bgcolor="<?=$light?>" width="46%" align="right">
  <input type="button" value='Add New' class="button" onclick="javascript:window.location.href='page.editor.php?menuid=129&menupid=128'">
</td></tr></table>
<p class="lnk" align="right">
	<?php echo $main_icon_active_img; ?>&nbsp;= Active
	&nbsp;|&nbsp;
	<?php echo $main_icon_inactive_img; ?>&nbsp;= Hidden
	&nbsp;|&nbsp;
	<?php echo $main_icon_edit_img; ?>&nbsp;= Edit
	&nbsp;|&nbsp;
	<?php echo $main_icon_del_img; ?>&nbsp;= Delete
	
</p>
<table id="table-1" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="6"  style="border:solid 1px <?=$dark?>">
<thead>
<tr bgcolor="<?=$graywhite2?>"><td height=22><b>Page Name</b></td><td height=22><b>Sub Page Name</b></td><td height=22><b>Page Code Name</b></td><td align="center"><b>Top Menu?</b></td><td align="center"><b>Order</b></td><td align="center"><b>Status</b></td><td  align="center"><b>Action</b></td></tr>
</thead><tbody>
<?
if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
if($_REQUEST[param] && $_REQUEST[search]):
   $cond=$_REQUEST[param]  . " rlike '" . $_REQUEST[search] . "'";
endif;
$cond = "parent_id='0'";
if($cond){$cond2=" where  " . $cond;}
$r=mysql_query("select count(id) as total from " . $prev . "contents " . $cond2);
$total=@mysql_result($r,0,"total");
if(!$total):
   echo"<tr class='lnkred'><td colspan='3' align='center'>No Record Found.</td></tr>";
endif;
$r=mysql_query("select * from " . $prev . "contents where parent_id='0' order by ord asc limit " . ($_REQUEST['limit']-1)*20 . ",20");
//echo "select * from " . $prev . "contents where parent_id='0'";
$j=0;$k=0;
while($d=@mysql_fetch_array($r)):
	if(!($j%2)){$class="even";}else{$class="odd";}
    if($d[status]=="Y"){$status=" $main_icon_active_img";}else{$status="$main_icon_inactive_img";}
    if($d[top_menu]=="Y"){$top_menu=" $main_icon_active_img";}else{$top_menu="$main_icon_inactive_img";}
    echo"<tr bgcolor='#ffffff' class='" . $class . "'>";
	
	echo"<td height=20><a class='lnk'  href='page.editor.php?menuid=129&menupid=128&id=" . $d[id] . "'><u>" . ucwords($d[cont_title]) . "</u></a></td>";
	
	echo"<td align=center>&nbsp;</td></td><td align=center>" . $d['page_code'] . "</td><td align='center'>" . $top_menu . "</td><td align=center>" . $d['ord'] . "</td><td align='center'>" . ucwords($status) . "</td><td align=center><a class=lnk  href='page.editor.php?menuid=129&menupid=128&id=" . $d[id] . "'><img src='images/icon_edit.png' border='0'></a> | ";
	echo"<a class='lnk'  href=\"javascript://\" onclick=\"javascript:if(confirm('Are you sure you want to delete it?')){window.location='" . $_SERVER['PHP_SELF'] . "?id=" . $d[id] . "&amp;del=1';}\"><img src='images/icon_del.png' border='0'></a> ";
        echo"<a class=lnk href='page.editor.php?menuid=129&menupid=128&parent_id=" . $d[id] . "'><u>Add Sub Page</u></a> ";
    echo"</td></tr>";
    
    $rr1=mysql_query("select * from " . $prev . "contents where parent_id=" . $d[id] . " order by ord asc");
				$k=0;
				while($dd1=@mysql_fetch_array($rr1)):
                                    if($dd1[status]=="Y"){$status=" $main_icon_active_img";}else{$status="$main_icon_inactive_img";}
                                    if($dd1[top_menu]=="Y"){$top_menu=" $main_icon_active_img";}else{$top_menu="$main_icon_inactive_img";}
				   //$tot_prod2=mysql_query("select count(*) as total from ".$prev."products where cat_id='".$dd1[cat_id]."' and status='Y'");
				   //$tot_prod3=@mysql_result($tot_prod2,0,"total");

				   echo"<tr bgcolor=#ffffff class=odd><td>|______________</td>
				   <td><a class=lnk href='page.editor.php?menuid=129&menupid=128&id=" . $dd1[id] ."'>" . stripslashes($dd1[cont_title]) . "</a>
				   <td align=center>" . $dd1['page_code'] . "</td><td align='center'>" . $top_menu . "</td><td align=center>" . $dd1['ord'] . "</td><td align='center'>" . ucwords($status) . "</td>
				   <td align=center><a class=lnk href='page.editor.php?menuid=129&menupid=128&id=" . $dd1[id] . "'><img src='images/icon_edit.png' border='0'></a> |<a class=lnk href=\"javascript:if (confirm('Are you sure you want to delete `" . stripslashes($dd1[cat_name]) . "`?')){window.location.href='category.list.php?cat_id=" . $dd1[id] . "&del=1'}\"><img src='images/icon_del.png' border='0'></a> | <a class=lnk href='product.entryform.php?page_id=" . $d[id] . "'><u>Add Product</u></a> <br></td></tr>";
				endwhile;
	$j++;
endwhile;
$parama="&amp;menuid=129&amp;menupid=128&amp;search=" . $_REQUEST[search] . "&amp;param=" . $_REQUEST[param];
?>
</tbody>
</table>
<? if($total>20):?>
<table  width="100%"  border="0" align="center" cellspacing="0" cellpadding="4" style="border:solid 1px <?=$dark?>">
    <tr bgcolor="<?=$light?>"><td  align="center" height="25"><?=  pagination($total,20,$parama,"lnk");?></td></tr>
</table>
<? endif;?>
</form>
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
var st = new SortableTable(document.getElementById("table-1"),
	["Number","String","String","String","String","String","String","String","Number","String","None"]);
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

<? include("includes/footer.php"); ?>