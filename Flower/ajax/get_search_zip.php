<? 
require_once('../myconfig/config.php');
$q=$_GET[term];
$sql="select `zip_id`,zip_code from ".$prev."zip where status='Y' and zip_code like '%".$q."%' limit 10";

$no=0;

$mysql=mysql_query($sql);
while($a=@mysql_fetch_array($mysql)){	
	$array[$no]['value']=$a['zip_id'];
	$array[$no]['label']=$a['zip_code'];
	$array[$no]['desc']=$a['zip_code'];
	$no++;
}
	
echo json_encode($array);
?>