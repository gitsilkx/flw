<?php
require_once("../configs/path.php");
	$id=$_REQUEST['id'];
	function getNode($id)
	{
		$sql="select * from ".TABLE_ATTRIBUTES." where pid ='$id'";
		$res=mysql_query($sql);
		if(mysql_num_rows($res)!=0)
		{
			while($row=mysql_fetch_array($res))
			{
				
				$sqlck="select * from ".TABLE_ATTRIBUTES." where pid ='".$row['attributes_id']."'";
				$resck=mysql_query($sqlck);
				if(mysql_num_rows($resck)==0)
				{
				?>
				<tr class="lnk" bgcolor="#ffffff">
<td width="33%" bgcolor="#e9e9e9" style="padding:3px; "><b><?=$row['attributes_name']?>  :</b></td>
<td width="67%" style="padding:3px; ">
<input name="attributes_name_<?=$row['attributes_id']?>" type="text" id="attributes_name_<?=$row['attributes_id']?>" class="lnk" value="" size="40" >
<input type="hidden" name="attributes_array[]"  value="<?=$row['attributes_id']?>">
</td>
</tr>
				<?
				}
				else
				{
				?>
				<tr class="lnk" bgcolor="#ffffff">
<td width="33%" bgcolor="#e9e9e9" style="padding:3px; "><b><?=$row['attributes_name']?>  :</b></td>
<td width="67%" style="padding:3px; ">&nbsp;
</td>
</tr>
					<?
				}
				
				
				getNode($row['attributes_id']);
				
			}
		}
		
	}

?>
<table width="100%" border="0" align="left"  cellpadding="4" cellspacing="4" style="padding:0px; margin:0px;">
<?
	getNode($id);
?>
</table>