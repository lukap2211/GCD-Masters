<?php

    //open connection
    require("../admin/include/connect.php");
    global $conn;

    // include
    include("api_validate.php");
    include("api_functions.php");

    // upload image
    item_edit();

?>

<script language="javascript" type="text/javascript">window.top.window.GM._fn.marker.stopUpload(<?php echo $result; ?>);</script>