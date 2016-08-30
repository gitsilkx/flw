<?php
include("include/header.php");
ob_start();
$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
if (isset($_REQUEST['submit'])) {

    //$from = 'admin@flowerwyz.com';
    $to = 'flowerwyz@gmail.com';
    $to = 'biswa.mee@gmail.com';
    $subject = 'Contact Page';
	$body ="<b>CONTACT DETAILS-</b><br><br/>";
    $body .= "Name - " . $_REQUEST['fname'].' '. $_REQUEST['lname'] . "\n<br/>";
    $body.="Email - " . $_REQUEST['email'] . "\n<br/>";
    $body.="Phone - " . $_REQUEST['phone'] . "\n<br/>";
    $body.="Subject - " . $_REQUEST['title'] . "\n<br/>";
    $body.="Message - " . $_REQUEST['message'] . "\n<br/><br/>";
	$ua = getBrowser();
    $body .="<b>LOGISTICS-</b><br><br/>";    
    $body .="IP - " . $ip . "<br>";
    $body .="Country - " . $details->country . "<br>";
    $body .="State - " . $details->region . "<br>";
    $body .="City - " . $details->city . "<br>";
    $a =  date('m/d/Y H:i:s');
    $date = new DateTime($a, new DateTimeZone('America/New_York'));
	$body .="Timestamp - " . date("m/d/Y h:iA", $date->format('U')) . "<br>";
    $body .="Device - " . userAgent($_SERVER['HTTP_USER_AGENT']) . "<br>";
    $body .="Browser - " . $ua['name'];
	
    $header = "From: " . $from . "\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail($to, $subject, $body, $header);

    $msg = "Your message has been successfully submitted.";
}

?>

<style>
    address {
        display: block;
        margin-bottom: 20px;
        font-style: normal;
        line-height: 1.42857;
    }
    address .addres_name {
        font-size: 20px;
        line-height: 24px;
        margin-bottom: 6px;
    }
    address p {
        margin: 0px;
        font: 300 15px/18px "Roboto",sans-serif;
    }
    .sepH_b {
        margin-bottom: 12px;
    }
    address p + p {
        margin-top: 6px;
    }
    .heading_b {
        font: 300 16px/18px "Roboto",sans-serif;
        margin: 0px 0px 16px;
        text-transform: uppercase;
        position: relative;
    }
    .heading_b span {
        display: inline-block;
        background: #FFF none repeat scroll 0% 0%;
        position: relative;
        z-index: 10;
        padding-right: 10px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .col-sm-5 {
        width: 27.667%;
        float: left;
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 37px;
        margin-top:24px;
    }
    .col-sm-7 {
        width: 58.3333%;
        float: left;
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }
    .col-sm-4 {
        width: 43.333%;
        float: left;
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }
    .col-sm-12 {
        width: 100%;
        float: left;
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }
    #contact_description {
        width: 90%;
        margin-left:10px;
		font-family:Lato,sans-serif;
    }
    .col-sm-12 .form-control{
        width: 92%;
    }
    input.form-control {
        font-size: 14px;
        padding: 5px;
        border: thin solid #CCC;
        height: 22px;
        line-height: 34px;
        margin: 0px 0px 20px 10px;
        width: 100%;
    }
    .btn-primary{
        margin-left: 26px;
    }
    .row {
        margin-right: 22px;
        margin-left: -7px;
        margin-bottom: 10px;
    }
    .panel {
        background-color: #FFF;
        border: 1px solid transparent;
        border-radius: 0px;
        box-shadow: none;
    }
    .panel-default {
        border-color: #D3D3D3;
    }
    .panel-body-narrow {
        padding: 8px;
    }
    .success{
        font-size: 14px;
        color: green;
		margin-left:18px;
    }
</style>




<div class="innerWrap">         
    <div class="row-fluid">

        <div class="Content" id="section">
            <section class="container clearfix main_section">
                <div id="main_content_outer" class="clearfix">
                    <div id="main_content">

                        <!-- main content -->
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="panel panel-default">
                                    <div class="panel-body-narrow">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.876107984586!2d-74.00225498524391!3d40.742751579328555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259bc740ee057%3A0x82c8ac0a773f9b1f!2s290+W+19th+St%2C+New+York%2C+NY+10011%2C+USA!5e0!3m2!1sen!2sin!4v1448870738531" style="border:0" allowfullscreen="" frameborder="0" height="300" width="100%"></iframe>
                                        <!--<div id="gmap_contact_page" style="height:300px;width:100%"></div>-->
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <address>
                                    <p class="addres_name">FlowerWyz Center</p>
                                    <p>290 W 19th Street</p>
                                    <p>Chelsea, New York</p>
                                    <p class="sepH_b">NY 10010</p>                                    
                                    <p><span class="text-muted">E-mail:</span> <a href="mailto:info@flowerwyz.com">info@flowerwyz.com</a></p>
                                </address>
                            </div>
                            <div class="col-sm-7">
                                 <p class="heading_b">                                    
                                     <span class='success'><?php if($msg) echo  "<br>".$msg;?></span></p>
                                <form name='contact' method="post" action=''>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="text" name='fname' placeholder="First Name" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" name='lname' placeholder="Last Name" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" name='email' placeholder="Your Email" class="form-control">
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="text" name='phone' placeholder="Your Phone" class="form-control">
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" name='title' placeholder="Subject" class="form-control">
                                            </div>
                                            <div class="col-sm-12">
                                                <textarea name="message" id="contact_description" cols="30" rows="4" class="form-control" placeholder="Description"></textarea>
                                            </div>
                                            <input type="submit" name='submit' value='Send' class='btn btn-primary' style='margin-left: 25px;'>
                                <!--<button class="btn btn-primary"><span class="icon-envelope"></span> Send</button>-->
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            </section>
        </div>
    </div>
</div>




<!--[if lte IE 9]>
        <script src="js/ie/jquery.placeholder.js"></script>
        <script>
                $(function() {
                        $('input, textarea').placeholder();
                });
        </script>
<![endif]-->

<?php include("include/footer.php"); ?>
