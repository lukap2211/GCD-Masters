<!DOCTYPE html>

<!--

Copyright 2013 Luka Puharic
http://www.apache.org/licenses/LICENSE-2.0.txt

 -->

<html>
<head>

    <title>Geo CMS</title>

    <!-- Responsive CSS -->
    <link type="text/css" rel="stylesheet" href="include/style.css" media="screen" />
    <link type="text/css" rel="stylesheet" href="include/style-600.css" media="only screen and (min-width: 600px)" />
    <link type="text/css" rel="stylesheet" href="include/style-800.css" media="only screen and (min-width: 800px)" />
    <link type="text/css" rel="stylesheet" href="include/style-1100.css" media="only screen and (min-width: 1100px)" />

    <!-- icons -->
    <link rel="icon" href="include/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="include/icons/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="include/icons/touch-icon-iphone.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="include/icons/touch-icon-ipad.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="include/icons/touch-icon-iphone-retina.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="include/icons/touch-icon-ipad-retina.png" />

    <link rel="apple-touch-startup-image" href="include/icons/touch-icon-ipad-retina.png  ">

    <!-- iPad standalone app -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->

    <!-- GOOGLE MAPS API -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.6&sensor=false"></script>

</head>

<body data-spy="scroll" data-target=".navbar">

    <!-- GOOGLE MAP CANVAS -->
    <div id="map-canvas">
        <div class="loader"></div>
    </div>

    <!-- MAIN CONTAINER -->
    <header id="dashboard" class="container">

        <!-- MAIN NAVIGATION -->
        <>

        <!-- MAP CONTROLS -->
        <div id="map-controls">
            <div class="btn-group btn-group-vertical">
                <button id="zoomIn"  class="btn"><i class="icon-plus"></i></button>
                <button id="mapType" data-type-id="1" class="btn"><i class="icon-globe"></i></button>
                <button id="zoomOut" class="btn"><i class="icon-minus"></i></button>
            </div>
        </div>

    </header>

    <!-- COPYRIGHT -->
    <div id="copyright" class="info">
        <div class="title float-right"><i class="icon-info-sign"></i></div>
        <p class="text-right float-right">Luka Puharic 2013</p>
    </div>

    <!-- FOOTER -->
    <footer>
        FOOTER
    </footer>

    <!-- JAVASCRIPT -->
    <script src="include/jquery-1.10.1.min.js"></script>
    <script src="include/javascript.js"></script>

</body>

</html>