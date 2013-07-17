<?php
//album functions
function view_album($album_id,$action){

	global $conn;

	// get album
	$query = "SELECT a.id, a.title, a.artist, a.review, a.review_date, a.stars, a.year, u.usr_id, u.username, g.genre, g.gen_id";
	$query.= " FROM albums a, users u, genres g";
	$query.= " WHERE a.usr_id = u.usr_id and a.gen_id = g.gen_id and a.id = $album_id;";
	
	$result = mysql_query($query,$conn);	
		
	while($row = mysql_fetch_array($result)){
		extract($row);

	$review = nl2br ($review);
	//view album details
	$view_album = <<<VIEW

<article>
	<h2>{$title}</h2>
	<div class='published'>Published: <strong>{$review_date}</strong> by <a href='user.php?id={$usr_id}&amp;action=view'>{$username}</a></div>
		<div class='details'>
			<span class='artist'>Artist: <a href='index.php?filter=on&amp;artist={$artist}'>{$artist}</a></span> | 
			<span class='year'>Year: <a href='index.php?filter=on&amp;year={$year}'>{$year}</a></span> | 
			<span class='genre'>Genre: <a href='index.php?filter=on&amp;genre={$genre}'>{$genre}</a></span> |
			<span class='stars'>Stars: <a href='index.php?filter=on&amp;stars={$stars}'><img src='./images/stars_{$stars}.png' alt="stars"/></a></span>
		</div>
	<div class="clear"></div>
	<br />
	<div class='review'>{$review}</div>
</article>\n

VIEW;

	echo $view_album;
	}

	// admin section
	if(isset($_SESSION['username'])){
		$admin_section = <<<ADMIN

		<ul class="admin_area">
			<li><a class="admin delete" href='album.php?id={$album_id}&amp;action=delete' onclick="if(!confirm('Delete?')) return false;">Delete  Review</a></li>
			<li><a class="admin" href='album.php?id={$album_id}&amp;action=edit'>Edit Review</a></li>
	
		</ul>
ADMIN;
	echo $admin_section;
	}	
	
}

function add_album(){

	global $conn;

	//get genre details
	
	$genre_query = "SELECT gen_id, genre FROM genres"; 
	$genres = mysql_query($genre_query); 

	$options = ""; 
		
	while ($genres_row = mysql_fetch_array($genres)) { 
	
	    $gen_id = $genres_row["gen_id"]; 
	    $gen_genre = $genres_row["genre"]; 
	    $options .= "<option value=\"$gen_id\">".$gen_genre."</option>"; 
	} 

	//add album details
	$add_album = <<<ADD

<article>
	<h2>Add Review</h2>
	<form action="album.php" method="post">
	<p class='title'>
		<label>Album Title:</label>	
		<input type="text" name="title" size="50" value="{$_POST['title']}" />	
	</p>	<p class='artist'>
		<label>Artist:</label>	
		<input type="text" name="artist" size="50" value="{$_POST['artist']}" />	
	</p>
	<p class='year'>
		<label>Year:</label>
	 	<input type="text" name="year" maxlength="4" size="4" value="{$_POST['year']}" />
	</p>
	<p class='genre'>
		<label>Genre:</label>
		<select name='gen_id' id="genre"> 
			<option value = 0></options>
			{$options}
		</select> 
	</p>
	<p class='stars'> 	
		<label>Stars:</label>
		<select name="stars" id="stars">
		  <option value="1">1 star</option>
		  <option value="2">2 stars</option>
		  <option value="3">3 stars</option>
		  <option value="4">4 stars</option>
		  <option value="5">5 stars</option>
		</select>
	</p>	
	<div class='review'>
		<label>Review:</label>
		<textarea rows="20" cols="60" name="review">{$_POST['review']}</textarea>
		<div class="clear"></div>
	</div>
	<input type="hidden" name="usr_id" value="{$_SESSION['usr_id']}" />
	<input type="hidden" name="action" value="add" />
	<p><input type="submit" /> <a class="" href="index.php"/>Cancel</a></p>
	</form>
	<script>
		document.getElementById("genre").value = {$_POST['gen_id']};
		document.getElementById("stars").value = {$_POST['stars']};
	</script>
	
</article>\n

ADD;

	echo $add_album;
}

function add_album_success($title,$artist,$review,$stars,$year,$usr_id,$gen_id){

	global $conn,$error;
	
	if ($error) {
		add_album();
	} else {

		//get genre details	
		$genre_query = "SELECT gen_id, genre FROM genres"; 
		$genres=mysql_query($genre_query); 
	
		$options=""; 
			
		while ($genres_row=mysql_fetch_array($genres)) { 
		
		    $gen_gen_id = $genres_row["gen_id"]; 
		    $gen_genre = $genres_row["genre"]; 
		    $options .= "<option value=\"$gen_gen_id\">".$gen_genre."</option>"; 
		} 
	
		// get album details
		$query = "INSERT INTO albums ";
		$query.= " (title, artist, review, review_date, stars, year, usr_id, gen_id)";
		$query.= " VALUES ('{$title}','{$artist}', '{$review}', NOW(), '{$stars}', '{$year}', '{$usr_id}', '{$gen_id}');";
		
/* 		echo "Query: $query"; */
		
		$result = mysql_query($query,$conn);
		if ($result){
			echo "<div class='message'>Review added! </div>";
		} else {
			printf("<div class='error'>ERROR: %s! </div>",mysql_error());		
		}

		view_album(mysql_insert_id(),'view');
	}
}

