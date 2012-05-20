<?php

/**
 * Handle file uploads via XMLHttpRequest
 */
/* ====================make image folder and set image path=================== */
	$hash = $_GET['hash'];
	$siteFolder  = dirname(dirname($_SERVER['SCRIPT_FILENAME']));
	$image_forder_url = $siteFolder.'/img/room_flat_images'; 
	if(!is_dir($image_forder_url)) mkdir($image_forder_url,0777,true);
	
	if(!is_dir($image_forder_url.'/'.$hash)) mkdir($image_forder_url.'/'.$hash,0777,true);
	if(!is_dir($image_forder_url.'/'.$hash.'/uploaded')) mkdir($image_forder_url.'/'.$hash.'/uploaded',0777,true);
	if(!is_dir($image_forder_url.'/'.$hash.'/uploaded_thumb')) mkdir($image_forder_url.'/'.$hash.'/uploaded_thumb',0777,true);
	if(!is_dir($image_forder_url.'/'.$hash.'/uploaded_large')) mkdir($image_forder_url.'/'.$hash.'/uploaded_large',0777,true);
	
	define('IMAGE_LOADED_PATH',$image_forder_url.'/'.$hash.'/uploaded/');
	define('IMAGE_THUMB_PATH',$image_forder_url.'/'.$hash.'/uploaded_thumb/');
	define('IMAGE_LARGE_PATH',$image_forder_url.'/'.$hash.'/uploaded_large/');
 /* ===============================end here============================================== */

 class qqUploadedFileXhr {
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
	 
    function save($path) {    	
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);
        
        if ($realSize != $this->getSize()){            
            return false;
        }
        
        $target = fopen($path, "w");        
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);
        
        return true;
    }
    function getName() {
        return $_GET['qqfile'];
    }
    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])){
            return (int)$_SERVER["CONTENT_LENGTH"];            
        } else {
            throw new Exception('Getting content length is not supported.');
        }      
    }   
}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {  
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
		
        if(!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)){
            return false;
        }
        return true;
    }
    function getName() {
        return $_FILES['qqfile']['name'];
    }
    function getSize() {
        return $_FILES['qqfile']['size'];
    }
}

class qqFileUploader {

    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760){        
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = $sizeLimit;
        
        $this->checkServerSettings();       

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false; 
        }
    }
    
    private function checkServerSettings(){        
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
        
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");    
        }        
    }
    
    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;        
        }
        return $val;
    }
    
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
	 
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
        if (!is_writable($uploadDirectory)){
            return array('error' => "Server error. Upload directory isn't writable.");
        }
        
        if (!$this->file){
            return array('error' => 'No files were uploaded.');
        }
        
        $size = $this->file->getSize();
        
        if ($size == 0) {
            return array('error' => 'File is empty');
        }
        
        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }
        
        $pathinfo = pathinfo($this->file->getName());
        $filename = $pathinfo['filename'];
        //$filename = md5(uniqid());
        $ext = $pathinfo['extension'];

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }
        
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }
        
        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
            
			/*===================Create thumb images======================= */
				//$this->create_thumb($uploadDirectory . $filename . '.' . $ext,$ext);		
				$Upload = new UploadResize();
				$file = $uploadDirectory . $filename . '.' . $ext;
				$Upload->load($file);
				$Upload->resize(350,300);
				$Upload->save(IMAGE_LARGE_PATH . $filename . '.' . $ext);
				$Upload->resize(80,80);
				$Upload->save(IMAGE_THUMB_PATH . $filename . '.' . $ext);				
			/* ========================================================= */
			
			return array('success'=>true , 'filename' => $filename.'.'.$ext);
        
		
		} else {
            return array('error'=> 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
        
    }
	/* ================Add by S.R. for creat thumb======================= */
	function create_thumb($file, $userfile_type) {
	
		$userfile_type = strtolower($userfile_type);
		$n_width=135;
	    $n_height =135;		
		$newThumb = IMAGE_THUMB_PATH.basename($file);	
		
		if ($userfile_type == "gif"){
			$im = imagecreatefromgif($file);
			$width = ImageSx($im) ;   // Original picture width is stored
			$height = ImageSy($im) ;			
			if($width>$height){
				$width=$height;
			}else{
				$height=$width;
			}
            // Original picture height is stored
			$newimage = imagecreatetruecolor($n_width,$n_height);
			imagecopyresized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);			
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
			imagepng($newimage,$newThumb);
		}
	}

    
}
/* ==================include resize class======================= */
include_once('upload_resize.php');
/* ============================================================== */




// list of valid extensions, ex. array("jpeg", "xml", "bmp")
$allowedExtensions = array('jpg', 'jpeg','JPG','JPEG','PNG','png','gif','GIF');
// max file size in bytes
$sizeLimit = 10 * 1024 * 1024;
	
$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
$result = $uploader->handleUpload(IMAGE_LOADED_PATH);
echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
