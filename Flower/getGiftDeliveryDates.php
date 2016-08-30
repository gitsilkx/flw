<?php
$ch = curl_init();
$username = '527492';
$password = '8EEkyK';
$auth = base64_encode("{$username}:{$password}");
$code = 'WGD413';
curl_setopt_array(
	$ch,
	array(
		CURLOPT_URL => "https://www.floristone.com/api/rest/giftbaskets/getproducts?code=$code",
		CURLOPT_HTTPHEADER => array("Authorization: {$auth}"),
		CURLOPT_RETURNTRANSFER => true
	)
);
$output = json_decode(curl_exec($ch)); // return obj
curl_close($ch);
$products = $output->PRODUCTS;
$availabledeliverydates = $products[0]->AVAILABLEDELIVERYDATES;

?>
<option value="">Select Delivery Date *</option>
<?php
for ($y = 0; $y < count($availabledeliverydates); $y++) {
    echo '<option value="'.$availabledeliverydates[$y]->SHIPPINGTYPE.'|'.$availabledeliverydates[$y]->DATE.'">'.date('l, jS F Y',  strtotime($availabledeliverydates[$y]->DATE)).' - $'.$availabledeliverydates[$y]->SHIPPINGPRICE.'</option>';
}
?>
