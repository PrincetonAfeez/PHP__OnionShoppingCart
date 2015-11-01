<?php
function resizeImage($filePath, $width, $height){
	/* Get original image x y */
	list($w, $h) = getimagesize($filePath);
	$org_w = $w;
	$org_h = $h;
	
	/* calculate new image size with ratio */
	$ratio = min($width/$org_w, $height/$org_h);
	$y = abs($h - $height / $ratio) / 2;
	$x = abs($w - $width / $ratio) / 2;
	$new_h = floor($org_h * $ratio);
	$new_w = floor($org_w * $ratio);

	
	/* new file name */
	$path = preg_replace('/.(jpeg|jpg|png|gif){1}$/i', '-'.$width.'x'.$height.'.$1', $filePath);
	/* read binary data from image file */
	$imgString = file_get_contents($filePath);
	/* create image from string */
	$image = imagecreatefromstring($imgString);
	$tmp = imagecreatetruecolor($new_w, $new_h);
	imagecopyresized($tmp, $image,
			0, 0,
			0, 0,
			$new_w, $new_h,
			$org_w, $org_h
			);
	$finalImg = imagecreatetruecolor($width, $height);
	$whiteBackground = imagecolorallocate($finalImg, 255, 255, 255);
	imagefill($finalImg,0,0,$whiteBackground); // fill the background with white
	imagecopyresampled($finalImg, $tmp,
			0, 0,
			$x, $y,
			$width, $height,
			$new_w, $new_h
			);
	//imagecolorallocate($tmp, 255, 255, 255);
	//imagefill($tmp,0,0,$whiteBackground); // fill the background with white
	//imagefill($tmp,$width-1,0,$whiteBackground); // fill the background with white
	/* Save image */
	switch (exif_imagetype($filePath)) {
		case 1: // if image is gif
			imagegif($tmp, $path);
			break;
		case 2: // if image is jpeg/jpg
			imagejpeg($tmp, $path, 100);
			break;
		case 3: // if image is png
			imagepng($tmp, $path, 0);
			break;
		default:
			exit;
			break;
	}
	return $path;
	/* cleanup memory */
	imagedestroy($image);
	imagedestroy($tmp);
}
?>