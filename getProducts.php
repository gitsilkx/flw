<?php

error_reporting(0);
require_once('lib/nusoap.php');

class Lead {

    var $strSource;
    var $arrProducts = array();
    var $arrDates = array();
    var $arrTotal = array();
    var $arrOrder = array();
    var $arrTickets = array();
    var $arrCategory = array("ao" => "everyday ", "bd" => "birthday ", "an" => "anniversary ", "lr" => "love  & romance", "gw" => "get well", "nb" => "new baby", "ty" => "thank you ", "sy - sympathy", "c" => "centerpieces", "o" => "one sided arrangements", "n" => "novelty arrangements", "v" => "vased arrangements", "r" => "roses ", "q" => "cut bouquets", "x" => "fruit baskets", "p" => "plants", "b" => "balloons", "fa" => "table arrangements", "fb" => "baskets", "fs" => "sprays", "fp" => "floor plants", "fi" => "inside casket", "fw" => "wreaths", "fh" => "hearts", "fx" => "crosses", "fc" => "casket sprays", "apop" => "all items, sorted by popularity", "aaz" => "all items, sorted alphabetically", "apa" => "all items, sorted by price (ascending)", "apd" => "all items, sorted by price (descending)");
    var $strAction = null;
    //Soap Server Information
    //var $strSoapServer = "https://www.floristone.com/webservices/flowershop.cfc?wsdl";
    var $strSoapServer = "https://www.floristone.com/webservices4/flowershop.cfc?wsdl"; //New WSDL";
    var $strSoapServerError;
    var $strResponse = null;
    var $arrOutput = array();
    var $errors = array();
    var $strSuccess;
    var $strInfo;
    var $config = null;
    var $daoAdmin = null;

