<?php
include_once('security_check_admin.php');
include_once("database.php");
if(!empty($_GET['tl_id'])){

 $select="SELECT `tl_id`,  `tl_firstname`, `tl_lastname` FROM `teamleader`  where tl_id=".$_GET['tl_id'];
 $data=database::SelectData($select);
 $row=mysqli_fetch_array($data);

 $select="SELECT `tm_id`, `tl_id`, `tm_lat`, `tm_lng` FROM `teamleader_maparea`  where tl_id=".$_GET['tl_id']." order by tm_id";
 $data=database::SelectData($select);
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
        function initMap() {
            map = new google.maps.Map(document.getElementById('mapCanvas'), {
                    zoom: 9
            });
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    /*
                    var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                    };
                    map.setCenter(pos);
                    */
                    var blueCoords = [
                    <?php 
                    $centerset=0;
                    $centerlat=0;
                    $centerlag=0;
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
                    if(mysqli_num_rows($data)==0){
                    ?>
                    new google.maps.LatLng(position.coords.latitude,position.coords.longitude),
                    new google.maps.LatLng(position.coords.latitude+.01,position.coords.longitude-.02),
                    new google.maps.LatLng(position.coords.latitude-.02, position.coords.longitude-.05)
                    <?php
                    }
                    ?>
                    ];
                    /*
                    var blueCoords = [
                    new google.maps.LatLng(position.coords.latitude,position.coords.longitude),
                    new google.maps.LatLng(position.coords.latitude+.01,position.coords.longitude-.02),
                    new google.maps.LatLng(position.coords.latitude-.02, position.coords.longitude-.05)
                    ];
                    */
                    // Construct a draggable blue triangle with geodesic set to false.
                    myPolygon =new google.maps.Polygon({
                    map: map,
                    paths: blueCoords,
                    strokeColor: '#0000FF',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#0000FF',
                    fillOpacity: 0.35,
                    draggable: true,
                    editable:true,
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
                    //google.maps.event.addListener(myPolygon, "dragend", getPolygonCoords);
                    google.maps.event.addListener(myPolygon.getPath(), "insert_at", getPolygonCoords);
                    //google.maps.event.addListener(myPolygon.getPath(), "remove_at", getPolygonCoords);
                    google.maps.event.addListener(myPolygon.getPath(), "set_at", getPolygonCoords);
                });
            }else{
            // Browser doesn't support Geolocation
            handleLocationError(false, map.getCenter());
            }
        }
        //Display Coordinates below map
        function getPolygonCoords() {
             var len = myPolygon.getPath().getLength();
            var htmlStr = "";
            for (var i = 0; i < len; i++) {
            htmlStr += myPolygon.getPath().getAt(i).toUrlValue(12) + "<>";
            //Use this one instead if you want to get rid of the wrap > new google.maps.LatLng(),
            //htmlStr += "" + myPolygon.getPath().getAt(i).toUrlValue(5);
            }
            document.getElementById('info').innerHTML = htmlStr;
        }
        function handleLocationError(browserHasGeolocation, pos) {
            alert("map error");
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
    $currentmenu="teamleaders";
     include_once('left_nav.php');
    ?>
    <div id="right-panel" class="right-panel">
        <?php include_once('top_header.php'); ?>   
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                     <div class="col-md-12">
                        <?php
                            if(!empty($_GET['msg'])&& $_GET['msg']=="saved" ){
                        ?>
                        <div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">
                            <span class="badge badge-pill badge-primary">Success</span>
                                Map Successfully Created
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                        }
                        ?> 
                        <div class="card">
                             <div class="card-header">
                                    <strong class="card-title"><?php echo $row['tl_firstname']; ?> <?php echo $row['tl_lastname']; ?>(Team Leader) Map</strong>
                                    <a href="list_teamleadrs.php" class="btn btn-sm btn-outline-primary pull-right"><i class="fa fa-group"></i>&nbsp; List Team Leaders</a>
                            </div>
                            <div class="card-body" style="height:500px;">
                                <div id="mapCanvas" style="height:100%;"></div>
                            </div>
                            <div class="card-footer">
                                <form action="sqlprocess/teamleadermap_sql_process.php" method="post" autocomplete="off" >
                                    <div class="row">
                                    
                                            <div class="col-md-8">
                                                <div class="lngLat"><span class="one">Latitude and</span><span class="two"> Longitudes</span></div>
                                                <textarea name="mapinfo"  id="info" style="font-size:14px;font-weight:600;width:100%;" readonly required></textarea>
                                            </div>
                                            <div class="col-md-4" style="margin-top:32px;">
                                                <button id="btn_save" type="submit" class="btn btn-md btn-info  pull-right ">
                                                    <i class="fa fa-clipboard"></i>&nbsp;Save Map
                                                </button>
                                                <a href="list_teamleadrs.php" class="btn btn-md btn-outline-secondary"><i class="ti-close"></i>&nbsp; Cancel</a>
                                                <a href="sqlprocess/teamleadermap_sql_process.php?tl_id=<?php echo $row['tl_id']; ?>" class="btn btn-md btn-outline-danger"><i class="ti-trash"></i>&nbsp; Clear Map</a>
                                                <input name="tl_id" value="<?php echo $row['tl_id']; ?>" type="hidden" required/>
                                            </div>
                                    
                                    </div>
                                </form>
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
