<?php
session_start();
include("includes/access.php");
include("includes/header.php");
//$_SESSION['page_name']='add_contactinfo.php';
if(isset($_SESSION['page_name']))
{
	$page_name=$_SESSION['page_name'];
}
else
{
	$page_name='add_contactinfo.php';
}

?>
 
	<!--Script for validation-->
<!--<script type="text/javascript" src="<?=$vpath?>ajaxtabs/ajaxtabs.js"></script>   
<link rel="stylesheet" type="text/css" href="<?=$vpath?>ajaxtabs/ajaxtabs.css" />
<link rel="stylesheet" type="text/css" href="<?=$vpath?>css/tab.css" />-->


<!--<script src="<?=$vpath?>admincp/js/jquery.js" type="text/javascript"></script>-->
<script src="<?=$vpath?>admincp/js/main.js" type="text/javascript"></script>
<?php if($_REQUEST['rest_id']!=''){?>
<script>
$(function() {
$( "#tabs" ).tabs();
});
</script>
<?php }else { ?>
<script>
$(function() {
$( "#tabs" ).tabs();
$("#tabs").tabs({disabled: [1,2,3,4,5]});
});
</script>
<?php } ?>

		<!--<div >
			<ul id="countrytabs1" class=css-tabs>
              <li><a href="add_contactinfo.php" <?php if($page_name === 'add_contactinfo.php'){?>  rel="#default"  class="selected" <?php }else {?>rel="countrycontainer1" <?php }?> >Contact Info</a></li>
              <li><a href="<?=$vpath?>admincp/restaurant_info.php" rel="#default" class="selected" >Restaurant Info</a></li>
              <li><a href="delivery_info.php" <?php if($page_name === 'delivery_info.php'){?>  rel="#default"  class="selected" <?php }else {?>rel="countrycontainer1" <?php }?>>Delivery Info</a></li>
               <li><a href="restaurant_photo.php" <?php if($page_name === 'restaurant_photo.php'){?>  rel="#default"  class="selected" <?php }else {?>rel="countrycontainer1" <?php }?> >Restaurant Photo</a></li>
              <li><a href="commission_info.php" <?php if($page_name === 'commission_info.php'){?>  rel="#default"  class="selected" <?php }else {?>rel="countrycontainer1" <?php }?>>Commission Info</a></li>
              <li><a href="bank_acinfo.php" <?php if($page_name === 'bank_acinfo.php'){?>  rel="#default"  class="selected" <?php }else {?>rel="countrycontainer1" <?php }?>>Bank A/c Info</a></li>
            </ul>
		</div>-->
	<div id="tabs">
<ul>
<li><a href="#tabs-1">Contact Info</a></li>
<li><a href="#tabs-2">Restaurant Info</a></li>
<li><a href="#tabs-3">Delivery Info</a></li>
<li><a href="#tabs-4">Restaurant Photo</a></li>
<li><a href="#tabs-5">Commission Info</a></li>
<li><a href="#tabs-6">Bank A/c Info</a></li>
</ul>
<div id="tabs-1">
<p><?php include('add_contactinfo.php');?></p>
</div>
<div id="tabs-2">
<p><?php include('restaurant_info.php');?></p>
</div>
<div id="tabs-3">
<p><?php include('delivery_info.php');?></p>
</div>
<div id="tabs-4">
<p><?php include('restaurant_photo.php');?></p>
</div>
<div id="tabs-5">
<p><?php include('commission_info.php');?></p>
</div>
<div id="tabs-6">
<p><?php include('bank_acinfo.php');?></p>
</div>
</div>	
				<!--<div class="restaurantTabContent" id="countrydivcontainer1" >
                <?php //include('restaurant_info.php');?>
					
</div>-->
				
		
        
         <!--<script type="text/javascript">
		
		var countries=new ddajaxtabs("countrytabs1", "countrydivcontainer1")
		countries.setpersist(true)
		countries.setselectedClassTarget("link") //"link" or "linkparent"
		countries.init()
		
		</script>-->
<?
include("includes/footer.php");
?>
