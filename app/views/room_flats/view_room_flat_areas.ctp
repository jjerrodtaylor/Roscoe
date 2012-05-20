<div id="map" style="height:356px;width:242px; border:0px;margin:0px;padding:0px;"></div>
<?php e($javascript->link(array('jquery/jquery'))); ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		var street_address 	= "<?php e($roomFlatAreas['RoomFlat']['street_address']); ?>";
		var city_name 		= "<?php e($roomFlatAreas['RoomFlat']['city_name']); ?>";
		var zipcode 		= "<?php e($roomFlatAreas['RoomFlat']['zipcode']); ?>";
		var country_code 	= "<?php e($roomFlatAreas['Country']['iso_code']); ?>";
		var state_name 		= "<?php e($roomFlatAreas['State']['name']); ?>";
		
		var userLocation= street_address+','+city_name+','+state_name+','+country_code;
			initialize(userLocation);
			function initialize(userLocation) {
				 if(userLocation!=""){
					var Location = userLocation;
				 }
				
				 var geocoder = new google.maps.Geocoder();
				 geocoder.geocode( {'address': Location}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						var lat = results[0].geometry.location.lat();
							var lng = results[0].geometry.location.lng();
							
						var myOptions = {
						  center: new google.maps.LatLng(lat, lng),
						  zoom: 5,
						  mapTypeId: google.maps.MapTypeId.ROADMAP
						};
						var map = new google.maps.Map(document.getElementById("map"),myOptions);
						var marker = new google.maps.Marker({
							position: new google.maps.LatLng(lat, lng),
							title:Location
						});
						marker.setMap(map);
					} 
				});
		}
	});
</script>
<?
	/* $address = $roomFlatAreas['RoomFlat']['street_address'].", ";
	$address .= $roomFlatAreas['RoomFlat']['city_name'].", ";
	$address .= $roomFlatAreas['RoomFlat']['zipcode'].", ";
	$address .= $roomFlatAreas['Country']['iso_code'].", ";
	$address .= $roomFlatAreas['State']['name'];


	<div class="Map5Img" id="Map5Img">
	<?php $longdesc="http://maps.googleapis.com/maps/api/staticmap?size=356x242&zoom=5&scale=2&maptype=roadmap&markers=size:mid|color:red|".$address."&sensor=false"; ?>
	<a rel="facebox" href="#mapStreet">
	<img class="lazy" border="0" width="242" height="356" src="<?php echo $longdesc; ?>">
	</a>
	</div>
	 */
?> 