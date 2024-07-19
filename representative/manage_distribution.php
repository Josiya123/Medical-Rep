<?php
include_once('security_check_representative.php');
include_once("database.php");
$select="select case when sum(rf_qty) is null then 0 when sum(rf_qty)  is not null then sum(rf_qty) end as totalinward  from representative_stock where rp_id=".$_COOKIE['mr_urid']." and pr_id=".$_GET['pr_id']." and rf_type='INWARD'";
$data1=database::SelectData($select);
$totalinward=mysqli_fetch_array($data1);
$select="select case when sum(rf_qty) is null then 0 when sum(rf_qty)  is not null then sum(rf_qty) end as totaloutward  from representative_stock where rp_id=".$_COOKIE['mr_urid']." and pr_id=".$_GET['pr_id']." and rf_type='OUTWARD'";
$data1=database::SelectData($select);
$totaloutward=mysqli_fetch_array($data1);
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
    $currentmenu="stock";
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
                                Distribution Successfully Done
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                        }
						else   if(!empty($_GET['msg'])&& $_GET['msg']=="notsaved" ){
                        ?> 
						 <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                            <span class="badge badge-pill badge-danger">Failed</span>
                                Quantity is greater than available quantity
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
						<?php
                        }
                        ?> 
                        <div class="card">
                             <form action="sqlprocess/distribute_sql_process.php" method="post" autocomplete="off" >
                                <?php 
                                if(empty($_GET['cs_id'])){
                                ?>
                                <div class="card-header">
                                    <strong class="card-title">New Distribution</strong>
                                    <a href="list_distribution.php?hp_id=<?php echo $_GET['hp_id']; ?>" class="btn btn-sm btn-outline-primary pull-right"><i class="fa fa-angle-left"></i>&nbsp; Back</a>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="rf_qty" class="control-label mb-1">Quantity to Distribute (Strips / bottles / Piece )</label>
                                        <input id="rf_qty" name="rf_qty" type="number" placeholder="quantity" class="form-control" required />
                                    </div>
									<div class="form-group">
                                        <label for="rf_qty1" class="control-label mb-1">Available Quantity</label>
                                        <input value="<?php echo $totalinward['totalinward'] -$totaloutward['totaloutward']; ?>" id="rf_qty1" name="rf_qty1" type="number" placeholder="quantity" class="form-control" required readonly />
                                    </div>
									<div class="form-group">
                                            <label for="pr_id" class="control-label mb-1">Product</label>
                                            <select name="pr_id" id="pr_id" class="form-control" readonly>
                                            <?php
                                           
                                            $select="SELECT `pr_id`, `pt_id`, `pr_name` FROM `products` where pr_id=".$_GET['pr_id'];
                                            $data=database::SelectData($select);
                                            while($row1=mysqli_fetch_array($data)) {
                                            ?>
                                            <option value="<?php echo $row1['pr_id']; ?>" <?php echo  ($row1['pr_id']==$_GET['pr_id'])?'selected':''; ?>><?php echo $row1['pr_name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                            </select>
                                    </div>
                                    <button type="submit" class="btn btn-md btn-info pull-right ">
                                    <i class="fa fa-check"></i>&nbsp;Save
                                    </button>
                                    <a href="list_distribution.php?hp_id=<?php echo $_GET['hp_id']; ?>" class="btn btn-md btn-outline-secondary"><i class="ti-close"></i>&nbsp; Cancel</a>
                                    <input name="cs_id" id="cs_id" value="0" type="hidden" required/>
									 <input name="hp_id" id="hp_id" value="<?php echo $_GET['hp_id']; ?>" type="hidden" required/>
                                </div>
                                <?php 
                                }
                                else{
								$select="SELECT `cs_id`, `pr_id`, `hp_id`, `rf_id`, `rf_qty`, `rf_type`, `rf_date` 
								FROM `client_stock`  where cs_id=".$_GET['cs_id'];
								$data=database::SelectData($select);
								$row2=mysqli_fetch_array($data);								
                                ?>
                                <div class="card-header">
                                    <strong class="card-title">Delete Distribution</strong>
                                    <a href="list_stock1.php?pr_id=<?php echo $row2['pr_id']; ?>&hp_id=<?php echo $_GET['hp_id']; ?>" class="btn btn-sm btn-outline-primary pull-right"><i class="fa fa-angle-left"></i>&nbsp; Back</a>
                                </div>
                                <div class="card-body">
									<div class="form-group">
                                        <label for="rf_qty" class="control-label mb-1">Quantity to Distribute (Strips / bottles / Piece )</label>
                                        <input value="<?php echo $row2['rf_qty']; ?>" id="rf_qty" name="rf_qty" type="number" placeholder="quantity" class="form-control" readonly required/>
                                    </div>
									<div class="form-group">
                                            <label for="pr_id" class="control-label mb-1">Product</label>
                                            <select name="pr_id" id="pr_id" class="form-control" readonly>
                                            <?php
                                           
                                            $select="SELECT `pr_id`, `pt_id`, `pr_name` FROM `products` where pr_id=".$_GET['pr_id'];
                                            $data=database::SelectData($select);
                                            while($row1=mysqli_fetch_array($data)) {
                                            ?>
                                            <option value="<?php echo $row1['pr_id']; ?>" ><?php echo $row1['pr_name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                            </select>
                                    </div>
									<a href="list_stock1.php?pr_id=<?php echo $row2['pr_id']; ?>&hp_id=<?php echo $_GET['hp_id']; ?>" class="btn btn-md btn-outline-secondary"><i class="ti-close"></i>&nbsp; Cancel</a>
                                
                                    <a href="sqlprocess/distribute_sql_process.php?cs_id=<?php echo $row2['cs_id']; ?>&pr_id=<?php echo $row2['pr_id']; ?>&hp_id=<?php echo $_GET['hp_id']; ?>" class="btn btn-md btn-info pull-right ">
                                    <i class="fa fa-check"></i>&nbsp;Delete
                                    </a>
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
    
</body>
</html>
