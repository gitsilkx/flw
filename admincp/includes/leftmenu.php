
<table cellpadding='4' cellspacing='0' border='0' width='100%'>
<?php

$rws=mysql_query("select * from " . $prev . "adminmenu where status='Y' and id=" . $_GET[menupid] . "  order by ord");

$rw=mysql_fetch_array($rws);
echo "<tr bgcolor='" . $lightgray ."'><td height=26 style='border-bottom:solid 1px gray'><a href='".$rw[url]."' class='lnk14'><b>".$rw[name]."</b></a></td></tr>\n";

if(!file_exists($rw[pic]))
{
	$img="images/arrow_r.gif";
}
$j=0;
$rs=mysql_query("select * from " . $prev . "adminmenu where status='Y' and parent_id=".$_GET[menupid]." order by ord");
if(@mysql_num_rows($rs))
{
   	while($r=mysql_fetch_array($rs))
	{

   		if($r[id]==$_GET[menuid] || $r[url]==$currentPageName){$bgcolor='#0080C0';$class='lnk_white_m';}else{$bgcolor='white';$class='lnk';}
   		echo "<tr bgcolor=" . $bgcolor ."><td colspan='2'><img src='".$img."'  border='0' hspace='3' align='absmiddle' /><a href='".$r[url]."?menuid=" . $r[id]."&menupid=" . $r[parent_id]."' class='" . $class . "'>".$r[1]."</a></td></tr>";
	    $j++;
	}
}
?>
</table>
<!--</ul>-->