<?php
include("configs/path.php");
include("getProducts.php");


$ip = $_SERVER['REMOTE_ADDR'];
$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip;
$details = unserialize(file_get_contents($geopluginURL));


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
$panel = '';
//print_r($_POST);
if ($_GET['itemCode'] && $_GET['itemCode'] != '') {
     $itemCode = $_GET['itemCode'];
}

$product = $ins->getProduct(API_USER, API_PASSWORD, $itemCode);

$num_of_days = date('t');
for ($i = date('d'); $i <= $num_of_days; $i++) {
    $dates[date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT)] = date("l", mktime(0, 0, 0, date('m'), $i, date('Y'))) . ' ' . date("M $i,Y");
}

$result = mysql_query("SELECT * FROM ". TABLE_PERMISSION ." WHERE id=1");
$row= mysql_fetch_object($result);
if($row->is_live == 'N')
    $subject = "Payment Page Access[T]";
else
    $subject = "Payment Page Access";

//print_r($_POST);
if ($_POST['save'] == 'Place Order') {

    $deliverydate = $_POST['deliverydate1'];
    $itemCode = $_POST['itemCode'];
    $carddate = $_POST['experition_date1'];
    $experition_date = explode('/', $carddate);
    $ccExpMonth = $experition_date[0];
    $ccExpYear = $experition_date[1];
    $raddress1 = $_POST['raddress1_1'];
    $raddress2 = $_POST['raddress2_1'];
    $rcity = $_POST['rcity1'];
    $rcountry = $_POST['rcountry1'];
    $cemail = $_POST['cemail1'];
    $rattention = $_POST['rattention1'];
    $rfirstname = $_POST['rfirstname1'];
    $rlastname = $_POST['rlastname1'];
    $rphone = $_POST['rphone1'];
    $rstate = $_POST['rstate1'];
    $rzip = $_POST['rzip1'];
    $caddress1 = $_POST['caddress1_1'];
    $caddress2 = $_POST['caddress2_1'];
    $ccity = $_POST['ccity1'];
    $ccountry = $_POST['ccountry1'];
    $cfirstname = $_POST['cfirstname1'];
    $clastname = $_POST['clastname1'];
    $cphone = $_POST['cphone1'];
    $phone_code = $_POST['phone_code1'];
    $cstate = $_POST['cstate1'];
    $czip = $_POST['czip1'];
    $ccardnum = $_POST['ccardnum1'];
    $cvv2 = $_POST['cvv2_1'];
    $ccardtype = $_POST['ccardtype1'];
    $ccardname = $_POST['ccardname1'];
    $rinstructions = $_POST['rinstructions1'];
    $renclosure = $_POST['renclosure1'];
    $panel_order = 'order';
    $panel = 'generate';
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
        
        $ins->placeOrder(API_USER, API_PASSWORD, $arrRecipient, $arrCustomer, $customerIP, $arrCCInfo, $arrProducts, $cardMsg, $specialInstructions, $deliverydate, $affiliateServiceCharge, $affiliateTax, $orderTotal, $subAffiliateID); //return value stored in $this->arrOrder
        
        
        $arrRecipient = "array(address1 =>" .$raddress1. ",address2 =>". $raddress2. ",city =>". $rcity ."country =>". $rcountry .",email =>". $cemail ."institution =>". $rattention. "name =>". $rfirstname  .' ' . $rlastname .",phone =>". $rphone. ",state =>". $rstate. ",zip =>". $rzip.")";
        $arrCustomer = "array(address1 =>" .$caddress1. ",address2 =>" .$caddress2. ",city =>".$ccity .",country =>" .$ccountry. ",email =>"  .$cemail. ",institution =>"  .$rattention. ",name =>" .$cfirstname . ' ' . $clastname. ",phone =>"  .$cphone. ",state=>".  $cstate. ",zip =>" .$czip.")";
        $arrCCInfo = "array(ccExpMonth =>". $ccExpMonth. ",ccExpYear =>" .$ccExpYear. ",ccNum =>". $ccardnum. ",ccSecCode =>". $cvv2. ",ccType => "  .$ccardtype.")";
        $generate_api = '$ins->placeOrder(';
        $generate_api .= API_USER.','.API_PASSWORD.','.$arrRecipient.','.$arrCustomer.','.$customerIP.','.$arrCCInfo.','.$arrProducts1.','.$cardMsg.','.$specialInstructions.','.$deliverydate.','.$affiliateServiceCharge.','.$affiliateTax.','.$orderTotal.','.$subAffiliateID;
        $generate_api .=')';
}

if($_POST['api_call'] == 'Generate API Call'){
    
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
    $cstate = $_POST['cstate'];
    $czip = $_POST['czip'];
    $ccardnum = $_POST['ccardnum'];
    $cvv2 = $_POST['cvv2'];
    $ccardtype = $_POST['ccardtype'];
    $ccardname = $_POST['ccardname'];
    $rinstructions = $_POST['rinstructions'];
    $renclosure = $_POST['renclosure'];
    /*
    if (!empty($cphone)) {
           $cphone = preg_replace('/\D/', '', $cphone);
           if(strlen($cphone) > 10)
                $cphone = substr($cphone, 0, 10);
           else
                $cphone = str_pad($cphone, 10, '0', STR_PAD_RIGHT);
            
        }
     * */
    
    $panel = 'generate';
    
    $product = $ins->getProduct(API_USER, API_PASSWORD, $itemCode);
        $arrProducts = array(
            0 =>
            array(
                "code" => $product['code'],
                "price" => $product['price']
            ),
        );
        $arrProducts1 = "array(code => ".$product['code'].",price => ".$product['price'].")";
        $ins->getTotal(API_USER, API_PASSWORD, $_POST['rzip'], $arrProducts, $strAffiliateServiceCharge = '', $strAffiliateTax = '');
        $arrRecipient1 = array("address1" => $raddress1, "address2" => $raddress2, "city" => $rcity, "country" => $rcountry, "email" => $cemail, "institution" => $rattention, "name" => $rfirstname . ' ' . $rlastname, "phone" => $rphone, "state" => $rstate, "zip" => $rzip);
        $arrRecipient = "array(address1 =>" .$raddress1. ",address2 =>". $raddress2. ",city =>". $rcity ."country =>". $rcountry .",email =>". $cemail ."institution =>". $rattention. "name =>". $rfirstname  .' ' . $rlastname .",phone =>". $rphone. ",state =>". $rstate. ",zip =>". $rzip.")";
        $arrCustomer = "array(address1 =>" .$caddress1. ",address2 =>" .$caddress2. ",city =>".$ccity .",country =>" .$ccountry. ",email =>"  .$cemail. ",institution =>"  .$rattention. ",name =>" .$cfirstname . ' ' . $clastname. ",phone =>"  .$cphone. ",state=>".  $cstate. ",zip =>" .$czip.")";
        $customerIP = $ip;
        // $customerIP = '127.127.127.127';
        //$arrCCInfo = array("ccExpMonth"=>11,"ccExpYear"=>18,"ccNum"=>"4445999922225","ccSecCode"=>"999","ccType"=>"VI");$cardMsg = "I LOVE YOU LETISHA!!"; //ccNum->CreditCard Number
        $arrCCInfo = "array(ccExpMonth =>". $ccExpMonth. ",ccExpYear =>" .$ccExpYear. ",ccNum =>". $ccardnum. ",ccSecCode =>". $cvv2. ",ccType => "  .$ccardtype.")";

        $cardMsg = trim($renclosure); //ccNum->CreditCard Number
        $specialInstructions = trim($rinstructions);
        //$deliveryDate = $deliverydate . 'T' . date('H:i:s') . 'Z'; //"2015-04-29T05:00:00.000Z"; //you can get this value from getDeliveryDates() call... the value must be dateTime format eg: 2011-01-15T05:00:00.000Z
        $affiliateServiceCharge = "0";
        $affiliateTax = "0";
        $orderTotal = $product['price'] + $ins->arrTotal['serviceChargeTotal']; // You can get this value from getTotal() call.... $this->arrTotal['orderTotal'];
        $subAffiliateID = 0;
        
        //$ins->placeOrder(API_USER, API_PASSWORD, $arrRecipient, $arrCustomer, $customerIP, $arrCCInfo, $arrProducts, $cardMsg, $specialInstructions, $deliverydate, $affiliateServiceCharge, $affiliateTax, $orderTotal, $subAffiliateID); //return value stored in $this->arrOrder
        $generate_api = '$ins->placeOrder(';
        $generate_api .= API_USER.','.API_PASSWORD.','.$arrRecipient.','.$arrCustomer.','.$customerIP.','.$arrCCInfo.','.$arrProducts1.','.$cardMsg.','.$specialInstructions.','.$deliverydate.','.$affiliateServiceCharge.','.$affiliateTax.','.$orderTotal.','.$subAffiliateID;
        $generate_api .=')';
        
}

