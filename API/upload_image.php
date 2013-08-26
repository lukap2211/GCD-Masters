<?php

    //open connection
    require("../admin/include/connect.php");
    global $conn;

    // include
    include("api_validate.php");
    include("api_functions.php");

    // edit item
    $result = item_edit();

    echo $result;

?>

