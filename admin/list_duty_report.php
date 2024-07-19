<?php
include_once('security_check_admin.php');
include_once("database.php");
$rp_id=$_GET['rp_id'];
$rp_name=$_GET['rp_name'];
$select="SELECT distinct rd_dutydate from
`representative_duty` where rp_id=$rp_id";
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
                    
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <strong class="card-title">Duties @ <span class="text-danger"><?php echo $rp_name; ?></span></strong>
							<a href="list_representatives.php" class="btn btn-sm btn-outline-secondary pull-right" style='margin-left:10px;height:40px;padding:auto;padding-top:10px;'>&nbsp;<i class="fa fa-chevron-left"></i>&nbsp;</a>
                        </div>
                        <div class="card-body">
                  <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Date</th>
						<th>Total Dutie</th>
						<th>Completed</th>
						<th>Not Completed</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once("database.php");
                        while($row=mysqli_fetch_array($myduties)) {
							$total_duties=DataBase::RowCount("select count(*) from `representative_duty` where rd_dutydate='".$row['rd_dutydate']."' and rp_id=$rp_id");
							$completed_duties=DataBase::RowCount("select count(*) from `representative_duty` where rd_status='finish' and rd_dutydate='".$row['rd_dutydate']."' and rp_id=$rp_id");
                       
						?>
						<tr>
							<td><?php echo $row['rd_dutydate'];  ?></td>
							<td><?php echo $total_duties;  ?></td>
							<td><?php echo $completed_duties;  ?></td>
							<td><?php echo $total_duties-$completed_duties;  ?></td>
							<td class="text-right" style='width:149px;'>
								<a href="progress_duty_map_1.php?rd_dutydate=<?php echo $row['rd_dutydate'];  ?>&rp_id=<?php echo $rp_id; ?>&rp_name=<?php echo $rp_name; ?>" class="btn btn-outline-primary btn-sm">View Duties</a>
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
