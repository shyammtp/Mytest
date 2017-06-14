<?php defined('SYSPATH') OR die('No direct script access.');
$value = $this->_getValue(); 
?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&key=<?php echo App::getConfig('GOOGLE_MAP_APIKEY',Model_Core_Place::ADMIN);?>"></script>
<div class="col-sm-12">
    <div style="position:relative;"> 	
        <div id="mapCanvas" style=" width: 100%; height:500px;"></div>
        <!--Map Lat&Long-->
        <input type="hidden" id="latitude" name="<?php echo $this->getName();?>[latitude]" value="<?php echo Arr::get($value,'latitude');?>" />
        <input type="hidden" id="longitude" name="<?php echo $this->getName();?>[longitude]" value="<?php echo Arr::get($value,'latitude');?>" /> 
    </div>
</div>
<script>
    
var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function updateMarkerStatus(str) {
  //document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) {
    $("#latitude").val(latLng.lat());
    $("#longitude").val(latLng.lng()); 
}

function updateMarkerAddress(str) {
  document.getElementById('address').innerHTML = str;
}

function initialize() {
  var latLng = new google.maps.LatLng(<?php echo Arr::get($value,'latitude',31.0770538);?>, <?php echo Arr::get($value,'longitude',36.2038197);?>);
  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 14,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  var marker = new google.maps.Marker({
    position: latLng,
    title: 'Point A',
    map: map,
    draggable: true
  });
  
  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);
  
  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });
  
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Drag ended');
    geocodePosition(marker.getPosition());
  });
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);
</script>