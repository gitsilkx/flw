<?php include("configs/path.php");     
$ch = curl_init();
$username = '527492';
$password = '8EEkyK';
$code = $_REQUEST[product_id];
$occasion_id = $_REQUEST['occasion_id'];
$type_id = getProductTypeById($code);
$product_code = getProductCodeById($code);
//$product_code = 'WGD413';
$auth = base64_encode("{$username}:{$password}");
curl_setopt_array(
        $ch, array(
    CURLOPT_URL => "https://www.floristone.com/api/rest/giftbaskets/getproducts?code=$product_code",
    CURLOPT_HTTPHEADER => array("Authorization: {$auth}"),
    CURLOPT_RETURNTRANSFER => true
        )
);
$output = json_decode(curl_exec($ch)); // return obj
curl_close($ch);
$products = $output->PRODUCTS;
$availabledeliverydates = $products[0]->AVAILABLEDELIVERYDATES;

$rr=mysql_query("select * from products where id=" . $code);	
$product_price=@mysql_result($rr,0,"price");	
$total=$product_price*$_REQUEST[qty];   
//echo "insert into " . $prev . "cart set product_id='" . $_REQUEST['product_id'] . "',type_id='" . $type_id . "',occasion_id='" . $occasion_id . "',	   user_id='".$_SESSION['user_id']."',qty='" . $_REQUEST['qty'] . "',	   price='" . $product_price . "',total='" . $total . "', ip_address='".$_SERVER['REMOTE_ADDR']."',	  `date`='".date("Y-m-d")."',purchased='N',OrderID='" . GetCartId() . "'";
$r1=mysql_query("insert into " . $prev . "cart set product_id='" . $_REQUEST['product_id'] . "',type_id='" . $type_id . "',occasion_id='" . $occasion_id . "',	   user_id='".$_SESSION['user_id']."',qty='" . $_REQUEST['qty'] . "',	   price='" . $product_price . "',total='" . $total . "',ip_address='".$_SERVER['REMOTE_ADDR']."',	  `date`='".date("Y-m-d")."',purchased='N',OrderID='" . GetCartId() . "'");           
$car_id = mysql_insert_id();		 	
//$r=mysql_query("select " . $prev . "cart.*,products.name,products.price,products.flowerwyz_image from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'");		 ?>
<p>Remove</p>
<input type="radio" name="<?=$_REQUEST[product_id]?>"  value="<?=$car_id; ?>" class="remove-to-cart" id="<?=$_REQUEST[product_id]?>"><label for="<?=$_REQUEST[product_id]?>" class="css-label2 radGroup1"></label>
<br>
<select class="del_date" name="<?= $car_id ?>" id="deliverydate_<?= $code ?>" required="required">
    <option value="">Select Delivery Date *</option>
    <?php
    for ($y = 0; $y < count($availabledeliverydates); $y++) {
        echo '<option value="'. $availabledeliverydates[$y]->DATE . '">' . date('l, jS F Y', strtotime($availabledeliverydates[$y]->DATE)) . ' - $' . $availabledeliverydates[$y]->SHIPPINGPRICE . '</option>';
    }
    ?>
</select>
<br>