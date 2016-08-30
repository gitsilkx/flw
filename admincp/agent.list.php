<?php
include("includes/access.php");
include("includes/header.php");

$pid=($_REQUEST['pid']=='')?0:$_REQUEST['pid'];
$param="&menuid=52&menupid=46";
if($_REQUEST['del']):
  mysql_query("delete from ".TABLE_AGENT_IP." where id=" . $_REQUEST['agent_id']);
  pageRedirect("agent.list.php?pid=$pid");
  exit();
endif;
?>
<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
		<td class="header"><a href="attribute.list.php" class="header">Agent IP List  &nbsp;</a>
	    <input type="button" class="button" onClick="javascritp:window.location.href='agent.entryform.php?pid=<?=$pid?>'" value="Add New Agent IP">		</td><td width="40%" align="right">
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
		<td width="20%" height="25"><b>Agent ID</b></td>
		<td  height="25"><b>Agent IP</b></td>                
		<td  width="20%" align="center"><b>Action</b></td>
		</tr>
	</thead>
	<tbody>
		<?
		
		$r=mysql_query("select * from ".TABLE_AGENT_IP." where  1 order by id");
	    //echo"select * from ".TABLE_SUPPLIERS." where  pid='0'   order by attributes_id";
		$rr=mysql_query("select count(*) as total from ".TABLE_AGENT_IP);
		//echo "select count(*) as total from " . $prev . "products " . $cond2;
		$total=@mysql_result($rr,0,"total");
		if(!$total):
   			?>
				<tr class='lnkred'><td colspan='4' align='center'>No record found.</td></tr>
			<?
		endif;
		$j=0;
		while($d=@mysql_fetch_array($r)):
			
    		if(!($j%2)){$class="even";}else{$class="odd";}
			
			?>
			<tr   class="even">
				<td ><?=$d['id']?>
				</td>
				<td ><?=$d['agent_ip']?></td>                                
				<td width="20%" align=center><a href='agent.entryform.php?agent_id=<?=$d['id']?>&pid=<?=$pid?>' class='lnk'><u>Edit</u></a> | 
				<a href="<?=$_SERVER['PHP_SELF']?>?agent_id=<?=$d['id']?>&del=1&pid=<?=$pid?>" class='lnk'  onclick="return confirm('Are you sure you want to delete?')"><u>Delete</u></a></td>
				</tr>
			<?php
    		 
		$j++; 
	endwhile;   	
		?>
                                <tr><td align="center" class="lnk" colspan=3 bgcolor=<?=$lightgray?> height=28><?=pagination($total,25,$param,"lnk")?></td></tr>
	</tbody>
	
</table>


</form>

<?
include("includes/footer.php");
?>