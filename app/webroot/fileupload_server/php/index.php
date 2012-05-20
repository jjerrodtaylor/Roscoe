<?php
ob_start();
session_start();
/*
 * jQuery File Upload Plugin PHP Example 5.7
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

 if(!isset($_SESSION['HASH']) && isset($_REQUEST['hash'])){	
	$_SESSION['HASH'] = $_REQUEST['hash'];
 }elseif(isset($_SESSION['HASH']) && isset($_REQUEST['hash']) && $_SESSION['HASH'] != $_REQUEST['hash']){
	$_SESSION['HASH'] = $_REQUEST['hash'];
 }

error_reporting(E_ALL | E_STRICT);

require('upload.class.php');
$hash = $_SESSION['HASH'];

if(!is_dir(dirname($_SERVER['SCRIPT_FILENAME']).'/'.$hash)) mkdir(dirname($_SERVER['SCRIPT_FILENAME']).'/'.$hash,0777,true);
if(!is_dir(dirname($_SERVER['SCRIPT_FILENAME']).'/'.$hash.'/files')) mkdir(dirname($_SERVER['SCRIPT_FILENAME']).'/'.$hash.'/files',0777,true);
if(!is_dir(dirname($_SERVER['SCRIPT_FILENAME']).'/'.$hash.'/thumbnails')) mkdir(dirname($_SERVER['SCRIPT_FILENAME']).'/'.$hash.'/thumbnails',0777,true);

$upload_handler = new UploadHandler();

header('Pragma: no-cache');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Content-Disposition: inline; filename="files.json"');
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        break;
    case 'HEAD':
    case 'GET':
        $upload_handler->get();
        break;
    case 'POST':
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
            $upload_handler->delete();
        } else {
            $upload_handler->post();
        }
        break;
    case 'DELETE':
        $upload_handler->delete();
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
}
