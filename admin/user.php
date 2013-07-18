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

//get header
include("include/admin_header.php");


////////////////////////////////

?>

<header id="user_area">

<?php

if (isset($_SESSION['username'])){
    echo "Hi {$_SESSION['username']}, <a href='logout.php'>Log Out</a>";
  } else {
    echo "<a href='../admin/'>Log in</a>";
  }

?>
</header>


<?php

// ADMIN AREA
if(isset($_SESSION['username'])) {

?>

<h1>Welcome!</h1>
<br />

<div class="navbar">
  <div class="navbar-inner">
    <div class="container">

      <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <!-- Be sure to leave the brand out there if you want it shown -->
      <a class="brand" href="#">My Dashboard</a>

      <!-- Everything you want hidden at 940px or less, place within here -->
      <div class="nav-collapse collapse">
        <!-- .nav, .navbar-search, .navbar-form, etc -->

            <ul class="nav">

              <li class="active"><a href="user.php">Home</a></li>

	          <?php
	          if ($_SESSION['privilege'] == "admin" ) {
	          ?>

	          <li class="dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Locations <b class="caret"></b></a>
	            <ul class="dropdown-menu">
	              <li><a class="set_home_1" href="#" data-home="griffith">GCD Campus</a></li>
	              <li><a class="set_home_2" href="#" data-home="smithfield">Smithfield Square</a></li>
	            </ul>
	          </li>

	          <li class="dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <b class="caret"></b></a>
	            <ul class="dropdown-menu">
	              <li><a href="#">View All Users</a></li>
	              <li><a href="#">Add New User</a></li>
	            </ul>
	          </li>

	          <?php } ?>

	          <li class="dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Content <b class="caret"></b></a>
	            <ul class="dropdown-menu">
	              <li><a href="#">View All Content</a></li>
	              <li><a href="#">Add New Content</a></li>
	            </ul>
	          </li>
            </ul>

			<ul class="nav pull-right">
	          <li class="dropdown">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <b class="caret"></b></a>
	            <ul class="dropdown-menu">
	              <li><a href="user.php?id=<?php echo $_SESSION['id'] ?>&amp;action=view">My profile</a></li>
	              <li><a href="#">Site Settings</a></li>
	              <li class="divider"></li>
	              <li><a href="#">Log Out</a></li>
	            </ul>
	          </li>
        	</ul>

        </div>

    </div>
  </div>
</div>


<?php

} else {

// NOT  LOGGED IN

?>


<h1>Admin Area</h1>



<?php } ?>
</header>


<?php


// open main container
echo "<section id='container'>";

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
	view_dashboard();
}

// close main container
echo "</section>";

// sidebar
// include("include/aside.php");

//get footer
include("include/admin_footer.php");

?>