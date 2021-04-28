<?php
error_reporting(0);
$koordinat_all = $_GET['koordinat'];
$koordinat_all = str_replace(")","",$koordinat_all);
$koordinat_all = str_replace("(","",$koordinat_all);
$koordinat_all = str_replace(" ","",$koordinat_all);

$koordinat_all_explode = explode(",",$koordinat_all);

$i=0;
foreach ($koordinat_all_explode as $value1) {
	$i++;
	if($i%2==0){
		$koordinat_y_arr[] = $value1;
	}else{
		$koordinat_x_arr[] = $value1;
	}
}

//$koordinat_x = array(2.554583014155121, 2.5610996473341987,2.5568981376286746,2.5448937484495056,2.5430073342586277, 2.5483235853591855, 2.550295737445332);
$koordinat_x = $koordinat_x_arr;

//$koordinat_y = array(98.31793349204054, 98.32454245505323, 98.33518546042433, 98.32728903708448, 98.32153838095655, 98.31922095236769, 98.3173326772212);
$koordinat_y = $koordinat_y_arr;

$points_polygon = count($koordinat_x) - 1;  // number koordinat - zero-based array

$mix = array_combine($koordinat_x,$koordinat_y);
//echo json_encode($mix);
$jav = "[";
foreach ($mix as $key => $value) {
//echo $key;
	$jav .= "{lat:".$key.", lng:".$value."},";
}
$jav.="]";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Drawing Tools</title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<meta charset="utf-8">
	<style>
/* Always set the map height explicitly to define the size of the div
* element that contains the map. */
#map {
	height: 80%;
}
/* Optional: Makes the sample page fill the window. */
html, body {
	height: 100%;
	margin: 0;
	padding: 0;
}
</style>

</head>
<body>
	<div id="map"></div>
	<input type="text" name="koordinat" value="" id="koordinat"  style="width: 100%" />
	<button id="hapus">Hapus</button>
	<button onclick="javascript:dd()">Ambil koordinat</button>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script>
// This example requires the Drawing library. Include the libraries=drawing
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=drawing">
var all_overlays = [];


function initMap() {
	var map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: 2.5407779321132535, lng: 98.31763308463087},

		zoom: 14
	});

	var drawingManager = new google.maps.drawing.DrawingManager({
		drawingMode: google.maps.drawing.OverlayType.POLYGON,
		drawingControl: true,
		drawingControlOptions: {
			position: google.maps.ControlPosition.TOP_CENTER,
//drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle']
drawingModes: ['polygon']
},
markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
circleOptions: {
	fillColor: '#ffff00',
	fillOpacity: 1,
	strokeWeight: 5,
	clickable: false,
	editable: true,
	zIndex: 1
}
});

	drawingManager.setMap(map);


	google.maps.event.addListener(drawingManager, "overlaycomplete", function(event){
		all_overlays.push(event);
		overlayClickListener(event.overlay);
		$('#koordinat').val(event.overlay.getPath().getArray());

	});
/*
google.maps.event.addListener(drawingManager, 'click', function() {
this.setMap(null);
});
*/

/*

var triangleCoords = [
{lat: 2.554583014155121, lng: 98.31793349204054},
{lat: 2.5610996473341987, lng:  98.32454245505323},
{lat: 2.5568981376286746, lng: 98.33518546042433}
];
*/

var triangleCoords = <?php echo ($jav)?>;


// Construct the polygon.
var bermudaTriangle = new google.maps.Polygon({
	paths: triangleCoords,
	strokeColor: '#FF0000',
	strokeOpacity: 0.8,
	strokeWeight: 3,
	fillColor: '#FF0000',
	fillOpacity: 0.35
});
bermudaTriangle.setMap(map);




}


function deleteAllShape() {
	for (var i = 0; i < all_overlays.length; i++) {
		all_overlays[i].overlay.setMap(null);
	}
	all_overlays = [];
}


function overlayClickListener(overlay) {
	google.maps.event.addListener(overlay, "mouseup", function(event){
		$('#koordinat').val(overlay.getPath().getArray());
	});        
}

$("#hapus").on("click",function(){
//drawingManager.setMap(null);
deleteAllShape();
$('#koordinat').val('');
})
function dd(){
		window.opener.refreshFromPopup($("#koordinat").val());
		window.close();
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDq5_6tgSUmi7ukDbpAnTbQ2_ungfOEs2I&libraries=drawing&callback=initMap"
async defer></script>

</body>
</html>




