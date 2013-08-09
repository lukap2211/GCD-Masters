<?php

// API functions

// content functions

function item_all() {

	// by map
	if(!empty($_GET['map']) && is_string($_GET['map'])){
		$filter = "and c.map = '{$_GET['map']}'";
	}

	// by type
	if(!empty($_GET['type']) && is_string($_GET['type'])){
		$filter .= " and t.type = '{$_GET['type']}'";
	}

	// query
	$query = "SELECT c.id, c.title, t.type, c.content, c.excerpt, c.date, c.status, u.id as user_id, c.geo_lat, c.geo_lng, u.username, c.category, t.type";
	$query.= " FROM contents c, users u, types t";
	$query.= " WHERE c.user_id = u.id and c.type_id = t.id $filter";
	$query.= " ORDER BY c.category asc, c.date desc";

	// output
	return $query;
}

function item_legend() {

	// by map
	if(!empty($_GET['map']) && is_string($_GET['map'])){
		$filter = "and c.map = '{$_GET['map']}'";
	}

	// by type
	if(!empty($_GET['type']) && is_string($_GET['type'])){
		$filter .= " and t.type = '{$_GET['type']}'";
	}

	// query
	$query = "SELECT count(*) as total, c.category";
	$query.= " FROM contents c, users u, types t";
	$query.= " WHERE c.user_id = u.id and c.type_id = t.id $filter";
	$query.= " GROUP BY c.category";
	$query.= " ORDER BY c.category asc";

	return $query;
}

function item_id() {

	// by id
	if(!empty($_GET['id']) && intval($_GET['id'])){
		$filter = " and c.id = '{$_GET['id']}'";
	}

	// query
	$query = "SELECT c.id, c.title, t.type, c.content, c.excerpt, c.date, c.status, u.id as user_id, c.geo_lat, c.geo_lng, u.username, c.category, t.type";
	$query.= " FROM contents c, users u, types t";
	$query.= " WHERE c.user_id = u.id and c.type_id = t.id $filter";

	return $query;
}

function item_add() {

	// query
	$query = "INSERT INTO contents";
	$query.= " (id, user_id, type_id, title, date, date_modified, content, excerpt, status, geo_lng, geo_lat, map, category)  ";
	$query.= " VALUES (NULL, '{$_GET['user_id']}', '1', 'test', '0000-00-00 00:00:00', CURRENT_TIMESTAMP, 'some lukap content', 'bla', '0', '{$_GET['geo_lng']}', '{$_GET['geo_lat']}', '{$_GET['map']}', '{$_GET['category']}')";
	return $query;
}

function item_edit() {
	// code...
}

function item_edit_loc() {

	// by id
	if(!empty($_GET['id']) && intval($_GET['id'])){
		$filter = " and id = '{$_GET['id']}'";
	}

	if(!empty($_GET['geo_lat']) && intval($_GET['geo_lat'])){
		// $filter = " and geo_lat = '{$_GET['geo_lat']}'";
	}
	if(!empty($_GET['geo_lng']) && intval($_GET['geo_lng'])){
		// $filter = " and geo_lng = '{$_GET['geo_lng']}'";
	}
	// query
	$query = "UPDATE contents";
	$query.= " SET geo_lng = '{$_GET['geo_lng']}', geo_lat = '{$_GET['geo_lat']}' ";
	$query.= " where id $filter";
	return $query;
}

function item_delete() {
	// code...
}

// user functions

function user_all() {
	// code...
}

function user_id() {
	// code...
}

function user_add() {
	// code...
}

function user_edit() {
	// code...
}

function user_delete() {
	// code...
}

// site functions

function site_id() {

	// query
	$query = "SELECT s.name, s.desc, s.logo, s.debug, s.size";
	$query.= " FROM settings s";
	$query.= " WHERE id = 1";

	return $query;
}

function site_edit() {

	// query
	$query = "UPDATE settings";
	$query.= " SET name = '{_GET['name']}', logo = '{_GET['logo']}', debug = '{_GET['debug']}', size = '{_GET['size']}'";
	$query.= " WHERE id = 1";

	return $query;
}

?>