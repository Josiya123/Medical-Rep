<?php
ob_start();
include_once("../database.php");
$dc_id=$_POST['dc_id'];
$dc_name=$_POST['dc_name'];
$dc_emailid=$_POST['dc_emailid'];
$tl_id=$_COOKIE['mr_urid'];

$dc_speciality=$_POST['dc_speciality'];
if(empty($_GET['dc_id'])&& $dc_id==0)
{
  $query="INSERT INTO `doctors`(`dc_name`, `dc_emailid`,dc_speciality,tl_id) 
  VALUES ('$dc_name','$dc_emailid','$dc_speciality',$tl_id)";
  database::ExecuteQuery($query);
  ob_clean();
  header("location:../manage_doctors.php?msg=saved");
}
else if(empty($_GET['dc_id'])&& $dc_id!=0)
{
$query="update doctors set dc_name='$dc_name',dc_emailid='$dc_emailid',dc_speciality='$dc_speciality'  where dc_id=$dc_id";
database::ExecuteQuery($query);
ob_clean();
header("location:../list_doctors.php?msg=edited");
}
else if(!empty($_GET['dc_id']))
{
$query="delete from doctors where dc_id=".$_GET['dc_id'];
database::ExecuteQuery($query);
ob_clean();
header("location:../list_doctors.php?msg=deleted");
}

?>