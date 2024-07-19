<?php
include_once('security_check_admin.php');
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
    $currentmenu="representative";
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
                            <strong class="card-title">Representatives</strong>
                            <a href="manage_representatives.php" class="btn btn-sm btn-outline-primary pull-right"><i class="menu-icon fa fa-briefcase"></i>&nbsp; New Representative</a>
                        </div>
                        <div class="card-body">
                  <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Representative</th>
                        <th>Team Leader</th>
                        <th>Mobile Number</th>
                        <th>Email ID</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once("database.php");
                        $select="SELECT `rp_id`, `rp_repfirstname`, `rp_replastname`, `rp_mobilenumber`, `rp_emailid`,tl_firstname,tl_lastname
                        FROM `representative` inner join teamleader on teamleader.tl_id=representative.tl_id";
                        $data=database::SelectData($select);
                        while($row=mysqli_fetch_array($data)) {
                        ?>
                      <tr>
                      <td><?php echo $row['rp_repfirstname'];  ?> <?php echo $row['rp_replastname'];  ?></td>
                        <td><?php echo $row['tl_firstname'];  ?> <?php echo $row['tl_lastname'];  ?></td>
                        <td><?php echo $row['rp_mobilenumber'];  ?></td>
                        <td><?php echo $row['rp_emailid'];  ?></td>
                    
                        <td class="text-right" style='width:249px;'>
						<a href="list_duty_report.php?rp_id=<?php echo $row['rp_id']; ?>&rp_name=<?php echo $row['rp_repfirstname'];  ?> <?php echo $row['rp_replastname'];  ?>" class="btn btn-success btn-sm">Duty Report</a>
                        
                        <a href="manage_representatives.php?mode=edit&rp_id=<?php echo $row['rp_id']; ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-clipboard"></i>&nbsp; Edit</a>
                        <a href="manage_representatives.php?mode=delete&rp_id=<?php echo $row['rp_id']; ?>" class="btn btn-outline-danger btn-sm"><i class="fa fa-cut"></i>&nbsp; Delete</a>
                                              
                        </td>
                      </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
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
