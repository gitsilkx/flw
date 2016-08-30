<?php
include("includes/access.php");
include("includes/header.php");
if($_REQUEST['OrderID']){
	$OrderID=$_REQUEST['OrderID'];
    $sql=mysql_query("SELECT * FROM ".$prev."orders where OrderID=".$OrderID."");	
	$order=mysql_fetch_object($sql);
	
$tax='No';	
/********************************Restaurant Tax/delivery/min order****************************************************/	
    $sql_count=mysql_query("SELECT count(`rest_info_id`) cnt FROM ".$prev."resturant_info where rest_id=".$order->rest_id);
	$row_count=mysql_fetch_object($sql_count);
	if($row_count->cnt){
	$sql_tax=mysql_query("SELECT rest_tax FROM ".$prev."resturant_info where rest_id=".$order->rest_id);	
	$row_tax=mysql_fetch_object($sql_tax);	
	$tax=$row_tax->rest_tax;
	}

 
}
?>
<div class="adminRight">
<div class="rightContHeading Heading">Order view full details - <?php echo 'ORD'.$order->OrderID;?></div>
<div class="rightContBody">
	<div class="riteContWrap1">
		<div class="manageButtonLastCont">
		<a href="manage_order.php?menuid=108&menupid=103" class="manageButton_addnw">Back</a>
		</div>

		<div class="riteContWrap1">
			<div class="addtocartWrap">
				<div class="addtoCartInner">
					<div class="thanksTableOrderview">
						<table width="100%" border="0">
							<tbody><tr class="thanks1row">
								<th width="30%">Item</th>
								<!--<th width="30%">Addon</th>-->
								<th width="20%">Qty</th>
								<th width="20%">Price</th>
								<th width="50%">Total Price</th>
							</tr>
                            <?php 
							
							$sql_cart=mysql_query("SELECT * FROM ".$prev."cart where OrderID=".$OrderID."");
							      while($cart=mysql_fetch_object($sql_cart)){
							?>
                            
							<tr class="thanks2row">
								<td><?=getMenuNameById($cart->menu_id);?></td>
								<td><?=$cart->qty;?></td>
								<td><?=$cart->price;?></td>
								<td><?=$cart->total;?></td>
							</tr>
                            <?php }?>
							<tr class="thanks4row">
								<td colspan="3">Total</td>
								<td><?= $amount=$order->amount?></td>
							</tr>
							<tr class="thanks4row">
								<td colspan="3">Tax (<?=$tax?>%)</td>
								<td><?= $vat=$order->vat?></td>
							</tr>
														<tr class="thanks4row">
								<td colspan="3">Delivery Charges</td>
								<td><?= $shipping_charges=$order->shipping_charges?></td>
							</tr>
							<tr class="thanks5row">
								<td colspan="3">Final Total</td>
								<td>Rs. <?= $amount+$vat+$shipping_charges;?></td>
							</tr>
						</tbody></table>
					</div>
				</div>
				
				<!--ORDER DETAILS-->
				<div class="addPageCont"><h1><b>Order Details</b></h1></div>
				
				<div class="addPageCont">
					<span class="addPageRightFont">Order Number</span>
					<span class="colon1">:</span>				
					<span class="value"><?= 'ORD'.$order->OrderID?></span>
				</div>
				
				<div class="addPageCont">
					<span class="addPageRightFont">Order Type</span>
					<span class="colon1">:</span>				
					<span class="value"><?= $order->delivery_type?></span>
				</div>
								<div class="addPageCont">
					<span class="addPageRightFont">Delivery Time</span>
					<span class="colon1">:</span>				
					<span class="value"><?= $order->Ord_time.$order->delivery_time.$order->delivery_status?></span>
				</div>
								<div class="addPageCont">
					<span class="addPageRightFont">Order Status</span>
					<span class="colon1">:</span>				
					<span class="value"><?= $order->delivered?></span>
				</div>
				
				<div class="addPageCont">
					<span class="addPageRightFont">Order Date</span>
					<span class="colon1">:</span>				
					<span class="value"><?= $order->cur_date?></span>
				</div>
				
				<div class="addPageCont">
					<span class="addPageRightFont">Restaurant</span>
					<span class="colon1">:</span>				
					<span class="value"><?= getRestuarantnameById($order->rest_id)?></span>
				</div>
				<!--CUSTOMER DETAILS-->
				<div class="addPageCont"><h1><b>Customer Details</b></h1></div>
				<div class="addPageCont">
					<span class="addPageRightFont">Customer Name</span>
					<span class="colon1">:</span>				
					<span class="value"><?= getUsernameById($order->user_id)?></span>
				</div>
				
				<div class="addPageCont">
					<span class="addPageRightFont">Customer Address</span>
					<span class="colon1">:</span>				
					<span class="value"><?= getUserAddressById($order->user_id)?></span>
				</div>
				
				<div class="addPageCont">
					<span class="addPageRightFont">Customer Phone Number</span>
					<span class="colon1">:</span>				
					<span class="value"><?= getUserContactById($order->user_id)?></span>
				</div>
				<!--PAYMENT DETAILS-->
				<div class="addPageCont"><h1><b>Payment Details</b></h1></div>
				<div class="addPageCont">
					<span class="addPageRightFont">Payment Method</span>
					<span class="colon1">:</span>				
					<span class="value"><?= $order->payment_mode?></span>
				</div>
								
			</div>
		</div>
		<div class="manageButtonLastCont">
		<a href="manage_order.php?menuid=108&menupid=103" class="manageButton_addnw">Back</a>
		</div>
	</div>
</div>
</div>
<?
include("includes/footer.php");
?>