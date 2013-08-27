<?php

    //open connection
    require("../admin/include/connect.php");
    global $conn;

    // include
    include("api_validate.php");
    include("api_functions.php");

    // edit item
    $query = item_edit();

    $result = mysqli_query($conn, $query);

    if(!$result) {
	    $output["error"] = "ERROR: " . mysqli_error($conn);
    } else {
	    // $output["query"] = $query;
		$output["result"] = $conn->affected_rows;
    }

    echo "<pre>";
    print_r($output);
    echo "</pre>";

?>

<script language="javascript" type="text/javascript">window.top.window.GM._fn.marker.saveMarkerStop(<?php echo json_encode($output) ?>);</script>