    function run() {


        //Here output element is $this->arrOutput & Error element is $this->strSoapServerError
        //1) Get Product Details
        //Input
        $strSoapUsername = "787040";  //Your Soap username
        $strSoapPassword = "yEEBpE";      //Your Soap password
        $strCategory = "ao";
        $intProductCount = "10"; // number of products
        $intStart = "1";

        //FIRST FUNCTION CALL

        $this->getProductDetails($strSoapUsername, $strSoapPassword, $strCategory, $intProductCount, $intStart); //return value stored in $this->arrProducts
        //var_dump($this->arrProducts);
        //Output
        /* array(1) {
          [1]=>
          array(6) {
          [code]=>code1
          [name]=>name1
          [price]=>price1
          [thumbnail]=>thumbnail1
          [image]=>image1
          [description]=>description1
          },
          [2]=>
          array(6) {
          [code]=>code2
          [name]=>name2
          [price]=>price2
          [thumbnail]=>thumbnail2
          [image]=>image2
          [description]=>description2
          }....
          } */


        //2) Get Delivery Dates
        //Input
        /* $strSoapUsername = "123456";
          $strSoapPassword = "abcd";
          $strZipCode = "93710"; */

        //SECOND FUNCTION CALL
        //$this->getDeliveryDates($strSoapUsername,$strSoapPassword,$strZipCode); //return value stored in $this->arrDates
        // print_r($this->arrDates);
        //Output
        /* array(25) {
          0=>2010-12-15T05:00:00.000Z
          1=>2010-12-16T05:00:00.000Z
          2=>2010-12-17T05:00:00.000Z
          .
          .
          .
          } */

        //3) Get Total
        //Input
        /* $strSoapUsername = "123456";  //Your Soap username
          $strSoapPassword = "abcd";      //Your Soap password
          $strZipCode  = "10020";
          $arrProducts = array (
          0=>
          array (
          "code"=>"enter product code here",
          "name"=>"enter product name here",
          "price"=>"enter product price here",
          "thumbnail"=>"enter product thumbnail here",
          "image"=>"enter image here",
          "description"=>"enter product description here"
          ),
          1=>
          array (
          "code"=>"enter product code here",
          "name"=>"enter product name here",
          "price"=>"enter product price here",
          "thumbnail"=>"enter product thumbnail here",
          "image"=>"enter image here",
          "description"=>"enter product description here"
          )
          );// this value can get from getProducts() call.. $arrProducts = $this->arrProducts;
          $strAffiliateServiceCharge = null;
          $strAffiliateTax = null; */

        //THIRD FUNCTION CALL
        //$this->getTotal($strSoapUsername ,$strSoapPassword ,$strZipCode ,$arrProducts ,$strAffiliateServiceCharge,$strAffiliateTax ); //return value stored in $this->arrTotal
        //var_dump($this->arrTotal);
        //Output
        /* array(9) {
          ["affiliateServiceCharge"]=> affiliateServiceCharge
          ["affiliateTax"]=> affiliateTax
          ["floristOneServiceCharge"]=> floristOneServiceCharge
          ["floristOneTax"]=> floristOneTax
          ["orderNumber"]=> orderNumber
          ["orderTotal"]=> orderTotal
          ["serviceChargeTotal"]=> serviceChargeTotal
          ["subTotal"]=> subTotal
          ["taxTotal"]=> taxTotal
          } */

        //4) Place Order
        //Input

        /* $strSoapUsername = "123456";  //Your Soap username
          $strSoapPassword = "abcd";      //Your Soap password
          $arrRecipient = array("address1"=>"Address Line 1","address2"=>"Address Line 2","city"=>"Recipient City","country"=>"Recipient Country","email"=>"Recipient Email","institution"=>"Recipient Institution","name"=>"RecipientName","phone"=>"Recipient Phone","state"=>"Recipient State","zip"=>"Recipient Zip");
          $arrCustomer = array("address1"=>"Address Line 1","address2"=>"Address Line 2","city"=>"Customer City","country"=>"Customer Country","email"=>"Customer Email","institution"=>"Customer Institution","name"=>"CustomerName","phone"=>"Customer Phone","state"=>"Customer State","zip"=>"Customer Zip");
          $customerIP = "127.127.127.127";
          $arrCCInfo = array("ccExpMonth"=>11,"ccExpYear"=>11,"ccNum"=>"xxxxxxxxx","ccSecCode"=>"999","ccType"=>"VI");$cardMsg = "I LOVE YOU LETISHA!!"; //ccNum->CreditCard Number
          $specialInstructions = "Please deliver this item on time!";
          $deliveryDate =  "2010-12-25T05:00:00.000Z"; //you can get this value from getDeliveryDates() call... the value must be dateTime format eg: 2011-01-15T05:00:00.000Z
          $affiliateServiceCharge = "0";
          $affiliateTax = "0";
          $orderTotal = "123.345"; // You can get this value from getTotal() call.... $this->arrTotal['orderTotal'];
          $subAffiliateID = 0;
          $arrProducts = array (
          0=>
          array (
          "code"=>"enter product code here",
          "name"=>"enter product name here",
          "price"=>"enter product price here",
          "thumbnail"=>"enter product thumbnail here",
          "image"=>"enter image here",
          "description"=>"enter product description here"
          ),
          1=>
          array (
          "code"=>"enter product code here",
          "name"=>"enter product name here",
          "price"=>"enter product price here",
          "thumbnail"=>"enter product thumbnail here",
          "image"=>"enter image here",
          "description"=>"enter product description here"
          )
          ); // this value can get from getProducts() call.. $arrProducts = $this->arrProducts; */



        //FOURTH FUNCTION CALL
        //$this->placeOrder($strSoapUsername ,$strSoapPassword ,$arrRecipient ,$arrCustomer,$customerIP ,$arrCCInfo ,$arrProducts ,$cardMsg ,$specialInstructions ,$deliveryDate ,$affiliateServiceCharge ,$affiliateTax ,$orderTotal ,$subAffiliateID );//return value stored in $this->arrOrder
        //var_dump($this->arrOrder);
        //Output
        /* array(9) {
          ["affiliateServiceCharge"]=> affiliateServiceCharge
          ["affiliateTax"]=> affiliateTax
          ["floristOneServiceCharge"]=> floristOneServiceCharge
          ["floristOneTax"]=> floristOneTax
          ["orderNumber"]=> orderNumber
          ["orderTotal"]=> orderTotal
          ["serviceChargeTotal"]=> serviceChargeTotal
          ["subTotal"]=> subTotal
          ["taxTotal"]=> taxTotal
          } */



        //5) Create Customer Ticket
        //Input
        /* $strSoapUsername = "123456"; //Your Soap username
          $strSoapPassword = "abcd";      //Your Soap password
          $strOrerNumber = "123456";     //You can get this value from PlaceOrder() call....$this->arrOrder['orderNumber'];
          $strIssue = "Was this item delivered?"; */


        //FIFTH function call
        //$this->createCustomerServiceTicket($strSoapUsername ,$strSoapPassword ,$strOrerNumber,$strIssue);//return value stored in $this->arrTickets
        //var_dump($this->arrTickets);
        //Output
        /* array(1) {
          [TicketNum>]=>"corresponding ticket number"
          } */
    }

