<script>
var map;

// Correct Medivesta coordinates
var myLat = 6.835137;
var myLng = 79.999512;

// Custom marker (remove if not using)
var myMarkerx = "images/cd-icon-location.png";

// Map styling
var main_color = '#000000',
    saturation_value = -80,
    brightness_value = 5;

var style = [
    {
        elementType: "labels",
        stylers: [{ saturation: saturation_value }]
    },
    {
        featureType: "poi",
        elementType: "labels",
        stylers: [{ visibility: "off" }]
    },
    {
        featureType: 'road.highway',
        elementType: 'labels',
        stylers: [{ visibility: "off" }]
    },
    {
        featureType: "road.local",
        elementType: "labels.icon",
        stylers: [{ visibility: "off" }]
    },
    {
        featureType: "road.arterial",
        elementType: "labels.icon",
        stylers: [{ visibility: "off" }]
    },
    {
        featureType: "road",
        elementType: "geometry.stroke",
        stylers: [{ visibility: "off" }]
    },
    {
        featureType: "transit",
        elementType: "geometry.fill",
        stylers: [
            { hue: main_color },
            { visibility: "on" },
            { lightness: brightness_value },
            { saturation: saturation_value }
        ]
    },
    {
        featureType: "landscape",
        stylers: [
            { hue: main_color },
            { visibility: "on" },
            { lightness: brightness_value },
            { saturation: saturation_value }
        ]
    },
    {
        featureType: "road",
        elementType: "geometry.fill",
        stylers: [
            { hue: main_color },
            { visibility: "on" },
            { lightness: brightness_value },
            { saturation: saturation_value }
        ]
    },
    {
        featureType: "water",
        elementType: "geometry",
        stylers: [
            { hue: main_color },
            { visibility: "on" },
            { lightness: brightness_value },
            { saturation: saturation_value }
        ]
    }
];

function CustomZoomControl(controlDiv, map) {
    var controlUIzoomIn = document.getElementById('cd-zoom-in');
    var controlUIzoomOut = document.getElementById('cd-zoom-out');

    controlDiv.appendChild(controlUIzoomIn);
    controlDiv.appendChild(controlUIzoomOut);

    google.maps.event.addDomListener(controlUIzoomIn, 'click', function () {
        map.setZoom(map.getZoom() + 1);
    });

    google.maps.event.addDomListener(controlUIzoomOut, 'click', function () {
        map.setZoom(map.getZoom() - 1);
    });
}

function initMap() {
    var map_options = {
        center: new google.maps.LatLng(myLat, myLng),
        zoom: 14,
        panControl: false,
        zoomControl: false,
        mapTypeControl: false,
        streetViewControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false,
        styles: style
    };

    map = new google.maps.Map(document.getElementById('maps'), map_options);

    // Add custom marker
    new google.maps.Marker({
        position: new google.maps.LatLng(myLat, myLng),
        map: map,
        visible: true,
        icon: myMarkerx
    });

    // Add custom zoom buttons
    var zoomControlDiv = document.createElement('div');
    new CustomZoomControl(zoomControlDiv, map);
    map.controls[google.maps.ControlPosition.LEFT_TOP].push(zoomControlDiv);
}
</script>
