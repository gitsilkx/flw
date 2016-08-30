<?php
session_start();

ini_set('display_errors', 'On');
include("configs/path.php");
include("getProducts.php");

$strCategory = 'apop';
$intProductCount = '1000';
$intStart = '1';
$start_time = date('Y-m-d H:i:s');
$message = "*********************** CRON STARTS [".$start_time."] ***********************<br><br>";
$message1 ="";
$message12="";

$ins->getProductDetails(API_USER, API_PASSWORD, $strCategory, $intProductCount, $intStart);


$message .= "STEP:1 [TAKE INITIAL COUNTS]<br><br>";

$result = mysql_query("SELECT COUNT(id) `prv_totalrow` FROM ".TABLE_PRODUCT); //Count from local API dynamic data
$row=mysql_fetch_array($result);
$prev_totalrow=$row['prv_totalrow'];
mysql_free_result($result);

$r=mysql_query("insert into " . TABLE_LOG." set cron_start_time='".$start_time."',previous_product_cnt='".$prev_totalrow."'");  //Insert value to logo table
$last_id = mysql_insert_id();
mysql_free_result($r);


$result = mysql_query("SELECT COUNT(id) `cnt` FROM ".TABLE_IMAGE); //Count from local static data
$row=mysql_fetch_array($result);
$image_count=$row['cnt'];
mysql_free_result($result);

$result = mysql_query("SELECT COUNT(id) `cnt` FROM ".TABLE_DELETE_PRODUCT); //Count from local dynamic [Deleted] data
$row=mysql_fetch_array($result);
$dynamic_delete_count=$row['cnt'];
mysql_free_result($result);

$result = mysql_query("SELECT COUNT(id) `cnt` FROM ".TABLE_STATIC_DELETE_PRODUCT); //Count from local static [Deleted] data
$row=mysql_fetch_array($result);
$static_delete_count=$row['cnt'];
mysql_free_result($result);

$result = mysql_query("SELECT COUNT(id) `cnt` FROM ".TABLE_ADD_PRODUCT); //Count from local dynamic [Added] data
$row=mysql_fetch_array($result);
$dynamic_add_count=$row['cnt'];
mysql_free_result($result);

$result = mysql_query("SELECT COUNT(id) `cnt` FROM ".TABLE_STATIC_ADD_PRODUCT); //Count from local static [Added] data
$row=mysql_fetch_array($result);
$static_add_count=$row['cnt'];
mysql_free_result($result);


