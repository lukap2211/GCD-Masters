<?php
//database settings

//localhost
$host="localhost"; $db_username="root"; $db_password="root"; $database="masters";

//remote
//$host="localhost"; $db_username="lukapin_masters"; $db_password="Masters123"; $database="lukapin_masters";


// database connection
$conn = mysql_connect($host, $db_username, $db_password) or die(mysqli_connect_error());
mysql_select_db($database) or die("ERROR: can not select database!") ;

?>