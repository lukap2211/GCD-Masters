var marker, map, xhr;

// Google Maps object
var GM = {

    // settings
    apiKey          : "AIzaSyCGHVSkXtwVy4D6GDK5WVVgFXs_SKg-0Z0",
    rootAPI         : "http://github/GCD-masters/API/",         // local
    // rootAPI         : "http://lukap.info/gcd/masters/API/",     // production
    latitude        : "",
    longitude       : "",
    accuracy        : "",

    // site settings
    site   : {
        name        : "",
        desc        : "",
        logo        : "",
        size        : "",
        debug       : ""
    },

    // user
    user : {
        id          : "",
        viewAsId    : "",
    },

    // markers
    locations       : [],
    markers         : [],
    iterator        : 0,
    pin  : {
        /* backup icon */
        // green       : "http://cdn1.iconfinder.com/data/icons/locationicons/pin.png",
        // orange      : "http://cdn1.iconfinder.com/data/icons/locationicons/pin.png",
        // blue        : "http://cdn1.iconfinder.com/data/icons/locationicons/pin.png",
        // black       : "http://cdn1.iconfinder.com/data/icons/locationicons/pin.png",
        // todo        : "http://cdn1.iconfinder.com/data/icons/locationicons/pin.png",
        // shadow      : "http://cdn1.iconfinder.com/data/icons/locationicons/pin.png"
        /* originals */
        green       : "http://lukap.info/gcd/masters/admin/img/pin_green.png",
        orange      : "http://lukap.info/gcd/masters/admin/img/pin_orange.png",
        blue        : "http://lukap.info/gcd/masters/admin/img/pin_blue.png",
        black       : "http://lukap.info/gcd/masters/admin/img/pin_black.png",
        todo        : "http://lukap.info/gcd/masters/admin/img/pin_todo.png",
        shadow      : "http://lukap.info/gcd/masters/admin/img/pin_shadow.png"
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
        gcd         : { map : new google.maps.LatLng(53.33101073729732,  -6.278211772441864), zoom : 19, minZoom : 17, maxZoom : 21}, // Griffith
        smi         : { map : new google.maps.LatLng(53.348732478223454, -6.279000341892242), zoom : 17, minZoom : 16, maxZoom : 21}, // Smithfield Square
        pho         : { map : new google.maps.LatLng(53.35890161658443,  -6.329755783081055), zoom : 14, minZoom : 14, maxZoom : 21}, // Phoenix park
        dub         : { map : new google.maps.LatLng(53.34737470187197,  -6.263923645019531), zoom : 12, minZoom : 10, maxZoom : 21} // Dublin
    },

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

            // showing current location
            $("#my_location").html("<a href='//maps.google.com/?q=" + GM.latitude + "," + GM.longitude + "' target=_blank>" + GM.latitude + ", " + GM.longitude + "</a>").hide().fadeIn();
            $("#my_accuracy").html(Math.round(GM.accuracy)).hide().fadeIn();

            // load map when location retrieved
            GM._fn.getMap();
        },

        getMap : function () {
            google.maps.visualRefresh = true;
            map = new google.maps.Map(document.getElementById('map-canvas'), GM.options);
            // move to current location
            var center = new google.maps.LatLng(GM.latitude, GM.longitude);
            map.panTo(center);

            // set Map
            GM._fn.setMap();

            // set listeners

            // on click add new location
            google.maps.event.addListener(map, 'dblclick', function (e) {
                if (GM.user.id !== GM.user.viewAsId) {
                    alert("You cant add marker while viewing as another user!");
                } else {
                    // disable more than one at the setTimeout
                    console.log(marker === undefined);
                    // if(marker === undefined){
                    GM._fn.placeMarker(e.latLng, map);
                    // }
                }
            });

            google.maps.event.addListener(map, 'tilesloaded', function () {
                // $('#map-canvas').find('img').parent().css('border', '1px solid red');
            });

            // pan offset
            google.maps.Map.prototype.panToWithOffset = function (latlng, offsetX, offsetY) {
                var map = this;
                var ov = new google.maps.OverlayView();
                ov.onAdd = function () {
                    var proj = this.getProjection();
                    var aPoint = proj.fromLatLngToContainerPixel(latlng);
                    aPoint.x = aPoint.x + offsetX;
                    aPoint.y = aPoint.y + offsetY;
                    map.panTo(proj.fromContainerPixelToLatLng(aPoint));
                };
                ov.draw = function () {};
                ov.setMap(this);
            };
        },

        setMap : function () {

            GM._fn.customZoom();
            GM._fn.loadMarkers();
            GM._fn.loadLegend();

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
        },

        loadMarkers : function () {

            var filter;
            // TO DO view as user - pass the user id for admin
            // reset values
            GM._fn.clearMap();
            GM.legend.total = GM.legend.activity.total = GM.legend.history.total = GM.legend.study.total = 0;
            GM.locations = [];
            GM.markers   = [];
            GM.iterator  = 0;

            if (GM.user.id === GM.user.viewAsId && GM.user.privilege === "admin") {
                filter = "";
            } else {
                filter = "&id=" + GM.user.viewAsId;
            }

            var param = "?c=content&a=all&map=" + GM.currentMap + filter;
            xhr = $.getJSON(GM.rootAPI + param)
                .done(function (data) {
                    if (data.result) {
                        $.each(data.items, function (i, item) {
                            GM.locations.push(item);
                        });
                    }
                    // $(".progress div").css({"width" : 0});
                    // drop all markers on map
                    setTimeout(function () {
                        GM._fn.placeMarkers();
                    }, 1000);
                })
                .fail(function () {
                    alert("ERROR: " + param);
                });
        },

        placeMarker : function (position, map) {
            // marker = new google.maps.Marker({
            marker = new google.maps.Marker({
                animation   : google.maps.Animation.DROP,
                position    : position,
                map         : map,
                draggable   : true,
                icon        : new google.maps.MarkerImage(GM.pin.todo, null, null, null, new google.maps.Size(47, 47)),
                shadow      : new google.maps.MarkerImage(GM.pin.shadow, null, null, null, new google.maps.Size(47, 47))
            });
            // add to markers array
            GM.markers.push(marker);

            // update position
            document.getElementById("latitude").value = position.lat();
            document.getElementById("longitude").value = position.lng();

            // insert into DB via API
            var param = "?c=content&a=add&geo_lat=" + position.lat() + "&geo_lng=" + position.lng() + "&user_id=" + GM.user.id + "&map=" + GM.currentMap + "&category=todo";
            xhr = $.getJSON(GM.rootAPI + param)
                .done(function (data) {
                    console.log("marker id: " + data.result + " inserted!!!");
                })
                .fail(function () {
                    alert("ERROR: " + param);
                });

            // on drag update location
            google.maps.event.addListener(marker, 'dragstart', function () {
                // drag START
            });

            // update marker
            google.maps.event.addListener(marker, 'dragend', function (e) {
                // drag END
                GM._fn.moveMarker(e.latLng, map);
            });

            // delete marker
            google.maps.event.addListener(marker, 'dblclick', function () {
                // delete item
                // GM._fn.deleteMarker(i);
            });
        },

        placeMarkers : function () {
            for (var i = 0; i < GM.locations.length; i++) {
                setTimeout(function () {
                    GM._fn.addMarkers();
                }, i * 300);
            }
        },

        addMarker : function () {
            // TODO? or put on main function when marker created
            // add new marker
        },

        addMarkers : function () {

            var i = GM.iterator;

            GM.markers[i] = (new google.maps.Marker({
                animation   : google.maps.Animation.DROP,
                position    : new google.maps.LatLng(GM.locations[i].geo_lat, GM.locations[i].geo_lng),
                map         : map,
                draggable   : true,
                icon        : GM._fn.getIcon(GM.locations[i].category),
                shadow      : GM._fn.getIcon('shadow'),

                optimized   : true

            }));

            // show details
            google.maps.event.addListener(GM.markers[i], 'click', function () {
                // TODO ?
            });

            google.maps.event.addListener(GM.markers[i], 'dblclick', function () {
                GM._fn.viewModal(i);
            });

            // hover icon
            google.maps.event.addListener(GM.markers[i], 'mouseover', function () {
                GM.markers[i].setIcon(GM._fn.getIcon("black"));
            });

            google.maps.event.addListener(GM.markers[i], 'mouseout', function () {
                GM.markers[i].setIcon(GM._fn.getIcon(GM.locations[i].category));
            });

            // update location
            google.maps.event.addListener(GM.markers[i], 'dragend', function (e) {
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
            GM.locations[i].geo_lng = position.lng();

            // update position
            document.getElementById("latitude").value = position.lat();
            document.getElementById("longitude").value = position.lng();

            GM._fn.editMarkerLocation(i);
        },

        editMarkerLocation : function (i) {
            // update location in db
            var param = "?c=content&a=edit_loc&id=" + GM.locations[i].id + "&geo_lat=" + GM.locations[i].geo_lat + "&geo_lng=" + GM.locations[i].geo_lng;
            xhr = $.getJSON(GM.rootAPI + param)
                .done(function (data) {
                    if (data.result) {
                        console.log("Marker updated!");
                    }
                })
                .fail(function () {
                    alert("ERROR: " + param);
                });
        },

        deleteMarker : function (i) {

            // confirm delete
            var x = window.confirm("Are you sure you want to delete this?");
            if (x) {
                var param = "?c=content&a=delete&id=" + GM.locations[i].id;
                xhr = $.getJSON(GM.rootAPI + param)
                    .done(function (data) {
                        if (data.result) {
                            // TODO
                            // clean markers array
                            GM.markers[i].setMap(null);
                            GM.locations.splice(i, 1);
                            GM.markers.splice(i, 1);

                            console.log("marker index: " + i + ", id: " + data.result + " deleted!!!");
                            $("#marker-modal").modal('hide');
                            GM._fn.setMap();
                        } else {
                            // TODO
                            alert("ERROR: no results!");
                        }
                    })
                    .fail(function () {
                        alert("ERROR: " + param);
                    });

            } else {
                alert("NOT DELETED!");
            }
        },

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
            }
            if (link) {
                return icon;
            } else {
                // return icon;
                return new google.maps.MarkerImage(icon, null, null, null, new google.maps.Size(47, 47));
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
            // set filter if viewing as user
            if (GM.user.id === GM.user.viewAsId && GM.user.privilege === "admin") {
                filter = "";
            } else {
                filter = "&id=" + GM.user.viewAsId;
            }
            var param = "?c=content&a=legend&map=" + GM.currentMap + filter;
            xhr = $.getJSON(GM.rootAPI + param)
                .done(function (data) {
                    // prepare legend
                    if (data.result) {
                        // reset values
                        $(".progress div").css({"width" : 0});

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
                        $(".progress div").css({"width" : 0});
                    }

                    // set legend
                    GM.legend.activity.perc = GM.legend.activity.total !== 0 ? (GM.legend.activity.total / GM.legend.total * 100) : 0;
                    GM.legend.history.perc = GM.legend.history.total !== 0 ? (GM.legend.history.total / GM.legend.total * 100) : 0;
                    GM.legend.study.perc = GM.legend.study.total !== 0 ? (GM.legend.study.total / GM.legend.total * 100) : 0;
                    GM.legend.todo.perc = GM.legend.todo.total !== 0 ? (GM.legend.todo.total / GM.legend.total * 100) : 0;

                    setTimeout(function () {
                        GM._fn.setLegend();

                        // drop all markers on map
                        // GM._fn.placeMarkers();
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

        viewModal : function (i) {
            var details;
            // TODO
            // prepare modal
            details = "<img src='http://maps.googleapis.com/maps/api/staticmap?markers=icon:" + GM._fn.getIcon(GM.locations[i].category, true) + "|" + GM.locations[i].geo_lat + "," + GM.locations[i].geo_lng + "|shadow:true&center=" + GM.locations[i].geo_lat + "," + GM.locations[i].geo_lng + "&zoom=" + GM.options.zoom + "&maptype=hybrid&size=640x200&sensor=false' />";
            // details = "<img src='http://maps.googleapis.com/maps/api/staticmap?markers=icon:" + encodeURIComponent(GM._fn.getIcon(GM.locations[i].category), true) + "|" + GM.locations[i].geo_lat + "," +GM.locations[i].geo_lng + "|shadow:true&center=" + GM.locations[i].geo_lat + "," +GM.locations[i].geo_lng + "&zoom=" + GM.options.zoom + "&maptype=hybrid&size=640x200&sensor=false'/>";
            details += "i: " + i + "</br>";
            details += "id: " + GM.locations[i].id + "</br>";
            details += "type: " + GM.locations[i].type + "</br>";
            details += "content: " + GM.locations[i].content + "</br>";

            // console.log(details);
            $("#marker-modal h3").html(GM.locations[i].title + " (id=" + GM.locations[i].id + ")");
            $("#marker-modal .modal-body").html(details);
            $("#marker-modal").attr("data-item-id", i);

            // load modal
            $('#marker-modal').modal({
                keyboard : true,
                backdrop : true
            });
        },

        getSettings : function () {
            var param = "?c=site&a=id";
            xhr = $.getJSON(GM.rootAPI + param)
                .done(function (data) {
                    if (data.result) {
                        var site = data.items[0];
                        GM.site.name = site.name;
                        GM.site.desc = site.desc;
                        GM.site.debug = site.debug === '1' ? true : false;
                        GM.site.location = site.location === '1' ? true : false;
                        GM.site.legend = site.legend === '1' ? true : false;
                        GM._fn.setSettings();
                    }
                })
                .fail(function () {
                    alert("ERROR: " + param);
                });
        },

        setSettings : function () {
            if (GM.site.debug) {$("#debug").fadeIn('slow'); } else {$("#debug").fadeOut('slow'); }
            if (GM.site.location) {$("#location").fadeIn('slow'); } else {$("#location").fadeOut('slow'); }
            if (GM.site.legend) {$("#legend").fadeIn('slow'); } else {$("#legend").fadeOut('slow'); }

        },

        showSettings : function () {
            $("#modal-site [name='name']").val(GM.site.name);
            $("#modal-site [name='desc']").html(GM.site.desc);
            $("#modal-site [name='debug']").prop('checked', GM.site.debug);
            $("#modal-site [name='location']").prop('checked', GM.site.location);
            $("#modal-site [name='legend']").prop('checked', GM.site.legend);

            $('#modal-site').modal({
                keyboard : true,
                backdrop : true
            });
        },

        saveSettings : function () {
            var param = "?c=site&a=edit&" + $("#modal-site form").serialize();
            xhr = $.getJSON(GM.rootAPI + param)
                .done(function (data) {
                    $('#modal-site').modal('hide')
                    GM._fn.getSettings();
                })
                .fail(function () {
                    alert("ERROR: " + param);
                });

        },

        getUser : function () {
            var html;
            var param = "?c=user&a=id&id=" + GM.user.id;
            xhr = $.getJSON(GM.rootAPI + param)
                .done(function (data) {
                    if (data.result) {
                        var user = data.items[0];

                        // alert(site.name);
                        // view site settings
                        html += "<h2>" + user.first_name + " " + user.last_name + " </h2>";
                        html += '<p class="lead">' + user.bio + '</p> ';

                        $("#modal-users h3").html("My Settings");
                        $("#modal-users .modal-body #user").html(html);
                        $("#modal-users .modal-body div").hide();
                        $("#modal-users .modal-body #user").show();

                        // load modal & options
                        $('#modal-users').modal({keyboard : true});
                        // load carousel
                        $('#users-carousel').carousel({'interval' : false});

                    }
                })
                .fail(function () {
                    alert("ERROR: " + param);
                });
        },

        getUsers : function () {

            var html, i, j;
            var param = "?c=user&a=all";
            xhr = $.getJSON(GM.rootAPI + param)
                .done(function (data) {
                    if (data.result) {
                        for (i = 0 , j = 1; i < data.items.length; i++ , j++) {

                            html += '<tr>';
                            html += '<td>' +  j + '</td>';
                            html += '<td>' +  data.items[i].username + '</td>';
                            html += '<td>' +  data.items[i].first_name + '</td>';
                            html += '<td>' +  data.items[i].last_name + '</td>';
                            html += (data.items[i].privilege === "admin") ? '<td><i class="icon-ok-sign"></i></td>' : '<td></td>';
                            html += '<td><a href="#modal-users" data-slide="next" data-user-id="' +  data.items[i].id + '">Details</a></td>';
                            html += '</tr>';
                        }

                        $("#modal-users tbody").html(html);

                        // load modal & options
                        $('#modal-users').modal({keyboard : true});
                        // load carousel
                        $('#users-carousel').carousel({'interval' : false});

                    }
                })
                .fail(function () {
                    alert("ERROR: " + param);
                });
        },

        getUsersViewAs : function () {

            var html = "", i;
            var param = "?c=user&a=all&ignore=" + GM.user.id;
            xhr = $.getJSON(GM.rootAPI + param)
                .done(function (data) {
                    if (data.result) {
                        for (i = 0; i < data.items.length; i++) {
                            html += '<li>';
                            html += '<a class="view_as" data-user-id="' +  data.items[i].id + '" data-user-fullname="' +  data.items[i].first_name + ' ' + data.items[i].last_name + '" href="#">';
                            html += '<i class="icon-fixed-width icon-user"></i> ' +  data.items[i].first_name + ' ' + data.items[i].last_name + '</a>';
                            html += '</li>';
                        }
                        $(".nav #viewAsId").prepend(html);
                    }
                })
                .fail(function () {
                    alert("ERROR: " + param);
                });
        },

        editSettings : function () {

        },

        init : function () {
            navigator.geolocation.getCurrentPosition(GM._fn.getLocation);
            GM.user.id = $("#user").data("user-id");
            GM.user.privilege = $("#user").data("user-privilege");
            GM.user.viewAsId = $("#user").data("user-id");
            if (GM.user.privilege === "admin") {
                GM._fn.getUsersViewAs();
            };
            GM._fn.getSettings();
        }

    },

    API : {

        // TODO
        // calls go here!
    }

};

// other JS goes here

$(function () {

    // default map on dashboard
    GM.currentMap = "smi";
    GM.options.draggable = true;

    // init
    GM._fn.init();

    // NAVIGATION

    // change map
    $(".nav .set_map").click(function (e) {
        e.preventDefault();
        GM.currentMap = $(this).data("map");
        GM._fn.setMap();
    });

    // view as
    $("#viewAsId").delegate("a", "click", function (e) {
        e.preventDefault();
        GM.user.viewAsId = $(this).data("user-id");
        $("#view-as").html($(this).data("user-fullname"));
        GM._fn.setMap();
    });

    // site settings get
    $(".nav .settings").click(function (e) {
        e.preventDefault();
        GM._fn.showSettings();
    });

    // site settings save
    $("#modal-site a.save").click(function (e) {
        e.preventDefault();
        GM._fn.saveSettings();
    });

    // user settings
    $(".nav .user").click(function (e) {
        e.preventDefault();
        GM._fn.getUser();
    });

    // users settings
    $(".nav .users").click(function (e) {
        e.preventDefault();
        GM._fn.getUsers();
    });

    // custom map type
    $("#map-controls #mapType").click(function (e) {
        e.preventDefault();
        var typeId = $(this).data("type-id") + 1;
        // alert(typeId);
        if (typeId === 5) {typeId = 0; }
        $(this).data("type-id", typeId);
        GM._fn.customType(typeId);
    });

    // custom map zoom +
    $("#map-controls #zoomIn").click(function (e) {
        e.preventDefault();
        if (GM.options.zoom < GM.options.maxZoom) {
            GM.options.zoom += 1;
            map.setZoom(GM.options.zoom);
        }
        GM._fn.customZoom();
    });

    // custom map zoom -
    $("#map-controls #zoomOut").click(function (e) {
        e.preventDefault();
        if (GM.options.zoom > GM.options.minZoom) {
            GM.options.zoom -= 1;
            map.setZoom(GM.options.zoom);
        }
        GM._fn.customZoom();
    });

    // progress tooltip
    $('.progress div a').popover({placement: "top", trigger : "hover", toggle : "popover" });

    // Scroll Spy
    $('#navbar').scrollspy();

    // Modals
    $('#marker-modal').delegate(".delete", "click", function(e){
        alert("DELETE! " + $('#marker-modal').data('item-id'));
        GM._fn.deleteMarker($('#marker-modal').data('item-id'));
        e.preventDefault();
    });

    // Edit
    $('#marker-modal').delegate(".edit", "click", function(e){
        alert("EDIT! " + $('#marker-modal').data('item-id'));
        GM._fn.deleteMarker($('#marker-modal').data('item-id'));
        e.preventDefault();
    });


    // // iScroll
    // var myScroll = new iScroll('wrapper', {
    //     snap: 'li',
    //     momentum: false,
    //     hScrollbar: false,
    //     vScrollbar: false
    // });

});
