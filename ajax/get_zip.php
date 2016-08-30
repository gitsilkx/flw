<?php
require_once('../myconfig/config.php');
//echo 'sdfad';

$city_id=$_POST['city_id'];
if($city_id){

?>
<script>
$(document).ready(function(){
		$('#zip_id').change(function(){
		//alert('sdf');
		var zip_id=$(this).val(); 
		var state_id=$('#state_id').val();
		var city_id=$('#city_id').val();
		//alert(state_id);
		
	  	var dataString='state_id='+state_id+'&city_id='+city_id+'&zip_id='+zip_id;
		//alert(dataString);
				 $.ajax({
					type:"POST",
					data:dataString,
					url:"<?=$vpath?>ajax/get_delivery_code.php",
					success:function(return_data)
					{
						
						$('#ajax_deliver_code').html(return_data);
					}
				});
			
		});

	})
</script>

	<select class="selectbx" name="zip_id" id="zip_id">
			<option value="">Select</option>
						<?php 
						$sql=mysql_query("SELECT `zip_id`,`area_name`,`zip_code` FROM ".$prev."zip WHERE status='Y' and city_id='".$city_id."'");
						if(mysql_num_rows($sql)){
						  while($row=mysql_fetch_object($sql)){?>
								<option value="<?= $row->zip_id?>"><?= $row->zip_code.' - '.$row->area_name;?></option>  
						  <?php }
						  mysql_free_result($sql);
						}
						?>
	</select>
<?php 	} else {?>

		<select class="selectbx" name="zip_id" id="zip_id" >
			<option value="">First Select City</option>
           					</select>
      
<?php }?>