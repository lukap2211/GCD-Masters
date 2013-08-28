<!DOCTYPE html>

<!--

Copyright 2013 Luka Puharic
http://www.apache.org/licenses/LICENSE-2.0.txt

 -->

<html>
<head>

    <title>Geo App</title>

    <!-- Responsive CSS -->
    <link type="text/css" rel="stylesheet" href="css/style.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="css/style-600.css" media="only screen and (min-width: 600px)" />
    <link type="text/css" rel="stylesheet" href="css/style-800.css" media="only screen and (min-width: 800px)" />
    <link type="text/css" rel="stylesheet" href="css/style-1100.css" media="only screen and (min-width: 1100px)" />

    <!-- Font Awsome -->
    <link type="text/css" rel="stylesheet" href="../assets/css/font-awesome.min.css">

    <!-- Roboto - Free Font from Google -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>

    <!-- icons -->
    <link rel="icon" href="../assets/icons/favicon-app.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/icons/favicon-app.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="../assets/icons/touch-icon-iphone.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="../assets/icons/touch-icon-ipad.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="../assets/icons/touch-icon-iphone-retina.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="../assets/icons/touch-icon-ipad-retina.png" />

    <link rel="apple-touch-startup-image" href="../assets/icons/touch-icon-ipad-retina.png">

    <!-- iPad standalone app -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

    <meta name="viewport" content="width=321, initial-scale=1.0">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->

    <!-- GOOGLE MAPS API -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.6&sensor=false"></script>

</head>

<body>

    <!-- MAIN HEADER -->
    <header class="main">
        <div class="banner-wrapper">
            <a class="logo" href="#siteInfo" ><img src="../assets/icons/logo.png" />
                <h1></h1>
            </a>
            <div class="toggle-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <!-- MAIN NAVIGATION -->
        <nav class="header-nav">
            <ul class="nav-list">
                <li><a class="button all" href="#">Show All</a></li>
                <li><a class="button nearby" href="#">Show Nearby</a></li>
                <li><a class="button category">Filter by Category</a></li>
                <li><a class="button legal">Terms And Conditions</a></li>
            </ul>
            <ul class="nav-list close">
                <li><a class="button black" href="javascript:void(0);"><i class="icon-remove"></i></a></li>
            </ul>
            </div>
        </nav>
    </header>

    <!-- GOOGLE MAP CANVAS -->
    <div id="map-wrapper">
        <div id="map-canvas">
            <div class="loader"></div>
        </div>
    </div>

    <!-- MAP CONTROLS -->
    <div id="map-controls">
        <div class="btn-group btn-group-vertical">
            <button id="zoomIn"  class="button"><i class="icon-plus"></i></button>
            <button id="mapType" data-type-id="1" class="button"><i class="icon-globe"></i></button>
            <button id="zoomOut" class="button"><i class="icon-minus"></i></button>
        </div>
    </div>

    <article>
        <a class="scrollTop" href="#">Back to top <i class="icon-arrow-up"></i></a>
        <header>Content Title!</header>
        <div class="location">
            <img src="http://maps.googleapis.com/maps/api/staticmap?markers=icon:http://lukap.info/gcd/masters/admin/img/pin_todo_small.png|53.349379,-6.278376|shadow:true&center=53.349379,-6.278376&zoom=17&maptype=hybrid&size=1060x500&sensor=false" />
        </div>
        <div class="body">
            <div class="content">Content Comes Here!</div>
        </div>

        <footer>Social LINKS</footer>
    </article>


    <!-- FOOTER -->
    <hr />
    <footer class="main">

    <h2>SITE INFO</h2>
        <ul>
            <li><a href="#">Terms And Conditions</a></li>
            <li><a href="#">Terms And Conditions</a></li>
            <li><a href="#">Terms And Conditions</a></li>
            <li class="admin"><a href="/admin">Admin</a></li>
        </ul>
        <ul>
            <li><a class="set_map button" data-map="gcd" href="#">GCD Campus</a></li>
            <li><a class="set_map button" data-map="smi" href="#">Smithfield Square</a></li>
            <li><a class="set_map button" data-map="pho" href="#">Phoenix Park</a></li>
            <li><a class="set_map button" data-map="dub" href="#">Dublin</a></li>
        </ul>

    </footer>

    <!-- JAVASCRIPT -->
    <script src="..//assets/js/jquery-1.10.1.min.js"></script>
    <script src="js/app.js"></script>

</body>

</html>