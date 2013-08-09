<?
session_start();
session_destroy();
$_SESSION = array();

// open connection
require("include/connect.php");

// get main header
include("include/main_header.php");

// get admin header
include("include/admin_header.php");
include("include/dashboard_functions.php");

// show_modal();

// open main container
echo "<section id='login_container' class='container'>";


//message
if(isset($_GET['login'])){
	echo "<div class='alert alert-error'>You must be logged in to view this page</div>";
} else{
	echo "<div class='alert alert-error'><b>Info:</b> You are logged out.</div>";
}

// login form
include("include/login_form.php");

// close main container
echo "</section>";

// get main footer
include("include/main_footer.php");
?>