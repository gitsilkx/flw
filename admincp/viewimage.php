<?php 
include "image.class.php";
if(!file_exists($_GET['img'])){$_GET['img']="uploads/nopic.jpg";}
$image = new thumbnail($_GET['img']);

if(!empty($_GET['size'])){$size=(int) $_GET['size'];}else{$size=500;}
if(!empty($_GET['size_h'])){$size_h=(int) $_GET['size_h'];}else{$size_h=500;}
if($_REQUEST[width]):
	$image->size_width($_REQUEST[width]);   
endif;
if($_REQUEST[height]):
	$image->size_height($size); 
endif;
if($_REQUEST[size]):
	$image->size_height($size); 
endif;
//$image->size_auto($size);   
//$image->size_crop($size);    
if($_REQUEST[width] && $_REQUEST[height]):
	$image->size_width_height($size,$size_h);
endif;	
if($_GET['add_logo']==1)
{ 
	$image->add_logo("images/logo.png"); 
}
$image->show();

?>