<?php
session_start();

// TODO
// show debug
if ($_GET['debug'] == "on") {

    echo("<pre>");

    // show all errors
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    // output session data
    print_r($_SESSION);

    echo("</pre>");
}

// redirect is session empty
if(!isset($_SESSION['username'])){
    header("location:logout.php?login=false");
}
?>
<!DOCTYPE html>

<!--

Copyright 2013 Luka Puharic
http://www.apache.org/licenses/LICENSE-2.0.txt

 -->

<html>
<head>

    <title>Geo CMS Dashboard</title>

    <!-- CSS -->
    <link type="text/css" rel="stylesheet" href="css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="css/bootstrap-responsive.css">
    <link type="text/css" rel="stylesheet" href="css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="css/style.css" />

    <!-- icons -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

    <link rel="apple-touch-icon" href="img/touch-icon-iphone.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="img/touch-icon-ipad.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="img/touch-icon-iphone-retina.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="img/touch-icon-ipad-retina.png" />

    <link rel="apple-touch-startup-image" href="img/touch-icon-ipad-retina.png  ">

    <!-- iPad standalone app -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />



    <!--[if IE 7]>
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome-ie7.min.css">
    <![endif]-->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <!-- <img class="loader" src="img/ajax-loader.gif" /> -->
    </div>

    <!-- MAIN CONTAINER -->
    <header id="dashboard" class="container">

        <!-- MAIN NAVIGATION -->
        <?php include("include/main-nav.php") ?>

        <!-- MAP CONTROLS -->
        <div id="map-controls">
            <div class="btn-group btn-group-vertical">
                <button id="zoomIn"  class="btn"><i class="icon-plus"></i></button>
                <button id="mapType" data-type-id="1" class="btn"><i class="icon-globe"></i></button>
                <button id="zoomOut" class="btn"><i class="icon-minus"></i></button>
            </div>
        </div>

    </header>

    <!-- MODAL USERS -->
    <?php include("include/modal-users.php") ?>

    <!-- MODAL USER -->
    <?php include("include/modal-user.php") ?>

    <!-- MODAL MARKER -->
    <?php include("include/modal-marker.php") ?>

    <!-- MODAL SITE -->
    <?php include("include/modal-site.php") ?>


    <!-- LOCATION -->
    <div id="location" class="info">
        <div class="title float-right"><i class="icon-map-marker"></i></div>
        <p class="muted float-right">
            <span id="my_location">...</span>
         <i class="icon-signal"></i> <span id="my_accuracy">...</span>
        </p>
    </div>

    <!-- DEBUG -->
    <div id="debug" class="info">
        <div class="title float-right"><i class="icon-bug"></i></div>
        <div class="muted float-right">
            <form class="form-inline ">
                <input id="longitude" type="text" value="" class="input-medium" placeholder="longitude">
                <input id="latitude" type="text" value="" class="input-medium" placeholder="latitude">
            </form>
        </div>
    </div>

    <!-- COPYRIGHT -->
    <div id="copyright" class="info">
        <div class="title float-right"><i class="icon-info-sign"></i></div>
        <p class="text-right float-right">Luka Puharic 2013</p>
    </div>

    <!-- LEGEND -->
    <footer id="legend">
        <div class="container">
            <div class="progress">
                <div class="bar activity bar-success" style="width: 0%;">
                    <a href="#" title="" data-original-title="Activity">0</a>
                </div>
                <div class="bar history bar-warning" style="width: 0%;">
                    <a href="#" title="" data-original-title="History">0</a>
                </div>
                <div class="bar study" style="width: 0%;">
                    <a href="#" title="" data-original-title="Study">0</a>
                </div>
                <div class="bar todo bar-danger" style="width: 0%;">
                    <a href="#" title="" data-original-title="To Do!">0</a>
                </div>
            </div>
        </div>

    </footer>

    <!-- JAVASCRIPT -->
    <script src="js/jquery-1.10.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/application.js"></script>

</body>

</html>