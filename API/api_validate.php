<?php
// validate api input

/*
echo "<pre>";
print_r($_GET);
print_r($_POST);
echo "</pre>";
*/


if ($_GET){

	// controler
	if(!empty($_GET['c']) && in_array($_GET['c'], array("user", "content", "site"))) {
		$c = $_GET['c'];
	} else {
		$c = NULL;
		die("GET Please provide controler");
	}

	// action
	if(!empty($_GET['a']) && in_array($_GET['a'],array('all', 'id', 'delete', 'legend','add', 'edit', 'edit_loc'))){
		$a = $_GET['a'];
	} else {
		$a = NULL;
		die("GET Please provide action");
	}
}

if ($_POST){

	// controler
	if(!empty($_POST['c']) && in_array($_GET['c'],array("user", "content","site"))) {
		$c = $_POST['c'];
	} else {
		$c = NULL;
		die("POST Please provide controler");
	}

	// action
	if(!empty($_POST['a']) && in_array($_POST['a'],array('add','edit'))){
		$a = $_POST['a'];
	} else {
		$a = NULL;
		die("POST Please provide action");
	}
}
?>