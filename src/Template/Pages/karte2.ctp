<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   
 <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   
<script src="http://localhost/dwe_map/orte/umap_json" type="text/javascript"></script>


<div id="map" style="height:800px;" ></div>   

<script>

var map = L.map('map').setView([52.520008, 13.404954], 11);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);


function onEachFeature(feature, layer) {
	content = "<h4>"+feature.properties.name+"</h4><br>"+feature.properties.description;
	layer.bindPopup(content);
	console.log(layer);
}

function loadLayer(json_url, marker_icon = '../img/marker.svg'){
    let xhr = new XMLHttpRequest();
    xhr.open('GET', json_url);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.responseType = 'json';
    xhr.onload = function() {
        if (xhr.status !== 200) return
        L.geoJSON(xhr.response, {
            //onEachFeature: onEachFeature,
            pointToLayer: function(feature, latlng){
    
            	var smallIcon = new L.Icon({
            	     iconSize: [30, 30],
            	     iconAnchor: [13, 27],
            	     popupAnchor:  [1, -24],
            	     iconUrl: marker_icon
            	 });
    
            	return L.marker(latlng, {icon: smallIcon});        
            }
        }).addTo(map);
    };
    xhr.send();
}
loadLayer('http://localhost/dwe_map/orte/index_json', '../img/marker.svg');
loadLayer('https://dwenteignen.party/service/action-export', '../img/marker_yellow.svg');



</script>

