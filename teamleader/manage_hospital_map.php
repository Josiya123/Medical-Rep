<?php
include_once('security_check_teamleader.php');
include_once("database.php");
if(!empty($_GET['hp_id'])){
    $select="SELECT `hp_id`, `tl_id`, `hp_name`, `hp_code`, `hp_address`, `hp_emailid`, `hp_mobilenumber`, 
    `hp_weburl`, `hp_landline`, `hp_lat`, `hp_lon`, `hp_type` FROM hospitals   where hp_id=".$_GET['hp_id'];
    $data=database::SelectData($select);
    $hospitaldetails=mysqli_fetch_array($data);
}
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include_once('admin_title.php'); ?>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="../assets/css/normalize.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../assets/css/lib/datatable/dataTables.bootstrap.min.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="../assets/scss/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <script>
        // Note: This example requires that you consent to location sharing when
        // prompted by your browser. If you see the error "The Geolocation service
        // failed.", it means you probably did not give permission for the browser to
        // locate you.
        var map;
        var infoWindow;
        function initMap() {
            map = new google.maps.Map(document.getElementById('mapCanvas'), {
                    zoom: 9
            });
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                  
                    <?php 
                    $centerset=0;
                    $centerlat=0;
                    $centerlag=0;
             
                    $select="SELECT `tm_id`, `tl_id`, `tm_lat`, `tm_lng` FROM `teamleader_maparea`  where tl_id=".$_COOKIE['mr_urid']." order by tm_id";
                    $data=database::SelectData($select);
                    ?>

                    var blueCoords = [
                    <?php 
                    $i=0;
                     while($rows=mysqli_fetch_array($data)) {
                        if($centerset==0){
                            $centerlat=$rows['tm_lat'];
                            $centerlag=$rows['tm_lng'];
                            $centerset=1;
                         }
                    $i++;
                    ?>
                    new google.maps.LatLng(<?php echo $rows['tm_lat']; ?>,<?php echo $rows['tm_lng']; ?>)
                    <?php
                    if($i<mysqli_num_rows($data)){
                        echo ",";
                    }
                    }
                    ?>
                    ];
                    // Construct a draggable blue triangle with geodesic set to false.
                    myPolygon =new google.maps.Polygon({
                    map: map,
                    paths: blueCoords,
                    strokeColor: '#0000FF',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#0000FF',
                    fillOpacity: 0.35,
                    draggable: false,
                    editable:false,
                    geodesic: false
                    });
                    myPolygon.setMap(map);
                    <?php
                   
                    if($centerset==1){
                    ?>
                    var pos = {
                    lat:  <?php echo $centerlat; ?>,
                    lng: <?php echo $centerlag; ?>
                    };
                    <?php
                    }
                    else{
                    ?>
                     var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                    };
                    <?php
                    }
                    
                    ?>
                    map.setCenter(pos);
                    // Add a listener for the click event.
                    myPolygon.addListener('click', showArrays);

                    infoWindow = new google.maps.InfoWindow;
         
                });
            }else{
            // Browser doesn't support Geolocation
            handleLocationError(false, map.getCenter());
            }
            setMarkers(map);
        }
        function handleLocationError(browserHasGeolocation, pos) {
            alert("map error");
        }
        /** @this {google.maps.Polygon} */
      function showArrays(event) {

        contentString="<div class='card' style='width:250px;'>"+
                            "<form action='sqlprocess/hospital_map_sql_process.php' method='post' autocomplete='off' >"+
                                "<div class='card-header'>"+
                                    "<strong class='card-title'><?php echo $hospitaldetails['hp_name']; ?></strong>"+
                                "</div>"+
                                "<div class='card-body'>"+
                                    "<div class='form-group'>"+
                                        "<label for='hospital_location' class='control-label mb-1'>Hospital Location</label>"+
                                        "<input id='hospital_location' name='hospital_location' type='text' value='"+event.latLng.lat() + ',' + event.latLng.lng()+"'  class='form-control' readonly required/>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='card-footer'>"+
                                    "<input name='hp_id' type='hidden' value='<?php echo $hospitaldetails['hp_id']; ?>'  class='form-control' readonly required/>"+
                                    "<button id='btn_save' type='submit' class='btn btn-md btn-info btn-block'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Save Hospital Location</button>"+
                                "</div>"+
                            "</form>"+
                       "</div>"; 


        // Replace the info window's content and position.
        infoWindow.setContent(contentString);
        infoWindow.setPosition(event.latLng);

        infoWindow.open(map);
      }

      var hosclinic = [
	
        ['<?php echo $hospitaldetails['hp_name'];?>',
         <?php echo $hospitaldetails['hp_lat'];?>,
          <?php echo $hospitaldetails['hp_lon'];?>, 
          1, 
          '<?php echo $hospitaldetails['hp_type'];?>',
          '<?php echo $hospitaldetails['hp_id'];?>'
          ]
        ];
    function setMarkers(map) {
        var hospital = {
			url: '../images/hospital.png',
			size: new google.maps.Size(20, 20),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(0, 20)
        };
        var clinic = {
			url: '../images/clinic-1.png',
			size: new google.maps.Size(20, 20),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(0, 20)
        };
       
		var infowindow1="";
		var shape = {
          coords: [1, 1, 1, 20, 18, 20, 18, 1],
          type: 'poly'
        };
        for (var i = 0; i < hosclinic.length; i++) {
			var row = hosclinic[i];
			var image=hospital;
            if(row[4]=='CLINIC'){
				image=clinic;
			
            }
            var marker = new google.maps.Marker({
            position: {lat: row[1], lng: row[2]},
            map: map,
            icon: image,
            shape: shape,
            title: row[0],
            zIndex: row[3]
          });
          
        
        }
    }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3VCgt8XUKoDJMDvo6DIEiufGAtE1y6Ps&callback=initMap">
    </script>
    <style>
        #mapCanvas {
            width:auto;
            height: 100%;
        }
    </style>
</head>
<body>
    <?php
    $currentmenu="hospitals";
     include_once('left_nav.php');
    ?>
    <div id="right-panel" class="right-panel">
        <?php include_once('top_header.php'); ?>   
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                     <div class="col-md-12 ">
                        
                        <div class="card">
                            <div class="card-header" style="height:60px;padding-left:0;padding-right:0;">
                               
                                <div class="col-9">
                                    <strong class="card-title"><?php echo $hospitaldetails['hp_name']; ?></strong>
                                </div>
                                
                                <div class="col-3">
                                    <a href="list_hospitals.php" class="btn btn-sm btn-outline-secondary pull-right" style='margin-left:10px;height:40px;padding:auto;padding-top:10px;'>&nbsp;<i class="fa fa-chevron-left"></i>&nbsp;</a>
                                </div>
                            </div>
                            <div class="card-body" style="height:650px;">
                                <div id="mapCanvas" style="height:100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/main.js"></script>


</body>
</html>
