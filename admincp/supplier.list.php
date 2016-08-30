<?php
include("includes/access.php");
include("includes/header.php");

$pid=($_REQUEST['pid']=='')?0:$_REQUEST['pid'];

if($_REQUEST['del']):
  mysql_query("delete from ".TABLE_SUPPLIERS." where supplier_id=" . $_REQUEST['supplier_id']);
  pageRedirect("attribute.list.php?pid=$pid");
  exit();
endif;
?>
<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
		<td class="header"><a href="attribute.list.php" class="header">Supplier List  &nbsp;</a>
	    <input type="button" class="button" onClick="javascritp:window.location.href='supplier.entryform.php?pid=<?=$pid?>'" value="Add New Supplier">		</td><td width="40%" align="right">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr class="lnk">
					<td>
					<select name="parama" size="1" class="lnk">
						<option value="supplier_id" <? if($_REQUEST['parama']=="supplier_id"){echo" selected";}?>>ID</option>
						<option value="supplier_name" <? if($_REQUEST['parama']=="supplier_name"){echo" selected";}?>>Name</option>
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
		<td  height="25"><b>Supplier Name</b></td>   
                <td  height="25"><b>Supplier Code</b></td>    
		<td width="20%" align="center"><b>Status</b></td>
		<td  width="20%" align="center"><b>Action</b></td>
		</tr>
	</thead>
	<tbody>
		<?
		
		$r=mysql_query("select * from ".TABLE_SUPPLIERS." where  1   order by supplier_id");
	    //echo"select * from ".TABLE_SUPPLIERS." where  pid='0'   order by attributes_id";
		$total=@mysql_num_rows($r);
		if(!$total):
   			?>
				<tr class='lnkred'><td colspan='4' align='center'>No record found.</td></tr>
			<?
		endif;
		$j=0;
		while($d=@mysql_fetch_array($r)):
			
    		if(!($j%2)){$class="even";}else{$class="odd";}
			if($d['status']=="Y"){$status="Active";}else{$status="<span class='lnkred'>In Active</span>";}
			?>
			<tr   class="even">
				<td >
				<a href='attribute.list.php?pid=<?=$d['supplier_id']?>' class='lnk'><?=$d['supplier_id']?></a>
				</td>
				<td ><a href='attribute.list.php?pid=<?=$d['supplier_id']?>' class='lnk'><?=$d['supplier_name']?></a></td>
                                <td width="20%" align="center"><?=$d['supplier_code']?></td>
				<td width="20%" align="center"><?=$status?></td>
				<td width="20%" align=center><a href='supplier.entryform.php?supplier_id=<?=$d['supplier_id']?>&pid=<?=$pid?>' class='lnk'><u>Edit</u></a> | 
				<a href="<?=$_SERVER['PHP_SELF']?>?supplier_id=<?=$d['supplier_id']?>&del=1&pid=<?=$pid?>" class='lnk'  onclick="return confirm('Are you sure you want to delete?')"><u>Delete</u></a></td>
				</tr>
			<?php
    		 
		$j++; 
	endwhile;   	
		?>
	</tbody>
	
</table>


</form>

<?
include("includes/footer.php");
?>