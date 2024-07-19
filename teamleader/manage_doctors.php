<?php
include_once('security_check_teamleader.php');
if(!empty($_GET['dc_id'])){
 include_once("database.php");
 $select="SELECT `dc_id`, `tl_id`, `dc_name`, `dc_emailid`, `dc_speciality` FROM `doctors` where dc_id=".$_GET['dc_id'];
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
    #py_ur_code,#py_ur_mobile,#py_email_valid{
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
    $currentmenu="doctors";
     include_once('left_nav.php');
    ?>
    <div id="right-panel" class="right-panel">
        <?php include_once('top_header.php'); ?>   
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                     <div class="col-md-6 offset-md-3">
                        <?php
                            if(!empty($_GET['msg'])&& $_GET['msg']=="saved" ){
                        ?>
                        <div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">
                            <span class="badge badge-pill badge-primary">Success</span>
                                Doctor Successfully Created
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                        }
                        ?> 
                        <div class="card">
                             <form action="sqlprocess/doctor_sql_process.php" method="post" autocomplete="off" >
                                <?php 
                                if(empty($_GET['dc_id'])){
                                ?>
                                <div class="card-header">
                                    <strong class="card-title">New Doctor</strong>
                                    <a href="list_doctors.php" class="btn btn-sm btn-outline-primary pull-right"><i class="fa fa-plus-square"></i>&nbsp; List Doctors</a>
                                </div>
                                <div class="card-body">
                               
                                    <div class="form-group">
                                        <label for="dc_name" class="control-label mb-1">Doctor Name</label>
                                        <input id="dc_name" name="dc_name" type="text" placeholder="name of doctor" class="form-control" required/>
                                    </div>
                                    
                                    <div class="form-group" style='position:relative;'>
                                        <span id="py_email_valid" style=""></span>
									    <label for="ur_email" class="control-label mb-1">Email ID</label>
                                        <input id="ur_email" name="dc_emailid" type="email" placeholder="email id of doctor" class="form-control" autocomplete="off" required/>
                                    </div>
                                   
                                    <div class="form-group">
                                            <label for="dc_speciality" class="control-label mb-1">Specialization</label>
                                            <select name="dc_speciality" id="dc_speciality" class="form-control">
                                                <option value="DENTIST">DENTIST</option>
                                                <option value="GYNECOLOGIST">GYNECOLOGIST</option>
                                                <option value="GENERAL-PHYSICIAN">GENERAL-PHYSICIAN</option>
                                                <option value="DERMATOLOGIST">DERMATOLOGIST</option>
                                                <option value="ENT-SPECIALIST">ENT-SPECIALIST</option>
                                                <option value="HOMOEO-PATH">HOMOEO-PATH</option>
                                                <option value="AYURVEDA">AYURVEDA</option>
                                                <option value="AYURVEDA">PHARMASIST</option>
                                            </select>
                                    </div>
                                    <button id="btn_save" type="submit" class="btn btn-md btn-info  pull-right ">
                                    <i class="fa fa-check"></i>&nbsp;Save
                                    </button>
                                    <a href="manage_doctors.php" class="btn btn-md btn-outline-secondary"><i class="ti-close"></i>&nbsp; Cancel</a>
                                    <input name="dc_id" id="dc_id" value="0" type="hidden" required/>
                               
                                </div>
                                <?php 
                                }
                                else{
                                ?>
                                <div class="card-header">
                                     <?php
                                    if(($_GET['mode'])=="edit"){
                                    ?>
                                     <strong class="card-title">Edit Doctor</strong>
                                     <?php
                                    }
                                    else if(($_GET['mode'])=="delete"){
                                    ?>
                                     <strong class="card-title">Delete Doctor</strong>
                                      <?php
                                    }
                                   
                                    ?>
                                   
                                    <a href="list_doctors.php" class="btn btn-sm btn-outline-primary pull-right"><i class="fa fa-plus-square"></i>&nbsp; List Doctors</a>
                                </div>
                                <div class="card-body">
                               
                                    <div class="form-group">
                                        <label for="dc_name" class="control-label mb-1">Doctor</label>
                                        <input id="dc_name" name="dc_name" value="<?php echo $row['dc_name']; ?>" type="text" placeholder="name of doctor" class="form-control" required/>
                                    </div>
                                    
                                    <div class="form-group" style='position:relative;'>
                                        <span id="py_email_valid" style=""></span>
									    <label for="ur_email" class="control-label mb-1">Email ID</label>
                                        <input id="ur_email" name="dc_emailid" value="<?php echo $row['dc_emailid']; ?>" type="email"  placeholder="email id of doctor" class="form-control" autocomplete="off" required/>
                                    </div>
                                   
                                    <div class="form-group">
                                            <label for="dc_speciality" class="control-label mb-1">Specialization</label>
                                            <select name="dc_speciality" id="dc_speciality" class="form-control">
                                                <option value="DENTIST" <?php echo  ($row['dc_speciality']=='DENTIST')?'selected':''; ?>>DENTIST</option>
                                                <option value="GYNECOLOGIST" <?php echo  ($row['dc_speciality']=='GYNECOLOGIST')?'selected':''; ?>>GYNECOLOGIST</option>
                                                <option value="GENERAL-PHYSICIAN" <?php echo  ($row['dc_speciality']=='GENERAL-PHYSICIAN')?'selected':''; ?>>GENERAL-PHYSICIAN</option>
                                                <option value="DERMATOLOGIST" <?php echo  ($row['dc_speciality']=='DERMATOLOGIST')?'selected':''; ?>>DERMATOLOGIST</option>
                                                <option value="ENT-SPECIALIST" <?php echo  ($row['dc_speciality']=='ENT-SPECIALIST')?'selected':''; ?>>ENT-SPECIALIST</option>
                                                <option value="HOMOEO-PATH" <?php echo  ($row['dc_speciality']=='HOMOEO-PATH<')?'selected':''; ?>>HOMOEO-PATH</option>
                                                <option value="AYURVEDA" <?php echo  ($row['dc_speciality']=='AYURVEDA')?'selected':''; ?>>AYURVEDA</option>
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
                                     <a id="btn_save" href='sqlprocess/doctor_sql_process.php?dc_id=<?php echo $row['dc_id']; ?>' class="btn btn-md btn-danger  pull-right ">
                                        <i class="fa fa-cut"></i>&nbsp;
                                        <span id="payment-button-amount">Delete</span>
                                    </a>
                                    <?php
                                    }
                                    ?>
                                    <a href="list_doctors.php" class="btn btn-md btn-outline-secondary"><i class="ti-close"></i>&nbsp; Cancel</a>
                                    <input name="dc_id" id="dc_id" value="<?php echo $row['dc_id']; ?>" type="hidden" required/>
                               
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

			function email_validation(){
                $('#py_email_valid').css("display","inline");
				var ur_email = $("#ur_email").val();
                var dc_id = $("#dc_id").val();
				if(ur_email.length >= 5 && validateEmail(ur_email) ){
					document.getElementById('py_email_valid').innerHTML="<span style='color:orange;'>checking availability...</span>";
					$.ajax({
						type: "POST",  
						url: "sqlprocess/doctoremailid_checking_sql_process.php",  
						data: "ur_email="+ur_email+"&dc_id="+dc_id,
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


            function validateEmail($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test( $email );
            }
      
            function finalvalidate(){
                if(window.emailflag==true) {
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
