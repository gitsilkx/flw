<?php
include("includes/access.php");
include("includes/header.php");
  //$parent_id=$_REQUEST[parent_id];
if($_GET[del]):
$q=mysql_query("select * from " . $prev . "categories where parent_id=" . $_GET[cat_id]);
//echo"select * from " . $prev . "categories where parent_id=" . $_GET[id];
if(@mysql_num_rows($q))
{
echo"<script>alert('You Can not delete!!');window.location.href='".$_SERVER[PHP_SELF]."';</script>";
}
else
{
   mysql_query("delete from " . $prev . "categories where cat_id=" . $_GET[cat_id]);
}
endif;
   ?>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>"><td class="header">Category List</td><td align="right"><input type="button" class="button" onClick="javascritp:window.location.href='category.entryform.php?parent_id=0';" value="Add Category"></td></tr>
</table>
<table id="table-1" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
	<thead>
		<tr><td><b>Category Name</b></td><td><b>Sub Category Name</b></td><td><b>Sub Sub Category Name</b></td><td><b>Category Code</b></td><td align=center><strong>Display Order</strong></td><td align="center"><b>Option</b></td></tr>
		<?php
		$j=0;
		$r=mysql_query("select * from " . $prev . "categories where parent_id='0'  order by cat_name");
		while($d=@mysql_fetch_array($r)):
		   // if(!($j%2)){$class="even";}else{$class="even";}
		    echo"<tr bgcolor='#ffffff' class='".$class."' onmouseover=\"this.style.backgroundColor='#F0FFD1';\" onmouseout=\"this.style.backgroundColor='';\"><td ><a class=lnk href='category.entryform.php?cat_id=" . $d[cat_id] . "'>" . stripslashes($d[cat_name]) . "</a></td>";
			
                echo"<td align=center>&nbsp;</td><td align=center>&nbsp;</td><td align=center>" . $d['cat_code'] . "</td><td align=center>" . $d['ord'] . "</td>";
			echo"<td align=center><a class=lnk href='category.entryform.php?cat_id=" . $d[cat_id] . "'><u>Edit</u></a> | ";
			echo"<a class=lnk href='category.entryform.php?parent_id=" . $d[cat_id] . "'><u>Add Subcategory</u></a> | ";
			echo"<a class=lnk href=\"javascript:if (confirm('Are you sure you want to delete `" . stripslashes($d[cat_name]) . "`?')){window.location.href='category.list.php?cat_id=" . $d[cat_id] . "&del=1'}\"><u>Delete</u></a></td>

			 </tr>";


		    $rr=mysql_query("select * from " . $prev . "categories where parent_id=" . $d[cat_id] . " order by cat_name");
			$k=0;
			while($dd=@mysql_fetch_array($rr)):
				$tot_prod2=mysql_query("select count(*) as total from ".$prev."products where cat_id='".$dd[cat_id]."' and status='Y'");
				$tot_prod3=@mysql_result($tot_prod2,0,"total");
				  //if(!($k%2)){$class="odd";}else{$class="odd";}
			    echo"<tr bgcolor=#ffffff class=odd>
				<td>|______________</td><td ><a class=lnk href='category.entryform.php?cat_id=" . $dd[cat_id] . "&parent_id=" . $dd[parent_id] . "'>" . stripslashes($dd[cat_name]) . "</a></td><td></td>
				<td align=center>" . $dd['cat_code'] . "</td><td align=center>" . $dd['ord'] . "</td><td align=center><a class=lnk href='category.entryform.php?parent_id=" . $dd[parent_id] . "&cat_id=" . $dd[cat_id] . "'><u>Edit</u></a> | <a class=lnk href='category.entryform.php?parent_id=" . $dd[cat_id] . "'><u>Add Subcategory</u></a> |<a class=lnk href=\"javascript:if (confirm('Are you sure you want to delete `" . stripslashes($dd[cat_name]) . "`?')){window.location.href='category.list.php?cat_id=" . $dd[cat_id] . "&del=1'}\"><u>Delete</u></a> | <a href='autoform.php?cat_id=" . $dd[cat_id] . "' class=lnk><u>Technical Info Form</u></a> | <a class=lnk href='product.entryform.php?parent_id=" . $dd[parent_id] . "&sub_cat_id=" . $dd[cat_id] . "'><u>Add Product</u></a> | <a class=lnk href='product.list.php?cat_id=" . $dd[cat_id] . "'><u>View Products(".$tot_prod3.")</u></a><br></td></tr>";

                $rr1=mysql_query("select * from " . $prev . "categories where parent_id=" . $dd[cat_id] . " order by cat_name");
				$k=0;
				while($dd1=@mysql_fetch_array($rr1)):
				   $tot_prod2=mysql_query("select count(*) as total from ".$prev."products where cat_id='".$dd1[cat_id]."' and status='Y'");
				   $tot_prod3=@mysql_result($tot_prod2,0,"total");

				   echo"<tr bgcolor=#ffffff class=odd><td align=center>&nbsp;</td><td>|______________</td>
				   <td><a class=lnk href='category.entryform.php?cat_id=" . $dd1[cat_id] . "&parent_id=" . $dd[cat_id] . "'>" . stripslashes($dd1[cat_name]) . "</a>
				   <td align=center>" . $dd1['cat_code'] . "</td></td><td align=center>" . $dd1['ord'] . "</td>
				   <td align=center><a class=lnk href='category.entryform.php?parent_id=" . $dd1[parent_id] . "&cat_id=" . $dd1[cat_id] . "'><u>Edit</u></a> |<a class=lnk href=\"javascript:if (confirm('Are you sure you want to delete `" . stripslashes($dd1[cat_name]) . "`?')){window.location.href='category.list.php?cat_id=" . $dd1[cat_id] . "&del=1'}\"><u>Delete</u></a> | <a href='autoform.php?cat_id=" . $dd1[cat_id] . "' class=lnk><u>Technical Info Form</u></a> | <a class=lnk href='product.entryform.php?parent_id=" . $d[cat_id] . "&sub_cat_id=" . $dd[cat_id] . "&cat_id=" . $dd1[cat_id] . "'><u>Add Product</u></a> | <a class=lnk href='product.list.php?cat_id=" . $dd1[cat_id] . "'><u>View Products(".$tot_prod3.")</u></a><br></td></tr>";
				endwhile;
		    endwhile;
			$j++;
		endwhile;

		?>
	</thead>
</table>
<?php
include("includes/footer.php");
?>