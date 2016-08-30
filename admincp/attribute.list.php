<?php
include("includes/access.php");
include("includes/header.php");

$pid=($_REQUEST['pid']=='')?0:$_REQUEST['pid'];

if($_REQUEST['del']):
  mysql_query("delete from ".TABLE_ATTRIBUTES." where attributes_id=" . $_REQUEST['attributes_id']);
  pageRedirect("attribute.list.php?pid=$pid");
  exit();
endif;
?>
<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
		<td class="header"><a href="attribute.list.php" class="header">Attribute List  &nbsp;</a>
	    <input type="button" class="button" onClick="javascritp:window.location.href='attribute.entryform.php?pid=<?=$pid?>'" value="Add New Attribute">		</td><td width="40%" align="right">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr class="lnk">
					<td>
					<select name="parama" size="1" class="lnk">
						<option value="attributes_id" <? if($_REQUEST['parama']=="attributes_id"){echo" selected";}?>>ID</option>
						<option value="attributes_name" <? if($_REQUEST['parama']=="attributes_id"){echo" selected";}?>>Name</option>
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
		<td width="20" height="25"><b>ID</b></td>
		<td  height="25"><b>Name</b></td><td ><strong>Option Value</strong></td>
		<td width="20%" align="center"><b>Status</b></td>
		<td  width="20%" align="center"><b>Action</b></td>
		</tr>
	</thead>
	<tbody>
		<?
		
		$r=mysql_query("select * from ".TABLE_ATTRIBUTES." where  pid='0'   order by attributes_id");
	    //echo"select * from ".TABLE_ATTRIBUTES." where  pid='0'   order by attributes_id";
		$total=@mysql_num_rows($r);
		if(!$total):
   			?>
				<tr class='lnkred'><td colspan='4' align='center'>No record found.</td></tr>
			<?
		endif;
		$j=0;
		while($d=@mysql_fetch_array($r)):
			
    		if(!($j%2)){$class="even";}else{$class="odd";}
			if($d['attributes_status']=="Y"){$status="Active";}else{$status="<span class='lnkred'>In Active</span>";}
			?>
			<tr   class="even">
				<td >
				<a href='attribute.list.php?pid=<?=$d['attributes_id']?>' class='lnk'><?=$d['attributes_id']?></a>
				</td>
				<td ><a href='attribute.list.php?pid=<?=$d['attributes_id']?>' class='lnk'><?=$d['attributes_name']?></a></td>
				<td >..</td><td width="20%" align="center"><?=$status?></td>
				<td width="20%" align=center><a href='attribute.entryform.php?attributes_id=<?=$d['attributes_id']?>&pid=<?=$pid?>' class='lnk'><u>Edit</u></a> | <a href='addoption.php?attributes_id=0&pid=<?=$d['attributes_id']?>' onclick="return hs.htmlExpand(this, {objectType: 'iframe', width: 555, height: 270, 
				allowSizeReduction: false, wrapperClassName: 'draggable-header no-footer', 
				preserveContent: false,headingText: 'Add Option', objectLoadTime: 'after'})" class='lnk'><u>Add Option</u></a> |
				<a href="<?=$_SERVER['PHP_SELF']?>?attributes_id=<?=$d['attributes_id']?>&del=1&pid=<?=$pid?>" class='lnk'  onclick="return confirm('Are you sure you want to delete?')"><u>Delete</u></a></td>
				</tr>
			<?
			$rr=mysql_query("select * from ".TABLE_ATTRIBUTES."  where pid=" . $d['attributes_id']);
			$k=0;
			while($dd=mysql_fetch_array($rr)):
				if(!($k%2)){$class="odd";}else{$class="even";} 
				echo"<tr  class=odd><td></td>
						<td >&nbsp;|______________</td>
						<td >
							<a class=lnk"; 
								echo" href='attribute.entryform.php?attributes_id=" . $dd['attributes_id'] . "&pid=" . $dd[pid] . "'"; 
								//echo "href='#'";
								echo">" . $dd[attributes_name] . "
							</a>
						</td>
						<td align=center>" . $dd[status] . "</td>
						<td align=center> 
							<a class=lnk"; 
								echo" href='attribute.entryform.php?attributes_id=" . $dd[attributes_id]. "&pid=" . $dd[pid] . "'"; 
								//echo"href='#'";
								echo"><u>Edit</u>
							</a> | 
							
							<a class=lnk"; 
								echo" href=\"javascript:if(confirm('You are deleting `" . $dd[name] . "`?')){window.location='" . $_SERVER[PHP_SELF] . "?attributes_id=" . $dd[attributes_id] . "&del=1';}\"";
								//echo"href='#'";
								echo"><u>Delete</u>
							</a>
						</td>
					</tr>";
    		
			
		
   			$k++;
		endwhile;  
		$j++; 
	endwhile;   	
		?>
	</tbody>
	
</table>


</form>

<?
include("includes/footer.php");
?>