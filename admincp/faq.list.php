<?php
require_once("includes/access.php");
require_once("includes/header.php");
if($_GET[del]):
   mysql_query("delete from " . $prev . "faq where id=" . $_GET[id]);
   pageRedirect('faq.list.php?menuid=130&menupid=128');
endif;
?>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="4" bgcolor="<?=$light?>" class="table">
<tr bgcolor="<?=$light?>"><td width="52%" height=25 class="header">Faq Management</span>&nbsp;&nbsp;&nbsp;<input type=button value='Add New' class=button onclick="javascript:window.location.href='faq.entryform.php?menuid=130&menupid=128&id=0'"></td>
<td bgcolor="<?=$light?>" width=48% align="right">
<table >
<tr class=lnk>
	<td>
    	<label><b>Enter Question</b></label>&nbsp;&nbsp;
	</td>
    <td>
    	<input type="text" name="search_txt" value="<?php print $_REQUEST[search_txt];?>" /> &nbsp;
    </td>
<td><input type=submit class=button name='SBMT_SEARCH'  value='  Search  '>	</td></tr></table>
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
<table id="table-1" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
<thead>
<tr><td height=22 width=70%><b>Question</b></td><td align=center><b>Display Order</b></td><td align=center><b>Status</b></td><td  align=center><b>Action</b></td></tr>
</thead><tbody>
<?
$cond="";
$cond1="";
$cond2="";
if(!$_GET[limit]){$limit=0;$lmt="limit " . $limit . ",20";}else{$lmt="limit " . ($_GET[limit] - 1) * 20 . ",20";}
if($_POST[SBMT_SEARCH] && $_POST[search_txt]):
   if( $_POST[param]=='id'){
   	$cond=$_POST[param]  . " = '" . $_POST[search_txt] . "'";
   }
  else{
   $cond=" question like '%" . $_POST[search_txt] . "%'";}
endif;

if($_GET['faq_cat'])
{$cond1=" faq_cat=".$_GET['faq_cat'];}

if($cond1!="")
{//echo "aa";
$cond2=" where " . $cond1;
}
if($cond!="" && $cond!="")
{
//echo "sdad";
$cond2=" where " . $cond . " and ".$cond1;}


$r=mysql_query("select count(*) as total from " . $prev . "faq " . $cond2);
$total=@mysql_result($r,0,"total");
$r=mysql_query("select * from " . $prev . "faq" . $cond2 . " " .  $lmt);
			//echo "select count(*) as total from " . $prev . "faq " . $cond2;
	if(!$total):
		echo"<tr class='lnkred'><td colspan='4' align='center'>No Result found.</td></tr>";
	endif;
$j=0;$k=0;
while($d=@mysql_fetch_array($r)):
	if(!($j%2)){$class="even";}else{$class="odd";}
    if($d[status]=="Y"){$status=$main_icon_active_img;}else{$status=$main_icon_inactive_img;}
    //$rr=mysql_query("select * from " . $prev . "faq_header where hid=". $d[hid]);
    //$menu_header=@mysql_result($rr,0,"name");
    //$place="";
	$dot="";
	if(strlen($d[question])>60){$dot="...";}
    echo"<tr bgcolor=#ffffff class=" . $class . "><td height=20><a class=lnk  href='faq.entryform.php?menuid=130&menupid=128&id=" . $d[id] . "'><u>" . substr($d[question],0,60) . "" . $dot . "</u></a></td><td align=center>" . $d[ord] . "</td><td align=center>" . $status . "</td><td align=center><a class=lnk  href='faq.entryform.php?menuid=130&menupid=128&id=" . $d[id] . "'><u>".$main_icon_edit_img."</u></a> | <a class=lnk  href=\"javascript:if(confirm('Are you sure you want to delete it?')){window.location='" . $PHP_SELF . "?id=" . $d[id] . "&del=1';}\"><u>".$main_icon_del_img."</u></a></td></tr>";
	$j++;
endwhile;
?>
</tbody>
</table>
<?
if($total>20):?>
<table  width="100%"  border="0" align="center" HEIGHT=25 cellspacing="0" cellpadding="4" style="border:solid 1px <?=$dark?>">
  <tr bgcolor=<?=$light?>><td  align=center >
   <?php echo paging($total,20,"$parama","lnk");?>
</td></tr></table>
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
	["Number","String","String","Number","String","None"]);
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