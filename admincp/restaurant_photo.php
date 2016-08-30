<?php 
if(isset($_GET['rest_id']))
		{
			$rest_id=$_GET['rest_id'];
			//$_SESSION['rest_id']=$rest_id;
			$sql="SELECT * FROM ".$prev."resturant_photo WHERE rest_id='".$rest_id."'";
			$result=mysql_query($sql);
			$row=mysql_fetch_object($result);
			$restaurant_dispphoto=$row->rest_disp_photo;
			$restaurant_dispvideo=$row->rest_disp_video;
			$restaurant_dispbanner=$row->rest_disp_banner;
		} 
if(isset($_POST['REST_PHOTO']) && $_POST['REST_PHOTO']!='')
{
	if($_GET['rest_id']=="")
				{
$rest_id=$_SESSION['rest_id'];		
$sql_insert="INSERT INTO ".$prev."resturant_photo SET rest_disp_photo='".mysql_real_escape_string($_POST['rest_disp_photo'])."',rest_disp_video='".mysql_real_escape_string($_POST['rest_disp_video'])."',rest_disp_banner='".mysql_real_escape_string($_POST['rest_disp_banner'])."',rest_id=".$rest_id;
$result=mysql_query($sql_insert);
if($result)
				   {
						    ?>
                        <script>
						$(function() {
						//$( "#tabs" ).tabs();
						$("#tabs").tabs({disabled: [0,1,2,3,5]});
						$("#tabs").tabs( "enable" , 4 ); 
						$('#tabs').tabs({ active: 4 });
						});
						</script>
                         <?php 
					 }
				}
	if($_GET['rest_id']<>"")
	{
$count_rows=mysql_num_rows(mysql_query("SELECT * FROM ".$prev."resturant_photo WHERE rest_id=".$_SESSION['rest_id']));
if($count_rows==0)
{
	$sql_insert="INSERT INTO ".$prev."resturant_photo SET rest_disp_photo='".mysql_real_escape_string($_POST['rest_disp_photo'])."',rest_disp_video='".mysql_real_escape_string($_POST['rest_disp_video'])."',rest_disp_banner='".mysql_real_escape_string($_POST['rest_disp_banner'])."',rest_id=".$_GET['rest_id'];
$result=mysql_query($sql_insert);
}
else
{
$sql_update="UPDATE ".$prev."resturant_photo SET rest_disp_photo='".mysql_real_escape_string($_POST['rest_disp_photo'])."',rest_disp_video='".mysql_real_escape_string($_POST['rest_disp_video'])."',rest_disp_banner='".mysql_real_escape_string($_POST['rest_disp_banner'])."',rest_id=".$rest_id." WHERE rest_id=".$_GET['rest_id'];
$result=mysql_query($sql_update);
}
if($result)
				   {
						    ?>
                        <script>
						$(function() {
						//$( "#tabs" ).tabs();
						//$("#tabs").tabs({disabled: [0,1,2,3,5]});
						$("#tabs").tabs( "enable" , 4 ); 
						$('#tabs').tabs({ active: 4 });
						});
						</script>
                         <?php 
					 }
				
	}
}

?>

<form name="addNewRestaurantPhoto" method="post" action="" onsubmit="" enctype="">

