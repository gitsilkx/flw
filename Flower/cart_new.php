<?php
include("configs/path.php");
include("getProducts.php");

$r = mysql_query("select " . $prev . "cart.*,products.name,products.price,products.product_no,products.id as product_id,products.flowerwyz_image," . $prev . "cart.type_id from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'");
//echo "select " . $prev . "cart.*,products.* from " . $prev . "cart," . $prev . "products where " . $prev . "cart.product_id=products.id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'";
$totRow = mysql_num_rows($r);
//print_r($r);
?>
<script type="text/javascript">
    function removepr(id,product_id) {      
       $('#loading').html('<div class="visiblediv" ><img src="<?= $vpath ?>images/login_loader.gif"  /></div>');
        $.ajax({
            type: "POST",
            url: "<?= $vpath ?>removecart.php",
            data: "id=" + id,
            success: function(data) {
                if (data == 1) {
                    $("#cart_" + id).fadeOut('slow'); 
                    //$('#remove_cart_'+product_id).html('<input type="radio" name="'+product_id+'" value="1" class="add-to-cart radio" id="remove_cart_'+product_id+'_y"><label for="remove_cart_'+product_id+'_y" class="css-label radGroup1"></label>');
                    carttotalcnt();                    
                    updaterecipent();
                    updatedelivery(product_id);
                    $('#loading').empty().html();                
                }
            }
        });
    }
    function updatecart(id, qty) {
        if (qty > 0) {
            $.ajax({
                type: "POST",
                url: "<?= $vpath ?>updatecart.php",
                data: "id=" + id + "&qty=" + qty + "&update=update",
                beforeSend: function() {
                    $('#cartsec').css("background", " rgba(204, 204, 204, 0.16)");
                    $('#loading').html('<div class="visiblediv" ><img src="<?= $vpath ?>images/login_loader.gif"  /></div>');

                },
                success: function(data) {
                    $('#cartsec').css("background", "none");                    
                    $('#cartsec').empty().html(data);
                    carttotalcnt();
                    $('#loading').empty().html();
                }
            });
        }
    }
    function carttotalcnt() {
        $.ajax({
            type: "POST",
            url: "<?= $vpath ?>cntandtotal.php",
            data:"",
            success: function(data) {
                $("#getcntre").empty().html(data);
                var cnt = $("#cntn").val();
                var totn = $("#totals").val();
                $("#crtup").empty().html(cnt);
                $("#totpr").empty().html('$' + totn);
                $(".td1bg3").empty().html('$' + totn);

            }
        });

    }
    
function updaterecipent() {
        $.ajax({
            type: "POST",
            url: "<?= $vpath ?>updaterecipent.php",
            data:"",
            success: function(data) {
                $("#ajax_recipent").empty().html(data);
            }
        });

    }
    
