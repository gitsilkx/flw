<?php
include "includes/header.php";

if($_POST[addtocart]):
		$rr=mysql_query("select * from " . $prev . "product where product_id=" . $_REQUEST[product_id]);
		$product_price=@mysql_result($rr,0,"product_price");
		$cat_id=@mysql_result($rr,0,"cat_id");
		
		$total=$product_price*$_REQUEST[qty];
	    if(!$_SESSION[user_id]){$user_id=GetCartId();}else{$user_id=$_SESSION[user_id];}
		$r1=mysql_query("insert into " . $prev . "cart set 
			   product_id='" . $_REQUEST[product_id] . "',
			   user_id='".$user_id."',qty='" . $_REQUEST[qty] . "',
			   color='" . addslashes($_REQUEST[color]) . "',
			   size='".addslashes($_REQUEST[size])."',
			   price='" . $product_price . "',total='" . $total . "',
			   ip_address='".$_SERVER[REMOTE_ADDR]."',
			  `date`='".date("Y-m-d")."',purchased='N',OrderID='" . GetCartId() . "'");										
			  /* echo "insert into " . $prev . "cart set 
			   product_id='" . $_REQUEST[product_id] . "',
			   user_id='".$user_id."',qty='" . $_REQUEST[qty] . "',
			   color='" . addslashes($_REQUEST[color]) . "',
			   size='".addslashes($_REQUEST[size])."',
			   price='" . $product_price . "',total='" . $total . "',
			   ip_address='".$_SERVER[REMOTE_ADDR]."',
			  `date`='".date("Y-m-d")."',purchased='N',
			   OrderID='" . GetCartId() . "'";*/
elseif($_POST[update]):
	 for($i=0;$i<count($_REQUEST[product_id]);$i++):
		  echo"||" .$_REQUEST[remove][$i]; 
		  if($_REQUEST[qty][$i] && !$_REQUEST[remove][$i]):          
				$r1=mysql_query("update " . $prev . "cart set qty='" . $_REQUEST[qty][$i] . "',price='".$_REQUEST[price][$i]."',total='" . ($_REQUEST[qty][$i]*$_REQUEST[price][$i]) . "',color='" . addslashes($_REQUEST[color][$i]) . "',currency_type='".$_SESSION[currency]."',size='".addslashes($_REQUEST[size][$i])."' where product_id='" .$_REQUEST[product_id][$i] . "' and purchased='N' and (OrderID='" . GetCartId() . "' or user_id='".$_SESSION[user_id]."')");
		  endif;   
		  if($_REQUEST[remove][$i]):
			 $rr=mysql_query("delete  from " . $prev . "cart where product_id=" . $_REQUEST[remove][$i] . "  and  (OrderID='" . GetCartId() . "' or user_id='".$_SESSION[user_id]."')");
		     echo"delete  from " . $prev . "cart where product_id=" . $_REQUEST[remove][$i] . "  and  (OrderID='" . GetCartId() . "' or user_id='".$_SESSION[user_id]."')";
		  endif;
	 endfor;
endif;

if($_SESSION[user_id]):
	$r=mysql_query("select " . $prev . "cart.*," . $prev . "product.* from " . $prev . "cart," . $prev . "product where " . $prev . "cart.product_id=" . $prev . "product.product_id and (" . $prev . "cart.OrderID='" . GetCartId() . "' or " . $prev . "cart.user_id='".$_SESSION[user_id]."') and " . $prev . "cart.purchased='N'");
else:
	$r=mysql_query("select " . $prev . "cart.*," . $prev . "product.* from " . $prev . "cart," . $prev . "product where " . $prev . "cart.product_id=" . $prev . "product.product_id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'");
endif;
?>
<!--ani end-->
<!--main_body -->
<div id="main_body">
<!--main_body_txt -->
<div id="main_body_txt">
<h1><b>Shopping Cart</b> </h1>
<br />
<div class="clear"></div><br />



<div style="border:1px solid #ffffff;">
<?
if(!@mysql_num_rows($r)):
	 echo"<table align=center><tr><td align=center><br><br><br><br><br><div align=center class=lnkred>No product found.</div><br><br><br><br><br></td></tr></table>";
else:?>
<form action="<?=$_SERVER[PHP_SELF]?>" name="form1" method="post">
<input type=hidden name=cat_id value=<?=$_REQUEST[cat_id]?>>
<!--your_shopping _cart -->
<div id="your_shopping_cart">
<table cellpadding="6" cellspacing="0" border="1" width="100%" style="border-top:1px solid #000000; border-left:1px solid #000000; border-right:1px solid #000000;">
<tr><td><b>Picture</b></td>
<td ><b>Product Name</b></td>
<td align=right><b>Unit price</b>(£)</td>
<td align=center><b>No. of items</b></td>
<td  align=right><b>Price</b>(£)</td><td align=center><strong>Remove</strong></td>
</tr>
<?
$amt=0;$j=0;
while($d=@mysql_fetch_array($r)):
    echo"<tr ><td width=100><img src='viewimage.php?img=" . $d[product_photo] . "&size=90' border=0></td>
	<td height=25 width=200><input type=hidden name=product_id[] value=" . $d[product_id] . ">" . stripslashes(ucwords($d[product_title])) . "</td>";
    echo " <td align=right><input type='hidden' name='price[]' value='" . $d[product_price] . "'>";
    echo $setting[currency]." " .  sprintf("%01.2f",$d[product_price]);
    echo"</td><td align=center ><input type=text  size=4 name=qty[] value='" . $d[qty] . "'></td>
    <td align=right width=100>".$setting[currency]." " . sprintf("%01.2f",$total) . "</td>
    <td align=center width=25><input type=checkbox name=remove[] value='".$d[product_id]."'></td></tr>\n";
	$amt+=$d[qty]*$d[price];
	
	 
    $j++; 
endwhile;
echo"<tr ><td colspan=3></td><td style='padding-left:5px;' ><strong>Total Amount</strong></td><td align=right >".$setting[currency]." " . sprintf("%01.2f",$amt) . "</td><td></td></tr>";
?>
<tr>
<td></td>
<td ></td>
<td ></td>
<td ><b>VAT :</b></td>
<td></td><td></td>
</tr>
<tr>
<td></td>
<td ></td>
<td ></td>
<td ><b>Shipping charge :</b></td>
<td ></td>
<td></td></tr>
<tr>
<td></td>
<td ></td>
<td ></td>
<td><b>Grand total :</b></td>
<td></td><td></tr>

<tr><td colspan=4><a href='products.php?cat_id=<?=$cat_id?>'>Continue Shopping</a></td><td colspan=2><input type="submit"  name="addtocart"   class="Checkout" value="Checkout" style="cursor:pointer;" />	<input type="submit"  name="update"   class="Checkout" value="Update Cart" style="cursor:pointer;" /></td></tr>
</table></form>
<?endif;?>	<br /><br />
</div></div></div></div>

<!--wrapper end-->
<!--footer -->
<?php include "includes/footer.php";?>

