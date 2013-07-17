<?php

	// show all errors
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);

	session_start();

	//open connection
	require("include/connect.php");

	// set globals
	$admin = true;

	// header
	include("include/admin_header.php");

	// open main container
	echo "<section id='container'>";

	// login form
	include("include/login_form.php");

	// close main container
	echo "</section>";

	// footer
	include("include/admin_footer.php");

	//close connection
	$conn->close();

?>