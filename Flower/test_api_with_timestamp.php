<?php
include("configs/path.php");
include("getProducts.php");

$strZipCode = '10011';
$API_USER = '';
$API_PASSWORD = '';


if (isset($_POST['save'])) {

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
    $cstate = $_POST['cstate'];
    $czip = $_POST['czip'];
    $ccardnum = $_POST['ccardnum'];
    $cvv2 = $_POST['cvv2'];
    $ccardtype = $_POST['ccardtype'];
    $ccardname = $_POST['ccardname'];
    $rinstructions = $_POST['rinstructions'];
    $renclosure = $_POST['renclosure'];
    $orderTotal = '72.94';

    $product = $ins->getProduct(API_USER, API_PASSWORD, $itemCode);
    $arrProducts = array(
        0 =>
        array(
            "code" => $product['code'],
            "price" => $product['price']
        ),
    );

    $arrRecipient = array("address1" => $raddress1, "address2" => $raddress2, "city" => $rcity, "country" => $rcountry, "email" => $cemail, "institution" => $rattention, "name" => $rfirstname . ' ' . $rlastname, "phone" => $rphone, "state" => $rstate, "zip" => $rzip);
    $arrCustomer = array("address1" => $caddress1, "address2" => $caddress2, "city" => $ccity, "country" => $ccountry, "email" => $cemail, "institution" => $rattention, "name" => $cfirstname . ' ' . $clastname, "phone" => $cphone, "state" => $cstate, "zip" => $czip);
    $customerIP = $ip;
    $cardMsg = trim($renclosure); //ccNum->CreditCard Number
        $specialInstructions = trim($rinstructions);
        //$deliveryDate = $deliverydate . 'T' . date('H:i:s') . 'Z'; //"2015-04-29T05:00:00.000Z"; //you can get this value from getDeliveryDates() call... the value must be dateTime format eg: 2011-01-15T05:00:00.000Z
        $affiliateServiceCharge = "0";
        $affiliateTax = "0";
    // $customerIP = '127.127.127.127';
    //$arrCCInfo = array("ccExpMonth"=>11,"ccExpYear"=>18,"ccNum"=>"4445999922225","ccSecCode"=>"999","ccType"=>"VI");$cardMsg = "I LOVE YOU LETISHA!!"; //ccNum->CreditCard Number
    $arrCCInfo = array("ccExpMonth" => $ccExpMonth, "ccExpYear" => $ccExpYear, "ccNum" => $ccardnum, "ccSecCode" => $cvv2, "ccType" => $ccardtype);


    $ins->placeOrder(API_USER, API_PASSWORD, $arrRecipient, $arrCustomer, $customerIP, $arrCCInfo, $arrProducts, $cardMsg, $specialInstructions, $deliverydate, $affiliateServiceCharge, $affiliateTax, $orderTotal, $subAffiliateID); //return value stored in $this->arrOrder

    echo '<br><br>Sending Information<br>';
    print_r($_POST);
    echo '<br><br>Receiving Information<br>';
    print_r($ins->arrOrder);
}

$ins->getDeliveryDates(API_USER, API_PASSWORD, $strZipCode);
?>

