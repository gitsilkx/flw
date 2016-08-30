<?php
require_once('../myconfig/config.php');
//echo 'sdfad';

$city_id=$_POST['city_id'];
$state_id=$_POST['state_id'];
 $zip_id=$_POST['zip_id'];

if($_SESSION['admin_id']){


?>


	
            <?php //if($delivery_code){
        
						$sql=mysql_query("SELECT `id`,`delivery_code` FROM ".$prev."delivery_code WHERE status='Y' AND state_id=".$state_id." AND city_id=".$city_id." AND zip_id=".$zip_id."");
						if(mysql_num_rows($sql)){
						  while($row=mysql_fetch_object($sql)){?>
                          <input type="checkbox" value="<?= $row->delivery_code?>" name="delivery_code[]" /><?= $row->delivery_code?>
								
						  <?php }
						  mysql_free_result($sql);
						}
		//	}?>
					
      

<?php 	}
else if($_SESSION['rest_id']){ 
		$sql=mysql_query("SELECT `id`,`delivery_code` FROM ".$prev."delivery_code WHERE status='Y' AND state_id=".$state_id." AND city_id=".$city_id." AND zip_id=".$zip_id."");
						if(mysql_num_rows($sql)){
						  while($row=mysql_fetch_object($sql)){?>
                          <input type="checkbox" value="<?= $row->delivery_code?>" name="delivery_code" /><?= $row->delivery_code?>
								
						  <?php }
						  mysql_free_result($sql);
						}
      
 }else {	
 $sql=mysql_query("SELECT `id`,`delivery_code` FROM ".$prev."delivery_code WHERE status='Y' AND state_id=".$state_id." AND city_id=".$city_id." AND zip_id=".$zip_id."");
						if(mysql_num_rows($sql)){
						  while($row=mysql_fetch_object($sql)){?>
                          <input type="checkbox" value="<?= $row->delivery_code?>" name="delivery_code[]" /><?= $row->delivery_code?>
								
						  <?php }
						  mysql_free_result($sql);
						}
						
			 }?>