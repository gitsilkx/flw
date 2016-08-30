<?php
session_start();
include("includes/access.php");
include("includes/header.php");
if(isset($_GET['offer_id']))
		{
			$offer_id=$_GET['offer_id'];
			$sql="SELECT * FROM ".$prev."offer WHERE offer_id='".$offer_id."'";
			$result=mysql_query($sql);
			$row=mysql_fetch_object($result);
			$rest_id=$row->rest_id;
			$offer_percentage=$row->offer_percentage;
			$offer_price=$row->offer_price;
			$offer_valid_from=date("m/d/Y",strtotime($row->offer_valid_from));
			$offer_valid_to=date("m/d/Y",strtotime($row->offer_valid_to));
			$offer_desc=$row->offer_desc;
			$status=$row->status;
		}
if(isset($_POST['OFFER']))
{
	$offer_valid_from= date("Y-m-d",strtotime(mysql_real_escape_string($_POST['offer_valid_from'])));
	$offer_valid_to= date("Y-m-d",strtotime(mysql_real_escape_string($_POST['offer_valid_to'])));
	$status=mysql_real_escape_string($_POST['status']);
	if($_POST['offer_id']=="")
	{	
		$sql_offer_insert=mysql_query("INSERT INTO ".$prev."offer SET rest_id='".mysql_real_escape_string($_POST['rest_id'])."',offer_percentage='".mysql_real_escape_string($_POST['offer_percentage'])."',offer_price='".mysql_real_escape_string($_POST['offer_price'])."',offer_valid_from='".$offer_valid_from."',offer_valid_to='".$offer_valid_to."',offer_desc='".txt_value($_POST['offer_desc'])."',cur_date=CURDATE(),status='".$status."'");
		if($sql_offer_insert)
		{
		$_SESSION['succ_message']="Restaurant Offer Data Inserted Successfully !!";
		pageRedirect('manage_offer.php?menuid=107&menupid=103');
		}
	}
	
	if($_POST['offer_id']!="")
	{
		
		$sql_offer_update=mysql_query("UPDATE ".$prev."offer SET rest_id='".mysql_real_escape_string($_POST['rest_id'])."',offer_percentage='".mysql_real_escape_string($_POST['offer_percentage'])."',offer_price='".mysql_real_escape_string($_POST['offer_price'])."',offer_valid_from='".$offer_valid_from."',offer_valid_to='".$offer_valid_to."',offer_desc='".txt_value($_POST['offer_desc'])."',cur_date=CURDATE(),status='".$status."' WHERE offer_id=".$_POST['offer_id']);
		if($sql_offer_update)
		{
		$_SESSION['succ_message']="Restaurant Offer Data Updated Successfully !!";
		pageRedirect('manage_offer.php?menuid=107&menupid=103');
		}
	}
}
//By 10.09.13
if($_REQUEST['offer_id'])
{
	$offer_id = $_REQUEST['offer_id'];
	$offer_sql = mysql_query("SELECT * FROM ".$prev."offer WHERE 
	offer_id =".$offer_id);
	$result = mysql_fetch_array($offer_sql);	
	
	$rest_id=$result['rest_id'];
}

if($_REQUEST['rest_id']){
	$rest_id=$_REQUEST['rest_id'];
}
//end
?>
 <script>
$(function() {
$( "#offer_valid_from" ).datepicker();
$( "#offer_valid_to" ).datepicker();
});
function addRestaurantOfferValidate() {
	//alert('aaaaaa');
	var txt = '';
	if(document.getElementById('rest_id').value == "") {
			$("#resNameOfferErr").html("Please select Restaurant Name");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNameOfferErr").html("");
	}
	if(document.getElementById('offer_percentage').value == "") {
			$("#resNamePerErr").html("Please enter Offer Percentage");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNamePerErr").html("");
	}
	if(document.getElementById('offer_price').value == "") {
			$("#resNamePriErr").html("Please enter Offer Price");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNamePriErr").html("");
	}
	if(document.getElementById('offer_valid_from').value == "") {
			$("#resNameValFroErr").html("Please enter Valid From");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNameValFroErr").html("");
	}
	if(document.getElementById('offer_valid_to').value == "") {
			$("#resNameValToErr").html("Please enter Valid To");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNameValToErr").html("");
	}
	if(document.getElementById('offer_desc').value == "") {
			$("#resNameValToErr").html("Please enter Offer Description");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNameValToErr").html("");
	}
	if(txt != "") {
		//alert("Hello guest, the following fields are mandatory:-\n\n" + txt);
		return false;
	}
}
<!-------------------- Tooltip---------->
		$(function() {
$( document ).tooltip();
});
</script>
 <div class="adminRight">
<div class="rightContHeading Heading"> Add New Restaurant Offer</div>
<div class="rightContBody">
	<div class="riteContWrap1">
		<div id="errormsg"></div>
		<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>
		<form name="addNewResOffr" method="post" action="" onsubmit=" return addRestaurantOfferValidate(); " >
			<input type="hidden" name="offer_id" id="offer_id" value="<?=$_GET['offer_id']?>">
			<!--<input type="hidden" name="resid" id="resid" value="">
			<input type="hidden" name="action" value="Add">-->
									<div class="addPageCont">
				<span class="addPageRightFont">Restaurant <!--<a href="manage_offer.php">manage_offer</a>-->Name <span class="color1">*</span></span>
				<span class="colon1">:</span>
                <? 	$select_resturant=mysql_query("SELECT rest_id,rest_name FROM ".$prev."restaurant");?>
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
				<div class="tooltip"><div class="HelpButton" title="Select restaurant Name">?</div>
                </div>
                <span class="errClass" id="resNameOfferErr"></span>
			</div>
						
			<div class="addPageCont">
					<span class="addPageRightFont">Offer Percentage <span class="color1">*</span></span>
					<span class="colon1">:</span>
					<input class="textbox" type="text" name="offer_percentage" id="offer_percentage" value="<?=$offer_percentage?>" />
					<script type="text/javascript">document.addNewResOffr.offer_percentage.focus();</script>
					<div class="tooltip"><div class="HelpButton" title="Enter restaurant offer percentage">?</div></div>
					<!--<input type="hidden" name="offer_id" id="offer_id" value="" />-->
                    <span class="errClass" id="resNamePerErr"></span>
			</div>
			
			<div class="addPageCont">
					<span class="addPageRightFont">Offer Price<span class="color1">*</span></span>
					<span class="colon1">:</span>
					<input class="textbox" type="text" name="offer_price" id="offer_price" value="<?=$offer_price?>" />
					<div class="tooltip"><div class="HelpButton" title="Enter restaurant offer price">?</div></div>
                    <span class="errClass" id="resNamePriErr"></span>
			</div>
			
			<div class="addPageCont">
					<span class="addPageRightFont">Valid From <span class="color1">*</span></span>
					<span class="colon1">:</span>
					<input class="offerCaltextbox" name="offer_valid_from" id="offer_valid_from" type="text" value="<?=$offer_valid_from?>" />
					<div class="realtive">
						<div class="absolute1">
							<div class="tooltip"><div class="HelpButton" title="Select restaurant valid offer from">?</div></div>
						</div>
					</div>
                    <span class="errClass" id="resNameValFroErr"></span>
			</div>

			
			<div class="addPageCont">
					<span class="addPageRightFont">Valid To <span class="color1">*</span></span>
					<span class="colon1">:</span>
					<input class="offerCaltextbox" name="offer_valid_to" id="offer_valid_to" type="text" value="<?=$offer_valid_to?>" />
					<div class="realtive">
						<div class="absolute1">
							<div class="tooltip"><div class="HelpButton" title="Select restaurant valid offer to">?</div></div>
						</div>
					</div>
                    <span class="errClass" id="resNameValToErr"></span>
			</div>
			
			<div class="addPageCont">
					<span class="addPageRightFont">Offer Description<span class="color1">*</span></span>
					<span class="colon1">:</span>
					<textarea class="textbox" name="offer_desc" id="offer_desc" style="height:107px; width:246px;"><?=txt_value_output($offer_desc)?></textarea>
					<div class="tooltip"><div class="HelpButton" title="Enter restaurant offer description">?</div></div>
                    <span class="errClass" id="resNamePriErr"></span>
			</div>
            
            <div class="addPageCont">
                <span class="addPageRightFont">Status </span>
                <span class="colon1">:</span>
                <span class="radioBtn">
                <span class="labelcont"><input class="radiobotton" type="radio" name="status" id="restaurant_pickup_yes" value="Y"  <?=($status=='Y')?'checked':''?> checked="checked"/><label class="labelfont" for="yes">&nbsp;Yes</label> </span>	
                <span class="labelcont"><input class="radiobotton" type="radio" name="status" id="restaurant_pickup_no" value="N"<?=($status=='N')?'checked':''?>  /><label class="labelfont" for="no">&nbsp;No</label></span>
                </span>
                <div class="tooltip"><div class="HelpButton" title="Select any one restaurant pickup option">?</div></div>
            </div>
			
			<div class="buttonCont2">
				<input type="submit" class="button" name="OFFER" value="<?=($_GET['offer_id']!="")?"Update":"Add"?>" >
				<a class="CanceButton" href="restaurantOfferManage.php">Cancel</a>
				<!--<a class="CanceButton" href="javascript:void(0);" onclick="tb_remove()">Cancel</a>-->
			</div>
		</form>
	</div>
</div>
</div>

<?
include("includes/footer.php");
?>
