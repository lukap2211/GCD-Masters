var marker, map, xhr;

// Google Maps object
var GM = {

    // settings
    apiKey          : "AIzaSyCGHVSkXtwVy4D6GDK5WVVgFXs_SKg-0Z0",
    rootAPI         : "http://github/GCD-masters/API/",
    latitude        : "",
    longitude       : "",
    accuracy        : "",

    // site settings
    site   : {
        name        : "100%",
        desc        : "400px",
        logo        : "400px",
        size        : "400px",
        debug       : "200px"
    },

    // user
    user : {
        id          : "",
    },

    // markers
    locations       : [],
    markers         : [],
    iterator        : 0,
    pin  : {
        // green       : "http://cdn1.iconfinder.com/data/icons/locationicons/pin.png",
        // orange      : "http://cdn1.iconfinder.com/data/icons/locationicons/pin.png",
        // red         : "http://cdn1.iconfinder.com/data/icons/locationicons/pin.png",
        // black       : "http://cdn1.iconfinder.com/data/icons/locationicons/pin.png"
        green       : "http://lukap.info/gcd/masters/admin/img/pin_green.png",
        orange      : "http://lukap.info/gcd/masters/admin/img/pin_orange.png",
        red         : "http://lukap.info/gcd/masters/admin/img/pin_red.png",
        black       : "http://lukap.info/gcd/masters/admin/img/pin_black.png",
        todo        : "http://lukap.info/gcd/masters/admin/img/pin_todo.png"
    },

    // legend
    legend  : {
        total       : 0,
        activity    : { total : 0 , perc : 0 },
        history     : { total : 0 , perc : 0 },
        study       : { total : 0 , perc : 0 },
        pending     : { total : 0 , perc : 0 }
    },

    // custom positions
    gcd         : { map : new google.maps.LatLng(53.33101073729732,  -6.278211772441864), zoom : 19, minZoom : 17, maxZoom : 21}, // Griffith
    smi         : { map : new google.maps.LatLng(53.348732478223454, -6.279000341892242), zoom : 17, minZoom : 16, maxZoom : 21}, // Smithfield Square
    pho         : { map : new google.maps.LatLng(53.35890161658443,  -6.329755783081055), zoom : 14, minZoom : 14, maxZoom : 21}, // Phoenix park
    dub         : { map : new google.maps.LatLng(53.34737470187197,  -6.263923645019531), zoom : 12, minZoom : 10, maxZoom : 21}, // Dublin

    // map otpions
    options     : {
        zoom                : 19,
        minZoom             : 12,
        maxZoom             : 21,
        draggable           : false,
        scrollwheel         : false,
        disableDefaultUI    : true,
        disableDoubleClickZoom: true,

        styles : [{
            featureType     : "poi",
            elementType     : "labels",
            stylers : [{
                visibility  : "off"
            }]
        }],

        MapTypeId           : google.maps.MapTypeId.ROADMAP
    },

    // functions
    _fn : {

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

        getMap : function () {
            google.maps.visualRefresh = true;
            map = new google.maps.Map(document.getElementById('map-canvas'), GM.options);
            // move to current location
            var center = new google.maps.LatLng(GM.latitude,GM.longitude);
            map.panTo(center);

            // set Map
            GM._fn.setMap();

            // set listeners

            // on click add new location
            google.maps.event.addListener(map, 'click', function(e) {
                // disable more than one at the setTimeout
                console.log(marker === undefined);
                // if(marker === undefined){
                    GM._fn.placeMarker(e.latLng, map);
                // }
            });

            google.maps.event.addListener(map, 'tilesloaded', function() {
                // $('#map-canvas').find('img').parent().css('border', '1px solid red');
            });

            // pan offset
            google.maps.Map.prototype.panToWithOffset = function(latlng, offsetX, offsetY) {
                var map = this;
                var ov = new google.maps.OverlayView();
                ov.onAdd = function() {
                    var proj = this.getProjection();
                    var aPoint = proj.fromLatLngToContainerPixel(latlng);
                    aPoint.x = aPoint.x+offsetX;
                    aPoint.y = aPoint.y+offsetY;
                    map.panTo(proj.fromContainerPixelToLatLng(aPoint));
                };
                ov.draw = function() {};
                ov.setMap(this);
            };
        },

        setMap : function () {

            GM._fn.customZoom();
            GM._fn.loadMarkers();
            GM._fn.loadLegend();

            switch (GM.currentMap) {
            case "gcd" :
                GM.options.zoom = GM.gcd.zoom; GM.options.minZoom = GM.gcd.minZoom; GM.options.maxZoom = GM.gcd.maxZoom; map.panTo(GM.gcd.map); map.setZoom(GM.gcd.zoom);
                break;
            case "smi" :
                GM.options.zoom = GM.smi.zoom; GM.options.minZoom = GM.smi.minZoom; GM.options.maxZoom = GM.smi.maxZoom; map.panTo(GM.smi.map); map.setZoom(GM.smi.zoom);
                break;
            case "pho" :
                GM.options.zoom = GM.pho.zoom; GM.options.minZoom = GM.pho.minZoom; GM.options.maxZoom = GM.pho.maxZoom; map.panTo(GM.pho.map); map.setZoom(GM.pho.zoom);
                break;
            case "dub" :
                GM.options.zoom = GM.dub.zoom; GM.options.minZoom = GM.dub.minZoom; GM.options.maxZoom = GM.dub.maxZoom; map.panTo(GM.dub.map); map.setZoom(GM.dub.zoom);
                break;
            }
        },

        clearMap : function () {
            for (var i = 0; i < GM.markers.length; i++ ) {
                GM.markers[i].setMap(null);
            }
        },

        loadMarkers : function () {

            // reset values
            GM._fn.clearMap();
            GM.legend.total = GM.legend.activity.total = GM.legend.history.total = GM.legend.study.total = 0;
            GM.locations = [];
            GM.markers   = [];
            GM.iterator  = 0;

            var param = "?c=content&a=all&map=" + GM.currentMap;
            xhr = $.getJSON(GM.rootAPI + param, {dataType: "json"})
                .done(function(data) {
                    if(data.result){
                        $.each(data.items, function(i, item) {
                            GM.locations.push(item);
                        });
                    }
                    // $(".progress div").css({"width" : 0});
                    // drop all markers on map
                    setTimeout(function(){
                        GM._fn.placeMarkers();
                    }, 1000);
                })
                .fail(function(){
                    alert("ERROR: " + param);
                })
        },

        placeMarker : function (position, map) {
            // marker = new google.maps.Marker({
            marker = new google.maps.Marker({
                animation   : google.maps.Animation.DROP,
                position    : position,
                map         : map,
                draggable   : true,
                icon        : new google.maps.MarkerImage(GM.pin.todo, null, null, null, new google.maps.Size(50,50))
            });
            // add to markers array
            GM.markers.push(marker);

            // update position
            document.getElementById("latitude").value = position.lat();
            document.getElementById("longitude").value = position.lng();

            // insert into DB via API
            var param = "?c=content&a=add&geo_lat=" + position.lat() + "&geo_lng=" + position.lng()+ "&user_id=" + GM.user.id + "&map=" + GM.currentMap + "&category=pending";
            xhr = $.getJSON(GM.rootAPI + param)
                .done(function(data) {
                    console.log("marker id: " + data.result + " inserted!!!");
                })
                .fail(function() {
                    alert("ERROR: " + param);
                })

            // on drag update location
            google.maps.event.addListener(marker, 'dragstart', function(e) {
                // drag START
            });

            google.maps.event.addListener(marker, 'dragend', function(e) {
                // drag END
                GM._fn.moveMarker(e.latLng, map);
            });

            // show details
            google.maps.event.addListener(marker, 'dblclick', function(e) {

                // TODO
                // this should happen in modal!!!
                // insert into DB via API
                var param = "?c=content&a=delete&&id=" + GM.currentMap + "&category=pending";
                xhr = $.getJSON(GM.rootAPI + param, {dataType: "json"})
                    .done(function(data) {
                        console.log("marker id: " + data.result + " inserted!!!");
                        // clean markers array
                        GM.markers[GM.markers.length - 1].setMap(null);
                        GM.markers.pop();
                        // update locations array
                        GM.locations.pop();
                        console.log("New Marker deleted!!!");
                    })
                    .fail(function() {
                        alert("ERROR: " + param);
                    })
            });
        },

        placeMarkers : function () {
            for (var i = 0; i < GM.locations.length; i++) {
                setTimeout(function(){
                    GM._fn.addMarkers();
                } , i * 300);
            }
        },

        addMarker : function () {
            // TODO? or put on main function when marker created
            // add new marker
        },

        addMarkers : function() {

            var icon, icon_backup, i = GM.iterator;

            GM.markers[i] = (new google.maps.Marker({
                animation   : google.maps.Animation.DROP,
                position    : new google.maps.LatLng(GM.locations[i].geo_lat, GM.locations[i].geo_lng),
                map         : map,
                draggable   : true,
                icon        : GM._fn.getIcon(GM.locations[i].category),
                optimized   : true

            }));

            // show details
            google.maps.event.addListener(GM.markers[i], 'click', function(e) {
                // TODO ?
            });

            google.maps.event.addListener(GM.markers[i], 'dblclick', function(e) {

                // view details
                GM._fn.viewModal(i);
            });

            // hover icon
            google.maps.event.addListener(GM.markers[i], 'mouseover', function(e) {
                GM.markers[i].setIcon(GM._fn.getIcon("black"));
            });

            google.maps.event.addListener(GM.markers[i], 'mouseout', function(e) {
                GM.markers[i].setIcon(GM._fn.getIcon(GM.locations[i].category));
            });

            // update location
            google.maps.event.addListener(GM.markers[i], 'dragend', function(e) {
                GM._fn.moveMarkers(e.latLng, map, i);
            });

            GM.iterator++;
        },

        moveMarker : function (position, map) {
            map.panTo(position);

            // update position
            document.getElementById("latitude").value = position.lat();
            document.getElementById("longitude").value = position.lng();
        },

        moveMarkers : function (position, map, i) {

            // udpate object
            // map.panTo(position);
            GM.locations[i].geo_lat = position.lat();
            GM.locations[i].geo_lng = position.lng()

            // update position
            document.getElementById("latitude").value = position.lat();
            document.getElementById("longitude").value = position.lng();

            GM._fn.editMarkerLocation(i);
        },

        editMarkerLocation : function (i) {
            // update location in db
            var param = "?c=content&a=edit_loc&id=" + GM.locations[i].id + "&geo_lat=" + GM.locations[i].geo_lat+ "&geo_lng=" + GM.locations[i].geo_lng;
            xhr = $.getJSON(GM.rootAPI + param)
                .done(function(data) {
                    if(data.result){
                        console.log("Marker updated!");
                    }
                })
                .fail(function() {
                    alert("ERROR: " + param);
                })
        },

        deleteMarker : function(i) {
            markers[i].setMap(null);
        },

        getIcon : function (category) {
            var icon;
            switch (category) {
            case "history" :
                icon = GM.pin.green;
                break;
            case "activity" :
                icon = GM.pin.orange;
                break;
            case "study" :
                icon = GM.pin.red;
                break;
            case "black" :
                icon = GM.pin.black;
                break;
            case "pending" :
                icon = GM.pin.todo;
                break;
            }
            // return icon;
            return new google.maps.MarkerImage(icon, null, null, null, new google.maps.Size(50,50));
        },

        setLegend : function () {

            $("#map-legend .activity").css("width", GM.legend.activity.perc + "%").find("a").html(GM.legend.activity.total);
            $("#map-legend .history").css("width", GM.legend.history.perc + "%").find("a").html(GM.legend.history.total);
            $("#map-legend .study").css("width",GM.legend.study.perc + "%").find("a").html(GM.legend.study.total);
        },

        loadLegend : function () {

            var param = "?c=content&a=legend&map=" + GM.currentMap;
            xhr = $.getJSON(GM.rootAPI + param, {dataType: "json"})
                .done(function(data) {
                    // prepare legend
                    if(data.result){
                        $.each(data.items, function(i, item) {
                            GM.legend.total += parseInt(item.total);
                            switch (item.category) {
                            case "history" :
                                GM.legend.history.total = item.total;
                                break;
                            case "activity" :
                                GM.legend.activity.total = item.total;
                                break;
                            case "study" :
                                GM.legend.study.total = item.total;
                                break;
                            case "pending" :
                                GM.legend.pending.total = item.total;
                                break;
                            }
                        });
                    }

                    // set legend
                    GM.legend.history.perc = GM.legend.history.total != 0 ? (GM.legend.history.total/GM.legend.total*100) : 0 ;
                    GM.legend.study.perc = GM.legend.study.total != 0 ? (GM.legend.study.total/GM.legend.total*100) : 0 ;
                    GM.legend.activity.perc = GM.legend.activity.total != 0 ? (GM.legend.activity.total/GM.legend.total*100) : 0 ;

                    // $(".progress div").css({"width" : 0});
                    setTimeout(function() {
                        GM._fn.setLegend()

                        // drop all markers on map
                        // GM._fn.placeMarkers();
                    }, 1000);


                })
                .fail(function() {
                    alert("error");
                })
        },

        customZoom : function () {

            if(GM.options.zoom === GM.options.maxZoom){
                $("#zoomIn").addClass("disabled");
            } else {
                $("#zoomIn").removeClass("disabled");
            }

            if(GM.options.zoom === GM.options.minZoom){
                $("#zoomOut").addClass("disabled");
            } else {
                $("#zoomOut").removeClass("disabled");
            }

            // console.log("CURRENT ZOOM: " + GM.options.zoom);
        },

        customType : function () {
            map.setMapTypeId(google.maps.MapTypeId.HYBRID);
        },

        viewModal : function (i) {
            var details;
            // TODO
            // prepare modal
            // details  = "<p class='text-info'>Geolocation: " +  GM.locations[i].geo_lat + ", " + GM.locations[i].geo_lng + "</p>"
            details = "<img src='http://maps.googleapis.com/maps/api/staticmap?markers=icon:" + encodeURIComponent(GM._fn.getIcon(GM.locations[i].category)) + "|" + GM.locations[i].geo_lat + "," +GM.locations[i].geo_lng + "|shadow:true&center=" + GM.locations[i].geo_lat + "," +GM.locations[i].geo_lng + "&zoom=" + GM.options.zoom + "&maptype=hybrid&size=640x200&sensor=false'/>";
            $("#modal h3").html(GM.locations[i].title);
            $("#modal .details").html(details);
            $("#modal").data("item-id",GM.locations[i].id);

            // load modal
            $('#modal').modal({
                keyboard : true
            });
        },

        init : function () {
            navigator.geolocation.getCurrentPosition(GM._fn.getLocation);
            GM.user.id = $("#user_area").data("user-id");
        },

        site : {

            getSettings : function (){

            },

            editSettings : function (){

            }

        }
    },

    API : {
        // calls go here!
    }

}