<div class="restInnerTab">
<!--Restaurant Photos-->
<!--<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>-->

		
	<div class="addPageCont">
		<span class="addPageRightFont">Display photos</span>
		<span class="colon1">:</span>
		<span class="radioBtn">
			<span class="labelcont"><input class="radiobotton" type="radio" name="rest_disp_photo" id="restaurant_display_photo_yes" value="Yes"  <?=($restaurant_dispphoto=='Yes')?'checked':''?>/><label class="labelfont" for="restaurant_display_photo_yes">&nbsp;Yes</label> </span>
			
			<span class="labelcont"><input class="radiobotton" type="radio" name="rest_disp_photo" id="restaurant_display_photo_no" value="No"  <?=($restaurant_dispphoto=='No')?'checked':''?>/><label class="labelfont" for="restaurant_display_photo_no">&nbsp;No</label> </span>
		</span>
	</div>
	
	<div class="photoDispOpt"  style="display:none;" >
		<div class="photoDispOpt" id="photoDispOpt" >
			<div class="addPageCont">
				<label class="addPageRightFont">Restaurant Photo1 </label>
				<span class="colon1">:</span>
				<div class="photoUpload">
					<div class="Photo">
						<input class="fileUpload" type="file" name="restaurant_photos1" id="restaurant_photos1" size="25" />
					</div>
				</div>
			<div class="tooltip"><div class="HelpButton">?</div><span>Upload restaurant photo1</span></div>
							
			</div>
			<span class="errClass" id="resPhoErr"></span>
		</div>
		
		<div class="photoDispOpt" id="photoDispOpt2" >
			<div class="addPageCont">
				<label class="addPageRightFont">Restaurant Photo2 </label>
				<span class="colon1">:</span>
				<div class="photoUpload">
					<div class="Photo">
						<input class="fileUpload" type="file" name="restaurant_photos2" id="restaurant_photos2" size="25" />
						<!---->
					</div>
				</div>
			<div class="tooltip"><div class="HelpButton">?</div><span>Upload restaurant photo2</span></div>
				
			</div>
		</div>
		
		<div class="photoDispOpt" id="photoDispOpt3" >
			<div class="addPageCont">
				<label class="addPageRightFont">Restaurant Photo3 </label>
				<span class="colon1">:</span>
				<div class="photoUpload">
					<div class="Photo">
						<input class="fileUpload" type="file" name="restaurant_photos3" id="restaurant_photos3" size="25" />
					</div>
				</div>
			<div class="tooltip"><div class="HelpButton">?</div><span>Upload restaurant photo3</span></div>
				
			</div>
		</div>
		
		<div class="photoDispOpt" id="photoDispOpt4" >
			<div class="addPageCont">
				<label class="addPageRightFont">Restaurant Photo4 </label>
				<span class="colon1">:</span>
				<div class="photoUpload">
					<div class="Photo">
						<input class="fileUpload" type="file" name="restaurant_photos4" id="restaurant_photos4" size="25" />
					</div>
				</div>
			<div class="tooltip"><div class="HelpButton">?</div><span>Upload restaurant photo4</span></div>
				
			</div>
		</div>
	</div>
	
	<!--<div class="mapDispOpt" id="mapDispOpt" style="display: none;">
		<div class="addPageCont">
			<label class="addPageRightFont">Restaurant Map <span class="color1">*</span></label>
			<span class="colon1">:</span>
			<div class="map">
				<div class="map">
						<textarea class="addPageTxtArea" name="restaurant_map" id="map" /></textarea>		
						<span class="errClass" id="resMapErr"></span>
				</div>
			</div>
			<div class="tooltip"><div class="HelpButton">?</div><span>Restaurant Map</span></div>
		</div>
	</div>-->
	
	<div class="addPageCont">
		<span class="addPageRightFont">Display Videos</span>
		<span class="colon1">:</span>
		<span class="radioBtn">
			<span class="labelcont"><input class="radiobotton" type="radio" name="rest_disp_video" id="restaurant_display_video_yes" value="Yes"  <?=($restaurant_dispvideo=='Yes')?'checked':''?>/><label class="labelfont" for="restaurant_display_video_yes">&nbsp;Yes</label> </span>
			
			<span class="labelcont"><input class="radiobotton" type="radio" name="rest_disp_video" id="restaurant_display_video_no" value="No"  <?=($restaurant_dispvideo=='No')?'checked':''?>/><label class="labelfont" for="restaurant_display_video_no">&nbsp;No</label> </span>
		</span>
	</div>
	
	<div class="videoDispOpt" id="videoDispOpt"  style="display: none;" >
		<div class="addPageCont">
			<label class="addPageRightFont">Restaurant Video </label>
			<span class="colon1">:</span>
			<div class="vid">
				<div class="vid">
						<textarea class="addPageTxtArea" name="restaurant_video" id="vid" /></textarea>		
						<span class="errClass" id="resVideoErr"></span>
				</div>
			</div>
			<div class="tooltip"><div class="HelpButton">?</div><span>Restaurant Video</span></div>
		</div>
	</div>
	
	<!--<div class="addPageCont">
		<span class="addPageRightFont">Market Banner</span>
		<span class="colon1">:</span>
		<span class="radioBtn">
			<span class="labelcont"><input class="radiobotton" type="radio" name="restaurant_market_banner" id="restaurant_banner_img" value="img" checked="checked" /><label class="labelfont" for="restaurant_banner_img">&nbsp;Image</label> </span>
			<span class="labelcont"><input class="radiobotton" type="radio" name="restaurant_market_banner" id="restaurant_banner_code" value="code"  /><label class="labelfont" for="restaurant_banner_code">&nbsp;Code</label></span>
		</span>
	</div>-->
	
	<div class="addPageCont">
		<span class="addPageRightFont">Display Banners</span>
		<span class="colon1">:</span>
		<span class="radioBtn">
			<span class="labelcont"><input class="radiobotton" type="radio" name="rest_disp_banner" id="restaurant_display_banner_yes" value="Yes"  <?=($restaurant_dispbanner=='Yes')?'checked':''?>/><label class="labelfont" for="restaurant_display_banner_yes">&nbsp;Yes</label> </span>
			
			<span class="labelcont"><input class="radiobotton" type="radio" name="rest_disp_banner" id="restaurant_display_banner_no" value="No"  <?=($restaurant_dispbanner=='No')?'checked':''?>/><label class="labelfont" for="restaurant_display_banner_no">&nbsp;No</label> </span>
		</span>
	</div>
	
	<div class="bannerDispOpt" id="marketbannerimageOpt"  style="display:none;" >
		<div class="addPageCont">
			<label class="addPageRightFont">Market Banner Image </label>
			<span class="colon1">:</span>
			<div class="photoUpload">
				<div class="Photo">
					<input class="fileUpload" type="file" name="market_ban_image" id="market_ban_image" size="25" />
				</div>
			</div>
			<span class="errClass" id="resBannerErr"></span>
		<div class="tooltip"><div class="HelpButton">?</div><span>Upload Market Banner Image</span></div>
			
		</div>
	</div>
	
	<!--<div id="marketbannercodeOpt"  style="display: none;" >
		<div class="addPageCont">
			<label class="addPageRightFont">Market Banner Code<span class="color1">*</span></label>
			<span class="colon1">:</span>
			<div class="vid">
				<div class="vid">
						<textarea class="addPageTxtArea" name="market_ban_code" id="market_ban_code" /></textarea>		
						<span class="errClass" id="resBannerCodeErr"></span>
				</div>
			</div>
			<div class="tooltip"><div class="HelpButton">?</div><span>Upload Market Banner Code</span></div>
		</div>
	</div>-->
	
</div>
 <div class="buttonCont_restaurant">
			<input type="submit" class="button" value="<?=($rest_id!=0)?'Update':'Add'?>" name="REST_PHOTO"> 
			<a class="CanceButton" href="restaurantManage.php">Cancel</a>
		</div>
		</form>