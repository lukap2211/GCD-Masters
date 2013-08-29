<?php

// database settings

// localhost
$host="localhost"; $db_username="root"; $db_password="root"; $database="masters";

// remote
// $host="localhost"; $db_username=""; $db_password=""; $database="";

// database connection
$conn = mysqli_connect($host, $db_username, $db_password, $database) or die('Connection Error ('.mysqli_connect_errno().') '. mysqli_connect_error());

?>