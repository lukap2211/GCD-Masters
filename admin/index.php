<?php
// login check
ob_start();

session_start();


// if logged in redirect to admin area
if(!session_is_registered("username")){

	// open connection
	require("include/connect.php");

	// login form validation
	$error_message = NULL;
	$username = NULL;
	$password = NULL;

	// validate username
	if(!empty($_POST['username']) && is_string($_POST['username'])){
		$username = $_POST['username'];
	}else{
		$error_message = "<li>Please insert username</li>";
	}

	// validate password
	if(!empty($_POST['password']) && is_string($_POST['password'])){
		$password = $_POST['password'];
	}else{
		$error_message .= "<li>Please insert password</li>";
	}

	if(!$error_message){

		// MySQL injection prevention
		if (!get_magic_quotes_gpc()) {
			$username = stripslashes($username);
			$password = stripslashes($password);
		}
		$username = mysqli_real_escape_string($conn, $username);
		$password = mysqli_real_escape_string($conn, $password);


		// crypt password
		$hashed_password = md5($password);

		// DEBUG
		// echo "$hashed_password <br />";

		// check if there is a match in db
		$query = "SELECT u.username, u.password, u.first_name, u.last_name, u.id, p.privilege FROM users u, privileges p";
		$query.= " WHERE u.username = '$username'";
		$query.= " AND u.password = '$hashed_password' AND u.privilege_id = p.id";

		// echo $query;

		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);
		if($count){
			// while($row = $result->fetch_array()){
			while($row = mysqli_fetch_array($result)){
				extract($row);
				// register $username, $password and redirect to file "login_success.php"
				session_register("username");
				session_register("hashed_password");
				session_register("id");
				session_register("privilege");
				session_register("first_name");
				session_register("last_name");
				header("location:login_success.php");
			}

		} else {
			// errorlukapin_masters
			$error_message .= "<li>Wrong username or password</li>";
		}

	}

} else {
	// header("location:user.php?action=view&id={$_SESSION['id']}");
	header("location:dashboard.php");
}

// get main header
include("include/main_header.php");

// get admin footer
include("include/admin_header.php");

// open main container
echo "<section id='login_container' class='container'>";

// throw error
if($error_message) {
	echo "<div class='alert alert-error'><strong>Ooops!</strong><button type='button' class='close' data-dismiss='alert'>x</button><br /><br /><ul>$error_message</ul></div>";
}

// login form
include("include/login_form.php");

// close main container
echo "</section>";

// get main footer
include("include/main_footer.php");

ob_end_flush();

?>