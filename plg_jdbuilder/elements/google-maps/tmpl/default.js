(function () {
    var themes = {
        'silver': [{
            "elementType": "geometry",
            "stylers": [{
                "color": "#f5f5f5"
            }]
        }, {
            "elementType": "labels.icon",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#616161"
            }]
        }, {
            "elementType": "labels.text.stroke",
            "stylers": [{
                "color": "#f5f5f5"
            }]
        }, {
            "featureType": "administrative.land_parcel",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#bdbdbd"
            }]
        }, {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [{
                "color": "#eeeeee"
            }]
        }, {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#757575"
            }]
        }, {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [{
                "color": "#e5e5e5"
            }]
        }, {
            "featureType": "poi.park",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#9e9e9e"
            }]
        }, {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [{
                "color": "#ffffff"
            }]
        }, {
            "featureType": "road.arterial",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#757575"
            }]
        }, {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [{
                "color": "#dadada"
            }]
        }, {
            "featureType": "road.highway",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#616161"
            }]
        }, {
            "featureType": "road.local",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#9e9e9e"
            }]
        }, {
            "featureType": "transit.line",
            "elementType": "geometry",
            "stylers": [{
                "color": "#e5e5e5"
            }]
        }, {
            "featureType": "transit.station",
            "elementType": "geometry",
            "stylers": [{
                "color": "#eeeeee"
            }]
        }, {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{
                "color": "#c9c9c9"
            }]
        }, {
            "featureType": "water",
            "elementType": "labels.text.fill",
            "stylers": [{
                "color": "#9e9e9e"
            }]
        }],
        'retro': [{
                "elementType": "geometry",
                "stylers": [{
                    "color": "#ebe3cd"
                }]
            },
            {
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#523735"
                }]
            },
            {
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#f5f1e6"
                }]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#c9b2a6"
                }]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#dcd2be"
                }]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#ae9e90"
                }]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#dfd2ae"
                }]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#dfd2ae"
                }]
            },
            {
                "featureType": "poi",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#93817c"
                }]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#a5b076"
                }]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#447530"
                }]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#f5f1e6"
                }]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#fdfcf8"
                }]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#f8c967"
                }]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#e9bc62"
                }]
            },
            {
                "featureType": "road.highway.controlled_access",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#e98d58"
                }]
            },
            {
                "featureType": "road.highway.controlled_access",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#db8555"
                }]
            },
            {
                "featureType": "road.local",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#806b63"
                }]
            },
            {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#dfd2ae"
                }]
            },
            {
                "featureType": "transit.line",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#8f7d77"
                }]
            },
            {
                "featureType": "transit.line",
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#ebe3cd"
                }]
            },
            {
                "featureType": "transit.station",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#dfd2ae"
                }]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#b9d3c2"
                }]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#92998d"
                }]
            }
        ],
        'dark': [{
                "elementType": "geometry",
                "stylers": [{
                    "color": "#212121"
                }]
            },
            {
                "elementType": "labels.icon",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#757575"
                }]
            },
            {
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#212121"
                }]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#757575"
                }]
            },
            {
                "featureType": "administrative.country",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#9e9e9e"
                }]
            },
            {
                "featureType": "administrative.land_parcel",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#bdbdbd"
                }]
            },
            {
                "featureType": "poi",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#757575"
                }]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#181818"
                }]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#616161"
                }]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#1b1b1b"
                }]
            },
            {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#2c2c2c"
                }]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#8a8a8a"
                }]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#373737"
                }]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#3c3c3c"
                }]
            },
            {
                "featureType": "road.highway.controlled_access",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#4e4e4e"
                }]
            },
            {
                "featureType": "road.local",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#616161"
                }]
            },
            {
                "featureType": "transit",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#757575"
                }]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#000000"
                }]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#3d3d3d"
                }]
            }
        ],
        'night': [{
                "elementType": "geometry",
                "stylers": [{
                    "color": "#242f3e"
                }]
            },
            {
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#746855"
                }]
            },
            {
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#242f3e"
                }]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#d59563"
                }]
            },
            {
                "featureType": "poi",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#d59563"
                }]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#263c3f"
                }]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#6b9a76"
                }]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#38414e"
                }]
            },
            {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#212a37"
                }]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#9ca5b3"
                }]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#746855"
                }]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#1f2835"
                }]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#f3d19c"
                }]
            },
            {
                "featureType": "transit",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#2f3948"
                }]
            },
            {
                "featureType": "transit.station",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#d59563"
                }]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#17263c"
                }]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#515c6d"
                }]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#17263c"
                }]
            }
        ],
        'aubergine': [{
                "elementType": "geometry",
                "stylers": [{
                    "color": "#1d2c4d"
                }]
            },
            {
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#8ec3b9"
                }]
            },
            {
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#1a3646"
                }]
            },
            {
                "featureType": "administrative.country",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#4b6878"
                }]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#64779e"
                }]
            },
            {
                "featureType": "administrative.province",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#4b6878"
                }]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#334e87"
                }]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#023e58"
                }]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#283d6a"
                }]
            },
            {
                "featureType": "poi",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#6f9ba5"
                }]
            },
            {
                "featureType": "poi",
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#1d2c4d"
                }]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#023e58"
                }]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#3C7680"
                }]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#304a7d"
                }]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#98a5be"
                }]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#1d2c4d"
                }]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#2c6675"
                }]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#255763"
                }]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#b0d5ce"
                }]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#023e58"
                }]
            },
            {
                "featureType": "transit",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#98a5be"
                }]
            },
            {
                "featureType": "transit",
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#1d2c4d"
                }]
            },
            {
                "featureType": "transit.line",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#283d6a"
                }]
            },
            {
                "featureType": "transit.station",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#3a4762"
                }]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#0e1626"
                }]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#4e6d70"
                }]
            }
        ]
    };

    var JDBuilderElementGoogleMaps = function (element) {
        element.addClass('jdb-google-map');
        elementStyling(element);

        var markers = _JDBDATA.get('markers-' + element.id);
        var infowindows = _JDBDATA.get('infowindows-' + element.id);
        if (markers === undefined) {
            _JDBDATA.set('markers-' + element.id, new Map());
        }
        if (infowindows === undefined) {
            _JDBDATA.set('infowindows-' + element.id, new Map());
        }
        return '<div id="jdb-gmap-' + element.id + '"></div>';
    }

    function elementStyling(element) {
        var mapStyle = new JDBRenderer.ElementStyle("#jdb-gmap-" + element.id);
        var infoStyle = new JDBRenderer.ElementStyle(".jdb-gmap-info");
        var infoContainerStyle = new JDBRenderer.ElementStyle(".gm-style-iw");
        var infoContainerAfterStyle = new JDBRenderer.ElementStyle(".gm-style .gm-style-iw-t::after");
        var titleStyle = new JDBRenderer.ElementStyle(".jdb-gmap-info-title");
        var descStyle = new JDBRenderer.ElementStyle(".jdb-gmap-info-desc");
        element.addChildrenStyle([mapStyle, infoStyle, titleStyle, descStyle, infoContainerStyle, infoContainerAfterStyle]);

        var mapHeight = element.params.get('mapHeight', null);
        if (mapHeight !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in mapHeight) && JDBRenderer.Helper.checkSliderValue(mapHeight[_deviceObj.key])) {
                    mapStyle.addCss("height", mapHeight[_deviceObj.key].value + mapHeight[_deviceObj.key].unit, _deviceObj.type);
                }
            });
        }

        var infoWidth = element.params.get('infoWidth', null);
        if (infoWidth !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in infoWidth) && JDBRenderer.Helper.checkSliderValue(infoWidth[_deviceObj.key])) {
                    infoStyle.addCss("max-width", infoWidth[_deviceObj.key].value + infoWidth[_deviceObj.key].unit, _deviceObj.type);
                }
            });
        }

        var infoPadding = element.params.get('infoPadding', null);
        if (infoPadding !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in infoPadding) {
                    infoStyle.addStyle(JDBRenderer.Helper.spacingValue(infoPadding[_deviceObj.key], "padding"), _deviceObj.type);
                }
            });
        }
        infoContainerStyle.addCss('padding', 0);
        infoContainerStyle.addCss('background-color', element.params.get('infoBackgroundColor', ''));
        infoContainerAfterStyle.addCss('background', 'linear-gradient(45deg,' + element.params.get('infoBackgroundColor', 'rgba(255,255,255,1)') + ' 50%,rgba(255,255,255,0) 51%,rgba(255,255,255,0) 100%)');
        JDBRenderer.Helper.applyBorderValue(infoContainerStyle, element.params, "infoBorder");


        let infoSpaceBetween = element.params.get('infoSpaceBetween', null);
        if (infoSpaceBetween != null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if ((_deviceObj.key in infoSpaceBetween) && JDBRenderer.Helper.checkSliderValue(infoSpaceBetween[_deviceObj.key])) {
                    titleStyle.addCss("margin-bottom", infoSpaceBetween[_deviceObj.key].value + 'px', _deviceObj.type);
                }
            });
        }

        titleStyle.addCss('color', element.params.get('infoTitleColor', ''));

        var typography = element.params.get("infoTitleTypography", null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    titleStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        descStyle.addCss('color', element.params.get('infoDescriptionColor', ''));

        var typography = element.params.get("infoDescriptionTypography", null);
        if (typography !== null) {
            JDBRenderer.DEVICES.forEach(function (_deviceObj) {
                if (_deviceObj.key in typography) {
                    descStyle.addStyle(JDBRenderer.Helper.typographyValue(typography[_deviceObj.key]), _deviceObj.type);
                }
            });
        }

        descStyle.addCss('margin-bottom', '0px');
    }

    function initMap(element, params) {
        if (google == undefined) {
            return;
        }
        var mapType = params.get('mapType', 'roadmap');
        var mapTheme = params.get('mapTheme', '');
        var mapZoom = params.get('mapZoom', {
            value: 7
        });
        var controls = getControls(params);
        if (mapType == 'satellite') {
            mapTheme = [];
        } else if (mapTheme == '') {
            mapTheme = [];
        } else if (mapTheme == 'custom') {
            if (params.get('customTheme', '') != '') {
                mapTheme = JSON.parse(params.get('customTheme', ''));
            } else {
                mapTheme = [];
            }
        } else {
            mapTheme = themes[mapTheme];
        }

        controls = Object.assign(controls, {
            mapTypeId: mapType,
            styles: mapTheme,
            zoom: mapZoom.value
        });

        var map = new google.maps.Map(document.getElementById('jdb-gmap-' + element.id), controls);
        var geocoder = new google.maps.Geocoder;
        var bounds = new google.maps.LatLngBounds();
        _JDBDATA.set('map-' + element.id, map);
        _JDBDATA.set('bounds-' + element.id, bounds);
        _JDBDATA.set('geocoder-' + element.id, geocoder);
        addPlaces(element, params);
    }

    function clearMap(element) {
        var markers = _JDBDATA.get('markers-' + element.id);
        var infowindows = _JDBDATA.get('infowindows-' + element.id);
        infowindows.clear();
        markers.clear();
    }

    function validLatLng(item) {
        return ('lat' in item && 'lng' in item && item.lat !== '' && item.lat !== false && item.lat !== null && item.lat !== undefined && item.lat.length !== 0 && item.lng !== '' && item.lng !== false && item.lng !== null && item.lng !== undefined && item.lng.length !== 0);
    }

    function addPlaces(element, params) {
        var map = _JDBDATA.get('map-' + element.id);
        var bounds = _JDBDATA.get('bounds-' + element.id);
        var markers = _JDBDATA.get('markers-' + element.id);
        var infowindows = _JDBDATA.get('infowindows-' + element.id);

        var locations = params.get('locations', []);
        var animation = params.get('markerAnimation', '');
        var mapZoom = params.get('mapZoom', {
            value: 7
        });
        if (!locations.length) {
            clearMap(element);
            return false;
        }
        locations.forEach(function (item) {
            if (validLatLng(item)) {
                map.setCenter({
                    lat: Number(item.lat),
                    lng: Number(item.lng)
                });

                var markerObj = {
                    map: map,
                    position: {
                        lat: Number(item.lat),
                        lng: Number(item.lng)
                    },
                    icon: ''
                };

                if (animation != '') {
                    if (animation == 'drop') {
                        markerObj.animation = google.maps.Animation.DROP;
                    } else {
                        markerObj.animation = google.maps.Animation.BOUNCE;
                    }
                }

                if (item.markerType == 'custom' && item.customMarker != '') {
                    var size = item.customMarkerSize !== undefined ? item.customMarkerSize.value : 20;
                    if (!Number.isInteger(size)) {
                        size = 20;
                    }
                    markerObj.icon = {
                        url: JDBRenderer.Helper.mediaValue(item.customMarker),
                        scaledSize: new google.maps.Size(size, size)
                    };
                } else {
                    markerObj.icon = '';
                }

                var marker = new google.maps.Marker(markerObj);
                var infowindow = new google.maps.InfoWindow({
                    content: ''
                });

                var _locId = item.lat + '-' + item.lng;

                marker.addListener('click', function () {
                    if (infowindow.content != '') {
                        infowindows.forEach(function (iw, iwl) {
                            if (iwl != _locId) {
                                iw.close();
                            }
                        });
                        infowindow.open(map, marker);
                    }
                });

                markers.set(_locId, marker);
                infowindows.set(_locId, infowindow);

                var loc = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
                bounds.extend(loc);
            }
        });
        setTimeout(function () {
            map.fitBounds(bounds);
            map.panToBounds(bounds);
            if (Number.isInteger(mapZoom.value)) {
                setTimeout(function () {
                    map.setZoom(mapZoom.value);
                }, 100);
            }
        });
        updateInfowindows(element, locations);
    }

    JDBuilderElementGoogleMaps.onAfterDisplay = function (element, oldParams, newParams, newItem) {
        var map = _JDBDATA.get('map-' + element.id);

        if (element === undefined) {
            return;
        }
        var oldLocations = oldParams.get('locations', []);
        var newLocations = newParams.get('locations', []);
        var oldPlaces = [];
        var newPlaces = [];

        oldLocations.forEach(function (item) {
            if (validLatLng(item)) {
                oldPlaces.push({
                    lat: item.lat,
                    lng: item.lng,
                    markerType: item.markerType,
                    customMarker: item.customMarker,
                    customMarkerSize: item.customMarkerSize
                });
            }
        });

        newLocations.forEach(function (item) {
            if (validLatLng(item)) {
                newPlaces.push({
                    lat: item.lat,
                    lng: item.lng,
                    markerType: item.markerType,
                    customMarker: item.customMarker,
                    customMarkerSize: item.customMarkerSize
                });
            }
        });

        if (!JDBRenderer.Helper.isEqual(oldPlaces, newPlaces)) {
            clearMap(element);
            initMap(element, newParams);
        }

        if (JDBRenderer.Helper.isEqual(oldPlaces, newPlaces) && !JDBRenderer.Helper.isEqual(oldLocations, newLocations)) {
            updateInfowindows(element, newLocations);
        }

        if (!JDBRenderer.Helper.isEqual(oldParams.get('mapType', 'roadmap'), newParams.get('mapType', 'roadmap'))) {
            map.setMapTypeId(newParams.get('mapType', 'roadmap'));
        }

        if (!JDBRenderer.Helper.isEqual(oldParams.get('mapTheme', ''), newParams.get('mapTheme', '')) || !JDBRenderer.Helper.isEqual(oldParams.get('customTheme', ''), newParams.get('customTheme', '')) || !JDBRenderer.Helper.isEqual(oldParams.get('markerAnimation', ''), newParams.get('markerAnimation', '')) || !JDBRenderer.Helper.isEqual(oldParams.get('mapZoom', {
                value: 7
            }), newParams.get('mapZoom', {
                value: 7
            }))) {
            clearMap(element);
            initMap(element, newParams);
        }

        var oldControls = getControls(oldParams);
        var newControls = getControls(newParams);

        if (!JDBRenderer.Helper.isEqual(oldControls, newControls)) {
            clearMap(element);
            initMap(element, newParams);
        }
    }

    getControls = function (params) {
        return {
            scrollwheel: params.get('scrollwheel', true),
            zoomControl: params.get('zoomControl', true),
            mapTypeControl: params.get('mapTypeControl', true),
            scaleControl: false,
            streetViewControl: params.get('streetViewControl', true),
            rotateControl: false,
            fullscreenControl: params.get('fullscreenControl', true)
        }
    }

    updateInfowindows = function (element, locations) {
        var map = _JDBDATA.get('map-' + element.id);
        var markers = _JDBDATA.get('markers-' + element.id);
        var infowindows = _JDBDATA.get('infowindows-' + element.id);

        locations.forEach(function (item) {
            if (validLatLng(item)) {
                var _locId = item.lat + '-' + item.lng;
                var infowindow = infowindows.get(_locId);
                var marker = markers.get(_locId);
                if (infowindow == undefined) {
                    return false;
                }
                if ('infoWindow' in item && item.infoWindow != '') {
                    var content = ['<div class="jdb-gmap-info">'];
                    if (item.title != '') {
                        content.push('<div class="jdb-gmap-info-title">' + item.title + '</div>');
                    }
                    if (item.description != '') {
                        content.push('<div class="jdb-gmap-info-desc">' + item.description + '</div>');
                    }
                    content.push('</div>');
                    infowindow.setContent(content.join(''));
                    if (item.infoWindow == 'onload') {
                        infowindow.open(map, marker);
                    }
                } else {
                    infowindow.setContent('');
                    infowindow.close();
                }
            }
        });
    }

    window.JDBuilderElementGoogleMaps = JDBuilderElementGoogleMaps;

})();