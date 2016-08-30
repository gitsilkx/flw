<?php
include("configs/path.php");
include("getProducts.php");
if ($_GET['code'] && $_GET['code'] != '') {
    $itemCode = $_GET['code'];
}

$product = $ins->getProduct(API_USER, API_PASSWORD, $itemCode);

$num_of_days = date('t');
for ($i = date('d'); $i <= $num_of_days; $i++) {
    $dates[date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT)] = date("l", mktime(0, 0, 0, date('m'), $i, date('Y'))) . ' ' . date("M $i,Y");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        </style>
        <!-- bootstrap framework-->
        <link rel="stylesheet" href="<?= $vpath ?>bootstrap/css/bootstrap.min.css">

            <!-- ebro styles -->
            <link rel="stylesheet" href="<?= $vpath ?>css/flower.css">


                <!-- jQuery --> 
                <script src="<?= $vpath ?>js/jquery.min.js"></script> 
                <!-- bootstrap framework --> 
                <script src="<?= $vpath ?>bootstrap/js/bootstrap.min.js"></script> 
                <!-- jQuery resize event --> 
                <script src="<?= $vpath ?>js/jquery.ba-resize.min.js"></script> 
                <!-- jquery cookie --> 
                <script src="<?= $vpath ?>js/jquery_cookie.min.js"></script> 
                <!-- retina ready --> 
                <script src="<?= $vpath ?>js/retina.min.js"></script> 
                <!-- tinyNav --> 
                <script src="<?= $vpath ?>js/tinynav.js"></script> 
                <!-- sticky sidebar --> 
                <script src="<?= $vpath ?>js/jquery.sticky.js"></script> 
                <!-- Navgoco --> 
                <script src="<?= $vpath ?>js/lib/navgoco/jquery.navgoco.min.js"></script> 
                <!-- jMenu --> 
                <script src="<?= $vpath ?>js/lib/jMenu/js/jMenu.jquery.js"></script> 
                <!-- typeahead --> 
                <script src="<?= $vpath ?>js/lib/typeahead.js/typeahead.min.js"></script> 
                <script src="<?= $vpath ?>js/lib/typeahead.js/hogan-2.0.0.js"></script> 
                <script src="<?= $vpath ?>js/ebro_common.js"></script> 

                <!-- clender --> 
                <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

                    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

                    <!-- jquery steps --> 
                    <script src="<?= $vpath ?>js/lib/jquery-steps/jquery.steps.min.js"></script> 
                    <!-- parsley --> 
                    <script src="<?= $vpath ?>js/lib/parsley/parsley.min.js"></script> 
                    <script src="<?= $vpath ?>js/pages/ebro_wizard.js"></script> 



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
                    </head>

                    <div id="main_content_outer" class="clearfix">
                        <div id="main_content">
                            <div style="background:#ffeaeb; padding:10px 0 0 5%; overflow:hidden; width:90%">
                                <h2 class="headingPan">FlowerWyz Secure Checkout</h2>
                                <!-- main content -->
                                <div>
                                    <div style="width:70%; float:left;">

                                        <form class="cmxform" id="wizard_a" method="post" action="<?= $vpath; ?>notify.php">
                                            <input type="hidden" name='itemCode' id="itemCode" value="<?php echo $_GET['code']; ?>">
                                                <input type="hidden" name='action_type' id="ActionType" value="0">
                                              
                                                <input type="hidden" name='save' value="Continue" >
                                                    <input type="hidden" name='hidden_site_baseurl' id="hidden_site_baseurl" value="<?php echo $vpath; ?>">
                                                        <h4>Review Cart</h4>
                                                        <fieldset data-step="0">
                                                            <div class="row">
                                                                <div class="col-sm-12" id="review-cart">
                                                                    <table class="cart-contents">
                                                                        <tbody>
                                                                            <tr class="background">
                                                                                <th class="th item"><span style="padding:0 0 0 6px;">Item</span></th>
                                                                                <th class="th item_name">Item Details</th>
                                                                                <th class="th unit-price" style="text-align: right; padding:0 8px 0 0;">Unit Price</th>
                                                                            </tr>

                                                                            <tr class="item-row">
                                                                                <td class="item"><p><img src="<?php echo $product['thumbnail']; ?>" height="130px"></p></td>
                                                                                <td class="item_name" style="width: 58%; padding-top: 13px;text-align: left;"><span class="inline-quantity-label"><?php echo $product['name'] . '<br /><br /><span class="desc">' . $product['description'] . "</span>"; ?></span></td>
                                                                                <td class="unit-price" style="text-align: right;vertical-align:top;padding-top: 14px; padding-right:8px;"><span class="purchase_display_currency">$</span><?php echo $product['price']; ?></td>
                                                                            </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <h4>Recipient Information</h4>
                                                        <fieldset data-step="1">
                                                            <div class="row">
                                                                  <div class="col-sm-6">
                                                                    <div class="form_sep">

                                                                        <input id="rname" name="rname" placeholder="Name*" type="text" class="form-control" data-required="true">
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <input id="rattention" name="rattention" placeholder="Institution" type="text" class="form-control">
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <input id="raddress1" name="raddress1" type="text" placeholder="Address*" class="form-control" data-required="true">
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <input id="raddress2" name="raddress2" type="text" placeholder="Address 2" class="form-control">
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <input id="rcity" name="rcity" type="text" placeholder="City*" class="form-control" data-required="true">
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <select id="rstate" class="form-control" data-required="true" name="rstate" >
                                                                            <option value="">--Select State*--</option>
                                                                            <option value="x">--United States--</option>
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
                                                                            <option value="x">--Canada--</option>
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
                                                                        </select>
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <select id="rcountry" class="form-control" data-required="true" name="rcountry">
                                                                            <option value="">--Select Country*--</option>
                                                                            <option value="US">United States</option>
                                                                            <option value="CA">Canada</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <input id="rzip" name="rzip" type="text" placeholder="Zip Code*" class="form-control" data-required="true">
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <input id="rphone" name="rphone" type="text" placeholder="Phone*" class="form-control" data-required="true">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    

                                                                    <div class="form_sep">
                                                                        <label class="req">Message On Card</label>
                                                                        <textarea id="renclosure" class="form-control"cols="70" rows="7" data-required="true" name="renclosure" maxlength="200">Please enter your personalized message here. Don't forget to add your name.</textarea>
                                                                    </div>
                                                                    <div class="form_sep">
                                                                        <label class="req">Special Delivery Instructions</label>
                                                                        <textarea id="rinstructions" class="form-control" cols="70" rows="7" data-required="true" name="rinstructions" maxlength="200">If you have specific instructions for our delivery team, you may add them here.</textarea>
                                                                    </div>
                                                                    <div class="form_sep">
                                                                       <!-- <input type="text" name="deliverydate" id="datepicker"  data-required="true" placeholder="Select Delivery Date*" class="form-control" />-->
                                                                        <select name="deliverydate" id="deliverydate" data-required="true" class="form-control">
                                                                            <option value="">Select Delivery Date *</option>
                                                                       
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                              
                                                            </div>
                                                        </fieldset>
                                                        <h4>Billing Information</h4>
                                                        <fieldset data-step="2">
                                                            <div class="row">
                                                                <div>
                                                                    <label class="checkbox inline" style="padding: 0;margin: 0px 0px 5px 37px;">
                                                                        <input name="shipping_chk" id="shipping_chk" type="checkbox" >
                                                                            Same as shipping address.</label>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form_sep">

                                                                        <input id="cfirstname" name="cfirstname" placeholder="First Name*" type="text" class="form-control" data-required="true">
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <input id="cemail" name="cemail" type="text" placeholder="Email*" class="form-control" data-required="true" data-type="email">
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <input id="caddress2" name="caddress2" placeholder="Address 2" type="text" class="form-control">
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <select id="cstate" class="form-control" data-required="true" name="cstate">
                                                                            <option value="">--Select State*--</option>
                                                                            <option value="x">--United States--</option>
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
                                                                            <option value="x">--Canada--</option>
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
                                                                        </select>
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <input id="czip" name="czip" type="text" placeholder="Zip Code*" class="form-control" data-required="true">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form_sep">

                                                                        <input id="clastname" name="clastname" type="text" placeholder="Last name*" class="form-control" data-required="true" data-minlength="3">
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <input id="caddress1" name="caddress1" type="text" placeholder="Address*" class="form-control" data-required="true">
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <input id="ccity" name="ccity" type="text" placeholder="City*" class="form-control"  data-required="true">
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <select id="ccountry" class="form-control" data-required="true" name="ccountry">
                                                                            <option value="">--Select Country*--</option>
                                                                            <option value="US">United States</option>
                                                                            <option value="CA">Canada</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form_sep">

                                                                        <input id="cphone" name="cphone" placeholder="Phone*" type="text" class="form-control" data-required="true">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </fieldset>

                                                        <h4>Payment Methods</h4>
                                                        <fieldset data-step="3">
                                                            <div class="row">
                                                                <div class="col-sm-12" id="review-cart">
                                                                    <div id="ajaxTotal"  style="height: 258px;;">
                                                                     

                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6" style="height: 100%">
                                                                    <div class="step_info">
                                                                        <h4>Payment Methods</h4>
                                                                        <img src="<?php echo $vpath; ?>images/credit-cards.png" style="margin:10px 0;" /> </div>
                                                                    <p>All flowers, plants, or containers may not always be available. By checking this box, you give us permission to make reasonable substitutions to ensure we deliver your order in a timely manner. Substitutions will not affect the value or quality of your order.</p>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <h4 style="padding:0 0 10px;">&nbsp;</h4>

                                                                    <div class="form-group">

                                                                        <select id="ccardtype" name="ccardtype" class="form-control" data-required="true">
                                                                            <option value="" selected="selected">--Select Card*--</option>
                                                                            <option value="AX">American Express</option>
                                                                            <option value="VI">Visa</option>
                                                                            <option value="MC">MasterCard</option>
                                                                            <option value="DI">Discover</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">

                                                                        <input id="ccardname" name="ccardname" type="text" placeholder="Name On Card*" class="form-control" data-required="true" />
                                                                    </div>
                                                                    <div class="form-group">

                                                                        <input id="ccardnum" name="ccardnum" type="text" placeholder="Card Number*" maxlength="20" class="form-control" data-required="true">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="styled-select-med">
                                                                            <input id="experition_date" name="experition_date" type="text" placeholder="Expiration Date*" maxlength="4" class="form-control2 monthPicker" data-required="true">
                                                                        </div>
                                                                        <div class="styled-select-med">
                                                                            <input id="cvv2" name="cvv2" type="password" placeholder="CVV Code*" maxlength="4" class="form-control2" data-required="true"> 
                                                                        </div>
                                                                        <!--<div class="styled-select-med">
                                                                        <select id="ccardexpmonth" name="ccardexpmonth" class="form-control2" data-required="true">
                                                                            <option value="">--Month--</option>
                                                                            <option value="01">01</option>
                                                                            <option value="02">02</option>
                                                                            <option value="03">03</option>
                                                                            <option value="04">04</option>
                                                                            <option value="05">05</option>
                                                                            <option value="06">06</option>
                                                                            <option value="07">07</option>
                                                                            <option value="08">08</option>
                                                                            <option value="09">09</option>
                                                                            <option value="10">10</option>
                                                                            <option value="11">11</option>
                                                                            <option value="12">12</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="styled-select-med">
                                                                        <select id="ccardexpyear"  data-required="true" name="ccardexpyear"  class="form-control2">
                                                                            <option value="">--Year--</option>
                                                                            <option value="15">2015</option>
                                                                            <option value="16">2016</option>
                                                                            <option value="17">2017</option>
                                                                            <option value="18">2018</option>
                                                                            <option value="19">2019</option>
                                                                            <option value="20">2020</option>
                                                                            <option value="21">2021</option>
                                                                            <option value="22">2022</option>
                                                                            <option value="23">2023</option>
                                                                            <option value="24">2024</option>
                                                                            <option value="25">2025</option>
                                                                            <option value="26">2026</option>
                                                                            <option value="27">2027</option>
                                                                            <option value="28">2028</option>
                                                                            <option value="29">2029</option>
                                                                            <option value="30">2030</option>
                                                                        </select>
                                                                    </div> -->
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div>
                                                                <label for="acceptTerms" class="checkbox inline checkbox2">
                                                                    <input id="acceptTerms" name="acceptTerms" type="checkbox" data-required="true" >
                                                                        I agree with the Terms and Conditions.</label>
                                                            </div>
                                                        </fieldset>
                                                        </form>
                                                        </div>
                                                        <div style="width:27%; float:right">
                                                            <div class="security"> This website is secure. Your personal details are safe. <a target="_blank" href="/static/checkout/vbv_toolkit/service_desc_popup.htm">

                                                                    <a target="_blank" href="https://www.export.gov/safeharbor"></a><br />

                                                                    <img src="<?php echo $vpath ?>images/security.png" style="margin:0 auto; width:154px; display:block;" />
                                                                    <div class="clear"></div>
                                                            </div>
                                                            <div class="global-options">
                                                                <label for="lang">Change Language</label>
                                                                <select id="lang" name="lang">
                                                                    <option value="en" selected="">English</option>
                                                                    <option value="es_ib" disabled="disabled">Spanish (European) - Español</option>
                                                                    <option value="es_la" disabled="disabled">Spanish (Latin) - Español</option>
                                                                    <option value="fr" disabled="disabled">French - Français</option>
                                                                    <option value="ja" disabled="disabled">Japanese - 日本語</option>
                                                                    <option value="de" disabled="disabled">German - Deutsch</option>
                                                                    <option value="it" disabled="disabled">Italian - Italiano</option>
                                                                    <option value="nl" disabled="disabled">Dutch - Nederlands</option>
                                                                    <option value="pt" disabled="disabled">Portuguese - Português</option>
                                                                    <option value="el" disabled="disabled">Greek - Ελληνική</option>
                                                                    <option value="sv" disabled="disabled">Swedish - Svenska</option>
                                                                    <option value="zh" disabled="disabled">Chinese (Traditional) - 語言名稱</option>
                                                                    <option value="sl" disabled="disabled">Slovenian - Slovene</option>
                                                                    <option value="da" disabled="disabled">Danish - Dansk</option>
                                                                    <option value="no" disabled="disabled">Norwegian - Norsk</option>
                                                                </select>
                                                                <label for="tco_currency">Change Currency</label>
                                                                <select id="tco_currency" name="tco_currency">
                                                                    <option value="AED" disabled="disabled">AED - United Arab Emirates Dirham</option>
                                                                    <option value="ARS" disabled="disabled">ARS - Argentina Peso</option>
                                                                    <option value="AUD" disabled="disabled">AUD - Australian Dollar</option>
                                                                    <option value="BRL" disabled="disabled">BRL - Brazilian Real</option>
                                                                    <option value="CAD" disabled="disabled">CAD - Canadian Dollar</option>
                                                                    <option value="CHF" disabled="disabled">CHF - Swiss Franc</option>
                                                                    <option value="DKK" disabled="disabled">DKK - Danish Krone</option>
                                                                    <option value="EUR" disabled="disabled">EUR - Euro</option>
                                                                    <option value="GBP" disabled="disabled">GBP - British Pound</option>
                                                                    <option value="HKD" disabled="disabled">HKD - Hong Kong Dollar</option>
                                                                    <option value="ILS" disabled="disabled">ILS - Israeli New Shekel</option>
                                                                    <option value="INR" disabled="disabled">INR - Indian Rupee</option>

                                                                    <option value="MXN" disabled="disabled">MXN - Mexican Peso</option>
                                                                    <option value="MYR" disabled="disabled">MYR - Malaysian Ringgit</option>
                                                                    <option value="NOK" disabled="disabled">NOK - Norwegian Krone</option>
                                                                    <option value="NZD" disabled="disabled">NZD - New Zealand Dollar</option>
                                                                    <option value="PHP" disabled="disabled">PHP - Philippine Peso</option>
                                                                    <option value="RON" disabled="disabled">RON - Romanian New Leu</option>
                                                                    <option value="RUB" disabled="disabled">RUB - Russian Ruble</option>
                                                                    <option value="SEK" disabled="disabled">SEK - Swedish Krona</option>
                                                                    <option value="SGD" disabled="disabled">SGD - Singapore Dollar</option>
                                                                    <option value="TRY" disabled="disabled">TRY - Turkish Lira</option>
                                                                    <option value="USD" selected="selected">USD - U.S. Dollar</option>
                                                                    <option value="ZAR" disabled="disabled">ZAR - South African Rand</option>
                                                                </select>
                                                                <button type="submit" class="btn btn-success" style="padding: 0 !important;width: 68px; margin-left: 25%"> Update</button>
                                                                <div class="clear"></div>
                                                            </div>
                                                            <div class="questions">
                                                                <div class="summary">
                                                                    <h3>Cart Summary</h3>
                                                                    <table class="summary-table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="item">All Items</td>
                                                                                <td class="price"><span class="purchase_display_currency">$</span><?php echo $product['price']; ?> *</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="left" colspan="2" valign="top"> <p> *Before service charges and taxes.</p></td>                                
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="summary-total">
                                                                        <div class="total-label">Total (USD)</div>
                                                                        <div class="total-price"><span class="purchase_display_currency">$</span><?php echo $product['price']; ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                        </div>



                                                        <script>
                                                            $(document).ready(function() {


                                                                var FULL_BASE_URL = $('#hidden_site_baseurl').val(); // For base path of value;
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
                                                                
                                                                $('#rzip').change(function() {
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


                                                                $("#shipping_chk").bind('click', function() {
                                                                    var fullName = $('#rname').val();

                                                                    if ($(this).is(":checked")) {
                                                                        $("#cfirstname").val(fullName.split(' ').slice(0, -1).join(' '));
                                                                        $("#clastname").val(fullName.split(' ').slice(-1).join(' '));
                                                                        $("#caddress1").val($('#raddress1').val());
                                                                        $("#caddress2").val($('#raddress2').val());
                                                                        $("#ccity").val($('#rcity').val());
                                                                        $("#cstate").val($('#rstate').val());
                                                                        $("#ccountry").val($('#rcountry').val());
                                                                        $("#czip").val($('#rzip').val());
                                                                        $("#cphone").val($('#rphone').val());

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
                                                                        $("#cphone").val('');

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
                                                                $('.btn-default').click(function(){
                                                                  // alert('df');
                                                                   //return false;
                                                                });
                                                                
                                                            });
                                                        </script>
                                                        </body>
                                                        </html>
