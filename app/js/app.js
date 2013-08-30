/*!
* Copyright 2013 Luka Puharic
* http://www.apache.org/licenses/LICENSE-2.0.txt
*/

var map, xhr;

// Google Maps object
var GM = {

    // settings
    apiKey          : "AIzaSyCGHVSkXtwVy4D6GDK5WVVgFXs_SKg-0Z0",
    rootURL         : "http://github/GCD-masters/",         // local
    // rootURL         : "http://lukap.info/gcd/masters/",     // production
    latitude        : "",
    longitude       : "",
    accuracy        : "",

    // site settings
    site   : {
        name        : "",
        desc        : "",
    },

    // markers
    locations       : [],
    markers         : [],
    currentId       : "",
    filterCategory  : "",
    iterator        : 0,
    pin  : {

        /* backup icons */
        // green       : "http://o.aolcdn.com/os/industry/misc/pin_green",
        // orange      : "http://o.aolcdn.com/os/industry/misc/pin_orange",
        // blue        : "http://o.aolcdn.com/os/industry/misc/pin_blue",
        // black       : "http://o.aolcdn.com/os/industry/misc/pin_black",
        // todo        : "http://o.aolcdn.com/os/industry/misc/pin_todo",
        // shadow      : "http://o.aolcdn.com/os/industry/misc/pin_shadog"

        /* originals */
        green       : "http://lukap.info/gcd/masters/assets/pins/pin_green",
        orange      : "http://lukap.info/gcd/masters/assets/pins/pin_orange",
        blue        : "http://lukap.info/gcd/masters/assets/pins/pin_blue",
        black       : "http://lukap.info/gcd/masters/assets/pins/pin_black",
        todo        : "http://lukap.info/gcd/masters/assets/pins/pin_todo",
        shadow      : "http://lukap.info/gcd/masters/assets/pins/pin_shadow",
        me          : "http://lukap.info/gcd/masters/assets/pins/me"
    },

    // legend
    legend  : {
        total       : 0,
        activity    : {total : 0, perc : 0},
        history     : {total : 0, perc : 0},
        study       : {total : 0, perc : 0},
        todo        : {total : 0, perc : 0}
    },

    myMaps : {
        gcd         : { map : new google.maps.LatLng(53.33101073729732,  -6.278211772441864), zoom : 18, minZoom : 17, maxZoom : 21}, // Griffith
        smi         : { map : new google.maps.LatLng(53.348732478223454, -6.279000341892242), zoom : 17, minZoom : 16, maxZoom : 21}, // Smithfield Square
        pho         : { map : new google.maps.LatLng(53.35890161658443,  -6.329755783081055), zoom : 14, minZoom : 14, maxZoom : 21}, // Phoenix park
        dub         : { map : new google.maps.LatLng(53.34737470187197,  -6.263923645019531), zoom : 12, minZoom : 10, maxZoom : 21} // Dublin
    },

    // map opions
    options     : {
        zoom                : 17,
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

        map : {

            getLocation : function (position) {
                GM.latitude  = position.coords.latitude;
                GM.longitude = position.coords.longitude;
                GM.accuracy  = position.coords.accuracy;

                console.log("my location updated! (" + GM.latitude + ", " + GM.longitude + ")");

                // showing current location
                // if (GM.me) { GM.me.setMap(null); }
                GM._fn.marker.addMarker();
            },

            getMap : function () {
                // google.maps.visualRefresh = true;
                map = new google.maps.Map(document.getElementById('map-canvas'), GM.options);
                // set Map no
                GM._fn.map.setMap(false);

            },

            setMap : function (timeout) {

                GM._fn.markers.loadMarkers(timeout);
                GM._fn.admin.customZoom();
                GM._fn.admin.loadLegend();

                switch (GM.currentMap) {
                case "gcd" :
                    GM.options.zoom = GM.myMaps.gcd.zoom;
                    GM.options.minZoom = GM.myMaps.gcd.minZoom;
                    GM.options.maxZoom = GM.myMaps.gcd.maxZoom;
                    map.panTo(GM.myMaps.gcd.map);
                    map.setZoom(GM.myMaps.gcd.zoom);
                    break;
                case "smi" :
                    GM.options.zoom = GM.myMaps.smi.zoom;
                    GM.options.minZoom = GM.myMaps.smi.minZoom;
                    GM.options.maxZoom = GM.myMaps.smi.maxZoom;
                    map.panTo(GM.myMaps.smi.map);
                    map.setZoom(GM.myMaps.smi.zoom);
                    break;
                case "pho" :
                    GM.options.zoom = GM.myMaps.pho.zoom;
                    GM.options.minZoom = GM.myMaps.pho.minZoom;
                    GM.options.maxZoom = GM.myMaps.pho.maxZoom;
                    map.panTo(GM.myMaps.pho.map);
                    map.setZoom(GM.myMaps.pho.zoom);
                    break;
                case "dub" :
                    GM.options.zoom = GM.myMaps.dub.zoom;
                    GM.options.minZoom = GM.myMaps.dub.minZoom;
                    GM.options.maxZoom = GM.myMaps.dub.maxZoom;
                    map.panTo(GM.myMaps.dub.map);
                    map.setZoom(GM.myMaps.dub.zoom);
                    break;
                }
            },

            clearMap : function () {
                for (var i = 0; i < GM.markers.length; i++) {
                    GM.markers[i].setMap(null);
                }
                GM.legend.total = GM.legend.activity.total = GM.legend.history.total = GM.legend.study.total = 0;
                GM.locations = [];
                GM.markers   = [];
                GM.iterator  = 0;
            },

            centerMap :function () {
                // center my location
                var center = new google.maps.LatLng(GM.latitude, GM.longitude);
                map.panTo(center);
            }
        },

        markers : {

            loadMarkers : function (timeout) {

                var filter = "";
                // reset values
                GM._fn.map.clearMap();

                if (GM.filterCategory !== "") {
                    filter = "&category=" + GM.filterCategory;
                }

                var param = "API/?c=content&a=all&todo=false&map=" + GM.currentMap + filter;
                xhr = $.getJSON(GM.rootURL + param)
                    .done(function (data) {
                        if (data.result) {
                            $.each(data.items, function (i, item) {
                                GM.locations.push(item);
                                // console.log(item);
                            });
                        }

                        GM._fn.markers.placeMarkers(timeout);
                        GM._fn.marker.viewMarker(0);

                    })
                    .fail(function () {
                        alert("ERROR: " + param);
                    });
            },

            placeMarkers : function (timeout) {
                for (var i = 0; i < GM.locations.length; i++) {
                    if (timeout) {
                        setTimeout(function () {
                            GM._fn.marker.placeMarker();
                        }, i * 200);
                    } else {
                        GM._fn.marker.placeMarker();
                    }

                }
            }
        },

        marker : {

            addMarker : function () {

                if (GM.me) {
                    GM.me.setMap(null) ;
                }

                GM.me = (new google.maps.Marker({
                    position    : new google.maps.LatLng(GM.latitude, GM.longitude),
                    map         : map,
                    draggable   : true,
                    icon        : GM._fn.admin.getIcon("me"),
                    optimized   : true

                }));

            },

            getMarker : function (id) {

                // ad to location[]
                // insert into DB via API
                var param = "API/?c=content&a=id&id=" + id;
                xhr = $.getJSON(GM.rootURL + param)
                    .done(function (data) {
                        if (data.result) {
                            console.log("ID: " + id + " - Marker Fetched");
                            // add record into locations array
                            GM.locations.push(data.items[0]);
                            // add to markers array
                            GM._fn.marker.placeMarker();
                        }
                    })
                    .fail(function () {
                        alert("ERROR: " + param);
                    });
            },

            placeMarker : function () {

                var i = GM.iterator;


                GM.markers[i] = (new google.maps.Marker({
                    animation   : google.maps.Animation.DROP,
                    position    : new google.maps.LatLng(GM.locations[i].geo_lat, GM.locations[i].geo_lng),
                    map         : map,
                    draggable   : true,
                    icon        : GM._fn.admin.getIcon(GM.locations[i].category),
                    shadow      : GM._fn.admin.getIcon('shadow'),
                    optimized   : true

                }));

                // show details ??
                google.maps.event.addListener(GM.markers[i], 'click', function () {

                    // TODO ?? BUG? wont
                    GM._fn.marker.viewMarker(i);
                });

                // edit
                google.maps.event.addListener(GM.markers[i], 'dblclick', function () {
                    GM._fn.marker.viewMarker(i);
                });

                // hover icon
                google.maps.event.addListener(GM.markers[i], 'mouseover', function () {
                    GM.markers[i].setIcon(GM._fn.admin.getIcon("black"));
                });

                google.maps.event.addListener(GM.markers[i], 'mouseout', function () {
                    GM.markers[i].setIcon(GM._fn.admin.getIcon(GM.locations[i].category));
                });

                GM.iterator++;
            },

            resetView : function (){
                $("article .title").html("");
                $("article .title").html("<span class='empty'>No Title</span>");
                $("article .content").html("<span class='empty'>No Content</span>");
                $("article .location").html("");
                $("article footer .comments").hide();
                $("article footer .twitter").hide();
                $("article footer .facebook").hide();
                $("article #item_no").html("0");
                $("article #item_total").html("0");
                $("article .image").html("<img />");
                $("article .image img").prop("src", GM.rootURL + "cms/img/noimage.png");



                for (var i = 0; i<GM.locations.length; i++) {
                    GM.markers[i].setIcon(GM._fn.admin.getIcon(GM.locations[i].category));
                }
            },

            viewMarker : function (i) {
                // reset view
                GM._fn.marker.resetView();

                GM.currentId = i;
                GM.markers[GM.currentId].setIcon(GM._fn.admin.getIcon("black"));

                var data = GM.locations[i];

                console.log("ID: " + GM.locations[i].id + " - View Marker");

                // set counter
                $("article #item_no").html(parseInt(GM.currentId,10) +1);
                $("article #item_total").html(GM.locations.length);

                // set images
                var map_src = "http://maps.googleapis.com/maps/api/staticmap?markers=icon:" + GM._fn.admin.getIcon(GM.locations[i].category, true) + "|" + GM.locations[i].geo_lat + "," + GM.locations[i].geo_lng + "|shadow:true&center=" + GM.locations[i].geo_lat + "," + GM.locations[i].geo_lng + "&zoom=" + GM.options.zoom + "&maptype=hybrid&size=530x250&sensor=false";

                if (data.image_name) {
                    GM._fn.marker.loadImage(data.id);
                } else {
                    $("article .image").html("<img />");
                    $("article .image img").prop("src", GM.rootURL + "cms/img/noimage.png");
                    console.log("ID: " + GM.locations[i].id + " - NO Image.");
                }

                // add info
                if (data.title) {
                    $("article .title").html(data.title);
                } else {
                    $("article .title").html("<span class='empty'>No Title</span>");
                }
                if (data.content) {
                    $("article .content").html(data.content);
                } else {
                    $("article .content").html("<span class='empty'>No Content</span>");

                }

                $("article .sat_map").prop("src", map_src);

                if (data.comments === 1) {$("article footer .comments").show();}
                if (data.twitter === 1) {$("article footer .twitter").show();}
                if (data.facebook === 1) {$("article footer .facebook").show();}
            },

            loadImage : function (id) {
                // load iamge from database based on id
                console.log("ID: " + id + " - Loading image...");
                    $("article .image").html("<img />");
                    $("article .image img").prop("src", GM.rootURL + "API/load_image.php?id=" + id);
            }

        },

        admin : {

            getIcon : function (category, link) {
                var icon;
                switch (category) {
                case "history" :
                    icon = GM.pin.orange;
                    break;
                case "activity" :
                    icon = GM.pin.green;
                    break;
                case "study" :
                    icon = GM.pin.blue;
                    break;
                case "black" :
                    icon = GM.pin.black;
                    break;
                case "todo" :
                    icon = GM.pin.todo;
                    break;
                case "shadow" :
                    icon = GM.pin.shadow;
                    break;
                case "me" :
                    icon = GM.pin.me;
                    break;
                }
                if (link) {
                    return icon + "_small.png";
                } else {
                    // return icon;
                    return new google.maps.MarkerImage(icon + ".png", null, null, null, new google.maps.Size(47, 47));
                }
            },

            setLegend : function () {

                $("#legend .activity").css("width", GM.legend.activity.perc + "%").find("a").html(GM.legend.activity.total);
                $("#legend .history").css("width", GM.legend.history.perc + "%").find("a").html(GM.legend.history.total);
                $("#legend .study").css("width", GM.legend.study.perc + "%").find("a").html(GM.legend.study.total);
                $("#legend .todo").css("width", GM.legend.todo.perc + "%").find("a").html(GM.legend.todo.total);
            },

            loadLegend : function () {
                var filter;
                // TODO
                // set filter if viewing as user
                filter = "";

                var param = "API/?c=content&a=legend" + filter;
                xhr = $.getJSON(GM.rootURL + param)
                    .done(function (data) {
                        // prepare legend
                        if (data.result) {
                            // reset values
                            $("#legend .progress div").css({"width" : 0});

                            $.each(data.items, function (i, item) {
                                GM.legend.total += parseInt(item.total, 10);
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
                                case "todo" :
                                    GM.legend.todo.total = item.total;
                                    break;
                                }
                            });
                        } else {
                            $("#legend .progress div").css({"width" : 0});
                        }

                        // set legend
                        GM.legend.activity.perc = GM.legend.activity.total !== 0 ? (GM.legend.activity.total / GM.legend.total * 100) : 0;
                        GM.legend.history.perc = GM.legend.history.total !== 0 ? (GM.legend.history.total / GM.legend.total * 100) : 0;
                        GM.legend.study.perc = GM.legend.study.total !== 0 ? (GM.legend.study.total / GM.legend.total * 100) : 0;
                        GM.legend.todo.perc = GM.legend.todo.total !== 0 ? (GM.legend.todo.total / GM.legend.total * 100) : 0;

                        setTimeout(function () {
                            GM._fn.admin.setLegend();
                        }, 1000);

                    })
                    .fail(function () {
                        alert("error");
                    });
            },

            customZoom : function () {

                if (GM.options.zoom === GM.options.maxZoom) {
                    $("#zoomIn").addClass("disabled");
                } else {
                    $("#zoomIn").removeClass("disabled");
                }

                if (GM.options.zoom === GM.options.minZoom) {
                    $("#zoomOut").addClass("disabled");
                } else {
                    $("#zoomOut").removeClass("disabled");
                }

                // console.log("CURRENT ZOOM: " + GM.options.zoom);
            },

            customType : function (type) {
                switch (type) {
                case 1:
                    map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
                    break;
                case 2:
                    map.setMapTypeId(google.maps.MapTypeId.HYBRID);
                    map.setTilt(0);
                    break;
                case 3:
                    map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
                    map.setTilt(0);
                    break;
                case 4:
                    map.setMapTypeId(google.maps.MapTypeId.HYBRID);
                    map.setTilt(45);
                    break;
                case 5:
                    map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
                    map.setTilt(45);
                    break;
                }
            },

            locateMe : function (){
                navigator.geolocation.getCurrentPosition(GM._fn.map.getLocation);
            }

        },

        site : {

            getSiteDetails : function () {
                var param = "API/?c=site&a=id";
                xhr = $.getJSON(GM.rootURL + param)
                    .done(function (data) {
                        if (data.result) {
                            var site = data.items[0];
                            GM.site.name = site.name;
                            GM.site.desc = site.desc;
                            GM._fn.site.showSiteDetails();
                        }
                    })
                    .fail(function () {
                        alert("ERROR: " + param);
                    });
            },

            showSiteDetails : function () {
                $(".siteTitle").html(GM.site.name);
                $(".siteDesc").html(GM.site.desc);
            }
        }
    },

    init : function () {
        GM._fn.admin.locateMe();
        GM._fn.map.getMap();
        GM._fn.site.getSiteDetails();
    },


};

