<?php
ob_start();
include_once("../database.php");
$pr_id=$_POST['pr_id'];
$pt_id=$_POST['pt_id'];
$pr_name=$_POST['pr_name'];

if(empty($_GET['pr_id'])&& $pr_id==0)
{
  $query="INSERT INTO `products`(`pt_id`, `pr_name`) VALUES ('$pt_id','$pr_name')";
  database::ExecuteQuery($query);
  ob_clean();
  header("location:../manage_products.php?msg=saved");
}
else if(empty($_GET['pr_id'])&& $pr_id!=0)
{
$query="update products set pt_id='$pt_id',pr_name='$pr_name' where pr_id=$pr_id";
database::ExecuteQuery($query);
ob_clean();
header("location:../list_products.php?msg=edited");
}
else if(!empty($_GET['pr_id']))
{
$query="delete from products where pr_id=".$_GET['pr_id'];
database::ExecuteQuery($query);
ob_clean();
header("location:../list_products.php?msg=deleted");
}

?>