// on document loaded
$(function(){

    // init
    GM._fn.init();

    // default map on dashboard
    if ($("#dashboard_container").length > 0) {
        GM.currentMap = "gcd";
        GM.options.draggable = true;
    }

    // TODO
    // NAVIGATION

    // change map
    $(".nav .set_map").click(function(e){
        e.preventDefault();
        GM.currentMap = $(this).data("map");
        GM._fn.setMap();
    });

    // site settings
    $(".nav .settings").click(function(e){
        e.preventDefault();
        GM._fn.site.getSettings();
    })

    // custom map zoom +
    $("#map-controls #zoomIn").click(function (e) {
        e.preventDefault();
        if(GM.options.zoom < GM.options.maxZoom) {
            GM.options.zoom += 1;
            map.setZoom(GM.options.zoom);
        }
        GM._fn.customZoom()
    });

    // custom map zoom -
    $("#map-controls #zoomOut").click(function (e) {
        e.preventDefault();
        if(GM.options.zoom > GM.options.minZoom) {
            GM.options.zoom -= 1;
            map.setZoom(GM.options.zoom);
        }
        GM._fn.customZoom()
    });

    // $('.progress div a').tooltip();
    $('.progress div a').popover({placement: "top", trigger : "hover", toggle :"popover" });

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


    // TODO
    // API common call function

});
