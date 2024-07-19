<?php
include_once('security_check_teamleader.php');
include_once("database.php");
    $select="SELECT `hp_id`, `tl_id`, `hp_name`, `hp_code`, `hp_address`, `hp_emailid`, `hp_mobilenumber`, 
    `hp_weburl`, `hp_landline`, `hp_lat`, `hp_lon`, `hp_type` FROM hospitals   where tl_id=".$_COOKIE['mr_urid'];
    $hospitals=database::SelectData($select);
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
      
      var hosclinics= [
        <?php 
		$i=0;
		$total=mysqli_num_rows($hospitals);
		while($rows=mysqli_fetch_array($hospitals)){
		$i++;
		?>
	
        ['<?php echo $rows['hp_name'];?>',
         <?php echo $rows['hp_lat'];?>,
          <?php echo $rows['hp_lon'];?>, 
          <?php echo $i;?>, 
          '<?php echo $rows['hp_type'];?>',
          '<?php echo $rows['hp_id'];?>',
          '<?php echo $rows['hp_code'];?>',
          '<?php echo $rows['hp_address'];?>',
          '<?php echo $rows['hp_emailid'];?>',
          '<?php echo $rows['hp_mobilenumber'];?>',
          '<?php echo $rows['hp_weburl'];?>',
          '<?php echo $rows['hp_landline'];?>'
          ]
          <?php if($i<$total){ echo ",";}?>
		<?php 
		}
		?>
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
      
        for (var i = 0; i < hosclinics.length; i++) {
			var row = hosclinics[i];
			var image=hospital;
            if(row[4]=='CLINIC'){
				image=clinic;
			}
            var infoWindow1 = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
            position: {lat: row[1], lng: row[2]},
            map: map,
            icon: image,
            shape: shape,
            title: row[0],
            zIndex: row[3]
          });
          (function (marker, row) {
                google.maps.event.addListener(marker, "click", function (e) {
                    var contentString="<div class='card' style='width:250px;'>"+
                                "<div class='card-header'><h3>"+row[0]+
                                "</h3></div>"+
                                "<div class='card-body'>"+
                                    "<div class='list-group'>"+
                                        "<a class='list-group-item list-group-item-action'>Type <span>"+row[4]+"</span></a>"+
                                        "<a class='list-group-item list-group-item-action'>Code <span>"+row[6]+"</span></a>"+
                                        "<a class='list-group-item list-group-item-action'>Address <span>"+row[7]+"</span></a>"+
                                        "<a class='list-group-item list-group-item-action'>Email ID <span>"+row[8]+"</span></a>"+
                                        "<a class='list-group-item list-group-item-action'>Mobile Number <span>"+row[9]+"</span></a>"+
                                        "<a class='list-group-item list-group-item-action' target='_blank' href="+row[10]+" >Website <span>"+row[10]+"</span></a>"+
                                        "<a class='list-group-item list-group-item-action'>Land Phone <span>"+row[11]+"</span></a>"+
                                    "</div>"+  
                                "</div>"+
                            "</div>"; 
                    infoWindow1.setContent(contentString);
                    infoWindow1.open(map, marker);
                });
            
            })(marker, row);
          
        
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
                                    <strong class="card-title">All Hospotals and Clinics</strong>
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
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../assets/js/main.js"></script>
    
    <style>
    .list-group-item span{
        font-weight:bold;
        color:red;

    }
    </style>



</body>
</html>
