<?php
require_once('../myconfig/config.php');
//echo 'sdfad';

$state_id=$_POST['state_id'];
if($state_id){


?>
<script>
$(document).ready(function(){
	$('#city_id').change(function(){
		var city_id=$(this).val(); 
	  // var id=$(this).attr("id");
	  var dataString='city_id='+city_id;
				 $.ajax({
					type:"POST",
					data:dataString,
					url:"<?=$vpath?>ajax/get_zip.php",
					success:function(return_data)
					{
						$('#ajax_zip').html(return_data);
					}
				});
		});	
	})
</script>


	<select class="selectbx" name="city_id" id="city_id">
			<option value="">--Select City--</option>
						<?php 
						$sql=mysql_query("SELECT `city_id`,`city_name` FROM ".$prev."city WHERE status='Y' and state_id='".$state_id."'");
						if(mysql_num_rows($sql)){
						  while($row=mysql_fetch_object($sql)){?>
								<option value="<?= $row->city_id?>"><?= $row->city_name?></option>  
						  <?php }
						  mysql_free_result($sql);
						}
						?>
	</select>
<?php 	} else {?>

		<select class="selectbx" name="city_id" id="city_id">
		<option value="">--Select State--</option>     
		</select>


<?php }?>