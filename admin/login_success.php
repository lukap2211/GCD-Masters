<?
session_start();
if(!session_is_registered("username")){
	header("location:login.php");
}else {
	// header("location:user.php?action=view&id={$_SESSION['id']}");
	header("location:user.php");
}
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>

<html>
<body>
Login Successful
</body>
</html>