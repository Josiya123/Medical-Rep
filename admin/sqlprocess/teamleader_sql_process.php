<?php
ob_start();
include_once("../database.php");
$tl_id=$_POST['tl_id'];
$dt_id=$_POST['dt_id'];
$tl_emailid=$_POST['tl_emailid'];
$tl_password=$_POST['tl_password'];
$tl_firstname=$_POST['tl_firstname'];
$tl_lastname=$_POST['tl_lastname'];
$tl_gender=$_POST['tl_gender'];
$tl_mobilenumber=$_POST['tl_mobilenumber'];
if(empty($_GET['tl_id']) && $tl_id==0){
  $query="INSERT INTO `teamleader`(`dt_id`, `tl_emailid`,  `tl_firstname`, 
  `tl_password`, `tl_lastname`, `tl_gender`,tl_mobilenumber) 
  VALUES ('$dt_id','$tl_emailid','$tl_firstname','$tl_password','$tl_lastname','$tl_gender','$tl_mobilenumber')";
  database::ExecuteQuery($query);
  ob_clean();
  header("location:../manage_teamleadrs.php?msg=saved");
}
else if(empty($_GET['tl_id']) && $tl_id!=0){
$query="update teamleader set dt_id='$dt_id',tl_emailid='$tl_emailid'
,tl_firstname='$tl_firstname',tl_password='$tl_password',tl_lastname='$tl_lastname',tl_gender='$tl_gender'
,tl_mobilenumber='$tl_mobilenumber' where tl_id=$tl_id";
database::ExecuteQuery($query);
ob_clean();
header("location:../list_teamleadrs.php?msg=edited");
}
else if(!empty($_GET['tl_id']))
{
$query="delete from teamleader where tl_id=".$_GET['tl_id'];
database::ExecuteQuery($query);
ob_clean();
header("location:../list_teamleadrs.php?msg=deleted");
}
?>