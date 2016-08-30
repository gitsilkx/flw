<?php
include("configs/path.php");
include("getProducts.php");
if ($_GET['code'] && $_GET['code'] != '') {
    $itemCode = $_GET['code'];
}
$_SESSION['calling_url'] = $_SERVER['HTTP_REFERER'];

//$product = $ins->getProduct(API_USER, API_PASSWORD, $itemCode);
$r = mysql_query("select * from products where product_no='".$itemCode."'");
$product = @mysql_fetch_array($r);
?>
<script>
$(document).ready(function() {
    $('.add-to-cart').click( function () {

        var value=$(this).attr("name"); 
        var occasion_id = $('#occasion_id').val();
        var type_id = $('#type_id').val();
        var product_no = $('#product_no').val();
	$.ajax({
		type: "POST",
		url: "<?=$vpath?>addupdatecart.php",
		data: "product_id="+value+"&qty=1&occasion_id="+occasion_id+"&type_id="+type_id+"&addtocartnew=1", 
		beforeSend:  function() {
		$('#ajax_cart').html('<img src="<?=$vpath?>images/loader1.gif" style="position:absolute; padding: 22px;" />');
		},
		success: function(data){
                    window.location.assign("<?=$vpath?>checkout.php?code="+product_no)
		//alert(data);
                //$('#ajax_cart').html('<a class="btn-pink" href="cart.php">VIEW CART</a>')
		//$("#crtup").empty().html(data);
		//cartlist();
                
                
		 	}
		});		
		
    });

    });
    </script>
    <input type="hidden" name="product_id" value="<?php echo $product['id']?>">
    <input type="hidden" name="product_no" id="product_no" value="<?php echo $product['product_no']?>">
        <input type="hidden" id="type_id" name="type_id" value="<?php echo $product['type_id']?>">
        <input type="hidden" name="qty" value="1">
        <input type="hidden" name="occasion_id" id="occasion_id" value="1" />
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
            <a class="add-to-cart" name="<?php echo $product['id']; ?>"><img src="<?php echo $vpath;?>images/BUY_BOTTON2.jpg" style="margin:11px 110px 0 0; float:right" alt="<?php echo $product['name']; ?>"/></a>
        </div>

    </div>

</section>

