<?php
session_start();
include("includes/access.php");
include("includes/header.php");
$msg="";
if($_REQUEST[COUSINE])
{
$cuisine_desc=htmlentities($_REQUEST[cuisine_desc]);
	if(!$_REQUEST['cuisine_id'])
	{
		
	    $insert_query = "insert into " .TABLE_CUISINE." set 
		cuisine_name='" . $_REQUEST['cuisine_name'] .  "',
		cuisine_desc='".$cuisine_desc."',	
		cuisine_status='".$_REQUEST['cuisine_status']."'";		
		
		$r=mysql_query($insert_query);
		$cuisine_id=mysql_insert_id();
	}
   	else
	{
   		$upd_query = "update " .TABLE_CUISINE." set 
		cuisine_name='" . $_REQUEST['cuisine_name'] .  "',
		cuisine_desc='".$cuisine_desc."',		
		cuisine_status='".$_REQUEST['cuisine_status']."'
		where cuisine_id='".$_REQUEST['cuisine_id']."'	";
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
		
		$cuisine_id=$_REQUEST['cuisine_id'];
	   
	}
	
   	   if($_FILES[cuisine_image][name]!="")

	   {
		 	 $ext=substr($_FILES[cuisine_image][name],-3,3);

			 copy($_FILES[cuisine_image][tmp_name],"../cuisine_image/" . $cuisine_id . "." . $ext);

             mysql_query("update " . TABLE_CUISINE . " set cuisine_image='cuisine_image/" . $cuisine_id . "." . $ext . "' where cuisine_id=" . $cuisine_id);


	   }
	   if($cuisine_id){
		  $_SESSION['succ_message']="Cuisine Updated Successfully !!";
		  pageRedirect('couisine.list.php?menuid=119&menupid=117');   
	   }
	   else
	   {
		  $_SESSION['err_message']="Cuisine Updated Unsuccessfully !!";
		  pageRedirect('couisine.list.php?menuid=119&menupid=117');   
	
	   }

   pageRedirect('couisine.list.php?menuid=119&menupid=117');
 }	
#if product exists /fetch data
if($_REQUEST['cuisine_id'])
{
	$cuisine_id=$_REQUEST['cuisine_id'];
	$r=mysql_query("select * from ".TABLE_CUISINE." where cuisine_id=" . $cuisine_id);
	$d=@mysql_fetch_array($r);
	
}

if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;

?>
 <script>

function addCousineOfferValidate() {
	//alert('aaaaaa');
	var txt = '';
	if(document.getElementById('cuisine_name').value == "") {
			$("#resNameOfferErr").html("Please select Restaurant Name");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNameOfferErr").html("");
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
		<form name="addNewResOffr" method="post" action="" onsubmit=" return addCousineOfferValidate(); " >
			<input type="hidden" name="offer_id" id="offer_id" value="<?=$_GET['offer_id']?>">
			<!--<input type="hidden" name="resid" id="resid" value="">
			<input type="hidden" name="action" value="Add">-->
									
						
			<div class="addPageCont">
					<span class="addPageRightFont">Cuisine Name<span class="color1">*</span></span>
					<span class="colon1">:</span>
                    <input name="cuisine_name" class="textbox" type="text" id="cuisine_name" value="<?=$d['cuisine_name']?>"  >
					
					<script type="text/javascript">document.addNewResOffr.offer_percentage.focus();</script>
					<div class="tooltip"><div class="HelpButton" title="Enter Cuisine Name">?</div></div>
					<!--<input type="hidden" name="offer_id" id="offer_id" value="" />-->
                    <span class="errClass" id="resNameOfferErr"></span>
			</div>
			
			<div class="addPageCont">
					<span class="addPageRightFont">Cuisine Photo</span>
					<span class="colon1">:</span>
					<input name="cuisine_image" type="file" class="textbox" id="cuisine_image">
                         	<?php
								if($d[cuisine_image]!="")
								{
								?>
								<img src="<?=$vpath?>viewimage.php?img=<?=$d[cuisine_image]?>&size=80" />
								</p>
								<?php
								}
								?>
					<div class="tooltip"><div class="HelpButton" title="Select Cuisiine Photo">?</div></div>
                    <span class="errClass" id="resNamePriErr"></span>
			</div>
			
			<div class="addPageCont">
					<span class="addPageRightFont">Description <span class="color1">&nbsp;</span></span>
					<span class="colon1">:</span>
					<?php
// Make sure you are using correct paths here.
include_once '../ckeditor/ckeditor.php';
include_once '../ckfinder/ckfinder.php';
 
$ckeditor = new CKEditor();
$ckeditor->basePath = '../ckeditor/';
$ckfinder = new CKFinder();
$ckfinder->BasePath = '../ckfinder/'; // Note: the BasePath property in the CKFinder class starts with a capital letter.
$ckfinder->SetupCKEditorObject($ckeditor);
$ckeditor->editor('cuisine_desc',html_entity_decode($d[cuisine_desc]));
?>
					<div class="realtive">
						
					</div>
                    <span class="errClass" id="resNameValFroErr"></span>
			</div>

			
			
            
            <div class="addPageCont">
                <span class="addPageRightFont">Status </span>
                <span class="colon1">:</span>
                <span class="radioBtn">
                <span class="labelcont"><input class="radiobotton" type="radio" name="cuisine_status" id="restaurant_pickup_yes" value="Y"  <?=($d[cuisine_status]=='Y')?'checked':''?> checked="checked"/><label class="labelfont" for="yes">&nbsp;Yes</label> </span>	
                <span class="labelcont"><input class="radiobotton" type="radio" name="cuisine_status" id="restaurant_pickup_no" value="N"<?=($d[cuisine_status]=='N')?'checked':''?>  /><label class="labelfont" for="no">&nbsp;No</label></span>
                </span>
                <div class="tooltip"><div class="HelpButton" title="Select any one restaurant pickup option">?</div></div>
            </div>
			
			<div class="buttonCont2">
				<input type="submit" class="button" name="COUSINE" value="<?=($_GET['cuisine_id']!="")?"Update":"Add"?>" >
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
