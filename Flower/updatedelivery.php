<?php
include("configs/path.php");
include("getProducts.php");

$ch = curl_init();
$username = '527492';
$password = '8EEkyK';
$code = getProductCodeById($_REQUEST['product_id']);
$auth = base64_encode("{$username}:{$password}");
curl_setopt_array(
        $ch, array(
    CURLOPT_URL => "https://www.floristone.com/api/rest/giftbaskets/getproducts?code=$code",
    CURLOPT_HTTPHEADER => array("Authorization: {$auth}"),
    CURLOPT_RETURNTRANSFER => true
        )
);
$output = json_decode(curl_exec($ch)); // return obj
curl_close($ch);
$products = $output->PRODUCTS;
$availabledeliverydates = $products[0]->AVAILABLEDELIVERYDATES;


$strZipCode = '10011';
$ins->getDeliveryDates(API_USER, API_PASSWORD, $strZipCode);
$r = mysql_query("select " . $prev . "cart.*,products.name,products.price,products.flowerwyz_image," . $prev . "cart.type_id from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'");
$i = 1;
//echo "select " . $prev . "cart.*,products.name,products.price,products.flowerwyz_image," . $prev . "cart.type_id from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'";
while($product = @mysql_fetch_array($r)) {
    ?>
    <div class="col-sm-6">
        <div class="form_sep">
            <?php echo $product['name']; ?>
        </div>
    </div>
    <?php if ($product['type_id'] == '1') { ?>
        <div class="col-sm-6 form_sep cust-select">
            <select onChange="this.className = this.options[this.selectedIndex].className"
                    class="greenText deliverydate" name="flowerDeliverydate_<?= $i ?>" id="deliverydate_<?= $i ?>" required="required">
                <option value="">Select Delivery Date *</option>
                <?php
                foreach ($ins->arrDates as $key => $val) {
                    $date_array = explode("T", $val);
                    echo '<option value="' . $val . '">' . date('l, jS F Y', strtotime($date_array[0])) . '</option>';
                }
                ?>
            </select>
        </div>
    <?php } elseif ($product['type_id'] == '2') {
        ?>
        <div class="col-sm-6 form_sep cust-select">
            <select onChange="this.className = this.options[this.selectedIndex].className"
                    class="greenText deliverydate" name="giftDeliverydate_<?= $i ?>" id="deliverydate_<?= $i ?>" required="required">
                <option value="">Select Delivery Date *</option>
                <?php
                for ($y = 0; $y < count($availabledeliverydates); $y++) {
                    echo '<option value="' . $availabledeliverydates[$y]->SHIPPINGTYPE . '|' . $availabledeliverydates[$y]->DATE . '">' . date('l, jS F Y', strtotime($availabledeliverydates[$y]->DATE)) . ' - $' . $availabledeliverydates[$y]->SHIPPINGPRICE . '</option>';
                }
                ?>
            </select>
        </div>
        <?php
    }
    $i++;
}
?>