if (isset($ins->arrProducts) && count($ins->arrProducts) > 0):

    $result = mysql_query("SELECT `code` FROM ".TABLE_IMAGE); // step3
    $image_cnt = mysql_num_rows($result);
    while($row = mysql_fetch_array($result)){
        $code[] = $row['code'];
    }
    mysql_free_result($result);
    
    $message1 .="a) Start Truncate local API dynamic data ".date('Y-m-d H:i:s')."<br>";
    mysql_query("TRUNCATE TABLE ".TABLE_PRODUCT); //step 4
    $message1 .="b) End Truncate local API dynamic data ".date('Y-m-d H:i:s')."<br>";
    $message1 .="c) Start Insert local API dynamic data ".date('Y-m-d H:i:s')."<br>";
    $message12 .="e) Start Truncate local dynamic [Deleted] data ".date('Y-m-d H:i:s')."<br>";
    mysql_query("TRUNCATE TABLE ".TABLE_DELETE_PRODUCT); //step 4
    $message12 .="f) End Truncate local dynamic [Deleted] data ".date('Y-m-d H:i:s')."<br>";
    $message12 .="g) Start Truncate local dynamic [Added] data ".date('Y-m-d H:i:s')."<br>";
    mysql_query("TRUNCATE TABLE ".TABLE_ADD_PRODUCT); //step 4
    $message12 .="h) End Truncate local dynamic [Added] data ".date('Y-m-d H:i:s')."<br>";
   
    $i= 0 ;
     foreach ($ins->arrProducts as $product):
    if($product['code']<>''){
        $r=mysql_query("insert into " . TABLE_PRODUCT." set name='".mysql_escape_string(trim($product['name']))."',product_no='".$product['code']."',image='".$product['image']."',description='".mysql_escape_string(trim($product['description']))."',thumb_image='".$product['thumbnail']."',price='".$product['price']."',category='".strtolower($product['productType'])."'");  //step 5
        if (!in_array($product['code'], $code)) {
            $r=mysql_query("insert into " . TABLE_ADD_PRODUCT." set name='".mysql_escape_string(trim($product['name']))."',product_no='".$product['code']."',image='".$product['image']."',description='".mysql_escape_string(trim($product['description']))."',thumb_image='".$product['thumbnail']."',price='".$product['price']."',category='".strtolower($product['productType'])."'");  //step 6
        }
        
        $i++; //Count from foreign API data
    }
    endforeach;
    $message1 .="d) End Insert local API dynamic data ".date('Y-m-d H:i:s')."<br>";
    
    $message .="a) Count from foreign API data: ".$i."<br>";
    $message .="b) Count from local API dynamic data: ".$prev_totalrow."<br>";
    $message .="c) Count from local static data: ".$image_count."<br>";
    $message .="d) Count from local static [Deleted] data: ".$static_delete_count."<br>";
    $message .="e) Count from local dynamic [Deleted] data: ".$dynamic_delete_count."<br>";
    $message .="f) Count from local static [Added] data: ".$static_add_count."<br>";
    $message .="g) Count from local dynamic [Added] data: ".$dynamic_add_count."<br>";
    $message .="h) Mismatched volume since last Cron [a - b] = ".($i - $prev_totalrow)."<br>";
    $message .="i) Mismatched volume since last Cron [a - c] = ".($i - $image_count)."<br><br>";
    $message .= "Moving on to Step 2 [".date('Y-m-d H:i:s')."]"."<br><br>";
    $message .="STEP:2 [TRUNCATE/REFILL LOCAL API DYNAMIC/DELETED/ADDED DATA]"."<br><br>";

    $result = mysql_query("SELECT d.* FROM ".TABLE_IMAGE." as d left JOIN ".TABLE_PRODUCT." as e ON e.product_no = d.code WHERE e.product_no IS null OR d.code IS null");
    while($row = mysql_fetch_array($result)){
       
            mysql_query("insert into " . TABLE_DELETE_PRODUCT." set code='".$row['code']."',type='".$row['type']."',imageurl='".mysql_escape_string(trim($row['imageurl']))."',flowerurl='".mysql_escape_string(trim($row['flowerurl']))."',flower_name='".mysql_escape_string(trim($row['flower_name']))."'
                        ,exotic='" . $row['exotic'] . "',shop='" . $row['shop'] . "',flower_order='" . $row['flower_order'] . "',easter='" . $row['easter'] . "'
                        ,thank_you='" . $row['thank_you'] . "',romance='" . $row['romance'] . "',christmas='" . $row['christmas'] . "',new_baby='" . $row['new_baby'] . "'
                        ,common='" . $row['common'] . "',today='" . $row['today'] . "',tomorrow='" . $row['tomorrow'] . "',arrangements='" . $row['arrangements'] . "'
                        ,plants='" . $row['plants'] . "',bouquets='" . $row['bouquets'] . "',deals='" . $row['deals'] . "',anniversary='" . $row['anniversary'] . "'
                        ,birthday='" . $row['birthday'] . "',funerals='" . $row['funerals'] . "',mothers_day='" . $row['mothers_day'] . "',sympathy='" . $row['sympathy'] . "',valentines_day='" . $row['valentines_day'] . "'
                        ,wedding='" . $row['wedding'] . "',get_well='" . $row['get_well'] . "',roses='" . $row['roses'] . "',centerprices='" . $row['centerprices'] . "',funeral_casket_sprays='" . $row['funeral_casket_sprays'] . "'
                         ,funeral_plants='" . $row['funeral_plants'] . "',funeral_wreaths='" . $row['funeral_wreaths'] . "',funeral_sprays='" . $row['funeral_sprays'] . "',funeral_baskets='" . $row['funeral_baskets'] . "'");
            mysql_query("UPDATE " . TABLE_IMAGE." set status='n' WHERE id=".$row['id']); 
    }
    $result = mysql_query("SELECT COUNT(id) `cnt` FROM ".TABLE_DELETE_PRODUCT); //Count from local dynamic [Deleted] data
    $row=mysql_fetch_array($result);
    $dynamic_delete_count=$row['cnt'];
    mysql_free_result($result);
    
    $result = mysql_query("SELECT COUNT(id) `cnt` FROM ".TABLE_ADD_PRODUCT); //Count from local dynamic [Added] data
    $row=mysql_fetch_array($result);
    $dynamic_add_count=$row['cnt'];
    mysql_free_result($result);
    
    
    $result = mysql_query("SELECT COUNT(id) `totalrow` FROM ".TABLE_PRODUCT);
    $row=mysql_fetch_array($result);
    $totalrow=$row['totalrow'];
    mysql_free_result($result);
    $message12 .="i) Count from local API dynamic data: ".$totalrow."<br>";
    $message12 .="i) Count from local Static data: ".$image_count."<br>";
    $message12 .="j) Count from local dynamic [Deleted] data: ".$dynamic_delete_count."<br>";
    $message12 .="k) Count from local dynamic [Deleted] data: ".$dynamic_add_count."<br><br>";
    
    $message12 .="Moving on to Step 3".date('Y-m-d H:i:s')."<br><br>";
    $message12 .="STEP:3 [UPDATE LOCAL STATIC DATA, INSERT DELETED DATA]"."<br><br>";
    $message12 .="a) Count of local static data untouched: ".$totalrow."<br>";
    $message12 .="b) Count of local static data de-activated: ".$dynamic_delete_count."<br>";
    $message12 .="c) Count of local static deleted data inserted: ".$static_delete_count."<br>";
    $message12 .="d) Count of local dynamic deleted data inserted: ".$dynamic_delete_count."<br>";
    $message12 .="e) Count of local static [Deleted] data: ".$static_delete_count."<br>";
    $message12 .="f) Count of local dynamic [Deleted] data: ".$dynamic_delete_count."<br><br>";
    $message12 .="Moving on to Step 4".date('Y-m-d H:i:s')."<br><br>";
    $message12 .="STEP:4 [UPDATE LOCAL STATIC DATA, INSERT ADDED DATA]"."<br><br>";
    $message12 .="a) Count of local API dynamic data: ".$totalrow."<br>";
    $message12 .="b) Count of local static added data inserted: ".$static_add_count."<br>";
    $message12 .="c) Count of local dynamic added data inserted: ".$dynamic_add_count."<br>";
    $message12 .="d) Count from local static [Deleted] data: ".$static_delete_count."<br>";
    $message12 .="e) Count from local dynamic [Deleted] data: ".$dynamic_delete_count."<br><br>";
    $message12 .="Moving on to Step 5".date('Y-m-d H:i:s')."<br><br>";
    $message12 .="STEP:5 [CREATE REPORTS AND TRUNCATE LOCAL DYNAMIC DELETED/ADDED DATA]"."<br><br>";
    $message12 .="a) TOTAL RECORDS DELETED TODAY: ".$dynamic_delete_count."<br>";
    $message12 .="b) Start Truncate local dynamic [Deleted] data ".date('Y-m-d H:i:s')."<br>";
    $message12 .="c) End Truncate local dynamic [Deleted] data ".date('Y-m-d H:i:s')."<br>";
    $message12 .="d) TOTAL RECORDS ADDED TODAY: ".$dynamic_add_count."<br>"; 
    $message12 .="e) Start Truncate local dynamic [Added] data ".date('Y-m-d H:i:s')."<br>";
    $message12 .="f) End Truncate local dynamic [Added] data ".date('Y-m-d H:i:s')."<br>";
    
 
    $data_output="";

    $result = mysql_query("SELECT * FROM ".TABLE_DELETE_PRODUCT); //Count from local dynamic [Deleted] data

    while ($row=mysql_fetch_array($result)){
        $data_output[]=$row['code'];
        $data_output[]=$row['type'];
        $data_output[]=$row['flower_name'];
        $data_output[]=$row['imageurl'];
        $data_output[]=$row['flowerurl'];
        $data_output[]=$row['exotic'];
        $data_output[]=$row['shop'];
        $data_output[]=$row['flower_order'];
        $data_output[]=$row['easter'];
        $data_output[]=$row['thank_you'];
        $data_output[]=$row['romance'];
        $data_output[]=$row['christmas'];
        $data_output[]=$row['new_baby'];
        $data_output[]=$row['common'];
        $data_output[]=$row['today'];
        $data_output[]=$row['tomorrow'];
        $data_output[]=$row['arrangements'];
        $data_output[]=$row['plants'];
        $data_output[]=$row['bouquets'];
        $data_output[]=$row['deals'];
        $data_output[]=$row['anniversary'];
        $data_output[]=$row['birthday'];
        $data_output[]=$row['funerals'];
        $data_output[]=$row['mothers_day'];
        $data_output[]=$row['sympathy'];
        $data_output[]=$row['valentines_day'];
        $data_output[]=$row['wedding'];
        $data_output[]=$row['get_well'];
        $data_output[]=$row['roses'];
        $data_output[]=$row['centerprices'];
        $data_output[]=$row['funeral_casket_sprays'];
        $data_output[]=$row['funeral_plants'];
        $data_output[]=$row['funeral_wreaths'];
        $data_output[]=$row['funeral_sprays'];
        $data_output[]=$row['funeral_baskets'];
        $data_output[]=$row['created'].'</tr>';
     
    }
    mysql_free_result($result);
    $result = mysql_query("SELECT * FROM ".TABLE_ADD_PRODUCT); //Count from local dynamic [Deleted] data
    while ($row=mysql_fetch_array($result)){
        $data_output1[]=$row['product_no'];
        $data_output1[]=$row['name'];
        $data_output1[]=$row['category'];
        $data_output1[]=$row['price'];
        $data_output1[]=$row['image'];
        $data_output1[]=$row['thumb_image'];
        $data_output1[]=$row['description'];
        $data_output1[]=$row['created'].'</tr>';
    }
    mysql_free_result($result);
    
        include("excelwriter.inc.php");
        $file_path = "uploads/";
	$deletedFileName = "DELETED_".date('Y_m_d_H_i_s').".xls";
        $addedFileName = "ADDED_".date('Y_m_d_H_i_s').".xls";
	$excel = new ExcelWriter($file_path.$deletedFileName);
	$add_excel = new ExcelWriter($file_path.$addedFileName);
	if($excel==false)	
	{
		echo $excel->error;
		die;
	}
	$myArr=array(
				"Product No",
                                "Type",
				"Name Of The Product",
				"Florist Image",
				"Flowerwyz Image",
                                "EXOTIC",
                                "SHOP",
                                "ORDER",
                                "EASTER",
                                "THANK YOU",
                                "ROMANCE",
                                "CHRISTMAS",
                                "NEW BABY",
                                "COMMON",
                                "TODAY",
                                "TOMORROW",
                                "ARRANGEMENTS",
                                "PLANTS",
                                "BOUQUETS",
                                "DEALS",
                                "ANNIVERSARY",
                                "BIRTHDAY",
                                "FUNERALS",
                                "MOTHERS DAY",
                                "SYMPATHY",
                                "VALENTINES DAY",
                                "WEDDING",
                                "GET WELL",
                                "ROSES",
                                "CENTERPIECES",
                                "FUNERAL CASKET SPRAYS",
                                "FUNERAL PLANTS",
                                "FUNERAL WREATHS",
                                "FUNERAL SPRAYS",
                                "FUNERAL BASKETS",
                                "CREATED"
				);
        $myAddedArr=array(
				"Product No",
				"Name Of The Product",
				"Category",
				"Price",
                                "Image",
                                "Thumb Image",
                                "Description",
                                "Created"
				);
	
	$excel->writeLine($myArr, array('text-align'=>'center', 'color'=> 'red'));
        $add_excel->writeLine($myAddedArr, array('text-align'=>'center', 'color'=> 'red'));

	$excel->writeLine($data_output);
	$add_excel->writeLine($data_output1);
	$excel->writeRow();
        $add_excel->writeRow();
	//$excel->writeCol("Alok");
	//$excel->writeCol("<span style='color:red;'>Sah</span>");
	//$excel->writeCol("Pandav Nagar", array('text-align'=>'center', 'color'=> 'green','font-size'=> '22px'));
	//$excel->writeCol(30,array('text-align'=>'right', 'color'=> 'brown'));
	
	
	$excel->close();
	
    
    
  
    $path = $vpath.'uploads/';
   // $mailto = 'flowerwyz@gmail.com';
    $mailto = 'biswajit.das801@gmail.com';
    $from_mail = 'admin@flowerwyz.com';
    $from_name = 'Flowerwyz';
    $replyto = 'admin@flowerwyz.com';
    $delete_subject = 'TOTAL RECORDS DELETED TODAY';
    $add_subject = 'TOTAL RECORDS ADDED TODAY';
    $delete_message = 'test';
    $add_message = 'test';
    mail_attachment($deletedFileName, $path, $mailto, $from_mail, $from_name, $replyto, $delete_subject, $delete_message);
    mail_attachment($addedFileName, $path, $mailto, $from_mail, $from_name, $replyto, $add_subject, $add_message);
 
    
    

    
    $message12 .= "Moving on to Step 6 [".date('Y-m-d H:i:s')."]"."<br><br>";
    $message12 .="STEP:6 [TAKE FINAL COUNTS AND FINISH CRON]"."<br><br>";
    $message12 .="a) Count from foreign API data: ".$i."<br>";
    $message12 .="b) Count from local API dynamic data: ".$prev_totalrow."<br>";
    $message12 .="c) Count from local static data: ".$image_count."<br>";
    $message12 .="d) Count from local static [Deleted] data: ".$static_delete_count."<br>";
    $message12 .="e) Count from local dynamic [Deleted] data: ".$dynamic_delete_count."<br>";
    $message12 .="f) Count from local static [Added] data: ".$static_add_count."<br>";
    $message12 .="g) Count from local dynamic [Added] data: ".$dynamic_add_count."<br>";
    $message12 .="h) Mismatched volume since last Cron [a - b] = ".($i - $prev_totalrow)."<br>";
    $message12 .="i) Mismatched volume since last Cron [a - c] = ".($i - $image_count)."<br><br>";
    $end_time = date('Y-m-d H:i:s');
    $message12 .="*********************** CRON ENDS - ".$end_time." ***********************";
    
    mysql_query("UPDATE " . TABLE_LOG." set flag=0 WHERE 1");
    $r=mysql_query("UPDATE " . TABLE_LOG." set current_product_cnt='".$totalrow."',cron_end_time='".$end_time."' WHERE id=".$last_id); 
    if($r)
         echo "<center><h3>Programm has been successfully run.</h3><br></center>";
    
    include('mpdf/mpdf.php');
	$mpdf=new mPDF();
	$mpdf->WriteHTML(stripslashes($message.$message1.$message12));
	$pdf_name="Log_".date('Y_m_d_H_i_s').".pdf";
	$mpdf->Output("uploads/".$pdf_name);
        
        $subject = "Log Report";
        $message = htmlspecialchars($message.$message1.$message12);
         mail_attachment($pdf_name, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message);
   // echo $message.$message1.$message12;
   
  else:  
      echo "<center><h3>Sorry!!! Due to connection problem.</h3><br></center>";  
endif;


?>

