<?php

// filename: upload.processor.php

// first let's set some variables

// make a note of the directory that will recieve the uploaded file
$uploadsDirectory = '/upload/images';

// fieldname used within the file <input> of the HTML form
$fieldname = 'file';

// Now let's deal with the upload

// possible PHP upload errors
$errors = array(1 => 'php.ini max file size exceeded',
		2 => 'html form max file size exceeded',
		3 => 'file upload was only partial',
		4 => 'no file was attached');

$blnSaveFileResult = false;


// check for PHP's built-in uploading errors
if ($_FILES[$fieldname]['error'] == 0) {

	
	// check that the file we are working on really was the subject of an HTTP upload
	@is_uploaded_file($_FILES[$fieldname]['tmp_name']);
	 
	// validation... since this is an image upload script we should run a check
	// to make sure the uploaded file is in fact an image. Here is a simple check:
	// getimagesize() returns false if the file tested is not an image.
	@getimagesize($_FILES[$fieldname]['tmp_name']);
	 
	// make a unique filename for the uploaded file and check it is not already
	// taken... if it is already taken keep trying until we find a vacant one
	// sample filename: 1140732936-filename.jpg
	$now = time();
	$filename = urlencode($_FILES[$fieldname]['name']);
	$filename = preg_replace('/(%[0-9a-zA-Z]{2}){3}/', '_', $filename);
	$filename = preg_replace('/\d*-*(.*)-(\d*x\d*)\.([a-z]*)$/i', '$1.$3', $filename);
	while(file_exists($uploadFilename = $_SERVER['DOCUMENT_ROOT'].$uploadsDirectory.'/'.$now.'-'.$filename))
	{
		$now++;
	}
	$httpFilePath = $uploadsDirectory.'/'.$now.'-'.$filename;
	
	// now let's move the file to its final location and allocate the new filename to it
	@move_uploaded_file($_FILES[$fieldname]['tmp_name'], $uploadFilename);
	
	// save copy of different size of the image
	require_once './application/image_factory.php';
	resizeImage($uploadFilename, 150, 150);
	resizeImage($uploadFilename, 500, 500);
	
	$blnSaveFileResult = true;
}	

try{
	$result = array(
					"result"=>$blnSaveFileResult,
					"filepath"=>$httpFilePath
				);
	echo json_encode($result);
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage();
}
?>