function updatedelivery(product_id) {
        $.ajax({
            type: "POST",
            url: "<?= $vpath ?>updatedelivery.php",
            data:"product_id="+product_id,
            success: function(data) {
                $("#ajax_delivery").empty().html(data);
            }
        });

    }    
    $(document).ready(function() {


        var AddToCart = function(){

        var product_id=$(this).attr("name");       
        

        $.ajax({
		type: "POST",
		url: "<?=$vpath?>updatespecial.php",
		data: "product_id="+product_id+"&qty=1&type_id=2&addtocartnew=1", 
		beforeSend:  function() {
		$('#loading').html('<div class="visiblediv" ><img src="<?= $vpath ?>images/login_loader.gif"  /></div>');
		},
		success: function(data){
                    $('#remove_cart_'+product_id).empty().html(data);
                    carttotalcnt();
                    updaterecipent();
                    updatedelivery(product_id);
                    $('#loading').empty().html();
                    $('.remove-to-cart,.add-to-cart').unbind('change');
                    $('.remove-to-cart').bind('change',RemoveToCart);
                    $('.add-to-cart').bind('change',AddToCart);
		 	}
		});     
    }
    
    
    var RemoveToCart = function(){

        var product_id=$(this).attr("name");
        var cart_id=$(this).val();   
        

        $.ajax({
		type: "POST",
		url: "<?=$vpath?>removespecial.php",
		data: "product_id="+product_id+"&cart_id="+cart_id, 
		beforeSend:  function() {
		$('#loading').html('<div class="visiblediv" ><img src="<?= $vpath ?>images/login_loader.gif"  /></div>');
		},
		success: function(data){
                    $('#remove_cart_'+product_id).empty().html(data);
                    carttotalcnt();
                    updaterecipent();
                    updatedelivery(product_id);
                    $('#loading').empty().html();
                    $('.remove-to-cart,.add-to-cart').unbind('change');
                    $('.remove-to-cart').bind('change',RemoveToCart);
                    $('.add-to-cart').bind('change',AddToCart);
		 	}
		});     
    }
        $('.add-to-cart').bind('change',AddToCart);
        $('.remove-to-cart').bind('change',AddToCart);
        
        /*
        $('.add-to-cart').change( function () {
          
         // var value=$(this).val();    
        var product_id=$(this).attr("name");    
         //alert(product_id);
         //exit;
	$.ajax({
		type: "POST",
		url: "<?=$vpath?>updatespecial.php",
		data: "product_id="+product_id+"&qty=1&type_id=2&addtocartnew=1", 
		beforeSend:  function() {
		$('#loading').html('<div class="visiblediv" ><img src="<?= $vpath ?>images/login_loader.gif"  /></div>');
		},
		success: function(data){
                    $('#remove_cart_'+product_id).empty().html(data);
                    
                    carttotalcnt();
                    updaterecipent();
                    updatedelivery(product_id);
                    $('#loading').empty().html();

		 	}
		});		
		
    });
    */
    
    
    //Copy Current Delivery Address from previous Delivery Address
	$("[name^='copyDeliveryAddress_']").click(function(){
		var thisChecked = $(this).is(":checked");
                
		if(thisChecked){
			var thisId = $.trim($(this).attr("id"));
			currentIndex = thisId.split("_")[1];
			prevIndexSelected = thisId.split("_")[2];

			var prevFirstNameSelected = $.trim($("#rfirstname_" + prevIndexSelected).val());
			$("#rfirstname_" + currentIndex).val(prevFirstNameSelected);
                        var prevLastNameSelected = $.trim($("#rlastname_" + prevIndexSelected).val());
			$("#rlastname_" + currentIndex).val(prevLastNameSelected);
			var prevAttentionSelected = $.trim($("#rattention_" + prevIndexSelected).val());
			$("#rattention_" + currentIndex).val(prevAttentionSelected);
			var prevAddress1Selected = $.trim($("#raddress1_" + prevIndexSelected).val());
			$("#raddress1_" + currentIndex).val(prevAddress1Selected);
			var prevAddress2Selected = $.trim($("#raddress2_" + prevIndexSelected).val());
			$("#raddress2_" + currentIndex).val(prevAddress2Selected);
			var prevCitySelected = $.trim($("#rcity_" + prevIndexSelected).val());
			$("#rcity_" + currentIndex).val(prevCitySelected);
			var prevStateSelected = $.trim($("#rstate_" + prevIndexSelected).val());
			$("#rstate_" + currentIndex).val(prevStateSelected);
			var prevCountrySelected = $.trim($("#rcountry_" + prevIndexSelected).val());
			$("#rcountry_" + currentIndex).val(prevCountrySelected);
			var prevZipSelected = $.trim($("#rzip_" + prevIndexSelected).val());
			$("#rzip_" + currentIndex).val(prevZipSelected);
			var prevPhoneSelected = $.trim($("#rphone_" + prevIndexSelected).val());
			$("#rphone_" + currentIndex).val(prevPhoneSelected);
                        var prevRenclosureSelected = $.trim($("#renclosure_" + prevIndexSelected).val());
			$("#renclosure_" + currentIndex).val(prevRenclosureSelected);
                        var prevRinstructionsSelected = $.trim($("#rinstructions_" + prevIndexSelected).val());
			$("#rinstructions_" + currentIndex).val(prevRinstructionsSelected);
		}
	});
    
    });
