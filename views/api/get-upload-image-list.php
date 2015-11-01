<?php
$IMAGE_UPLOAD_FILE = '/upload/images/';
$imageFullPath = $_SERVER['DOCUMENT_ROOT'].$IMAGE_UPLOAD_FILE;

// valid file extension of an image
$valid_exts = array('jpeg', 'jpg', 'png', 'gif');

$imagelist = array();

if (file_exists($imageFullPath)){
	$fileFromUpload = scandir($imageFullPath);
	//echo print_r($fileFromUpload);
	
	foreach ($fileFromUpload as $imageFile) {
		$file_ext = strtolower(pathinfo($imageFile, PATHINFO_EXTENSION));
		if (in_array($file_ext, $valid_exts)) {
			$imageFile = urlencode($imageFile);
			if (!preg_match('/\d+x\d+.(jpeg|jpg|gif|png)$/i', $imageFile)) {
				array_push($imagelist, $IMAGE_UPLOAD_FILE.$imageFile);
			}
		}
	}
	echo json_encode(array(
			'result'=>true,
			'images'=>$imagelist
		));
} else {
	echo json_encode(array(
			'result'=>false,
			'message'=>"Upload folder not found! ".$IMAGE_UPLOAD_FILE
	));
}
?>