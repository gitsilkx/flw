<?php
include("configs/path.php");
include("getProducts.php");

$strZipCode = $_REQUEST['zip_code'];
$itemCode = $_REQUEST['itemCode'];
$product = $ins->getProduct(API_USER, API_PASSWORD, $itemCode);
$arrProducts = array(
    0 =>
    array(
        "code" => $product['code'],
        "price" => $product['price']
    ),
);
$ins->getTotal(API_USER, API_PASSWORD, $strZipCode, $arrProducts, $strAffiliateServiceCharge = '', $strAffiliateTax = '');

?>

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
                    <td colspan="2" class="text-right">Service Charge: $ <?php echo $ins->arrTotal['serviceChargeTotal'];?></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" class="text-right"><span style="font-size:18px;">Current Total $ <?php echo $product['price'] + $ins->arrTotal['serviceChargeTotal']; ?></td>
                </tr>

            </tbody>
        </table>

