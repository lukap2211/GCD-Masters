<?php
session_start();
//validate input

/*
if(!empty($_GET['menu']) && is_string($_GET['menu'])){
	$menu=$_GET['menu'];
}else{
	$menu = NULL;
}
*/


// set page title TODO

// if user is logged in show ADMIN section | username
$page_title = "ADMIN Section ";

echo sha1("here is my password");

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
	$filter = "and (UPPER(review) like UPPER('%{$search}%') ";
	$filter.= "or UPPER(artist) like UPPER('%{$search}%') ";
	$filter.= "or UPPER(genre) like UPPER('%{$search}%') ";
	$filter.= "or UPPER(year) like UPPER('%{$search}%') ";
	$filter.= "or UPPER(title) like UPPER('%{$search}%')) ";

	$search = stripslashes($_POST['search']);
	$filter_title = "Search results for: <em><strong>{$search}</strong></em>";
}
*/

/*
if($filter){

	// build filter

	// by year
	if(!empty($_GET['year']) && is_numeric($_GET['year'])){
		$filter = "and year = '{$_GET['year']}'";
		$filter_title = "Filter by year: <strong>{$_GET['year']}</strong>";

	}
	// by artist
	if(!empty($_GET['artist']) && is_string($_GET['artist'])){
		$filter = "and artist = '{$_GET['artist']}'";
		$filter_title = "Filter by artist: <strong>{$_GET['artist']}</strong>";

	}
	// by artist
	if(!empty($_GET['stars']) && is_numeric($_GET['stars'])){
		$filter = "and stars = '{$_GET['stars']}'";
		$filter_title = "Filter by stars: <img src='./images/stars_{$_GET['stars']}.png' alt='stars' />";

	}
	// by genre
	if(!empty($_GET['genre']) && is_string($_GET['genre'])){
		$filter = "and g.genre = '{$_GET['genre']}'";
		$filter_title = "Filter by genre: <strong>{$_GET['genre']}</strong>";

	}

	// by user
	if(!empty($_GET['genre']) && is_string($_GET['genre'])){
		$filter = "and g.genre = '{$_GET['genre']}'";
		$filter_title = "Filter by genre: <strong>{$_GET['genre']}</strong>";

	}


}
*/



// ADMIN navigation

//open connection
require("include/admin_nav.php");

//open connection
require("include/connect.php");

// get 10 most recent reviews
$query = "SELECT c.id, c.title, t.type, c.content, c.excerpt, c.date, c.status, u.id, u.username, t.type";
$query.= " FROM contents c, users u, types t";
$query.= " WHERE c.user_id = u.id and c.type_id = t.id $filter";
$query.= " ORDER BY c.date desc limit 0,10;";


$result = mysql_query($query, $conn);

// error check
if(!$result){

	echo "<div class='error'>ERROR: " . mysql_error() ."</div>";

} else {

	// header
	include("include/header.php");

	// open main container
	echo "<section id='container' class='shadow'>\n";

	// filter header
	if($filter_title){
		echo "<div class='header shadow'>$filter_title</div>";
	}

	// listing results
	echo "<ul class='albums_listing'>";
	while($row = mysql_fetch_array($result)){
		extract($row);

		$review = substr($review,0,390)."...";


		$list_albums = <<<LIST

	<li>
		<h2>{$title}</h2>
		<div class='published'>Published: <strong>{$date}</strong> by {$username}</div>
		<div class='details'>
			<span class='genre'>Type: <a href='index.php?filter=on&amp;genre={$genre}'>{$type}</a></span> |
			<span class='stars'>Geo Longitude: {geo_lon}</span>
			<span class='stars'>Geo Latitude: {geo_lat}</span>
		</div>
		<div class="clear"></div>
		<div class='full_review'><a href='album.php?id={$id}&amp;action=view'>Read full review</a></div>
	</li>

LIST;

		echo $list_albums;
	}

	echo "</ul>\n";

	// close main container
	echo "</section>";

	// sidebar
	// include("include/aside.php");

	// footer
	include("include/footer.php");

}
?>