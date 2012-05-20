<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
$dbname = 'sellsolo';
mysql_select_db($dbname);
/*
 * jQuery File Upload Plugin PHP Example 5.2.7
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://creativecommons.org/licenses/MIT/
 */
	//private $uploaddir = 'd:/xampp/htdocs/cellsolo/app/webroot/files/'; 
	//private $uploaddir1 = 'http://localhost/cellsolo/app/webroot/files/'; 
//	private $uploaddir2 = 'd:/xampp/htdocs/cellsolo/app/webroot/files/thumbnails/'; 
//	private $uploaddir3 = 'http://localhost/cellsolo/app/webroot/files/thumbnails/'; 
/* Note: This thumbnail creation script requires the GD PHP Extension.  
		If GD is not installed correctly PHP does not render this page correctly
		and SWFUpload will get "stuck" never calling uploadSuccess or uploadError
	 */
	// Get the session Id passed from SWFUpload. We have to do this to work-around the Flash Player Cookie Bug
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	}

	session_start();
	ini_set("html_errors", "0");

	// Check the upload
	// Check the upload
	if (!isset($_FILES["Filedata"]) || !is_uploaded_file($_FILES["Filedata"]["tmp_name"]) || $_FILES["Filedata"]["error"] != 0) {
		echo "ERROR:invalid upload";
		exit(0);
	}


	if (!isset($_SESSION["file_info"])) {
		$_SESSION["file_info"] = array();
	}
	
	$fileName = md5(rand()*10000000) . ".jpg";
	move_uploaded_file($_FILES["Filedata"]["tmp_name"], "saved/" . $fileName);

	$file_id = md5(rand()*10000000);
	
	$_SESSION["file_info"][$file_id] = $fileName;

	echo "FILEID:" . $file_id;	// Return the file id to the script
?>