    //Get Product Details
    function getProductDetails($strSoapUsername, $strSoapPassword, $strCategory, $intProductCount, $intStart ) {
        $blnResult = false;

        // Create the client instance
        $client = new nusoap_client($this->strSoapServer, true);



        // Check for an error
        $strErrors = $client->getError();
        if ($strErrors) {
            if (is_array($strErrors)) {
                $this->strSoapServerError = implode("\r\n", $strErrors);
            } else {
                $this->strSoapServerError = $strErrors;
            }
            //echo("ERORR in Connecting with SOAP server");
            return $blnResult;
        }


        // Call the SOAP method

        $result = $client->call('getProducts', array("APIKey" => $strSoapUsername, "APIPassword" => $strSoapPassword, "category" => $strCategory, "numProducts" => $intProductCount, "startAt" => $intStart));
        // Check for a fault
        if (count($result['errors']) > 0) {
            $strErrors = null;
            if (is_array($result['errors'])) {
                foreach ($result['errors'] as $key => $strTempError) {
                    $strErrors .= $result['errors'][$key]['field'] . " : " . $result['errors'][$key]['message'] . "\r\n";
                }
                $this->strSoapServerError = $strErrors;
            } else {
                $this->strSoapServerError = $result['errors'];
            }
        } elseif (count($result['products']) > 0) {
            $arrInput = $result['products'];
            $arrOurput = array();
            foreach ($arrInput as $arrTemp) {
                $arrOurput[] = array_map("trim", $arrTemp);
            }
            $this->arrProducts = $arrOurput;
            unset($arrInput);
            unset($arrOurput);
            unset($arrTemp);
            $blnResult = true;
        } elseif ($strErrors = $client->getError()) {

            if (is_array($strErrors) && count($strErrors) > 0) {
                $this->strSoapServerError = implode("\r\n", $strErrors);
            } else {
                $this->strSoapServerError = $strErrors;
            }
        } else {
            $this->strSoapServerError = $client->response;
        }

        return $blnResult;
    }

    //Get Delivery Dates
    function getDeliveryDates($strSoapUsername, $strSoapPassword, $strZipCode) {

        $blnResult = false;

        // Create the client instance
        $client = new nusoap_client($this->strSoapServer, true);



        // Check for an error
        $strErrors = $client->getError();
        if ($strErrors) {
            if (is_array($strErrors)) {
                $this->strSoapServerError = implode("\r\n", $strErrors);
            } else {
                $this->strSoapServerError = $strErrors;
            }
            //echo("ERORR in Connecting with SOAP server");
            return $blnResult;
        }


        // Call the SOAP method

        $result = $client->call('getDeliveryDates', array("APIKey" => $strSoapUsername, "APIPassword" => $strSoapPassword, "zipcode" => $strZipCode));

        // Check for a fault
        if (count($result['errors']) > 0) {
            $strErrors = null;
            if (is_array($result['errors'])) {
                foreach ($result['errors'] as $key => $strTempError) {
                    $strErrors .= $result['errors'][$key]['field'] . " : " . $result['errors'][$key]['message'] . "\r\n";
                }
                $this->strSoapServerError = $strErrors;
            } else {
                $this->strSoapServerError = $result['errors'];
            }
        } elseif (count($result['dates']) > 0) {
            $arrInput = $result['dates'];
            $arrOurput = array();
            foreach ($arrInput as $strTemp) {
                $arrOurput[] = trim($strTemp);
            }
            $this->arrDates = $arrOurput;
            unset($arrInput);
            unset($arrOurput);
            unset($strTemp);
            $blnResult = true;
        } elseif ($strErrors = $client->getError()) {

            if (is_array($strErrors) && count($strErrors) > 0) {
                $this->strSoapServerError = implode("\r\n", $strErrors);
            } else {
                $this->strSoapServerError = $strErrors;
            }
        } else {
            $this->strSoapServerError = $client->response;
        }

        return $blnResult;
    }

