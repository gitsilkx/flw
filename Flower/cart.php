  <!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <!--<html lang="en">-->
<?php
include("configs/path.php");
include("getProducts.php");
?>
    <head>
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
                $('#amount').val(totn);
                $('#count').val(cnt);
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
        var occasion_id=$(this).val();

        $.ajax({
		type: "POST",
		url: "<?=$vpath?>updatespecial.php",
		data: "product_id="+product_id+"&qty=1&occasion_id="+occasion_id+"&addtocartnew=1", 
		beforeSend:  function() {
		$('#loading').html('<div class="visiblediv" ><img src="<?= $vpath ?>images/login_loader.gif"  /></div>');
		},
		success: function(data){
                    $('#remove_cart_'+product_id).empty().html(data);
                    carttotalcnt();
                    updaterecipent();
                    updatedelivery(product_id);
                    $('#loading').empty().html();
                    $('.remove-to-cart,.add-to-cart,.del_date').unbind('change');
                    $("[name^='copyDeliveryAddress_']").unbind('click');
                    $("[name^='copyDeliveryAddress_']").bind('click',copyDeliveryAddress);
                    $('.remove-to-cart').bind('change',RemoveToCart);
                    $('.add-to-cart').bind('change',AddToCart);
                    $('.del_date').bind('change',DeliveryDate);
                    
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
                    $('.remove-to-cart,.add-to-cart,.del_date').unbind('change');
                    $("[name^='copyDeliveryAddress_']").unbind('click');
                    $("[name^='copyDeliveryAddress_']").bind('click',copyDeliveryAddress);
                    $('.remove-to-cart').bind('change',RemoveToCart);
                    $('.add-to-cart').bind('change',AddToCart);
                    $('.del_date').bind('change',DeliveryDate);
		 	}
		});     
    }
        
        
    
      var DeliveryDate = function () {
          
        var deliverydate=$(this).val();       
        var cart_id=$(this).attr("name");  
 
	$.ajax({
		type: "POST",
		url: "<?=$vpath?>updatedeliverydate.php",
		data: "deliverydate="+deliverydate+"&cart_id="+cart_id, 
		beforeSend:  function() {
		$('#loading').html('<div class="visiblediv" ><img src="<?= $vpath ?>images/login_loader.gif"  /></div>');
		},
		success: function(data){
                    $('#loading').empty().html();
                     $('.remove-to-cart,.add-to-cart,.del_date,#rfirstname_1,#rlastname_1,#rattention_1,#rphone_1,#raddress1_1,#raddress2_1,#rcountry_1,#rstate_1,#rcity_1,#rzip_1,#renclosure_1,#rinstructions_1').unbind('change');
                     $("[name^='copyDeliveryAddress_']").unbind('click');
                     $("[name^='copyDeliveryAddress_']").bind('click',copyDeliveryAddress);
                     $('.remove-to-cart').bind('change',RemoveToCart);
                     $('.add-to-cart').bind('change',AddToCart);
                     $('.del_date').bind('change',DeliveryDate);
                     $('#rfirstname_1').bind('blur',copyRecFirstName);
                     $('#rlastname_1').bind('blur',copyRecLastName);
                    $('#rattention_1').bind('blur',copyRecItention);
                    $('#rphone_1').bind('blur',copyRecPhone);
                    $('#raddress1_1').bind('blur',copyRecAddress1);
                    $('#raddress2_1').bind('blur',copyRecAddress2);
                    $('#rcountry_1').bind('blur',copyRecCountry);
                    $('#rstate_1').bind('blur',copyRecState);
                    $('#rcity_1').bind('blur',copyRecCity);
                    $('#rzip_1').bind('blur',copyRecZip);
                    $('#renclosure_1').bind('blur',copyRecEnclosure);
                    $('#rinstructions_1').bind('blur',copyRecInstructions);
		 	}
		});		
 }
 
     //Copy Current Delivery Address from previous Delivery Address
    var copyDeliveryAddress = function () {
    
		var thisChecked = $(this).is(":checked");
		if(thisChecked){
			var thisId = $.trim($(this).attr("id"));
			currentIndex = thisId.split("_")[1];
                        //alert(currentIndex);
			prevIndexSelected = thisId.split("_")[2];
                        $('.hideDelivery_'+currentIndex).css("display", "block");
			var prevFirstNameSelected = $.trim($("#rfirstname_" + prevIndexSelected).val());
			$("#rfirstname_" + currentIndex).val('');
                        var prevLastNameSelected = $.trim($("#rlastname_" + prevIndexSelected).val());
			$("#rlastname_" + currentIndex).val('');
			var prevAttentionSelected = $.trim($("#rattention_" + prevIndexSelected).val());
			$("#rattention_" + currentIndex).val('');
			var prevAddress1Selected = $.trim($("#raddress1_" + prevIndexSelected).val());
			$("#raddress1_" + currentIndex).val('');
			var prevAddress2Selected = $.trim($("#raddress2_" + prevIndexSelected).val());
			$("#raddress2_" + currentIndex).val('');
			var prevCitySelected = $.trim($("#rcity_" + prevIndexSelected).val());
			$("#rcity_" + currentIndex).val('');
			var prevStateSelected = $.trim($("#rstate_" + prevIndexSelected).val());
			$("#rstate_" + currentIndex).val('');
			var prevCountrySelected = $.trim($("#rcountry_" + prevIndexSelected).val());
			$("#rcountry_" + currentIndex).val('');
			var prevZipSelected = $.trim($("#rzip_" + prevIndexSelected).val());
			$("#rzip_" + currentIndex).val('');
			var prevPhoneSelected = $.trim($("#rphone_" + prevIndexSelected).val());
			$("#rphone_" + currentIndex).val('');
                        var prevRenclosureSelected = $.trim($("#renclosure_" + prevIndexSelected).val());
			$("#renclosure_" + currentIndex).val('');
                        var prevRinstructionsSelected = $.trim($("#rinstructions_" + prevIndexSelected).val());
			$("#rinstructions_" + currentIndex).val('');
		}
                else{
                    var thisId = $.trim($(this).attr("id"));
			currentIndex = thisId.split("_")[1];                       
			prevIndexSelected = thisId.split("_")[2];
                        $('.hideDelivery_'+currentIndex).css("display", "none");
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
                    $('.remove-to-cart,.add-to-cart,.del_date').unbind('change');
                    $("[name^='copyDeliveryAddress_']").unbind('click');
                    $("[name^='copyDeliveryAddress_']").bind('click',copyDeliveryAddress);
                    $('.remove-to-cart').bind('change',RemoveToCart);
                    $('.add-to-cart').bind('change',AddToCart);
                    $('.del_date').bind('change',DeliveryDate);
                    
    }
     
    var copyRecFirstName = function () {    
        var count = $('.count').val();  
        var value = $(this).val();
        var i = 2;
        while (i <= count) {
            $('#rfirstname_'+i).val(value);
            i++;
        }   
         $("#rfirstname_1").unbind('blur');
        $('#rfirstname_1').bind('blur',copyRecFirstName);
    }
    
    var copyRecLastName = function () {    
        var count = $('.count').val();  
        var value = $(this).val();
        var i = 2;
        while (i <= count) {
            $('#rlastname_'+i).val(value);
            i++;
        }   
         $("#rlastname_1").unbind('blur');
        $('#rlastname_1').bind('blur',copyRecLastName);
    }
    
    var copyRecItention= function () {    
        var count = $('.count').val();  
        var value = $(this).val();
        var i = 2;
        while (i <= count) {
            $('#rattention_'+i).val(value);
            i++;
        }   
         $("#rattention_1").unbind('blur');
        $('#rattention_1').bind('blur',copyRecItention);
    }
    
    var copyRecPhone = function () {    
        var count = $('.count').val();  
        var value = $(this).val();
        var i = 2;
        while (i <= count) {
            $('#rphone_'+i).val(value);
            i++;
        }   
         $("#rphone_1").unbind('blur');
        $('#rphone_1').bind('blur',copyRecPhone);
    }
    
    var copyRecAddress1 = function () {    
        var count = $('.count').val();  
        var value = $(this).val();
        var i = 2;
        while (i <= count) {
            $('#raddress1_'+i).val(value);
            i++;
        }   
         $("#raddress1_1").unbind('blur');
        $('#raddress1_1').bind('blur',copyRecAddress1);
    }
    
    var copyRecAddress2 = function () {    
        var count = $('.count').val();  
        var value = $(this).val();
        var i = 2;
        while (i <= count) {
            $('#raddress2_'+i).val(value);
            i++;
        }   
         $("#raddress2_1").unbind('blur');
        $('#raddress2_1').bind('blur',copyRecAddress2);
    }
    
    var copyRecCountry = function () {    
        var count = $('.count').val();  
        var value = $(this).val();
        var i = 2;
        while (i <= count) {
            $('#rcountry_'+i).val(value);
            i++;
        }   
         $("#rcountry_1").unbind('blur');
        $('#rcountry_1').bind('blur',copyRecCountry);
    }
    
    var copyRecState = function () {    
        var count = $('.count').val();  
        var value = $(this).val();
        var i = 2;
        while (i <= count) {
            $('#rstate_'+i).val(value);
            i++;
        }   
         $("#rstate_1").unbind('blur');
        $('#rstate_1').bind('blur',copyRecState);
    }
    
    var copyRecCity = function () {    
        var count = $('.count').val();  
        var value = $(this).val();
        var i = 2;
        while (i <= count) {
            $('#rcity_'+i).val(value);
            i++;
        }   
         $("#rcity_1").unbind('blur');
        $('#rcity_1').bind('blur',copyRecCity);
    }
    var copyRecZip = function () {    
        var count = $('.count').val();  
        var value = $(this).val();
        var i = 2;
        while (i <= count) {
            $('#rzip_'+i).val(value);
            i++;
        }   
         $("#rzip_1").unbind('blur');
        $('#rzip_1').bind('blur',copyRecZip);
    }
    var copyRecEnclosure = function () {    
        var count = $('.count').val();  
        var value = $(this).val();
        var i = 2;
        while (i <= count) {
            $('#renclosure_'+i).val(value);
            i++;
        }   
         $("#renclosure_1").unbind('blur');
        $('#renclosure_1').bind('blur',copyRecEnclosure);
    }
    var copyRecInstructions = function () {    
        var count = $('.count').val();  
        var value = $(this).val();
        var i = 2;
        while (i <= count) {
            $('#rinstructions_'+i).val(value);
            i++;
        }   
         $("#rinstructions_1").unbind('blur');
        $('#rinstructions_1').bind('blur',copyRecInstructions);
    }

    
    $('.add-to-cart').bind('change',AddToCart);
    $('.remove-to-cart').bind('change',AddToCart);
    $('.del_date').bind('change',DeliveryDate);
    $('#rfirstname_1').bind('blur',copyRecFirstName);
    $('#rlastname_1').bind('blur',copyRecLastName);
    $('#rattention_1').bind('blur',copyRecItention);
    $('#rphone_1').bind('blur',copyRecPhone);
    $('#raddress1_1').bind('blur',copyRecAddress1);
    $('#raddress2_1').bind('blur',copyRecAddress2);
    $('#rcountry_1').bind('blur',copyRecCountry);
    $('#rstate_1').bind('blur',copyRecState);
    $('#rcity_1').bind('blur',copyRecCity);
    $('#rzip_1').bind('blur',copyRecZip);
    $('#renclosure_1').bind('blur',copyRecEnclosure);
    $('#rinstructions_1').bind('blur',copyRecInstructions);
    $("[name^='copyDeliveryAddress_']").bind('click',copyDeliveryAddress);
  
   
   
   
    

        
        
        $("#shipping_chk").click(function() {
                                //var fullName = $('#rname').val();
                                

                                if ($(this).is(":checked")) {
                                    $("#cfirstname").val($('#rfirstname_1').val());
                                    $("#clastname").val($('#rlastname_1').val());
                                    $("#caddress1").val($('#raddress1_1').val());
                                    $("#caddress2").val($('#raddress2_1').val());
                                    $("#ccity").val($('#rcity_1').val());
                                    $("#cstate").val($('#rstate_1').val());
                                    $("#ccountry").val($('#rcountry_1').val());
                                    $("#czip").val($('#rzip_1').val());
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
             
             $('#goAccorFive').click( function () {
                 
                var cfirstname = $("#cfirstname").val();
                 var clastname =   $("#clastname").val();
                var caddress1 =     $("#caddress1").val();
                 var caddress2 =   $("#caddress2").val();
                 var ccity =   $("#ccity").val();
                 var cstate = $("#cstate").val();
                 var ccountry = $("#ccountry").val();
                 var czip = $("#czip").val();
                 var cemail = $("#cemail").val();
                 var phone_code = $("#phone_code").val();
                 var cphone = $("#cphone").val();
                 if(cfirstname == ''){
                  alert('Please type first name.');
                  return false;
                 }
                 if(cfirstname == ''){
                  alert('Please type first name.');
                  return false;
                 }
                 if(clastname == ''){
                  alert('Please type last name.');
                  return false;
                 }
                 if(caddress1 == ''){
                  alert('Please type address.');
                  return false;
                 }
                 if(ccountry == ''){
                  alert('Please select country.');
                  return false;
                 }
                 if(cstate == ''){
                  alert('Please select state.');
                  return false;
                 }
                 if(ccity == ''){
                  alert('Please type city.');
                  return false;
                 }
                 if(czip == ''){
                  alert('Please type zip code.');
                  return false;
                 }
                 if(phone_code == ''){
                  alert('Please select phone code.');
                  return false;
                 }
                  if(cphone == ''){
                  alert('Please type phone no.');
                  return false;
                 }
                  if(cemail == ''){
                  alert('Please type email id.');
                  return false;
                 }
	$.ajax({
		type: "POST",
		url: "<?=$vpath?>ajax/billing_email.php",
		data: "cfirstname="+cfirstname+"&clastname="+clastname+"&caddress1="+caddress1+"&caddress2="+caddress2+"&ccity="+ccity+"&cstate="+cstate+"&ccountry="+ccountry+"&czip="+czip+"&cemail="+cemail+"&phone_code="+phone_code+"&cphone="+cphone, 
		beforeSend:  function() {
                    $('#loading').html('<div class="visiblediv" ><img src="<?= $vpath ?>images/login_loader.gif"  /></div>');
		},
		success: function(data){
                    $('#loading').empty().html();
                    //window.location.assign("<?=$vpath?>cart.htm")
		//alert(data);
                //$('#ajax_cart').html('<a class="btn-pink" href="cart.php">VIEW CART</a>')
		//$("#crtup").empty().html(data);
		//cartlist();
                
                
		 	}
		});		
		
    });
    
    });
</script>

        
        
        
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
                            var flagFive = false;
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
                            $("#accorBodyFive").hide();

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
                            $("#goAccorFive").click(function() {
                                if (v.form()) {
                                    
                                    $("#accorBodyFive").show(400);
                                    $("#accorBodyFour").hide(400);
                                    $("#accorHeadFour").removeClass("selected");
                                    $('#accorHeadFour').find('span').remove();
                                    $("#accorHeadFour").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                    $("#accorHeadFive").addClass("selected");
                                    
                                    
                                    
                                    //flagThree = true;
                                    flagFour = true;
                                }
                            });
                            
                            $("#finalPay").click(function() {
                                if (v.form()) {

                                    flagFive = true;


                                }

                            });

                            $("#accorHeadOne").click(function() {
                                if (flagOne == true) {

                                    $("#accorBodyOne").show(400);
                                    $("#accorBodyTwo").hide(400);
                                    $("#accorBodyThree").hide(400);
                                    $("#accorBodyFour").hide(400);
                                    $("#accorBodyFive").hide(400);
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
                                    $('#accorHeadFive').find('span').remove();
                                    $("#accorHeadFive").removeClass("selected");
                                    $("#accorHeadFive").prepend('<span class="label label-dark">5</span>');
                                    flagTwo = false;
                                    flagThree = false;
                                    flagFour = false;
                                    flagFive = false;
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
                                        $("#accorBodyFive").hide(400);
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
                                        $('#accorHeadFive').find('span').remove();
                                    $("#accorHeadFive").removeClass("selected");
                                    $("#accorHeadFive").prepend('<span class="label label-dark">5</span>');
                                        flagThree = false;
                                        flagFour = false;
                                        flagFive = false;
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
                                        $("#accorBodyFive").hide(400);
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
                                        flagFive = false;
                                    }

                                }
                            })
                            $("#accorHeadFour").click(function() {
                                if (flagThree == true) {

                                    if (v.form()) {
                                        $("#accorHeadFour").show(400);
                                        $("#accorBodyOne").hide(400);
                                        $("#accorBodyTwo").hide(400);
                                        $("#accorBodyFour").hide(400);
                                        $("#accorBodyFive").hide(400);
                                        $("#goAccorFive").click(function() {
                                            $("#accorBodyFive").show(400);
                                            $("#accorBodyFour").hide(400);
                                            $("#accorBodyFour").removeClass("selected");
                                            $('#accorBodyFour').find('span').remove();
                                            $("#accorBodyFour").prepend('<span class="label-green glyphicon glyphicon-ok"></span>');
                                            $("#accorHeadFive").addClass("selected");
                                            flagFour = true;
                                            //flagFour = true;
                                        });
                                        $('#accorHeadFour').find('span').remove();
                                        $("#accorHeadFour").addClass("selected");
                                        $("#accorHeadFour").prepend('<span class="label label-dark">4</span>');
                                        $('#accorHeadFive').find('span').remove();
                                        $("#accorHeadFive").removeClass("selected");
                                        $("#accorHeadFive").prepend('<span class="label label-dark">5</span>');
                                        //flagFour = false;
                                        flagFive = false;
                                    }

                                }
                            })
                            $("#accorHeadFive").click(function() {
                                if (flagFour == true) {

                                    if (v.form()) {
                                        $("#accorBodyFive").show(400);
                                        $("#accorBodyFour").hide(400);
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
        
        <style type="text/css">
/*---------- bubble tooltip -----------*/
    a.tt{
        position:relative;
        z-index:24;
        color:#106a6d;
        font-weight:bold;
        text-decoration:none;
    }
    a.tt span{ display: none; }

    /*background:; ie hack, something must be changed in a for ie to execute it*/
    a.tt:hover{ z-index:125; color: #454545;}
    a.tt:hover span.tooltip{
        display:block;
        position:absolute;
        top:0px; left:0;
        padding: 15px 0 0 0;
        width:490px;
        color: #111111;
        text-align: center;
        filter: alpha(opacity:1);
        KHTMLOpacity: 1;
        MozOpacity: 1;
        opacity: 1;
    }
   /* a.tt:hover span.top{
        display: block;
        padding: 30px 8px 0;
        background: url(http://www.scriptgiant.com/images/bubble2.gif) no-repeat top;
        font-family:Verdana, Arial, Helvetica, sans-serif;
        text-decoration:none;
        font-style:normal;
        font-size:12px;
        color:#111111;
        font-weight:normal;
        line-height:18px;
    }
    a.tt:hover span.middle{ 
        display: block;
        padding: 0 8px;
        background: url(http://www.scriptgiant.com/images/bubble_filler.gif) repeat bottom;
        font-family:Verdana, Arial, Helvetica, sans-serif;
        text-decoration:none;
        font-style:normal;
        font-size:12px;
        color:#111111;
        font-weight:normal;
        line-height:18px;
    }*/
	
	a.tt:hover span.top {
    background: url("images/theme_anchor.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
    display: block;
    height: 25px;
    margin: -73px 0 0 122px;
    position: absolute;
    width: 26px;
}
a.tt:hover span.middle {
    background: none repeat scroll 0 0 #e1e7d2;
    border: 2px solid #a7b5b1;
    border-radius: 10px;
    color: #111111;
    display: block;
    float: left;
    font-family: Verdana,Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-style: normal;
    font-weight: normal;
    line-height: 18px;
    margin: -50px 0 0 -55px;
    padding: 8px;
    text-decoration: none;
}

    a.tt:hover span.bottom{
        display: block;
        padding:3px 8px 10px;
        color: #548912;
        /*background: url(http://www.scriptgiant.com/images/bubble2.gif) no-repeat bottom;*/
        font-family:Verdana, Arial, Helvetica, sans-serif;
        text-decoration:none;
        font-style:normal;
        font-size:12px;
        color:#106a6d;
        font-weight:normal;
        line-height:18px;
    }
    /*---------- bubble tooltip -----------*/
    
    .product_book {
        background-image: url(images/no_img_available_sky.jpg);
        width: 999px;
        height:372px;
    }
</style>
</head>
    <body>
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
                            //$row = mysql_query("select " . $prev . "cart.*,products.name,products.price,products.flowerwyz_image,products.product_no from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and products.type_id='1' and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N' limit 0,1");
                            //$singlePro = @mysql_fetch_array($row)
                            ?>
                            <div class="col-sm-12">
                                
                              
                            <div class="col-sm-9">
                                <div class="panel panel-default checkout-panel">
                                    <div class="panel-body">                                       
                                        <form class="cmxform" id="cmxform" method="post" action="<?= $vpath; ?>notify.php">
                                          <input type="hidden" name='itemCode' id="itemCode" value="<?php echo $_GET['code']; ?>">
                                          <input type="hidden" name='action_type' id="ActionType" value="0">
                                           <input type="hidden" name="count" id="count" class="count" value="<?php echo $totRow;?>">  
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
                                                                                        $r = mysql_query("select " . $prev . "cart.*,products.name,products.price,products.product_no,products.id as product_id,products.flowerwyz_image," . $prev . "cart.type_id from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'");
                                                                                        //echo "select " . $prev . "cart.*,products.name,products.price,products.product_no,products.id as product_id,products.flowerwyz_image," . $prev . "cart.type_id from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'";
                                                                                        $totRow = mysql_num_rows($r);
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
                                                                                            $occasion_id = $product['occasion_id'];
                                                                                            $strZipCode = '10011';
                                                                                            $ins->getDeliveryDates(API_USER, API_PASSWORD, $strZipCode);
                                                                                        ?>
                                                                                       <tr id="cart_<?=$product[id]?>">
                                                                                            <td><span style="text-transform:uppercase"><b><?php echo $product['name']; ?></b></span><br />Delivered to All Zip Codes, USA & Canada.</td>
                                                                                            <td class="text-left">
                                                                                                <select class="del_date" id="deliverydate" name="<?=$product[id]?>" required="required">
                                                                                                <option value="" selected="selected">Delivery Date *</option>     
                                                                                                <?php
                                                                                                if($product['type_id'] == '1'){
                                                                                                    foreach($ins->arrDates as $key => $val){
                                                                                                            $date_array = explode("T",$val);
                                                                                                            echo '<option value="'.$val.'">'.date('l, jS F Y',  strtotime($date_array[0])).'</option>';
                                                                                                        }
                                                                                                    
                                                                                                }
                                                                                                elseif($product['type_id'] == '2'){
                                                                                                    $ch = curl_init();
                                                                                                    $username = '527492';
                                                                                                    $password = '8EEkyK';                                                                                                    
                                                                                                    $product_code = $product['product_no'];
                                                                                                    //$product_code = 'WGD413';
                                                                                                    $auth = base64_encode("{$username}:{$password}");
                                                                                                    curl_setopt_array(
                                                                                                            $ch, array(
                                                                                                        CURLOPT_URL => "https://www.floristone.com/api/rest/giftbaskets/getproducts?code=$product_code",
                                                                                                        CURLOPT_HTTPHEADER => array("Authorization: {$auth}"),
                                                                                                        CURLOPT_RETURNTRANSFER => true
                                                                                                            )
                                                                                                    );
                                                                                                    $output = json_decode(curl_exec($ch)); // return obj
                                                                                                    curl_close($ch);
                                                                                                    $products = $output->PRODUCTS;
                                                                                                    $availabledeliverydates = $products[0]->AVAILABLEDELIVERYDATES;
                                                                                                    for ($y = 0; $y < count($availabledeliverydates); $y++) {
                                                                                                        echo '<option value="'. $availabledeliverydates[$y]->DATE . '">' . date('l, jS F Y', strtotime($availabledeliverydates[$y]->DATE)) . ' - $' . $availabledeliverydates[$y]->SHIPPINGPRICE . '</option>';
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                                                
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
                    <input type="hidden" name='amount' id="amount" value="<?= sprintf("%01.2f",$amt)?>"> 
                                                                          
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
                                                                                    <?php
                                                                                    $special1 = mysql_query("select " . $prev . "occasion.* from " . $prev . "occasion where " . $prev . "occasion.id='" . $occasion_id . "'");
                                                                                     //echo "select " . $prev . "occasion.*,products.name,products.price,products.flowerwyz_image,products.product_no from " . $prev . "cart,products where " . $prev . "occasion.product_id=products.id and " . $prev . "occasion.id='" . $occasion_id . "'";   
                                                                                    $resultSpecial1 = @mysql_fetch_array($special1);
                                                                                     $product_id = $resultSpecial1['product_'.rand(1,3)];
                                                                                     $product_name = getProductNameById($product_id);
                                                                                     $product_image = getProductImageById($product_id);
                                                                                     $product_type = getProductTypeById($product_id);
                                                                                     $product_desc = getProductDescriptionById($product_id);
                                                                                     $product_price = getProductPriceById($product_id);
                                                                                     mysql_free_result($special1);
;                                                                                     ?>
                                                                                    <div class="image_title"><?=$product_name?></div>
                                                                                    <div class="prod_img2">
                                                                                        
                                                                                        <a href="javascript:void(0)" class="tt"><img src="<?=$product_image?>" title="Elance Clone Theme 8">
                                                                                         <span class="details">
                                                                                            <h4><?=$product_name?></h4>
                                                                                            </br><h2><?=$setting[currency]." " . sprintf("%01.2f",$product_price)?></h2></br>
                                                                                            <p><?=$product_desc?></p>
                                                                                           </span>
                                                                                            <span class="tooltip"><span class="top"></span>
                                                                                                <span class="middle">
                                                                                                    <img src="<?=$product_image?>" title="Elance Clone Theme 8">
                                                                                                         <span>
                                                                                                        <h4><?=$product_name?></h4>
                                                                                            </br><h2><?=$setting[currency]." " . sprintf("%01.2f",$product_price)?></h2></br>
                                                                                            <p><?=$product_desc?></p>
                                                                                           </span>
                                                                                                </span><span class="bottom"></span>                                                    
                                                                                            </span>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="price_section">
                                                                                        <div class="price"><?=$setting[currency]." " . sprintf("%01.2f",$product_price)?></div>
                                                                                        <div class="cal">
                                                                                             
                                                                                           <span id="remove_cart_<?=$product_id?>">
                                                                                               <p>Add</p>
                                                                                            <input type="radio" name="<?=$product_id?>" value="<?=$occasion_id?>" class="add-to-cart radio" id="remove_cart_<?=$product_id?>_y"><label for="remove_cart_<?=$product_id?>_y" class="css-label radGroup1"></label>
                                                                                            <!--<input type="radio" name="490" value="0" class="remove-to-cart" id="490"><label for="490" class="css-label2 radGroup1"></label>--></span>
                                                                                            <!--<button class="button_add addition add-to-cart" name="490">+</button>-->
                                                                                            <br>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div class="prod_image col-sm-4 prods">
                                                                                    <?php
                                                                                    $special2= mysql_query("select " . $prev . "occasion.* from " . $prev . "occasion where " . $prev . "occasion.id='" . $occasion_id . "'");
                                                                                     //echo "select " . $prev . "occasion.*,products.name,products.price,products.flowerwyz_image,products.product_no from " . $prev . "cart,products where " . $prev . "occasion.product_id=products.id and " . $prev . "occasion.id='" . $occasion_id . "'";   
                                                                                    $resultSpecial2 = @mysql_fetch_array($special2);
                                                                                     $product_id = $resultSpecial2['product_'.rand(4,6)];
                                                                                     $product_name = getProductNameById($product_id);
                                                                                     $product_image = getProductImageById($product_id);
                                                                                     $product_type = getProductTypeById($product_id);
                                                                                     $product_desc = getProductDescriptionById($product_id);
                                                                                     $product_price = getProductPriceById($product_id);
                                                                                     mysql_free_result($special2);
;                                                                                     ?>
                                                                                    <div class="image_title"><?=$product_name?></div>
                                                                                    <div class="prod_img2">
                                                                                        <a href="javascript:void(0)" class="tt"><img src="http://www.floristone.com/flowers/products/WGG385_d1.jpg" title="Elance Clone Theme 8">
                                                                                       
                                                                                        
                                                                                        <span class="details">
                                                                                            <h4><?=$product_name?></h4>
                                                                                            </br><h2><?=$setting[currency]." " . sprintf("%01.2f",$product_price)?></h2></br>
                                                                                            <p><?=$product_desc?></p>
                                                                                        </span>
                                                                                            <span class="tooltip"><span class="top"></span>
                                                                                                <span class="middle">
                                                                                                   <img src="http://www.floristone.com/flowers/products/WGG385_d1.jpg" title="Elance Clone Theme 8">
                                                                                                  
                                                                                                         <span>
                                                                                                            <h4><?=$product_name?></h4>
                                                                                                            </br><h2><?=$setting[currency]." " . sprintf("%01.2f",$product_price)?></h2></br>
                                                                                                            <p><?=$product_desc?></p>
                                                                                                        </span>
                                                                                                </span><span class="bottom"></span>                                                    
                                                                                            </span>
                                                                                                </a>
                                                                                    </div>
                                                                                    <div class="price_section">
                                                                                        <div class="price"><?=$setting[currency]." " . sprintf("%01.2f",$product_price)?></div>
                                                                                        <div class="cal">
                                                                                            <span id="remove_cart_<?=$product_id?>">
                                                                                             <p>Add</p>
                                                                                         
                                                                                            <input type="radio" name="<?=$product_id?>" value="<?=$occasion_id?>" class="add-to-cart radio" id="remove_cart_<?=$product_id?>_y"><label for="remove_cart_<?=$product_id?>_y" class="css-label radGroup1"></label>
                                                                                            </span>
                                                                                            <br>
                                                                                          
                                                                                        </div>

                                                                                    </div>
                                                                                </div>

                                                                                <div class="prod_image col-sm-4 prods">
                                                                                    <?php
                                                                                    $special3= mysql_query("select " . $prev . "occasion.* from " . $prev . "occasion where " . $prev . "occasion.id='" . $occasion_id . "'");
                                                                                     //echo "select " . $prev . "occasion.*,products.name,products.price,products.flowerwyz_image,products.product_no from " . $prev . "cart,products where " . $prev . "occasion.product_id=products.id and " . $prev . "occasion.id='" . $occasion_id . "'";   
                                                                                    $resultSpecial3 = @mysql_fetch_array($special3);
                                                                                     $product_id = $resultSpecial2['product_'.rand(7,10)];
                                                                                     $product_name = getProductNameById($product_id);
                                                                                     $product_image = getProductImageById($product_id);
                                                                                     $product_type = getProductTypeById($product_id);
                                                                                     $product_desc = getProductDescriptionById($product_id);
                                                                                     $product_price = getProductPriceById($product_id);
                                                                                     mysql_free_result($special3);
;                                                                                     ?>
                                                                                    <div class="image_title"><?=$product_name;?></div>
                                                                                    <div class="prod_img2">
                                                                                        <a href="javascript:void(0)" class="tt"><img src="<?=$product_image?>" title="Elance Clone Theme 8">
                                                                                       
                                                                                        
                                                                                        <span class="details">
                                                                                            <h4><?=$product_name;?></h4>
                                                                                            </br><h2><?=$setting[currency]." " . sprintf("%01.2f",$product_price)?></h2></br>
                                                                                             <p><?=$product_desc;?></p>
                                                                                        </span>
                                                                                        <span class="tooltip"><span class="top"></span>
                                                                                                <span class="middle">
                                                                                                    <img src="http://www.floristone.com/flowers/products/WGH170_d1.jpg" title="Elance Clone Theme 8">
                                                                                                         <span>
                                                                                                            <h4><?=$product_name;?></h4>
                                                                                                            </br><h2><?=$setting[currency]." " . sprintf("%01.2f",$product_price)?></h2></br>
                                                                                                            <p><?=$product_desc;?></p>
                                                                                                        </span>
                                                                                                </span><span class="bottom"></span>                                                    
                                                                                            </span>    
                                                                                                 </a>
                                                                                    </div>
                                                                                    <div class="price_section">
                                                                                        <div class="price"><?=$setting[currency]." " . sprintf("%01.2f",$product_price)?></div>
                                                                                        <div class="cal">
                                                                                            <span id="remove_cart_<?=$product_id?>">
                                                                                            <p>Add</p>
                                                                                            
                                                                                            <input type="radio" name="<?=$product_id?>" value="<?=$occasion_id?>" class="add-to-cart radio" id="remove_cart_<?=$product_id?>_y"><label for="remove_cart_<?=$product_id?>_y" class="css-label radGroup1"></label>
                                                                                            </span>
                                                                                                <br>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>                                                                       
                                                                        </div>
                                                                    </fieldset>                                                                   
                                                                    <button type="button" style="margin-top: 264px !important;" class="green-btn pull-right" id="goAccorThree">Continue To Next Step</button>
                                                                </div>
                                                            </div>

                                                            <div class="panel panel-default accord-container" style="border-radius:0px; margin-top:-1px;">
                                                                <div class="panel-heading" id="accorHeadThree" ><span class="label label-dark">3</span>Recipient Information</div>
                                                                <div class="panel-body" id="accorBodyThree">
                                                                    <fieldset data-step="2">
              <div id="ajax_recipent">
                                                                        <?php 
                                                                       
                                                                        
                                                                           $r = mysql_query("select " . $prev . "cart.*,products.name,products.price,products.flowerwyz_image from " . $prev . "cart,products where " . $prev . "cart.product_id=products.id and " . $prev . "cart.OrderID='" . GetCartId() . "' and " . $prev . "cart.purchased='N'");
		 
                                                                            $i=1;
                                                                             while ($product = @mysql_fetch_array($r)){             
                                                                             if($i>1){	
                                                                            ?>
                                                           
                                                          <input name="copyDeliveryAddress_<?=$i?>_<?=$i-1?>" id="copyDeliveryAddress_<?=$i?>_<?=$i-1?>" class="copyDeliveryAddress" type="checkbox"> Use same Recipient information as first item 
                                                            <div class="hideDelivery_<?=$i?>" style="display:none;">   
                                                              <?php }?>                                                                      
                                                                <input type="hidden" name="product_id[]" value="<?php echo $product['product_id'];?>">
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
                                                                           $i++;  }
                                                                        ?>
                                                                        
                                                                       </div> 
                                                                    </fieldset>
                                                                   <button type="button" style="margin-top:10px;" class="green-btn pull-right" id="goAccorFour">Continue To Next Step</button>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-default accord-container" style="border-radius:0px; margin-top:-1px;">
                                                                <div class="panel-heading" id="accorHeadFour"><span class="label label-dark">4</span>Billing Information</div>
                                                                <div class="panel-body" id="accorBodyFour">
                                                                    <fieldset data-step="2">

                                                                        <div class="row">
                                                                            <div>
                                                                                <label class="checkbox inline" style="padding: 0;margin: 0px 0px 5px 37px;">
                                                                                    <input name="shipping_chk" id="shipping_chk" type="checkbox" >
                                                                                        Same as recipient information.</label>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="cfirstname" name="cfirstname" placeholder="First Name*" type="text" class="form-control" required="required">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="clastname" name="clastname" type="text" placeholder="Last name*" class="form-control" required="required" data-minlength="3">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="caddress1" name="caddress1" type="text" placeholder="Address*" class="form-control" required="required">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="caddress2" name="caddress2" placeholder="Address 2" type="text" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep cust-select">
                                                                                    <select onChange="this.className=this.options[this.selectedIndex].className"
    class="greenText" id="ccountry" required="required" name="ccountry">

                                                                                        <option value="" selected="selected">--Select Country--</option>

                                                                                        <option value="US">United States</option>

                                                                                        <option value="CA">Canada</option>

                                                                                        <option value="x" disabled="disabled">-----------------------</option>

                                                                                        <option value="AF">Afghanistan</option>

                                                                                        <option value="AL">Albania</option>

                                                                                        <option value="DZ">Algeria</option>

                                                                                        <option value="AS">American Samoa</option>

                                                                                        <option value="AD">Andorra</option>

                                                                                        <option value="AO">Angola</option>

                                                                                        <option value="AI">Anguilla</option>

                                                                                        <option value="AQ">Antarctica</option>

                                                                                        <option value="AG">Antigua and Barbuda</option>

                                                                                        <option value="AR">Argentina</option>

                                                                                        <option value="AM">Armenia</option>

                                                                                        <option value="AW">Aruba</option>

                                                                                        <option value="AU">Australia</option>

                                                                                        <option value="AT">Austria</option>

                                                                                        <option value="AZ">Azerbaijan</option>

                                                                                        <option value="BS">Bahamas</option>

                                                                                        <option value="BH">Bahrain</option>

                                                                                        <option value="BD">Bangladesh</option>

                                                                                        <option value="BB">Barbados</option>

                                                                                        <option value="BY">Belarus</option>

                                                                                        <option value="BE">Belgium</option>

                                                                                        <option value="BZ">Belize</option>

                                                                                        <option value="BJ">Benin</option>

                                                                                        <option value="BM">Bermuda</option>

                                                                                        <option value="BT">Bhutan</option>

                                                                                        <option value="BO">Bolivia</option>

                                                                                        <option value="BA">Bosnia - Herzegovina</option>

                                                                                        <option value="BW">Botswana</option>

                                                                                        <option value="BV">Bouvet Island</option>

                                                                                        <option value="BR">Brazil</option>

                                                                                        <option value="IO">British Indian Ocean Ter.</option>

                                                                                        <option value="BN">Brunei Darussalam</option>

                                                                                        <option value="BG">Bulgaria</option>

                                                                                        <option value="BF">Burkina Faso</option>

                                                                                        <option value="BI">Burundi</option>

                                                                                        <option value="KH">Cambodia</option>

                                                                                        <option value="CM">Cameroon</option>

                                                                                        <option value="CA">Canada</option>

                                                                                        <option value="CV">Cape Verde</option>

                                                                                        <option value="KY">Cayman Islands</option>

                                                                                        <option value="CF">Central African Republic</option>

                                                                                        <option value="TD">Chad</option>

                                                                                        <option value="CL">Chile</option>

                                                                                        <option value="CN">China</option>

                                                                                        <option value="CX">Christmas Island</option>

                                                                                        <option value="CC">Cocos (Keeling) Islands</option>

                                                                                        <option value="CO">Colombia</option>

                                                                                        <option value="KM">Comoros</option>

                                                                                        <option value="CG">Congo</option>

                                                                                        <option value="CK">Cook Islands</option>

                                                                                        <option value="CR">Costa Rica</option>

                                                                                        <option value="CI">Cote D'Ivoire(Ivory Coast)</option>

                                                                                        <option value="HR">Croatia</option>

                                                                                        <option value="CU">Cuba</option>

                                                                                        <option value="CY">Cyprus</option>

                                                                                        <option value="CZ">Czech Republic</option>

                                                                                        <option value="DK">Denmark</option>

                                                                                        <option value="DJ">Djibouti</option>

                                                                                        <option value="DM">Dominica</option>

                                                                                        <option value="DO">Dominican Republic</option>

                                                                                        <option value="TP">East Timor</option>

                                                                                        <option value="EC">Ecuador</option>

                                                                                        <option value="EG">Egypt</option>

                                                                                        <option value="SV">El Salvador</option>

                                                                                        <option value="GQ">Equatorial Guinea</option>

                                                                                        <option value="ER">Eritrea</option>

                                                                                        <option value="EE">Estonia</option>

                                                                                        <option value="ET">Ethiopia</option>

                                                                                        <option value="FK">Falkland Islands</option>

                                                                                        <option value="FO">Faroe Islands</option>

                                                                                        <option value="FJ">Fiji</option>

                                                                                        <option value="FI">Finland</option>

                                                                                        <option value="FR">France</option>

                                                                                        <option value="GF">French Guyana</option>

                                                                                        <option value="PF">French Polynesia</option>

                                                                                        <option value="GA">Gabon</option>

                                                                                        <option value="GM">Gambia</option>

                                                                                        <option value="GE">Georgia</option>

                                                                                        <option value="DE">Germany</option>

                                                                                        <option value="GH">Ghana</option>

                                                                                        <option value="GI">Gibraltar</option>

                                                                                        <option value="GR">Greece</option>

                                                                                        <option value="GL">Greenland</option>

                                                                                        <option value="GD">Grenada</option>

                                                                                        <option value="GP">Guadeloupe</option>

                                                                                        <option value="GU">Guam</option>

                                                                                        <option value="GT">Guatemala</option>

                                                                                        <option value="GN">Guinea</option>

                                                                                        <option value="GW">Guinea-Bissau</option>

                                                                                        <option value="GY">Guyana</option>

                                                                                        <option value="HT">Haiti</option>

                                                                                        <option value="HM">Heard &amp; McDonald Islands</option>

                                                                                        <option value="VA">Holy See (Vatican City)</option>

                                                                                        <option value="HN">Honduras</option>

                                                                                        <option value="HK">Hong Kong</option>

                                                                                        <option value="HU">Hungary</option>

                                                                                        <option value="IS">Iceland</option>

                                                                                        <option value="IN">India</option>

                                                                                        <option value="ID">Indonesia</option>

                                                                                        <option value="IR">Iran</option>

                                                                                        <option value="IE">Ireland</option>

                                                                                        <option value="IL">Israel</option>

                                                                                        <option value="IT">Italy</option>

                                                                                        <option value="JM">Jamaica</option>

                                                                                        <option value="JP">Japan</option>

                                                                                        <option value="JO">Jordan</option>

                                                                                        <option value="KZ">Kazakstan</option>

                                                                                        <option value="KE">Kenya</option>

                                                                                        <option value="KI">Kiribati</option>

                                                                                        <option value="KR">Korea, Republic of</option>

                                                                                        <option value="KW">Kuwait</option>

                                                                                        <option value="KG">Kyrgyzstan</option>

                                                                                        <option value="LA">Laos</option>

                                                                                        <option value="LV">Latvia</option>

                                                                                        <option value="LB">Lebanon</option>

                                                                                        <option value="LS">Lesotho</option>

                                                                                        <option value="LR">Liberia</option>

                                                                                        <option value="LY">Libyan Arab Jamahiriya</option>

                                                                                        <option value="LI">Liechtenstein</option>

                                                                                        <option value="LT">Lithuania</option>

                                                                                        <option value="LU">Luxembourg</option>

                                                                                        <option value="MO">Macau</option>

                                                                                        <option value="MK">Macedonia</option>

                                                                                        <option value="MG">Madagascar</option>

                                                                                        <option value="MW">Malawi</option>

                                                                                        <option value="MY">Malaysia</option>

                                                                                        <option value="MV">Maldives</option>

                                                                                        <option value="ML">Mali</option>

                                                                                        <option value="MT">Malta</option>

                                                                                        <option value="MH">Marshall Islands</option>

                                                                                        <option value="MQ">Martinique</option>

                                                                                        <option value="MR">Mauritania</option>

                                                                                        <option value="MU">Mauritius</option>

                                                                                        <option value="YT">Mayotte</option>

                                                                                        <option value="MX">Mexico</option>

                                                                                        <option value="FM">Micronesia</option>

                                                                                        <option value="MD">Moldavia</option>

                                                                                        <option value="MC">Monaco</option>

                                                                                        <option value="MN">Mongolia</option>

                                                                                        <option value="MS">Montserrat</option>

                                                                                        <option value="MA">Morocco</option>

                                                                                        <option value="MZ">Mozambique</option>

                                                                                        <option value="MM">Myanmar</option>

                                                                                        <option value="NA">Namibia</option>

                                                                                        <option value="NR">Nauru</option>

                                                                                        <option value="NP">Nepal</option>

                                                                                        <option value="NL">Netherlands</option>

                                                                                        <option value="AN">Netherlands Antilles</option>

                                                                                        <option value="NC">New Caledonia</option>

                                                                                        <option value="NZ">New Zealand</option>

                                                                                        <option value="NI">Nicaragua</option>

                                                                                        <option value="NE">Niger</option>

                                                                                        <option value="NG">Nigeria</option>

                                                                                        <option value="NU">Niue</option>

                                                                                        <option value="MP">Northern Mariana Islands</option>

                                                                                        <option value="NO">Norway</option>

                                                                                        <option value="OM">Oman</option>

                                                                                        <option value="PK">Pakistan</option>

                                                                                        <option value="PW">Palau</option>

                                                                                        <option value="PA">Panama</option>

                                                                                        <option value="PG">Papua New Guinea</option>

                                                                                        <option value="PY">Paraguay</option>

                                                                                        <option value="PE">Peru</option>

                                                                                        <option value="PH">Philippines</option>

                                                                                        <option value="PN">Pitcairn Island</option>

                                                                                        <option value="PL">Poland</option>

                                                                                        <option value="PT">Portugal</option>

                                                                                        <option value="PR">Puerto Rico</option>

                                                                                        <option value="QA">Qatar</option>

                                                                                        <option value="RE">Reunion</option>

                                                                                        <option value="RO">Romania</option>

                                                                                        <option value="RU">Russian Federation</option>

                                                                                        <option value="RW">Rwanda</option>

                                                                                        <option value="KN">Saint Kitts &amp; Nevis</option>

                                                                                        <option value="LC">Saint Lucia</option>

                                                                                        <option value="VC">Saint Vincent &amp; Grenadines</option>

                                                                                        <option value="WS">Samoa</option>

                                                                                        <option value="SM">San Marino</option>

                                                                                        <option value="ST">Sao Tome and Principe</option>

                                                                                        <option value="SA">Saudi Arabia</option>

                                                                                        <option value="SN">Senegal</option>

                                                                                        <option value="SC">Seychelles</option>

                                                                                        <option value="SL">Sierra Leone</option>

                                                                                        <option value="SG">Singapore</option>

                                                                                        <option value="SK">Slovakia</option>

                                                                                        <option value="SI">Slovenia</option>

                                                                                        <option value="SB">Solomon Islands</option>

                                                                                        <option value="SO">Somalia</option>

                                                                                        <option value="ZA">South Africa</option>

                                                                                        <option value="ES">Spain</option>

                                                                                        <option value="LK">Sri Lanka</option>

                                                                                        <option value="SH">St. Helena</option>

                                                                                        <option value="PM">St. Pierre and Miquelon</option>

                                                                                        <option value="SD">Sudan</option>

                                                                                        <option value="SR">Suriname</option>

                                                                                        <option value="SJ">Svalbard &amp; Jan Mayen Isl.</option>

                                                                                        <option value="SZ">Swaziland</option>

                                                                                        <option value="SE">Sweden</option>

                                                                                        <option value="CH">Switzerland</option>

                                                                                        <option value="SY">Syrian Arab Republic</option>

                                                                                        <option value="TW">Taiwan</option>

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
                                                                                                                                      <!--  <select id="ccountry" required="required" name="ccountry">
                                                                                                                                            <option value="">--Select Country*--</option>
                                                                                                                                            <option value="US">United States</option>
                                                                                                                                            <option value="CA">Canada</option>
                                                                                                                                        </select>-->
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep cust-select">

                                                                                    <select onChange="this.className=this.options[this.selectedIndex].className"
    class="greenText" id="cstate" name="cstate" required="required">
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

                                                                                    <input id="ccity" name="ccity" type="text" placeholder="City*" class="form-control"  required="required">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="czip" name="czip" type="text" placeholder="Zip Code*" class="form-control" required="required">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">
                                                                                    <select name="phone_code" id="phone_code" class="form-control" required="required" style="width: 38%;float: left;">
                                                                                        <option value="">--Select--</option>
                                                                                        <?php
                                                                                        $result = mysql_query("SELECT * FROM country_code where code <> ''"); //Count from local API dynamic data
                                                                                        while($row = mysql_fetch_array($result)){?>
                                                                                                <option value="<?php echo $row['code'];?>"><?php echo $row['code'].' - '.$row['value'];?></option>
                                                                                            <?php }
                                                                                        ?>
                                                                                    </select>    
                                                                                    <input name="cphone" id="cphone" placeholder="Phone*" type="text" class="form-control" required="required" autocomplete="off" style='width: 62%;'>
                                                                                        <p for="cphone" class="warning" id="val-cphone-error"></p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form_sep">

                                                                                    <input id="cemail" name="cemail"  placeholder="Email*" class="form-control"  required="required" type="email">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </fieldset>
                                                                    <button type="button" style="margin-top:10px;" class="green-btn pull-right" id="goAccorFive">Continue To Next Step</button>
                                                                </div>
                                                            </div>

                                                            <div class="panel panel-default accord-container" style="border-radius:0px; margin-top:-1px;">
                                                                <div class="panel-heading" id="accorHeadFive"><span class="label label-dark">5</span>Payment Methods</div>
                                                                <div class="panel-body" id="accorBodyFive">
                                                                    <fieldset data-step="3">
                                                                        <div class="row">                                                                          

                                                                            <div class="col-sm-6">
                                                                                <div class="step_info">
                                                                                    <h4>Payment Methods</h4>
                                                                                    <img src="<?php echo $vpath; ?>images/credit-cards.png" style="margin:10px 0;" /> </div>

                                                                                <div class="form-group cust-select">

                                                                                    <select onChange="this.className=this.options[this.selectedIndex].className" class="greenText" id="ccardtype" name="ccardtype"  required="required">
                                                                                        <option value="" selected="selected">--Select Card*--</option>
                                                                                        <option value="AX">American Express</option>
                                                                                        <option value="VI">Visa</option>
                                                                                        <option value="MC">MasterCard</option>
                                                                                        <option value="DI">Discover</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group">

                                                                                    <input id="ccardname" name="ccardname" type="text" placeholder="Name On Card*" class="form-control" required="required" />
                                                                                </div>
                                                                                <div class="form-group">

                                                                                    <input id="ccardnum" name="ccardnum" onKeyPress="masking(this.value,this,event);" onBlur="validateCard(this.value)" type="text" placeholder="Card Number*" maxlength="19" class="form-control" required="required">
                                                                                        <p class="warning" id="Vali-ccardnum-error"></p>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div style="width:52%; float:left;">
                                                                                        <input id="experition_date" name="experition_date" type="text" autocomplete="off" placeholder="Expiration Date*"  readonly="readonly" class="form-control monthPicker" required="required">
                                                                                    </div>

                                                                                    <div style="width:46%; float:right;">
                                                                                        <input id="cvv2" name="cvv2" type="password" placeholder="CVV Code*" maxlength="4" class="form-control" required="required">
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
                                                                                    <input id="acceptTerms" name="acceptTerms" type="checkbox" required="required">
                                                                                        I agree with the Terms and Conditions.</label>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                   <!-- <input type="submit" id="finalPay" class="green-btn pull-right" style="margin-top:10px; width:200px;" value="Place Order" />-->
                                                                </div>
                                                            </div>
                                                            <div class="bottom_amount_right">
                                                                <div class="amt">
                                                                  <h3><span class="td1bg3" id="td1bg3p"><?=$setting[currency]." " . sprintf("%01.2f",$amt)?></span></h3>
                                                                </div>
                                                                     <input type="submit" id="finalPay" class="green-btn pull-right" style="margin-top:10px;" value="Place Order" />
                                                                  
                                                                    
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
                                                                                        <td class="price"><span class="purchase_display_currency"></span><span class="td1bg3" id="td1bg3p"><?=$setting[currency]." " . sprintf("%01.2f",$amt)?></span></td>
                                                                                        
                                                                                    </tr>                                                                                    
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="panel-footer summary">
                                                                        <div class="summary-total">
                                                                            <div class="total-label">Total (USD)</div>
                                                                            <div class="total-price"><span class="purchase_display_currency"></span><span class="td1bg3" id="td1bg3p"><?=$setting[currency]." " . sprintf("%01.2f",$amt)?></span></div>
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
                     /*      
        
        $.ajax({
                                type: "POST",
                                data: 'zip_code=10011',
                                url: FULL_BASE_URL + 'getDeliveryDates.php',
                                beforeSend: function() {
                                    $('.del_date').attr('disabled', 'disabled');
                                    // $('#ProjectId').attr('disabled', 'disabled');
                                    //return false;
                                },
                                success: function(return_data) {
                                    $('.del_date').removeAttr('disabled');
                                    $('.del_date').html(return_data);
                                }
                            });
*/
                        
                        
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
    </body>
    </html>