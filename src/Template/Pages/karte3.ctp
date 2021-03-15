<link rel="stylesheet" type="text/css" href="leaflet/leaflet.css" />
    <!--[if lte IE 8]>
        <link rel="stylesheet" type="text/css" href="css/leaflet.ie.css" />
    <![endif]-->
    <script src="leaflet/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <script src="hydro_s.geojson" type="text/javascript"></script>
    <script src="hydro_l.geojson" type="text/javascript"></script>
    <style>
        html, body, #map {
            height: 100%;
        }
        body {
            padding: 0;
            margin: 0;
        }
    </style>
    <title>Leaflet Map with GeoJson</title>
 </head>


<body>
    <div id="map"></div>
    <script type="text/javascript">

        var map = L.map('map', {
            center: [45.57, -73.5648],
            zoom: 10
        });

         /* Hydro */
        var hydro = new L.LayerGroup();
        L.geoJson(hydro_s, {style: hydrosStyle}).addTo(hydro);
        L.geoJson(hydro_l, {style: hydrolStyle}).addTo(hydro);

    </script>
</body>