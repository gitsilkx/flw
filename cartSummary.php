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
                    <tr>
                        <td class="item">Service Charge</td>
                        <td class="price"><span class="purchase_display_currency">$</span><?php echo $ins->arrTotal['serviceChargeTotal']; ?></td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-footer summary">
        <div class="summary-total">
            <div class="total-label">Total (USD)</div>
            <div class="total-price"><span class="purchase_display_currency">$</span><?php echo $product['price'] + $ins->arrTotal['serviceChargeTotal'];  ?></div>
        </div>
    </div>
</div>


