<?php
include("configs/path.php");
include("getProducts.php");

$strZipCode = $_REQUEST['zip_code'];
$itemCode = $_REQUEST['itemCode'];
$deliveryDate = $_REQUEST['delivery_date'];
//$product = $ins->getProduct(API_USER, API_PASSWORD, $itemCode);
 $r = mysql_query("select " . $prev . "cart.*,products.name,products.price,products.product_no,products.id as product_id,products.flowerwyz_image," . $prev . "cart.type_id from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'");
$product = @mysql_fetch_array($r);

$type_id = $product['type_id'];
$all_price = $product['price'];
if($type_id == '1'){
$arrProducts = array(
    0 =>
    array(
        "code" => $product['product_no'],
        "price" => $product['price']
    ),
);
$ins->getTotal(API_USER, API_PASSWORD, $strZipCode, $arrProducts, $strAffiliateServiceCharge = '', $strAffiliateTax = '');

$service_charge = $ins->arrTotal['serviceChargeTotal'];

 $total = $all_price + $service_charge;
}
elseif($type_id == '2'){
    $ch = curl_init();
$username = '123456';
$password = 'abcd';
$auth = base64_encode("{$username}:{$password}");
$products = array(array('code' => $itemCode, 'deliverydate' => $deliveryDate, 'rpa' => 0)); //one item
//$products = array(array('code' => 'WGX673', 'deliverydate' => '10/29/2015', 'rpa' => 5), array('code' => 'WGCDNGM53', 'deliverydate' => '10/30/2015', 'rpa' => 4)); //two items
$products = json_encode($products);
curl_setopt_array(
	$ch,
	array(
		CURLOPT_URL => "https://www.floristone.com/api/rest/giftbaskets/gettotal?products=$products",
		CURLOPT_HTTPHEADER => array("Authorization: {$auth}"),
		CURLOPT_RETURNTRANSFER => true
	)
);
$output = json_decode(curl_exec($ch)); // return obj
curl_close($ch);

$products = $output->PRODUCTS;


$service_charge = $output->SHIPPINGTOTAL;
$total = $all_price + $service_charge;
}

$_SESSION['service_charge'] = $service_charge;
?>
<div class="panel panel-default" id="ajaxCartSummary">
    <div class="panel-body questions">
        <div class="summary">
            <h3>Cart Summary</h3>
            <table class="summary-table">
                <tbody>
                    <tr>
                        <td class="item">All Items</td>
                        <td class="price"><span class="purchase_display_currency">$</span><?php echo $all_price; ?></td>

                    </tr>
                    <tr>
                        <td class="item">Service Charge</td>
                        <td class="price"><span class="purchase_display_currency">$</span><?php echo $service_charge; ?></td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-footer summary">
        <div class="summary-total">
            <div class="total-label">Total (USD)</div>
            <div class="total-price"><span class="purchase_display_currency">$</span><?php echo $total;  ?></div>
        </div>
    </div>
</div>


