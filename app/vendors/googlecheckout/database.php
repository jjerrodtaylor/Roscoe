<?php 
class DB
{
    var $server = "64.15.136.251";
    var $conn_username = "khetaram";
    var $conn_password="khetaram!@#";
    var $database_name="cellsolo";
    var $connection;
    function __construct()
		{
				$connection = mysql_connect($this->server,$this->conn_username,$this->conn_password) or die('Connection no created.')  ;
				$select = mysql_select_db($this->database_name,$connection);
		}
    function sqlinsert($query)
    {
      mysql_query($query);
        
    }
		function mysql_number($query)
    {
       mysql_num_rows($query);
       
    }
}


?>