function edit_album($album_id,$action){

	global $conn;

	//get genre details	
	$genre_query = "SELECT gen_id, genre FROM genres"; 
	$genres=mysql_query($genre_query); 

	$options=""; 
		
	while ($genres_row=mysql_fetch_array($genres)) { 
	
	    $gen_id = $genres_row["gen_id"]; 
	    $gen_genre = $genres_row["genre"]; 
	    $options .= "<option value=\"$gen_id\">".$gen_genre."</option>"; 
	} 

	// get album details
	$query = "SELECT a.id, a.title, a.artist, a.review, a.review_date, a.stars, a.year, u.usr_id, u.username, g.gen_id";
	$query.= " FROM albums a, users u, genres g";
	$query.= " WHERE a.usr_id = u.usr_id and a.gen_id = g.gen_id and a.id = $album_id;";
	
	$result = mysql_query($query,$conn);	
		
	while($row = mysql_fetch_array($result)){
		extract($row);

	//edit album details
	$edit_album = <<<EDIT

<article>
	<h2>Edit Review</h2>
	<form action="album.php" method="post">
	<p class='title'>
		<label>Album Title:</label>	
		<input type="text" name="title" size="50" value="{$title}" />	
	</p>	<p class='artist'>
		<label>Artist:</label>	
		<input type="text" name="artist" size="50" value="{$artist}" />	
	</p>
	<p class='year'>
		<label>Year:</label>
	 	<input type="text" name="year" maxlength="4" size="4" value="{$year}" />
	</p>
	<p class='genre'>
		<label>Genre:</label>
		<select name='gen_id' id="genre"> 
			{$options}
		</select> 
	</p>
	<p class='stars'> 	
		<label>Stars:</label>
		<select name="stars" id="stars">
		  <option value="1">1 star</option>
		  <option value="2">2 stars</option>
		  <option value="3">3 stars</option>
		  <option value="4">4 stars</option>
		  <option value="5">5 stars</option>
		</select>
	</p>
	<div class='review'>
		<label>Review:</label>
		<textarea rows="20" cols="70" name="review">{$review}</textarea>
		<div class="clear"></div>
	</div>
	<input type="hidden" name="action" value="edit" />
	<input type="hidden" name="id" value="{$id}" />
	<input type="hidden" name="usr_id" value="{$_SESSION['usr_id']}" />
	<p><input class="admin" type="submit" /> <a class="" href="album.php?action=view&amp;id={$id}"/>Cancel</a></p>
	</form>
	<script>
		document.getElementById("genre").value = {$gen_id};
		document.getElementById("stars").value = {$stars};
	</script>	
</article>\n

EDIT;

		echo $edit_album;
	}
}

function edit_album_success($title,$artist,$review,$stars,$year,$usr_id,$gen_id,$id){

	global $conn,$error;
	

	if ($error) {
/* 		edit_album(); */
	} else {

		//get genre details	
		$genre_query = "SELECT gen_id, genre FROM genres"; 
		$genres = mysql_query($genre_query); 
	
		$options = ""; 
			
		while ($genres_row = mysql_fetch_array($genres)) { 
		
		    $gen_gen_id=$genres_row["gen_id"]; 
		    $gen_genre=$genres_row["genre"]; 
		    $options.="<option value=\"$gen_gen_id\">".$gen_genre."</option>"; 
		} 
	
		// get album details
		$query = "UPDATE  albums ";
		$query.= " SET title = '{$title}', artist = '{$artist}', review = '{$review}', review_date = NOW(),"; 
		$query.= " stars = {$stars}, year = {$year}, usr_id = {$usr_id}, gen_id = {$gen_id}";
		$query.= " WHERE id= {$id};";
		
/* 		echo "Query: $query"; */
		
		$result = mysql_query($query,$conn);
		
		if ($result){
			echo "<div class='message'>Review updated! </div>";
		} else {
			printf("<div class='error'>ERROR:  %s! </div>",mysql_error());		
		}

		view_album($id,'view');
	}
}

function delete_album($album_id,$action){

	global $conn;

	// check id
	$query = "SELECT FROM albums WHERE id = $album_id;";
	$result = mysql_query($query,$conn);
	
	if (mysql_num_rows($result) < 1) {
		echo "<div class='error'>Review with id = $album_id doesn't exixst!</div>";
	} else {
			
		// delete album
		$query = "DELETE FROM albums WHERE id = $album_id;";
		$result = mysql_query($query,$conn);
		
		if ($result){
			echo "<div class='message'>Review deleted! </div>";
		} else {
			printf("<div class='error'>ERROR: %s!</div>",mysql_error());		
		}	
	}	


}
?>