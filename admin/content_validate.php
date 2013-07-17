<?php
//validate album input

/*
echo "<pre>";
print_r($_GET);
print_r($_POST);
echo "</pre>";
*/

if($_GET){

	// GET validate 

	// id
	if(!empty($_GET['id']) && is_numeric($_GET['id'])){
		$album_id = $_GET['id'];
	} else {
		$album_id = NULL;
	}
	
	// action
	if(!empty($_GET['action']) && in_array($_GET['action'],array('add','edit','delete','view'))){
		$action = $_GET['action'];
	} else {
		$action = NULL;
		echo("<div class='error'>ERROR: please provide action</div>");

	}
	
	//album id not required for add
	if (!$album_id && $_GET['action'] != "add"){
		echo("<div class='error'>ERROR: please enter album ID as number</div>");
	}

} elseif($_POST) {  	

	// POST validate
	
	$error_message = NULL;
	
	// usr_id
	if(!empty($_POST['usr_id']) && is_numeric($_POST['usr_id'])){
		$usr_id = $_POST['usr_id'];
	} else {
		$error_message.= "<li>No user logged in!</li>";
		$usr_id = NULL;
		$error = true;
	}

	//  action
	if(!empty($_POST['action']) && in_array($_POST['action'],array('add','edit'))){
		$action_success = $_POST['action'];
	} else {
		$action_success = NULL;
		$error = true;
	}
	
	//title
	if(!empty($_POST['title'])){
		$title = $_POST['title'];
	} else {
		$error_message.= "<li>Please enter title as string!</li>";
		$title = NULL;
		$error = true;
	}

	//artist
	if(!empty($_POST['artist'])){
		$artist = $_POST['artist'];
	} else {
		$error_message.= "<li>Please enter artist as string!</li>";
		$artist = NULL;
		$error = true;
	}

	//review
	if(!empty($_POST['review'])){
		$review = $_POST['review'];
	} else {
		$error_message.= "<li>Please enter review as string!</li>";
		$review = NULL;
		$error = true;
	}
	
	// year
	if(!empty($_POST['year']) && is_numeric($_POST['year'])){
		$year = $_POST['year'];
	} else {
		$error_message.= "<li>Please enter year as integer!</li>";

		$year = NULL;
		$error = true;
	}

	// stars
	if(!empty($_POST['stars']) && is_numeric($_POST['stars'])){
		$stars = $_POST['stars'];
	} else {
		$error_message.= "<li>Please enter stars as integer!</li>";

		$stars = NULL;
		$error = true;
	}

	// genre
	if(!empty($_POST['gen_id']) && is_numeric($_POST['gen_id'])){
		$gen_id = $_POST['gen_id'];
	} else {
		$error_message.= "<li>No genre selected!</li>";
		$gen_id = NULL;
		$error = true;
	}

	// id
	if(!empty($_POST['id']) && is_numeric($_POST['id'])){
		$id = $_POST['id'];
	}
	if($error_message)
		echo "<ul class='error'>ERROR: $error_message</ul>";

}


?>