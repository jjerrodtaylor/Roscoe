<?php
echo phpinfo();exit;

$con = mysql_connect('actuaryanswerscom.ipagemysql.com','roomie','r00mi3');
$con1= mysql_select_db('iwantaroommate',$con);
if (!$con1)
  {
  die('Could not connect: ' . mysql_error());
  }
  else{
  echo "connect";
  }

?>