</script>
        <link rel="stylesheet" href="<?= $vpath ?>css/flower.css">
        <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/layout.css"/>
        <link href="<?= $vpath ?>css/styles.css" rel="stylesheet" type="text/css" />
        <link href="<?= $vpath ?>css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?= $vpath ?>css/responsive.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/slicknav.css" />
        <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/skin.css" />
        <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/Arvo.css" />
        <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/Lato.css" />
        <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/OpenSans.css" />
        <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/splay.css"/>
        <link href="<?= $vpath ?>css/custom.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?= $vpath ?>js/jquery.min.js"></script>
        <script  type="text/javascript" src="<?= $vpath ?>js/jquery.slicknav.min.js"></script>
        <script  type="text/javascript" src="<?= $vpath ?>js/jquery.js"></script>
        <script  type="text/javascript" src="<?= $vpath ?>js/menudrop.js"></script>
        <script type="text/javascript" src="<?= $vpath ?>js/iselector.js"></script>
        <script type="text/javascript" src="<?= $vpath ?>js/general.js"></script>
        
        
        
        <link rel="stylesheet" href="<?= $vpath ?>bootstrap/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="<?= $vpath ?>css/no_conflict_bs.css"> 
        <script type="text/javascript" src="<?= $vpath ?>bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= $vpath ?>js/lib/typeahead.js/typeahead.min.js"></script>
        <script type="text/javascript" src="<?= $vpath ?>js/jquery.validate.js"></script>

        <script>
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
                            //flagTwo==true;// added for testing
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
                        
                        function validateCPhone(phoneText) {
	
                            str = phoneText.replace(/[^0-9#]/g, '');
                            var filter = /^[0-9]{10}$/;
                            if (!filter.test(str)) {
                                $('#val-cphone-error').text('Invalid Phone Number.');
                            //alert('Invalid Phone Number.');
                            $("#cphone").focus();
                            $('#cphone').val('');
                            
                            }
                            else{
                                $('#val-cphone-error').text('');
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
   
<span id="getcntre" style="display:none;"></span>
<div class="innerWrap">         
    <div class="row-fluid">
        <div class="Content" id="section">
            
            
              <div class="container page-container">
                 <div class="row">
                      <div class="col-sm-12">
                        <h2 class="page-heading">FlowerWyz Secure Checkout
                        <ol class="breadcrumb">
                              <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                              <li><a href="#">Previous Page</a></li>
                              <li class="active">Your Shopping Cart</li>
                              <hr class="hr_brdcum">
                          </ol>
                        
                        </h2>
                          
                      </div>
                  </div>
                        <div class="row main_back">
                            <div id="loading" align=center></div>
<!--                            <div class="col-sm-12 crumb">
                                                          <h2 class="page-heading">FlowerWyz Secure Checkout</h2>
                                <ol class="breadcrumb">
                                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                                    <li><a href="#">Previous Page</a></li>
                                    <li class="active">Your Shopping Cart</li>
                                    <hr class="hr_brdcum">
                                </ol>
                            </div>-->
                            <?php
                            $row = mysql_query("select " . $prev . "cart.*,products.name,products.price,products.flowerwyz_image,products.product_no from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and products.type_id='1' and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N' limit 0,1");
                            $singlePro = @mysql_fetch_array($row)
                            ?>
                            <div class="col-sm-12">
                                
                               <!--  <div class="col-sm-9 product_img_title">
                                    <h4><?=$singlePro['name'];?></h4>
                                </div>
                                <div class="col-sm-3 product_price">

                                       <img src="<?= $vpath; ?>/images/comodo.png">
                                </div>
                               
                                <div class="prod_image col-sm-3">
                                    <img src="<?= $singlePro['flowerwyz_image'];?>" name="<?= $singlePro['name'];?>" />                                    
                                    <div class="prod_image col-sm-12">
                                        <h4>Item No. <?= $singlePro['product_no'];?></h4>
                                        <h4><?= $setting['currency'] ?> <?=$singlePro['price'];?></h4>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <div class="accordian_header">
                                        <h3> Secure Checkout</h3>
                                    </div>
                                </div>    -->
                            <div class="col-sm-9">
                                <div class="panel panel-default checkout-panel">
                                    <div class="panel-body">                                       
                                        <form class="cmxform" id="cmxform" method="post" action="<?= $vpath; ?>checkout.php">
                                          <input type="hidden" name='itemCode' id="itemCode" value="<?php echo $_GET['code']; ?>">
                                          <input type="hidden" name='action_type' id="ActionType" value="0">
                                          <input type="hidden" name='save' value="Continue" >
                                          <input type="hidden" name='hidden_site_baseurl' id="hidden_site_baseurl" value="<?php echo $vpath; ?>">
                                                            <div class="panel panel-default accord-container" style="border-radius:0px;">
                                                                <div class="panel-heading selected" id="accorHeadOne"><span class="label label-dark">1</span>Choose Your Flower</div>
                                                                <div class="panel-body" id="accorBodyOne">
                                                                    <fieldset data-step="0">
                                                                         
                                                                        <div class="row">
                                                                            <div class="col-sm-12" id="review-cart">
                                                                                
                <div id="cartsec">
                                                                                <table class="table cart-contents">
                                                                                    <tbody>
                                                                                        <tr class="background">
                                                                                            <th>Item</th>
                                                                                           <th style="width: 28%;text-align: center;">Delivery Date</th>
                                                                                            <th class="text-center">Quantity</th>
                                                                                            <th class="text-right">Unit Price</th>
                                                                                             <th class="text-right">&nbsp;</th>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $amt = 0;
                                                                                        $j = 0;
                                                                                        $weight = 0;
                                                                                        while ($product = @mysql_fetch_array($r)):
                                                                                            if ($product['flowerwyz_image']) {
                                                                                                //$imgsizen = GetThumbnailSize("{$product[image]}", 38, 75);
                                                                                                $pic = $product['flowerwyz_image'];
                                                                                            } else {
                                                                                                $pic = $vpath."images/cart1.jpg";
                                                                                            }
                                                                                            $product_name[] = $product['name'];
                                                                                            $type_id[] = $product['type_id'];
                                                                                            $product_no[] = $product['product_no'];
                                                                                        ?>
                                                                                       <tr id="cart_<?=$product[id]?>">
                                                                                            <td><span style="text-transform:uppercase"><b><?php echo $product['name']; ?></b></span><br />Delivered to All Zip Codes, USA & Canada.</td>
                                                                                            <td class="text-left">
                                                                                                <select class="del_date" id="deliverydate" required="required">
                                                                                                <option value="">Delivery Date *</option>
                                                                                                
                                                                                            </select>
                                                                                                <!--<img src="<?= $pic?>" name="<?= $product['name'];?>" height="50" width="60" />-->
                                                                                            </td>
                                                                                            <td class="text-center"><?php echo $product['qty']; ?></td>
                                                                                            <td class="text-right"><?= $setting['currency'] ?> <?php echo $product['total']; ?>&nbsp;&nbsp;</td>
                                                                                            <td class="text-right"><img src="<?=$vpath?>images/cut.png" alt="" style="border:0; padding:0; float:none; margin:0; cursor:pointer"  onclick="removepr('<?=$product[id]?>,<?=$product[product_id]?>')"/></td>
                                                                                        </tr>
                                                                                        <?php 
                                                                                        $amt+=$product[qty] * $product[price];
                                                                                        endwhile;?>
                                                                                        <tr>
                                                                                            <td>&nbsp;</td>
                                                                                            <td colspan="4" class="text-right"><span style="font-size:18px; font-weight:bold;">Current Total <span class="td1bg3" id="td1bg3p"><?=$setting[currency]." " . sprintf("%01.2f",$amt)?></span></span></td>
                                                                                        </tr>
                                                                                       

                                                                                    </tbody>
                                                                                </table>
                                                                          
                                                                        </div>                </div>
                                                                </div>
                                                                    </fieldset>
                                                                    <button type="button" class="green-btn pull-right" id="goAccorTwo">Continue to Next Step</button>
                                                                </div>
                                                            </div>

                                                            <div class="panel panel-default accord-container" style="border-radius:0px; margin-top:-1px;">
                                                                <div class="panel-heading" id="accorHeadTwo"><span class="label label-dark">2</span>Make It Special</div>
                                                                <div class="panel-body" id="accorBodyTwo">
                                                                     <fieldset data-step="1">

                                                                        <div class="row">
                                                                            
                                                                            <div class="prod_image col-sm-12">
                                                                                <div class="prod_image col-sm-4 prods">
                                                                                    <div class="image_title">Fields of Lavender  - Good</div>
                                                                                    <div class="prod_img2">
                                                                                        <img class="imag" src="http://www.floristone.com/flowers/products/WGG384_d1.jpg">
                                                                                        <a href="<?= $vpath; ?>item.php?code=B9-4833" class="splFancyIframe">
                                                                                        <span class="details">
                                                                                            <h4>Fields of Lavender  - Good</h4>
                                                                                            </br><h2>$49.99</h2></br>
                                                                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                                                                        </span></a>
                                                                                    </div>
                                                                                    <div class="price_section">
                                                                                        <div class="price">$49.99</div>
                                                                                        <div class="cal">
                                                                                             
                                                                                           <span id="remove_cart_490">
                                                                                               <p>Add</p>
                                                                                            <input type="radio" name="490" value="1" class="add-to-cart radio" id="remove_cart_490_y"><label for="remove_cart_490_y" class="css-label radGroup1"></label>
                                                                                            <!--<input type="radio" name="490" value="0" class="remove-to-cart" id="490"><label for="490" class="css-label2 radGroup1"></label>--></span>
                                                                                            <!--<button class="button_add addition add-to-cart" name="490">+</button>-->
                                                                                            
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="prod_image col-sm-4 prods">
                                                                                    <div class="image_title">Fields of Lavender</div>
                                                                                    <div class="prod_img2">
                                                                                        <img class="imag" src="http://www.floristone.com/flowers/products/WGG385_d1.jpg">
                                                                                        <a href="<?= $vpath; ?>item.php?code=B9-4833" class="splFancyIframe">
                                                                                        <span class="details">
                                                                                            <h4>Fields of Lavender</h4>
                                                                                            </br><h2>$59.99</h2></br>
                                                                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                                                                        </span></a>
                                                                                    </div>
                                                                                    <div class="price_section">
                                                                                        <div class="price">$59.99</div>
                                                                                        <div class="cal">
                                                                                            <span id="remove_cart_491">
                                                                                             <p>Add</p>
                                                                                         
                                                                                            <input type="radio" name="491" value="1" class="add-to-cart radio" id="remove_cart_491_y"><label for="remove_cart_491_y" class="css-label radGroup1"></label>
                                                                                            </span>
                                                                                            
                                                                                          
                                                                                        </div>

                                                                                    </div>
                                                                                </div>

                                                                                <div class="prod_image col-sm-4 prods">
                                                                                    <div class="image_title">Birthday Spa Delights</div>
                                                                                    <div class="prod_img2">
                                                                                        <img class="imag" src="http://www.floristone.com/flowers/products/WGH170_d1.jpg">
                                                                                        <a href="<?= $vpath; ?>item.php?code=B9-4833" class="splFancyIframe">
                                                                                        <span class="details">
                                                                                            <h4>Birthday Spa Delights</h4>
                                                                                            </br><h2>$29.99</h2></br>
                                                                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                                                                                        </span></a>
                                                                                    </div>
                                                                                    <div class="price_section">
                                                                                        <div class="price">$29.99</div>
                                                                                        <div class="cal">
                                                                                            <span id="remove_cart_492">
                                                                                            <p>Add</p>
                                                                                            
                                                                                            <input type="radio" name="492" value="1" class="add-to-cart radio" id="remove_cart_492_y"><label for="remove_cart_492_y" class="css-label radGroup1"></label>
                                                                                            </span>
                                                                                        
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        
                                                                        </div>

                                                                    </fieldset>
                                                                   
                                                                    <button type="button" style="margin-top: 238px !important;" class="green-btn pull-right" id="goAccorThree">Continue To Next Step</button>
                                                                </div>
                                                            </div>

                                                            <div class="panel panel-default accord-container" style="border-radius:0px; margin-top:-1px;">
                                                                <div class="panel-heading" id="accorHeadThree" ><span class="label label-dark">3</span>Recipient Information</div>
                                                                <div class="panel-body" id="accorBodyThree">
                                                                    <fieldset data-step="2">
              <div id="ajax_recipent">
                                                                        <?php 
                                                                       
                                                                        
                                                                            for($i=1;$i<= $totRow;$i++){
                                                                                if($i>1){
                                                                            ?>
                                                          <input name="copyDeliveryAddress_<?=$i?>_<?=$i-1?>" id="copyDeliveryAddress_<?=$i?>_<?=$i-1?>" class="copyDeliveryAddress" type="checkbox"> Use same Recipient information as first item 
                                                            <div class="hideDelivery">   
                                                              <?php }?>                                                                      

                                                                      <div class="row">
                                                                          <div class="col-sm-6">
                                                                              <div class="form_sep">

                                                                                  <input id="rfirstname_<?=$i?>" name="rfirstname_<?=$i?>" placeholder="First Name*" type="text" class="form-control" required="required">
                                                                              </div>
                                                                          </div>
                                                                          <div class="col-sm-6">
                                                                              <div class="form_sep">

                                                                                  <input id="rlastname_<?=$i?>" name="rlastname_<?=$i?>" placeholder="Last Name*" type="text" class="form-control" required="required">
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                      <div class="row">
                                                                          <div class="col-sm-6">
                                                                              <div class="form_sep">

                                                                                  <input id="rattention_<?=$i?>" name="rattention_<?=$i?>" placeholder="Institution" type="text" class="form-control">
                                                                              </div>
                                                                          </div>
                                                                          <div class="col-sm-6">
                                                                              <div class="form_sep">

                                                                                  <input id="rphone_<?=$i?>" name="rphone_<?=$i?>" type="text" placeholder="Phone*" class="form-control" onKeyUp="formatPhone(this);" onBlur="validatePhone(this.value)" maxlength="14" required="required" autocomplete="off">
                                                                                  <p for="rphone" class="warning" id="val-rphone-error"></p>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                      <div class="row">
                                                                          <div class="col-sm-6">
                                                                              <div class="form_sep">

                                                                                  <input id="raddress1_<?=$i?>" name="raddress1_<?=$i?>" type="text" placeholder="Address*" class="form-control" required="required">
                                                                              </div>
                                                                          </div>
                                                                          <div class="col-sm-6">
                                                                              <div class="form_sep">

                                                                                  <input id="raddress2_<?=$i?>" name="raddress2_<?=$i?>" type="text" placeholder="Address 2" class="form-control">
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                      <div class="row">
                                                                          <div class="col-sm-6">
                                                                              <div class="form_sep cust-select">

                                                                                  <select id="rcountry_<?=$i?>" onChange="this.className=this.options[this.selectedIndex].className" class="greenText" required="required" name="rcountry_<?=$i?>">
                                                                                      <option value="" class="first_option">--Select Country*--</option>
                                                                                      <option value="US">United States</option>
                                                                                      <option value="CA">Canada</option>
                                                                                  </select>
                                                                              </div>
                                                                          </div>
                                                                          <div class="col-sm-6">
                                                                              <div class="form_sep cust-select">

                                                                                  <select onChange="this.className=this.options[this.selectedIndex].className"
                                                          class="greenText" id="rstate_<?=$i?>"  name="rstate_<?=$i?>" required="required"  class="greenText" required="required">
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

                                                                                  <input id="rcity_<?=$i?>" name="rcity_<?=$i?>" type="text" placeholder="City*" class="form-control" required="required">
                                                                              </div>
                                                                          </div>
                                                                          <div class="col-sm-6">
                                                                              <div class="form_sep">

                                                                                  <input id="rzip_<?=$i?>" name="rzip_<?=$i?>" type="text" placeholder="Zip Code*" class="form-control" required="required">
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                      <div class="row">
                                                                          <div class="col-sm-12">
                                                                              <div class="form_sep">
                                                                                  <label class="req">Message On Card</label>
                                                                                  <textarea id="renclosure_<?=$i?>" class="form-control" rows="3" required="required" name="renclosure_<?=$i?>" maxlength="200" placeholder="Please enter your personalized message here. Don't forget to add your name."></textarea>
                                                                              </div>
                                                                              <div class="form_sep">
                                                                                  <label>Special Delivery Instructions</label>
                                                                                  <textarea id="rinstructions_<?=$i?>" class="form-control" rows="3" name="rinstructions_<?=$i?>" placeholder="If you have specific instructions for our delivery team, you may add them here." maxlength="200"></textarea>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                    <?php  if($i>1) echo '</div>';?>       
                                                                            <?php 
                                                                             }
                                                                        ?>
                                                                         
                                                                       </div> 
                                                                    </fieldset>
                                                                <!--    <button type="button" style="margin-top:10px;" class="green-btn pull-right" id="goAccorFour">Continue To Next Step</button>-->
                                                                </div>
                                                            </div>
                                                            <div class="bottom_amount_right">
                                                                <div class="amt">
                                                                  <h3><span class="td1bg3" id="td1bg3p"><?=$setting[currency]." " . sprintf("%01.2f",$amt)?></span></h3>
                                                                </div>
                                                                     <input type="submit" id="finalPay" class="green-btn pull-right" style="margin-top:10px;" value="Continune To Billing" />
                                                                  
                                                                    
                                                            </div>
                                                                 </form>
                                                            <div class="secure_logo">
                                                                   <img src="<?= $vpath; ?>/images/comodo_seal_recolored.png">
                                                            </div>
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
                                <!-- <div class="prod_image1 col-sm-12">
                                                                            <ul class="nav nav-tabs">
                                                                                <li class="active"><a data-toggle="tab" href="#home">You May Also Like</a></li>
                                                                            </ul>
                                       <div class="panel panel-default">
                                          
                                           <div class="panel-body"><ul>
                                                   <li><a><img src="https://www.flowerwyz.com/images/send-flowers.jpg" alt="" height="211px" width="183px"></a><p>Image 1</p></li>
                                                   <li><a><img src="https://www.flowerwyz.com/images/online-flower-delivery.jpg" alt="" height="211px" width="183px"></a><p>Image 2</p></li>
                                                   <li><a><img src="https://www.flowerwyz.com/images/send-flowers.jpg" alt="" height="211px" width="183px"></a><p>Image 3</p></li>
                                                   <li><a><img src="https://www.flowerwyz.com/images/online-flower-delivery.jpg" alt="" height="211px" width="183px"></a><p>Image 4</p></li>
                                                   <li><a><img src="https://www.flowerwyz.com/images/send-flowers.jpg" alt="" height="211px" width="183px"></a><p>Image 5</p></li>
                                               </ul></div>
                                       </div>
<!--                                                                            <div id="home" class="tab-pane fade in active">
                                                                                <h3>You May Also Like</h3>
                                                                                <ul>
                                                                                    <li><a><img src="https://www.flowerwyz.com/images/send-flowers.jpg" alt="" height="211px" width="183px"></a></li>
                                                                                    <li><a><img src="https://www.flowerwyz.com/images/online-flower-delivery.jpg" alt="" height="211px" width="183px"></a></li>
                                                                                    <li><a><img src="https://www.flowerwyz.com/images/send-flowers.jpg" alt="" height="211px" width="183px"></a></li>
                                                                                    <li><a><img src="https://www.flowerwyz.com/images/online-flower-delivery.jpg" alt="" height="211px" width="183px"></a></li>
                                                                                    <li><a><img src="https://www.flowerwyz.com/images/send-flowers.jpg" alt="" height="211px" width="183px"></a></li>
                                                                                </ul>
                                                                            </div>

                                                                            </div> -->
                            </div>
                                                            <div class="clear"></div>


                                                            </div>
                                                            </div>

                    </div>
    </div>
</div>
<?php //include("include/footer.php"); ?>
                    <script type="text/javascript">
                    $(document).ready(function(){
                      
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

                        
                        
                    $('.addition').each(function(i){
                            var a=i+1;
                            $(this).click(function(event){
                                event.preventDefault();
                        
                            var qty= $('#qty'+a).val();
                            if(qty>=0){
                                $('#qty'+a).val(parseInt(qty)+1);
                            }
                        });
                        });
                          
                        $('.substruct').each(function(i){
                            var a=i+1;
                            $(this).click(function(event){
                                event.preventDefault();
                        
                            var qty= $('#qty'+a).val();
                            if(qty>=1){
                                $('#qty'+a).val(parseInt(qty)-1);
                            }
                        });
                        });


$('.prod_img2').each(function(){
                    $(this).mouseover(function(){
                    $(this).find("span").show();
                    });
                    $(this).mouseout(function(){
                    $(this).find("span").hide();
                    });
                });
                });
                    </script>