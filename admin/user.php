<?php
/*session_start();

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
<div id="user_container" class="container">

<?php

echo "<header id='user_area'>";

// main nav
include("include/admin_nav.php");

echo "</header>";

// user validation
include("user_validate.php");

// user functions
include("user_functions.php");

// check mode for GET
if ($_GET) {
	switch ($action){
		case 'add':
			if ($action) add_user();
			break;
		case 'view':
			if ($user_id) view_user($user_id,$action);
			break;
		case 'edit':
			if ($user_id) edit_user($user_id,$action);
			break;
		case 'delete':
			if ($user_id) delete_user($user_id,$action);
			break;
	}
} elseif ($_POST) {
	// add & edit submit
	switch ($action_success){
		case 'add':
			add_user_success($username,$password,$first_name,$last_name,$bio);
			break;
		case 'edit':
			// edit_user_success($username,$password,$first_name,$last_name,$bio,$usr_id);
			edit_user_success($username,$first_name,$last_name,$bio,$usr_id);
			break;
	}
} else {
	show_map_controls();
}


//get admin footer
include("include/admin_footer.php");
echo "</div > "; // wrapper END

//get main footer
include("include/main_footer.php");*/

?>