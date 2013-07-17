// Google Maps object
var GM = {

    // main
    // INFO        : "This is Google Maps object that is used in CMS",
    apiKey      : "AIzaSyCGHVSkXtwVy4D6GDK5WVVgFXs_SKg-0Z0",
    latitude    : "",
    longitude   : "",
    accuracy    : "",

    // functions
    _fn : {

        get_location: function () {
            navigator.geolocation.getCurrentPosition(GM._fn.show_map);
        },

        show_map : function (position) {
            GM.latitude  = position.coords.latitude;
            GM.longitude = position.coords.longitude;
            GM.accuracy  = position.coords.accuracy;

            // let's show a map or do something interesting!
            $("#my_location").html("<a href='//maps.google.com/?q=" + GM.latitude + "," + GM.longitude +"' target=_blank>" + GM.latitude + ", " + GM.longitude + "</a>");
            $("#my_accuracy").html(Math.round(GM.accuracy));
        }
    }
}

$(function(){


    GM._fn.get_location();


    // Scroll Spy
    $('#navbar').scrollspy();

    // ADMIN section

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