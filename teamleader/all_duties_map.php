<script type="text/javascript">
	function initialize() {
		function displayCurrentPosition(data){
		  var latLng = new google.maps.LatLng(data.coords.latitude,data.coords.longitude);
		  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
			zoom: 6,
			center: latLng,
			mapTypeId: google.maps.MapTypeId.ROADMAP   
		  });
		setMarkers(map);
		
		}
		function onError(error)	{
			switch(error.code) {
				case error.PERMISSION_DENIED:
					element.text('Access to location API denied by user');
					break;
				case error.POSITION_UNAVAILABLE:
					element.text('Unable to determine location');
					break;
				case error.TIMEOUT:
					element.text('Unable to determine location, the request timed out');
					break;
				case error.UNKNOWN_ERROR:
					element.text('An unknown error occurred!');
					break;
			}
		}
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(displayCurrentPosition,onError);
		} else {
			x.innerHTML = "Geolocation is not supported by this browser.";
		}
	}
    var crimes = [
		<?php 
		$i=0;
		$totalcrimes=mysqli_num_rows($crimes);
		while($rows=mysqli_fetch_array($crimes)){
			$i++;
		?>
        ['<?php echo $rows['cr_title'];?>', <?php echo $rows['cr_lat'];?>, <?php echo $rows['cr_lon'];?>, <?php echo $i;?>, <?php echo $rows['ci_id'];?>]
		<?php if($i<$totalcrimes){ echo ",";}?>
		<?php 
		}
		?>
    ];
    function setMarkers(map) {
        var high = {
			url: '../images/high.png',
			size: new google.maps.Size(20, 20),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(0, 20)
        };
		var medium = {
			url: '../images/medium.png',
			size: new google.maps.Size(20, 20),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(0, 20)
        };
		var low = {
			url: '../images/low.png',
			size: new google.maps.Size(20, 20),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(0, 20)
        };
		var shape = {
          coords: [1, 1, 1, 20, 18, 20, 18, 1],
          type: 'poly'
        };
        for (var i = 0; i < crimes.length; i++) {
			var crime = crimes[i];
			var image=high;
			if(crime[4]==28){
				image=high;
			}
			else if(crime[4]==29){
				image=medium;
			}
			else{
				image=low;
			}
			var marker = new google.maps.Marker({
            position: {lat: crime[1], lng: crime[2]},
            map: map,
            icon: image,
            shape: shape,
            title: crime[0],
            zIndex: crime[3]
          });
        }
    }
	// Onload handler to fire off the app.
	google.maps.event.addDomListener(window, 'load', initialize);
</script>