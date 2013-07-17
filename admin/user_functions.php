 <?php

// user functions

function view_user($usr_id,$action){

	global $conn, $filter;

	// get user
	$query = "SELECT u.id, u.username, u.bio, u.first_name, u.last_name";
	$query.= " FROM users u";
	$query.= " WHERE u.id = $usr_id;";

	// echo "$query";
	$result = mysqli_query($conn,$query);
	$count = mysqli_num_rows($result);
	if($count){

		while($row = mysqli_fetch_assoc($result)){
			extract($row);

			$bio = nl2br($bio);
			//view user user_details
			$view_user = <<<VIEW

	<article class='alert'>
		<h2>{$username}</h2>
		<span >First Name: {$first_name}</span></a><br />
		<span >Last name: {$last_name}</span> </a><br />
		<div class='bio'>{$bio}</div>
	</article>

VIEW;
			echo $view_user;

		}

		// admin section
		if(isset($_SESSION['username'])){
			$admin_section = <<<ADMIN

	<div class="form-actions">

	<ul class="inline">
		<li><a class="btn btn-primary" href='user.php?action=add' >Add User</a></li>
		<li><a class="btn btn-danger" href='user.php?id={$usr_id}&amp;action=delete' onclick="if(!confirm('Delete?')) return false;">Delete User</a></li>
		<li><a class="btn btn-warning" href='user.php?id={$usr_id}&amp;action=edit'>Edit User</a></li>
	</ul>
	</div>
ADMIN;
			echo $admin_section;
		}

		// get 10 most recent reviews by user
		$query = "SELECT c.id, c.title, t.type, c.content, c.excerpt, c.date, c.date_modified, c.status, u.id as user_id, u.username, t.type";
		$query.= " FROM contents c, users u, types t";
		$query.= " WHERE c.user_id = u.id and c.type_id = t.id $filter";
		$query.= " ORDER BY c.date desc limit 0,10;";

		$result = mysqli_query($conn,$query);
		$count = mysqli_num_rows($result);
		if($count){
			echo "<ul class='unstyled'>";

			while($row = mysqli_fetch_assoc($result)){
				extract($row);
				echo "<pre>";
				print_r($row);
				echo "</pre>";

				$excerpt = substr($excerpt,0,400)."...";
				$list_items_by_user = <<<LIST

	<li>
		<h2>{$title}</h2>
		<div class='published'>Published: <strong>{$date}</strong> by {$username}</div>
		<div class='published'>Modified: <strong>{$date_modified}</strong></div>
		<div class='details'>
			<span class='type'>Type: {$type}</span> |
			<span class='stars'>Geo Longitude: {geo_lon}</span>
			<span class='stars'>Geo Latitude: {geo_lat}</span>
		</div>
		<div class="clear"></div>
		<div class='full_review'><a href='album.php?id={$id}&amp;action=view'>Read full review</a></div>
	</li>
LIST;

				// echo $list_reviews_by_user;
			}
			echo "</ul>";
		}

	// USER DOESNT EXIST
	} else {

		$view_user = <<<VIEW

	<article class="alert alert-error">
		User with id = $usr_id doesn't exist!
	</article>
VIEW;
		echo $view_user;
	}
}

function add_user(){

	global $conn;

	//add user details
	$add_user = <<<ADD

	<article>
		<h2>Add User</h2>
		<form action="user.php" method="post">
		<p>
			<label>Username:</label>
			<input type="text" name="username" value="" />
		</p>
		<p>
			<label>Password:</label>
			<input type="password" name="password" value="" />
		</p>
		<p>
			<label>First Name:</label>
			<input type="text" name="first_name" value="" />
		</p>

		<p>
			<label>Last Name:</label>
			<input type="text" name="last_name" value="" />
		</p>
		<div class='review'>
			<label>Bio:</label>
			<textarea rows="20" cols="70" name="bio"></textarea>
			<div class="clear"></div>
		</div>
		<input type="hidden" name="action" value="add" />

		<div class="form-actions">
		  <button type="submit" class="btn btn-primary">Save changes</button>
		  <a class="btn" href="user.php?action=view&amp;id={$usr_id}"/>Cancel</a>
		</div>

		</form>

	</article>\n

ADD;

	echo $add_user;
}

