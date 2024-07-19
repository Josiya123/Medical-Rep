<?php
include_once('security_check_admin.php');
include_once("database.php");
$dt_id=0;
$st_id=0;
if(!empty($_POST['st_id']) || !empty($_POST['dt_id'])){
    $dt_id=$_POST['dt_id'];
    $st_id=$_POST['st_id'];
if($dt_id!=-1){
$select="SELECT `tl_id`, dt_name, `tl_emailid`, `tl_password`, `tl_firstname`, `tl_lastname`,
`tl_gender` FROM `teamleader` inner join district on district.dt_id=teamleader.dt_id where teamleader.dt_id=$dt_id and district.st_id=$st_id";
}else{
    $select="SELECT `tl_id`, dt_name, `tl_emailid`, `tl_password`, `tl_firstname`, `tl_lastname`,
    `tl_gender` FROM `teamleader` inner join district on district.dt_id=teamleader.dt_id where district.st_id=$st_id";
      
}
$leaders=database::SelectData($select);
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
                    zoom: 8
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
                    <?php 
                    $centerset=0;
                    $centerlat=0;
                    $centerlag=0;
                    while($leader=mysqli_fetch_array($leaders)) {
                    $select="SELECT `tm_id`, `tl_id`, `tm_lat`, `tm_lng` FROM `teamleader_maparea`  where tl_id=".$leader['tl_id']." order by tm_id";
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
                    draggable: false,
                    editable:false,
                    geodesic: false
                    });
                    myPolygon.setMap(map);
                    <?php
                    }
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
                    //google.maps.event.addListener(myPolygon.getPath(), "insert_at", getPolygonCoords);
                    //google.maps.event.addListener(myPolygon.getPath(), "remove_at", getPolygonCoords);
                   // google.maps.event.addListener(myPolygon.getPath(), "set_at", getPolygonCoords);
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
                     <div class="col-md-12 ">
                        
                        <div class="card">
                             <form action="team_leaders_map_view.php" method="post">
                         
                                <div class="card-header">
                                    <strong class="card-title">Map View Of Team Leaders</strong>
                                    <a href="list_teamleadrs.php" class="btn btn-sm btn-outline-primary pull-right"><i class="fa fa-group"></i>&nbsp; List Team Leaders</a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label for="st_id" class="control-label mb-1">Select State</label>
                                                <select name="st_id" id="st_id" class="form-control" required>
                                                <?php
                                                $select="SELECT `st_id`, `na_id`, `st_name` FROM `state`";
                                                $data=database::SelectData($select);
                                                while($row1=mysqli_fetch_array($data)) {
                                                ?>
                                                <option value="<?php echo $row1['st_id']; ?>" <?php echo   ($st_id==$row1['st_id'])?'selected':''; ?>><?php echo $row1['st_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <label for="dt_id" class="control-label mb-1">Select District</label>
                                                <select name="dt_id" id="dt_id" class="form-control" required>
                                                    <?php
                                                    if($st_id!=0){
                                                    $select="SELECT `dt_id`, `st_id`, `na_id`, `dt_name`, `dt_pincode` FROM `district` where st_id=$st_id";
                                                    $data=database::SelectData($select);
                                                    while($row1=mysqli_fetch_array($data)) {
                                                    ?>
                                                    <option value="<?php echo $row1['dt_id']; ?>" <?php echo  ($dt_id==$row1['dt_id'])?'selected':''; ?> ><?php echo $row1['dt_name']; ?> </option>
                                                    <?php
                                                    }
                                                    if(mysqli_num_rows($data)>0){
                                                    ?>
                                                        <option value="-1" <?php echo  ($dt_id==-1)?'selected':''; ?>>All Districts</option>  
                                                    <?php
                                                    }
                                                    }
                                                    else{
                                                    ?>
                                                     <option value="">Please Select Any State</option>
                                                    <?php
                                                    }
                                                    ?>
                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                        <button id="btn_save" type="submit" class="btn btn-md btn-warning  pull-right " style="margin-top:30px;">
                                        <i class="fa fa-map"></i>&nbsp;Show Map
                                        </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer" style="height:500px;">
                                    <div id="mapCanvas" style="height:100%;"></div>
                                </div>
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/vendor/jquery-2.1.4.min.js"></script>

    <script type="text/javascript">
	    $(document).ready(function(){
			$("#st_id").change(function(){
				var id=$(this).val();
				var dataString = 'st_id='+id;
				$.ajax({
					type: "POST",
					url: "ajax/manage_districts1.php",
					data: dataString,
					cache: false,
					success: function(html){
                    	$("#dt_id").html(html);
				    } 
				});
			});
		});
    </script>
    

</body>
</html>
