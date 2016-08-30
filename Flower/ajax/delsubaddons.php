<?php
require_once('../myconfig/config.php');
//echo 'sdfad';

$sub_addons_id=$_POST['sub_addons_id'];
$addons_id=$_POST['addons_id'];
$del=mysql_query("delete from ".$prev."sub_addons where sub_addons_id=".$sub_addons_id);
if($del){
	$res_addons=mysql_query("select * from ".$prev."sub_addons where addons_id='".$addons_id."' order by sub_addons_name");
?>
<?php
					$i=0;
					while($row_addons=mysql_fetch_array($res_addons))
					{
						$i++;
					?>
                    <div id="content" style="" align='center'>
					<input  type='text' id='<?=$i?>' name='subaddons[]' value="<?=$row_addons['sub_addons_name']?>"/>
                    <input  type='text' id='<?=$i?>' name='subaddonsprice[]' value="<?=$row_addons['sub_addons_price']?>"/>
                    <input  type='hidden' id='addons_id<?=$i?>'  value="<?=$row_addons['addons_id']?>"/>
                    <input  type='hidden' id='sub_addons_id<?=$i?>'  value="<?=$row_addons['sub_addons_id']?>"/>
                    &nbsp;<a href='javascript:delsubAddons(<?=$i?>)'  style='text-decoration:none;' >Remove</a>&nbsp;
                    <span id='msgs<?=$i?>' style="padding-left:22px;"></span></div>
                    <?php
					}
					?>


<?php } ?>