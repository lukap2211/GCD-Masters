<?php

// API functions

// content functions

function item_all() {

    $filter = "";
    // by map
    if(!empty($_GET['map']) && is_string($_GET['map'])){
        $filter .= "AND c.map = '{$_GET['map']}'";
    }

    // by type
    if(!empty($_GET['type']) && is_string($_GET['type'])){
        $filter .= " AND t.type = '{$_GET['type']}'";
    }

    // by user id (view as user)
    if(!empty($_GET['id']) && is_string($_GET['id'])){
        $filter .= " AND u.id = '{$_GET['id']}'";
    }

    // query
    $query = "SELECT c.id, c.title, t.type, c.content, c.excerpt, c.date, c.status, u.id as user_id, c.geo_lat, c.geo_lng, u.username, c.category, t.type";
    $query.= " FROM contents c, users u, types t";
    $query.= " WHERE c.user_id = u.id AND c.type_id = t.id $filter";
    $query.= " ORDER BY c.category ASC, c.date DESC";

    // output
    run_query($query);
}

function item_legend() {

    $filter = "";
    // by map
    if(!empty($_GET['map']) && is_string($_GET['map'])){
        $filter .= "AND c.map = '{$_GET['map']}'";
    }

    // by type
    if(!empty($_GET['type']) && is_string($_GET['type'])){
        $filter .= " AND t.type = '{$_GET['type']}'";
    }

    // by user id (view as user)
    if(!empty($_GET['id']) && is_string($_GET['id'])){
        $filter .= " AND u.id = '{$_GET['id']}'";
    }

    // query
    $query = "SELECT count(*) as total, c.category";
    $query.= " FROM contents c, users u, types t";
    $query.= " WHERE c.user_id = u.id and c.type_id = t.id $filter";
    $query.= " GROUP BY c.category";
    $query.= " ORDER BY c.category ASC";

    // output
    run_query($query);
}

function item_id() {

    $filter = "";
    // by id
    if(!empty($_GET['id']) && intval($_GET['id'])){
        $filter .= " AND c.id = '{$_GET['id']}'";
    }

    // query
    $query = "SELECT c.id, c.title, t.type, c.content, c.excerpt, c.date, c.status, u.id as user_id, c.geo_lat, c.geo_lng, u.username, c.category, t.type";
    $query.= " FROM contents c, users u, types t";
    $query.= " WHERE c.user_id = u.id AND c.type_id = t.id $filter";

    run_query($query);
}

function item_add() {
    // query
    $query = "INSERT INTO contents";
    $query.= " (id, user_id, type_id, date, date_modified, geo_lng, geo_lat, map, category)  ";
    $query.= " VALUES (NULL, '{$_GET['user_id']}', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '{$_GET['geo_lng']}', '{$_GET['geo_lat']}', '{$_GET['map']}', '{$_GET['category']}')";
    run_query($query);
}

function item_edit() {
    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);

    // echo "<pre>";
    // print_r($_FILES["file"]);
    // echo "</pre>";

    if ((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/x-png")
        || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 1048576)
        && in_array($extension, $allowedExts)){

            if ($_FILES["file"]["error"] > 0) {
                echo "Error: " . $_FILES["file"]["error"] . "<br>";
            } else {

                $image_file = file_get_contents($_FILES["file"]["tmp_name"]);
                $image_name = $_FILES["file"]["name"];

                // if (file_exists("upload/" . $_FILES["file"]["name"])) {
                //     echo $_FILES["file"]["name"] . " already exists. ";
                // } else {
                //     move_uploaded_file($_FILES["file"]["tmp_name"],
                //     "upload/" . $_FILES["file"]["name"]);
                //     echo "Stored in: " . "../upload/" . $_FILES["file"]["name"];
                // }
            }
    } else {
        echo "Invalid file";
    }

    // query
    // TODO type, user
    $query = "UPDATE contents";
    $query.= " SET user_id = '{$_GET['user_id']}', title = '{$_GET['title']}', date_modified = CURRENT_TIMESTAMP,";
    $query.= " content = '{$_GET['content']}', category = '{$_GET['category']}', image = " . mysql_real_escape_string($image_file) . ", image_name = {$image_name}";
    $query.= " WHERE id = {$_GET['id']};";

    echo "$query";
    run_query($query);

}

