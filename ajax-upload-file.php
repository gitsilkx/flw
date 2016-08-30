<?php
require_once("configs/path.php");


$num_images_uploaded = count( $_SESSION['main_temp_image_container'] );

if( !empty( $_POST['purpose'] ) && $_POST['purpose'] == 'edit' ) {
	$num_images_uploaded += count( $_SESSION['main_image_container'] );
}

if( $num_images_uploaded >= $pic_count ) {
	echo "Only $pic_count Free Images can be Uploaded.";
}
else {
	$old_file_name	= basename($_FILES['uploadfile']['name']);
	$exp__file_ext	= explode('.', $old_file_name);
	$file_ext		= strtolower( end( $exp__file_ext ) );
	$new_file_name	= time() . '.' . $file_ext;
	
	$uploaddir	= $datadir['temp_adpics'].'/';
	$file_path	= $uploaddir . $new_file_name;
	$file_size	= (int) ceil( $_FILES['uploadfile']['size'] / 1000 );
	
	
	if( ( $pic_maxsize - $file_size ) < 0 ) {
		echo "Image Size is greater than the allowed size of <em>$pic_maxsize KB</em>.";
	}
	
	else if( !in_array( $_FILES['uploadfile']['type'], $pic_filetypes ) ) {
		echo "Please upload an Image of proper ".strtoupper( implode(', ', $pic_file_exts_show) )." extension(s).";
	}
	
	else if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file_path)) {
		$_SESSION['main_temp_image_container'][$old_file_name] = $new_file_name;
		echo "success_".$new_file_name;
	}
	
	else {
		echo "Image could not be Uploaded to the Server.";
	}
}
?>