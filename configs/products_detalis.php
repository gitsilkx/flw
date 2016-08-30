<?php include ("includes/header.php");

/*if(!$_SESSION['user_id'])
{
	$txt_quantity=$_REQUEST['txt_quantity'];
	$id=$_REQUEST['id'];
	header("location:addtocart.php?txt_quantity=$txt_quantity&id=$id");
}
*/
$select_product="select * from ".$prev."product where product_id='".$_REQUEST['product_id']."' ";
$rec_product=mysql_query($select_product);
$row_product=mysql_fetch_array($rec_product);


$select_category="select * from ".$prev."categories where cat_id='".$row_product['cat_id']."'";
$rec_category=mysql_query($select_category);
$row_category=mysql_fetch_array($rec_category);


$select_product_size="select * from ".$prev."product_size where product_id='".$_REQUEST['product_id']."'";
$rec_product_size=mysql_query($select_product_size);
$num_product_size=mysql_num_rows($rec_product_size);


$select_product_color="select * from ".$prev."product_color where product_id='".$_REQUEST['product_id']."'";
$rec_product_color=mysql_query($select_product_color);
$num_product_color=mysql_num_rows($rec_product_color);
?>
<script type="text/javascript" src="highslide/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide/highslide.css" />
<script type="text/javascript" src="js/stickytooltip.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script> -->
<style type="text/css">
.stickytooltip{
box-shadow: 5px 5px 8px #818181; /*shadow for CSS3 capable browsers.*/
-webkit-box-shadow: 5px 5px 8px #818181;
-moz-box-shadow: 5px 5px 8px #818181;
display:none;
position:absolute;
display:none;
border:5px solid black; /*Border around tooltip*/
background:white;
z-index:3000;
}


.stickytooltip .stickystatus{ /*Style for footer bar within tooltip*/
background:black;
color:white;
padding-top:5px;
text-align:center;
font:bold 11px Arial;
}


</style>
<!--
    2) Optionally override the settings defined at the top
    of the highslide.js file. The parameter hs.graphicsDir is important!
-->

<script type="text/javascript">
function funcbigimage(img,a)
{

	//	document.getElementById('bigimage').innerHTML ='<img src="'+ img + '"   height="250" width="300" alt="" />';
	
	document.getElementById('bigimage').innerHTML ='<img src="viewimage.php?img="'+ img + '"&size=390"   alt="" />';
	
		return false;
	
}
</script>

<script type="text/javascript">
hs.graphicsDir = 'highslide/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>

<script type="text/javascript" src="flexcroll.js"></script>
<link href="tutorsty.css" rel="stylesheet" type="text/css" media="all" />

<link href="css/cloud-zoom.css" rel="stylesheet" type="text/css" />

<!-- You can load the jQuery library from the Google Content Network.
Probably better than from your own server. -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<!-- Load the Cloud Zoom JavaScript file -->
<script type="text/JavaScript" src="js/cloud-zoom.1.0.2.min.js"></script>
<!--header end-->

<!--new_products_details -->
<div class="new_products_details">
<h1><a style="color:#999999;" href="index.php">Home</a> > <a style="color:#999999;" href="products.php?cat_id=<?php echo $row_category['cat_id'];?>"><?php echo $row_category['cat_name'];?></a> ><span> <?php echo $row_product['product_title'];?></span></h1>
<div class="clear"></div>
<!--new_products_details_panels -->
<div class="new_products_details_panels">
<!--display -->
<div class="display">
<div align="center">
	<div class="inner_imshrd" id="bigimage" style="height:250px;">
	<a href='viewimage.php?img=<?php echo $row_product['product_photo'];?>&size=750' class = 'cloud-zoom' id='zoom1'
            rel="adjustX: 5, adjustY:-4">
		<img src="viewimage.php?img=<?php echo $row_product['product_photo'];?>&size=200" alt="" /></a>
	</div>
