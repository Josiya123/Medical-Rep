<?php
include_once('security_check_representative.php');
include_once("database.php");


    $select="SELECT `rp_id`,tl_id, `rp_repfirstname`,`rp_replastname`  FROM `representative`    where rp_id=".$_COOKIE['mr_urid'];
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
    `representative_duty`  where rp_id=".$_COOKIE['mr_urid']." and rd_dutydate='$rd_dutydate'";
    $myduties=database::SelectData($select);

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
                  
                    <?php 
                    $centerset=0;
                    $centerlat=0;
                    $centerlag=0;
             
                    $select="SELECT `tm_id`, `tl_id`, `tm_lat`, `tm_lng` FROM `teamleader_maparea`  where tl_id=".$repdetails['tl_id']." order by tm_id";
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
        /** @this {google.maps.Polygon} */
      function showArrays(event) {

      
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
          <?php echo $rows['rd_id'];?>,
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
                               
                                "<div class='card-body'>"+
                                   
                                    "<div class='form-group'>"+
                                        "<label for='rd_dutydescription' class='control-label mb-1'>Duty Description</label>"+
                                        "<input id='rd_dutydescription' name='rd_dutydescription' value="+duty[0]+" type='text' placeholder='about duty' class='form-control' readonly required/>"+
                                    "</div>"+
                                    "<div class='form-group'>"+
                                        "<label for='rd_dutylocation' class='control-label mb-1'>Location Latitude</label>"+
                                        "<input id='rd_dutylocation' name='rd_dutylocation' type='text' value='"+duty[1] +"'  class='form-control' readonly required/>"+
                                    "</div>"+
                                    "<div class='form-group'>"+
                                        "<label for='rd_dutylocation' class='control-label mb-1'>Location Langitude</label>"+
                                        "<input id='rd_dutylocation' name='rd_dutylocation' type='text' value='" +duty[2]+"'  class='form-control' readonly required/>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='card-footer'>"+
                                    "<input name='rp_id' type='hidden' value='<?php echo $repdetails['rp_id']; ?>'  class='form-control' required/>"+
                                    "<input name='rd_id' type='hidden' value='"+duty[5]+"'  class='form-control' required/>"+
                                    "<input name='rd_dutydate' type='hidden' value='"+duty[6]+"'  class='form-control' required/>"+
                                    "<input name='rd_status' type='hidden' value='"+duty[4]+"'  class='form-control' required/>"+
                                    "<button id='btn_save' type='submit' class='btn btn-md btn-primary btn-block'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Check In</button>"+
                                    "<button type='button' id='dy_"+duty[5]+"' class='btn btn-md btn-danger btn-block duty_details'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Duty Details</button>"+
                                "</div>"+
                            "</form>"+
                       "</div>"; 
                    }
                    else if(duty[4]=='checkin'){
                        contentString="<div class='card' style='width:250px;'>"+
                            "<form action='sqlprocess/rep_duty_sql_process.php' method='post' autocomplete='off' >"+
                               
                                "<div class='card-body'>"+
                                   
                                    "<div class='form-group'>"+
                                        "<label for='rd_dutydescription' class='control-label mb-1'>Duty Description</label>"+
                                        "<input id='rd_dutydescription' name='rd_dutydescription' value="+duty[0]+" type='text' placeholder='about duty' class='form-control' readonly required/>"+
                                    "</div>"+
                                    "<div class='form-group'>"+
                                        "<label for='rd_dutylocation' class='control-label mb-1'>Check In Date</label>"+
                                        "<input id='rd_dutylocation' name='rd_dutylocation' type='text' value='"+duty[7] +"'  class='form-control' readonly required/>"+
                                    "</div>"+
                                    "<div class='form-group'>"+
                                        "<label for='rd_dutylocation' class='control-label mb-1'>Check In Time</label>"+
                                        "<input id='rd_dutylocation' name='rd_dutylocation' type='text' value='" +duty[8]+"'  class='form-control' readonly required/>"+
                                    "</div>"+
                                "</div>"+
                                "<div class='card-footer'>"+
                                    "<input name='rp_id' type='hidden' value='<?php echo $repdetails['rp_id']; ?>'  class='form-control' required/>"+
                                    "<input name='rd_id' type='hidden' value='"+duty[5]+"'  class='form-control' required/>"+
                                    "<input name='rd_dutydate' type='hidden' value='"+duty[6]+"'  class='form-control' required/>"+
                                    "<input name='rd_status' type='hidden' value='"+duty[4]+"'  class='form-control' required/>"+
                                    "<button id='btn_save' type='submit' class='btn btn-md btn-warning btn-block'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Chek Out</button>"+
                                    "<button type='button' id='dy_"+duty[5]+"' class='btn btn-md btn-danger btn-block duty_details'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Duty Details</button>"+
                                "</div>"+
                            "</form>"+
                       "</div>";   
                    }
                    else if(duty[4]=='checkout'){
                        contentString="<div class='card' style='width:250px;'>"+
                            "<form action='sqlprocess/rep_duty_sql_process.php' method='post' autocomplete='off' >"+
                               
                                "<div class='card-body'>"+
                                   
                                    "<div class='form-group'>"+
                                        "<label for='rd_dutydescription' class='control-label mb-1'>Duty Description</label>"+
                                        "<input id='rd_dutydescription' name='rd_dutydescription' value="+duty[0]+" type='text' placeholder='about duty' class='form-control' readonly required/>"+
                                    "</div>"+
                                    "<div class='form-group'>"+
                                        "<label for='rd_dutydescription' class='control-label mb-1'>Feedback</label>"+
                                        "<input id='rd_feedback' name='rd_feedback'  type='text' placeholder='what you do ?' class='form-control' required/>"+
                                    "</div>"+
                                   
                                "</div>"+
                                "<div class='card-footer'>"+
                                    "<input name='rp_id' type='hidden' value='<?php echo $repdetails['rp_id']; ?>'  class='form-control' required/>"+
                                    "<input name='rd_id' type='hidden' value='"+duty[5]+"'  class='form-control' required/>"+
                                    "<input name='rd_dutydate' type='hidden' value='"+duty[6]+"'  class='form-control' required/>"+
                                    "<input name='rd_status' type='hidden' value='"+duty[4]+"'  class='form-control' required/>"+
                                    "<button id='btn_save' type='submit' class='btn btn-md btn-success btn-block'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Feedback</button>"+
                                    "<button type='button' id='dy_"+duty[5]+"' class='btn btn-md btn-danger btn-block duty_details'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Duty Details</button>"+
                                "</div>"+
                            "</form>"+
                       "</div>";   
                    }
                    else if(duty[4]=='finish'){
                        contentString="<div class='card' style='width:250px;'>"+
                           
                                "<div class='card-body'>"+
                                   
                                    "<div class='form-group'>"+
                                        "<label for='rd_dutydescription' class='control-label mb-1'>Duty Description</label>"+
                                        "<input id='rd_dutydescription' name='rd_dutydescription' value="+duty[0]+" type='text' placeholder='about duty' class='form-control' readonly required/>"+
                                    "</div>"+
                                    "<div class='form-group'>"+
                                        "<label for='rd_dutydescription' class='control-label mb-1'>Feedback</label>"+
                                        "<input id='rd_feedback' name='rd_feedback'  type='text' value="+duty[9]+"  placeholder='what you do ?' class='form-control' readonly required/>"+
                                    "</div>"+
                                   
                                "</div>"+
                                "<div class='card-footer'>"+
                              
                                    "<button type='button' id='dy_"+duty[5]+"' class='btn btn-md btn-danger btn-block duty_details'>"+
                                    "<i class='fa fa-check'></i>&nbsp;Duty Details</button>"+
                                "</div>"+
                         
                       "</div>";   
                    }
					infoWindow1.setContent(contentString);
                    infoWindow1.open(map, marker);
                });
            })(marker, duty);
        
        }
    }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3VCgt8XUKoDJMDvo6DIEiufGAtE1y6Ps&v=3&callback=initMap">
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
    $currentmenu="myduties";
     include_once('left_nav.php');
    ?>
    <div id="right-panel" class="right-panel">
        <?php include_once('top_header.php'); ?>   
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                     <div class="col-md-12 ">
                        
                        <div class="card">
                            <div class="card-header ">
                                    <form action="progress_duty_map.php" style="margin:auto;" method="post">
                                        <div class="form-group text-left" style='width:50%;float:left;'>
                                            <input name="rd_dutydate" type="date" value="<?php echo $rd_dutydate; ?>" class="form-control" required/>
                                        </div>
                                        <button type="submit" class="btn btn-outline-secondary btn-sm" style='margin-left:10px;height:38px;'><i class="fa  fa-exchange"></i>&nbsp; Change Date</button>
                                    </form>
                               </div>
                            <div class="card-body" style="height:550px;">
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
