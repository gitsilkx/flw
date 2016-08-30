<?  include("configs/path.php");
$cnt1=@mysql_fetch_array(mysql_query("select sum(qty) as cnt, sum(total) as ntotals  from " . $prev . "cart where   OrderID='" . GetCartId() . "'"));
  if($cnt1[cnt]>0){
  $cnt=$cnt1[cnt];
   $totp=$cnt1[ntotals];
  }else{
$cnt=0;
 $totp=0.00; 
  }
echo '<input type="hidden" name="cntn" id="cntn" value="'.$cnt.'"/>';
echo '<input type="hidden" name="totals" id="totals" value="'.$totp.'"/>';
?>
