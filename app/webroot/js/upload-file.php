<?php //session_start();


	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';  //Octal123#

	$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');

	//$dbname = 'test';
	$dbname = 'cellsolo'; //willownerfinance
	mysql_select_db($dbname);



	$uploaddir = '../img/uploaded/'; 
	$file = $uploaddir .basename($_FILES['uploadfile']['name']); 
	$size=$_FILES['uploadfile']['size'];

	$newFileName = basename($_FILES['uploadfile']['name']); 
	 
	$l_time = time();
	 
	//if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
	if($_FILES['uploadfile']['size'] <= 1048576) {
		if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], "../img/uploaded/" . $l_time . $newFileName)) { 
			
			$newFileType = end(explode(".", $newFileName));
			//$newFile = "../img/uploaded/$l_time" . "$newFileName";
			$newFile = "../img/uploaded/" . $l_time . $newFileName ;
			create_thumb($newFile, $newFileType);
			create_small($newFile, $newFileType);
			create_large($newFile, $newFileType);
			
			$tmp_hash1 = $_GET["product_id"];
				
			$qry = "INSERT INTO product_images Set image_name='".$l_time.$newFileName."',product_id='".$tmp_hash1."'";
			//echo $qry;
			$res = mysql_query($qry);
					
			?>
			<?php //echo SITE_URL;?>
			<?php /*?><img src="../img/uploaded/<?=basename($_FILES['uploadfile']['name'])?>" width="100" height="100" border="0" />  
			<?php */?>  
			<div align="left"><?=basename($_FILES['uploadfile']['name'])?> successfully uploaded.</div>
			<?php  
		}else{
			echo "error ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
		}
	} else {
		echo "Error The file size of ".$_FILES['uploadfile']['name']." is greater then 1 Mb.";
	}
	?>


	<?php
	function create_thumb($file, $userfile_type) {
	
		$userfile_type = strtolower($userfile_type);
		list($width, $height, $type, $attr) = getimagesize($file);
		if($width<135){
			$n_width = $width;
		}else{
			$n_width=135; // Fix the width of the thumb nail images
		}
		/*if($height<135){
			$n_height=$height;
		}else{
			$n_height=135; // Fix the height of the thumb nail image
		} */
		
		$ratio = $n_width / $width;
		$n_height = $height * $ratio;
		
		
		
		
		
		/*------------ fix with by 135 * 135 ------------------*/
		
			$n_width=135;
	         $n_height =135;
		
		
		
		
		$newThumb = "../img/uploaded_thumb/".basename($file);	
		
		if ($userfile_type == "gif"){
			$im = imagecreatefromgif($file);
			$width = ImageSx($im) ;              // Original picture width is stored
			$height = ImageSy($im) ;

			
			if($width>$height){
				$width=$height;
			}else{
				$height=$width;
			}


            // Original picture height is stored
			$newimage = imagecreatetruecolor($n_width,$n_height);
			imagecopyresized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
			
			//header("Content-type: image/gif");
			imagegif($newimage,$newThumb);
		}
		
		
		
		if ($userfile_type == "jpeg" || $userfile_type == "jpg"){
			$im = imagecreatefromjpeg($file);

			
			$width = ImageSx($im);              // Original picture width is stored
			$height = ImageSy($im);            // Original picture height is stored
			
			
			if($width>$height){
				$width=$height;
			}else{
				$height=$width;
			}
			
			
			$newimage = imagecreatetruecolor($n_width,$n_height);		
			 imagecopyresized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
			

			//header("Content-type: image/jpeg");
			imagejpeg($newimage,$newThumb);
		}	

		if ($userfile_type == "png"){
			$im = imagecreatefrompng($file);

			
			$width = ImageSx($im);              // Original picture width is stored
			$height = ImageSy($im);            // Original picture height is stored
			
			if($width>$height){
				$width=$height;
			}else{
				$height=$width;
			}
			
			
			$newimage = imagecreatetruecolor($n_width,$n_height) ;
			imagecopyresized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height) ; 
			// header("Content-type: image/jpeg");
			imagepng($newimage,$newThumb);
		}
	}

	
 
	
	
	function create_thumb_center($imgSrc,$userfile_type) { //$imgSrc is a FILE - Returns an image resource.
    //getting the image dimensions 
	$thumbnail_width=$thumbnail_height=135;
	
    list($width_orig, $height_orig) = getimagesize($imgSrc);  
 


	if($userfile_type == "jpeg" || $userfile_type == "jpg"){
		$myImage = imagecreatefromjpeg($imgSrc);
	}else if ($userfile_type == "png"){
	   $myImage = imagecreatefrompng($imgSrc);
	}else if ($userfile_type == "gif"){
	   $myImage = imagecreatefromgif($imgSrc);
	}




   $ratio_orig = $width_orig/$height_orig;
   $newThumbName = "../img/uploaded_thumb/".basename($imgSrc);	
   
   
   
    if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
       $new_height = $thumbnail_width/$ratio_orig;
       $new_width = $thumbnail_width;
    } else {
       $new_width = $thumbnail_height*$ratio_orig;
       $new_height = $thumbnail_height;
    }
   
    $x_mid = $new_width/2;  //horizontal middle
    $y_mid = $new_height/2; //vertical middle
   
    $process = imagecreatetruecolor(round($new_width), round($new_height));
   
    imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
    $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
    imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);

    // And display the image...
