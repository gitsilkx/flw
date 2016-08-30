<?php
include("configs/path.php");
include("getProducts.php");
if ($_GET['code'] && $_GET['code'] != '') {
    $itemCode = $_GET['code'];
}
$_SESSION['calling_url'] = $_SERVER['HTTP_REFERER'];

$product = $ins->getProduct(API_USER, API_PASSWORD, $itemCode);
?>
<section id="item_full" class="container">
    <div id="container">
        <div id="item_image">
            <span class="item_name"><?php echo $product['name']; ?></span>
            <img src="<?php echo $product['image']; ?>">
        </div>
        <div id="item_description">
            
            <span class="item_code">Item No. <?php echo $product['code']; ?></span>
            <span class="item_description"><?php echo $product['description']; ?></span>
            <span class="item_price">$<?php echo $product['price']; ?></span>
            <?php if($product['price']<> ''){?>
            <a href="<?= $vpath; ?>checkout.php?code=<?php echo $itemCode; ?>"><img src="<?php echo $vpath;?>images/BUY_BOTTON2.jpg" style="margin:11px 110px 0 0; float:right" alt="<?php echo $product['name']; ?>"/></a>
            <?php }else{?>
            <image src="<?php echo $vpath; ?>images/sold_out.png" alt="soldout" />
            <?php }?>
        </div>

    </div>

</section>