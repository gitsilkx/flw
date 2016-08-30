<?php
include("includes/access.php");
include("includes/header.php");

$pid=($_REQUEST['pid']=='')?0:$_REQUEST['pid'];
?>
<form name="form1" method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
		<td class="header"><a href="attribute.list.php" class="header">Cron List  &nbsp;</a>
	    <input type="button" class="button" onClick="javascritp:window.location.href='cron.php?pid=<?=$pid?>'" value="Cron Start">		</td><td width="40%" align="right">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr class="lnk">
					<td>
					<select name="parama" size="1" class="lnk">
						<option value="cron_id" <? if($_REQUEST['parama']=="cron_id"){echo" selected";}?>>ID</option>						
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
		<td  height="25"><b>Report</b></td> 
                <td  height="25"><b>Add Report</b></td>
                <td  height="25"><b>Delete Report</b></td>		
		<td  width="20%" align="center"><b>Date</b></td>
		</tr>
	</thead>
	<tbody>
		<?
		
		$r=mysql_query("select * from ".$prev."cron where  1   order by cron_id");
	    //echo"select * from ".TABLE_SUPPLIERS." where  pid='0'   order by attributes_id";
		$total=@mysql_num_rows($r);
		if(!$total):
   			?>
				<tr class='lnkred'><td colspan='5' align='center'>No record found.</td></tr>
			<?
		endif;
		$j=0;
		while($d=@mysql_fetch_array($r)):
			
    		if(!($j%2)){$class="even";}else{$class="odd";}			
			?>
			<tr class="even">
				<td><?=$d['cron_id']?></td>
				<td><a href='<?= $vpath?>uploads/<?=$d['report1']?>' download class='lnk'><?=$d['report1']?></a></td>
                                <td><a href='<?= $vpath?>uploads/<?=$d['report2']?>' download class='lnk'><?=$d['report2']?></a></td>
                                <td><a href='<?= $vpath?>uploads/<?=$d['report3']?>' download class='lnk'><?=$d['report3']?></a></td>                             
				<td width="20%" align="center"><?=$d['cron_date']?></td>				
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