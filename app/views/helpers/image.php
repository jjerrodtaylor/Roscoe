<?php
/**
 * @version 1.1
 * @author Josh Hundley
 * @author Jorge Orpinel <jop@levogiro.net> (changes)
 * @author Arialdo Martini <arialdomartini@bebox.it> (changes)
 */
class ImageHelper extends AppHelper
{
  var $helpers = array('Html');
  //var $cacheDir = 'thumbs'; // relative to 'img'.DS
  var $cacheDir; // relative to 'img'.DS; Default to "imagecache". Defined in /config/core.php with Configure::write('Image.imagecache', 'imagecache');

 function __construct(){
     $this->cacheDir = (Configure::read('Image.imagecache')?Configure::read('Image.imagecache'):'imagecache');
 }
  /**
   * Automatically resizes an image and returns formatted IMG tag
   *
   * @param string $path Path to the image file, relative to the webroot/img/ directory.
   * @param integer $width Image of returned image
   * @param integer $height Height of returned image
   * @param boolean $aspect Maintain aspect ratio (default: true)
   * @param array    $htmlAttributes Array of HTML attributes.
   * @param boolean $return Wheter this method should return a value or output it. This overrides AUTO_OUTPUT.
   * @return mixed    Either string or echos the value, depends on AUTO_OUTPUT and $return.
   * @access public
   */


 function rotateImage($sourceFile,$destImageName,$degreeOfRotation)
{
   //function to rotate an image in PHP
  //developed by Roshan Bhattara (http://roshanbh.com.np)
//ob_start();
  //get the detail of the image
  $imageinfo=getimagesize($sourceFile);
  switch($imageinfo['mime'])
  {
   //create the image according to the content type
   case "image/jpg":
   case "image/jpeg":
   case "image/pjpeg": //for IE
    //  header('Content-type:'.$imageinfo['mime']);
     // echo $sourceFile ;die;
        $src_img=imagecreatefromjpeg("$sourceFile"); //die;
		break;
    case "image/gif":
     //   header('Content-type: image/gif');
        $src_img = imagecreatefromgif("$sourceFile");
		break;
    case "image/png":
	case "image/x-png": //for IE
       // header('Content-type: image/png');
        $src_img = imagecreatefrompng("$sourceFile");
		break;
  }
  //rotate the image according to the spcified degree
  $src_img = imagerotate($src_img, $degreeOfRotation, 0);
  //output the image to a file
  imagejpeg ($src_img,$destImageName);
//  imagedestroy($src_img);
 // imagedestroy($destImageName);
//  ob_flush();
 // ob_end_flush();
}





  function resize($path, $width, $height, $name, $aspect = true, $htmlAttributes = array(), $return = false) {
    $types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); // used to determine image type
    if(empty($htmlAttributes['alt'])) $htmlAttributes['alt'] = '';  // Ponemos alt default
    
   $fullpath = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS;
   $url = $fullpath.$path;
    if (!file_exists($url) || is_dir($url)  || !($size = getimagesize($url))) 
	{
          
	 	return; // image doesn't exist 
	 }
    
    if ($aspect) { // adjust to aspect.

      if($size[0] > $width || $size[1] > $height){
       // -- resize to max, then crop to center
       $ratioX = $size[0] / $width;
       $ratioY = $size[1] / $height;

        if ($ratioX < $ratioY) {
            $newX = round(($width - ($size[0] / $ratioY)) / 2);
            $newY = 0;
            $width = round($size[0] / $ratioY);
            $height = $height;
        } else {
            $newX = 0;
            $newY = round(($height - ($size[1] / $ratioX)) / 2);
            $width = $width;
            $height = round($size[1] / $ratioX);
        }

        }
        else{
           $size[0] = $width;
           $size[1] = $height;
        }
//      if (($size[1]/$height) > ($size[0]/$width))  // $size[0]:width, [1]:height, [2]:type
//      $width = ceil(($size[0]/$size[1]) * $height);
//      else
//      $height = ceil($width / ($size[0]/$size[1]));
    }

    $relfile = $this->webroot.$this->themeWeb.$name; // relative file
    $cachefile = $fullpath.DS.$name;  // location on server

    if (file_exists($cachefile)) 
	{
      $csize = getimagesize($cachefile);
      $cached = ($csize[0] == $width && $csize[1] == $height); // image is cached
      if (@filemtime($cachefile) < @filemtime($url)) // check if up to date
      $cached = false;
    } 
	else 
	{
      $cached = false;
    }

    if (!$cached) {
      $resize = ($size[0] > $width || $size[1] > $height) || ($size[0] < $width || $size[1] < $height);
    } else {
      $relfile = $relfile."?".time();
      $resize = false;
    }

    if ($resize) {
	ini_set( "memory_limit", "200M" ); 
	 $image = call_user_func('imagecreatefrom'.$types[$size[2]], $url);
      if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor ($width, $height))) {
        imagecopyresampled ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
      } else {
        $temp = imagecreate ($width, $height);
        imagecopyresized ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
      }
      call_user_func("image".$types[$size[2]], $temp, $cachefile);
      imagedestroy ($image);
      imagedestroy ($temp);
      } elseif (!$cached) {
      copy($url, $cachefile);
    }

    return $this->output(sprintf($this->Html->tags['image'], $relfile, $this->Html->_parseAttributes($htmlAttributes, null, '', ' ')), $return);
  }
}
?>