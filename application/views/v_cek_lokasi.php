<?php

$data1 = $this->m_lokasi->m_cek_lokasi($nip);
$koordinat_all = $data1[0]->koordinat;
    //print_r($koordinat_all);

$koordinat_all_explode = explode("),(",$koordinat_all);
foreach ($koordinat_all_explode as $value1) {
  $value1 = str_replace(", "," ",$value1);
  $value1 = str_replace("(","",$value1);
  $value1 = str_replace(")","",$value1);
  $polygon[] = $value1;
}

$point = $lat_x." ".$lng_y;

//$points = array("2.48847736495573 98.1529683642402");
//$polygon = array("2.4887443888424206 98.1529535715823","2.48847374122775 98.15270814945744","2.4882097927579387 98.1530246501212","2.488497858344176 98.15326202561901","2.4887443888424206 98.1529535715823");
//print_r($point);
//print_r($polygon);

$this->load->library('PointLocation');
$pointLocation = new PointLocation();

$cek = $pointLocation->pointInPolygon($point, $polygon);

if($cek=='inside'){
  $warning = "Selamat!!! Lokasi anda tepat, Silahkan lanjutkan.";
  $zoom = 17;
}else if($cek=='outside'){
  $warning = "Warning!!! anda diluar lokasi!!!";
  $zoom = 17;
}else{
  $warning = "longitude_x dan latitude_y harus isset";
  $zoom = 17;
}

$mix = array_combine($vertices_x,$vertices_y);
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
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title><?php echo config_item('app_client1'); ?> | <?php echo config_item('app_client2'); ?></title>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  
  <style>
      /* Always set the map height explicitly to define the size of the div
      * element that contains the map. */
      #map {
        height: 100%;
        min-height:400px;
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
    
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>
      // This example requires the Drawing library. Include the libraries=drawing
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=drawing">
      var all_overlays = [];

      var myLatLng = {lat: <?php echo $lat_x?>, lng: <?php echo $lng_y?>};
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          //center: {lat: 2.5407779321132535, lng: 98.31763308463087},
          center : myLatLng,
          zoom: <?php echo $zoom?>
        });

        
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
        

        
        var contentString = '<?php echo $warning?>';

        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Lokasi Anda'
        });
        marker.setMap(map);
        infowindow.open(map, marker);



        var p1 = new google.maps.LatLng(<?php echo $lat_x?>, <?php echo $lng_y?>);
        var p2 = new google.maps.LatLng(<?php echo @$vertices_x[0]?>, <?php echo @$vertices_y[0]?>);
        console.log(meter(p1,p2));

      }


      function meter(p1, p2) {
        //return (google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);
        return (google.maps.geometry.spherical.computeDistanceBetween(p1, p2)).toFixed(2)+" m";
      }



      //alert("<?php echo $warning?>");

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDq5_6tgSUmi7ukDbpAnTbQ2_ungfOEs2I&libraries=drawing&callback=initMap&libraries=geometry"
    async defer></script>

  </body>
  </html>




