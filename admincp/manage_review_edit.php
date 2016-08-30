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

	if(document.getElementById('review').value == "") {
			$("#resNamePerErr").html("Please enter Review");
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
if($_REQUEST['id']!="")
{
	$id=$_REQUEST['id'];
	$r=mysql_query("SELECT rev.id,rev.user_id,rev.rest_id,rev.review,rev.status,rev.cur_date,res.rest_name FROM ".$prev."review as rev LEFT JOIN ".$prev."restaurant as res ON rev.rest_id = res.rest_id  where id='$id'");
	
	$d=mysql_fetch_array($r);

}

	if(isset($_REQUEST['submit']))
	{
		$update=mysql_query("UPDATE ".$prev."review SET review='".$_REQUEST['review']."' WHERE id=".$_REQUEST['id']);
		if(update)
		{
		$_SESSION['succ_message']="Review Updated Successfully !!";
		pageRedirect('manage_review.php?menuid=110&menupid=103');
		}
	}

 // start By 10.09.13
if($_REQUEST['rest_id']){
	$rest_id=$_REQUEST['rest_id'];
}
// end


?>

	<div class="adminRight">
<div class="rightContHeading Heading"> Edit Review for " <?=$d['rest_name']?> "</div>
<div class="rightContBody">
	<div class="riteContWrap1">
		<div id="errormsg"></div>
		<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>
		<form name="addNewResOffr" method="post" action="" onsubmit=" return addRestaurantValidate(); " >
			<input type="hidden" name="cat_id" id="cat_id" value="<?=$_GET['cat_id']?>">
			<!--<input type="hidden" name="resid" id="resid" value="">
			<input type="hidden" name="action" value="Add">-->

			<div class="addPageCont">
					<span class="addPageRightFont" style="width:170px;">Review<span class="color1">*</span></span>
					<span class="colon1">:</span>
			  <textarea class="textbox" name="review" id="review" style="width:246px; height:118px;"><?=$d['review']?></textarea>
					<script type="text/javascript">document.addNewResOffr.review.focus();</script>
					<div class="tooltip"><div class="HelpButton" title="Edit Review here">?</div></div>
                    <span class="errClass" id="resNamePerErr"></span>
			</div>
		
			<div class="buttonCont2">
			  <input type="submit" class="button" name="submit" value="Update" style="margin-left:275px; margin-top:10px;">
				<a class="CanceButton" href="manage_review_edit.php?&menuid=110&menupid=103">Cancel</a>
				<!--<a class="CanceButton" href="javascript:void(0);" onclick="tb_remove()">Cancel</a>-->
			</div>
		</form>
	</div>
</div>
</div>
<?
include("includes/footer.php");
?>
