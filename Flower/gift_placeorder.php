<html>
<head>
<title>Florist One - REST API - GiftBaskets/placeOrder</title>
</head>
<body>
<?php
$ch = curl_init();
$username = '527492';
$password = '8EEkyK';
$auth = base64_encode("{$username}:{$password}");

$recipient = array(
	'name' => 'John Doe', 
	'institution' => '', 
	'address1' => '123 Big Street', 
	'address2' => '', 
	'city' => 'Wilmington', 
	'state' => 'DE', 
	'zipcode' => '11779', 
	'country' => 'US', 
	'phone' => '123-123-1234',	
);
$recipient1 = array(
	'name' => 'John Doe', 
	'institution' => '', 
	'address1' => '123 Big Street', 
	'address2' => '', 
	'city' => 'Wilmington', 
	'state' => 'DE', 
	'zipcode' => '11779', 
	'country' => 'US', 
	'phone' => '123-123-1234',	
);

$products = json_encode(array(
	array(
		'code' => 'WGG193', 
		'deliverydate' => '04/29/2016',
		'rpa' => 0,
		'cardmsg' => 'Happy Birthday!',
		'recipient' => $recipient
	),
    array(
		'code' => 'WGG193', 
		'deliverydate' => '04/29/2016',
		'rpa' => 0,
		'cardmsg' => 'Happy Birthday!',
		'recipient' => $recipient1
	)
));

$customer = json_encode(array(
	'name' => 'John Doe', 
	'address1' => '123 Big Street', 
	'address2' => '', 
	'city' => 'Wilmington', 
	'state' => 'DE', 
	'zipcode' => '11779', 
	'country' => 'US', 
	'phone' => '123-123-1234',	
	'email' => 'phil@floristone.com',
	'ip' => '0.0.0.0' 
));

$ccinfo = json_encode(array(
	'type' => 'VI', 
	'expmonth' => 01, 
	'expyear' => 19, 
	'ccnum' => 1234123412341234, 
	'cvv2' => 123
));


$ordertotal = 149.96;

$data = array('products' => $products, 'customer' => $customer, 'ccinfo' => $ccinfo, 'ordertotal' => $ordertotal);
//print_r(json_encode($data));

curl_setopt_array(
	$ch,
	array(
		CURLOPT_URL => "https://www.floristone.com/api/rest/giftbaskets/placeorder",
		CURLOPT_HTTPHEADER => array("Authorization: {$auth}"),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $data
	)
);


$response = curl_exec($ch);
//print_r($response);

// curl_exec returns either the result or boolean false if something went wrong
if ($response !== false) {
	$output = json_decode($response);
        echo $output->ORDERNO;
	//print_r($output);
} else {
	echo "Something went wrong!!";
}
curl_close($ch);

?>
</body>
</html>