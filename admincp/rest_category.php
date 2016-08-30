<?php
include("includes/access.php");
include("includes/header.php");

?>
 
	<!--Script for validation-->
	
	<script language="javascript">
		
		
		
			<!--Script for validation-->

function addRestaurantValidate() {
	//alert('aaaaaa');
	var txt = '';
	if(document.getElementById('rest_id').value == "") {
			$("#resNameOfferErr").html("Please select Restaurant Name");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNameOfferErr").html("");
	}
	if(document.getElementById('cat_name').value == "") {
			$("#resNamePerErr").html("Please select Category Name");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNamePerErr").html("");
	}
	
	if(txt != "") {
		//alert("Hello guest, the following fields are mandatory:-\n\n" + txt);
		return false;
	}
}
			
			$(function() {
$( document ).tooltip();
});
		</script>

<?php



if(isset($_GET['cat_id']))
		{
			$cat_id=$_GET['cat_id'];
			$sql="SELECT * FROM ".$prev."category WHERE cat_id='".$cat_id."'";
			$result=mysql_query($sql);
			$row=mysql_fetch_object($result);
			$rest_id=$row->rest_id;
			$cat_name=$row->cat_name;
			$cat_option=$row->cat_option;
			$status=$row->status;
			
		}
if(isset($_POST['category_id']))
{
	$status=mysql_real_escape_string($_POST['status']);
	if($_POST['cat_id']=="")
	{	
		$sql_cat_insert=mysql_query("INSERT INTO ".$prev."category SET 
		rest_id='".mysql_real_escape_string($_POST['rest_id'])."',
		cat_name='".mysql_real_escape_string($_POST['cat_name'])."',
		cat_option='".mysql_real_escape_string($_POST['cat_option'])."',
		cur_date=CURDATE(),
		status='".$status."'");
		if($sql_cat_insert)
		{
		$_SESSION['succ_message']="Category  Data Inserted Successfully !!";
		pageRedirect('category.type.list.php?menuid=122&menupid=120');
		}
	}
	if($_POST['cat_id']!="")
	{
		
		$sql_cat_update=mysql_query("UPDATE ".$prev."category SET 
		rest_id='".mysql_real_escape_string($_POST['rest_id'])."',
		cat_name='".mysql_real_escape_string($_POST['cat_name'])."',
		cat_option='".mysql_real_escape_string($_POST['cat_option'])."',
		cur_date=CURDATE(),
		status='".$status."' WHERE cat_id=".$_POST['cat_id']);
		if($sql_cat_update)
		{
		$_SESSION['succ_message']="Category  Data Updated Successfully !!";
		pageRedirect('category.type.list.php?menuid=122&menupid=120');
		}
	}
}
if($_REQUEST['cat_id'])
{
	$cat_id=$_REQUEST['cat_id'];
	$r=mysql_query("select * from ".$prev."category where cat_id=" . $cat_id);
	$d=@mysql_fetch_array($r);
	
	$rest_id=$d['rest_id'];//by 10.09.13
}
 // start By 10.09.13
if($_REQUEST['rest_id']){
	$rest_id=$_REQUEST['rest_id'];
}
// end


?>

	<div class="adminRight">
<div class="rightContHeading Heading"> Add New Category</div>
<div class="rightContBody">
	<div class="riteContWrap1">
		<div id="errormsg"></div>
		<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>
		<form name="addNewResOffr" method="post" action="" onsubmit=" return addRestaurantValidate(); " >
			<input type="hidden" name="cat_id" id="cat_id" value="<?=$_GET['cat_id']?>">
			<!--<input type="hidden" name="resid" id="resid" value="">
			<input type="hidden" name="action" value="Add">-->

<div class="addPageCont">
				<span class="addPageRightFont">Restaurant <!--<a href="manage_offer.php">manage_offer</a>-->Name <span class="color1">*</span></span>
				<span class="colon1">:</span>
               <? $select_resturant=mysql_query("SELECT * FROM ".$prev."restaurant  ORDER BY rest_name"); ?>
				<select class="selectbx" name="rest_id" id="rest_id" <?php if($_REQUEST['rest_id']){?> disabled="disabled" <?php }?> >
				<option value="">--Select Resturant--</option>
                <?php
				
				$count_resturant=mysql_num_rows($select_resturant);
				if($count_resturant>0)
				{
					while($row_resturant=mysql_fetch_array($select_resturant))
					{
				?>
                <option value="<?=$row_resturant['rest_id']?>" <? if($row_resturant['rest_id']==$rest_id){?> selected="selected" <? }?>><?=$row_resturant['rest_name']?></option>
                <?php
					}
				}
				?>
									
								</select>
				<div class="tooltip"><div class="HelpButton" title="Select Restaurant Name">?</div>
                </div>
                <span class="errClass" id="resNameOfferErr"></span>
			</div>


			<div class="addPageCont">
					<span class="addPageRightFont">Main Category Name<span class="color1">*</span></span>
					<span class="colon1">:</span>
			  <input class="textbox" type="text" name="cat_name" id="cat_name" value="<?=$cat_name?>" />
					<script type="text/javascript">document.addNewResOffr.cat_name.focus();</script>
					<div class="tooltip"><div class="HelpButton" title="Enter Category Name">?</div></div>
					<!--<input type="hidden" name="offer_id" id="offer_id" value="" />-->
                    <span class="errClass" id="resNamePerErr"></span>
			</div>
			<!--<div class="addPageCont">
                <span class="addPageRightFont">Category Option </span>
                <span class="colon1">:</span>
                <span class="radioBtn">
                <span class="labelcont">
                <input class="radiobotton" type="radio" name="cat_option" id="restaurant_pickup_normal" value="1"  <?=($cat_option=='1')?'checked':''?> checked="checked"/><label class="labelfont" for="yes">&nbsp;Normal</label> </span>	
                <span class="labelcont"><input class="radiobotton" type="radio" name="cat_option" id="restaurant_pickup_pizza" value="2"<?=($cat_option=='2')?'checked':''?>  /><label class="labelfont" for="no">&nbsp;Pizza</label></span>
                </span>
                <div class="tooltip"><div class="HelpButton" title="Select Any One   Pickup Option">?</div></div>
            </div>-->
			<div class="addPageCont"> <span class="addPageRightFont">Status </span> <span class="colon1">:</span> <span class="radioBtn"> <span class="labelcont">
			  <input class="radiobotton" type="radio" name="status" id="restaurant_pickup_yes" value="Y"  <?=($status=='Y')?'checked':''?> checked="checked"/>
			  <label class="labelfont" for="yes2">&nbsp;Yes</label>
			  </span> <span class="labelcont">
			    <input class="radiobotton" type="radio" name="status" id="restaurant_pickup_no" value="N"<?=($status=='N')?'checked':''?>  />
			    <label class="labelfont" for="no2">&nbsp;No</label>
			    </span> </span>
			  <div class="tooltip">
			    <div class="HelpButton" title="Select Any One  Pickup Option">?</div>
			    </div>
		  </div>
			<div class="buttonCont2">
			  <input type="submit" class="button" name="category_id" value="<?=($_GET['Update']!="")?"Update":"Add"?>" >
				<a class="CanceButton" href="rest_category.php?&menuid=121&menupid=120">Cancel</a>
				<!--<a class="CanceButton" href="javascript:void(0);" onclick="tb_remove()">Cancel</a>-->
			</div>
		</form>
	</div>
</div>
</div>
<?
include("includes/footer.php");
?>
