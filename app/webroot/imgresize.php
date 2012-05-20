<?php
//header ("Content-type: image/jpeg");
/*
<!-- 1. Resize an image to 50% the size -->
<img src="imgresize.php?percent=30&amp;img=elvita.jpg" />

<!-- 2. Resize an image to 150 pixels wide and autocompute the height -->
<img src="imgresize.php?w=150&amp;img=elvita.jpg" />

<!-- 3. Resize an image to 225 pixels tall and autocompute the width -->
<img src="imgresize.php?h=225&amp;img=elvita.jpg" />

<!-- 4. Resize to 150 pixels width OR 500 pixels tall,
        whichever resulting image is smaller -->
<img src="imgresize.php?w=150&amp;h=500&amp;constrain=1&amp;img=elvita.jpg" />

<!-- 5. Display a default image if the requested image doesn't exist -->
<img src="imgresize.php?w=150&amp;img=miss_elvita.jpg" />

=====================================
*/
/*
JPEG / PNG Image Resizer
Parameters (passed via URL):

img = path / url of jpeg or png image file

percent = if this is defined, image is resized by it's
          value in percent (i.e. 50 to divide by 50 percent)

w = image width

h = image height

constrain = if this is parameter is passed and w and h are set
            to a size value then the size of the resulting image
            is constrained by whichever dimension is smaller

Requires the PHP GD Extension

Outputs the resulting image in JPEG Format

By: Michael John G. Lopez - www.sydel.net
Filename : imgsize.php

Modified by: Nash - http://nashruddin.com
Added:
 - displays default image if the requested image doesn't exist
 - hide image path from user
*/




if(isset($_GET['temp'])){
 $path = dirname(__FILE__)."/uploads/temp";
}
else if(isset($_GET['profile'])){

  $path = dirname(__FILE__)."/uploads/products_images/";
}
else{
     $path = dirname(__FILE__)."/uploads/service/";
}
// change to where your images reside
$img  = $path . '/' . $_GET['img'];

$defaultPath = dirname(__FILE__)."/img/site";

if (file_exists($img)) {
	$percent = $_GET['percent'];
	$constrain = $_GET['constrain'];
	$w = $_GET['w'];
	$h = $_GET['h'];
} else {
	$img = $defaultPath . '/no_image_150x100.gif';	// change with your default image
	$percent = 100;
}

// get image size of img
$x = @getimagesize($img);
// image width
$sw = $x[0];
// image height
$sh = $x[1];

if ($percent > 0) {
	// calculate resized height and width if percent is defined
	$percent = $percent * 0.01;
	$w = $sw * $percent;
	$h = $sh * $percent;
} else {
	if (isset ($w) AND !isset ($h)) {
		// autocompute height if only width is set
		$h = (100 / ($sw / $w)) * .01;
		$h = @round ($sh * $h);
	} elseif (isset ($h) AND !isset ($w)) {
		// autocompute width if only height is set
		$w = (100 / ($sh / $h)) * .01;
		$w = @round ($sw * $w);
	} elseif (isset ($h) AND isset ($w) AND isset ($constrain)) {
		// get the smaller resulting image dimension if both height
		// and width are set and $constrain is also set
		$hx = (100 / ($sw / $w)) * .01;
		$hx = @round ($sh * $hx);

		$wx = (100 / ($sh / $h)) * .01;
		$wx = @round ($sw * $wx);

		if ($hx < $h) {
			$h = (100 / ($sw / $w)) * .01;
			$h = @round ($sh * $h);
		} else {
			$w = (100 / ($sh / $h)) * .01;
			$w = @round ($sw * $w);
		}
	}
}

$im = @ImageCreateFromJPEG ($img) or // Read JPEG Image
$im = @ImageCreateFromPNG ($img) or // or PNG Image
$im = @ImageCreateFromGIF ($img) or // or GIF Image
$im = false; // If image is not JPEG, PNG, or GIF

if (!$im) {
	// We get errors from PHP's ImageCreate functions...
	// So let's echo back the contents of the actual image.
	readfile ($img);
} else {
	// Create the resized image destination
	$thumb = @ImageCreateTrueColor ($w, $h);
	// Copy from image source, resize it, and paste to image destination
	@ImageCopyResampled ($thumb, $im, 0, 0, 0, 0, $w, $h, $sw, $sh);
	
	// Output resized image
	@ImageJPEG ($thumb);
}
?>