    //Get Totals
    function getTotal($strSoapUsername, $strSoapPassword, $strZipCode, $arrProducts, $strAffiliateServiceCharge = "0", $strAffiliateTax = "0") {
        $blnResult = false;

        // Create the client instance
        $client = new nusoap_client($this->strSoapServer, true);



        // Check for an error
        $strErrors = $client->getError();
        if ($strErrors) {
            if (is_array($strErrors)) {
                $this->strSoapServerError = implode("\r\n", $strErrors);
            } else {
                $this->strSoapServerError = $strErrors;
            }
            //echo("ERORR in Connecting with SOAP server");
            return $blnResult;
        }


        // Call the SOAP method

        $result = $client->call('getTotal', array("APIKey" => $strSoapUsername, "APIPassword" => $strSoapPassword, "recipientZip" => $strZipCode, "products" => $arrProducts, "affiliateServiceCharge" => $strAffiliateServiceCharge, "affiliateTax" => $strAffiliateTax));

        // Check for a fault
        if (count($result['errors']) > 0) {
            $strErrors = null;
            if (is_array($result['errors'])) {
                foreach ($result['errors'] as $key => $strTempError) {
                    $strErrors .= $result['errors'][$key]['field'] . " : " . $result['errors'][$key]['message'] . "\r\n";
                }
                $this->strSoapServerError = $strErrors;
            } else {
                $this->strSoapServerError = $result['errors'];
            }
        } elseif (count($result) > 0) {
            $arrInput = $result;
            unset($arrInput['errors']);
            $arrOurput = array();
            foreach ($arrInput as $key => $strTemp) {
                $arrOurput[$key] = trim($strTemp);
            }
            $this->arrTotal = $arrOurput;
            unset($arrInput);
            unset($arrOurput);
            unset($strTemp);
            $blnResult = true;
        } elseif ($strErrors = $client->getError()) {

            if (is_array($strErrors) && count($strErrors) > 0) {
                $this->strSoapServerError = implode("\r\n", $strErrors);
            } else {
                $this->strSoapServerError = $strErrors;
            }
        } else {
            $this->strSoapServerError = $client->response;
        }

        return $blnResult;
    }

    //Place Order
    function placeOrder($strSoapUsername, $strSoapPassword, $arrRecipient, $arrCustomer = "", $customerIP = "", $arrCCInfo = "", $arrProducts = array(), $cardMsg = "", $specialInstructions = "", $deliveryDate = "", $affiliateServiceCharge = "", $affiliateTax = "", $orderTotal = "", $subAffiliateID = "0") {

        $blnResult = false;

        // Create the client instance
        $client = new nusoap_client($this->strSoapServer, true);



        // Check for an error
        $strErrors = $client->getError();
        if ($strErrors) {
            if (is_array($strErrors)) {
                $this->strSoapServerError = implode("\r\n", $strErrors);
            } else {
                $this->strSoapServerError = $strErrors;
            }
            //echo("ERORR in Connecting with SOAP server");
            return $blnResult;
        }


        // Call the SOAP method

        $result = $client->call('placeOrder', array("APIKey" => $strSoapUsername, "APIPassword" => $strSoapPassword, "recipient" => $arrRecipient, "customer" => $arrCustomer, "customerIP" => $customerIP, "ccInfo" => $arrCCInfo, "products" => $arrProducts, "cardMsg" => $cardMsg, "specialInstructions" => $specialInstructions, "deliveryDate" => $deliveryDate, "affiliateServiceCharge" => $affiliateServiceCharge, "affiliateTax" => $affiliateTax, "orderTotal" => $orderTotal, "subAffiliateID" => $subAffiliateID));
        // Check for a fault
        if (count($result['errors']) > 0) {
            $strErrors = null;
            if (is_array($result['errors'])) {
                foreach ($result['errors'] as $key => $strTempError) {
                    $strErrors .= $result['errors'][$key]['field'] . " : " . $result['errors'][$key]['message'] . "\r\n";
                }
                $this->strSoapServerError = $strErrors;
            } else {
                $this->strSoapServerError = $result['errors'];
            }
        } elseif (count($result) > 0) {
            $arrInput = $result;
            unset($arrInput['errors']);
            $arrOurput = array();
            foreach ($arrInput as $key => $strTemp) {
                $arrOurput[$key] = trim($strTemp);
            }
            $this->arrOrder = $arrOurput;
            unset($arrInput);
            unset($arrOurput);
            unset($strTemp);
            $blnResult = true;
        } elseif ($strErrors = $client->getError()) {

            if (is_array($strErrors) && count($strErrors) > 0) {
                $this->strSoapServerError = implode("\r\n", $strErrors);
            } else {
                $this->strSoapServerError = $strErrors;
            }
        } else {
            $this->strSoapServerError = $client->response;
        }

        return $blnResult;
    }

