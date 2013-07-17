<?php

// show all errors
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// API calls - JSON only


/*

CALLS TODO :

- get all content (cache in object or local storage)
- get content by logitude and latitude
- get content by id
- get all content on that location
- get content by type

*/

$page_title = "API Calls ";

// filter by GET
if(!empty($_GET['filter']) && ($_GET['filter'] === 'on' )){
	$filter = $_GET['filter'];
}else{
	$filter = NULL;
}


// search by POST
$filter_title = NULL;
//main search
/*
if(!empty($_POST['search']) && is_string($_POST['search'])){
	$search = addslashes($_POST['search']);
	$filter = "and (UPPER(type) like UPPER('%{$search}%') ";
	$filter.= "or UPPER(content) like UPPER('%{$search}%')) ";

	$search = stripslashes($_POST['search']);
	$filter_title = "Search results for: <em>{$search}</em>";
}
*/


if($filter){

	// build filter

	// by type
	if(!empty($_GET['type']) && is_string($_GET['type'])){
		$filter = "and t.type = '{$_GET['type']}'";
		$filter_title = "Filter by type: {$_GET['type']}";
	}

}


//open connection
require("../admin/include/connect.php");

// get content
$query = "SELECT c.id, c.title, t.type, c.content, c.excerpt, c.date, c.status, u.id as user_id, u.username, t.type";
$query.= " FROM contents c, users u, types t";
$query.= " WHERE c.user_id = u.id and c.type_id = t.id $filter";
$query.= " ORDER BY c.date desc limit 0,10;";

// echo $query;

$results = mysqli_query($conn, $query);

$json = array();

// error check
if(!$results){

	$json["query"][] = "ERROR: " . mysqli_error();

} else {

	$json["query"][] = $query;

	if ($filter) $json["filter"] = $filter_title;

	// listing results
	while($row = mysqli_fetch_array($results, MYSQL_ASSOC)){
		$json["result"][] = $row;
	}
}

// output JSON
echo "<pre>";
echo json_encode($json);
echo "</pre>";

?>