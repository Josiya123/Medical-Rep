<?php
include_once('security_check_teamleader.php');
if(!empty($_GET['hp_id'])){
 include_once("database.php");
 $select="SELECT `hp_id`, `hp_name`, `hp_code`, 
 `hp_address`, `hp_emailid`, `hp_mobilenumber`, `hp_weburl`, 
 `hp_landline`, `hp_lat`, `hp_lon`, `hp_type` FROM `hospitals` where hp_id=".$_GET['hp_id'];
 $data=database::SelectData($select);
 $row=mysqli_fetch_array($data);
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
    <style>
    #py_ur_code,#py_ur_mobile,#py_email_valid,#py_ur_landline{
        font-weight:bold;
        color:red;
        position:absolute;
        right:0px;
        bottom:-20px;
        display:none;
        font-size:small;

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
                     <div class="col-md-10 offset-md-1">
                        <?php
                            if(!empty($_GET['msg'])&& $_GET['msg']=="saved" ){
                        ?>
                        <div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">
                            <span class="badge badge-pill badge-primary">Success</span>
                                Hospital or Clinic Successfully Created
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                        }
                        ?> 
                        <div class="card">
                             <form action="sqlprocess/hospital_sql_process.php" method="post" autocomplete="off" >
                                <?php 
                                if(empty($_GET['hp_id'])){
                                ?>
                                <div class="card-header">
                                    <strong class="card-title">New Hospital | Clinic | Medical Shop</strong>
                                    <a href="list_hospitals.php" class="btn btn-sm btn-outline-primary pull-right"><i class="fa fa-plus-square"></i>&nbsp; List Hospitals | Clinics | MedicalShops</a>
                                </div>
                                <div class="card-body">
                               
                                    <div class="form-group">
                                        <label for="hp_name" class="control-label mb-1">Hospital | Clinic | MedicalShop Name</label>
                                        <input id="hp_name" name="hp_name" type="text" placeholder="name of hospital , clinic , medicalshop" class="form-control" required/>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group" style='position:relative;'>
                                               <span id="py_ur_code" style=""></span>
									           <label for="ur_code" class="control-label mb-1">Code</label>
                                                <input id="ur_code" name="hp_code" type="text" placeholder="code of hospital , clinic or medicalshop" class="form-control" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group" style='position:relative;'>
                                                <span id="py_ur_mobile" style=""></span>
									           <label for="ur_mobile" class="control-label mb-1">Mobile Number</label>
                                                <input id="ur_mobile" name="hp_mobilenumber" type="text" placeholder="mobile number of hospital , clinic or medical shop" class="form-control" autocomplete="off" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style='position:relative;'>
                                        <span id="py_email_valid" style=""></span>
									    <label for="ur_email" class="control-label mb-1">Email ID</label>
                                        <input id="ur_email" name="hp_emailid" type="email" placeholder="email id of hospital , clinic or medicalshop" class="form-control" autocomplete="off" required/>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="hp_weburl" class="control-label mb-1">Website</label>
                                                <input id="hp_weburl" name="hp_weburl" type="url" placeholder="website url of hospital , clinic or medicalshop" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group" style='position:relative;'>
                                                <span id="py_ur_landline" style=""></span>
                                                <label for="hp_landline" class="control-label mb-1">Landline Number</label>
                                                <input id="ur_landline" name="hp_landline" type="text" placeholder="LL number(Ex:0000-0000000)" class="form-control" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <label for="hp_landline" class="control-label mb-1">Institution Type</label>
                                            <select name="hp_type" id="hp_type" class="form-control">
                                                <option value="HOSPITAL">HOSPITAL</option>
                                                <option value="CLINIC">CLINIC</option>
												<option value="MEDICALSHOP">MEDICALSHOP</option>
                                            </select>
                                    </div>
                                    <button id="btn_save" type="submit" class="btn btn-md btn-info  pull-right ">
                                    <i class="fa fa-check"></i>&nbsp;Save
                                    </button>
                                    <a href="manage_hospitals.php" class="btn btn-md btn-outline-secondary"><i class="ti-close"></i>&nbsp; Cancel</a>
                                    <input name="hp_id" id="hp_id" value="0" type="hidden" required/>
                               
                                </div>
                                <?php 
                                }
                                else{
                                ?>
                                <div class="card-header">
                                     <?php
                                    if(($_GET['mode'])=="edit"){
                                    ?>
                                     <strong class="card-title">Edit Hospital | Clinic | MedicalShop</strong>
                                     <?php
                                    }
                                    else if(($_GET['mode'])=="delete"){
                                    ?>
                                     <strong class="card-title">Delete Hospital | Clinic | MedicalShop</strong>
                                      <?php
                                    }
                                   
                                    ?>
                                   
                                    <a href="list_hospitals.php" class="btn btn-sm btn-outline-primary pull-right"><i class="fa fa-plus-square"></i>&nbsp; List Hospitals | Clinics | MedicalShops</a>
                                </div>
                                <div class="card-body">
                               
                                    <div class="form-group">
                                        <label for="hp_name" class="control-label mb-1">Hospital | Clinic | MedicalShop</label>
                                        <input id="hp_name" name="hp_name" value="<?php echo $row['hp_name']; ?>" type="text" placeholder="name of hospital , clinic or medicalshop" class="form-control" required/>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group" style='position:relative;'>
                                               <span id="py_ur_code" style=""></span>
									           <label for="ur_code" class="control-label mb-1">Code</label>
                                                <input id="ur_code" name="hp_code" value="<?php echo $row['hp_code']; ?>" type="text" placeholder="code of hospital , clinic or medicalshop" autocomplete="off" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group" style='position:relative;'>
                                                <span id="py_ur_mobile" style=""></span>
									           <label for="ur_mobile" class="control-label mb-1">Mobile Number</label>
                                                <input id="ur_mobile" name="hp_mobilenumber" value="<?php echo $row['hp_mobilenumber']; ?>" type="text" placeholder="mobile number of hospital , clinic or medicalshop" class="form-control" autocomplete="off" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style='position:relative;'>
                                        <span id="py_email_valid" style=""></span>
									    <label for="ur_email" class="control-label mb-1">Email ID</label>
                                        <input id="ur_email" name="hp_emailid" value="<?php echo $row['hp_emailid']; ?>" type="email"  placeholder="email id of hospital , clinic or medicalshop" class="form-control" autocomplete="off" required/>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="hp_weburl" class="control-label mb-1">Website</label>
                                                <input id="hp_weburl" name="hp_weburl" value="<?php echo $row['hp_weburl']; ?>" type="url" placeholder="website url of hospital , clinic or medicalshop" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group" style='position:relative;'>
                                                 <span id="py_ur_landline" style=""></span>
                                                <label for="hp_landline" class="control-label mb-1">Landline Number</label>
                                                <input name="hp_landline" id="ur_landline" value="<?php echo $row['hp_landline']; ?>" type="text" placeholder="landline number ( Example:0000-00000)" class="form-control" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <label for="hp_landline" class="control-label mb-1">Institution Type</label>
                                            <select name="hp_type" id="hp_type" class="form-control">
                                                <option value="HOSPITAL" <?php echo  ($row['hp_type']=='HOSPITAL')?'selected':''; ?>>HOSPITAL</option>
                                                <option value="CLINIC" <?php echo  ($row['hp_type']=='CLINIC')?'selected':''; ?>>CLINIC</option>
												<option value="MEDICALSHOP" <?php echo  ($row['hp_type']=='MEDICALSHOP')?'selected':''; ?>>MEDICALSHOP</option>
                                            </select>
                                    </div>
                                    <?php
                                    if(($_GET['mode'])=="edit"){
                                    ?>
                                    <button id="btn_save" type="submit" class="btn btn-md btn-info  pull-right ">
                                        <i class="fa fa-clipboard"></i>&nbsp;Edit
                                    </button>
                                    <?php
                                    }
                                    else if(($_GET['mode'])=="delete"){
                                    ?>
                                     <a id="btn_save" href='sqlprocess/hospital_sql_process.php?hp_id=<?php echo $row['hp_id']; ?>' class="btn btn-md btn-danger  pull-right ">
                                        <i class="fa fa-cut"></i>&nbsp;
                                        <span id="payment-button-amount">Delete</span>
                                    </a>
                                    <?php
                                    }
                                    ?>
                                    <a href="list_hospitals.php" class="btn btn-md btn-outline-secondary"><i class="ti-close"></i>&nbsp; Cancel</a>
                                    <input name="hp_id" id="hp_id" value="<?php echo $row['hp_id']; ?>" type="hidden" required/>
                               
                                </div>
                                <?php 
                                }
                                ?>
                            </form>
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

    <script src="../assets/js/lib/data-table/datatables.min.js"></script>
    <script src="../assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="../assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
    <script src="../assets/js/lib/data-table/jszip.min.js"></script>
    <script src="../assets/js/lib/data-table/pdfmake.min.js"></script>
    <script src="../assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="../assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.print.min.js"></script>
    <script src="../assets/js/lib/data-table/buttons.colVis.min.js"></script>
    <script src="../assets/js/lib/data-table/datatables-init.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        } );
    </script>
    <script>
			$(document).ready(function(){
        	var typingTimer;   
			var doneTypingInterval = 800;
            window.emailflag=false;
            window.codeflag=false;
            window.mobileflag=false;
            window.landlineflag=false;
			$(document).on("input","#ur_email",function(e) {
				e.preventDefault();
				$("#btn_save").prop('disabled', true);
				
				clearTimeout(typingTimer);	
				if ($('#ur_email').val){
					typingTimer = setTimeout(function(){
                    email_validation(); 
                    },doneTypingInterval);
				}
			});
            $(document).on("input","#ur_code",function(e) {
				e.preventDefault();
				$("#btn_save").prop('disabled', true);
				clearTimeout(typingTimer);	
				if ($('#ur_code').val){
					typingTimer = setTimeout(function(){
                        code_validation();
                   
                    },doneTypingInterval);
				}
			});
            $(document).on("input","#ur_mobile",function(e) {
				e.preventDefault();
				$("#btn_save").prop('disabled', true);
				clearTimeout(typingTimer);	
				if ($('#ur_mobile').val){
					typingTimer = setTimeout(function(){
                        mobile_validation();
                   
                    },doneTypingInterval);
				}
			});
            $(document).on("input","#ur_landline",function(e) {
                
				e.preventDefault();
				$("#btn_save").prop('disabled', true);
				clearTimeout(typingTimer);	
				if ($('#ur_landline').val){
					typingTimer = setTimeout(function(){
                        landline_validation();
                   
                    },doneTypingInterval);
				}
			});
			function email_validation(){
                $('#py_email_valid').css("display","inline");
				var ur_email = $("#ur_email").val();
                var hp_id = $("#hp_id").val();
				if(ur_email.length >= 5 && validateEmail(ur_email) ){
					document.getElementById('py_email_valid').innerHTML="<span style='color:orange;'>checking availability...</span>";
					$.ajax({
						type: "POST",  
						url: "sqlprocess/hospitalemailid_checking_sql_process.php",  
						data: "ur_email="+ur_email+"&hp_id="+hp_id,
						success: function(msg){	
						
							if(msg=="exsists"){
								document.getElementById('py_email_valid').innerHTML="<span><i>"+ur_email+" </i> is already used !!!</span>";
							    window.emailflag=false;
                        	}
							else{
								document.getElementById('py_email_valid').innerHTML="<span style='color:green'><i>"+ur_email+" </i> is available !!!</span>";
								window.emailflag=true;
                           }
                            finalvalidate();
                 		}				
					});
				}
				else{
					document.getElementById('py_email_valid').innerHTML="<span>please enter a valid email id</span>";
			        window.emailflag=false;
                    finalvalidate();			
				}
               
            }
            function code_validation(){
                $('#py_ur_code').css("display","inline");
				var ur_code = $("#ur_code").val();
                var hp_id = $("#hp_id").val();
				if(ur_code.length >= 3 ){
					document.getElementById('py_ur_code').innerHTML="<span style='color:orange;'>checking availability...</span>";
					$.ajax({
						type: "POST",  
						url: "sqlprocess/hospitalcode_checking_sql_process.php",  
						data: "ur_code="+ur_code+"&hp_id="+hp_id,
						success: function(msg){	
						
							if(msg=="exsists"){
								document.getElementById('py_ur_code').innerHTML="<span><i>"+ur_code+" </i> is already used !!!</span>";
                                window.codeflag=false;
                            
							}
							else{
								document.getElementById('py_ur_code').innerHTML="<span style='color:green'><i>"+ur_code+" </i> is available !!!</span>";
                                window.codeflag=true;
                            
							}
                            finalvalidate();
						}				
					});
				}
				else{
					document.getElementById('py_ur_code').innerHTML="<span>minimum 3 charecters required</span>";
                    window.codeflag=false;
                    finalvalidate();			
				}
                
            }
            function mobile_validation(){
                $('#py_ur_mobile').css("display","inline");
				var ur_mobile = $("#ur_mobile").val();
                var hp_id = $("#hp_id").val();
				if(ur_mobile.length >= 10 && validateMobile(ur_mobile) ){
					document.getElementById('py_ur_mobile').innerHTML="<span style='color:orange;'>checking availability...</span>";
					$.ajax({
						type: "POST",  
						url: "sqlprocess/hospitalmobile_checking_sql_process.php",  
						data: "ur_mobile="+ur_mobile+"&hp_id="+hp_id,
						success: function(msg){	
						
							if(msg=="exsists"){
								document.getElementById('py_ur_mobile').innerHTML="<span><i>"+ur_mobile+" </i> is already used !!!</span>";
							    window.mobileflag=false;
                        	}
							else{
								document.getElementById('py_ur_mobile').innerHTML="<span style='color:green'><i>"+ur_mobile+" </i> is available !!!</span>";
								window.mobileflag=true;
                           }
                            finalvalidate();
                 		}				
					});
				}
				else{
					document.getElementById('py_ur_mobile').innerHTML="<span>please enter a valid mobile number</span>";
			        window.mobileflag=false;
                    finalvalidate();			
				}
               
            }
            function landline_validation(){
                $('#py_ur_landline').css("display","inline");
				var ur_landline = $("#ur_landline").val();
                var hp_id = $("#hp_id").val();
				if(ur_landline.length >= 10 && validateLandline(ur_landline) ){
					document.getElementById('py_ur_landline').innerHTML="<span style='color:orange;'>checking availability...</span>";
					$.ajax({
						type: "POST",  
						url: "sqlprocess/hospitallandline_checking_sql_process.php",  
						data: "ur_landline="+ur_landline+"&hp_id="+hp_id,
						success: function(msg){	
						
							if(msg=="exsists"){
								document.getElementById('py_ur_landline').innerHTML="<span><i>"+ur_landline+" </i> is already used !!!</span>";
							    window.landlineflag=false;
                        	}
							else{
								document.getElementById('py_ur_landline').innerHTML="<span style='color:green'><i>"+ur_landline+" </i> is available !!!</span>";
								window.landlineflag=true;
                           }
                            finalvalidate();
                 		}				
					});
				}
				else{
					document.getElementById('py_ur_landline').innerHTML="<span style='color:red'>please enter a valid landline number</span>";
			        window.landlineflag=false;
                    finalvalidate();			
				}
               
            }
            function validateEmail($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test( $email );
            }
            function validateMobile($mobile) {
            var mobileReg = /^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$/;
            return mobileReg.test( $mobile );
            }
            function validateLandline($landline) {
            var landlineReg = /^([0-9]{4}[\-]{1}[0-9]{7})$/;
            return landlineReg.test( $landline);
            }
            function finalvalidate(){
                if(window.emailflag==true && window.codeflag==true &&  window.mobileflag==true  &&  window.landlineflag==true ) {
                    $("#btn_save").prop('disabled', false);
                }
                else{
                    $("#btn_save").prop('disabled', true);  
                }

            }
        });
	</script>	

</body>
</html>
