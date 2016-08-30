<?php
include("includes/access.php");
include("includes/header_pop.php");

$product_type_id=$_REQUEST['product_type_id'];

$msg="";
if($_REQUEST[Update])
{
    mysql_query("delete from " . $prev. "product_type_rel where product_type_id=" . $_REQUEST['product_type_id']);
    for($i=0;$i<$_POST[tot];$i++):
		$v="attirbutes_id" . $i;
		if($_POST[$v]):
			$insert_query = mysql_query("insert into " . $prev. "product_type_rel set 
			attributes_id=" . $_POST[$v] .  ",product_type_id=" . $_REQUEST['product_type_id']);
			
		endif;	
	endfor; 
    echo"<script>window.opener.location.reload();</script><p align=center>Update successful</p>";
 }	

?>
<br />
	<form method="post" name="attribute_entry" action="<?=$_SERVER['PHP_SELF']?>">
	<input type="hidden" name="product_type_id" value="<?=$product_type_id?>">

<table id="table-1" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
<thead><tr><td  height="25" width=80%><b>Name</b></td><td align=right><input type=submit name='Update' value='Update'></td></tr></thead>
<tbody>
		<?
		
		$r=mysql_query("select * from ".TABLE_ATTRIBUTES." where  pid='0'   order by attributes_id");
	
		$j=0;
		while($d=@mysql_fetch_array($r)):
			if(!($j%2)){$class="even";}else{$class="odd";}
			$chk = @mysql_num_rows(mysql_query("select * from  " . $prev. "product_type_rel where attributes_id='" . $d['attributes_id'] .  "' and product_type_id='" . $_REQUEST['product_type_id'] .  "'"));

			?>
			<tr  class="<?=$class?>"><td  colspan=2><input type=checkbox name="attirbutes_id<?=$j?>" value="<?=$d['attributes_id']?>" <?if($chk){echo"checked";}?>> <?=$d['attributes_name']?></td></tr>
		    <?	
		$j++; 
	endwhile;   	
		?>
	</tbody>
</table>
<input type=hidden name=tot value=<?=$j?>>
</form>
<p align=center><a href="javascript:;" onclick="closeAndReload()">Close and reload parent</a></p>
</body></html>
