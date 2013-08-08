<?php
session_start();

// // show all errors
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);

// only for signed in users
// if(!isset($_SESSION['username']) && (!isset($_GET['action']) || ($_GET['action']!='view'))){
if(!isset($_SESSION['username'])){
	header("location:logout.php?login=false");
}

// connect to database
require("include/connect.php");

//get main header
include("include/main_header.php");

//get admin header
include("include/admin_header.php");
?>

<!-- main container -->
<div id="dashboard_container" class="container">

<header id="user_area" data-user-id="<?= $_SESSION['id'] ?>">

<?php

// main nav
include("include/admin_nav.php");

?>

</header>

<?php

// open main container
// echo "<section id='container'>";

// dashboard validation
// NO NEED all goes via API
// include("dashboard_validate.php");

// dashboard functions
include("dashboard_functions.php");

// close main container
// echo "</section>";

// show dashboard
view_dashboard();

//get admin footer
include("include/admin_footer.php");

//get main footer
include("include/main_footer.php");

?>