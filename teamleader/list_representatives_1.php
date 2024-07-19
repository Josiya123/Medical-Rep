<?php
include_once('security_check_teamleader.php');
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
</head>
<body>
    <?php
    $currentmenu="dutyprogress";
     include_once('left_nav.php');
    ?>
    <div id="right-panel" class="right-panel">
        <?php include_once('top_header.php'); ?>   
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                
                <div class="col-md-12">
                    <?php
                        if(!empty($_GET['msg'])&& $_GET['msg']=="edited" ){
                    ?>
                    <div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">
                        <span class="badge badge-pill badge-primary">Success</span>
                            Representative Successfully Edited
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                        }
                        if(!empty($_GET['msg'])&& $_GET['msg']=="deleted" ){
                    ?>
                      <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        <span class="badge badge-pill badge-danger">Success</span>
                            Representative Successfully Deleted
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                    <?php
                        }
                    ?> 
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Duties of My Representatives</strong>
                        </div>
                        <div class="card-body">
                            <?php
                            include_once("database.php");
                            $select="SELECT `rp_id`, `rp_repfirstname`, `rp_replastname`, `rp_mobilenumber`, `rp_emailid`
                            FROM `representative` where tl_id=".$_COOKIE['mr_urid'];
                            $data=database::SelectData($select);
                            while($row=mysqli_fetch_array($data)) {
                            ?>
                            <div class="col-md-4">
                                <div class="card">
                            
                                    <div class="card-body">
                                        <div class="mx-auto d-block">
                                            <h5 class="text-sm-center mt-2 mb-1"><?php echo $row['rp_repfirstname'];  ?> <?php echo $row['rp_replastname'];  ?></h5>
                                            <div class="location text-sm-center"><i class="fa fa-phone-square"></i> <?php echo $row['rp_mobilenumber'];  ?></div>
                                            <div class="location text-sm-center"><i class="fa fa-envelope-o"></i> <?php echo $row['rp_emailid'];  ?></div>
                                        </div>
                                        <hr>
                                        <div class="card-text text-sm-center">
                                            <form action="progress_duty_map.php?mode=edit&rp_id=<?php echo $row['rp_id']; ?>" method="post">
                                                <div class="col-12">
                                                    <div class='form-group'>
                                                        <label for='rd_dutylocation' class='control-label mb-1'>Select Date And Check Duty progress</label>
                                                        <input name="rd_dutydate" type="date" class="form-control" required/>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-outline-danger btn-block btn-lg"><i class="fa  fa-exchange"></i>&nbsp; Duty Progress</button>
													<a href="list_duty_report.php?rp_id=<?php echo $row['rp_id']; ?>&rp_name=<?php echo $row['rp_repfirstname'];  ?> <?php echo $row['rp_replastname'];  ?>" class="btn btn-primary btn-block btn-lg"><i class="fa  fa-exchange"></i>&nbsp; Duty Report</a>
                                                </div>
                                            </form>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
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


</body>
</html>
