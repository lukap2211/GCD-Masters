<!-- Sidebar-->

<aside>

<!-- search -->
<form action="./index.php" method="POST">
	<input id="search" type="text" class="shadow" placeholder="Search" name="search"/>
	<input type="submit" style="display:none"/>
</form>

<?php
// admin section
if(isset($_SESSION['username'])){
	$admin_section = <<<ADMIN
	<h3>Admin Area</h3>
	<ul>
		<li><a class="admin" href='album.php?action=add'>Add Review</a></li>
		<li><a class="admin" href='genre.php'>Genres </a></li>
		<li><a class="admin" href='genre.php?action=add'>Add Genre</a></li>
		<li><a class="admin" href='user.php?action=add'>Add User</a></li>
		<li><a class="admin" href='user.php?action=edit&id={$_SESSION['usr_id']}'>Update Profie</a></li>
	</ul>

ADMIN;
	echo $admin_section;
}
?>

<h3>Stars</h3>
<ul>
<?php
//list stars
$stars = mysql_query("SELECT distinct stars FROM albums WHERE stars > 0 ORDER BY stars desc;");
while($list_stars = mysql_fetch_object($stars)){
	echo "\t<li><a href='index.php?filter=on&amp;stars={$list_stars->stars}'><img src='./images/stars_{$list_stars->stars}.png' alt='stars' /></a></li>\n";
}
?>
</ul>

<h3>Genres</h3>
<ul>
<?php
//list genres
$genres = mysql_query("SELECT g.genre, count(a.gen_id) total FROM genres g left JOIN albums a ON a.gen_id=g.gen_id GROUP BY g.genre ORDER BY
g.genre asc;");
while($list_genres = mysql_fetch_object($genres)){
	echo "\t<li><a href='index.php?filter=on&amp;genre={$list_genres->genre}'>{$list_genres->genre}";
	echo "<span>{$list_genres->total}</span></a></li>\n";
}
?>
</ul>

<h3>Years</h3>
<ul>
<?php
//list years
$years = mysql_query("SELECT distinct year, count(*) total FROM albums WHERE year<>'' GROUP BY year ORDER BY year desc");
while($list_years = mysql_fetch_object($years)){
	echo "\t<li><a href='index.php?filter=on&amp;&year={$list_years->year}'>{$list_years->year}";
	echo "<span>{$list_years->total}</span></a></li>\n";
}
?>
</ul>

</aside>
