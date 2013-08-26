<?php

    // show all errors
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);

    //open connection
    require("../admin/include/connect.php");
    global $conn;

    // include
    include("api_functions.php");


    // upload image
    $query = item_get_image();

    $result = mysqli_query($conn, $query);

    $output["query"] = $query;

    // show query
    $output["result"] = mysqli_num_rows($result);

    while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
        $output["items"][] = $row;
    }
    // echo "<pre>";
    // print_r($output);
    // echo "</pre>";

    header("Content-type:". $output['items'][0]['image_type']);
    echo $output['items'][0]['image'];
?>