function add_user_success($username,$password,$first_name,$last_name,$bio){

	global $conn,$error;

	// crypt password
	$hashed_password = md5($password);

	if ($error) {
		add_user();
	} else {

		// get user details
		$query = "INSERT INTO users ";
		$query.= " (username, password, bio, first_name, last_name)";
		$query.= " VALUES ('{$username}','{$hashed_password}', '{$bio}', '{$first_name}', '{$last_name}');";

 		// echo "Query: $query";

		$result = mysqli_query($conn, $query);
		$count = mysqli_num_rows($result);

		if ($count){
			echo "<div class='message'>User added!</div>";
		} else {
			printf("<div class='error'>ERROR: %s!</div>",mysql_error());
		}

		view_user(mysqli_insert_id(),'view');
	}
}

function edit_user($usr_id,$action){

	global $conn;

	// get user
	$query = "SELECT u.id, u.username, u.password, u.bio, u.first_name, u.last_name";
	$query.= " FROM users u";
	$query.= " WHERE u.id = $usr_id;";

	$result = mysqli_query($conn,$query);
	$count = mysqli_num_rows($result);
	if($count){

		while($row = mysqli_fetch_assoc($result)){

			extract($row);

			//edit user details
			$edit_user = <<<EDIT

	<article>
		<h2>Edit User</h2>
		<form action="user.php" method="post">
		<p>
			<label>Username:</label>
			<input type="text" name="username" value="{$username}" />
		</p>
		<p>
			<label>Password:</label>
			<input type="password" name="password" value="{$password}" disabled />
		</p>
		<p>
			<label>First Name:</label>
			<input type="text" name="first_name" value="{$first_name}" />
		</p>

		<p>
			<label>Last Name:</label>
			<input type="text" name="last_name" value="{$last_name}" />
		</p>

		<div class='review'>
			<label>Bio:</label>
			<textarea rows="20" cols="70" name="bio">{$bio}</textarea>
			<div class="clear"></div>
		</div>
		<input type="hidden" name="action" value="edit" />
		<input type="hidden" name="usr_id" value="{$usr_id}" />

		<div class="form-actions">
		  <button type="submit" class="btn btn-primary">Save changes</button>
		  <a class="btn" href="user.php?action=view&amp;id={$usr_id}"/>Cancel</a>
		</div>
		</form>

	</article>\n

EDIT;

			echo $edit_user;
		}
	}
}

// function edit_user_success($username,$password,$first_name,$last_name,$bio,$usr_id){
function edit_user_success($username,$first_name,$last_name,$bio,$usr_id){

	global $conn,$error;

	// crypt password
	// $hashed_password = md5($password);

	if ($error) {
 		// edit_user();
	} else {

		// update user
		$query = "UPDATE users";
		// $query.= " SET username = '{$username}', password = '{$hashed_password}', bio = '{$bio}', ";
		$query.= " SET username = '{$username}',  bio = '{$bio}', ";
		$query.= " first_name = '{$first_name}', last_name = '{$last_name}'";
		$query.= " WHERE id= {$usr_id};";

		// echo "$query";
		$result = mysqli_query($conn,$query);

		// $count = mysqli_num_rows($result);
		// if($count){

			// while($row = mysqli_fetch_assoc($result)){
				// extract($row);

		// $result = mysql_query($query,$conn);

		if ($result){
			echo "<div class='alert alert-success'><b>Success:</b> User details updated! </div>";
		} else {
			printf("<div class='error'>ERROR: %s! </div>",mysql_error());
		}

		view_user($usr_id,'view');
	}
}

function delete_user($usr_id,$action){

	global $conn;

	//check if user exist
	$query = "SELECT usr_id FROM users WHERE usr_id = $usr_id;";
	$result = mysql_query($query,$conn);
	if (mysql_num_rows($result) < 1) {
		echo "<div class='error'>ERROR: User id = $usr_id doesn't exist!</div>";
	} else {

		// delete user
		$query = "DELETE FROM users WHERE usr_id = $usr_id;";
		$result = mysql_query($query,$conn);

		if ($result){
			echo "<div class='message'>User deleted! </div>";
		} else {
			printf("<div class='error'>ERROR: %s! </div>",mysql_error());
		}
	}
}
?>