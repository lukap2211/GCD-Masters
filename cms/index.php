<?php
// login check
ob_start();

session_start();

if (!empty($_GET['a']) && in_array($_GET['a'], array("signedOut", "showError"))) {
    switch ($_GET['a']) {
        case 'signedOut':
            $error_message = "You are now signed out!";
            break;

        case 'showError':
            $error_message = "You are now signed out!";
            break;

        default:
            die("action not recognized!");
            break;
    }

} else {


    // if logged in redirect to admin area
    if(!session_is_registered("username")){

        // open connection
        require("include/connect.php");

        // login form validation
        $error_message = NULL;
        $username = NULL;
        $password = NULL;

        // validate username
        if(!empty($_POST['username']) && is_string($_POST['username'])){
            $username = $_POST['username'];
        }else{
            $error_message = "<li>Please insert username</li>";
        }

        // validate password
        if(!empty($_POST['password']) && is_string($_POST['password'])){
            $password = $_POST['password'];
        }else{
            $error_message .= "<li>Please insert password</li>";
        }

        if(!$error_message){

            // MySQL injection prevention
            if (!get_magic_quotes_gpc()) {
                $username = stripslashes($username);
                $password = stripslashes($password);
            }
            $username = mysqli_real_escape_string($conn, $username);
            $password = mysqli_real_escape_string($conn, $password);


            // crypt password
            $hashed_password = md5($password);

            // DEBUG
            // echo "$hashed_password <br />";

            // check if there is a match in db
            $query = "SELECT u.username, u.password, u.first_name, u.last_name, u.id, p.privilege FROM users u, privileges p";
            $query.= " WHERE u.username = '$username'";
            $query.= " AND u.password = '$hashed_password' AND u.privilege_id = p.id";

            // echo $query;

            $result = mysqli_query($conn,$query);
            $count = mysqli_num_rows($result);
            if($count){
                // while($row = $result->fetch_array()){
                while($row = mysqli_fetch_array($result)){
                    extract($row);
                    // register $username, $password and redirect to file "login_success.php"
                    session_register("username");
                    session_register("hashed_password");
                    session_register("id");
                    session_register("privilege");
                    session_register("first_name");
                    session_register("last_name");
                    header("location:login_success.php");
                }

            } else {
                // errorlukapin_masters
                $error_message .= "<li>Wrong username or password</li>";
            }

        }

    } else {
        // header("location:user.php?action=view&id={$_SESSION['id']}");
        header("location:dashboard.php");
    }

}
?>
<!DOCTYPE html>

<!--

Copyright 2013 Luka Puharic
http://www.apache.org/licenses/LICENSE-2.0.txt

 -->

<html>
<head>

    <meta charset="utf-8">
    <title>Geo CMS</title>

    <!-- CSS -->
    <link type="text/css" rel="stylesheet" href="css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="css/bootstrap-responsive.css">
    <link type="text/css" rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="css/style.css" />

    <!-- icons -->
    <link rel="shortcut icon" href="../assets/icons/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../assets/icons/favicon.ico" type="image/x-icon">

    <link rel="apple-touch-icon" href="../assets/icons/touch-icon-iphone.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="../assets/icons/touch-icon-ipad.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="../assets/icons/touch-icon-iphone-retina.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="../assets/icons/touch-icon-ipad-retina.png" />

    <!--[if IE 7]>
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome-ie7.min.css">
    <![endif]-->

    <!-- iPad standalone app -->
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->

    <!-- GOOGLE MAPS API -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.6&sensor=false"></script>

</head>

<body data-spy="scroll" data-target=".navbar">

    <!-- GOOGLE MAP CANVAS -->

    <div id="map-canvas">
        <div class="loader"></div>

        <div class="loader progress active progress-success progress-striped">
          <div class="bar" style="width: 1000%"></div>
        </div>
    </div>


    <section id='login_container' class='container'>
<?php
// throw error
if($error_message) {
    echo "<div class='alert alert-error'><strong>Warning!</strong><button type='button' class='close' data-dismiss='alert'>x</button><br /><br /><ul>$error_message</ul></div>";
}

// login form
include("include/login_form.php");

?>
    </section>

    <!-- JAVASCRIPT -->
    <script src="../assets/js/jquery-1.10.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/cms.js"></script>

    <script>
        GM.options.draggable = false;
        GM.currentMap = "smi"; // default map on dashboard
        GM.dashboard = false;
        GM.init();
    </script>

    <!-- GOOGLE ANALYTICS  -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-43664547-2', 'lukap.info');
        ga('send', 'pageview');

    </script>

</body>

</html>
<?php
ob_end_flush();
?>