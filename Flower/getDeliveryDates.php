<?php
include("configs/path.php");
include("getProducts.php");

$strZipCode = $_REQUEST['zip_code'];

$ins->getDeliveryDates(API_USER, API_PASSWORD, $strZipCode);

?>
<option value="">Delivery Date *</option>
<?php
foreach($ins->arrDates as $key => $val){
    $date_array = explode("T",$val);
    echo '<option value="'.$val.'">'.date('l, jS F Y',  strtotime($date_array[0])).'</option>';
}
?>
