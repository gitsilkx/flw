<?php
session_start();
include("includes/access.php");
include("includes/header.php");
if(isset($_GET['banner_id']))
		{
			$offer_id=$_GET['banner_id'];
			$sql="SELECT * FROM ".$prev."banner WHERE banner_id='".$banner_id."'";
			$result=mysql_query($sql);
			$row=mysql_fetch_object($result);
			$banner_id=$row->banner_id;
			$banner_size=$row->banner_size;
			$banner_subtitle=$row->banner_subtitle;
			$banner=$row->banner;
			$status=$row->status;
		}
if(isset($_POST['BANNER']))
{
	
	$status=mysql_real_escape_string($_POST['status']);
	if($_POST['banner_id']=="")
	{	
		$sql_banner_insert=mysql_query("INSERT INTO ".$prev."banner SET 
		banner_id='".mysql_real_escape_string($_POST['banner_id'])."',
		banner_size='".mysql_real_escape_string($_POST['banner_size'])."',
		banner_subtitle='".mysql_real_escape_string($_POST['banner_subtitle'])."',
		banner='".mysql_real_escape_string($_POST['banner'])."',
		status='".$status."'");
		if($sql_banner_insert)
		{
		$_SESSION['succ_message']="Banner Inserted Successfully !!";
		pageRedirect('banner_list.php?menuid=131&menupid=131');
		}
	}
	if($_POST['banner_id']!="")
	{
		
		$sql_banner_update=mysql_query("UPDATE ".$prev."banner SET
		 banner_id='".mysql_real_escape_string($_POST['banner_id'])."',
		 banner_size='".mysql_real_escape_string($_POST['banner_size'])."',
		 banner_subtitle='".mysql_real_escape_string($_POST['banner_subtitle'])."',
		 banner='".mysql_real_escape_string($_POST['banner'])."',
		 status='".$status."' 
		 WHERE banner_id=".$_POST['banner_id']);
		if($sql_banner_update)
		{
		$_SESSION['succ_message']="Banner Updated Successfully !!";
		pageRedirect('banner_list.php?menuid=131&menupid=131');
		}
	}
}

	if($r)
	{	
		if($_FILES['file'][name]!="")
		{
			
			$ext=substr($_FILES['file'][name],-3,3); 
			@copy($_FILES['file'][tmp_name],"../banner_upload/" . $id . "." . $ext);
			$up="update " . $prev . "banner set banner='banners/". $id . "." . $ext."' where id=$id";
			mysql_query($up);	
		}
	    $msg="Banner has been added/updated successfully.";
    }
    else
    {
	    $msg="Some error occurred, please try again.";
	
	}

?>
<script>
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

<SCRIPT language=javascript> 
<!--

  function formValidate() {
  if(document.form1.subtitle.value == "" )
  {
  	alert('Website Title is required!');
	document.form1.subtitle.focus();
  	return false;
  }
	if ( (document.form1.url.value == "http://")  || (document.form1.url.value == "") )
	 {
      alert('Website Url is required!');
		document.form1.url.focus();   
	   return false;
	   }

       /* if( (document.form1.bannerurl.value == "http://") || (document.form1.bannerurl.value == "") )
		{
	   alert('Banner url is required.');
	   document.form1.bannerurl.focus();
           return false; 
           }*/
		   
		   
		   if (document.form1.credits.value==''  || isNaN(document.form1.credits.value) || document.form1.credits.value<=0  )
{
	alert("Please provide some non-negative numeric value  for credits");
	document.form1.credits.focus();
	return (false);
}
if (isNaN(document.form1.displays.value) || document.form1.displays.value<0  )
{
	alert("Please provide some non-negative numeric value for displays");
	document.form1.displays.focus();
	return (false);
}

	return true;
  }
// -->

</SCRIPT>
<? if($msg):
   echo $msg;
endif;
if($_REQUEST[id]):
	$sql=mysql_query("select * from " . $prev . "banner  where banner_id=" . $_REQUEST["banner_id"]);
	$data=mysql_fetch_array($sql);
endif;	
?>
<div class="adminRight">
<div class="rightContHeading Heading"> Add New Banner</div>
<div class="rightContBody">
	<div class="riteContWrap1">
		<div id="errormsg"></div>
		<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>
 <form name="addNewResOffr" method="post" action="" onsubmit=" return addRestaurantOfferValidate(); " >
			<input type="hidden" name="offer_id" id="banner_id" value="<?=$_GET['banner_id']?>"><div class="addPageCont">
					<span class="addPageRightFont">Title<span class="color1">*</span></span>
					<span class="colon1">:</span>
					<INPUT name="subtitle" class="textbox" value="<? echo $data["subtitle"];?>" maxLength=120 style='width:300px'>
					<script type="text/javascript">document.addNewResOffr.offer_percentage.focus();</script>
					<div class="tooltip"><div class="HelpButton" title="Enter restaurant offer percentage">?</div></div>
					<!--<input type="hidden" name="offer_id" id="offer_id" value="" />-->
                    <span class="errClass" id="resNamePerErr"></span>
			</div>
            
            <div class="addPageCont">
					<span class="addPageRightFont">Website Url<span class="color1">*</span></span>
					<span class="colon1">:</span>
					<INPUT name=url class="textbox" value="<?=$data['link']?>" style='width:300px'
                        maxLength=120>
					<div class="tooltip"><div class="HelpButton" title="Enter restaurant offer price">?</div></div>
                    <span class="errClass" id="resNamePriErr"></span>
			</div>
            <div class="addPageCont">
					<span class="addPageRightFont">Banner Size<span class="color1">*</span></span>
					<span class="colon1">:</span>
					<select name="size" class="lnk" style='width:300px'>
							<option value="">Select Size</option>
							<option value="790x80" <?php if($data['size']=="790x80") echo "selected='selected'"  ?> >Top</option>
							<option value="250x250" <?php if($data['size']=="250x250") echo "selected='selected'"  ?> >Side Panel</option>
							<option value="200x200" <?php if($data['size']=="200x200") echo "selected='selected'"  ?> >Bottom</option>
					</select>
					<div class="tooltip"><div class="HelpButton" title="Enter restaurant offer price">?</div></div>
                    <span class="errClass" id="resNamePriErr"></span>
			</div>
            <div class="addPageCont">
					<span class="addPageRightFont">Select Banner Image<span class="color1">*</span></span>
					<span class="colon1">:</span>
					<input type="file" name="file" />
					<div class="tooltip"><div class="HelpButton" title="Enter restaurant offer price">?</div></div>
                    <span class="errClass" id="resNamePriErr"></span>
</div>
<div class="addPageCont">
                <span class="addPageRightFont">Status </span>
                <span class="colon1">:</span>
                <span class="radioBtn">
                <span class="labelcont"><input type="radio" class="radiobotton" name="status" id="yes" <?php echo  $selectedy; ?> value="Y"  /><label class="labelfont" for="yes">&nbsp;Yes</label> </span>	
                <span class="labelcont"><input type="radio" class="radiobotton" name="status" <?php echo  $selectedn; ?> id="no" value="N"  /><label class="labelfont" for="no">&nbsp;No</label></span>
                </span>
                <div class="tooltip"><div class="HelpButton" title="Select any one restaurant pickup option">?</div></div>
            </div>
            <div class="buttonCont2">
				<input type="submit" class="button" name="BANNER" value="<?=($_GET['banner_id']!="")?"Update":"Add"?>" >
				<a class="CanceButton" href="banner_entry.php&menuid=131&menupid=131">Cancel</a>
				<!--<a class="CanceButton" href="javascript:void(0);" onclick="tb_remove()">Cancel</a>-->
			</div>
            </form>
            </div>
         </div>
      </div>

<?


include("includes/footer.php");
?>