header('Content-type: image/jpeg');

	
	
	if($userfile_type == "jpeg" || $userfile_type == "jpg"){
		imagejpeg($thumb,$newThumbName);
	}else if ($userfile_type == "png"){
	  imagepng($thumb,$newThumbName);
	}else if ($userfile_type == "gif"){
	   imagegif($thumb,$newThumbName);
	}
	
	
	imagedestroy($process);
    imagedestroy($myImage);
	
   // return $thumb;
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function create_small($file, $userfile_type) {
	
		$userfile_type = strtolower($userfile_type);
		list($width, $height, $type, $attr) = getimagesize($file);
		
		/*if($width<56){
			$n_width = $width;
		}else{
			$n_width=56;
		} */
		if($width<80){
			$n_width = $width;
		}else{
			$n_width=80;
		}		
		/*if($height<56){
			$n_height=$height;
		}else{
			$n_height=56; // Fix the height of the thumb nail imaage
		} */
		$ratio = $n_width / $width;
		$n_height = $height * $ratio;
		
		 
		
		$newThumb = "../img/uploaded_small/".basename($file);	
		
		if ($userfile_type == "gif"){
			$im = imagecreatefromgif($file);
			$width = ImageSx($im);              // Original picture width is stored
			$height = ImageSy($im);            // Original picture height is stored
			$newimage = imagecreatetruecolor($n_width,$n_height);
			imagecopyresized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
			
			//header("Content-type: image/gif");
			imagegif($newimage,$newThumb);
		}
			
		if ($userfile_type == "jpeg" || $userfile_type == "jpg"){
			$im = imagecreatefromjpeg($file);
			
			$width = ImageSx($im);              // Original picture width is stored
			$height = ImageSy($im);            // Original picture height is stored
			
			$newimage = imagecreatetruecolor($n_width,$n_height);		
			imagecopyresized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);

			//header("Content-type: image/jpeg");
			imagejpeg($newimage,$newThumb);
		}	

		if ($userfile_type == "png"){
			$im = imagecreatefrompng($file);
	
			$width = ImageSx($im);              // Original picture width is stored
			$height = ImageSy($im);            // Original picture height is stored
			
			$newimage = imagecreatetruecolor($n_width,$n_height);
			imagecopyresized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
			
			//header("Content-type: image/jpeg");
			imagepng($newimage,$newThumb);
		}
	}
	?>

	<?php
	function create_large($file, $userfile_type){
	
		$userfile_type = strtolower($userfile_type);
		$n_width = $lareImageWith = 365;
		
		list($width, $height, $type, $attr) = getimagesize($file);
		
	/* 	if($width < $lareImageWith){
			$n_width = $width;
		}else{
			$n_width = $lareImageWith; // Fix the width of the thumb nail images
		} */
		
		
		
		$ratio = $n_width / $width;
		$n_height = $height * $ratio;
		

		$newThumb = "../img/uploaded_large/".basename($file);	
		
		if ($userfile_type == "gif"){
			$im = imagecreatefromgif($file);
			$width = ImageSx($im);              // Original picture width is stored
			$height = ImageSy($im);            // Original picture height is stored
			$newimage = imagecreatetruecolor($n_width,$n_height);
			imagecopyresized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
			
			//header("Content-type: image/gif");
			imagegif($newimage,$newThumb);
		}
		
		if ($userfile_type == "jpeg" || $userfile_type == "jpg"){
			$im = imagecreatefromjpeg($file);
		
			$width = ImageSx($im);              // Original picture width is stored
			$height = ImageSy($im);            // Original picture height is stored
			
			$newimage = imagecreatetruecolor($n_width,$n_height);		
			imagecopyresized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);

			//header("Content-type: image/jpeg");
			imagejpeg($newimage,$newThumb);
		}	

		if ($userfile_type == "png"){
			$im = imagecreatefrompng($file);
	
			$width = ImageSx($im);              // Original picture width is stored
			$height = ImageSy($im);            // Original picture height is stored
			
			$newimage = imagecreatetruecolor($n_width,$n_height);
			imagecopyresized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
			//header("Content-type: image/jpeg");
			imagepng($newimage,$newThumb);
		}
	}
     
 
	?>