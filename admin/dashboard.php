<?php
session_start();

// TODO
// show debug
if ($_GET['debug']) {

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

    <header id="dashboard" class="container">

        <!-- MAIN NAVIGATION -->

        <?php if ($_SESSION['privilege'] == "admin" ) { ?><div class="admin"><span>ADMIN</span></div><?php } ?>

        <div class="navbar">
            <div class="navbar-inner">

                <span id="user" class="brand" href="#" data-user-id=<?=$_SESSION['id']?> data-user-privilege=<?=$_SESSION['privilege']?> > Hi <?=$_SESSION['username']?></span>
                <div>
                    <ul class="nav">
                        <li class="dropdown active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-fixed-width icon-home"></i></a>
                            <ul class="dropdown-menu">
                                <li><a class="set_map" data-map="gcd" href="#"><i class="icon-fixed-width icon-globe"></i> GCD Campus</a></li>
                                <li><a class="set_map" data-map="smi" href="#"><i class="icon-fixed-width icon-globe"></i> Smithfield Square</a></li>
                                <li><a class="set_map" data-map="pho" href="#"><i class="icon-fixed-width icon-globe"></i> Phoenix Park</a></li>
                                <li><a class="set_map" data-map="dub" href="#"><i class="icon-fixed-width icon-globe"></i> Dublin</a></li>
                            </ul>
                        </li>
                        <?php if ($_SESSION['privilege'] == "admin" ) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-fixed-width icon-eye-open"></i> View as <span id="view-as"><?="{$_SESSION['first_name']} {$_SESSION['last_name']}"?></span> <b class="caret"></b> </a>
                            <ul id="viewAsId" class="dropdown-menu">
                                <li class="divider"></li>
                                <li><a class="view_as" data-user-id="<?=$_SESSION['id']?>" data-user-fullname="<?="{$_SESSION['first_name']} {$_SESSION['last_name']}"?>" href="#"><i class="icon-fixed-width icon-remove"></i> Reset</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                    <ul class="nav pull-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-fixed-width icon-cogs"></i> Settings <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a class="user" href="#"><i class="icon-fixed-width icon-wrench"></i> My Settings</a></li>
                                <?php if ($_SESSION['privilege'] == "admin" ) { ?>
                                <li><a class="users" data-slide-index="0" href="users-modal"><i class="icon-fixed-width icon-wrench"></i> Users </a></li>
                                <li><a class="settings" data-slide-index="0" href="site-modal"><i class="icon-fixed-width icon-wrench"></i> Site Settings</a></li>
                                <?php } ?>
                                <li class="divider"></li>
                                <li><a href="logout.php"><i class="icon-fixed-width icon-off"></i> Log Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

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
    <div id="users-modal" class="modal hide fade" data-keyboard="true">
        <div id="users-carousel" class="carousel">
            <!-- CAROUSEL ITEMS -->
            <div class="carousel-inner">
                <!-- ALL USERS -->
                <div class="active item">
                    <!-- HEADER -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>List of Users</h3>
                    </div>
                    <!-- BODY -->
                    <div class="modal-body">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Admin</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- FOOTER -->
                    <div class="modal-footer">
                        <a href="#users-modal" class="btn btn-primary" data-slide-to="3">Add User</a>
                    </div>

                </div>

                <!-- VIEW USER  -->
                <div class="item">
                    <!-- HEADER -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>View User</h3>
                    </div>
                    <!-- BODY -->
                    <div class="modal-body">
                        VIEW USER
                    </div>
                    <!-- FOOTER -->
                    <div class="modal-footer">
                        <a href="#users-modal" class="btn back-to-list" data-slide-to="0">Back to list</a>
                        <a href="#users-modal" class="btn btn-primary" data-slide-to="2"><i class="icon-pencil"></i> Edit</a>
                        <a href="#users-modal" id="delete-item" class="btn btn-danger"><i class="icon-trash"></i> Delete</a>
                    </div>
                </div>

                <!-- EDIT USER  -->
                <div class="item">
                    <!-- HEADER -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Edit User</h3>
                    </div>
                    <!-- BODY -->
                    <div class="modal-body">
                        EDIT USER
                    </div>
                    <!-- FOOTER -->
                    <div class="modal-footer">
                        <a href="#users-modal" class="btn" data-slide-to="1"><i class="icon-remove"></i> Cancel</a>
                        <a href="#users-modal" class="btn btn-primary" data-slide-to="11"><i class="icon-ok"></i> Save</a>
                    </div>
                </div>

                <!-- ADD USER  -->
                <div class="item">
                    <!-- HEADER -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Add User</h3>
                    </div>
                    <!-- BODY -->
                    <div class="modal-body">
                        ADD USER
                    </div>
                    <!-- FOOTER -->
                    <div class="modal-footer">
                        <a href="#users-modal" class="btn back-to-list" data-slide-to="0">Back to list</a>
                        <a href="#users-modal" class="btn btn-primary" data-slide-to="2">Add</a>
                    </div>
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