</div>
<div style="height:10px;"></div>
<div style=" height:110px;">
		<div id='mycustomscroll' class='flexcroll'>
		<div style="background-color:#CCCCCC; " id='horizontalwrap'>
		<?
		$a=1;
		$select_proimage="select * from ".$prev."product_picture where product_id='".$_REQUEST['product_id']."' limit 3";
        $rec_proimage=mysql_query($select_proimage);
		$rec_proimage_no=mysql_num_rows( $rec_proimage);
		
		?>
		<table cellpadding="0" cellspacing="0" border="0" width="100%" style="">
		<tr>
		<td>
			<div style="padding:0 12px 0 0;">
				<div style="border:0px solid #EAEAEA; width:60px; padding:6px 6px 2px 6px;">
				 <a style="cursor:pointer;" onClick="funcbigimage('viewimage.php?img=<?=$row_product['product_photo'];?>&size=200',<?php echo $a;?>);" >
		  		<img src="viewimage_box.php?img=<?=$row_product['product_photo'];?>&size=75"/>
				</a>
				</div>
		  	</div>
		 </td> 
		<?php
		$a++;
		
	//	echo $num_proimage=mysql_num_rows($rec_proimage);
		while($row_proimage=mysql_fetch_array($rec_proimage))
		{
		?>
		<td>
			<div style="padding:0 12px 0 0;">
				<div style="border:0px solid #EAEAEA; width:60px; padding:6px 6px 2px 6px;">
				 <a style="cursor:pointer;" onClick="funcbigimage('viewimage.php?img=<?=$row_proimage['picture'];?>&size=390',<?php echo $a;?>);" >
		  		<img src="viewimage_box.php?img=<?=$row_proimage['picture'];?>&size=75"/>
				</a>
				</div>
		  	</div>
		 </td> 
		<?php
		$a++;
		}
		?>
		</tr>
		</table>

		</div>
	</div>
</div>
</div>
<!--display end-->
<!--display_details -->

<div class="display_details">
<h1><?php echo $row_product['product_title'];?></h1>
<div class="clear"><br /></div>
<h2><?php echo $row_product['product_title_description'];?> </h2>
<div class="clear"></div>
<!--display_details_buy -->
<div class="display_details_buy">


<?php
if($num_product_color > 0)
{
?>
<h1>Choose Colour:</h1>
 <p><a class="tips" href="test.html" rel="test.html">show me the cluetip!</a></p>
<div >
<table cellpadding=4 border=0 cellspacing=4>
<tr>
<?php
$a=0;
while($row_product_color=mysql_fetch_array($rec_product_color))
{
  if($row_product['default_color']==$row_product_color[id]){$txt="checked";}else{$txt="";}
  if(!$row_product['default_color'] && !$a){$txt="checked";}else{$txt="";}
?>
	<td align=center><a    href="colorbox.php?id=<?=$row_product_color[id]?>&product_id=<?=$_REQUEST[product_id]?>" ><img src="viewimage_box.php?img=<?=$row_product_color['picture']?>&size=20" border="0" data-tooltip="sticky3"></a><br> <input type=radio name=color value=<?=$row_product_color[id]?> <?=$txt?>></td>
<?php
$a++;
}
echo"</tr></table></div>";
}

$row_product['default_size']=$row_product['height']."X".$row_product['width'] . "X". $row_product['depth']."X".$row_product['weight'];
?>


<!--<div class="black"></div><div class="gray"></div><div class="gray2"></div>-->


<?php 
if($num_product_size > 0)
{
?>
<div style='float:right'>
<h1>Size:</h1>

<div>Height &nbsp;<span style="color:#CCCCCC; font-size:12px;">X</span>&nbsp; Width <span style="color:#CCCCCC; font-size:12px;">X</span> Depth X Weight</div>
<select style="padding:2px; background-image:none; height:auto; margin:0 0 0 0; font-size: 14px;" name="product_size" class="">
<option>Please select</option>
<?php
while($row_product_size=mysql_fetch_array($rec_product_size))
{
    $size=$row_product_size['height']."X".$row_product_size['width'] . "X". $row_product_size['depth'];
	if($row_product['default_size']==$size){$txt=" selected";}else{$txt="";}
    ?>
    <option value="<?php echo $row_product_size['height']."X".$row_product_size['width'] . "X". $row_product_size['depth'];?>" <?=$txt?>><?php echo $row_product_size['height']."X".$row_product_size['width'] . "X". $row_product_size['depth']."X".$row_product_size['weight'];?></option>
    <?php
}
?>
</select>
<?php
}
?></div>
<div class="clear"></div>
<h4>Price </h4><h5> £&nbsp;<?php echo $row_product['product_price'];?></h5>

<span id="buy_now">

<form name="buyform" action="cart.php" method="post">
 <input type="hidden" value="1" name="qty" id="qty" />
 <input type="hidden" value="<?php echo $_REQUEST['product_id'];?>" name="product_id" id="id" />		
 <input type="submit" name="cart" value=""  class="buynow" style="cursor:pointer;" />
 <input type="hidden" name="addtocart" value="1"  />
 </form>
</span>


	<!-- AddThis Button BEGIN -->
 <a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;user_name=xa-4cbbe5915bd43e61"><img src="images/share.png"  alt="Bookmark and Share" Style="float:left;
margin:20px 0 0 0;" /></a>
    <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#user_name=xa-4cbbe5915bd43e61"></script>
   <!-- AddThis Button END -->
</div>
<!--display_details_buy end-->
<div class="clear"></div>
<h3><b>Click here for more info on delivery</b></h3>
<div class="clear"></div>
<hr />
<div class="clear"></div>
<ul>
<li><a href="#s" id="addin" style="color:#999999;" onClick="funaddion();">Additional Info</a></li>
<li>|</li>
<li><a href="#s" id="delin" onClick="fundeliver();">Delivery info</a></li>
</ul>
<div class="clear"></div>

