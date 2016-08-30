<?php 
require_once("configs/path.php");
ini_set('display_errors', 'Off');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 


$result = mysql_query("SELECT id,flag FROM ".TABLE_LOG." WHERE 1 ORDER BY id DESC LIMIT 0,1");
$row=mysql_fetch_array($result);
if($_POST['flag']<>''){
    
    
    $r=mysql_query("UPDATE " . TABLE_LOG." set flag='".$_POST['flag']."' where id=".$row['id']); 
    if($r)
        echo 'Successfully change the value';
}
else{
    echo 'Please type value';
}
?>

<form name="switch" method="post">
<input type="text" name="flag" value='<?php echo $row['flag'];?>' />
<input type="submit" name="save" />
</form>
</body>
</html>