// other JS goes here

$(function () {

    // MAIN SETTINGS
    GM.currentMap = "smi"; // default map on dashboard

    // init
    GM.init();

    // NAVIGATION

    // change map
    $(".locations .set_map").click(function (e) {
        e.preventDefault();
        var set_location = $(this).data("map");
        map.panTo(GM.myMaps.gcd.map);
        GM.currentMap = set_location;
        GM._fn.map.setMap(false);
        $(".scrollTop").click();
    });

    // filterCategory
    $(".category .set_category").click(function (e) {
        e.preventDefault();
        GM.filterCategory = $(this).data("category");
        GM._fn.map.setMap(false);
        $(".scrollTop").click();
    });

    // users settings
    $(".nav .users").click(function (e) {
        e.preventDefault();
        GM._fn.user.getAllUsers();
    });

    // user actions
    $("header.main")
    .delegate(".toggle-menu, .nav-list a", "click", function (e) {
        $(".header-nav").toggleClass('active');
    })


    // user actions
    $("nav")
    .delegate("a.all", "click", function (e) {
        e.preventDefault();
        $("#modal-user").modal('hide');
        GM._fn.user.getAllUsers();
    })
    .delegate("a.nerby", "click", function (e) {
        e.preventDefault();
        GM._fn.user.deleteUser();
    })
    .delegate("a.category", "click", function (e) {
        e.preventDefault();
        GM._fn.user.saveUser();
    })

    // next Marker
    $("#next").click(function (e) {
        var i;
        e.preventDefault();
        if (GM.currentId < GM.locations.length -1) {
            i = parseInt(GM.currentId,10) + 1;
        } else {
            i = 0;
        }
        GM._fn.marker.viewMarker(i);
    });

    // prev Marker
    $("#prev").click(function (e) {
        var i;
        e.preventDefault();
        if (GM.currentId > 0) {
            i = parseInt(GM.currentId,10) - 1;
        } else {
            i = GM.locations.length - 1;
        }
        GM._fn.marker.viewMarker(i);
    });

    // MAP CONTROL

    // custom map type
    $("#map-controls #mapType").click(function (e) {
        e.preventDefault();
        var typeId = $(this).data("type-id") + 1;
        if (typeId === 3) {typeId = 1; }
        $(this).data("type-id", typeId);
        GM._fn.admin.customType(typeId);
    });

    // custom map zoom +
    $("#map-controls #zoomIn").click(function (e) {
        e.preventDefault();
        if (GM.options.zoom < GM.options.maxZoom) {
            GM.options.zoom += 1;
            map.setZoom(GM.options.zoom);
        }
        GM._fn.admin.customZoom();
    });

    // custom map zoom -
    $("#map-controls #zoomOut").click(function (e) {
        e.preventDefault();
        if (GM.options.zoom > GM.options.minZoom) {
            GM.options.zoom -= 1;
            map.setZoom(GM.options.zoom);
        }
        GM._fn.admin.customZoom();
    });

    // custom map zoom -
    $("#map-controls #centerMe").click(function (e) {
        e.preventDefault();
        GM._fn.map.centerMap();
    });

    // scroll to info
    $(".scrollSection").click(function (e) {
        var target = $(this).data("section");
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $("." + target).offset().top
        }, 400);
    });

    // scroll to top
    $(".scrollTop").click(function (e) {
        $('html, body').animate({
            scrollTop: $("header.main").offset().top
        }, 400);
    });


});

setInterval(GM._fn.admin.locateMe, 10000);

