<div class="fixed_outer">
    <div class="fixed_inner">	
	<div class="full_white_box">
	    <div class="login_title">
		<h2> Anges</h2>		 
	    </div>
			<div id="map" style=" width: 100%; height:400px;"></div> 
	</div>
    </div>
</div>

<?php
$_city = $this->getCity();
$_sitelocation = App::getConfig('GOOGLE_LATLONG',Model_Core_Place::ADMIN); 
$_siteaddress = App::getConfig('SITE_CONTACT_ADDRESS',Model_Core_Place::ADMIN);
?> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry,places&ext=.js "></script>
<script>



var map = null;

function initMap() {
  var myOptions = {
    zoom: 15,
    center: new google.maps.LatLng(43, -79.5),
    mapTypeControl: true,
    mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
    },
    navigationControl: true,
    mapTypeId: google.maps.MapTypeId.SATELLITE
  }
  map = new google.maps.Map(document.getElementById("map"),
    myOptions);

 
  var point = new google.maps.LatLng(-21.2357709, -159.8123872);
  map.setCenter(point);
  var hex1 = google.maps.Polygon.RegularPoly(point, 461.5, 6, 0, "#000000", 1, 1, "#FF0000", 0.50);
  hex1.setMap(map);
  var d = 2 * 25000 * Math.cos(Math.PI / 6);
  
 


}
google.maps.event.addDomListener(window, 'load', initMap);


google.maps.Polygon.Shape = function(point, r1, r2, r3, r4, rotation, vertexCount, strokeColour, strokeWeight, Strokepacity, fillColour, fillOpacity, opts, tilt) {
  var rot = -rotation * Math.PI / 180;
  var points = [];
  var latConv = google.maps.geometry.spherical.computeDistanceBetween(point, new google.maps.LatLng(point.lat() + 0.1, point.lng())) * 10;
  var lngConv = google.maps.geometry.spherical.computeDistanceBetween(point, new google.maps.LatLng(point.lat(), point.lng() + 0.1)) * 10;
  var step = (360 / vertexCount) || 10;

  var flop = -1;
  if (tilt) {
    var I1 = 180 / vertexCount;
  } else {
    var I1 = 0;
  }
  for (var i = I1; i <= 360.001 + I1; i += step) {
    var r1a = flop ? r1 : r3;
    var r2a = flop ? r2 : r4;
    flop = -1 - flop;
    var y = r1a * Math.cos(i * Math.PI / 180);
    var x = r2a * Math.sin(i * Math.PI / 180);
    var lng = (x * Math.cos(rot) - y * Math.sin(rot)) / lngConv;
    var lat = (y * Math.cos(rot) + x * Math.sin(rot)) / latConv;

    points.push(new google.maps.LatLng(point.lat() + lat, point.lng() + lng));
  }
  return (new google.maps.Polygon({
    paths: points,
    strokeColor: strokeColour,
    strokeWeight: strokeWeight,
    strokeOpacity: Strokepacity,
    draggable: true,
    fillColor: fillColour,
    fillOpacity: fillOpacity
  }))
}

google.maps.Polygon.RegularPoly = function(point, radius, vertexCount, rotation, strokeColour, strokeWeight, Strokepacity, fillColour, fillOpacity, opts) {
  rotation = rotation || 0;
  var tilt = !(vertexCount & 1);
  return google.maps.Polygon.Shape(point, radius, radius, radius, radius, rotation, vertexCount, strokeColour, strokeWeight, Strokepacity, fillColour, fillOpacity, opts, tilt)
}

function EOffsetBearing(point, dist, bearing) {
  var latConv = google.maps.geometry.spherical.computeDistanceBetween(point, new google.maps.LatLng(point.lat() + 0.1, point.lng())) * 10;
  var lngConv = google.maps.geometry.spherical.computeDistanceBetween(point, new google.maps.LatLng(point.lat(), point.lng() + 0.1)) * 10;
  var lat = dist * Math.cos(bearing * Math.PI / 180) / latConv;
  var lng = dist * Math.sin(bearing * Math.PI / 180) / lngConv;
  return new google.maps.LatLng(point.lat() + lat, point.lng() + lng)
}

</script>	
