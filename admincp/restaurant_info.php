<?php 

if(isset($_GET['rest_id']))
		{
			$rest_id=$_GET['rest_id'];
			$_SESSION['rest_id']=$rest_id;
			$sql="SELECT * FROM ".$prev."resturant_info WHERE rest_id='".$rest_id."'";
			$result=mysql_query($sql);
			$row=mysql_fetch_object($result);
			$restaurant_logo=$row->rest_logo;
			$restaurant_info=$row->rest_info;
			$restaurant_pickup=$row->rest_pickup;
			$restaurant_booktable=$row->rest_booktable;
			$restaurant_time_open=$row->rest_time_open;
			$restaurant_time_close=$row->rest_time_close;
			$restaurant_order=$row->rest_order;
			$restaurant_tax=$row->rest_tax;
			$restaurant_cuisine=$row->rest_cuisine;
		}
if(isset($_POST['REST_INFO']) && $_POST['REST_INFO']!='')
{
if($_GET['rest_id']=="")
				{
$rest_id=$_SESSION['rest_id'];	
$ur = "../logo_upload/";
if($_POST['rest_cuisine']!="")
{
$rest_cuisine=implode(",",$_POST['rest_cuisine']);
}

$sql_insert="INSERT INTO ".$prev."resturant_info SET rest_info='".mysql_real_escape_string($_POST['rest_info'])."',
rest_pickup='".mysql_real_escape_string($_POST['rest_pickup'])."',rest_booktable='".mysql_real_escape_string($_POST['rest_booktable'])."',rest_time_open='".mysql_real_escape_string($_POST['rest_time_open'])."',rest_time_close='".mysql_real_escape_string($_POST['rest_time_close'])."',rest_order=".mysql_real_escape_string($_POST['rest_order']).",rest_tax=".mysql_real_escape_string($_POST['rest_tax']).",rest_cuisine='".$rest_cuisine."',rest_id=".$rest_id;
$result=mysql_query($sql_insert);

if($_POST['rest_time_open']=='Open')
{
	$day=$_POST['day'];
	$restaurant_delivery_open_hr=$_POST['restaurant_delivery_open_hr'];
	$restaurant_delivery_open_min=$_POST['restaurant_delivery_open_min'];
	$restaurant_delivery_open_sess=$_POST['restaurant_delivery_open_sess'];
	$time=array();
	if (!empty($restaurant_delivery_open_hr)){
		//echo count($restaurant_delivery_open_hr);
	for($i=0;$i<count($restaurant_delivery_open_hr);$i++)
	 {
		$time[$i] = $restaurant_delivery_open_hr[$i]." : ".$restaurant_delivery_open_min[$i]." : ".$restaurant_delivery_open_sess[$i];
		if($restaurant_delivery_open_hr[$i]!='')
		{
			$sql_insert_date=mysql_query("INSERT INTO ".$prev."resturant_days SET rest_id='".$rest_id."',action='".$_REQUEST['rest_time_open']."',day='".$day[$i]."',time='".$time[$i]."'");
		}
	 }
	}
}
if($_POST['rest_time_close']=='Close')
{
	$day=$_POST['day'];
	$restaurant_delivery_close_hr=$_POST['restaurant_delivery_close_hr'];
	$restaurant_delivery_close_min=$_POST['restaurant_delivery_close_min'];
	$restaurant_delivery_close_sess=$_POST['restaurant_delivery_close_sess'];
	$time=array();
	if (!empty($restaurant_delivery_close_hr)){
		//echo count($restaurant_delivery_open_hr);
	for($i=0;$i<count($restaurant_delivery_close_hr);$i++)
	 {
		$time[$i] = $restaurant_delivery_close_hr[$i]." : ".$restaurant_delivery_close_min[$i]." : ".$restaurant_delivery_close_sess[$i];
		if($restaurant_delivery_close_hr[$i]!='')
		{
			$sql_insert_date=mysql_query("INSERT INTO ".$prev."resturant_days SET rest_id='".$rest_id."',action='".$_REQUEST['rest_time_close']."',day='".$day[$i]."',time='".$time[$i]."'");
		}
	 }
	}
}
//header('location:add_restaurant.php?menuid=104&menupid=103#tabs-2');

if(is_uploaded_file($_FILES['rest_logo']['tmp_name']))
   {
    $image=explode('.',$_FILES["rest_logo"]["name"]);
    $s=$ur.$rest_id.".".end($image);
    //$pathToThumbs=$ur_thumb.$product_id.".".end($image);
    if(move_uploaded_file($_FILES['rest_logo']['tmp_name'] , $s ))
    {
    // createThumbnail( $s, $pathToThumbs, 72 , 71 );
     $image=$rest_id.".".end($image);
     @mysql_query("UPDATE " . $prev . "resturant_info SET rest_logo='".$image."' WHERE rest_id=".$rest_id);
     //unlink($s);
    }
   }
if($result)
				   {
						    ?>
                        <script>
						$(function() {
						//$( "#tabs" ).tabs();
						$("#tabs").tabs({disabled: [0,1,3,4,5]});
						$("#tabs").tabs( "enable" , 2 ); 
						$('#tabs').tabs({ active: 2 });
						});
						</script>
                         <?php 
					 }
			}
				else if($_GET['rest_id']<>"")
			{
	$ur = "../logo_upload/";
	if($_POST['rest_cuisine']!="")
	{
	$rest_cuisine=implode(",",$_POST['rest_cuisine']);
	}
	/*if($_POST['rest_cuisine']!="")
	{*/
	$sql_update="UPDATE ".$prev."resturant_info SET rest_info='".mysql_real_escape_string($_POST['rest_info'])."',
	rest_pickup='".mysql_real_escape_string($_POST['rest_pickup'])."',rest_booktable='".mysql_real_escape_string($_POST['rest_booktable'])."',rest_time_open='".mysql_real_escape_string($_POST['rest_time_open'])."',rest_time_close='".mysql_real_escape_string($_POST['rest_time_close'])."',rest_order=".mysql_real_escape_string($_POST['rest_order']).",rest_tax=".mysql_real_escape_string($_POST['rest_tax']).",rest_cuisine='".$rest_cuisine."',rest_id=".$rest_id." WHERE rest_id=".$_GET['rest_id'];
	$result=mysql_query($sql_update);
			if($_POST['rest_time_open']=='Open')
			{
				$del=mysql_query("DELETE FROM ".$prev."resturant_days WHERE rest_id='".$_GET['rest_id']."' AND action='Open'");
				if($del){
					$day=$_POST['day'];
					$restaurant_delivery_open_hr=$_POST['restaurant_delivery_open_hr'];
					$restaurant_delivery_open_min=$_POST['restaurant_delivery_open_min'];
					$restaurant_delivery_open_sess=$_POST['restaurant_delivery_open_sess'];
					$time=array();
				if (!empty($restaurant_delivery_open_hr)){
			//echo count($restaurant_delivery_open_hr);
		for($i=0;$i<count($restaurant_delivery_open_hr);$i++)
		 {
			$time[$i] = $restaurant_delivery_open_hr[$i]." : ".$restaurant_delivery_open_min[$i]." : ".$restaurant_delivery_open_sess[$i];
			if($restaurant_delivery_open_hr[$i]!='')
			{
				$sql_insert_date=mysql_query("INSERT INTO ".$prev."resturant_days SET rest_id='".$rest_id."',action='".$_REQUEST['rest_time_open']."',day='".$day[$i]."',time='".$time[$i]."'");
			}
		 }
		}
					}
			}
			if($_POST['rest_time_close']=='Close')
			{
				$del=mysql_query("DELETE FROM ".$prev."resturant_days WHERE rest_id='".$_GET['rest_id']."' AND action='Close'");
				if($del){
					$day=$_POST['day'];
					$restaurant_delivery_close_hr=$_POST['restaurant_delivery_close_hr'];
					$restaurant_delivery_close_min=$_POST['restaurant_delivery_close_min'];
					$restaurant_delivery_close_sess=$_POST['restaurant_delivery_close_sess'];
					$time=array();
			if (!empty($restaurant_delivery_close_hr)){
			//echo count($restaurant_delivery_open_hr);
		for($i=0;$i<count($restaurant_delivery_close_hr);$i++)
		 {
			$time[$i] = $restaurant_delivery_close_hr[$i]." : ".$restaurant_delivery_close_min[$i]." : ".$restaurant_delivery_close_sess[$i];
			if($restaurant_delivery_close_hr[$i]!='')
			{
				$sql_insert_date=mysql_query("INSERT INTO ".$prev."resturant_days SET rest_id='".$rest_id."',action='".$_REQUEST['rest_time_close']."',day='".$day[$i]."',time='".$time[$i]."'");
			}
		 }
		}
					}
			}
	if(is_uploaded_file($_FILES['rest_logo']['tmp_name']))
	   {
		$image=explode('.',$_FILES["rest_logo"]["name"]);
		$s=$ur.$rest_id.".".end($image);
		//$pathToThumbs=$ur_thumb.$product_id.".".end($image);
		if(move_uploaded_file($_FILES['rest_logo']['tmp_name'] , $s ))
		{
		// createThumbnail( $s, $pathToThumbs, 72 , 71 );
		 $image=$rest_id.".".end($image);
		 @mysql_query("UPDATE " . $prev . "resturant_info SET rest_logo='".$image."' WHERE rest_id=".$_GET['rest_id']);
		 //unlink($s);
		}
	   
	}
	if($result)
					   {
								?>
							<script>
							$(function() {
							//$( "#tabs" ).tabs();
							//$("#tabs").tabs({disabled: [0,1,3,4,5]});
							$("#tabs").tabs( "enable" , 2 ); 
							$('#tabs').tabs({ active: 2 });
							});
							</script>
							 <?php 
						 }
			
	}
}
/*if($_GET['rest_id']<>"")
        {
$count_rows=mysql_num_rows(mysql_query("SELECT * FROM ".$prev."resturant_info WHERE rest_id=".$_SESSION['rest_id']));
if($count_rows==0)
{
$rest_id=$_SESSION['rest_id'];	
$ur = "../logo_upload/";
if($_POST['rest_cuisine']!="")
{
$rest_cuisine=implode(",",$_POST['rest_cuisine']);
}
$sql_insert="INSERT INTO ".$prev."resturant_info SET rest_info='".mysql_real_escape_string($_POST['rest_info'])."',
rest_pickup='".mysql_real_escape_string($_POST['rest_pickup'])."',rest_booktable='".mysql_real_escape_string($_POST['rest_booktable'])."',rest_time_open='".mysql_real_escape_string($_POST['rest_time_open'])."',rest_time_close='".mysql_real_escape_string($_POST['rest_time_close'])."',rest_order=".mysql_real_escape_string($_POST['rest_order']).",rest_tax=".mysql_real_escape_string($_POST['rest_tax']).",rest_cuisine='".$rest_cuisine."',rest_id=".$_GET['rest_id'];
$result=mysql_query($sql_insert);

if($_POST['rest_time_open']=='Open')
{
	$day=$_POST['day'];
	$restaurant_delivery_open_hr=$_POST['restaurant_delivery_open_hr'];
	$restaurant_delivery_open_min=$_POST['restaurant_delivery_open_min'];
	$restaurant_delivery_open_sess=$_POST['restaurant_delivery_open_sess'];
	$time=array();
	if (!empty($restaurant_delivery_open_hr)){
		//echo count($restaurant_delivery_open_hr);
	for($i=0;$i<count($restaurant_delivery_open_hr);$i++)
	 {
		$time[$i] = $restaurant_delivery_open_hr[$i]." : ".$restaurant_delivery_open_min[$i]." : ".$restaurant_delivery_open_sess[$i];
		if($restaurant_delivery_open_hr[$i]!='')
		{
			$sql_insert_date=mysql_query("INSERT INTO ".$prev."resturant_days SET rest_id='".$rest_id."',action='".$_REQUEST['rest_time_open']."',day='".$day[$i]."',time='".$time[$i]."'");
		}
	 }
	}
}
if($_POST['rest_time_close']=='Close')
{
	$day=$_POST['day'];
	$restaurant_delivery_close_hr=$_POST['restaurant_delivery_close_hr'];
	$restaurant_delivery_close_min=$_POST['restaurant_delivery_close_min'];
	$restaurant_delivery_close_sess=$_POST['restaurant_delivery_close_sess'];
	$time=array();
	if (!empty($restaurant_delivery_close_hr)){
		//echo count($restaurant_delivery_open_hr);
	for($i=0;$i<count($restaurant_delivery_close_hr);$i++)
	 {
		$time[$i] = $restaurant_delivery_close_hr[$i]." : ".$restaurant_delivery_close_min[$i]." : ".$restaurant_delivery_close_sess[$i];
		if($restaurant_delivery_close_hr[$i]!='')
		{
			$sql_insert_date=mysql_query("INSERT INTO ".$prev."resturant_days SET rest_id='".$rest_id."',action='".$_REQUEST['rest_time_close']."',day='".$day[$i]."',time='".$time[$i]."'");
		}
	 }
	}
}
//header('location:add_restaurant.php?menuid=104&menupid=103#tabs-2');

if(is_uploaded_file($_FILES['rest_logo']['tmp_name']))
   {
    $image=explode('.',$_FILES["rest_logo"]["name"]);
    $s=$ur.$rest_id.".".end($image);
    //$pathToThumbs=$ur_thumb.$product_id.".".end($image);
    if(move_uploaded_file($_FILES['rest_logo']['tmp_name'] , $s ))
    {
    // createThumbnail( $s, $pathToThumbs, 72 , 71 );
     $image=$rest_id.".".end($image);
     @mysql_query("UPDATE " . $prev . "resturant_info SET rest_logo='".$image."' WHERE rest_id=".$rest_id);
     //unlink($s);
    }
   }
}*/

