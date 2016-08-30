<?php
$email_message = '';
$clastname=$_POST['clastname'];
$cfirstname=$_POST['cfirstname'];
$caddress1=$_POST['caddress1'];
$caddress2=$_POST['caddress2'];
$cemail=$_POST['cemail'];
$ccity=$_POST['ccity'];
$cstate=$_POST['cstate'];
$ccountry=$_POST['ccountry'];
$czip=$_POST['czip'];
$phone_code=$_POST['phone_code'];
$cphone=$_POST['cphone'];


$email_message .="<b>BILLING DETAILS -</b> <br><br>";
$email_message .="Name - " . $cfirstname . " " . $clastname . "<br>";
$email_message .="Address1 - " . $caddress1 . "<br>";
$email_message .="Address2 - " . $caddress2 . "<br>";
$email_message .="Email - " . $cemail . "<br>";
$email_message .="City - " . $ccity . "<br>";
$email_message .="State - " . $cstate . "<br>";
$email_message .="Country - " . $ccountry . "<br>";
$email_message .="Zip Code - " . $czip . "<br>";
$email_message .="Phone - " . $phone_code . ' ' . $cphone . "<br><br>";

$subj = 'BILLING PAGE ACCESS';
$to = 'flowerwyz@gmail.com';

$headers = "From: admin@flowerwyz.com \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

mail($to, $subj, $email_message, $headers);