function item_edit_loc() {

    $filter = "";

    // by id
    if(!empty($_GET['id']) && intval($_GET['id'])){
        $filter .= " AND id = '{$_GET['id']}'";
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
    $query.= " WHERE id $filter";
    run_query($query);
}

function item_delete() {

    $filter = "";

    // by id
    if(!empty($_GET['id']) && intval($_GET['id'])){
        $filter .= "id in ('{$_GET['id']}')";
    }
    // query
    $query = "DELETE FROM contents";
    $query.= " WHERE $filter";
    run_query($query);

}

// user functions

function users_all() {

    $filter = "";

    // ignore id
    if(!empty($_GET['ignore']) && intval($_GET['ignore'])){
        $filter .= "AND u.id <> '{$_GET['ignore']}'";
    }

    // query
    $query = "SELECT u.id, u.username, u.first_name, u.last_name, u.bio, p.privilege";
    $query.= " FROM users u, privileges p";
    $query.= " WHERE u.privilege_id = p.id $filter";
    run_query($query);
}

function user_id() {

    $filter = "";

    // by id
    if(!empty($_GET['id']) && intval($_GET['id'])){
        $filter .= " AND u.id = '{$_GET['id']}'";
    }

    // query
    $query = "SELECT u.id, u.username, u.bio, u.first_name, u.last_name, p.privilege";
    $query.= " FROM users u, privileges p";
    $query.= " WHERE u.privilege_id = p.id $filter";
    run_query($query);
}

function user_add() {
    // code...
}

function user_edit() {

    $hashed_password = "";

    // crypt password
    if (!empty($_GET['pass'])) {
        $hashed_password = ", password = '". md5($_GET['pass']) ."'";
    }

    // query
    $query = "UPDATE users";
    $query.= " SET first_name = '{$_GET['first_name']}', last_name = '{$_GET['last_name']}', bio = '{$_GET['bio']}' $hashed_password";
    $query.= " WHERE id = {$_GET['id']};";

    run_query($query);

}

function user_delete() {
    // code...
}

// site functions

function site_id() {

    // query
    $query = "SELECT s.name, s.desc, s.logo, s.debug, s.size, s.debug, s.location, s.legend ";
    $query.= " FROM settings s";
    $query.= " WHERE id = 1";

    run_query($query);
}

function site_edit() {

    // set checkbox values
    $debug = (!empty($_GET['debug']) && ($_GET['debug'] = 'on')) ? 1 : 0;
    $location = (!empty($_GET['location']) && ($_GET['location'] = 'on')) ? 1 : 0;
    $legend = (!empty($_GET['legend']) && ($_GET['legend'] = 'on')) ? 1 : 0;

    // query
    $query = "UPDATE settings s";
    $query.= " SET s.name = '{$_GET['name']}', s.desc = '{$_GET['desc']}', s.debug = {$debug}, s.location = {$location}, s.legend = {$legend}";
    $query.= " WHERE id = 1";

    run_query($query);
}

function run_query ($query) {

    global $a, $conn;

    if ($query != "") {

        $result = mysqli_query($conn, $query);

        $json["query"] = $query;

        // error check
        if(!$result) {

            $json["error"] = "ERROR: " . mysqli_error($conn);

        } else {

            // for add, edit, delete
            if (in_array($a, array("edit", "edit_loc", "delete"))) {

                // $json["result"] = mysqli_affected_rows($conn);
                $json["result"]= $conn->affected_rows;

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


}

?>