    //Create customer service ticket
    function createCustomerServiceTicket($strSoapUsername, $strSoapPassword, $strOrerNumber, $strIssue) {
        $blnResult = false;

        // Create the client instance
        $client = new nusoap_client($this->strSoapServer, true);



        // Check for an error
        $strErrors = $client->getError();
        if ($strErrors) {
            if (is_array($strErrors)) {
                $this->strSoapServerError = implode("\r\n", $strErrors);
            } else {
                $this->strSoapServerError = $strErrors;
            }
            //echo("ERORR in Connecting with SOAP server");
            return $blnResult;
        }


        // Call the SOAP method
        $result = $client->call('createCustomerServiceTicket', array("APIKey" => $strSoapUsername, "APIPassword" => $strSoapPassword, "orderNum" => $strOrerNumber, "issue" => $strIssue));

        // Check for a fault
        if (count($result['errors']) > 0) {
            $strErrors = null;
            if (is_array($result['errors'])) {
                foreach ($result['errors'] as $key => $strTempError) {
                    $strErrors .= $result['errors'][$key]['field'] . " : " . $result['errors'][$key]['message'] . "\r\n";
                }
                $this->strSoapServerError = $strErrors;
            } else {
                $this->strSoapServerError = $result['errors'];
            }
        } elseif (count($result) > 0) {
            $arrInput = $result;
            unset($arrInput['errors']);
            $arrOurput = array();
            foreach ($arrInput as $key => $strTemp) {
                $arrOurput[$key] = trim($strTemp);
            }
            $this->arrTickets = $arrOurput;
            unset($arrInput);
            unset($arrOurput);
            unset($strTemp);
            $blnResult = true;
        } elseif ($strErrors = $client->getError()) {

            if (is_array($strErrors) && count($strErrors) > 0) {
                $this->strSoapServerError = implode("\r\n", $strErrors);
            } else {
                $this->strSoapServerError = $strErrors;
            }
        } else {
            $this->strSoapServerError = $client->response;
        }

        return $blnResult;
    }

    function getProduct($strSoapUsername, $strSoapPassword, $itemCode) {
        $blnResult = false;

        // Create the client instance
        $client = new nusoap_client($this->strSoapServer, true);



        // Check for an error
        $strErrors = $client->getError();
        if ($strErrors) {
            if (is_array($strErrors)) {
                $this->strSoapServerError = implode("\r\n", $strErrors);
            } else {
                $this->strSoapServerError = $strErrors;
            }
            //echo("ERORR in Connecting with SOAP server");
            return $blnResult;
        }


        // Call the SOAP method

        $result = $client->call('getProduct', array("APIKey" => $strSoapUsername, "APIPassword" => $strSoapPassword, "itemCode" => $itemCode));
        if (count($result['errors']) > 0) {
            $strErrors = null;
            if (is_array($result['errors'])) {
                foreach ($result['errors'] as $key => $strTempError) {
                    $strErrors .= $result['errors'][$key]['field'] . " : " . $result['errors'][$key]['message'] . "\r\n";
                }
                $this->strSoapServerError = $strErrors;
            } else {
                $this->strSoapServerError = $result['errors'];
            }
        } elseif (count($result['product']) > 0) {
            $blnResult = $result['product'];
        } elseif ($strErrors = $client->getError()) {

            if (is_array($strErrors) && count($strErrors) > 0) {
                $this->strSoapServerError = implode("\r\n", $strErrors);
            } else {
                $this->strSoapServerError = $strErrors;
            }
        } else {
            $this->strSoapServerError = $client->response;
        }

        return $blnResult;
    }

}

$ins = new Lead();
?>

