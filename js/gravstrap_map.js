function initMap(id, mapOptions, markers) {
    var mapDiv = document.getElementById(id);
    var map = new google.maps.Map(mapDiv, mapOptions);

    for (var i = 0; i < markers.length; i++) {
        var markerOptions = markers[i];
        markerOptions.map = map;
        markerOptions.animation = google.maps.Animation.DROP;
        var marker = new google.maps.Marker(markerOptions);

        if (markerOptions.hasOwnProperty('info')) {
            var infowindow = new google.maps.InfoWindow({
                content: markerOptions.info
            });
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
        }
    }
}