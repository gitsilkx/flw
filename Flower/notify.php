<?php
include("include/header.php");
include("getProducts.php");
ob_start();

$ip = $_SERVER['REMOTE_ADDR'];
$geopluginURL = 'http://www.geoplugin.net/php.gp?ip=' . $ip;
$details = unserialize(file_get_contents($geopluginURL));
//$to = 'biswajit@wtbglobal.com';
$to = 'flowerwyz@gmail.com';
$header1 = "";
$header2 = "";
$header3 = "";
$header4 = "";
$header5 = "";
$deliverydate = '';
$itemCode = '';
$carddate = '';
$raddress1 = '';
$raddress2 = '';
$rcity = '';
$rcountry = '';
$cemail = '';
$rattention = '';
$rfirstname = '';
$rlastname = '';
$rphone = '';
$rstate = '';
$rzip = '';
$caddress1 = '';
$caddress2 = '';
$ccity = '';
$ccountry = '';
$cfirstname = '';
$clastname = '';
$cphone = '';
$cstate = '';
$czip = '';
$ccardnum = '';
$cvv2 = '';
$ccardtype = '';
$ccardname = '';
$rinstructions = '';
$renclosure = '';
$flag = 0;
$result = mysql_query("SELECT * FROM " . TABLE_PERMISSION . " WHERE id=1");
$row = mysql_fetch_object($result);
if ($row->is_live == 'N') {
    $subject = "Sending New Order[T]";
    $flag = 3;
} else {
    $subject = "Sending New Order";
}


