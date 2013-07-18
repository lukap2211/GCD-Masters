// Google Maps object
var GM = {

    // settings
    apiKey      : "AIzaSyCGHVSkXtwVy4D6GDK5WVVgFXs_SKg-0Z0",
    latitude    : "",
    longitude   : "",
    accuracy    : "",
    zoom        : 19,

    // functions
    _fn : {

        // get current location
        getLocation : function (position) {
            GM.latitude  = position.coords.latitude;
            GM.longitude = position.coords.longitude;
            GM.accuracy  = position.coords.accuracy;

            // showing current location in the header
            $("#my_location").html("<a href='//maps.google.com/?q=" + GM.latitude + "," + GM.longitude +"' target=_blank>" + GM.latitude + ", " + GM.longitude + "</a>").hide().fadeIn();
            $("#my_accuracy").html(Math.round(GM.accuracy)).hide().fadeIn();


            // load map when location retrieved
            GM._fn.getMap();
        },

        // get map current location
        getMap : function () {
            google.maps.visualRefresh = true;
            // google.maps.MapTypeStyleFeatureType = "administrative";
            var mapOptions = {
                zoom                : GM.zoom,
                minZoom             : GM.zoom,
                maxZoom             : GM.zoom,
                panControl          : false,
                draggable           : false,
                disableDefaultUI    : true,
                styles:[{
                    featureType:"poi",
                    elementType:"labels",
                    stylers:[{
                        visibility:"off"
                    }]
                }],
                center: new google.maps.LatLng(GM.latitude, GM.longitude),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

            // set home Smithfield or Griffith College
            var griffith    = new google.maps.LatLng(53.33101073729732, -6.278211772441864);
            var smithfield  = new google.maps.LatLng(53.348732478223454, -6.279000341892242);

            $(".set_home_1").click(function (e) {
                e.preventDefault;
                map.panTo(griffith);
            })

            $(".set_home_2").click(function (e) {
                e.preventDefault;
                map.panTo(smithfield);
            })

            // on click add new location
            google.maps.event.addListener(map, 'click', function(e) {
                GM._fn.placeMarker(e.latLng, map);
            });

        },

        // add new location
        placeMarker : function (position, map) {
            var marker = new google.maps.Marker({
                position: position,
                map: map
            });
            alert(position)
        },

        // init when DOM is ready
        init : function () {
            navigator.geolocation.getCurrentPosition(GM._fn.getLocation);
        },



    }
}

$(function(){

    // init
    GM._fn.init();

    // TODO
    // front end stuff


    // Scroll Spy
    $('#navbar').scrollspy();

    // tabs
    $('#myTab a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    });

    $('a[data-toggle="tab"]').on('shown', function (e) {
        e.target; // activated tab
        e.relatedTarget; // previous tab
    });

    $('#myTab a[href="#profile"]').tab('show'); // Select tab by name
    // $('#myTab a:first').tab('show'); // Select first tab
    // $('#myTab a:last').tab('show'); // Select last tab
    // $('#myTab li:eq(2) a').tab('show'); // Select third tab (0-indexed)

});
