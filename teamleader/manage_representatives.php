<?php
include_once('security_check_admin.php');
include_once("database.php");
if(!empty($_GET['rp_id'])){

 $select="SELECT `rp_id`, teamleader.tl_id,teamleader.dt_id,district.st_id, `rp_repfirstname`, 
 `rp_replastname`, `rp_gender`, `rp_mobilenumber`, `rp_emailid`, `rp_password` 
 FROM `representative` 
 inner join teamleader on teamleader.tl_id=representative.tl_id
inner join district on teamleader.dt_id=district.dt_id where rp_id=".$_GET['rp_id'];
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
        font-size:x-small;

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
                     <div class="col-md-6 offset-md-3">
                        <?php
                            if(!empty($_GET['msg'])&& $_GET['msg']=="saved" ){
                        ?>
                        <div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">
                            <span class="badge badge-pill badge-primary">Success</span>
                                Representative Successfully Created
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                        }
                        ?> 
                        <div class="card">
                            <form action="sqlprocess/representative_sql_process.php" method="post" autocomplete="off" >
                                <?php 
                                if(empty($_GET['rp_id'])){
                                ?>
                                <div class="card-header">
                                    <strong class="card-title">New Representative</strong>
                                    <a href="list_representatives.php" class="btn btn-sm btn-outline-primary pull-right"><i class="fa fa-group"></i>&nbsp; List Representative</a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="st_id" class="control-label mb-1">Select State</label>
                                                <select name="st_id" id="st_id" class="form-control">
                                                <?php
                                                $select="SELECT `st_id`, `na_id`, `st_name` FROM `state`";
                                                $data=database::SelectData($select);
                                                while($row1=mysqli_fetch_array($data)) {
                                                ?>
                                                <option value="<?php echo $row1['st_id']; ?>"><?php echo $row1['st_name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="dt_id" class="control-label mb-1">Select District</label>
                                                <select name="dt_id" id="dt_id" class="form-control">
                                                    <option value="">Please Select Any State</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="tl_id" class="control-label mb-1">Select Team Leader</label>
                                                <select name="tl_id" id="tl_id" class="form-control">
                                                    <option value="">Please Select Team Leader</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group" style='position:relative;'>
                                                <span id="py_email_valid" style=""></span>
                                                <label for="ur_email" class="control-label mb-1">Email ID</label>
                                                <input id="ur_email" name="rp_emailid" type="email" placeholder="email id to representative(username)" class="form-control" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group" style='position:relative;'>
                                                <label for="rp_password" class="control-label mb-1">Password</label>
                                                <input id="rp_password" name="rp_password" type="password" placeholder="set password for representative" class="form-control" autocomplete="off" required/>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="rp_repfirstname" class="control-label mb-1">First Name</label>
                                                <input id="rp_repfirstname" name="rp_repfirstname" type="text" placeholder="first name of representative" class="form-control" required/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="rp_replastname" class="control-label mb-1">Last Name</label>
                                                <input id="rp_replastname" name="rp_replastname" type="text" placeholder="last name of representative" class="form-control" required/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" style='margin-bottom:15px;'>
                                        <div class="col-6">
                                        <div class="form-group">
                                            <label for="rp_gender" class="control-label mb-1">Select Gender</label>
                                            <select name="rp_gender" id="rp_gender" class="form-control">
                                                <option value="MALE">MALE</option>
                                                <option value="FEMALE">FEMALE</option>
                                            </select>
                                        </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group" style='position:relative;'>
                                                <span id="py_ur_mobile" style=""></span>
									           <label for="ur_mobile" class="control-label mb-1">Mobile Number</label>
                                                <input id="ur_mobile" name="rp_mobilenumber"  type="text" placeholder="mobile number of the representative" class="form-control" autocomplete="off" required/>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <button id="btn_save" type="submit" class="btn btn-md btn-info  pull-right ">
                                    <i class="fa fa-check"></i>&nbsp;Save
                                    </button>
                                    <a href="manage_representatives.php" class="btn btn-md btn-outline-secondary"><i class="ti-close"></i>&nbsp; Cancel</a>
                                    <input name="rp_id" id="rp_id" value="0" type="hidden" required/>
                               
                                </div>
                                <?php 
                                }
                                else{
                                ?>
                                <div class="card-header">
                                     <?php
                                    if(($_GET['mode'])=="edit"){
                                    ?>
                                     <strong class="card-title">Edit Representative</strong>
                                     <?php
                                    }
                                    else if(($_GET['mode'])=="delete"){
                                    ?>
                                     <strong class="card-title">Delete Representative</strong>
                                      <?php
                                    }
                                   
                                    ?>
                                   
                                    <a href="list_representatives.php" class="btn btn-sm btn-outline-primary pull-right"><i class="fa fa-group"></i>&nbsp; List Representatives</a>
                                </div>
                                <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="st_id" class="control-label mb-1">Select State</label>
                                            <select name="st_id" id="st_id" class="form-control">
                                            <?php
                                            $select="SELECT `st_id`, `na_id`, `st_name` FROM `state`";
                                            $data=database::SelectData($select);
                                            while($row1=mysqli_fetch_array($data)) {
                                            ?>
                                            <option value="<?php echo $row1['st_id']; ?>" <?php echo  ($row['st_id']==$row1['st_id'])?'selected':''; ?> ><?php echo $row1['st_name']; ?> </option>
                                            <?php
                                            }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="dt_id" class="control-label mb-1">Select District</label>
                                            <select name="dt_id" id="dt_id" class="form-control">
                                                <?php
                                                $select="SELECT `dt_id`, `st_id`, `na_id`, `dt_name`, `dt_pincode` FROM `district` where st_id=".$row['st_id'];
                                                $data=database::SelectData($select);
                                                while($row1=mysqli_fetch_array($data)) {
                                                ?>
                                                <option value="<?php echo $row1['dt_id']; ?>" <?php echo  ($row['dt_id']==$row1['dt_id'])?'selected':''; ?> ><?php echo $row1['dt_name']; ?> </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="tl_id" class="control-label mb-1">Select Team Leader</label>
                                            <select name="tl_id" id="tl_id" class="form-control">
                                                <option value="">Please Select Team Leader</option>
                                                <?php
                                                $select="SELECT `tl_id`, `tl_firstname`, `tl_lastname` FROM `teamleader` where dt_id=".$row['dt_id'];
                                                $data=database::SelectData($select);
                                                while($row1=mysqli_fetch_array($data)) {
                                                ?>
                                                <option value="<?php echo $row1['tl_id']; ?>" <?php echo  ($row['tl_id']==$row1['tl_id'])?'selected':''; ?> ><?php echo $row1['tl_firstname']; ?> <?php echo $row1['tl_lastname']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group" style='position:relative;'>
                                            <span id="py_email_valid" style=""></span>
                                            <label for="ur_email" class="control-label mb-1">Email ID</label>
                                            <input id="ur_email" name="rp_emailid" type="email" value="<?php echo $row['rp_emailid']; ?>"  placeholder="email id to representative(username)" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" style='position:relative;'>
                                            <label for="rp_password" class="control-label mb-1">Password</label>
                                            <input id="rp_password" name="rp_password" type="password" value="<?php echo $row['rp_password']; ?>" placeholder="set password for representative" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="rp_repfirstname" class="control-label mb-1">First Name</label>
                                            <input id="rp_repfirstname" name="rp_repfirstname"  value="<?php echo $row['rp_repfirstname']; ?>" type="text" placeholder="first name of representative" class="form-control" required/>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="rp_replastname" class="control-label mb-1">Last Name</label>
                                            <input id="rp_replastname" name="rp_replastname"  value="<?php echo $row['rp_replastname']; ?>" type="text" placeholder="last name of representative" class="form-control" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style='margin-bottom:15px;'>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="rp_gender" class="control-label mb-1">Select Gender</label>
                                            <select name="rp_gender" id="rp_gender" class="form-control">
                                                <option value="MALE" <?php echo  ($row['rp_gender']=='MALE')?'selected':''; ?>>MALE</option>
                                                <option value="FEMALE" <?php echo  ($row['rp_gender']=='FEMALE')?'selected':''; ?>>FEMALE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group" style='position:relative;'>
                                            <span id="py_ur_mobile" style=""></span>
                                            <label for="ur_mobile" class="control-label mb-1">Mobile Number</label>
                                            <input id="ur_mobile" name="rp_mobilenumber" value="<?php echo $row['rp_mobilenumber']; ?>"   type="text" placeholder="mobile number of the representative" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
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
                                     <a id="btn_save" href='sqlprocess/representative_sql_process.php?rp_id=<?php echo $row['rp_id']; ?>' class="btn btn-md btn-danger  pull-right ">
                                        <i class="fa fa-cut"></i>&nbsp;
                                        <span id="payment-button-amount">Delete</span>
                                    </a>
                                    <?php
                                    }
                                    ?>
                                    <a href="list_representatives.php" class="btn btn-md btn-outline-secondary"><i class="ti-close"></i>&nbsp; Cancel</a>
                                    <input name="rp_id" id="rp_id" value="<?php echo $row['rp_id']; ?>" type="hidden" required/>
                               
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
    <script type="text/javascript">
	    $(document).ready(function(){
			$("#st_id").change(function(){
				var id=$(this).val();
				var dataString = 'st_id='+id;
				$.ajax({
					type: "POST",
					url: "ajax/manage_districts.php",
					data: dataString,
					cache: false,
					success: function(html){
                    	$("#dt_id").html(html);
				    } 
				});
			});
            $("#dt_id").change(function(){
				var id=$(this).val();
				var dataString = 'dt_id='+id;
				$.ajax({
					type: "POST",
					url: "ajax/manage_teamleaders.php",
					data: dataString,
					cache: false,
					success: function(html){
                    	$("#tl_id").html(html);
				    } 
				});
			});
		});
    </script>
    <script>
			$(document).ready(function(){
			var typingTimer;   
			var doneTypingInterval = 800;
            <?php
            if(!empty($_GET['tl_id'])){
            ?>
            window.emailflag=true;
            window.mobileflag=true;
            <?php
            }
            else{
            ?>
            window.emailflag=false;
            window.mobileflag=false;
            <?php
            }
            ?>
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
			function email_validation(){
                $('#py_email_valid').css("display","inline");
				var ur_email = $("#ur_email").val();
                var tl_id = $("#tl_id").val();
				if(ur_email.length >= 5 && validateEmail(ur_email) ){
					document.getElementById('py_email_valid').innerHTML="<span style='color:orange;'>checking availability...</span>";
					$.ajax({
						type: "POST",  
						url: "sqlprocess/representativeemailid_checking_sql_process.php",  
						data: "ur_email="+ur_email+"&tl_id="+tl_id,
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
            function mobile_validation(){
                $('#py_ur_mobile').css("display","inline");
				var ur_mobile = $("#ur_mobile").val();
                var tl_id = $("#tl_id").val();
				if(ur_mobile.length >= 10 && validateMobile(ur_mobile) ){
					document.getElementById('py_ur_mobile').innerHTML="<span style='color:orange;'>checking availability...</span>";
					$.ajax({
						type: "POST",  
						url: "sqlprocess/representativemobile_checking_sql_process.php",  
						data: "ur_mobile="+ur_mobile+"&tl_id="+tl_id,
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
            function validateEmail($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test( $email );
            }
            function validateMobile($mobile) {
            var mobileReg = /^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[789]\d{9}$/;
            return mobileReg.test( $mobile );
            }
            function finalvalidate(){
                if(window.emailflag==true && window.mobileflag==true ) {
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
