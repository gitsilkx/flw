<? 
require_once('../myconfig/config.php');
$q=$_GET[term];
$sql="select `rest_name` from ".$prev."restaurant where status='Y' and rest_name like '%".$q."%'";
$sql_menu="select `memu_name` from ".$prev."menu where status='Y' and `memu_name` like '%".$q."%'";

$no=0;
$array1=array();
$array2=array();
$mysql=mysql_query($sql);
$mysql_menu=mysql_query($sql_menu);
if(mysql_num_rows($mysql_menu)){
	while($b=@mysql_fetch_assoc($mysql_menu)){	
		$array1[]=$b['memu_name'];
	}
}
if(mysql_num_rows($mysql)){
	while($a=@mysql_fetch_assoc($mysql)){	
		$array2[]=$a['rest_name'];
	}
}
$array=array_merge_recursive($array1,$array2);

	
echo json_encode($array);
?>