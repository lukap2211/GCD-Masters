<?
session_start();
session_destroy();
$_SESSION = array();

// open connection
require("include/connect.php");

// header
include("include/admin_header.php");

// open main container
echo "<section id='container'>";

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

// footer
include("include/admin_footer.php");
?>