?>
<style>
h1{
	font-size:180%;
	font-weight:normal;
	color:#555;
}
h2{
	clear:both;
	font-size:160%;
	font-weight:normal;
	color:#555;
	margin:0;
	padding:.5em 0;
}
a{
	text-decoration:none;
	color:#f30;	
}
p{
	clear:both;
	margin:0;
	padding:.5em 0;
}
pre{
	display:block;
	font:100% "Courier New", Courier, monospace;
	padding:10px;
	border:1px solid #bae2f0;
	background:#e3f4f9;	
	margin:.5em 0;
	overflow:auto;
	width:800px;
}

img{border:none;}
ul,li{
	margin:0;
	padding:0;
}
li{
	list-style:none;
	float:left;
	display:inline;
	margin-right:10px;
}



/*  */

#screenshot{
	position:absolute;
	border:1px solid #ccc;
	background:#333;
	padding:5px;
	display:none;
	color:#fff;
	}

/*  */
</style>
<script>
function selectAllOpeningTime()
{
	if(document.getElementById('selectopen').checked==true)
	{
		for(var k=0;k<7;k++)
		{
				document.getElementById('restaurant_delivery_open_hr'+k).disabled=false;
				document.getElementById('restaurant_delivery_open_min'+k).disabled=false;
				document.getElementById('restaurant_delivery_open_sess'+k).disabled=false;
			
		}
	}
	if(document.getElementById('selectopen').checked==false)
	{
		for(var k=0;k<7;k++)
		{
				document.getElementById('restaurant_delivery_open_hr'+k).disabled=true;
				document.getElementById('restaurant_delivery_open_hr'+k).selectedIndex = 0;
				document.getElementById('restaurant_delivery_open_min'+k).disabled=true;
				document.getElementById('restaurant_delivery_open_min'+k).selectedIndex = 0;
				document.getElementById('restaurant_delivery_open_sess'+k).disabled=true;
				document.getElementById('restaurant_delivery_open_sess'+k).selectedIndex = 0;
			
		}
	}
}
function selectAllCloseingTime()
{
	if(document.getElementById('selectclose').checked==true)
	{
		for(var k=0;k<7;k++)
		{
				document.getElementById('restaurant_delivery_close_hr'+k).disabled=false;
				document.getElementById('restaurant_delivery_close_min'+k).disabled=false;
				document.getElementById('restaurant_delivery_close_sess'+k).disabled=false;
			
		}
	}
	if(document.getElementById('selectclose').checked==false)
	{
		for(var k=0;k<7;k++)
		{
				document.getElementById('restaurant_delivery_close_hr'+k).disabled=true;
				document.getElementById('restaurant_delivery_close_hr'+k).selectedIndex = 0;
				document.getElementById('restaurant_delivery_close_min'+k).disabled=true;
				document.getElementById('restaurant_delivery_close_min'+k).selectedIndex = 0;
				document.getElementById('restaurant_delivery_close_sess'+k).disabled=true;
				document.getElementById('restaurant_delivery_close_sess'+k).selectedIndex = 0;
			
		}
	}
}
function addRestaurantInfoValidate() {
	var txt = '';
	if(document.getElementById('rest_info').value == "") {
			$("#resAbtResErr").html("Please enter About Restaurant");
			txt ='err';
		}else{
			$("#resAbtResErr").html("");
	}
	if(document.getElementById('rest_order').value == "") {
			$("#resMinOrdErr").html("Please enter Min Order");
			txt ='err';
		}else{
			$("#resMinOrdErr").html("");
	}
	if(document.getElementById('rest_tax').value == "") {
			$("#resSalTaxErr").html("Please enter Sales Tax(%)");
			txt ='err';
		}else{
			$("#resSalTaxErr").html("");
	}
	if(txt != "") {
		//alert("Hello guest, the following fields are mandatory:-\n\n" + txt);
		return false;
	}
}
</script>
	<form name="addNewRestaurantInfo" method="post" action=""  onsubmit="return addRestaurantInfoValidate();" enctype="multipart/form-data">
		 <input type="hidden" name="rest_id" id="rest_id" value="<?=$rest_id?>">
