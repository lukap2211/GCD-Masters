<?php
//validate user input

/*
echo "<pre>";
print_r($_GET);
print_r($_POST);
echo "</pre>";
*/

// GET action

if($_GET){

	// id
	if(!empty($_GET['id']) && is_numeric($_GET['id'])){
		$user_id = $_GET['id'];
	} else {
		$user_id = NULL;
	}


	// action
	if(!empty($_GET['action']) && in_array($_GET['action'],array('add','edit','delete','view'))){
		$action = $_GET['action'];
	} else {
		$action = NULL;
		echo("<div class='alert alert-error'><b>ERROR:</b> please provide action</div>");
	}

	// user id not required for add
	if (!$user_id && $_GET['action'] != "add"){
		echo("<div class='alert alert-error'><b>ERROR:</b> please enter user ID as number</div>");
	}

} elseif($_POST) {

	// POST action
	// validate action
	if(!empty($_POST['action']) && in_array($_POST['action'],array('add','edit'))){
		$action_success = $_POST['action'];
	} else {
		$action_success = NULL;
		$error = true;
	}

	// username
	if(!empty($_POST['username'])){
		$username = $_POST['username'];
	} else {
		echo("<div class='alert alert-error'><b>ERROR:</b> Please enter username as string!</div>");
		$username = NULL;
		$error = true;
	}

	// password
	// if(!empty($_POST['password'])){
	// 	$password = $_POST['password'];
	// } else {
	// 	echo("<div class='alert alert-error'><b>ERROR:</b> Please enter password as string!</div>");
	// 	$password = NULL;
	// 	$error = true;
	// }

	// bio
	if(!empty($_POST['bio'])){
		$bio = $_POST['bio'];
	} else {
		echo("<div class='alert alert-error'><b>ERROR:</b> Please enter biography as string!</div>");
		$bio = NULL;
		$error = true;
	}

	// first name
	if(!empty($_POST['first_name']) && is_string($_POST['first_name'])){
		$first_name = $_POST['first_name'];
	} else {
		echo("<div class='alert alert-error'><b>ERROR:</b> Please enter first name as string!</div>");
		$first_name = NULL;
		$error = true;
	}

	// last name
	if(!empty($_POST['last_name']) && is_string($_POST['last_name'])){
		$last_name = $_POST['last_name'];
	} else {
		echo("<div class='alert alert-error'><b>ERROR:</b> Please enter last name as string!</div>");
		$last_name = NULL;
		$error = true;
	}

	// id
	if(!empty($_POST['usr_id']) && is_numeric($_POST['usr_id'])){
		$usr_id = $_POST['usr_id'];
	}

}


?>