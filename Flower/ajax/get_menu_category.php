<?php
require_once('../myconfig/config.php');
$rest_id = $_POST['rest_id'];
?>
     <select class="selectbx" name="menu_category" id="menu_category" onchange="otherSpecify('category');getShowAddons(this.value);" >
<?php	 
if($rest_id){
?>
						<?php 
						$sql=mysql_query("SELECT `cat_id`,`cat_name` FROM ".$prev."category WHERE status='Y' and rest_id='".$rest_id."'");
						if(mysql_num_rows($sql)){
						  while($row=mysql_fetch_object($sql)){
						  ?>
								 <option value="<?php echo $row->cat_id;?>"><?php echo $row->cat_name;?></option>  
						  <?php 
						  }
						  mysql_free_result($sql);
						}else 
						 {
						?>
							     <option value="" id="addCatMenu">Select</option>
					             <option value="other" id="categoryOther" onclick="otherSpecify('category');">Others</option>
					   <?php
						 }
						?>		
<?php         
}else
 {
 ?>
                                 <option value="" id="addCatMenu">Select</option>
					             <option value="other" id="categoryOther" onclick="otherSpecify('category');">Others</option>
<?php 
 }
?>
</select>	