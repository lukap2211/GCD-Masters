<?php
session_start();

// TODO
// show debug
if ($_GET['debug']) {
    echo("<pre>");
    // show all errors
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
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

GCD - MSCDM - Part Time
Luka Puharic - 2828092

Copyright - lukap. 2013.

 -->

<html>
<head>

    <title>Dashboard</title>

    <!-- CSS -->
    <link type="text/css" rel="stylesheet" href="css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="css/bootstrap-responsive.css">
    <link type="text/css" rel="stylesheet" href="css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="css/style.css" />

    <!--[if IE 7]>
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome-ie7.min.css">
    <![endif]-->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    <div id="dashboard_container" class="container">

        <!-- MAIN NAVIGATION -->

        <header id="user_area" data-user-id="<?= $_SESSION['id'] ?>">
            <div class="navbar">
                <div class="navbar-inner">
                    <span class="brand" href="javas"><?="Hi {$_SESSION['username']}" ?></span>
                    <div>
                        <ul class="nav">
                            <li class="dropdown active">
                                <a href="dashboard.php" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-fixed-width icon-home"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a class="set_map" data-map="gcd" href="#"><i class="icon-fixed-width icon-globe"></i> GCD Campus</a></li>
                                    <li><a class="set_map" data-map="smi" href="#"><i class="icon-fixed-width icon-globe"></i> Smithfield Square</a></li>
                                    <li><a class="set_map" data-map="pho" href="#"><i class="icon-fixed-width icon-globe"></i> Phoenix Park</a></li>
                                    <li><a class="set_map" data-map="dub" href="#"><i class="icon-fixed-width icon-globe"></i> Dublin</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-fixed-width icon-cogs"></i> Settings <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a class="user" href="user.php?id=<?= $_SESSION['id'] ?>&amp;action=view"><i class="icon-fixed-width icon-user"></i> Me</a></li>
                                    <?php if ($_SESSION['privilege'] == "admin" ) { ?>
                                    <li><a class="users" href="#"><i class="icon-fixed-width icon-group"></i> Users</a></li>
                                    <li><a class="settings" href="#"><i class="icon-fixed-width icon-globe"></i> Site</a></li>
                                    <?php } ?>
                                    <li class="divider"></li>
                                    <li><a href="logout.php"><i class="icon-fixed-width icon-signout"></i> Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAP CONTROLS -->

        <div id="map-controls">
            <div class="btn-group btn-group-vertical">
                <button id="zoomIn"  class="btn"><i class="icon-plus"></i></button>
                <button id="mapType" data-type-id="1" class="btn"><i class="icon-globe"></i></button>
                <button id="zoomOut" class="btn"><i class="icon-minus"></i></button>
            </div>
        </div>

    </div>


    <!-- MODAL -->

    <div id="modal" class="modal hide fade" data-keyboard="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Modal header</h3>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
        <a href="#" id="edit-item" class="btn btn-primary">Edit</a>
        <a href="#" id="delete-item" class="btn btn-danger">Delete</a>
        </div>
    </div>

    <!-- LEGEND -->

    <div id="footer_wrapper">
        <div id="map-legend" class="container">
            <div class="progress ">
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
    </div>

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


    <!-- JAVASCRIPT -->
    <script src="js/jquery-1.10.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/application.js"></script>

</body>

</html>