<?php
include("include/header.php");
include("getProducts.php");
if ($_GET['code'] && $_GET['code'] != '') {
    $itemCode = $_GET['code'];
}
$strSoapUsername = '787040';
$strSoapPassword = 'yEEBpE';
$product = $ins->getProduct($strSoapUsername, $strSoapPassword, $itemCode);
?>

<section class="container">
    <div id="container" class="checkout_container">
        <h1 class="checkout-header-2">My Cart</h1>
            <div id="inside_cart">
            <div class="checkout" style="padding-top:0;margin-top:0;">
                <div class="cart_items-wide grey-border"> 

                    <div class="odd">
                        <table>
                            <tbody><tr>
                                    <td width="150"><a href="<?= $vpath; ?>item.php?code=<?php echo $product['code'];?>" data-fancybox-type="iframe" class="fancyboxIframe"><img src="<?php echo $product['thumbnail']; ?>" height="130px"></a></td>
                                    <td width="450">
                                        <a href="<?= $vpath; ?>item.php?code=<?php echo $product['code'];?>" class="cart-item-name" data-fancybox-type="iframe" class="fancyboxIframe"><?php echo $product['name']; ?></a><br><br>   
                                    </td>
                                    <td width="200"><span class="price-label">Price:</span> 
                                        <span class="price-price">$<?php echo $product['price'];?></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>



                    <div class="odd pink-solid" id="top" style="height: 60px; ">
                        <span class="price_type" style="padding-left: 200px;">Subtotal</span><span>:</span>
                        <span class="price" style="padding-left: 200px;">
                            $<?php echo $product['price'];?>
                        </span>
                    </div>

                    <div class="even" style="height: 60px;">
                        <span class="price_type" style="padding-left: 200px;">Before service charge</span>
                    </div>
                    <div class="even">
                        <span class="cart-checkout-2">

                            <table align="center">

                                <tbody>
                                    <tr>
                                        <td>
                                            <form novalidate="novalidate" class="cmxform" id="zipform2" method="post" action="<?= $vpath; ?>checkout.php">
                                                <input name="code" value="<?php echo $product['code'];?>"type="hidden">
                                                <input aria-disabled="false" role="button" class="continue-checkout ui-button ui-widget ui-state-default ui-corner-all" value="Checkout" type="submit">
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center"><a class="continue-shopping" href="<?= $vpath; ?>">continue shopping</a></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </span>
                    </div>

                </div> 
            </div>
        </div>
    </div>
</section>
<?php include("include/footer.php"); ?>