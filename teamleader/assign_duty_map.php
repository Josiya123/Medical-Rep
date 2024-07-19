<?php
include_once('security_check_teamleader.php');
include_once("database.php");
if(!empty($_GET['rp_id'])){

    $select="SELECT `pr_id`, `pt_id`, upper(pr_name) as pr_name FROM `products`";
    $products=database::SelectData($select);

    $select="SELECT `hp_id`, `tl_id`,upper(`hp_name`) as  hp_name, `hp_code`, `hp_address`, `hp_emailid`, `hp_mobilenumber`, 
    `hp_weburl`, `hp_landline`, `hp_lat`, `hp_lon`, `hp_type` FROM hospitals   where tl_id=".$_COOKIE['mr_urid'];
    $hospitals=database::SelectData($select);
    $hospitals_1=database::SelectData($select);

    $select="SELECT `dc_id`, `tl_id`, upper(`dc_name`) as dc_name , `dc_emailid`, `dc_speciality` FROM `doctors`  where tl_id=".$_COOKIE['mr_urid'];
    $doctors=database::SelectData($select);

    $select="SELECT `mt_id`, upper(`mt_meetingtype`) as mt_meetingtype  FROM `meeting_types`";
    $meetingtype=database::SelectData($select);

    $select="SELECT `rp_id`, `rp_repfirstname`,`rp_replastname`  FROM `representative`    where rp_id=".$_GET['rp_id'];
    $data=database::SelectData($select);
    $repdetails=mysqli_fetch_array($data);
    if(!array_key_exists('rd_dutydate', $_POST)){
        $rd_dutydate=$_GET['rd_dutydate'];

    }
    else{
        $rd_dutydate=$_POST['rd_dutydate'];
    }
    $select="SELECT `rd_id`,`rd_dutydescription`, `rd_lat`, `rd_lng`,rd_status,rd_dutydate,
    `rd_checkindate`, `rd_checkintime`, `rd_checkoutdate`, `rd_checkouttime`, `rd_feedback`,
    `rd_feedbackdate`, `rd_feedbacktime` FROM 
    `representative_duty` where rp_id=".$_GET['rp_id']." and rd_dutydate='$rd_dutydate'";
    $myduties=database::SelectData($select);

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
            setHospitalMarkers(map) ;
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

        contentString="<div class='card' style='width:600px;'>"+
                            "<form action='sqlprocess/rep_duty_sql_process.php' method='post' autocomplete='off' >"+
                                "<div class='card-header'>"+
                                    "<strong class='card-title'>Assign Duty To <?php echo $repdetails['rp_repfirstname'].' '.$repdetails['rp_replastname']; ?></strong>"+
                                "</div>"+
                                "<div class='card-body'>"+
                                    "<div class='row'>"+
                                        "<div class='col-md-6'>"+
                                            "<div class='form-group'>"+
                                                "<label for='mt_id' class='control-label mb-1'>Meeting Type</label>"+
                                                "<select name='mt_id' id='mt_id' class='form-control' required>"+
                                                    "<option value=''>Select Meeting Type</option>"+
                                                    <?php
                                                    while($row=mysqli_fetch_array($meetingtype)) {
                                                    ?>
                                                    "<option value='<?php echo $row['mt_id']; ?>'><?php echo $row['mt_meetingtype']; ?></option>"+
                                                    <?php
                                                    }
                                                    ?>
                                                "</select>"+
                                            "</div>"+
                                            "<div class='form-group'>"+
                                                "<label for='pr_id' class='control-label mb-1'>Product</label>"+
                                                "<select name='pr_id' id='pr_id' class='form-control' required>"+
                                                    "<option value=''>Select Product</option>"+
                                                    <?php
                                                    while($row=mysqli_fetch_array($products)) {
                                                    ?>
                                                    "<option value='<?php echo $row['pr_id']; ?>'><?php echo $row['pr_name']; ?></option>"+
                                                    <?php
                                                    }
                                                    ?>
                                                "</select>"+
                                            "</div>"+
                                            "<div class='form-group'>"+
                                                "<label for='hp_id' class='control-label mb-1'>Hospital/ Clinic</label>"+
                                                "<select name='hp_id' id='hp_id' class='form-control' required>"+
                                                    "<option value=''>Select Hospital / Clinic</option>"+
                                                    <?php
                                                    while($row=mysqli_fetch_array($hospitals_1)) {
                                                    ?>
                                                    "<option value='<?php echo $row['hp_id']; ?>'><?php echo $row['hp_name'].'('.$row['hp_type'].')'; ?></option>"+
                                                    <?php
                                                    }
                                                    ?>
                                                "</select>"+
                                            "</div>"+
                                            "<div class='form-group'>"+
                                                "<label for='dc_id' class='control-label mb-1'>Doctor/ Pharmasist</label>"+
                                                "<select name='dc_id' id='dc_id' class='form-control' required>"+
                                                    "<option value=''>Doctor / Pharmasist</option>"+
                                                    <?php
                                                    while($row=mysqli_fetch_array($doctors)) {
                                                    ?>
                                                    "<option value='<?php echo $row['dc_id']; ?>'><?php echo $row['dc_name'].'('.$row['dc_speciality'].')'; ?></option>"+
                                                    <?php
                                                    }
                                                    ?>
                                                "</select>"+
                                            "</div>"+
                                        "</div>"+
                                        "<div class='col-md-6'>"+
                                            "<div class='form-group'>"+
                                                "<label for='rd_dutydescription' class='control-label mb-1'>Duty Description</label>"+
                                                "<textarea id='rd_dutydescription' name='rd_dutydescription' placeholder='about duty' class='form-control' required rows='4'></textarea>"+
                                            "</div>"+
                                            "<div class='form-group'>"+
                                                "<label for='rd_dutydate' class='control-label mb-1'>Duty Date</label>"+
                                                "<input id='rd_dutydate' name='rd_dutydate' type='date' value='<?php echo $rd_dutydate; ?>'  class='form-control' readonly required/>"+
                                            "</div>"+
                                            "<div class='form-group'>"+
                                                "<label for='rd_dutylocation' class='control-label mb-1'>Duty Location</label>"+
                                                "<input id='rd_dutylocation' name='rd_dutylocation' type='text' value='"+event.latLng.lat() + ',' + event.latLng.lng()+"'  class='form-control' readonly required/>"+
                                            "</div>"+           
                                        "</div>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='card-footer'>"+
                                    "<input name='rp_id' type='hidden' value='<?php echo $repdetails['rp_id']; ?>'  class='form-control' readonly required/>"+
                                    "<input name='rd_id' type='hidden' value='0'  class='form-control' readonly required/>"+
                                    
                                    "<button id='btn_save' type='submit' class='btn btn-md btn-info btn-block'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Save Duty</button>"+
                                "</div>"+
                            "</form>"+
                       "</div>"; 


        // Replace the info window's content and position.
        infoWindow.setContent(contentString);
        infoWindow.setPosition(event.latLng);

        infoWindow.open(map);
      }

      var myduties = [
		<?php 
		$i=0;
		$totalduties=mysqli_num_rows($myduties);
		while($rows=mysqli_fetch_array($myduties)){
			$i++;
		?>
        ['<?php echo $rows['rd_dutydescription'];?>',
         <?php echo $rows['rd_lat'];?>,
          <?php echo $rows['rd_lng'];?>, 
          <?php echo $i;?>, 
          '<?php echo $rows['rd_status'];?>',
          '<?php echo $rows['rd_id'];?>',
          '<?php echo $rows['rd_dutydate'];?>',
          '<?php echo $rows['rd_checkindate'];?>',
          '<?php echo $rows['rd_checkintime'];?>',
          '<?php echo $rows['rd_feedback'];?>'
          ]
		<?php if($i<$totalduties){ echo ",";}?>
		<?php 
		}
		?>
    ];
    function setMarkers(map) {
        var newduty = {
			url: '../images/newduty.png',
			size: new google.maps.Size(20, 20),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(0, 20)
        };
        var checkin = {
			url: '../images/checkin.png',
			size: new google.maps.Size(20, 20),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(0, 20)
        };
        var checkout = {
			url: '../images/checkout.png',
			size: new google.maps.Size(20, 20),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(0, 20)
        };
        var finish = {
			url: '../images/finish.png',
			size: new google.maps.Size(20, 20),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(0, 20)
        };
		var infowindow1="";
		var shape = {
          coords: [1, 1, 1, 20, 18, 20, 18, 1],
          type: 'poly'
        };
        for (var i = 0; i < myduties.length; i++) {
			var duty = myduties[i];
			var image=newduty;
            if(duty[4]=='checkin'){
				image=checkin;
			
            }
            if(duty[4]=='checkout'){
				image=checkout;
			
            }
            if(duty[4]=='finish'){
				image=finish;
			
            }
            var infoWindow1 = new google.maps.InfoWindow();
		    var marker = new google.maps.Marker({
            position: {lat: duty[1], lng: duty[2]},
            map: map,
            icon: image,
            shape: shape,
            title: duty[0],
            zIndex: duty[3]
          });
          (function (marker, duty) {
                google.maps.event.addListener(marker, "click", function (e) {
                    var contentString="";
                    if(duty[4]=='new'){
                   contentString="<div class='card' style='width:250px;'>"+
                            "<form action='sqlprocess/rep_duty_sql_process.php' method='post' autocomplete='off' >"+
                                "<div class='card-header'>"+
                                    "<strong class='card-title'>Delete Duty of <?php echo $repdetails['rp_repfirstname'].' '.$repdetails['rp_replastname']; ?></strong>"+
                                "</div>"+
                                "<div class='card-body'>"+
                                    "<div class='form-group'>"+
                                        "<label for='rd_dutydate' class='control-label mb-1'>Duty Date</label>"+
                                        "<input id='rd_dutydate' name='rd_dutydate' type='date' value='<?php echo $rd_dutydate; ?>'  class='form-control' readonly required/>"+
                                    "</div>"+
                                    "<div class='form-group'>"+
                                        "<label for='rd_dutydescription' class='control-label mb-1'>Duty Description</label>"+
                                        "<input id='rd_dutydescription' name='rd_dutydescription' value="+duty[0]+" type='text' placeholder='about duty' class='form-control' readonly required/>"+
                                    "</div>"+
                                    "<div class='form-group'>"+
                                        "<label for='rd_dutylocation' class='control-label mb-1'>Duty Location</label>"+
                                        "<input id='rd_dutylocation' name='rd_dutylocation' type='text' value='"+duty[1] + ',' +duty[2]+"'  class='form-control' readonly required/>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='card-footer'>"+
                                    "<input name='rp_id' type='hidden' value='<?php echo $repdetails['rp_id']; ?>'  class='form-control' readonly required/>"+
                                    "<input name='rd_id' type='hidden' value='"+duty[5]+"'  class='form-control' readonly required/>"+
                                    "<button id='btn_save' type='submit' class='btn btn-md btn-danger btn-block'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Delete Duty</button>"+
                                    "<button type='button' id='dy_"+duty[5]+"' class='btn btn-md btn-info btn-block duty_details'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Duty Details</button>"+
                                "</div>"+
                            "</form>"+
                       "</div>"; 
                    }
                    else if(duty[4]=='checkin'){
                        contentString=  "<div style='width:250px;' class='sufee-alert alert with-close alert-danger alert-dismissible fade show'>"+
                        "<span class='badge badge-pill badge-danger'>Deletion Not Possible</span>"+
                        "Representative Alreday CheckIn for Duty"+
                    "</div>"+
                    "<button type='button' id='dy_"+duty[5]+"' class='btn btn-md btn-info btn-block duty_details'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Duty Details</button>";
                    }
                    else if(duty[4]=='checkout'){
                        contentString=  "<div style='width:250px;' class='sufee-alert alert with-close alert-danger alert-dismissible fade show'>"+
                                            "<span class='badge badge-pill badge-danger'>Deletion Not Possible</span>"+
                                            "Representative Alreday Completed the Duty"+
                                        "</div>"+
                                        "<button type='button' id='dy_"+duty[5]+"' class='btn btn-md btn-info btn-block duty_details'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Duty Details</button>";
                                       
                    }
                    else if(duty[4]=='finish'){
                        contentString=  "<div style='width:250px;' class='sufee-alert alert with-close alert-danger alert-dismissible fade show'>"+
                        "<span class='badge badge-pill badge-danger'>Deletion Not Possible</span>"+
                        "Representative Alreday Completed and Feedback Duty"+
                    "</div>"+
                    "<button type='button' id='dy_"+duty[5]+"' class='btn btn-md btn-info btn-block duty_details'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Duty Details</button>";
                    }
					infoWindow1.setContent(contentString);
                    infoWindow1.open(map, marker);
                });
            })(marker, duty);
        
        }
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
          '<?php echo $rows['hp_id'];?>'
          ]
          <?php if($i<$total){ echo ",";}?>
		<?php 
        }
        
		?>
        ];
    function setHospitalMarkers(map) {
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
            var marker = new google.maps.Marker({
            position: {lat: row[1], lng: row[2]},
            map: map,
            icon: image,
            shape: shape,
            title: row[0],
            zIndex: -1
          });
          marker.addListener('click', showArrays);
        
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
    $currentmenu="representative";
     include_once('left_nav.php');
    ?>
    <div id="right-panel" class="right-panel">
        <?php include_once('top_header.php'); ?>   
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                     <div class="col-md-12 ">
                        
                        <div class="card">
                            <div class="card-header" style="padding:0;">
                                <div class="container-fluid">
                                    <div class="row"style="margin-bottom:10px;">
                                        <div class="col-12 text-center text-white bg-flat-color-1">
                                            <strong class="card-title">Assign Duty to <?php echo $repdetails['rp_repfirstname'].' '.$repdetails['rp_replastname']; ?></strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-9">
                                            <form action="assign_duty_map.php?mode=edit&rp_id=<?php echo $_GET['rp_id']; ?>" method="post">
                                                <div class="form-group text-left" style='width:80%;float:left;'>
                                                    <input name="rd_dutydate" type="date" value="<?php echo $rd_dutydate; ?>" class="form-control" required/>
                                                </div>
                                                <button type="submit" class="btn btn-outline-secondary btn-sm" style='margin-left:10px;height:40px;'>&nbsp;<i class="fa  fa-refresh"></i>&nbsp;</button>
                                            </form>
                                        </div>
                                        <div class="col-3">
                                            <a href="list_representatives.php" class="btn btn-sm btn-outline-secondary pull-right" style='margin-left:10px;height:40px;padding:auto;padding-top:10px;'>&nbsp;<i class="fa fa-chevron-left"></i>&nbsp;</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" style="height:600px;">
                                <div id="mapCanvas" style="height:100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="dutyDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id='modal_hospital'></h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                    <a class="list-group-item list-group-item-action">Product <span id="modal_product"></span></a>
                    <a class="list-group-item list-group-item-action">Consult With <span id="modal_consult"></span></a>
                    <a class="list-group-item list-group-item-action">Meeting Type <span id="modal_meetingtype"></span></a>
                    <a class="list-group-item list-group-item-action">Duty Date <span id="modal_dutydate"></span></a>
                    <a class="list-group-item list-group-item-action">Duty Status <span id="modal_dutystatus"></span></a>
                    <a class="list-group-item list-group-item-action">CheckIn Time <span id="modal_checkin"></span></a>
                    <a class="list-group-item list-group-item-action">CheckOut Time <span id="modal_checkout"></span></a>
                    <a class="list-group-item list-group-item-action">Feedback <span id="modal_feedback"></span></a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../assets/js/main.js"></script>
    <script>
   jQuery(document).ready(function($){
            'use strict';
            $(document).on('click', '.duty_details', function(){
                var temp=this;
		        var rd_id=temp.id.split("_");
                var dataString = 'rd_id='+rd_id[1];
                $.ajax
                ({
                    type: "POST",
                    url:'sqlprocess/duty_details.php',
                    data: dataString,
                    dataType: "json",
                    cache: false,
                    success: function(data){
                        $("#modal_hospital").html(data['hp_name']+"("+data['hp_type']+")");
                        $("#modal_product").html(data['pr_name']);
                        $("#modal_consult").html(data['dc_name']);
                        $("#modal_meetingtype").html(data['mt_meetingtype']);
                        $("#modal_dutydate").html(data['rd_dutydate']);
                        $("#modal_dutystatus").html(data['rd_status']);
                        $("#modal_checkin").html(data['rd_checkindate']+", "+data['rd_checkintime']);
                        $("#modal_checkout").html(data['rd_checkoutdate']+", "+data['rd_checkoutdate']);
                        $("#modal_feedback").html(data['rd_feedback']);
                        $('#dutyDetails').modal('show');
                      }
                });
             
            });
        });
    </script>
    <style>
    .list-group-item span{
        font-weight:bold;
        color:red;

    }
    </style>

</body>
</html>