if ($_REQUEST['save'] == 'Continue') {

    $deliverydate = $_POST['deliverydate'];
    $itemCode = $_POST['itemCode'];
    $carddate = $_POST['experition_date'];
    $experition_date = explode('/', $carddate);
    $ccExpMonth = $experition_date[0];
    $ccExpYear = $experition_date[1];
    $raddress1 = $_POST['raddress1'];
    $raddress2 = $_POST['raddress2'];
    $rcity = $_POST['rcity'];
    $rcountry = $_POST['rcountry'];
    $cemail = $_POST['cemail'];
    $rattention = $_POST['rattention'];
    $rfirstname = $_POST['rfirstname'];
    $rlastname = $_POST['rlastname'];
    $rphone = $_POST['rphone'];
    $rstate = $_POST['rstate'];
    $rzip = $_POST['rzip'];
    $caddress1 = $_POST['caddress1'];
    $caddress2 = $_POST['caddress2'];
    $ccity = $_POST['ccity'];
    $ccountry = $_POST['ccountry'];
    $cfirstname = $_POST['cfirstname'];
    $clastname = $_POST['clastname'];
    $cphone = $_POST['cphone'];
    $phone_code = $_POST['phone_code'];
    //$cphone = str_pad($cph, 10, "0", STR_PAD_LEFT);
    //$cphone = '(000) 007 6646';
    $cstate = $_POST['cstate'];
    $czip = $_POST['czip'];
    $ccardnum = $_POST['ccardnum'];
    $cvv2 = $_POST['cvv2'];
    $ccardtype = $_POST['ccardtype'];
    $ccardname = $_POST['ccardname'];
    $rinstructions = $_POST['rinstructions'];
    $renclosure = $_POST['renclosure'];
    $cur_time = date('m/d/Y H:i:s');
    $dateTime = new DateTime($cur_time, new DateTimeZone('America/New_York'));
    
    
    
    
    if (!empty($cphone)) {
        $cphone = preg_replace('/\D/', '', $cphone);
        if (strlen($cphone) > 10)
            $cphone = substr($cphone, 0, 10);
        else
            $cphone = str_pad($cphone, 10, '0', STR_PAD_RIGHT);
    }
    $err_msg = '';

    if ($itemCode == '') {
        $err_msg = "Please select at least one product.";
        $flag = 2;
    }
    if ($rfirstname == '') {
        $err_msg .= " Recipient First Name.";
        $flag = 1;
    }
    if ($rlastname == '') {
        $err_msg .= " Recipient Last Name.";
        $flag = 1;
    }
    if ($rphone == '') {
        $err_msg .= " Recipient Phone Number.";
        $flag = 1;
    }
    if (!empty($rphone)) {
        // $rphonestr = preg_replace('/\D/', '', $rphone);
        if (!preg_match('/^\(\d{3}\) \d{3} \d{4}$/', $rphone)) {
            $err_msg .= 'Please Enter Valid Recipient Phone Number.';
            $flag = 1;
        }
    }
    if ($raddress1 == '') {
        $err_msg .= " Recipient Address.";
        $flag = 1;
    }
    if ($rcountry == '') {
        $err_msg .=" Recipient Country.";
        $flag = 1;
    }
    if ($rstate == '') {
        $err_msg .= " Recipient State.";
        $flag = 1;
    }

    if ($rcity == '') {
        $err_msg .= " Recipient City.";
        $flag = 1;
    }
    if ($rzip == '') {
        $err_msg .= " Recipient Zip Code.";
        $flag = 1;
    }
    if ($renclosure == '') {
        $err_msg .= " Message On Card.";
        $flag = 1;
    }
    if ($deliverydate == '') {
        $err_msg .= " Delivery Date.";
        $flag = 1;
    }
    if ($cfirstname == '') {
        $err_msg .= " Billing First Name.";
        $flag = 1;
    }
    if ($clastname == '') {
        $err_msg .= " Billing Last Name.";
        $flag = 1;
    }
    if ($caddress1 == '') {
        $err_msg .=" Billing Address.";
        $flag = 1;
    }
    if ($ccountry == '') {
        $err_msg .= " Billing Country.";
        $flag = 1;
    }
    if ($cstate == '') {
        $err_msg .= " Billing State.";
        $flag = 1;
    }

    if ($ccity == '') {
        $err_msg .= " Billing City.";
        $flag = 1;
    }
    if ($czip == '') {
        $err_msg .= " Billing Zip Code.";
        $flag = 1;
    }
    if ($cphone == '') {
        $err_msg .= " Billing Phone Number.";
        $flag = 1;
    }
    /*
      if(!empty($cphone)){

      if(!preg_match('/^\(\d{3}\) \d{3} \d{4}$/', $cphone)) {
      $err_msg .= 'Please Enter Valid Billing Phone Number.';
      $flag = 1;
      }
      }
     * */

    if ($cemail == '') {
        $err_msg .= " Billing Email.";
        $flag = 1;
    }
    if ($ccardtype == '') {
        $err_msg .= " Card Type.";
        $flag = 1;
    }
    if ($ccardname == '') {
        $err_msg .= " Card Name.";
        $flag = 1;
    }
    if ($ccardnum == '') {
        $err_msg .= " Card Number.";
        $flag = 1;
    }
    if (!empty($ccardnum)) {
        $ccardnum = preg_replace('/\D/', '', $ccardnum);
        if (!preg_match("/^[0-9]{16}+$/", $ccardnum)) {
            $err_msg .= 'Please Enter Valid Card Number.';
            $flag = 1;
        }
    }
    if ($carddate == '') {
        $err_msg .= " Expriation Date.";
        $flag = 1;
    }
    if ($cvv2 == '') {
        $err_msg .= " CVV Code.";
        $flag = 1;
    }


    $r1 = mysql_query("update " . $prev . "cart set rfirstname='" . $rfirstname . "',rlastname='" . $rlastname . "',rattention='" . $rattention . "',rphone='" . $rphone . "',rstate='" . $rstate . "'
             ,rcountry='" . $rcountry . "',rcity='" . $rcity . "',rzip='" . $rzip . "',renclosure='" . $renclosure . "',rinstructions='" . $rinstructions . "',raddress1='" . $raddress1 . "',raddress2='" . $raddress2 . "'
                 ,cfirstname='" . $cfirstname . "',clastname='" . $clastname . "',caddress1='" . $caddress1 . "',caddress2='" . $caddress2 . "',ccity='" . $ccity . "',ccountry='" . $ccountry . "',cstate='" . $cstate . "',czip='" . $czip . "'
                     ,phone_code='" . $phone_code . "',cphone='" . $cphone . "',cemail='" . $cemail . "',ccardname='" . $ccardname . "',ccardtype='" . $ccardtype . "'
                         ,ccardnum='" . $ccardnum . "',experition_date='" . $carddate . "',cvv='" . $cvv2 . "' where purchased='N' and OrderID='" . GetCartId() . "'");


    $r = mysql_query("select " . $prev . "cart.*,products.name,products.price,products.product_no,products.id as product_id,products.flowerwyz_image," . $prev . "cart.type_id from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'");
    $product = @mysql_fetch_array($r);

    $type_id = $product['type_id'];
    $amount = $product['total'];
    $q = "insert into " . $prev . "orders set 
					user_id=\"" . $_SESSION['user_id'] . "\",
					ip_address=\"" . $ip . "\",
					amount=\"" . $amount . "\",
					status='P',
                                        type_id = \"" . $type_id . "\",
                                        service_charges = \"" . $_SESSION['service_charge'] . "\",
					ord_date=\"" . date("Y-m-d H:i:s", $dateTime->format('U')) . "\"";
    $rr = mysql_query($q);
    $OrderID = mysql_insert_id();
    unset($_SESSION['service_charge']);
    if ($rr) {
        mysql_query("update " . $prev . "cart set OrderID='" . $OrderID . "',user_id='" . $_SESSION['user_id'] . "' where purchased='N' and OrderID='" . GetCartId() . "'");
    }


    if ($flag == 0 || $flag == 3) {

        if ($type_id == '1') { //flower
            
            $type = 'Flower';
            $product = $ins->getProduct(API_USER, API_PASSWORD, $itemCode);
            $arrProducts = array(
                0 =>
                array(
                    "code" => $product['code'],
                    "price" => $product['price']
                ),
            );
            $ins->getTotal(API_USER, API_PASSWORD, $_POST['rzip'], $arrProducts, $strAffiliateServiceCharge = '', $strAffiliateTax = '');

            $arrRecipient = array("address1" => $raddress1, "address2" => $raddress2, "city" => $rcity, "country" => $rcountry, "email" => $cemail, "institution" => $rattention, "name" => $rfirstname . ' ' . $rlastname, "phone" => $rphone, "state" => $rstate, "zip" => $rzip);
            $arrCustomer = array("address1" => $caddress1, "address2" => $caddress2, "city" => $ccity, "country" => $ccountry, "email" => $cemail, "institution" => $rattention, "name" => $cfirstname . ' ' . $clastname, "phone" => $cphone, "state" => $cstate, "zip" => $czip);
            $customerIP = $ip;
            // $customerIP = '127.127.127.127';
            //$arrCCInfo = array("ccExpMonth"=>11,"ccExpYear"=>18,"ccNum"=>"4445999922225","ccSecCode"=>"999","ccType"=>"VI");$cardMsg = "I LOVE YOU LETISHA!!"; //ccNum->CreditCard Number
            $arrCCInfo = array("ccExpMonth" => $ccExpMonth, "ccExpYear" => $ccExpYear, "ccNum" => $ccardnum, "ccSecCode" => $cvv2, "ccType" => $ccardtype);

            $cardMsg = trim($renclosure); //ccNum->CreditCard Number
            $specialInstructions = trim($rinstructions);
            //$deliveryDate = $deliverydate . 'T' . date('H:i:s') . 'Z'; //"2015-04-29T05:00:00.000Z"; //you can get this value from getDeliveryDates() call... the value must be dateTime format eg: 2011-01-15T05:00:00.000Z
            $affiliateServiceCharge = "0";
            $affiliateTax = "0";
            $orderTotal = $product['price'] + $ins->arrTotal['serviceChargeTotal']; // You can get this value from getTotal() call.... $this->arrTotal['orderTotal'];
            $subAffiliateID = 0;

            if ($row->is_live == 'Y') {
                $ins->placeOrder(API_USER, API_PASSWORD, $arrRecipient, $arrCustomer, $customerIP, $arrCCInfo, $arrProducts, $cardMsg, $specialInstructions, $deliverydate, $affiliateServiceCharge, $affiliateTax, $orderTotal, $subAffiliateID); //return value stored in $this->arrOrder
                $order_no = $ins->arrOrder['orderNumber'];
            }
        } elseif ($type_id == '2') { //gift
            
            $type = 'Gift';
            $recipient[1] = array(
                'name' => $rfirstname . ' ' . $rlastname,
                'institution' => $rattention,
                'address1' => $raddress1,
                'address2' => $raddress2,
                'city' => $rcity,
                'state' => $rstate,
                'zipcode' => $rzip,
                'country' => $rcountry,
                'phone' => $rphone,
            );
            $totalProduct[] = array('code' => $itemCode, 'deliverydate' => $deliverydate, 'rpa' => 0);
            $products[] = array(
                'code' => $itemCode,
                'deliverydate' => $deliverydate,
                'rpa' => 0,
                'cardmsg' => $renclosure,
                'recipient' => $recipient[1]
            );

            $customer = json_encode(array(
                'name' => $cfirstname . ' ' . $clastname,
                'address1' => $caddress1,
                'address2' => $caddress2,
                'city' => $ccity,
                'state' => $cstate,
                'zipcode' => $czip,
                'country' => $ccountry,
                'phone' => $rphone,
                'email' => $cemail,
                'ip' => $ip
            ));

            $ccinfo = json_encode(array(
                'type' => $ccardtype,
                'expmonth' => $ccExpMonth,
                'expyear' => $ccExpYear,
                'ccnum' => $ccardnum,
                'cvv2' => $cvv2
            ));

            $ch = curl_init();
            $username = '527492';
            $password = '8EEkyK';
            $auth = base64_encode("{$username}:{$password}");

//$products = array(array('code' => 'WGG193', 'deliverydate' => '04/30/2016', 'rpa' => 0),array('code' => 'WGG193', 'deliverydate' => '04/29/2016', 'rpa' => 0)); //one item
//echo '<pre>';
//print_r($products);
//die;
//$products = array(array('code' => 'WGX673', 'deliverydate' => '10/29/2015', 'rpa' => 5), array('code' => 'WGCDNGM53', 'deliverydate' => '10/30/2015', 'rpa' => 4)); //two items
            $totalProduct = json_encode($totalProduct);

            curl_setopt_array(
                    $ch, array(
                CURLOPT_URL => "https://www.floristone.com/api/rest/giftbaskets/gettotal?products=$totalProduct",
                CURLOPT_HTTPHEADER => array("Authorization: {$auth}"),
                CURLOPT_RETURNTRANSFER => true
                    )
            );
            $output = json_decode(curl_exec($ch)); // return obj
            //curl_close($ch);

            $orderTotal = $output->ORDERTOTAL;
            $products = json_encode($products);            
            //$gift_email_message .="Total - $" . $ordertotal . "<br><br>";
            $data = array('products' => $products, 'customer' => $customer, 'ccinfo' => $ccinfo, 'ordertotal' => $orderTotal);
            curl_setopt_array(
                    $ch, array(
                CURLOPT_URL => "https://www.floristone.com/api/rest/giftbaskets/placeorder",
                CURLOPT_HTTPHEADER => array("Authorization: {$auth}"),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data
                    )
            );


            $response = curl_exec($ch);


// curl_exec returns either the result or boolean false if something went wrong
            if ($response !== false) {
                $output = json_decode($response);
                $order_no = $output->ORDERNO;
                //print_r($output);        
                $order = 'completed';
            }
        }


        $current = strtotime(date("Y-m-d"));
        $date = strtotime($deliverydate);

        $datediff = $date - $current;
        $difference = floor($datediff / (60 * 60 * 24));

        $email_message = "Flower Name - " . $product['name'] . "<br>";
        $email_message .= "Product Type - " . $type . "<br>";
        $email_message .= "Product No. - " . $itemCode . "<br>";
        $email_message .="Price - $" . $product['price'] . "<br>";
        $email_message .="Total - $" . $orderTotal . "<br><br>";

        $email_message .="<b>SHIPPING DETAILS-</b> <br>";
        $email_message .="Delivery Date - " . $deliverydate . " [" . GetDay($difference) . "]" . "<br>";
        $email_message .="Name - " . $rfirstname . " " . $rlastname . "<br>";
        $email_message .="Institution - " . $rattention . "<br>";
        $email_message .="Address1 - " . $raddress1 . "<br>";
        $email_message .="Address2 - " . $raddress2 . "<br>";
        $email_message .="City - " . $rcity . "<br>";
        $email_message .="State - " . $rstate . "<br>";
        $email_message .="Country - " . $rcountry . "<br>";
        $email_message .="Zip Code - " . $rzip . "<br>";
        $email_message .="Phone - " . $rphone . "<br>";
        $email_message .="Special Delivery Instructions - " . $rinstructions . "<br>";
        $email_message .="Message On Card - " . $renclosure . "<br><br>";

        $email_message .="<b>BILLING DETAILS-</b> <br>";
        $email_message .="Name - " . $cfirstname . " " . $clastname . "<br>";
        $email_message .="Address1 - " . $caddress1 . "<br>";
        $email_message .="Address2 - " . $caddress2 . "<br>";
        $email_message .="Email - " . $cemail . "<br>";
        $email_message .="City - " . $ccity . "<br>";
        $email_message .="State - " . $cstate . "<br>";
        $email_message .="Country - " . $ccountry . "<br>";
        $email_message .="Zip Code - " . $czip . "<br>";
        $email_message .="Phone - " . $phone_code . ' ' . $cphone . "<br><br>";

        $email_message .="<b>PAYMENT METHODS-</b><br>";
        $email_message .="Card - " . $ccardtype . "<br>";
        $email_message .="Name On Card - " . $ccardname . "<br>";
        $email_message .="Card No. - " . $ccardnum . "<br>";
        $email_message .="CVV Code - " . $cvv2 . "<br>";
        $email_message .="Expriation Date - " . $carddate . "<br><br>";

        $ua = getBrowser();
        $email_message .="<b>LOGISTICS-</b><br>";
        $email_message .="IP - " . $ip . "<br>";
        $email_message .="Country - " . $details['geoplugin_countryName'] . "<br>";
        $email_message .="State - " . $details['geoplugin_region'] . "<br>";
        $email_message .="City - " . $details['geoplugin_city'] . "<br>";
        $a = date('m/d/Y H:i:s');
        $date = new DateTime($a, new DateTimeZone('America/New_York'));

        $email_message .="Timestamp - " . date("m/d/Y H:i:s", $date->format('U')) . " EST<br>";
        $email_message .="Device - " . userAgent($_SERVER['HTTP_USER_AGENT']) . "<br>";
        $email_message .="Browser - " . $ua['name'];



        $headers = "From: admin@flowerwyz.com \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        mail($to, $subject, $email_message, $headers);



        if ($order_no) {
            $header1 = "Thank You For Your Order!";
            $header2 = "We Will Get Started With It Right Away.";
            $header3 = "Your Order Number is: #" . $order_no;
            $subject = "Completed New Order #" . $order_no;
            $q3 = mysql_query("update " . $prev . "cart set purchased='Y',order_no='" . $order_no . "' where OrderID='$OrderID'");
            $q1 = mysql_query("update " . $prev . "orders set status = 'D',order_no='" . $order_no . "' where OrderID = '$OrderID'");

            mail($to, $subject, $email_message, $headers);
        } elseif ($ins->arrOrder['faultstring']) {
            $header1 = "OOPS! Your Order Didn't Go Through!";
            $header2 = "Something Went Wrong With Your Credit Card Payment.";
            $header3 = "Please Try With A Different Credit Card.";
            $header5 = "<a href= '" . $vpath . "checkout.php?code=" . $itemCode . "'>Click here to try again</a>";
            $a = explode(':', $ins->arrOrder['faultstring']);
            $subject = "Failure Returned";
            $email_message = "Message - " . end($a) . "<br>";
            $email_message .= "OOPS! Your Order Didn't Go Through! <br>Something Went Wrong With Your Credit Card Payment.<br>Please Try With A Different Credit Card.";
            $b = date('m/d/Y H:i:s');
            $date = new DateTime($b, new DateTimeZone('America/New_York'));

            $email_message .= "Timestamp - " . date("m/d/Y H:i:s", $date->format('U')) . " EST<br>";
            mail($to, $subject, $email_message, $headers);
        } elseif ($row->is_live == 'Y') {
            $header1 = "OOPS! Your Order Didn't Go Through!";
            $header2 = "Something Went Wrong With Your Credit Card Payment.";
            $header3 = "Please Try With A Different Credit Card.";
            $header5 = "<a href= '" . $vpath . "checkout.php?code=" . $itemCode . "'>Click here to try again</a>";
            $subject = "XML Returned Void";
            $c = date('m/d/Y H:i:s');
            $date = new DateTime($c, new DateTimeZone('America/New_York'));
            $a = explode(':', $ins->arrOrder['faultstring']);
            $email_message = "OOPS! Your Order Didn't Go Through! <br>Something Went Wrong With Your Credit Card Payment.<br>Please Try With A Different Credit Card." . end($a);
            $email_message .= "Timestamp - " . date("m/d/Y H:i:s", $date->format('U')) . " EST<br>";
            mail($to, $subject, $email_message, $headers);
        } elseif ($row->is_live == 'N') {
            $header2 = "Your Information Has Been Submitted. We Will Get Back To You Shortly.";
            //$to = 'flowerwyz@gmail.com';
            $subject = "XML Has Not Been Called";
            $email_message = "Your Information Has Been Submitted. We Will Get Back To You Shortly.";
            mail($to, $subject, $email_message, $headers);
        }
    } elseif ($flag == 1) {
        $header1 = "OOPS! Your Order Didn't Go Through!";
        $header2 = "Missing Values - " . $err_msg;
        $header5 = "<a href= '" . $vpath . "checkout.php?code=" . $itemCode . "'>Click here to try again</a>";
        //$to = 'flowerwyz@gmail.com';
        $subject = "Missing Values";
        $c = date('m/d/Y H:i:s');
        $a = explode(':', $ins->arrOrder['faultstring']);
        $date = new DateTime($c, new DateTimeZone('America/New_York'));
        $email_message = "Missing Values - " . $err_msg;
        $email_message .= end($a) . "<br>";
        $email_message .= "Timestamp - " . date("m/d/Y H:i:s", $date->format('U')) . " EST<br>";
        mail($to, $subject, $email_message, $headers);
    } elseif ($flag == 2) {
        $header1 = "OOPS! Your Order Didn't Go Through!";
        $header2 = $err_msg;
        $header3 = "Please Try With A Different Item.";
        //$to = 'flowerwyz@gmail.com';
        $subject = "Invalid Item";
        $c = date('m/d/Y H:i:s');
        $date = new DateTime($c, new DateTimeZone('America/New_York'));
        $email_message = "Invalid Item!";
        $email_message .= "Timestamp - " . date("m/d/Y H:i:s", $date->format('U')) . " EST<br>";
        mail($to, $subject, $email_message, $headers);
    }
} else {
    header('location:index.htm');
}
?>
<style>
    .header5{        
        width: 100%;
        text-align: center;
        float: right;       
        text-decoration: underline;
    }
    .header5 a{
        color: blue;
    }
</style>
<div class="innerWrap">         
    <div class="row-fluid">

        <div class="Content" id="section">
            <div class="content_first">
                <span class="header1"><?php echo $header1 ?></span>
                <span class="header2"><?php echo $header2; ?></span>
                <span class="header3"><?php echo $header3; ?></span>
                <span class="header5"><?php echo $header5; ?></span>
            </div>
            <div style="clear: both"></div>
            <div class="content_secnd">
                <span class="header4">ALSO CHECK OUT SOME OF OUR BEST SELLING FLOWERS BELOW</span>
                <div class="line"></div>
                <table class="FeaturedProducts notify" width="100%" align="center" border="0" cellpadding="0" cellspacing="1">
                    <tbody>
                        <tr> 
                            <td>
                                <div class="ProductImage ">
                                    <a><img src="https://www.flowerwyz.com/images/send-flowers.jpg" alt="" height="211px" width="183px"></a>
                                </div>
                                <div class="ProductDetails">
                                    <a>Send Flowers Anywhere</a>
                                </div>
                                <div class="ProductPriceRating">
                                    <em>Lights of the Season</em>
                                    <em>$49.95</em>
                                </div>
                                <div style="text-align:center; margin-top:5px;">
                                    <a href="<?= $vpath; ?>item.php?code=B9-4833"  data-fancybox-type="iframe" class="splFancyIframe btn-pink">VIEW ITEM</a>
                                </div>
                            </td>
                            <td>
                                <div class="ProductImage ">
                                    <a><img src="https://www.flowerwyz.com/images/online-flower-delivery.jpg" alt="" height="211px" width="183px"></a>
                                </div>
                                <div class="ProductDetails">
                                    <a>Send Flowers Anywhere</a>
                                </div>
                                <div class="ProductPriceRating">
                                    <em>The Winter Wishes Bouquet</em>
                                    <em>$64.95</em>
                                </div>
                                <div style="text-align:center; margin-top:5px;">
                                    <a href="<?= $vpath; ?>item.php?code=B17-4362"  data-fancybox-type="iframe" class="splFancyIframe btn-pink">VIEW ITEM</a>
                                </div>
                            </td>
                            <td>
                                <div class="ProductImage ">
                                    <a><img src="https://www.flowerwyz.com/images/flowers-delivered.jpg" alt="" height="211px" width="183px"></a>
                                </div>
                                <div class="ProductDetails">
                                    <a>Send Flowers Anywhere</a>
                                </div>
                                <div class="ProductPriceRating">
                                    <em>Spirit of the Season</em>
                                    <em>$49.95</em>
                                </div>
                                <div style="text-align:center; margin-top:5px;">
                                    <a href="<?= $vpath; ?>item.php?code=B10-4787"  data-fancybox-type="iframe" class="splFancyIframe btn-pink">VIEW ITEM</a>
                                </div>
                            </td>
                            <td>
                                <div class="ProductImage ">
                                    <a><img src="https://www.flowerwyz.com/images/deliver-flowers.jpg" alt="" height="211px" width="183px"></a>
                                </div>
                                <div class="ProductDetails">
                                    <a>Send Flowers Anywhere</a>
                                </div>
                                <div class="ProductPriceRating">
                                    <em>The Abundant Harvest Basket</em>
                                    <em>$49.95</em>
                                </div>
                                <div style="text-align:center; margin-top:5px;">
                                    <a href="<?= $vpath; ?>item.php?code=B3-4347"  data-fancybox-type="iframe" class="splFancyIframe btn-pink">VIEW ITEM</a>
                                </div>
                            </td>
                            <td>
                                <div class="ProductImage ">
                                    <a><img src="https://www.flowerwyz.com/images/sending-flowers.jpg" alt="" height="211px" width="183px"></a>
                                </div>
                                <div class="ProductDetails">
                                    <a>Send Flowers Anywhere</a>
                                </div>
                                <div class="ProductPriceRating">
                                    <em>The Season's Glow Centerpiece</em>
                                    <em>$59.95</em>
                                </div>
                                <div style="text-align:center; margin-top:5px;">
                                    <a href="<?= $vpath; ?>item.php?code=B16-4830"  data-fancybox-type="iframe" class="splFancyIframe btn-pink">VIEW ITEM</a>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include("include/footer.php"); ?>