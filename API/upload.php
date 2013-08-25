<?php

	include("api_functions.php");

	// upload image
	item_edit();

	// execute
	run_query($query);

	sleep(1);
?>

<script language="javascript" type="text/javascript">window.top.window.GM._fn.marker.stopUpload(<?php echo $result; ?>);</script>