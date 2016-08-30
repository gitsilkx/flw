<?php include("configs/path.php");  
$cart_id = $_REQUEST[cart_id];
$product_id = $_REQUEST[product_id];
$a=mysql_query("delete from ".$prev."cart where id='".$cart_id."' and OrderID='" . GetCartId()."'");	 	
//$r=mysql_query("select " . $prev . "cart.*,products.name,products.price,products.flowerwyz_image from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'");		 ?>
<p>Add</p>
<input type="radio" name="<?= $product_id;?>" value="1" class="add-to-cart radio" id="remove_cart_<?= $product_id;?>_y"><label for="remove_cart_<?= $product_id;?>_y" class="css-label radGroup1"></label>