?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <!--<html lang="en">-->
    <head>
        <style>
            .prev_step.disabled .btn-link {
                background-image: -webkit-gradient(linear, left 0, left 100%, from(#f5f5f5 ), to(#f1f1f1));
                background-image: -webkit-linear-gradient(top, #f5f5f5 , 0%, #f1f1f1, 100%);
                background-image: -moz-linear-gradient(top, #f5f5f5 0, #f1f1f1 100%);
                /* background-image: linear-gradient(to bottom, #f5f5f5 0, #f1f1f1 100%); */
                /* background-repeat: repeat-x; */
                border: 1px solid #f1f1f1;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f5f5f5 ', endColorstr='#f1f1f1', GradientType=0);
                filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            }


            label.warning {
                color: red;
                font-size:12px;
                margin-bottom:0px;
            }
            p.warning {
                color: #F00;
                font-size: 12px;
                margin-bottom: 0px;
            }
			.HideTodayButton .ui-datepicker-buttonpane .ui-datepicker-current
                        {
                            visibility:hidden;
                        }

                        .hide-calendar .ui-datepicker-calendar
                        {
                            display:none!important;
                            visibility:hidden!important
                        }
        </style>
        <!-- bootstrap framework-->
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="<?= $vpath ?>bootstrap/css/bootstrap.min.css">
            <title>FlowerWyz Secure Checkout</title>
            <!-- ebro styles -->
            <link rel="stylesheet" href="<?= $vpath ?>css/flower.css">
                <meta name="robots" content="noindex,nofollow" />

                <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/layout.css"/>
                <!-- jQuery -->
                <script type="text/javascript" src="<?= $vpath ?>js/jquery.min.js"></script>
                <!-- bootstrap framework -->
                <script type="text/javascript" src="<?= $vpath ?>bootstrap/js/bootstrap.min.js"></script>
                <!-- jQuery resize event -->
                <script type="text/javascript" src="<?= $vpath ?>js/jquery.ba-resize.min.js"></script>
                <!-- jquery cookie -->
                <script type="text/javascript" src="<?= $vpath ?>js/jquery_cookie.min.js"></script>
                <!-- retina ready -->
                <script type="text/javascript" src="<?= $vpath ?>js/retina.min.js"></script>
                <!-- tinyNav -->
                <script type="text/javascript" src="<?= $vpath ?>js/tinynav.js"></script>
                <!-- sticky sidebar -->
                <script type="text/javascript" src="<?= $vpath ?>js/jquery.sticky.js"></script>
                <!-- Navgoco -->
                <script type="text/javascript" src="<?= $vpath ?>js/lib/navgoco/jquery.navgoco.min.js"></script>
                <!-- jMenu -->
                <script type="text/javascript" src="<?= $vpath ?>js/lib/jMenu/js/jMenu.jquery.js"></script>
                <!-- typeahead -->
                <script type="text/javascript" src="<?= $vpath ?>js/lib/typeahead.js/typeahead.min.js"></script>
                <script type="text/javascript" src="<?= $vpath ?>js/lib/typeahead.js/hogan-2.0.0.js"></script>
                <script type="text/javascript" src="<?= $vpath ?>js/ebro_common.js"></script>

                <!-- clender -->
                <link  type="text/css" rel="stylesheet" href="<?= $vpath ?>css/jquery-ui.css">

                    <script type="text/javascript" src="<?= $vpath ?>js/jquery-ui.js"></script>

                    <!-- jquery steps -->
                    <script type="text/javascript" src="<?= $vpath ?>js/lib/jquery-steps/jquery.steps.min.js"></script>
                    <!-- parsley -->

                    <script type="text/javascript" src="<?= $vpath ?>js/jquery.validate.js"></script>

                    <script>
                        $(function() {
                            $("#datepicker").datepicker({
                                changeMonth: true,
                                changeYear: true,
                                minDate: 0,
                                maxDate: 30,
                                dateFormat: 'mm/dd/yy'
                            });

                            $(".monthPicker").datepicker({
                                dateFormat: 'mm-yy',
                                changeMonth: true,
                                changeYear: true,
                                showButtonPanel: true,
                                onClose: function(dateText, inst) {
                                    // var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                                    //var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                                    $(this).val($.datepicker.formatDate('mm/y', new Date(inst.selectedYear, inst.selectedMonth, 1)));
                                    //$(this).val($.datepicker.formatDate('mm/yy', new Date(year, month, 1)));
                                }
                            });

                            $(".monthPicker").focus(function() {
                                $(".ui-datepicker-calendar").hide();
                                $("#ui-datepicker-div").position({
                                    my: "center top",
                                    at: "center bottom",
                                    of: $(this)
                                });
                            });



                        });


                        $(function() {
                            var flagOne = false;
                            var flagTwo = false;
                            var flagThree = false;
                            var flagFour = false;
                            var FULL_BASE_URL = $('#hidden_site_baseurl').val(); // For base path of value;
                           

                            var v = $(".cmxform").validate({
                                errorClass: "warning",
                                onkeyup: false,
                                onfocusout: false,
                                submitHandler: function() {
                                    v.submit();
                                }
                            });

                            $("#accorBodyTwo").hide();
                            $("#accorBodyThree").hide();
                            $("#accorBodyFour").hide();

                            $("#goAccorTwo").click(function() {

                                $("#accorBodyTwo").show(400);
                                $("#accorBodyOne").hide(400);
                                $("#accorHeadOne").removeClass("selected");
                                $('#accorHeadOne').find('span').remove();
                                $("#accorHeadOne").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                $("#accorHeadTwo").addClass("selected");
                                flagOne = true;
                            });
                            $("#goAccorThree").click(function() {
                                if (v.form()) {

                                    $("#accorBodyThree").show(400);
                                    $("#accorBodyTwo").hide(400);
                                    $("#accorHeadTwo").removeClass("selected");
                                    $('#accorHeadTwo').find('span').remove();
                                    $("#accorHeadTwo").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                    $("#accorHeadThree").addClass("selected");

                                    flagTwo = true;
                                }
                            });
                            $("#goAccorFour").click(function() {
                                if (v.form()) {
                                    
                                var zip_code = $('#rzip').val();
                                var itemCode = $('#itemCode').val();
                                var dataString = 'zip_code=' + zip_code + '&itemCode=' + itemCode;
                                $('#ajaxCartSummary').addClass('loader1');

                                $.ajax({
                                    type: "POST",
                                    data: dataString,
                                    url: FULL_BASE_URL + 'cartSummary.php',
                                    beforeSend: function() {
                                        $('#ajaxCartSummary').addClass('loader1');
                                        // $('#ProjectId').attr('disabled', 'disabled');
                                        //return false;
                                    },
                                    success: function(return_data) {
                                        $('#ajaxCartSummary').removeClass('loader1');
                                        $('#ajaxCartSummary').html(return_data);
                                    }
                                });
                                    
                                    
                                    
                                    
                                    $("#accorBodyFour").show(400);
                                    $("#accorBodyThree").hide(400);
                                    $("#accorHeadThree").removeClass("selected");
                                    $('#accorHeadThree').find('span').remove();
                                    $("#accorHeadThree").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                    $("#accorHeadFour").addClass("selected");
                                    
                                    
                                    
                                    flagThree = true;
                                    //flagFour = true;
                                }
                            });
                            $("#finalPay").click(function() {
                                if (v.form()) {

                                    flagFour = true;


                                }

                            });

                            $("#accorHeadOne").click(function() {
                                if (flagOne == true) {

                                    $("#accorBodyOne").show(400);
                                    $("#accorBodyTwo").hide(400);
                                    $("#accorBodyThree").hide(400);
                                    $("#accorBodyFour").hide(400);
                                    $("#accorBodyFour").hide(400);
                                    $("#goAccorTwo").click(function() {
                                        $("#accorBodyTwo").show(400);
                                        $("#accorBodyOne").hide(400);
                                        $("#accorHeadOne").removeClass("selected");
                                        $('#accorHeadOne').find('span').remove();
                                        $("#accorHeadOne").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                        $("#accorHeadTwo").addClass("selected");
                                        flagOne = true;
                                    });
                                    $('#accorHeadOne').find('span').remove();
                                    $("#accorHeadOne").prepend('<span class="label label-dark">1</span>');
                                    $("#accorHeadOne").addClass("selected");
                                    $('#accorHeadTwo').find('span').remove();
                                    $("#accorHeadTwo").removeClass("selected");
                                    $("#accorHeadTwo").prepend('<span class="label label-dark">2</span>');
                                    $('#accorHeadThree').find('span').remove();
                                    $("#accorHeadThree").removeClass("selected");
                                    $("#accorHeadThree").prepend('<span class="label label-dark">3</span>');
                                    $('#accorHeadFour').find('span').remove();
                                    $("#accorHeadFour").removeClass("selected");
                                    $("#accorHeadFour").prepend('<span class="label label-dark">4</span>');
                                    flagTwo = false;
                                    flagThree = false;
                                    flagFour = false;
                                }

                            });
                            $("#accorHeadTwo").click(function() {
                                if (flagTwo == true) {

                                    if (v.form()) {

                                        $("#accorBodyTwo").show(400);
                                        $("#accorBodyOne").hide(400);
                                        $("#accorBodyThree").hide(400);
                                        $("#accorBodyFour").hide(400);
                                        $("#goAccorThree").click(function() {
                                            $("#accorBodyThree").show(400);
                                            $("#accorBodyTwo").hide(400);
                                            $("#accorHeadTwo").removeClass("selected");
                                            $('#accorHeadTwo').find('span').remove();
                                            $("#accorHeadTwo").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                            $("#accorHeadThree").addClass("selected");

                                            flagTwo = true;
                                        });
                                        $('#accorHeadTwo').find('span').remove();
                                        $("#accorHeadTwo").addClass("selected");
                                        $("#accorHeadTwo").prepend('<span class="label label-dark">2</span>');
                                        $('#accorHeadThree').find('span').remove();
                                        $("#accorHeadThree").removeClass("selected");
                                        $("#accorHeadThree").prepend('<span class="label label-dark">3</span>');
                                        $('#accorHeadFour').find('span').remove();
                                        $("#accorHeadFour").removeClass("selected");
                                        $("#accorHeadFour").prepend('<span class="label label-dark">4</span>');
                                        flagThree = false;
                                        flagFour = false;
                                    }

                                }
                            })
                            $("#accorHeadThree").click(function() {
                                if (flagThree == true) {

                                    if (v.form()) {
                                        $("#accorBodyThree").show(400);
                                        $("#accorBodyOne").hide(400);
                                        $("#accorBodyTwo").hide(400);
                                        $("#accorBodyFour").hide(400);
                                        $("#goAccorFour").click(function() {
                                            $("#accorBodyFour").show(400);
                                            $("#accorBodyThree").hide(400);
                                            $("#accorHeadThree").removeClass("selected");
                                            $('#accorHeadThree').find('span').remove();
                                            $("#accorHeadThree").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                            $("#accorHeadFour").addClass("selected");
                                            flagThree = true;
                                            //flagFour = true;
                                        });
                                        $('#accorHeadThree').find('span').remove();
                                        $("#accorHeadThree").addClass("selected");
                                        $("#accorHeadThree").prepend('<span class="label label-dark">3</span>');
                                        $('#accorHeadFour').find('span').remove();
                                        $("#accorHeadFour").removeClass("selected");
                                        $("#accorHeadFour").prepend('<span class="label label-dark">4</span>');
                                        flagFour = false;
                                    }

                                }
                            })
                            $("#accorHeadFour").click(function() {
                                if (flagFour == true) {

                                    if (v.form()) {
                                        $("#accorBodyFour").show(400);
                                        $("#accorBodyThree").hide(400);
                                        $("#accorBodyOne").hide(400);
                                        $("#accorBodyTwo").hide(400);
                                    }



                                }
                            })



                        });

                        function formatPhone(obj) {

                            var numbers = obj.value.replace(/\D/g, ''),
                                    char = {0: '(', 3: ') ', 6: ' '};

                            obj.value = '';
                            for (var i = 0; i < numbers.length; i++) {
                                obj.value += (char[i] || '') + numbers[i];
                            }

                        }
                        
                        function masking(input, textbox,e) {
                                    if (input.length == 4 || input.length == 9 || input.length == 14) {
                                        if(e.keyCode != 8){
                                          input = input + '-';
                                        }
                                        textbox.value = input;
                                    }
                        }
                        
                        function validatePhone(phoneText) {
	
                            str = phoneText.replace(/[^0-9#]/g, '');
                            var filter = /^[0-9]{10}$/;
                            if (!filter.test(str)) {
                                $('#val-rphone-error').text('Invalid Phone Number.');
                            //alert('Invalid Phone Number.');
                            $("#rphone").focus();
                            $('#rphone').val('');
                            
                            }
                            else{
                                $('#val-rphone-error').text('');
                            }
                            
                        }
                        
                        
                        function validateCPhone() {
                            
                            var phoneText = $('#cphone').val();
                            var phone_code = $('#phone_code').val();
                            //alert(phoneText);
                            str = phoneText.replace(/[^0-9#]/g, '');
                            //alert(phone_code);
                            var filter = /^[0-9]{10}$/;
                            if(phone_code == '+1'){
                                if (!filter.test(str)) {
                                    $('#val-cphone-error').text('Please enter a 10-digit number.');
                                //alert('Invalid Phone Number.');
                                $("#cphone").focus();
                                $('#cphone').val('');

                                }
                                else{
                                    $('#val-cphone-error').text('');
                                }
                            }
                            
                        }
                        
                        function validateCard(cardText) {
	
                            str = cardText.replace(/[^0-9#]/g, '');                     
                            var filter = /^[0-9]{16}$/;
                            if (!filter.test(str)) {
                                $('#Vali-ccardnum-error').text('Invalid Card Number.');
                            //alert('Invalid Phone Number.');
                            $("#ccardnum").focus();
                            $('#ccardnum').val('');
                            
                            }
                            else{
                                $('#Vali-ccardnum-error').text('');
                            }
                            
                        }
                    </script>
                    <style>

                        .HideTodayButton .ui-datepicker-buttonpane .ui-datepicker-current
                        {
                            visibility:hidden;
                        }

                        .hide-calendar .ui-datepicker-calendar
                        {
                            display:none!important;
                            visibility:hidden!important
                        }

                    </style>

                    <script type="text/javascript">

                        var ThumbImageWidth = 183;
                        var ThumbImageHeight = 183;

                        (function(i, s, o, g, r, a, m) {
                            i['GoogleAnalyticsObject'] = r;
                            i[r] = i[r] || function() {
                                (i[r].q = i[r].q || []).push(arguments)
                            }, i[r].l = 1 * new Date();
                            a = s.createElement(o),
                                    m = s.getElementsByTagName(o)[0];
                            a.async = 1;
                            a.src = g;
                            m.parentNode.insertBefore(a, m)
                        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

                        ga('create', 'UA-57269771-1', 'auto');
                        ga('send', 'pageview');



                    </script>
                    </head>


    <form class="cmxform" id="cmxform" method="post" action="<?= $vpath; ?>api-testing.php?itemCode=<?php echo $_GET['itemCode']; ?>">
            <input type="hidden" name='deliverydate1' value="<?= $deliverydate?>"> 
            <input type="hidden" name='experition_date1' value="<?= $carddate?>">
            <input type="hidden" name='raddress1_1' value="<?= $raddress1?>">
             <input type="hidden" name='raddress2_1' value="<?= $raddress2?>">
            <input type="hidden" name='rcity1' value="<?= $rcity?>">
            <input type="hidden" name='rcountry1' value="<?= $rcountry?>">
            <input type="hidden" name='cemail1' value="<?= $cemail?>">
            <input type="hidden" name='rattention1' value="<?= $rattention?>">
            <input type="hidden" name='rfirstname1' value="<?= $rfirstname?>">
            <input type="hidden" name='rlastname1' value="<?= $rlastname?>">
            <input type="hidden" name='rphone1' value="<?= $rphone?>">
            <input type="hidden" name='rstate1' value="<?= $rstate?>">
            <input type="hidden" name='rzip1' value="<?= $rzip?>" />
            <input type="hidden" name='caddress1_1' value="<?= $caddress1?>" />
            <input type="hidden" name='caddress2_1' value="<?= $caddress2?>" />
            <input type="hidden" name='ccity1' value="<?= $ccity?>" />
            <input type="hidden" name='ccountry1' value="<?= $ccountry?>" />
            <input type="hidden" name='cfirstname1' value="<?= $cfirstname?>" />
            <input type="hidden" name='clastname1' value="<?= $clastname?>" />
            <input type="hidden" name='cphone1' value="<?= $cphone?>" />
            <input type="hidden" name='cstate1' value="<?= $cstate?>" />
            <input type="hidden" name='czip1' value="<?= $czip?>" />
            <input type="hidden" name='ccardnum1' value="<?= $ccardnum?>" />
            <input type="hidden" name='cvv2_1' value="<?= $cvv2?>" />
            <input type="hidden" name='ccardtype1' value="<?= $ccardtype?>" />
            <input type="hidden" name='ccardname1' value="<?= $ccardname?>" />
            <input type="hidden" name='rinstructions1' value="<?= $rinstructions?>" />
            <input type="hidden" name='renclosure1' value="<?= $renclosure?>" />
                    <div class="container page-container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h2 class="page-heading">FlowerWyz Secure Checkout</h2>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            if($panel_order == 'order'){
                            ?>
                            <div class="col-sm-12" style="margin-bottom:15px">
                                <div class="panel panel-default checkout-panel">
                                    <div class="panel-body">
                                        <h3>Response</h3>
                                       <?PHP if (count($ins->arrOrder)) {
                                           //$output = array();
                                        $output[] = $ins->arrOrder;
                                        echo 'Output =<br>';
                                        print_r($output);
                                        echo '<br>';
                                        echo 'Output.errors=';
                                        print_r($output->errors);
                                        }?>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            <?php if($panel == 'generate'){?>
                            <div class="col-sm-12" style="margin-bottom:15px">
                                <div class="panel panel-default checkout-panel">
                                    <div class="panel-body">
                                        <h3>API Call Generated</h3>
                                        <?php echo $generate_api;?>
                                        <input type="submit" name="save" id="finalPay" class="green-btn pull-right" style="margin-top:10px; width:200px;" value="Place Order" />
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            
                            <div class="col-sm-9">

                                <div class="panel panel-default checkout-panel">
                                    <div class="panel-body">
                                        <h3>Secure Checkout</h3>
                                        
                                            <input type="hidden" name='itemCode' id="itemCode" value="<?php echo $_GET['itemCode']; ?>">
                                                <input type="hidden" name='action_type' id="ActionType" value="0">                                                    
                                                        <input type="hidden" name='hidden_site_baseurl' id="hidden_site_baseurl" value="<?php echo $vpath; ?>">
                                                            <div class="panel panel-default accord-container" style="border-radius:0px;">
                                                                <div class="panel-heading selected" id="accorHeadOne"><span class="label label-dark">1</span>Review Cart</div>
                                                                <div class="panel-body" id="accorBodyOne">
                                                                    <fieldset data-step="0">
                                                                        <div class="row">
                                                                            <div class="col-sm-12" id="review-cart">
                                                                                <table class="table cart-contents">
                                                                                    <tbody>
                                                                                        <tr class="background">
                                                                                            <th>Item</th>
                                                                                            <th class="text-center">Quantity</th>
                                                                                            <th class="text-right">Unit Price</th>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td><span style="text-transform:uppercase"><b><?php echo $product['name']; ?></b></span><br />Delivered to All Zip Codes, USA & Canada.</td>
                                                                                            <td class="text-center">1</td>
                                                                                            <td class="text-right">$ <?php echo $product['price']; ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td></td>
                                                                                            <td colspan="2" class="text-right"><span style="font-size:18px; font-weight:bold;">Current Total $ <?php echo $product['price']; ?></span></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="3" style="border-top:none;"><img src="<?php echo $product['image']; ?>" height="150px"></td> <!-- 132px-->
                                                                                        </tr>

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                    <!--<small class="pull-left" style="font-size:10px; color:#6f889b; margin:12px 0 0 10px;">*Before service charges and taxes</small>--><button type="button" class="green-btn pull-right" id="goAccorTwo">Continue to Recipient Information</button>
                                                                </div>
                                                            </div>

                                                            <div class="panel panel-default accord-container" style="border-radius:0px; margin-top:-1px;">
                                                                <div class="panel-heading" id="accorHeadTwo"><span class="label label-dark">2</span>Recipient Information</div>
                                                                <div class="panel-body" id="accorBodyTwo">
                                                                    <fieldset data-step="1">

                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="rfirstname" name="rfirstname" value="<?= $rfirstname?>"  placeholder="First Name*" type="text" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="rlastname" name="rlastname" value="<?= $rlastname?>" placeholder="Last Name*" type="text" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="rattention" name="rattention" value="<?= $rattention;?>" placeholder="Institution" type="text" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="rphone" name="rphone" value="<?= $rphone;?>" type="text" placeholder="Phone*" class="form-control" onKeyUp="formatPhone(this);" onBlur="validatePhone(this.value)" maxlength="14" autocomplete="off">
                                                                                    <p for="rphone" class="warning" id="val-rphone-error"></p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="raddress1" name="raddress1" value="<?= $raddress1;?>" type="text" placeholder="Address*" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="raddress2" name="raddress2" value="<?= $raddress2;?>" type="text" placeholder="Address 2" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep cust-select">

                                                                                    <select id="rcountry" onChange="this.className=this.options[this.selectedIndex].className" class="greenText" name="rcountry">
                                                                                        <option value="" class="first_option">--Select Country*--</option>
                                                                                        <option value="US" <?php if($rcountry == 'US'){?> selected="selected"<?php }?>>United States</option>
                                                                                        <option value="CA" <?php if($rcountry == 'CA'){?> selected="selected"<?php }?>>Canada</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep cust-select">

                                                                                    <select onChange="this.className=this.options[this.selectedIndex].className"
    class="greenText" id="rstate"  name="rstate">
                                                                                        <option value="">--Select State*--</option>
                                                                                        <option value="x" disabled="disabled">&nbsp;</option>
                                                                                        <option value="x" disabled="disabled">--United States--</option>
                                                                                        <option value="AP" <?php if($rstate == 'AP'){?> selected="selected"<?php }?>>APO/FPO</option>
                                                                                        <option value="AL" <?php if($rstate == 'AL'){?> selected="selected"<?php }?>>Alabama</option>
                                                                                        <option value="AK" <?php if($rstate == 'AK'){?> selected="selected"<?php }?>>Alaska</option>
                                                                                        <option value="AZ" <?php if($rstate == 'AZ'){?> selected="selected"<?php }?>>Arizona</option>
                                                                                        <option value="AR" <?php if($rstate == 'AR'){?> selected="selected"<?php }?>>Arkansas</option>
                                                                                        <option value="CA" <?php if($rstate == 'CA'){?> selected="selected"<?php }?>>California</option>
                                                                                        <option value="CO" <?php if($rstate == 'CO'){?> selected="selected"<?php }?>>Colorado</option>
                                                                                        <option value="CT" <?php if($rstate == 'CT'){?> selected="selected"<?php }?>>Connecticut</option>
                                                                                        <option value="DE" <?php if($rstate == 'DE'){?> selected="selected"<?php }?>>Delaware</option>
                                                                                        <option value="DC" <?php if($rstate == 'DC'){?> selected="selected"<?php }?>>District of Columbia</option>
                                                                                        <option value="FL" <?php if($rstate == 'FL'){?> selected="selected"<?php }?>>Florida</option>
                                                                                        <option value="GA" <?php if($rstate == 'GA'){?> selected="selected"<?php }?>>Georgia</option>
                                                                                        <option value="HI" <?php if($rstate == 'HI'){?> selected="selected"<?php }?>>Hawaii</option>
                                                                                        <option value="ID" <?php if($rstate == 'ID'){?> selected="selected"<?php }?>>Idaho</option>
                                                                                        <option value="IL" <?php if($rstate == 'IL'){?> selected="selected"<?php }?>>Illinois</option>
                                                                                        <option value="IN" <?php if($rstate == 'IN'){?> selected="selected"<?php }?>>Indiana</option>
                                                                                        <option value="IA" <?php if($rstate == 'IA'){?> selected="selected"<?php }?>>Iowa</option>
                                                                                        <option value="KS" <?php if($rstate == 'KS'){?> selected="selected"<?php }?>>Kansas</option>
                                                                                        <option value="KY" <?php if($rstate == 'KY'){?> selected="selected"<?php }?>>Kentucky</option>
                                                                                        <option value="LA" <?php if($rstate == 'KY'){?> selected="selected"<?php }?>>Louisiana</option>
                                                                                        <option value="ME" <?php if($rstate == 'KY'){?> selected="selected"<?php }?>>Maine</option>
                                                                                        <option value="MD" <?php if($rstate == 'KY'){?> selected="selected"<?php }?>>Maryland</option>
                                                                                        <option value="MA" <?php if($rstate == 'KY'){?> selected="selected"<?php }?>>Massachusetts</option>
                                                                                        <option value="MI" <?php if($rstate == 'KY'){?> selected="selected"<?php }?>>Michigan</option>
                                                                                        <option value="MN" <?php if($rstate == 'MN'){?> selected="selected"<?php }?>>Minnesota</option>
                                                                                        <option value="MS" <?php if($rstate == 'MS'){?> selected="selected"<?php }?>>Mississippi</option>
                                                                                        <option value="MO" <?php if($rstate == 'MO'){?> selected="selected"<?php }?>>Missouri</option>
                                                                                        <option value="MT" <?php if($rstate == 'MT'){?> selected="selected"<?php }?>>Montana</option>
                                                                                        <option value="NC" <?php if($rstate == 'NC'){?> selected="selected"<?php }?>>North Carolina</option>
                                                                                        <option value="ND" <?php if($rstate == 'ND'){?> selected="selected"<?php }?>>North Dakota</option>
                                                                                        <option value="NE" <?php if($rstate == 'NE'){?> selected="selected"<?php }?>>Nebraska</option>
                                                                                        <option value="NV" <?php if($rstate == 'NV'){?> selected="selected"<?php }?>>Nevada</option>
                                                                                        <option value="NH" <?php if($rstate == 'NH'){?> selected="selected"<?php }?>>New Hampshire</option>
                                                                                        <option value="NJ" <?php if($rstate == 'NJ'){?> selected="selected"<?php }?>>New Jersey</option>
                                                                                        <option value="NM" <?php if($rstate == 'NM'){?> selected="selected"<?php }?>>New Mexico</option>
                                                                                        <option value="NY" <?php if($rstate == 'NY'){?> selected="selected"<?php }?>>New York</option>
                                                                                        <option value="OH" <?php if($rstate == 'OH'){?> selected="selected"<?php }?>>Ohio</option>
                                                                                        <option value="OK" <?php if($rstate == 'OK'){?> selected="selected"<?php }?>>Oklahoma</option>
                                                                                        <option value="OR" <?php if($rstate == 'OR'){?> selected="selected"<?php }?>>Oregon</option>
                                                                                        <option value="PA" <?php if($rstate == 'PA'){?> selected="selected"<?php }?>>Pennsylvania</option>
                                                                                        <option value="PR" <?php if($rstate == 'PR'){?> selected="selected"<?php }?>>Puerto Rico</option>
                                                                                        <option value="RI" <?php if($rstate == 'RI'){?> selected="selected"<?php }?>>Rhode Island</option>
                                                                                        <option value="SC" <?php if($rstate == 'SC'){?> selected="selected"<?php }?>>South Carolina</option>
                                                                                        <option value="SD" <?php if($rstate == 'SD'){?> selected="selected"<?php }?>>South Dakota</option>
                                                                                        <option value="TN" <?php if($rstate == 'TN'){?> selected="selected"<?php }?>>Tennessee</option>
                                                                                        <option value="TX" <?php if($rstate == 'TX'){?> selected="selected"<?php }?>>Texas</option>
                                                                                        <option value="UT" <?php if($rstate == 'UT'){?> selected="selected"<?php }?>>Utah</option>
                                                                                        <option value="VT" <?php if($rstate == 'VT'){?> selected="selected"<?php }?>>Vermont</option>
                                                                                        <option value="VI" <?php if($rstate == 'VI'){?> selected="selected"<?php }?>>Virgin Islands</option>
                                                                                        <option value="VA" <?php if($rstate == 'VA'){?> selected="selected"<?php }?>>Virginia</option>
                                                                                        <option value="WV" <?php if($rstate == 'WV'){?> selected="selected"<?php }?>>West Virginia</option>
                                                                                        <option value="WA" <?php if($rstate == 'WA'){?> selected="selected"<?php }?>>Washington</option>
                                                                                        <option value="WI" <?php if($rstate == 'WI'){?> selected="selected"<?php }?>>Wisconsin</option>
                                                                                        <option value="WY" <?php if($rstate == 'WY'){?> selected="selected"<?php }?>>Wyoming</option>
                                                                                        <option value="x" disabled="disabled">&nbsp;</option>
                                                                                        <option value="x" disabled="disabled">--Canada--</option>
                                                                                        <option value="AB" <?php if($rstate == 'AB'){?> selected="selected"<?php }?>>Alberta</option>
                                                                                        <option value="BC" <?php if($rstate == 'BC'){?> selected="selected"<?php }?>>British Columbia</option>
                                                                                        <option value="MB" <?php if($rstate == 'MB'){?> selected="selected"<?php }?>>Manitoba</option>
                                                                                        <option value="NB" <?php if($rstate == 'NB'){?> selected="selected"<?php }?>>New Brunswick</option>
                                                                                        <option value="NF" <?php if($rstate == 'NF'){?> selected="selected"<?php }?>>Newfoundland</option>
                                                                                        <option value="NT" <?php if($rstate == 'NT'){?> selected="selected"<?php }?>>North West Territory</option>
                                                                                        <option value="NS" <?php if($rstate == 'NS'){?> selected="selected"<?php }?>>Nova Scotia</option>
                                                                                        <option value="ON" <?php if($rstate == 'ON'){?> selected="selected"<?php }?>>Ontario</option>
                                                                                        <option value="PE" <?php if($rstate == 'PE'){?> selected="selected"<?php }?>>Prince Edward Island</option>
                                                                                        <option value="PQ" <?php if($rstate == 'PQ'){?> selected="selected"<?php }?>>Quebec</option>
                                                                                        <option value="SK" <?php if($rstate == 'SK'){?> selected="selected"<?php }?>>Saskatchewan</option>
                                                                                        <option value="YT" <?php if($rstate == 'YT'){?> selected="selected"<?php }?>>Yukon Territory</option>
                                                                                        <option value="x" disabled="disabled">&nbsp;</option>
                                                                                        <option value="OS">Other State / Province</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="rcity" name="rcity" value="<?= $rcity?>" type="text" placeholder="City*" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="rzip" name="rzip" value="<?= $rzip?>" type="text" placeholder="Zip Code*" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>



                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="form_sep">
                                                                                    <label class="req">Message On Card</label>
                                                                                    <textarea id="renclosure" class="form-control" rows="3" name="renclosure" maxlength="200" placeholder="Please enter your personalized message here. Don't forget to add your name."><?=$renclosure?></textarea>
                                                                                </div>
                                                                                <div class="form_sep">
                                                                                    <label>Special Delivery Instructions</label>
                                                                                    <textarea id="rinstructions" class="form-control" rows="3" name="rinstructions" placeholder="If you have specific instructions for our delivery team, you may add them here." maxlength="200"><?=$rinstructions?></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep cust-select">
                                                                                       <!-- <input type="text" name="deliverydate" id="datepicker"  data-required="true" placeholder="Select Delivery Date*" class="form-control" />-->
                                                                                    <select onChange="this.className=this.options[this.selectedIndex].className"
    class="greenText" name="deliverydate" id="deliverydate">
                                                                                        <option value="">Select Delivery Date *</option>

                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                    <button type="button" style="margin-top:10px;" class="green-btn pull-right" id="goAccorThree">Continue to Billing Information</button>
                                                                </div>
                                                            </div>

                                                            <div class="panel panel-default accord-container" style="border-radius:0px; margin-top:-1px;">
                                                                <div class="panel-heading" id="accorHeadThree"><span class="label label-dark">3</span>Billing Information</div>
                                                                <div class="panel-body" id="accorBodyThree">
                                                                    <fieldset data-step="2">

                                                                        <div class="row">
                                                                            <div>
                                                                                <label class="checkbox inline" style="padding: 0;margin: 0px 0px 5px 37px;">
                                                                                    <input name="shipping_chk" id="shipping_chk" type="checkbox" >
                                                                                        Same as recipient information.</label>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="cfirstname" name="cfirstname" value="<?= $cfirstname?>"  placeholder="First Name*" type="text" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="clastname" name="clastname" value="<?= $clastname?>" type="text" placeholder="Last name*" class="form-control" data-minlength="3">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="caddress1" name="caddress1" value="<?= $caddress1?>" type="text" placeholder="Address*" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="caddress2" name="caddress2" value="<?= $caddress2?>" placeholder="Address 2" type="text" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep cust-select">
                                                                                    <select onChange="this.className=this.options[this.selectedIndex].className"
    class="greenText" id="ccountry" name="ccountry">

                                                                                        <option value="" selected="selected">--Select Country--</option>

                                                                                        <option value="US" <?php if($ccountry == 'US'){?> selected='selected'<?php }?>>United States</option>

                                                                                        <option value="CA" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Canada</option>

                                                                                        <option value="x" disabled="disabled">-----------------------</option>

                                                                                        <option value="AF" <?php if($ccountry == 'AF'){?> selected='selected'<?php }?>>Afghanistan</option>

                                                                                        <option value="AL" <?php if($ccountry == 'AL'){?> selected='selected'<?php }?>>Albania</option>

                                                                                        <option value="DZ" <?php if($ccountry == 'DZ'){?> selected='selected'<?php }?>>Algeria</option>

                                                                                        <option value="AS" <?php if($ccountry == 'AS'){?> selected='selected'<?php }?>>American Samoa</option>

                                                                                        <option value="AD" <?php if($ccountry == 'AD'){?> selected='selected'<?php }?>>Andorra</option>

                                                                                        <option value="AO" <?php if($ccountry == 'AO'){?> selected='selected'<?php }?>>Angola</option>

                                                                                        <option value="AI" <?php if($ccountry == 'AI'){?> selected='selected'<?php }?>>Anguilla</option>

                                                                                        <option value="AQ" <?php if($ccountry == 'AQ'){?> selected='selected'<?php }?>>Antarctica</option>

                                                                                        <option value="AG" <?php if($ccountry == 'AG'){?> selected='selected'<?php }?>>Antigua and Barbuda</option>

                                                                                        <option value="AR" <?php if($ccountry == 'AR'){?> selected='selected'<?php }?>>Argentina</option>

                                                                                        <option value="AM" <?php if($ccountry == 'AM'){?> selected='selected'<?php }?>>Armenia</option>

                                                                                        <option value="AW" <?php if($ccountry == 'AW'){?> selected='selected'<?php }?>>Aruba</option>

                                                                                        <option value="AU" <?php if($ccountry == 'AU'){?> selected='selected'<?php }?>>Australia</option>

                                                                                        <option value="AT" <?php if($ccountry == 'AT'){?> selected='selected'<?php }?>>Austria</option>

                                                                                        <option value="AZ" <?php if($ccountry == 'AZ'){?> selected='selected'<?php }?>>Azerbaijan</option>

                                                                                        <option value="BS" <?php if($ccountry == 'BS'){?> selected='selected'<?php }?>>Bahamas</option>

                                                                                        <option value="BH" <?php if($ccountry == 'BH'){?> selected='selected'<?php }?>>Bahrain</option>

                                                                                        <option value="BD" <?php if($ccountry == 'BD'){?> selected='selected'<?php }?>>Bangladesh</option>

                                                                                        <option value="BB" <?php if($ccountry == 'BB'){?> selected='selected'<?php }?>>Barbados</option>

                                                                                        <option value="BY" <?php if($ccountry == 'BY'){?> selected='selected'<?php }?>>Belarus</option>

                                                                                        <option value="BE" <?php if($ccountry == 'BE'){?> selected='selected'<?php }?>>Belgium</option>

                                                                                        <option value="BZ" <?php if($ccountry == 'BZ'){?> selected='selected'<?php }?>>Belize</option>

                                                                                        <option value="BJ" <?php if($ccountry == 'BJ'){?> selected='selected'<?php }?>>Benin</option>

                                                                                        <option value="BM" <?php if($ccountry == 'BM'){?> selected='selected'<?php }?>>Bermuda</option>

                                                                                        <option value="BT" <?php if($ccountry == 'BT'){?> selected='selected'<?php }?>>Bhutan</option>

                                                                                        <option value="BO" <?php if($ccountry == 'BO'){?> selected='selected'<?php }?>>Bolivia</option>

                                                                                        <option value="BA" <?php if($ccountry == 'BA'){?> selected='selected'<?php }?>>Bosnia - Herzegovina</option>

                                                                                        <option value="BW" <?php if($ccountry == 'BW'){?> selected='selected'<?php }?>>Botswana</option>

                                                                                        <option value="BV" <?php if($ccountry == 'BV'){?> selected='selected'<?php }?>>Bouvet Island</option>

                                                                                        <option value="BR" <?php if($ccountry == 'BR'){?> selected='selected'<?php }?>>Brazil</option>

                                                                                        <option value="IO" <?php if($ccountry == 'IO'){?> selected='selected'<?php }?>>British Indian Ocean Ter.</option>

                                                                                        <option value="BN" <?php if($ccountry == 'BN'){?> selected='selected'<?php }?>>Brunei Darussalam</option>

                                                                                        <option value="BG" <?php if($ccountry == 'BG'){?> selected='selected'<?php }?>>Bulgaria</option>

                                                                                        <option value="BF" <?php if($ccountry == 'BF'){?> selected='selected'<?php }?>>Burkina Faso</option>

                                                                                        <option value="BI" <?php if($ccountry == 'BI'){?> selected='selected'<?php }?>>Burundi</option>

                                                                                        <option value="KH" <?php if($ccountry == 'KH'){?> selected='selected'<?php }?>>Cambodia</option>

                                                                                        <option value="CM" <?php if($ccountry == 'CM'){?> selected='selected'<?php }?>>Cameroon</option>

                                                                                        <option value="CA" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Canada</option>

                                                                                        <option value="CV" <?php if($ccountry == 'CV'){?> selected='selected'<?php }?>>Cape Verde</option>

                                                                                        <option value="KY" <?php if($ccountry == 'KY'){?> selected='selected'<?php }?>>Cayman Islands</option>

                                                                                        <option value="CF" <?php if($ccountry == 'CF'){?> selected='selected'<?php }?>>Central African Republic</option>

                                                                                        <option value="TD" <?php if($ccountry == 'TD'){?> selected='selected'<?php }?>>Chad</option>

                                                                                        <option value="CL" <?php if($ccountry == 'CL'){?> selected='selected'<?php }?>>Chile</option>

                                                                                        <option value="CN" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>China</option>

                                                                                        <option value="CX" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Christmas Island</option>

                                                                                        <option value="CC" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Cocos (Keeling) Islands</option>

                                                                                        <option value="CO" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Colombia</option>

                                                                                        <option value="KM" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Comoros</option>

                                                                                        <option value="CG" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Congo</option>

                                                                                        <option value="CK" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Cook Islands</option>

                                                                                        <option value="CR" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Costa Rica</option>

                                                                                        <option value="CI" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Cote D'Ivoire(Ivory Coast)</option>

                                                                                        <option value="HR" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Croatia</option>

                                                                                        <option value="CU" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Cuba</option>

                                                                                        <option value="CY" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Cyprus</option>

                                                                                        <option value="CZ" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Czech Republic</option>

                                                                                        <option value="DK" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Denmark</option>

                                                                                        <option value="DJ" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Djibouti</option>

                                                                                        <option value="DM" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Dominica</option>

                                                                                        <option value="DO" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Dominican Republic</option>

                                                                                        <option value="TP" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>East Timor</option>

                                                                                        <option value="EC" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Ecuador</option>

                                                                                        <option value="EG" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Egypt</option>

                                                                                        <option value="SV" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>El Salvador</option>

                                                                                        <option value="GQ" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Equatorial Guinea</option>

                                                                                        <option value="ER" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Eritrea</option>

                                                                                        <option value="EE" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Estonia</option>

                                                                                        <option value="ET" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Ethiopia</option>

                                                                                        <option value="FK" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Falkland Islands</option>

                                                                                        <option value="FO" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Faroe Islands</option>

                                                                                        <option value="FJ" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Fiji</option>

                                                                                        <option value="FI" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Finland</option>

                                                                                        <option value="FR" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>France</option>

                                                                                        <option value="GF" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>French Guyana</option>

                                                                                        <option value="PF" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>French Polynesia</option>

                                                                                        <option value="GA" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Gabon</option>

                                                                                        <option value="GM" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Gambia</option>

                                                                                        <option value="GE" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Georgia</option>

                                                                                        <option value="DE" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Germany</option>

                                                                                        <option value="GH" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Ghana</option>

                                                                                        <option value="GI" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Gibraltar</option>

                                                                                        <option value="GR" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Greece</option>

                                                                                        <option value="GL" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Greenland</option>

                                                                                        <option value="GD" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Grenada</option>

                                                                                        <option value="GP" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Guadeloupe</option>

                                                                                        <option value="GU" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Guam</option>

                                                                                        <option value="GT" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Guatemala</option>

                                                                                        <option value="GN" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Guinea</option>

                                                                                        <option value="GW" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Guinea-Bissau</option>

                                                                                        <option value="GY" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Guyana</option>

                                                                                        <option value="HT" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Haiti</option>

                                                                                        <option value="HM" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Heard &amp; McDonald Islands</option>

                                                                                        <option value="VA" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Holy See (Vatican City)</option>

                                                                                        <option value="HN" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Honduras</option>

                                                                                        <option value="HK" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Hong Kong</option>

                                                                                        <option value="HU" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Hungary</option>

                                                                                        <option value="IS" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Iceland</option>

                                                                                        <option value="IN" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>India</option>

                                                                                        <option value="ID" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Indonesia</option>

                                                                                        <option value="IR" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Iran</option>

                                                                                        <option value="IE" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Ireland</option>

                                                                                        <option value="IL" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Israel</option>

                                                                                        <option value="IT" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Italy</option>

                                                                                        <option value="JM" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Jamaica</option>

                                                                                        <option value="JP" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Japan</option>

                                                                                        <option value="JO" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Jordan</option>

                                                                                        <option value="KZ" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Kazakstan</option>

                                                                                        <option value="KE" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Kenya</option>

                                                                                        <option value="KI" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Kiribati</option>

                                                                                        <option value="KR" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Korea, Republic of</option>

                                                                                        <option value="KW" <?php if($ccountry == 'CA'){?> selected='selected'<?php }?>>Kuwait</option>

                                                                                        <option value="KG" <?php if($ccountry == 'KG'){?> selected='selected'<?php }?>>Kyrgyzstan</option>

                                                                                        <option value="LA" <?php if($ccountry == 'LA'){?> selected='selected'<?php }?>>Laos</option>

                                                                                        <option value="LV" <?php if($ccountry == 'LV'){?> selected='selected'<?php }?>>Latvia</option>

                                                                                        <option value="LB" <?php if($ccountry == 'LB'){?> selected='selected'<?php }?>>Lebanon</option>

                                                                                        <option value="LS" <?php if($ccountry == 'LS'){?> selected='selected'<?php }?>>Lesotho</option>

                                                                                        <option value="LR" <?php if($ccountry == 'LR'){?> selected='selected'<?php }?>>Liberia</option>

                                                                                        <option value="LY" <?php if($ccountry == 'LY'){?> selected='selected'<?php }?>>Libyan Arab Jamahiriya</option>

                                                                                        <option value="LI" <?php if($ccountry == 'LI'){?> selected='selected'<?php }?>>Liechtenstein</option>

                                                                                        <option value="LT" <?php if($ccountry == 'LT'){?> selected='selected'<?php }?>>Lithuania</option>

                                                                                        <option value="LU" <?php if($ccountry == 'LU'){?> selected='selected'<?php }?>>Luxembourg</option>

                                                                                        <option value="MO" <?php if($ccountry == 'MO'){?> selected='selected'<?php }?>>Macau</option>

                                                                                        <option value="MK" <?php if($ccountry == 'MK'){?> selected='selected'<?php }?>>Macedonia</option>

                                                                                        <option value="MG" <?php if($ccountry == 'MG'){?> selected='selected'<?php }?>>Madagascar</option>

                                                                                        <option value="MW" <?php if($ccountry == 'MW'){?> selected='selected'<?php }?>>Malawi</option>

                                                                                        <option value="MY" <?php if($ccountry == 'MY'){?> selected='selected'<?php }?>>Malaysia</option>

                                                                                        <option value="MV" <?php if($ccountry == 'MV'){?> selected='selected'<?php }?>>Maldives</option>

                                                                                        <option value="ML" <?php if($ccountry == 'ML'){?> selected='selected'<?php }?>>Mali</option>

                                                                                        <option value="MT" <?php if($ccountry == 'MT'){?> selected='selected'<?php }?>>Malta</option>

                                                                                        <option value="MH" <?php if($ccountry == 'MH'){?> selected='selected'<?php }?>>Marshall Islands</option>

                                                                                        <option value="MQ" <?php if($ccountry == 'MQ'){?> selected='selected'<?php }?>>Martinique</option>

                                                                                        <option value="MR" <?php if($ccountry == 'MR'){?> selected='selected'<?php }?>>Mauritania</option>

                                                                                        <option value="MU" <?php if($ccountry == 'MU'){?> selected='selected'<?php }?>>Mauritius</option>

                                                                                        <option value="YT" <?php if($ccountry == 'YT'){?> selected='selected'<?php }?>>Mayotte</option>

                                                                                        <option value="MX" <?php if($ccountry == 'MX'){?> selected='selected'<?php }?>>Mexico</option>

                                                                                        <option value="FM" <?php if($ccountry == 'FM'){?> selected='selected'<?php }?>>Micronesia</option>

                                                                                        <option value="MD" <?php if($ccountry == 'MD'){?> selected='selected'<?php }?>>Moldavia</option>

                                                                                        <option value="MC" <?php if($ccountry == 'MC'){?> selected='selected'<?php }?>>Monaco</option>

                                                                                        <option value="MN" <?php if($ccountry == 'MN'){?> selected='selected'<?php }?>>Mongolia</option>

                                                                                        <option value="MS" <?php if($ccountry == 'MS'){?> selected='selected'<?php }?>>Montserrat</option>

                                                                                        <option value="MA" <?php if($ccountry == 'MA'){?> selected='selected'<?php }?>>Morocco</option>

                                                                                        <option value="MZ" <?php if($ccountry == 'MZ'){?> selected='selected'<?php }?>>Mozambique</option>

                                                                                        <option value="MM" <?php if($ccountry == 'MM'){?> selected='selected'<?php }?>>Myanmar</option>

                                                                                        <option value="NA" <?php if($ccountry == 'NA'){?> selected='selected'<?php }?>>Namibia</option>

                                                                                        <option value="NR" <?php if($ccountry == 'NR'){?> selected='selected'<?php }?>>Nauru</option>

                                                                                        <option value="NP" <?php if($ccountry == 'NP'){?> selected='selected'<?php }?>>Nepal</option>

                                                                                        <option value="NL" <?php if($ccountry == 'NL'){?> selected='selected'<?php }?>>Netherlands</option>

                                                                                        <option value="AN" <?php if($ccountry == 'AN'){?> selected='selected'<?php }?>>Netherlands Antilles</option>

                                                                                        <option value="NC" <?php if($ccountry == 'NC'){?> selected='selected'<?php }?>>New Caledonia</option>

                                                                                        <option value="NZ" <?php if($ccountry == 'NZ'){?> selected='selected'<?php }?>>New Zealand</option>

                                                                                        <option value="NI" <?php if($ccountry == 'NI'){?> selected='selected'<?php }?>>Nicaragua</option>

                                                                                        <option value="NE" <?php if($ccountry == 'NE'){?> selected='selected'<?php }?>>Niger</option>

                                                                                        <option value="NG" <?php if($ccountry == 'NG'){?> selected='selected'<?php }?>>Nigeria</option>

                                                                                        <option value="NU" <?php if($ccountry == 'NU'){?> selected='selected'<?php }?>>Niue</option>

                                                                                        <option value="MP" <?php if($ccountry == 'MP'){?> selected='selected'<?php }?>>Northern Mariana Islands</option>

                                                                                        <option value="NO" <?php if($ccountry == 'NO'){?> selected='selected'<?php }?>>Norway</option>

                                                                                        <option value="OM" <?php if($ccountry == 'OM'){?> selected='selected'<?php }?>>Oman</option>

                                                                                        <option value="PK" <?php if($ccountry == 'PK'){?> selected='selected'<?php }?>>Pakistan</option>

                                                                                        <option value="PW" <?php if($ccountry == 'PW'){?> selected='selected'<?php }?>>Palau</option>

                                                                                        <option value="PA" <?php if($ccountry == 'PA'){?> selected='selected'<?php }?>>Panama</option>

                                                                                        <option value="PG" <?php if($ccountry == 'PG'){?> selected='selected'<?php }?>>Papua New Guinea</option>

                                                                                        <option value="PY" <?php if($ccountry == 'PY'){?> selected='selected'<?php }?>>Paraguay</option>

                                                                                        <option value="PE" <?php if($ccountry == 'PE'){?> selected='selected'<?php }?>>Peru</option>

                                                                                        <option value="PH" <?php if($ccountry == 'PH'){?> selected='selected'<?php }?>>Philippines</option>

                                                                                        <option value="PN" <?php if($ccountry == 'PN'){?> selected='selected'<?php }?>>Pitcairn Island</option>

                                                                                        <option value="PL" <?php if($ccountry == 'PL'){?> selected='selected'<?php }?>>Poland</option>

                                                                                        <option value="PT" <?php if($ccountry == 'PT'){?> selected='selected'<?php }?>>Portugal</option>

                                                                                        <option value="PR" <?php if($ccountry == 'PR'){?> selected='selected'<?php }?>>Puerto Rico</option>

                                                                                        <option value="QA" <?php if($ccountry == 'QA'){?> selected='selected'<?php }?>>Qatar</option>

                                                                                        <option value="RE" <?php if($ccountry == 'RE'){?> selected='selected'<?php }?>>Reunion</option>

                                                                                        <option value="RO" <?php if($ccountry == 'RO'){?> selected='selected'<?php }?>>Romania</option>

                                                                                        <option value="RU" <?php if($ccountry == 'RU'){?> selected='selected'<?php }?>>Russian Federation</option>

                                                                                        <option value="RW" <?php if($ccountry == 'RW'){?> selected='selected'<?php }?>>Rwanda</option>

                                                                                        <option value="KN" <?php if($ccountry == 'KN'){?> selected='selected'<?php }?>>Saint Kitts &amp; Nevis</option>

                                                                                        <option value="LC" <?php if($ccountry == 'LC'){?> selected='selected'<?php }?>>Saint Lucia</option>

                                                                                        <option value="VC" <?php if($ccountry == 'VC'){?> selected='selected'<?php }?>>Saint Vincent &amp; Grenadines</option>

                                                                                        <option value="WS" <?php if($ccountry == 'WS'){?> selected='selected'<?php }?>>Samoa</option>

                                                                                        <option value="SM" <?php if($ccountry == 'SM'){?> selected='selected'<?php }?>>San Marino</option>

                                                                                        <option value="ST" <?php if($ccountry == 'ST'){?> selected='selected'<?php }?>>Sao Tome and Principe</option>

                                                                                        <option value="SA" <?php if($ccountry == 'SA'){?> selected='selected'<?php }?>>Saudi Arabia</option>

                                                                                        <option value="SN" <?php if($ccountry == 'SN'){?> selected='selected'<?php }?>>Senegal</option>

                                                                                        <option value="SC"> <?php if($ccountry == 'SC'){?> selected='selected'<?php }?>Seychelles</option>

                                                                                        <option value="SL" <?php if($ccountry == 'SL'){?> selected='selected'<?php }?>>Sierra Leone</option>

                                                                                        <option value="SG" <?php if($ccountry == 'SG'){?> selected='selected'<?php }?>>Singapore</option>

                                                                                        <option value="SK" <?php if($ccountry == 'SK'){?> selected='selected'<?php }?>>Slovakia</option>

                                                                                        <option value="SI" <?php if($ccountry == 'SI'){?> selected='selected'<?php }?>>Slovenia</option>

                                                                                        <option value="SB" <?php if($ccountry == 'SB'){?> selected='selected'<?php }?>>Solomon Islands</option>

                                                                                        <option value="SO" <?php if($ccountry == 'SO'){?> selected='selected'<?php }?>>Somalia</option>

                                                                                        <option value="ZA" <?php if($ccountry == 'ZA'){?> selected='selected'<?php }?>>South Africa</option>

                                                                                        <option value="ES" <?php if($ccountry == 'ES'){?> selected='selected'<?php }?>>Spain</option>

                                                                                        <option value="LK" <?php if($ccountry == 'LK'){?> selected='selected'<?php }?>>Sri Lanka</option>

                                                                                        <option value="SH" <?php if($ccountry == 'SH'){?> selected='selected'<?php }?>>St. Helena</option>

                                                                                        <option value="PM" <?php if($ccountry == 'PM'){?> selected='selected'<?php }?>>St. Pierre and Miquelon</option>

                                                                                        <option value="SD" <?php if($ccountry == 'SD'){?> selected='selected'<?php }?>>Sudan</option>

                                                                                        <option value="SR" <?php if($ccountry == 'SR'){?> selected='selected'<?php }?>>Suriname</option>

                                                                                        <option value="SJ" <?php if($ccountry == 'SJ'){?> selected='selected'<?php }?>>Svalbard &amp; Jan Mayen Isl.</option>

                                                                                        <option value="SZ" <?php if($ccountry == 'SZ'){?> selected='selected'<?php }?>>Swaziland</option>

                                                                                        <option value="SE" <?php if($ccountry == 'SE'){?> selected='selected'<?php }?>>Sweden</option>

                                                                                        <option value="CH" <?php if($ccountry == 'CH'){?> selected='selected'<?php }?>>Switzerland</option>

                                                                                        <option value="SY" <?php if($ccountry == 'SY'){?> selected='selected'<?php }?>>Syrian Arab Republic</option>

                                                                                        <option value="TW" <?php if($ccountry == 'TW'){?> selected='selected'<?php }?>>Taiwan</option>

                                                                                        <option value="TJ">Tajikistan</option>

                                                                                        <option value="TZ">Tanzania</option>

                                                                                        <option value="TH">Thailand</option>

                                                                                        <option value="TG">Togo</option>

                                                                                        <option value="TK">Tokelau</option>

                                                                                        <option value="TO">Tonga</option>

                                                                                        <option value="TT">Trinidad and Tobago</option>

                                                                                        <option value="TN">Tunisia</option>

                                                                                        <option value="TR">Turkey</option>

                                                                                        <option value="TM">Turkmenistan</option>

                                                                                        <option value="TC">Turks &amp; Caicos Islands</option>

                                                                                        <option value="TV">Tuvalu</option>

                                                                                        <option value="UG">Uganda</option>

                                                                                        <option value="UA">Ukraine</option>

                                                                                        <option value="AE">United Arab Emirates</option>

                                                                                        <option value="GB">United Kingdom</option>

                                                                                        <option value="US">United States</option>

                                                                                        <option value="UY">Uruguay</option>

                                                                                        <option value="UZ">Uzbekistan</option>

                                                                                        <option value="VU">Vanuatu</option>

                                                                                        <option value="VE">Venezuela</option>

                                                                                        <option value="VN">Vietnam</option>

                                                                                        <option value="VG">Virgin Islands, British</option>

                                                                                        <option value="VI">Virgin Islands, U.S.</option>

                                                                                        <option value="WF">Wallis and Futuna Islands</option>

                                                                                        <option value="EH">Western Sahara</option>

                                                                                        <option value="YE">Yemen</option>

                                                                                        <option value="YU">Yugoslavia</option>

                                                                                        <option value="ZM">Zambia</option>

                                                                                        <option value="ZW">Zimbabwe</option>

                                                                                    </select>
                                                                                                                                      <!--  <select id="ccountry" name="ccountry">
                                                                                                                                            <option value="">--Select Country*--</option>
                                                                                                                                            <option value="US">United States</option>
                                                                                                                                            <option value="CA">Canada</option>
                                                                                                                                        </select>-->
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep cust-select">

                                                                                    <select onChange="this.className=this.options[this.selectedIndex].className"
    class="greenText" id="cstate" name="cstate">
                                                                                        <option value="">--Select State*--</option>
                                                                                        <option value="x" disabled="disabled">&nbsp;</option>
                                                                                        <option value="x" disabled="disabled">--United States--</option>
                                                                                        <option value="AP">APO/FPO</option>
                                                                                        <option value="AL">Alabama</option>
                                                                                        <option value="AK">Alaska</option>
                                                                                        <option value="AZ">Arizona</option>
                                                                                        <option value="AR">Arkansas</option>
                                                                                        <option value="CA">California</option>
                                                                                        <option value="CO">Colorado</option>
                                                                                        <option value="CT">Connecticut</option>
                                                                                        <option value="DE">Delaware</option>
                                                                                        <option value="DC">District of Columbia</option>
                                                                                        <option value="FL">Florida</option>
                                                                                        <option value="GA">Georgia</option>
                                                                                        <option value="HI">Hawaii</option>
                                                                                        <option value="ID">Idaho</option>
                                                                                        <option value="IL">Illinois</option>
                                                                                        <option value="IN">Indiana</option>
                                                                                        <option value="IA">Iowa</option>
                                                                                        <option value="KS">Kansas</option>
                                                                                        <option value="KY">Kentucky</option>
                                                                                        <option value="LA">Louisiana</option>
                                                                                        <option value="ME">Maine</option>
                                                                                        <option value="MD">Maryland</option>
                                                                                        <option value="MA">Massachusetts</option>
                                                                                        <option value="MI">Michigan</option>
                                                                                        <option value="MN">Minnesota</option>
                                                                                        <option value="MS">Mississippi</option>
                                                                                        <option value="MO">Missouri</option>
                                                                                        <option value="MT">Montana</option>
                                                                                        <option value="NC">North Carolina</option>
                                                                                        <option value="ND">North Dakota</option>
                                                                                        <option value="NE">Nebraska</option>
                                                                                        <option value="NV">Nevada</option>
                                                                                        <option value="NH">New Hampshire</option>
                                                                                        <option value="NJ">New Jersey</option>
                                                                                        <option value="NM">New Mexico</option>
                                                                                        <option value="NY">New York</option>
                                                                                        <option value="OH">Ohio</option>
                                                                                        <option value="OK">Oklahoma</option>
                                                                                        <option value="OR">Oregon</option>
                                                                                        <option value="PA">Pennsylvania</option>
                                                                                        <option value="PR">Puerto Rico</option>
                                                                                        <option value="RI">Rhode Island</option>
                                                                                        <option value="SC">South Carolina</option>
                                                                                        <option value="SD">South Dakota</option>
                                                                                        <option value="TN">Tennessee</option>
                                                                                        <option value="TX">Texas</option>
                                                                                        <option value="UT">Utah</option>
                                                                                        <option value="VT">Vermont</option>
                                                                                        <option value="VI">Virgin Islands</option>
                                                                                        <option value="VA">Virginia</option>
                                                                                        <option value="WV">West Virginia</option>
                                                                                        <option value="WA">Washington</option>
                                                                                        <option value="WI">Wisconsin</option>
                                                                                        <option value="WY">Wyoming</option>
                                                                                        <option value="x" disabled="disabled">&nbsp;</option>
                                                                                        <option value="x" disabled="disabled">--Canada--</option>
                                                                                        <option value="AB">Alberta</option>
                                                                                        <option value="BC">British Columbia</option>
                                                                                        <option value="MB">Manitoba</option>
                                                                                        <option value="NB">New Brunswick</option>
                                                                                        <option value="NF">Newfoundland</option>
                                                                                        <option value="NT">North West Territory</option>
                                                                                        <option value="NS">Nova Scotia</option>
                                                                                        <option value="ON">Ontario</option>
                                                                                        <option value="PE">Prince Edward Island</option>
                                                                                        <option value="PQ">Quebec</option>
                                                                                        <option value="SK">Saskatchewan</option>
                                                                                        <option value="YT">Yukon Territory</option>
                                                                                        <option value="x" disabled="disabled">&nbsp;</option>
                                                                                        <option value="OS">Other State / Province</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="ccity" name="ccity" value="<?= $ccity?>" type="text" placeholder="City*" class="form-control" >
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="czip" name="czip" value="<?= $czip?>" type="text" placeholder="Zip Code*" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">
                                                                                    <select name="phone_code" id="phone_code" class="form-control" style="width: 38%;float: left;">
                                                                                        <option value="">--Select--</option>
                                                                                        
                                                                                        <?php
                                                                                        $result = mysql_query("SELECT code,value, substring( code, 2, 3)  as code_value FROM country_code where code <> '' order by code_value * 1 asc"); //Count from local API dynamic data
                                                                                        while($row = mysql_fetch_array($result)){?>
                                                                                                <option value="<?php echo $row['code'];?>" <?php if($phone_code == $row['code']){?>selected="selected"<?php }?>><?php echo $row['code'].' - '.$row['value'];?></option>
                                                                                                
                                                                                            <?php }
                                                                                        ?>
                                                                                    </select>    
                                                                                    <input name="cphone" id="cphone" required="required" value="<?= $cphone;?>" placeholder="Phone*" type="text" class="form-control" autocomplete="off" style='width: 62%;'>
                                                                                        <p for="cphone" class="warning" id="val-cphone-error"></p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="cemail" name="cemail" value="<?= $cemail;?>"  placeholder="Email*" class="form-control"  type="email">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </fieldset>
                                                                    <button type="button" style="margin-top:10px;" class="green-btn pull-right" id="goAccorFour">Continue to Payment Methods</button>
                                                                </div>
                                                            </div>

                                                            <div class="panel panel-default accord-container" style="border-radius:0px; margin-top:-1px;">
                                                                <div class="panel-heading" id="accorHeadFour"><span class="label label-dark">4</span>Payment Methods</div>
                                                                <div class="panel-body" id="accorBodyFour">
                                                                    <fieldset data-step="3">
                                                                        <div class="row">
                                                                            <div class="col-sm-12" id="review-cart">
                                                                                <div id="ajaxTotal"  style="height:160px;margin-bottom:0px;">


                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="step_info">
                                                                                    <h4>Payment Methods</h4>
                                                                                    <img src="<?php echo $vpath; ?>images/credit-cards.png" style="margin:10px 0;" /> </div>

                                                                                <div class="form-group cust-select">

                                                                                    <select onChange="this.className=this.options[this.selectedIndex].className" class="greenText" id="ccardtype" name="ccardtype" >
                                                                                        <option value="" selected="selected">--Select Card*--</option>
                                                                                        <option value="AX" <?php if($ccardtype == 'AX'){?> selected="selected"<?php }?>>American Express</option>
                                                                                        <option value="VI" <?php if($ccardtype == 'VI'){?> selected="selected"<?php }?>>Visa</option>
                                                                                        <option value="MC" <?php if($ccardtype == 'MC'){?> selected="selected"<?php }?>>MasterCard</option>
                                                                                        <option value="DI" <?php if($ccardtype == 'DI'){?> selected="selected"<?php }?>>Discover</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group">

                                                                                    <input id="ccardname" name="ccardname" value="<?= $ccardname?>" type="text" placeholder="Name On Card*" class="form-control" />
                                                                                </div>
                                                                                <div class="form-group">

                                                                                    <input id="ccardnum" name="ccardnum" value="<?= $ccardnum?>" onKeyPress="masking(this.value,this,event);" onBlur="validateCard(this.value)" type="text" placeholder="Card Number*" maxlength="19" class="form-control">
                                                                                        <p class="warning" id="Vali-ccardnum-error"></p>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div style="width:52%; float:left;">
                                                                                        <input id="experition_date" name="experition_date" value="<?= $carddate;?>" type="text" autocomplete="off" placeholder="Expiration Date*"  readonly="readonly" class="form-control monthPicker">
                                                                                    </div>

                                                                                    <div style="width:46%; float:right;">
                                                                                        <input id="cvv2" name="cvv2" type="password" placeholder="CVV Code*" maxlength="4" class="form-control">
                                                                                    </div>

                                                                                </div>

                                                                            </div>
                                                                            <div class="col-sm-6" style="height: 100%; float:left;">
                                                                                <div class="step_info">
                                                                                    <h4>&nbsp;</h4>
                                                                                    <img src="<?php echo $vpath; ?>images/secure-pay.jpg" style="margin:10px 0;" /> </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-12 form_sep">
                                                                                <small>All flowers, plants, or containers may not always be available. By checking this box, you give us permission to make reasonable substitutions to ensure we deliver your order in a timely manner. Substitutions will not affect the value or quality of your order.</small>
                                                                            </div>
                                                                            <div class="clearfix"></div>
                                                                            <div class="col-sm-12 form_sep" style="margin-top:5px;">
                                                                                <label for="acceptTerms" class="checkbox inline checkbox2" style="font-size:12px;">
                                                                                    <input id="acceptTerms" name="acceptTerms" type="checkbox">
                                                                                        I agree with the Terms and Conditions.</label>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                                    <input type="submit" name="api_call" id="finalPay" class="green-btn pull-right" style="margin-top:10px; width:200px;" value="Generate API Call" />
                                                            
                                                            </div>
                                    
                                                            </div>
                                                                
                                                            </div>
                                                            <div class="col-sm-3 pull-right right_sidebar">

                                                                <div class="security"> <a target="_blank" href="/static/checkout/vbv_toolkit/service_desc_popup.htm">This website is secure. Your personal details are safe. </a>

                                                                    <a target="_blank" href="https://www.export.gov/safeharbor"></a><br />

                                                                    <img src="<?php echo $vpath ?>images/security.png" />
                                                                    <div class="clear"></div>
                                                                    <img src="<?php echo $vpath ?>images/comodo.png"  />
                                                                    <div class="clear"></div>
                                                                </div>
                                                                <div class="global-options">
                                                                    <label for="lang">Applied Language</label>
                                                                    <select id="lang" name="lang">
                                                                        <option value="en" selected="">English</option>

                                                                    </select>
                                                                    <label for="tco_currency">Applied Currency</label>
                                                                    <select id="tco_currency" name="tco_currency">

                                                                        <option value="USD" selected="selected">USD - U.S. Dollar</option>

                                                                    </select>
                                                                    <div class="clear"></div>
                                                                </div>
                                                                <div class="panel panel-default" id="ajaxCartSummary">
                                                                    <div class="panel-body questions">
                                                                        <div class="summary">
                                                                            <h3>Cart Summary</h3>
                                                                            <table class="summary-table">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="item">All Items</td>
                                                                                        <td class="price"><span class="purchase_display_currency">$</span><?php echo $product['price']; ?></td>
                                                                                        
                                                                                    </tr>                                                                                    
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="panel-footer summary">
                                                                        <div class="summary-total">
                                                                            <div class="total-label">Total (USD)</div>
                                                                            <div class="total-price"><span class="purchase_display_currency">$</span><?php echo $product['price']; ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--<div class="questions">
                                                                    <div class="summary">
                                                                        <h3>Cart Summary</h3>
                                                                        <table class="summary-table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="item">All Items</td>
                                                                                    <td class="price"><span class="purchase_display_currency">$</span><?php //echo $product['price'];         ?> *</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="left" colspan="2" valign="top" style="font-size:9px;">*Before service charges &amp; taxes.</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <div class="summary-total">
                                                                            <div class="total-label">Total (USD)</div>
                                                                            <div class="total-price"><span class="purchase_display_currency">$</span><?php //echo $product['price'];         ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>-->

                                                            </div>
                                                            <div class="clear"></div>

                                                            <p class="text-center" style="margin-bottom:0px;">
                                                                <img src="<?php echo $vpath ?>images/comodo_seal_recolored.png" style="max-width:250px;" />

                                                            </p>

                                                            </div>
                                                            </div>

</form>



                                                            <script>
                        $(document).ready(function() {


                            var FULL_BASE_URL = $('#hidden_site_baseurl').val(); // For base path of value;
                            //$('#rzip').trigger('change');
                            $.ajax({
                                type: "POST",
                                data: 'zip_code=10011',
                                url: FULL_BASE_URL + 'getDeliveryDates.php',
                                beforeSend: function() {
                                    $('#deliverydate').attr('disabled', 'disabled');
                                    // $('#ProjectId').attr('disabled', 'disabled');
                                    //return false;
                                },
                                success: function(return_data) {
                                    $('#deliverydate').removeAttr('disabled');
                                    $('#deliverydate').html(return_data);
                                }
                            });


                            $('#rzip_').change(function() {

                                var zip_code = $(this).val();
                                var itemCode = $('#itemCode').val();
                                var dataString = 'zip_code=' + zip_code;
                                $('#deliverydate').attr('disabled', 'disabled');


                                $.ajax({
                                    type: "POST",
                                    data: dataString,
                                    url: FULL_BASE_URL + 'getDeliveryDates.php',
                                    beforeSend: function() {
                                        $('#deliverydate').attr('disabled', 'disabled');
                                        // $('#ProjectId').attr('disabled', 'disabled');
                                        //return false;
                                    },
                                    success: function(return_data) {
                                        $('#deliverydate').removeAttr('disabled');
                                        $('#deliverydate').html(return_data);
                                    }
                                });


                            });


                            $('#rzip').change(function() {
                                var zip_code = $(this).val();
                                var itemCode = $('#itemCode').val();
                                var dataString = 'zip_code=' + zip_code + '&itemCode=' + itemCode;
                                $('#ajaxTotal').addClass('loader');

                                $.ajax({
                                    type: "POST",
                                    data: dataString,
                                    url: FULL_BASE_URL + 'getTotal.php',
                                    beforeSend: function() {
                                        $('#ajaxTotal').addClass('loader');
                                        // $('#ProjectId').attr('disabled', 'disabled');
                                        //return false;
                                    },
                                    success: function(return_data) {
                                        $('#ajaxTotal').removeClass('loader');
                                        $('#ajaxTotal').html(return_data);
                                    }
                                });

                            });




                            $("#shipping_chk").bind('click', function() {
                                //var fullName = $('#rname').val();

                                if ($(this).is(":checked")) {
                                    $("#cfirstname").val($('#rfirstname').val());
                                    $("#clastname").val($('#rlastname').val());
                                    $("#caddress1").val($('#raddress1').val());
                                    $("#caddress2").val($('#raddress2').val());
                                    $("#ccity").val($('#rcity').val());
                                    $("#cstate").val($('#rstate').val());
                                    $("#ccountry").val($('#rcountry').val());
                                    $("#czip").val($('#rzip').val());
                                    //$("#cphone").val($('#rphone').val());

                                }
                                else {
                                    $("#cfirstname").val('');
                                    $("#clastname").val('');
                                    $("#caddress1").val('');
                                    $("#caddress2").val('');
                                    $("#ccity").val('');
                                    $("#cstate").val('');
                                    $("#ccountry").val('');
                                    $("#czip").val('');
                                    //$("#cphone").val('');

                                }
                            });

                            $("#renclosure").focus(function() {
                                if ($(this).val() == "Please enter your personalized message here. Don't forget to add your name.") {
                                    $(this).val('');
                                }
                            });

                            $("#renclosure").blur(function() {
                                if ($(this).val() == "") {
                                    $(this).val("Please enter your personalized message here. Don't forget to add your name.");
                                }
                            });
                            $("#rinstructions").focus(function() {
                                if ($(this).val() == "If you have specific instructions for our delivery team, you may add them here.") {
                                    $(this).val('');
                                }
                            });

                            $("#rinstructions").blur(function() {
                                if ($(this).val() == "") {
                                    $(this).val("If you have specific instructions for our delivery team, you may add them here.");
                                }
                            });
                            $('.btn-default').click(function() {
                                // alert('df');
                                //return false;
                            });


                        });
                                                            </script>
                                                            </body>
                                                            </html>
