
// Google Maps object
var GM = {
    apiKey  = "AIzaSyCGHVSkXtwVy4D6GDK5WVVgFXs_SKg-0Z0",
}

$(function(){

    var latitude, longitude, accuracy;

    function get_location() {
        navigator.geolocation.getCurrentPosition(show_map);
    }

    function show_map(position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;
        accuracy = position.coords.accuracy;

        // let's show a map or do something interesting!
        $("#my_location").html("<a href='//maps.google.com/?q=" + latitude + "," + longitude +"' target=_blank>" + latitude + ", " + longitude + "</a>");
        $("#my_accuracy").html(Math.round(accuracy));
    }

    get_location();

});