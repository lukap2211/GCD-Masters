<?php

// show all errors
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// API calls - JSON only

/*

CALLS TODO :

- get all content (cache in object or local storage) - DONE!
- get content by logitude and latitude
- get content by id
- get all content on that location
- get content by type

*/

// c = controler (content, user)
// a = action (all, id, add, edit, delete)
// f = filter

//open connection
require("../admin/include/connect.php");
global $conn;

// include
include("api_validate.php");
include("api_functions.php");

// preare query based on controler and action
switch ($c) {
	case 'user':
		switch ($a) {
			case 'all':
				$query = user_all();
				break;
			case 'id':
				$query = user_id();
				break;
			case 'add':
				$query = user_add();
				break;
			case 'edit':
				$query = user_edit();
				break;
			case 'delete':
				$query = user_delete();
				break;
			default:
				die("no action for user!");
		}
		break;
	case 'content':
		switch ($a) {
			case 'all':
				$query = item_all();
				break;
			case 'legend':
				$query = item_legend();
				break;
			case 'id':
				$query = item_id();
				break;
			case 'add':
				$query = item_add();
				break;
			case 'edit':
				$query = item_edit();
				break;
			case 'edit_loc':
				$query = item_edit_loc();
				break;
			case 'delete':
				$query = item_delete();
				break;
			default:
				die("no action for content!");
		}
		break;
	case "site":
		switch ($a) {
			case 'id':
				$query = site_id();
				break;
			case 'edit':
				$query = site_edit();
				break;
		}
		break;
	default:
		die("no controler defined!");
}

if ($query != ""){

	$result = mysqli_query($conn, $query);

	$json["query"] = $query;

	// error check
	if(!$result) {

		$json["error"] = "ERROR: " . mysqli_error($conn);

	} else {

		// for add, edit, delete
		if (in_array($a, array("edit", "edit_loc", "delete"))) {

			$json["result"] = mysqli_affected_rows($conn);

		} else if ($a === "add"){

			$json["result"]= mysqli_insert_id($conn);

		} else {
			// show query
			$json["result"] = mysqli_num_rows($result);

			while($row = mysqli_fetch_array($result, MYSQL_ASSOC)){
				$json["items"][] = $row;
			}
		}


	}

	echo json_encode($json);

}



?>