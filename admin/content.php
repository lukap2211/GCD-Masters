
<?php
session_start();
// only for signed in users
if(!isset($_SESSION['username']) && (!isset($_GET['action']) || ($_GET['action']!='view'))){
	header("location:logout.php?login=false");
}

// get header
include("include/admin_header.php");

// connect to database
require("include/connect.php");

// open main container
echo "<section id='container'>";

// album validation
include("include/album_validate.php");

// album functions
include("include/album_functions.php");

// check mode for GET
if($_GET){
	switch ($action){
		case 'add':
			if ($action) add_album();
			break;
		case 'view':
			if ($album_id) view_album($album_id,$action);
			break;
		case 'edit':
			if ($album_id) edit_album($album_id,$action);
			break;
		case 'delete':
			if ($album_id) delete_album($album_id,$action);
			break;
	}
} elseif($_POST) {
	// add & edit submit
	switch ($action_success){
		case 'add':
			add_album_success($title,$artist,$review,$stars,$year,$usr_id,$gen_id);
			break;
		case 'edit':
			edit_album_success($title,$artist,$review,$stars,$year,$usr_id,$gen_id,$id);
			break;
	}
}
// close main container
echo "</section>";

// sidebar
include("include/aside.php");

//get footer
include("include/footer.php");

?>