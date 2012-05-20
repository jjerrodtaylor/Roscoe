<?php
$config['Site.title']     					=	'Iwantaroommate';
$siteFolder               					=	dirname(dirname(dirname($_SERVER['SCRIPT_NAME'])));
$config['App.AdminMail']  					=	"sandeep.raghav@octalsoftware.net";
$config['App.PageLimit']  					=	'20';
$config['App.AdminPageLimit'] 				=	'20';
$config['App.Status.inactive'] 				=	'0';
$config['App.Status.active'] 				=	'1';
$config['App.Status.delete'] 				=	'2';
$config['App.ProductType.phone'] 			=	'1';
$config['App.ProductType.accessories'] 		=	'2';
$config['App.Status.delete'] 				=	'2';
$config['App.MaxFileSize'] 					=	'1048576';
$config['Status']         					= 	array('1'=>'Active','0'=>'Inactive');
$config['App.PerPage']     					= 	array('10'=>'10', '15'=>'15', '20'=>'20', '30'=>'30', '50'=>'50');
$config['App.PriceSort']     				= 	array('Newest', 'MostPopular');
define('FileSizeLimit', 1024);
$config['App.PhoneProduct']         		= 	1;
$config['App.AccessoryProduct']     		= 	2;
$config['Used']          = array('0'=>'Active','1'=>'Inactive');

$config['App.Role.Admin'] = 1;
$config['App.Role.User'] = 2;

/* $config['Authorized.login']			=  	"88XX59gVLfQh" ;
$config['Authorized.key'] 			=  	"4W8C45WDp2ku5ygS" ; */
$config['Authorized.login']					=  	"9bJ323XkA6a6" ;
$config['Authorized.key'] 					=  	"772bsNSVnZ49Hv8x" ;
$config['App.MaxFileSize'] = FileSizeLimit * 1024;
/* * @define SITE_URL - Not defined */
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . $siteFolder);
define('IMAGE_USER_FOLDER_NAME','user_images');
define('IMAGE_ROOM_FLAT_FOLDER_NAME','room_flat_images');

?>