<div class="restInnerTab">
	<!--Restaurant Logo-->
	<!--<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>-->
	<div class="addPageCont">
			<label class="addPageRightFont">Restaurant Logo </label>
			<span class="colon1">:</span>
			<div class="logoUpload">
				<!--<div class="logo">
					<input type="file" name="restaurant_logo" id="restaurant_logo" size="30" />
										<span class="errClass" id="resLogoErr"></span>
				</div>-->
				<!--<div class="logo" style="width:250px;">-->
					<input class="fileUpload" type="file" name="rest_logo" id="rest_logo" size="25" />
				<!--</div>-->
			</div>
			<div class="tooltip"><div class="HelpButton" title="Upload restaurant logo">?</div> &nbsp;
            <?php if($restaurant_logo<>""){?>
            <!--<img src="<?=$vpath?>logo_upload/<?=$restaurant_logo?>" width="80" height="80" border="1" />-->
            <img src="<?=$vpath?>viewimage.php?img=logo_upload/<?=$restaurant_logo?>&size=50" border="1" />
            <?php }else { ?>
            <img src="<?=$vpath?>admincp/images/none.jpg" width="80" height="80" border="1" />
            <?php } ?>
            </div>
			<div class="errClass" id="resLogoErr"></div>
				</div>	
	<!--About Restaurant-->
	<div class="addPageCont">
		<span class="addPageRightFont">About Restaurant <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<textarea class="addPageTxtArea" name="rest_info" id="rest_info" /><?=$restaurant_info?></textarea>
		<div class="tooltip"><div class="HelpButton" title="Enter details about restaurant">?</div></div>
		<span class="errClass" id="resAbtResErr"></span>
	</div>
	<!--Restaurant Estimated Time-->
	<!--<div class="addPageCont">
		<span class="addPageRightFont">Restaurant delivery estimated time <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="restaurant_estimated_time" id="restaurant_estimated_time" value="" />
		<div class="tooltip"><div class="HelpButton">?</div><span>Enter restaurant delivery estimated time</span></div>
		<span class="errClass" id="resEstTimeErr"></span>
	</div>-->
	<!--Restaurant Delivery-->
	<!--<div class="addPageCont">
		<span class="addPageRightFont">Delivery <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<span class="radioBtn">
		<span class="labelcont"><input class="radiobotton" type="radio" name="restaurant_delivery" id="restaurant_delivery_yes" value="Yes" checked="checked" /><label class="labelfont" for="yes">&nbsp;Yes</label> </span>	
		<span class="labelcont"><input class="radiobotton" type="radio" name="restaurant_delivery" id="restaurant_delivery_no" value="No"  /><label class="labelfont" for="no">&nbsp;No</label></span>
		</span>
		<div class="tooltip"><div class="HelpButton">?</div><span>Select any one restaurant dlivery option</span></div>
	</div>-->
	
	<!--Restaurant Pickup-->
	<div class="addPageCont">
		<span class="addPageRightFont">Pickup </span>
		<span class="colon1">:</span>
		<span class="radioBtn">
		<span class="labelcont"><input class="radiobotton" type="radio" name="rest_pickup" id="restaurant_pickup_yes" value="Yes"  <?=($restaurant_pickup=='Yes')?'checked':''?>/><label class="labelfont" for="yes">&nbsp;Yes</label> </span>	
		<span class="labelcont"><input class="radiobotton" type="radio" name="rest_pickup" id="restaurant_pickup_no" value="No"<?=($restaurant_pickup=='No')?'checked':''?>  /><label class="labelfont" for="no">&nbsp;No</label></span>
		</span>
		<div class="tooltip"><div class="HelpButton" title="Select any one restaurant pickup option">?</div></div>
	</div>
	
	<!--Restaurant Book Table-->
	<!--<div class="addPageCont">
		<span class="addPageRightFont">Book Table </span>
		<span class="colon1">:</span>
		<span class="radioBtn">
		<span class="labelcont"><input class="radiobotton" type="radio" name="rest_booktable" id="restaurant_booktable_yes" value="Yes"  <?=($restaurant_booktable=='Yes')?'checked':''?>/><label class="labelfont" for="yes">&nbsp;Yes</label> </span>	
		<span class="labelcont"><input class="radiobotton" type="radio" name="rest_booktable" id="restaurant_booktable_no" value="No" <?=($restaurant_booktable=='No')?'checked':''?> /><label class="labelfont" for="no">&nbsp;No</label></span>
		</span><span class="errClass" id="resBookTableErr"></span>
		<div class="tooltip"><div class="HelpButton" title="Select any one restaurant book table option">?</div></div>
	</div>-->
	
	<!--Restaurant Delivery Hrs-->
	<div class="addPageCont">
		<span class="addPageRightFont">Opening &amp; Closing Time </span>
		<span class="colon1">:</span>
		<!-- <input class="textbox" type="text" name="restaurant_delivery_hrs" id="restaurant_delivery_hrs" value="" />-->
		<span class="DeliveryHrs">Opening Time<span class="DeliverHrs_Font"><input type="checkbox" name="rest_time_open" id="selectopen" onClick="selectAllOpeningTime();" value="Open" <?=($restaurant_time_open=='Open')?'checked':''?>/></span><span class="DeliverHrs_Font">Select All</span><span id="resSelectAllOpenErr"></span></span>
		<span class="DeliveryHrs">Closing Time<span class="DeliverHrs_Font"><input type="checkbox" id="selectclose" name="rest_time_close" onClick="selectAllCloseingTime();" value="Close" <?=($restaurant_time_close=='Close')?'checked':''?>/></span><span class="DeliverHrs_Font">Select All</span><span id="resSelectAllCloseErr"></span></span>
	</div>
	
	<div class="addPageCont">
		<span class="addPageRightFont">&nbsp;</span>
		<span class="colon1">&nbsp;</span>
		<span class="DeliverHrs_Font"><b>Note</b> : Your Restaurant is closed in particular day , Please select time <b> 00:00 </b></span>
	</div>
	
	<div class="addPageCont">
		<div class="addPageRightFontNew1">
        <?php
		$arr_days=array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
		for($i=0;$i<count($arr_days);$i++)
		{
		?>
        <div class="addPageCont"><span class="addPageRightFont"><?php echo $arr_days[$i]; ?>
        <input type="hidden" name="day[]" value="<?php echo $arr_days[$i]; ?>" /></span><span class="colon1">:</span></div>
        <?php } ?>
		</div>
		<div class="DeliveryHrsNew">
        <?php 
		for($k=0;$k<count($arr_days);$k++)
		{ 
		$row_day=mysql_fetch_array(mysql_query("SELECT * FROM ".$prev."resturant_days WHERE rest_id='".$_GET['rest_id']."' AND day='".$arr_days[$k]."' AND action='Open'"));
		$row_time=explode(" : ",$row_day['time']);
		?>
			<span class="DeliveryHrs">
			<select class="selectbx" name="restaurant_delivery_open_hr[]" id="restaurant_delivery_open_hr<?php echo $k;?>" style="width:60px; margin-right:15px;" <?=($restaurant_time_open=='Open')?'':'disabled'?>>
            <option value="">Hrs</option>
            <?php for($hr=0;$hr<=12;$hr++){ if($hr<=9){$hr="0".$hr;}else{$hr=$hr;}?>
            <option value="<?php echo $hr; ?>" <?=($row_time[0]==$hr)?'selected':''?>><?php echo $hr; ?></option>
            <?php } ?>
            </select>
            <select class="selectbx" name="restaurant_delivery_open_min[]" id="restaurant_delivery_open_min<?php echo $k;?>" style="width:60px; margin-right:15px;" <?=($restaurant_time_open=='Open')?'':'disabled'?>>
            <option value="">Mins</option>
            <?php for($min=0;$min<=59;$min++){ if($min<=9){$min="0".$min;}else{$min=$min;}?>
            <option value="<?php echo $min; ?>" <?=($row_time[1]==$min)?'selected':''?>><?php echo $min; ?></option>
            <?php } ?>
            </select>
            <select class="selectbx" name="restaurant_delivery_open_sess[]" id="restaurant_delivery_open_sess<?php echo $k;?>" style="width:120px" <?=($restaurant_time_open=='Open')?'':'disabled'?>>	
            <option value="">--AM/PM--</option>
            <option value="AM" <?=($row_time[2]=="AM")?'selected':''?>>AM</option> <!--Testing Validation-->
			<option value="PM" <?=($row_time[2]=="PM")?'selected':''?>>PM</option>
            </select>
		</span>
            
	<?php } ?>
		</div>
		<div class="DeliveryHrsNew">
			 <?php 
		for($l=0;$l<count($arr_days);$l++)
		{ 
		$row_day=mysql_fetch_array(mysql_query("SELECT * FROM ".$prev."resturant_days WHERE rest_id='".$_GET['rest_id']."' AND day='".$arr_days[$l]."' AND action='Close'"));
		$row_time=explode(" : ",$row_day['time']);
		?>
        <span class="DeliveryHrs">
			<select class="selectbx" name="restaurant_delivery_close_hr[]" id="restaurant_delivery_close_hr<?php echo $l;?>" style="width:60px; margin-right:15px;" <?=($restaurant_time_close=='Close')?'':'disabled'?>>
            <option value="">Hrs</option>
            <?php for($hr=0;$hr<=12;$hr++){ if($hr<=9){$hr="0".$hr;}else{$hr=$hr;}?>
            <option value="<?php echo $hr; ?>" <?=($row_time[0]==$hr)?'selected':''?>><?php echo $hr; ?></option>
            <?php } ?>
            </select>
            <select class="selectbx" name="restaurant_delivery_close_min[]" id="restaurant_delivery_close_min<?php echo $l;?>" style="width:60px; margin-right:15px;" <?=($restaurant_time_close=='Close')?'':'disabled'?>>
            <option value="">Mins</option>
            <?php for($min=0;$min<=59;$min++){ if($min<=9){$min="0".$min;}else{$min=$min;}?>
            <option value="<?php echo $min; ?>" <?=($row_time[1]==$min)?'selected':''?>><?php echo $min; ?></option>
            <?php } ?>
            </select>
            <select class="selectbx" name="restaurant_delivery_close_sess[]" id="restaurant_delivery_close_sess<?php echo $l;?>" style="width:120px" <?=($restaurant_time_close=='Close')?'':'disabled'?>>	
            <option value="">--AM/PM--</option>
            <option value="AM" <?=($row_time[2]=="AM")?'selected':''?>>AM</option> <!--Testing Validation-->
			<option value="PM" <?=($row_time[2]=="PM")?'selected':''?>>PM</option>
            </select>
		</span>
        <?php } ?>
		</div>
	</div>
	<!--Restaurant Delivery Areas-->
	<!--<div class="addPageCont">
		<span class="addPageRightFont">Delivery Areas <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<select class="multipleselectbx" name="restaurant_delivery_areas[]" id="restaurant_delivery_areas" multiple="multiple" size="16">
									<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
						<option value="" selected="selected" ></option>
					</select>
		<div class="tooltip"><div class="HelpButton">?</div><span>Select restaurant dlivery area</span></div>
		<span class="errClass" id="resDeliAreErr"></span>	
	</div>-->
	
	<!--Restaurant Delivery Charge-->
	<!--<div class="addPageCont">
		<span class="addPageRightFont">Delivery Charge <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="restaurant_delivery_charge" id="restaurant_delivery_charge" value="0.00"  onfocus="this.value=''"   />
		<div class="tooltip"><div class="HelpButton">?</div><span>Enter restaurant dlivery charge</span></div>
		<span class="errClass" id="resDeliChgErr"></span>
	</div>-->
	
	<!--Restaurant Minimumorder Price-->
	<div class="addPageCont">
		<span class="addPageRightFont">Min Order <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="rest_order" id="rest_order" value="<?=$restaurant_order?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant minimum order price">?</div></div>
		<span class="errClass" id="resMinOrdErr"></span>	
	</div>
	
	<!--Restaurant Salestax-->
	<div class="addPageCont">
		<span class="addPageRightFont">Sales Tax(%) <span class="color1">*</span></span>
		<span class="colon1">:</span>
		<input class="textbox" type="text" name="rest_tax" id="rest_tax" value="<?=$restaurant_tax?>" />
		<div class="tooltip"><div class="HelpButton" title="Enter restaurant salestax">?</div></div>
		<span class="errClass" id="resSalTaxErr"></span>
	</div>
	
	<!--Restaurant Serving Cuisines-->
	<div class="addPageCont">
		<span class="addPageRightFont">Serving Cuisines </span>
		<span class="colon1">:</span>
		<select class="multipleselectbx" name="rest_cuisine[]" id="restaurant_serving_cuisines" multiple="multiple" size="16">
        <?php
		$serv_cuisine=mysql_query("SELECT cuisine_name,cuisine_id FROM ".$prev."cuisine");
		$restaurant_cuisines=explode(",",$restaurant_cuisine);
		$i=0;
		while($row_cuisine=mysql_fetch_array($serv_cuisine))
			{
				//echo $row_cuisine['cuisine_id'];
			?>
			<option value="<?=$row_cuisine['cuisine_id']?>" <? if(in_array($row_cuisine['cuisine_id'],$restaurant_cuisines)){echo "selected";}?>><?=$row_cuisine['cuisine_name']?></option>
			<?php
			$i++;
			}
		?>
				</select>	
		<div class="tooltip"><div class="HelpButton" title="Select restaurant serving cuisines">?</div></div>
		<span class="errClass" id="resSerCuiErr"></span>
	</div>
	
</div>
                
                <div class="buttonCont_restaurant">
			<input type="submit" class="button" value="<?=($rest_id!=0)?'Update':'Add'?>" name="REST_INFO"> 
			<a class="CanceButton" href="restaurantManage.php">Cancel</a>
		</div>
		</form>