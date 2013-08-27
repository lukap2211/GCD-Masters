/*!
* Copyright 2013 Luka Puharic
* http://www.apache.org/licenses/LICENSE-2.0.txt
*/

var marker, map, xhr;

// Google Maps object
var GM = {

    // settings
    apiKey          : "AIzaSyCGHVSkXtwVy4D6GDK5WVVgFXs_SKg-0Z0",
    // rootURL         : "http://github/GCD-masters/",         // local
    rootURL         : "http://lukap.info/gcd/masters/",     // production
    latitude        : "",
    longitude       : "",
    accuracy        : "",

    // site settings
    site   : {
        name        : "",
        desc        : "",
        debug       : "",
        location    : "",
        legend      : ""
    },

    // user
    user : {
        id          : "",
        viewAsId    : ""
    },

    // markers
    locations       : [],
    markers         : [],
    currentId         : "",
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
        green       : "http://lukap.info/gcd/masters/admin/img/pin_green",
        orange      : "http://lukap.info/gcd/masters/admin/img/pin_orange",
        blue        : "http://lukap.info/gcd/masters/admin/img/pin_blue",
        black       : "http://lukap.info/gcd/masters/admin/img/pin_black",
        todo        : "http://lukap.info/gcd/masters/admin/img/pin_todo",
        shadow      : "http://lukap.info/gcd/masters/admin/img/pin_shadow"
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

    // map opions
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

        map : {

            getLocation : function (position) {
                GM.latitude  = position.coords.latitude;
                GM.longitude = position.coords.longitude;
                GM.accuracy  = position.coords.accuracy;

                // showing current location
                $("#my_location").html("<a href='//maps.google.com/?q=" + GM.latitude + "," + GM.longitude + "' target=_blank>" + GM.latitude + ", " + GM.longitude + "</a>").hide().fadeIn();
                $("#my_accuracy").html(Math.round(GM.accuracy)).hide().fadeIn();

                // load map when location retrieved
                GM._fn.map.getMap();
            },

            getMap : function () {
                // google.maps.visualRefresh = true;
                map = new google.maps.Map(document.getElementById('map-canvas'), GM.options);
                // move to current location
                var center = new google.maps.LatLng(GM.latitude, GM.longitude);
                map.panTo(center);

                // set Map
                GM._fn.map.setMap();

                // set listeners

                // on click add new location
                google.maps.event.addListener(map, 'dblclick', function (e) {
                    // if (GM.user.id !== GM.user.viewAsId) {
                        // alert("You cant add marker while viewing as another user!");
                    // } else {
                        // disable more than one at the setTimeout
                        // console.log(marker === undefined);
                        // if(marker === undefined){
                        GM._fn.marker.addMarker(e.latLng, map);
                        // }
                    // }
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
                };
            },

            setMap : function () {

                GM._fn.markers.loadMarkers(true);
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
            }
        },

        markers : {

            loadMarkers : function (timeout) {

                var filter;
                // reset values
                GM._fn.map.clearMap();

                if (GM.user.id === GM.user.viewAsId && GM.user.privilege === "admin") {
                    filter = "";
                } else {
                    filter = "&id=" + GM.user.viewAsId;
                }

                var param = "API/?c=content&a=all&map=" + GM.currentMap + filter;
                xhr = $.getJSON(GM.rootURL + param)
                    .done(function (data) {
                        if (data.result) {
                            $.each(data.items, function (i, item) {
                                GM.locations.push(item);
                            });
                        }
                        // $(".progress div").css({"width" : 0});
                        // drop all markers on map
                        setTimeout(function () {
                            GM._fn.markers.placeMarkers(timeout);
                        }, 1000);


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

            addMarker : function (position, map) {

                // update position
                if (GM.user.privilege === "admin") {
                    document.getElementById("latitude").value = position.lat();
                    document.getElementById("longitude").value = position.lng();
                }

                // insert into DB via API
                var param = "API/?c=content&a=add&geo_lat=" + position.lat() + "&geo_lng=" + position.lng() + "&user_id=" + GM.user.viewAsId + "&map=" + GM.currentMap + "&category=todo";
                xhr = $.getJSON(GM.rootURL + param)
                    .done(function (data) {
                        console.log("ID: " + data.result + " - Marker added!");
                        GM._fn.marker.getMarker(data.result);
                    })
                    .fail(function () {
                        alert("ERROR: " + param);
                    });
            },

            getMarker : function (id) {

                // ad to location[]
                // insert into DB via API
                var param = "API/?c=content&a=id&id=" + id;
                xhr = $.getJSON(GM.rootURL + param)
                    .done(function (data) {
                        if(data.result){
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

                var i = GM.iterator, animate_me;


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
                    // TODO ?
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

                // update location
                google.maps.event.addListener(GM.markers[i], 'dragend', function (e) {
                    GM._fn.marker.moveMarker(e.latLng, map, i);
                });

                GM.iterator++;
            },

            moveMarker : function (position, map, i) {

                // udpate object
                // map.panTo(position);
                GM.locations[i].geo_lat = position.lat();
                GM.locations[i].geo_lng = position.lng();

                // update position
                if (GM.user.privilege === "admin") {
                    document.getElementById("latitude").value = position.lat();
                    document.getElementById("longitude").value = position.lng();
                }

                GM._fn.marker.editLocation(i);
            },

            editLocation : function (i) {
                // update location in db
                var param = "API/?c=content&a=edit_loc&id=" + GM.locations[i].id + "&geo_lat=" + GM.locations[i].geo_lat + "&geo_lng=" + GM.locations[i].geo_lng;
                xhr = $.getJSON(GM.rootURL + param)
                    .done(function (data) {
                        if (data.result) {
                            console.log("Id: " + GM.locations[i].id + " - Marker location updated!");
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
                    var param = "API/?c=content&a=delete&id=" + GM.locations[i].id;
                    xhr = $.getJSON(GM.rootURL + param)
                        .done(function (data) {
                            if (data.result) {

                                console.log("ID: " + GM.locations[i].id + " - Deleted!");

                                // clean markers array
                                GM.markers[i].setMap(null);
                                GM.locations.splice(i, 1);
                                GM.markers.splice(i, 1);

                                // close and refresh
                                $("#marker-modal").modal('hide');
                                GM._fn.markers.loadMarkers();
                            } else {
                                // TODO
                                alert("ERROR: no results!");
                            }
                        })
                        .fail(function () {
                            alert("ERROR: " + param);
                        });

                } else {
                    console.log("ID: " + GM.locations[i].id + " - Not Deleted!");
                }
            },

            viewMarker : function (i) {
                // reset form
                $("#upload_form")[0].reset();
                $('#marker-tabs a:first').tab('show');

                GM.currentId = i;

                var data = GM.locations[i];

                console.log("ID: " + GM.locations[i].id + " - View Marker");
                // console.log(data);

                var src = "http://maps.googleapis.com/maps/api/staticmap?markers=icon:" + GM._fn.admin.getIcon(GM.locations[i].category, true) + "|" + GM.locations[i].geo_lat + "," + GM.locations[i].geo_lng + "|shadow:true&center=" + GM.locations[i].geo_lat + "," + GM.locations[i].geo_lng + "&zoom=" + GM.options.zoom + "&maptype=hybrid&size=530x250&sensor=false";

                // add info
                $("#modal-marker .edit-info").html("Edited on " +  data.date_modified + " by " + data.user_edit);



                $("#modal-marker [name='id']").val(data.id);
                $("#modal-marker [name='user_id']").val(GM.user.viewAsId);
                $("#modal-marker [name='title']").val(data.title);
                $("#modal-marker [name='content']").html(data.content);
                $("#modal-marker .geo_lat").html(data.geo_lat);
                $("#modal-marker .geo_lng").html(data.geo_lng);

                $("#modal-marker :radio[name ='category']").prop('checked', false);
                $("#modal-marker input[value='" + data.category + "']").prop('checked', true);
                $("#modal-marker .sat_map").prop("src", src);

                $("#modal-marker [name='comments']").prop('checked', data.comments === '1' ? true : false);
                $("#modal-marker [name='twitter']").prop('checked', data.twitter === '1' ? true : false);
                $("#modal-marker [name='facebook']").prop('checked', data.facebook === '1' ? true : false);

                // load image from database based on id
                if (data.image_name) {
                    GM._fn.marker.loadImage(data.id);
                } else {
                    console.log("ID: " + GM.locations[i].id + " - NO Image.");
                    $("#modal-marker .image").prop("src", GM.rootURL + "admin/img/noimage.png");
                }

                // load modal
                $('#modal-marker').modal({
                    keyboard : true,
                    backdrop : true
                });
            },

            loadImage : function (id) {
                // load iamge from database based on id
                console.log("ID: " + id + " - Loading image...");
                $("#modal-marker .image").prop("src", GM.rootURL + "API/load_image.php?id=" + id);
            },

            saveMarkerStart : function () {
                console.log("ID: " + GM.currentId + " - Saving Marker...");
                $('.modal .loader').css("display", "block");
                $('.modal .actions').css("display", "none");
                return false;
            },

            saveMarkerStop : function (output) {

                console.log("ID: " + GM.currentId + " - Done!");
                // console.log(output);

                if (output.result === 1){
                    setTimeout(function () {
                        $(".loader").css("display", "none");
                        $('#modal-marker').modal('hide');
                        GM._fn.markers.loadMarkers();
                    }, 1000)
                } else {
                    alert(output.error);
                    $(".loader").css("display", "none");
                }

                return true;
            }
        },

        user : {

            getUser : function (id) {
                var param = "API/?c=user&a=id&id=" + id;
                xhr = $.getJSON(GM.rootURL + param)
                    .done(function (data) {
                        if (data.result) {
                            var user = data.items[0];
                            GM._fn.user.showUser(user);
                        }
                    })
                    .fail(function () {
                        alert("ERROR: " + param);
                    });
            },

            showUser : function (user) {
                $("#modal-user h3").html(" My Settings <span>(" + user.username + " - " + user.privilege + ")</span>");

                $("#modal-user [name='id']").val(user.id);
                $("#modal-user [name='first_name']").val(user.first_name);
                $("#modal-user [name='last_name']").val(user.last_name);
                $("#modal-user [name='bio']").html(user.bio);
                $("#modal-user [name='admin']").prop('checked', user.admin);
                $("#modal-user [type='password']").val("");

                $('#modal-user').modal({
                    keyboard : true,
                    backdrop : true
                });
            },

            saveUser : function () {

                var pass = "";

                // new password check
                if ($("#modal-user [name='new-pass']").val() !== "" || $("#modal-user [name='repeat-pass']").val() !== "") {
                    if ($("#modal-user [name='new-pass']").val() === $("#modal-user [name='repeat-pass']").val()) {
                        pass = "&pass=" + $("#modal-user [name='new-pass']").val();
                    } else {
                        $("#modal-user [name='new-pass']").val("");
                        $("#modal-user [name='repeat-pass']").val("");
                        alert("Your New and Repeat Password must match!");
                        return false;
                    }
                }

                var param = "API/?c=user&a=edit&" + $("#modal-user form").serialize() + pass;
                xhr = $.getJSON(GM.rootURL + param)
                    .done(function () {
                        $('#modal-user').modal('hide');
                        GM._fn.settings.get();
                    })
                    .fail(function () {
                        alert("ERROR: " + param);
                    });
                console.log(param);
            },

            getAllUsers : function () {

                var html, i, j;
                var param = "API/?c=user&a=all";
                xhr = $.getJSON(GM.rootURL + param)
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
            }
        },

        admin : {

            viewAs : function () {

                var html = "", i;
                var param = "API/?c=user&a=all&ignore=" + GM.user.id;
                xhr = $.getJSON(GM.rootURL + param)
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
                // set filter if viewing as user
                if (GM.user.id === GM.user.viewAsId && GM.user.privilege === "admin") {
                    filter = "";
                } else {
                    filter = "&id=" + GM.user.viewAsId;
                }
                var param = "API/?c=content&a=legend&map=" + GM.currentMap + filter;
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
            }
        },

        settings : {

            getSettings : function () {
                var param = "API/?c=site&a=id";
                xhr = $.getJSON(GM.rootURL + param)
                    .done(function (data) {
                        if (data.result) {
                            var site = data.items[0];
                            GM.site.name = site.name;
                            GM.site.desc = site.desc;
                            GM.site.debug = site.debug === '1' ? true : false;
                            GM.site.location = site.location === '1' ? true : false;
                            GM.site.legend = site.legend === '1' ? true : false;
                            GM._fn.settings.setSettings();
                        }
                    })
                    .fail(function () {
                        alert("ERROR: " + param);
                    });
            },

            setSettings : function () {
                if (GM.site.debug) {
                    $("#debug").fadeIn('slow');
                    $("#upload_target").addClass("debug");
                } else {
                    $("#upload_target").removeClass("debug");
                    $("#debug").fadeOut('slow');
                }
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
                var param = "API/?c=site&a=edit&" + $("#modal-site form").serialize();
                xhr = $.getJSON(GM.rootURL + param)
                    .done(function () {
                        $('#modal-site').modal('hide');
                        GM._fn.settings.getSettings();
                    })
                    .fail(function () {
                        alert("ERROR: " + param);
                    });
            }
        }
    },

    init : function () {
        navigator.geolocation.getCurrentPosition(GM._fn.map.getLocation);
        GM.user.id = $("#user").data("user-id");
        GM.user.privilege = $("#user").data("user-privilege");
        GM.user.viewAsId = $("#user").data("user-id");
        if (GM.user.privilege === "admin") {
            GM._fn.admin.viewAs();
            GM._fn.settings.getSettings();
        }
    }

};

// other JS goes here

$(function () {

    // default map on dashboard
    GM.currentMap = "smi";
    GM.options.draggable = true;

    // init
    GM.init();

    // NAVIGATION

    // change map
    $(".nav .set_map").click(function (e) {
        e.preventDefault();
        GM.currentMap = $(this).data("map");
        GM._fn.map.setMap();
    });

    // view as
    $("#viewAsId").delegate("a", "click", function (e) {
        e.preventDefault();
        GM.user.viewAsId = $(this).data("user-id");
        $("#view-as").html($(this).data("user-fullname"));
        GM._fn.markers.loadMarkers();
    });

    // site settings get
    $(".nav .settings").click(function (e) {
        e.preventDefault();
        GM._fn.settings.showSettings();
    });

    // user settings
    $(".nav .user").click(function (e) {
        e.preventDefault();
        GM._fn.user.getUser(GM.user.id);
    });

    // users settings
    $(".nav .users").click(function (e) {
        e.preventDefault();
        GM._fn.user.getAllUsers();
    });

    // site settings save
    $("#modal-site a.save").click(function (e) {
        e.preventDefault();
        GM._fn.settings.saveSettings();
    });

    // user save
    $("#modal-user a.save").click(function (e) {
        e.preventDefault();
        GM._fn.user.saveUser();
    });

    // marker upload image
    // $("#modal-marker .upload-image").click(function (e) {
    //     e.preventDefault();
    //     GM._fn.marker.saveStart();
    // });

    // marker save
    $("#modal-marker a.save").click(function (e) {
        e.preventDefault();
        GM._fn.marker.saveMarkerStart();
        $("#upload_form").submit();

    });

    $('#modal-marker a.delete').click(function (e) {
        GM._fn.marker.deleteMarker(GM.currentId);
        e.preventDefault();
    });

    // custom map type
    $("#map-controls #mapType").click(function (e) {
        e.preventDefault();
        var typeId = $(this).data("type-id") + 1;
        // alert(typeId);
        if (typeId === 5) {typeId = 0; }
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

    // progress tooltip
    $('#legend .progress div a').popover({placement: "top", trigger : "hover", toggle : "popover" });

    // Scroll Spy
    $('#navbar').scrollspy();

});

