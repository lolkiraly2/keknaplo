<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <title>proba</title>
</head>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-gpx/2.0.0/gpx.min.js"></script>


<body>
    <div id="terkep">
        <div id="map"></div>
    </div>

</body>


<style>
    #map {
        height: 500px;
    }

    #terkep {
        width: 800px;
        height: 800px;
    }
</style>
<script>
    var map = L.map('map').setView([46.3578, 17.7812], 11);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        crossOrigin: null,
    }).addTo(map);

    var url = 'gpx/rpddk_teljes.gpx'; // URL to your GPX file or the GPX itself
    // new L.GPX(url, {
    //     async: true
    // }).on('loaded', function(e) {
    //     map.fitBounds(e.target.getBounds());
    // }).addTo(map);

    new L.GPX(url, {
        polyline_options: [{
            color: 'green',
            opacity: 0.75,
            weight: 3,
            lineCap: 'round'
        }, {
            color: 'blue',
            opacity: 0.75,
            weight: 1
        }]
    }).on('loaded', function(e) {
        var gpx = e.target;
        map.fitToBounds(gpx.getBounds());
    }).addTo(map);
</script>

</html>