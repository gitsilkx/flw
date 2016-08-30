<?php
include("includes/access.php");
include("includes/header.php");
$param="&menuid=119&menupid=117";
$pid=($_REQUEST['pid']=='')?0:$_REQUEST['pid'];

if($_REQUEST[del]):
    mysql_query("delete from products where id=" . $_REQUEST[id]);
endif;
?>
<form name="form1" method="post" action="product.list.php?menuid=119&menupid=117">
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
		<td class="header" width=15%>Product List </td><td align=right><input type="button" class="button" onClick="javascritp:window.location.href='product.entryform.php?id=0&cat_id=<?=$cat_id?>'" value="Add New Product"></td><td align=right>

			<select name="cat_code" size="1"  class="lnk" style='height:22px' onchange="document.location.href='product.list.php?menuid=119&menupid=117&cat_code='+this.value">
				<option value="0">Category Wise Search :</option>
				<?
				$rrr=mysql_query("select * from " . $prev . "categories where parent_id='0' order by cat_name");
				while($rows=mysql_fetch_array($rrr)):
				   if($rows[cat_code]==$_REQUEST[cat_code]):
				   		echo"<option value='" .$rows[cat_code] . "' selected>" . strtoupper($rows[cat_name]) . "</option>";
				   else:
				   		echo"<option value='" .$rows[cat_code] . "'>" . strtoupper($rows[cat_name]) . "</option>";
				   endif;
				   $rr=mysql_query("select * from " . $prev . "categories where parent_id=" . $rows[cat_id] . " order by cat_name");
				   while($row=mysql_fetch_array($rr)):
				      if($row[cat_code]==$_REQUEST[cat_code]):
				          echo "<option value='" . $row[cat_code] . "' selected>|__" . trim($row[cat_name]) . "</option>";
				      else:
				         echo "<option value='" . $row[cat_code] . "'>|__" . trim($row[cat_name]) . "</option>";
				      endif;
                                      $r=mysql_query("select * from " . $prev . "categories where parent_id=" . $row[cat_id] . " order by cat_name");
                                      while($ro=mysql_fetch_array($r)):
				      if($ro[cat_code]==$_REQUEST[cat_code]):
				          echo "<option value='" . $ro[cat_code] . "' selected>  |_____" . trim($ro[cat_name]) . "</option>";
				      else:
				         echo "<option value='" . $ro[cat_code] . "'>  |_____" . trim($ro[cat_name]) . "</option>";
				      endif;
				   endwhile;
				   endwhile;
				endwhile;
				?>
			</select><!--<input type="submit" class="lnk" name="SBMT_SEARCH" value="Go">-->
		</td>
		<td width="40%" align="right">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr class="lnk">
					<td>
						<select name="parama" size="1" class="lnk" style='height:22px'>
						<option value="name" <? if($_REQUEST[parama]=="name"){echo" selected";}?>>Product Name</option>
 				        <option value="product_no" <? if($_REQUEST[parama]=="product_no"){echo" selected";}?>>Product Code</option>						
 			        </select>
					</td>
					<td>== <input type="text" size="18" name="search"  value="<?=$_REQUEST[search]?>" class="lnk" style='height:18px'> &nbsp;</td>
					<td><input type="submit" class="button" name="SBMT_SEARCH"  value="  Search  "></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table id="table-1" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
	<thead>

		<tr>
		<td width="2%" height="25"><b>ID</b></td>		
		<td><b>Product Name</b></td>
                <td><b>Product Code</b></td>
                <td><b>Page Name</b></td>
		<td><b>Category</b></td>
		<td align=right><b>Price(<?=$setting[currency]?>)</b></td>
		<td><b>Add Date</b></td>
	
		<td align="center"><b>Status</b></td>
		<td align="center"><b>Action</b></td>
		</tr>
	</thead>
	<tbody>
		<?
		if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
		if($_REQUEST[SBMT_SEARCH] && $_REQUEST[parama] && $_REQUEST[search]):
   			if( $_REQUEST[parama]=="product_no"):
       			$cond=$_REQUEST[parama] . "='" . $_REQUEST[search] . "'";
				//echo $cond;
   			else:
      			$cond=$_REQUEST[parama] . " rlike '" . $_REQUEST[search] . "'";
   			endif;
		endif;
		if($_REQUEST[cat_code]):
    		$cond="category='" . $_REQUEST[cat_code] . "'";
		endif;

		if($cond){$cond2=" where " . $cond;}
		$r=mysql_query("select count(*) as total from products " . $cond2);
		//echo "select count(*) as total from " . $prev . "products " . $cond2;
		$total=@mysql_result($r,0,"total");
		$r=mysql_query("select * from products " . $cond2 ." order by id desc limit " . ($_REQUEST['limit']-1)*25 . ",25");
		//echo "select * from " . $prev . "products " . $cond2 ." order by id desc limit " . ($_REQUEST['limit']-1)*25 . ",25";
		if(!$total):
   			echo"<tr class='lnkred'><td colspan='8' align='center'>No Product found.</td></tr>";
		endif;
		$j=0;
		while($d=@mysql_fetch_array($r)):
			
    		if(!($j%2)){$class="even";}else{$class="odd";}
			if($d[status]=="Y"){$status="Online";}else{$status="<span class='lnkred'>Offline</span>";}
			

    		echo"<tr style='text-align:center' bgcolor='#ffffff' class='" . $class . "'><td>".$d[id]."</td>";
					
    		echo"
			<td><a title='View this product details' class='lnk' href='product.entryform.php?menuid=118&menupid=117&id=" . $d[id] .
			"&section=update'><u>" .$d[name] . "</u></a>
			</td><td >" . $d[product_no] . "</td>
                            <td >" . @getPagenameById($d[page_id]) . "</td>
                        <td >" . @getCategorynameByCode($d[category]) . "</td>
			<td align='right'>" . $d[price] . "</td>
			<td>" . @showdate($d[reg_date]) . "</td>
			<td align='center'>" . $status . "</td>";?>
<td width="20%" align=center><a href='product.entryform.php?menuid=118&menupid=117&id=<?=$d['id']?>&pid=<?=$pid?>' class='lnk'><u>Edit</u></a> | <a href='addoption.php?product_code=<?=$d['product_no']?>&pid=<?=$pid?>' onclick="return hs.htmlExpand(this, {objectType: 'iframe', width: 555, height: 270, 
				allowSizeReduction: false, wrapperClassName: 'draggable-header no-footer', 
				preserveContent: false,headingText: 'Add Option', objectLoadTime: 'after'})" class='lnk'><u>Add Option</u></a> |
				<a href="<?=$_SERVER['PHP_SELF']?>?menuid=118&menupid=117&id=<?=$d['id']?>&del=1&pid=<?=$pid?>" class='lnk'  onclick="return confirm('Are you sure you want to delete?')"><u>Delete</u></a></td>
			
            <?php 
   			$j++;
		endwhile;
		?>
	</tbody>
	<? if($total>10):?>
		<?

		if($_REQUEST[cat_code]):
			$param.="&cat_code=" . $_REQUEST[cat_code];
		endif;

		?>
		<tr><td align="center" class="lnk" colspan=9 bgcolor=<?=$lightgray?> height=28><?=pagination($total,25,$param,"lnk")?></td></tr>
<? endif;?>
</table>


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
