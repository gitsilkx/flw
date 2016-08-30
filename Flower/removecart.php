<? include("configs/path.php");
$a=mysql_query("delete from ".$prev."cart where id='".$_POST[id]."' and OrderID='" . GetCartId()."'");
if($a){
echo 1;
}else{

echo 0;
}
?>
					