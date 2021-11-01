<?php

/**
 * @package    JD Builder
 * @author     Team Joomdev <info@joomdev.com>
 * @copyright  2020 www.joomdev.com
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
extract($displayData);
$element->addClass('jdb-google-map');
?>
<div id="jdb-gmap-<?php echo $element->id; ?>"></div>
<?php
// element styling
$mapStyle = new JDPageBuilder\Element\ElementStyle('#jdb-gmap-' . $element->id);
$infoStyle = new JDPageBuilder\Element\ElementStyle('.jdb-gmap-info');
$infoContainerStyle = new JDPageBuilder\Element\ElementStyle('.gm-style-iw');
$infoContainerAfterStyle = new JDPageBuilder\Element\ElementStyle(".gm-style .gm-style-iw-t::after");
$titleStyle = new JDPageBuilder\Element\ElementStyle('.jdb-gmap-info-title');
$descStyle = new JDPageBuilder\Element\ElementStyle('.jdb-gmap-info-desc');
$element->addChildrenStyle([$mapStyle, $infoStyle, $infoContainerStyle, $titleStyle, $descStyle, $infoContainerAfterStyle]);

$height = $element->params->get('mapHeight', null);
if (!empty($height)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($height->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($height->{$deviceKey})) {
            $mapStyle->addCss('height', $height->{$deviceKey}->value . $height->{$deviceKey}->unit, $device);
        }
    }
}

$infoWidth = $element->params->get('infoWidth', null);
if (!empty($height)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($infoWidth->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($infoWidth->{$deviceKey})) {
            $infoStyle->addCss('max-width', $infoWidth->{$deviceKey}->value . $infoWidth->{$deviceKey}->unit, $device);
        }
    }
}

$infoPadding = $element->params->get('infoPadding', null);
if (!empty($infoPadding)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($infoPadding->{$deviceKey}) && !empty($infoPadding->{$deviceKey})) {
            $infoStyle->addStyle(JDPageBuilder\Helper::spacingValue($infoPadding->{$deviceKey}, "padding"), $device);
        }
    }
}
$infoContainerStyle->addCss('padding', 0);
$infoContainerAfterStyle->addCss('background', 'linear-gradient(45deg,' . $element->params->get('infoBackgroundColor', 'rgba(255,255,255,1)') . ' 50%,rgba(255,255,255,0) 51%,rgba(255,255,255,0) 100%)');
$infoContainerStyle->addCss('background-color', $element->params->get('infoBackgroundColor', ''));
JDPageBuilder\Helper::applyBorderValue($infoContainerStyle, $element->params, "infoBorder");

$infoSpaceBetween = $element->params->get('infoSpaceBetween', null);
if (!empty($height)) {
    foreach (\JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($infoSpaceBetween->{$deviceKey}) && \JDPageBuilder\Helper::checkSliderValue($infoSpaceBetween->{$deviceKey})) {
            $titleStyle->addCss('margin-bottom', $infoSpaceBetween->{$deviceKey}->value . 'px', $device);
        }
    }
}

$titleStyle->addCss('color', $element->params->get('infoTitleColor', ''));

$typography = $element->params->get("infoTitleTypography", NULL);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $titleStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$descStyle->addCss('color', $element->params->get('infoDescriptionColor', ''));

$typography = $element->params->get("infoDescriptionTypography", NULL);
if (!empty($typography)) {
    foreach (JDPageBuilder\Helper::$devices as $deviceKey => $device) {
        if (isset($typography->{$deviceKey}) && !empty($typography->{$deviceKey})) {
            $descStyle->addStyle(JDPageBuilder\Helper::typographyValue($typography->{$deviceKey}), $device);
        }
    }
}

$descStyle->addCss('margin-bottom', '0px');


$funcPostfix = 'JDGmap' . JDPageBuilder\Helper::classify($element->id);
$mapTheme = $element->params->get('mapTheme', '');
$mapType = $element->params->get('mapType', 'roadmap');
$customTheme = $element->params->get('customTheme', '');
if ($mapType == 'satellite') {
    $mapTheme = '[]';
} else if (empty($mapTheme)) {
    $mapTheme = '[]';
} else if ($mapTheme !== 'custom') {
    $mapTheme = JDBuilderGoogleMapsElementHelper::THEMES[$mapTheme];
} elseif ($mapTheme == 'custom' && !empty($customTheme)) {
    $mapTheme = $customTheme;
} else {
    $mapTheme = '[]';
}
?>
<script>
    function media<?php echo $funcPostfix; ?>(e) {
        if (null == e || "" === e) return "";
        let s = "";
        switch (e.substr(0, 4)) {
            case "link":
                s = e.substr(5);
                break;
            default:
                s = "<?php echo \JURI::root(); ?>images/" + e
        }
        return s
    }

    var map<?php echo $funcPostfix; ?>, geocoder<?php echo $funcPostfix; ?>, bounds<?php echo $funcPostfix; ?>, markers<?php echo $funcPostfix; ?> = new Map(),
        infowindows<?php echo $funcPostfix; ?> = new Map();

    function init<?php echo $funcPostfix; ?>() {
        var mapZoom = <?php echo \json_encode($element->params->get('mapZoom', \json_decode('{value: 7}', false))); ?>;
        map<?php echo $funcPostfix; ?> = new google.maps.Map(document.getElementById('jdb-gmap-<?php echo $element->id; ?>'), {
            mapTypeId: '<?php echo $element->params->get('mapType', 'roadmap'); ?>',
            styles: <?php echo \json_encode(\json_decode($mapTheme)); ?>,
            zoom: mapZoom.value,
            scrollwheel: <?php echo $element->params->get('scrollwheel', true) ? 'true' : 'false'; ?>,
            zoomControl: <?php echo $element->params->get('zoomControl', true) ? 'true' : 'false'; ?>,
            mapTypeControl: <?php echo $element->params->get('mapTypeControl', true) ? 'true' : 'false'; ?>,
            scaleControl: false,
            streetViewControl: <?php echo $element->params->get('streetViewControl', true) ? 'true' : 'false'; ?>,
            rotateControl: false,
            fullscreenControl: <?php echo $element->params->get('fullscreenControl', true) ? 'true' : 'false'; ?>
        });
        geocoder<?php echo $funcPostfix; ?> = new google.maps.Geocoder;
        bounds<?php echo $funcPostfix; ?> = new google.maps.LatLngBounds();
        addPlaces<?php echo $funcPostfix; ?>();
    }

    function validLatLng<?php echo $funcPostfix; ?>(item) {
        return ('lat' in item && 'lng' in item && item.lat !== '' && item.lat !== false && item.lat !== null && item.lat !== undefined && item.lat.length !== 0 && item.lng !== '' && item.lng !== false && item.lng !== null && item.lng !== undefined && item.lng.length !== 0);
    }

    function addPlaces<?php echo $funcPostfix; ?>() {
        var locations = <?php echo \json_encode($element->params->get('locations', [])); ?>;
        var animation = '<?php echo $element->params->get('markerAnimation', ''); ?>';
        var mapZoom = <?php echo \json_encode($element->params->get('mapZoom', \json_decode('{value: 7}', false))); ?>;
        locations.forEach(function(item) {
            if (validLatLng<?php echo $funcPostfix; ?>(item)) {
                map<?php echo $funcPostfix; ?>.setCenter({
                    lat: Number(item.lat),
                    lng: Number(item.lng)
                });

                var markerObj = {
                    map: map<?php echo $funcPostfix; ?>,
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
                        url: media<?php echo $funcPostfix; ?>(item.customMarker),
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

                marker.addListener('click', function() {
                    if (infowindow.content != '') {
                        infowindows<?php echo $funcPostfix; ?>.forEach(function(iw, iwl) {
                            if (iwl != _locId) {
                                iw.close();
                            }
                        });
                        infowindow.open(map<?php echo $funcPostfix; ?>, marker);
                    }
                });

                markers<?php echo $funcPostfix; ?>.set(_locId, marker);
                infowindows<?php echo $funcPostfix; ?>.set(_locId, infowindow);

                var loc = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
                bounds<?php echo $funcPostfix; ?>.extend(loc);
                setTimeout(function() {
                    map<?php echo $funcPostfix; ?>.fitBounds(bounds<?php echo $funcPostfix; ?>);
                    map<?php echo $funcPostfix; ?>.panToBounds(bounds<?php echo $funcPostfix; ?>);
                });
            }
        });
        setTimeout(function() {
            if (Number.isInteger(mapZoom.value)) {
                setTimeout(function() {
                    map<?php echo $funcPostfix; ?>.setZoom(mapZoom.value);
                });
            }
        }, 200);
        updateInfowindows<?php echo $funcPostfix; ?>(locations);
    }

    updateInfowindows<?php echo $funcPostfix; ?> = function(locations) {
        locations.forEach(function(item) {
            if (validLatLng<?php echo $funcPostfix; ?>(item)) {
                var _locId = item.lat + '-' + item.lng;
                var infowindow = infowindows<?php echo $funcPostfix; ?>.get(_locId);
                var marker = markers<?php echo $funcPostfix; ?>.get(_locId);
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
                        infowindow.open(map<?php echo $funcPostfix; ?>, marker);
                    }
                } else {
                    infowindow.setContent('');
                    infowindow.close();
                }
            }
        });
    }
</script>
<?php
\JDPageBuilder\Builder::loadGoogleMap('init' . $funcPostfix);
?>