<form class="cmxform" id="cmxform" method="post" action="">
    <input type="hidden" name='itemCode' id="itemCode" value="B16-4830">
    <input type="hidden" name='action_type' id="ActionType" value="0">

    <input type="hidden" name='save' value="Continue" >
    <input type="hidden" name='hidden_site_baseurl' id="hidden_site_baseurl" value="<?php echo $vpath; ?>">


    <div class="panel panel-default accord-container" style="border-radius:0px; margin-top:-1px;">
        <div class="panel-heading" id="accorHeadTwo"><span class="label label-dark">2</span>Recipient Information</div>
        <div class="panel-body" id="accorBodyTwo">
            <fieldset data-step="1">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form_sep">

                            <input id="rfirstname" name="rfirstname" placeholder="First Name*" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form_sep">

                            <input id="rlastname" name="rlastname" placeholder="Last Name*" type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form_sep">

                            <input id="rattention" name="rattention" placeholder="Institution" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form_sep">

                            <input id="rphone" name="rphone" type="text" placeholder="Phone*" class="form-control" onKeyUp="formatPhone(this);" onBlur="validatePhone(this.value)" maxlength="14" autocomplete="off">
                            <p for="rphone" class="warning" id="val-rphone-error"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form_sep">

                            <input id="raddress1" name="raddress1" type="text" placeholder="Address*" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form_sep">

                            <input id="raddress2" name="raddress2" type="text" placeholder="Address 2" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form_sep cust-select">

                            <select id="rcountry" onChange="this.className = this.options[this.selectedIndex].className" class="greenText" name="rcountry">
                                <option value="" class="first_option">--Select Country*--</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form_sep cust-select">

                            <select class="greenText" id="rstate"  name="rstate">
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

                            <input id="rcity" name="rcity" type="text" placeholder="City*" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form_sep">

                            <input id="rzip" name="rzip" type="text" placeholder="Zip Code*" class="form-control">
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-sm-12">
                        <div class="form_sep">
                            <label class="req">Message On Card</label>
                            <textarea id="renclosure" class="form-control" rows="3" name="renclosure" maxlength="200" placeholder="Please enter your personalized message here. Don't forget to add your name."></textarea>
                        </div>
                        <div class="form_sep">
                            <label>Special Delivery Instructions</label>
                            <textarea id="rinstructions" class="form-control" rows="3" name="rinstructions" placeholder="If you have specific instructions for our delivery team, you may add them here." maxlength="200"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form_sep cust-select">
                               <!-- <input type="text" name="deliverydate" id="datepicker"  data-required="true" placeholder="Select Delivery Date*" class="form-control" />-->
                            <select name="deliverydate" id="deliverydate">
                                <option value="">Select Delivery Date *</option>
                                <?php
                                foreach ($ins->arrDates as $key => $val) {
                                    $date_array = explode("T", $val);
                                    //echo date('Y-m-d', strtotime($date_array[0])) . "<br>";
                                    echo '<option value="' . $val . '">' . date('l, jS F Y', strtotime($date_array[0])) . '</option>';
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>


        </div>
    </div>

    <div class="panel panel-default accord-container" style="border-radius:0px; margin-top:-1px;">
        <div class="panel-heading" id="accorHeadThree"><span class="label label-dark">3</span>Billing Information</div>
        <div class="panel-body" id="accorBodyThree">
            <fieldset data-step="2">

                <div class="row">

                    <div class="col-sm-6">
                        <div class="form_sep">

                            <input id="cfirstname" name="cfirstname" placeholder="First Name*" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form_sep">

                            <input id="clastname" name="clastname" type="text" placeholder="Last name*" class="form-control" data-minlength="3">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form_sep">

                            <input id="caddress1" name="caddress1" type="text" placeholder="Address*" class="form-control">
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
                            <select onChange="this.className = this.options[this.selectedIndex].className"
                                    class="greenText" id="ccountry" name="ccountry">

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
                                                                              <!--  <select id="ccountry" name="ccountry">
                                                                                    <option value="">--Select Country*--</option>
                                                                                    <option value="US">United States</option>
                                                                                    <option value="CA">Canada</option>
                                                                                </select>-->
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form_sep cust-select">

                            <select onChange="this.className = this.options[this.selectedIndex].className"
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

                            <input id="ccity" name="ccity" type="text" placeholder="City*" class="form-control" >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form_sep">

                            <input id="czip" name="czip" type="text" placeholder="Zip Code*" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form_sep">

                            <input id="cphone" name="cphone" placeholder="Phone*" type="text" onKeyUp="formatPhone(this);" onBlur="validateCPhone(this.value)"  maxlength="14" class="form-control" autocomplete="off">
                            <p for="cphone" class="warning" id="val-cphone-error"></p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form_sep">

                            <input id="cemail" name="cemail"  placeholder="Email*" class="form-control"  type="email">
                        </div>
                    </div>
                </div>

            </fieldset>

        </div>
    </div>

    <div class="panel panel-default accord-container" style="border-radius:0px; margin-top:-1px;">
        <div class="panel-heading" id="accorHeadFour"><span class="label label-dark">4</span>Payment Methods</div>
        <div class="panel-body" id="accorBodyFour">
            <fieldset data-step="3">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="step_info">
                            <h4>Payment Methods</h4>


                            <div class="form-group cust-select">

                                <select onChange="this.className = this.options[this.selectedIndex].className" class="greenText" id="ccardtype" name="ccardtype" >
                                    <option value="" selected="selected">--Select Card*--</option>
                                    <option value="AX">American Express</option>
                                    <option value="VI">Visa</option>
                                    <option value="MC">MasterCard</option>
                                    <option value="DI">Discover</option>
                                </select>
                            </div>
                            <div class="form-group">

                                <input id="ccardname" name="ccardname" type="text" placeholder="Name On Card*" class="form-control" />
                            </div>
                            <div class="form-group">

                                <input id="ccardnum" name="ccardnum" onKeyPress="masking(this.value, this, event);" onBlur="validateCard(this.value)" type="text" placeholder="Card Number*" maxlength="19" class="form-control">
                                <p class="warning" id="Vali-ccardnum-error"></p>
                            </div>
                            <div class="form-group">
                                <div style="width:52%; float:left;">
                                    <input id="experition_date" name="experition_date" type="text" autocomplete="off" placeholder="Expiration Date*" class="form-control monthPicker">
                                </div>

                                <div style="width:46%; float:right;">
                                    <input id="cvv2" name="cvv2" type="password" placeholder="CVV Code*" maxlength="4" class="form-control">
                                </div>

                            </div>

                        </div>

                    </div>

            </fieldset>
            <input type="submit" name="save" id="finalPay" class="green-btn pull-right" style="margin-top:10px; width:200px;" value="save" />
        </div>
    </div>
</form>
