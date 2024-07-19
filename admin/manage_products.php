<?php
include_once('security_check_admin.php');
include_once("database.php");
if(!empty($_GET['pr_id'])){

 $select="SELECT `pr_id`, `pt_id`, `pr_name` FROM `products` where pr_id=".$_GET['pr_id'];
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
    
</head>
<body>
    <?php
    $currentmenu="products";
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
                                Product Successfully Created
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                        }
                        ?> 
                        <div class="card">
                             <form action="sqlprocess/product_sql_process.php" method="post" autocomplete="off" >
                                <?php 
                                if(empty($_GET['pr_id'])){
                                ?>
                                <div class="card-header">
                                    <strong class="card-title">New Product</strong>
                                    <a href="list_products.php" class="btn btn-sm btn-outline-primary pull-right"><i class="fa fa-flask"></i>&nbsp; List Products</a>
                                </div>
                                <div class="card-body">
                               
                                    <div class="form-group">
                                        <label for="pr_name" class="control-label mb-1">Product Name</label>
                                        <input id="pr_name" name="pr_name" type="text" placeholder="name of product" class="form-control" required/>
                                    </div>
                                   
                                    <div class="form-group">
                                            <label for="pt_id" class="control-label mb-1">Product Type</label>
                                            <select name="pt_id" id="pt_id" class="form-control">
                                            <?php
                                           
                                            $select="SELECT `pt_id`, `pt_name` FROM `products_type`";
                                            $data=database::SelectData($select);
                                            while($row1=mysqli_fetch_array($data)) {
                                            ?>
                                            <option value="<?php echo $row1['pt_id']; ?>"><?php echo $row1['pt_name']; ?></option>
                                            <?php
                                            }
                                            ?>
                                            </select>
                                    </div>
                                    <button id="btn_save" type="submit" class="btn btn-md btn-info pull-right ">
                                    <i class="fa fa-check"></i>&nbsp;Save
                                    </button>
                                    <a href="manage_products.php" class="btn btn-md btn-outline-secondary"><i class="ti-close"></i>&nbsp; Cancel</a>
                                    <input name="pr_id" id="pr_id" value="0" type="hidden" required/>
                                </div>
                                <?php 
                                }
                                else{
                                ?>
                                <div class="card-header">
                                     <?php
                                    if(($_GET['mode'])=="edit"){
                                    ?>
                                     <strong class="card-title">Edit Product</strong>
                                     <?php
                                    }
                                    else if(($_GET['mode'])=="delete"){
                                    ?>
                                     <strong class="card-title">Delete Product</strong>
                                      <?php
                                    }
                                    ?>
                                   
                                    <a href="list_products.php" class="btn btn-sm btn-outline-primary pull-right"><i class="fa fa-flask"></i>&nbsp; List Products</a>
                                </div>
                                <div class="card-body">
                               
                                    <div class="form-group">
                                        <label for="pr_name" class="control-label mb-1">Product Name</label>
                                        <input id="pr_name" name="pr_name" value="<?php echo $row['pr_name']; ?>" type="text" placeholder="name of product" class="form-control" required/>
                                    </div>
                                   
                                    <div class="form-group">
                                            <label for="pt_id" class="control-label mb-1">Institution Type</label>
                                            <select name="pt_id" id="pt_id" class="form-control">
                                                <?php
                                             
                                                $select="SELECT `pt_id`, `pt_name` FROM `products_type`";
                                                $data=database::SelectData($select);
                                                while($row1=mysqli_fetch_array($data)) {
                                                ?>
                                                <option value="<?php echo $row1['pt_id']; ?>" <?php echo  ($row['pt_id']==$row1['pt_id'])?'selected':''; ?>><?php echo $row1['pt_name']; ?></option>
                                                <?php
                                                }
                                                ?>
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
                                     <a id="btn_save" href='sqlprocess/product_sql_process.php?pr_id=<?php echo $row['pr_id']; ?>' class="btn btn-md btn-danger  pull-right ">
                                        <i class="fa fa-cut"></i>&nbsp;Delete
                                    </a>
                                    <?php
                                    }
                                    ?>
                                    <a href="list_hospitals.php" class="btn btn-md btn-outline-secondary"><i class="ti-close"></i>&nbsp; Cancel</a>
                                    <input name="pr_id" id="pr_id" value="<?php echo $row['pr_id']; ?>" type="hidden" required/>
                               
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
