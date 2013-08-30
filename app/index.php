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

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE MAPS API -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.6&sensor=false"></script>

</head>

<body>

    <!-- MAIN HEADER -->
    <header class="main">
        <div class="info">
            <a class="title scrollSection" data-section="about" >
                <img src="../assets/icons/logo.png" />
                <h1 class="siteTitle"></h1>
            </a>
            <div class="toggle-menu">
                <i class="icon-list-ul"></i>
            </div>
        </div>

        <!-- MAIN NAVIGATION -->
        <nav class="header-nav nav">
            <ul class="nav-list">
                <li><a class="button scrollSection" data-section="browse">Browse Locations</a></li>
                <!-- <li><a class="button nearby" href="#">Show Nearby</a></li> -->
                <li><a class="button scrollSection" data-section="category">Filter by Category</a></li>
                <li><a class="button scrollSection" data-section="locations">Change Location</a></li>
            </ul>
            <ul class="nav-list">
                <li><a class="button scrollSection" data-section="about">About</a></li>
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
        <div class="group ">
            <button id="zoomIn"  class="button"><i class="icon-plus"></i></button>
            <button id="mapType" data-type-id="1" class="button"><i class="icon-globe"></i></button>
            <button id="zoomOut" class="button"><i class="icon-minus"></i></button>
        </div>
    </div>

    <div class="main-container">

        <!-- ARTICLE -->
        <article>

            <!-- ARTICLE CONTROLS -->
            <div class="browse article-header">
                <div class="counter">
                    <span id="item_no">0</span> / <span id="item_total">0</span>
                </div>
                <nav>
                    <button id="prev" class="button scrollSection" data-section="browse" ><i class="icon-chevron-left"></i></button>
                    <button id="next" class="button scrollSection" data-section="browse"><i class="icon-chevron-right"></i></button>
                </nav>
            </div>

            <h1 class="title">No Title</h1>

            <div class="image"><img src="../cms/img/noimage.png" /></div>

            <div class="content">No Content</div>

            <div class="location"></div>

            <div class="social"></div>

            <div class="scrollTop separator" href="#">Back to top <i class="icon-arrow-up"></i></div>
        </article>


        <!-- CATEGORIES -->
        <section class="category light">

            <h2>Filter</h2>

            <nav class="nav">
                <ul class="nav-list">
                    <li><a class="set_category " data-category="activity" href="#"><img src="http://lukap.info/gcd/masters/assets/pins/pin_green.png" width="70" height="70" /><div class="button" >Activity</div></a></li>
                    <li><a class="set_category " data-category="history" href="#"><img src="http://lukap.info/gcd/masters/assets/pins/pin_orange.png" width="70" height="70" /><div class="button" >History</div></a></li>
                    <li><a class="set_category " data-category="study" href="#"><img src="http://lukap.info/gcd/masters/assets/pins/pin_blue.png" width="70" height="70" /><div class="button" >Study</div></a></li>
                    <li><a class="set_category " data-category="" href="#"><div class="reset"><i class="icon-remove"> </i></div><div class="button" >Reset</div></a></li>
                </ul>
            </nav>

            <div class="scrollTop separator" href="#">Back to top <i class="icon-arrow-up"></i></div>

        </section>

        <!-- LOCATIONS -->
        <section class="locations light">

            <h2>Locations</h2>

            <nav class="nav">
                <ul class="nav-list">
                    <li><a class="set_map button" data-map="gcd" href="#">GCD Campus</a></li>
                    <li><a class="set_map button" data-map="smi" href="#">Smithfield Square</a></li>
                    <li><a class="set_map button" data-map="pho" href="#">Phoenix Park</a></li>
                    <li><a class="set_map button" data-map="dub" href="#">Dublin</a></li>
                </ul>

                <div class="scrollTop separator" href="#">Back to top <i class="icon-arrow-up"></i></div>
            </nav>
        </section>

        <div class="clearfix"></div>

        <div class="scrollTop separator aboveFooter " href="#">Back to top <i class="icon-arrow-up"></i></div>

    </div>

    <footer class="dark">

        <img src="../assets/icons/logo.png" />
        <h3 class="siteTitle"></h3>
        <p class="siteDesc"></p>

        <p class="small" >&copy; Luka Puharic, 2013, except where stated differently.</p>

        <p>
            <a class="github" href="https://github.com/lukap2211/GCD-Masters"><i class="icon-github"></i></a>
        </p>

        <div class="scrollTop separator about" href="#">Back to top <i class="icon-arrow-up"></i></div>
    </footer>

    <!-- JAVASCRIPT -->
    <script src="..//assets/js/jquery-1.10.1.min.js"></script>
    <script src="js/app.js"></script>

</body>

</html>