<script type="text/javascript">
function funaddion()
{
	document.getElementById('additionalinfo').style.display= '';
	document.getElementById('deliveryinfo').style.display = 'none';
	document.getElementById('addin').style.color = "#999999";
	document.getElementById('delin').style.color = "#000000";
}
function fundeliver()
{
	document.getElementById('additionalinfo').style.display = 'none';
	document.getElementById('deliveryinfo').style.display = '';
	document.getElementById('addin').style.color = "#000000";
	document.getElementById('delin').style.color = "#999999";
}
</script>

<div id="additionalinfo"><?php echo nl2br($row_product['short_description']);?></div> 

<div style="display:none;" id="deliveryinfo"><?php echo nl2br($row_product['long_description']);?></div> 

<br /><br /><br /><br />

</div>
<!--display_details end-->
</div>
<!--new_products_details_panels end-->
<!--you_may_also -->
<?
$rr=mysql_query("select   " . $prev. "product.* from " . $prev. "product," . $prev. "product_similar where " . $prev. "product.product_id=" . $prev. "product_similar.similar_id and " . $prev. "product_similar.product_id=" . $_REQUEST[product_id]);
$num_row=@mysql_num_rows($rr);

if($num_row):
?>				
<div class="you_may_also">
You may also be interested in...
</div>

<link rel="stylesheet" type="text/css" href="css/btslide.css">	
<script language="javascript" type="text/javascript" src="js/sub/mootools-1.js"></script>	
<script language="javascript" type="text/javascript" src="js/sub/slideitmoo-1.js"></script>		
<script language="javascript" type="text/javascript" src="js/sub/load.js"></script>	

<script type="text/javascript" src="js/crawler.js">
/*
Text and/or Image Crawler Script ©2009 John Davenport Scheuer
as first seen in http://www.dynamicdrive.com/forums/ username: jscheuer1
This Notice Must Remain for Legal Use
*/
</script>

<!--you_may_also end-->
<!--you_may_also_display -->
<div class="you_may_also_display"><!--<img src="images/products_display.png" height="110" width="988" alt="" /> -->

<div style="width:980px; height:145px; float:left; clear:both; margin:0px 0px 10px 0px;">
                
				
				<?php
				 
				 if($num_row > 0)
				 {
					
				?>
				
				
  			    <div style=" width:980px; margin:0 auto;" id="SlideItMoo_outer">	
				<div style="width:980px;" id="SlideItMoo_inner">			
					<div style="width: 1500px; margin-left: 0px;" id="SlideItMoo_items">
					
					<!--
						<div class="SlideItMoo_element"><img src="images/slide_img.png" /></div>
			 			<div class="SlideItMoo_element"><img src="images/slide_img1.png" /></div>
			 			<div class="SlideItMoo_element"><img src="images/slide_img2.png" /></div>
			 			<div class="SlideItMoo_element"><img src="images/slide_img3.png" /></div>
                        <div class="SlideItMoo_element"><img src="images/slide_img.png" height="110" width="117" /></div>
                        <div class="SlideItMoo_element"><img src="images/slide_img1.png" /></div>
                        <div class="SlideItMoo_element"><img src="images/slide_img2.png" /></div>
			 			<div class="SlideItMoo_element"><img src="images/slide_img3.png" /></div>
			 			<div class="SlideItMoo_element"><img src="images/slide_img.png" /></div>-->
					
					<?
					
					
					while($dd=mysql_fetch_array($rr))
					{
					?>
					<div class="SlideItMoo_element"><a href='products_detalis.php?product_id=<?php echo $dd['product_id'];?>'>
					<img src='viewimage_box.php?img=<?php echo $dd['product_photo']; ?>&size=80&height_fix=80' border="0"/></a></div>
					
					
					
					<!--	echo"<div class=\"SlideItMoo_element\" ><a href='products_details.php?product_id=" . $dd[product_id] ."'><img src='viewimage.php?img=" . $dd[product_photo] . "&size=80' border=0/></a><br><span class=text >". $dd[product_title]."<br><font color=red><strong>Price : £</font> ".$dd[product_price] . "</strong></span></div>";-->
					<?php
					}
					?>	
			 			           
                        			
					</div>			
				</div>
			<div class="SlideItMoo_forward"></div><div class="SlideItMoo_back"></div>
           </div>
		   <?php
		   }
		   ?>
                
</div>
<?endif;?>
<br /><br /><br />
</div><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />

<!--you_may_also_display end-->
</div>
<!--new_products_details end-->
</div>
<!--wrapper end-->
<!--footer -->

<?php include "includes/footer.php";?>
