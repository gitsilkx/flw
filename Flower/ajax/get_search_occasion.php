<? 
require_once('../myconfig/config.php');
$q=$_GET[term];
$sql="select `id`,name,type_id from ".$prev."occasion where status='Y' and name like '%".$q."%' limit 10";

$no=0;

$mysql=mysql_query($sql);
while($a=@mysql_fetch_array($mysql)){	
	$array[$no]['value']=$a['id'];
	$array[$no]['label']=$a['name'];
	$array[$no]['desc']=$a['type_id'];
	$no++;
}
	
echo json_encode($array);
?>