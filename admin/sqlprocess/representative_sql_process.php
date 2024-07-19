<?php
ob_start();
include_once("../database.php");
$tl_id=$_POST['tl_id'];
$rp_id=$_POST['rp_id'];
$rp_repfirstname=$_POST['rp_repfirstname'];
$rp_replastname=$_POST['rp_replastname'];
$rp_emailid=$_POST['rp_emailid'];
$rp_password=$_POST['rp_password'];
$rp_gender=$_POST['rp_gender'];
$rp_mobilenumber=$_POST['rp_mobilenumber'];
if(empty($_GET['rp_id']) && $rp_id==0){
  $query="INSERT INTO `representative`(`tl_id`, `rp_repfirstname`, `rp_replastname`, `rp_gender`, 
  `rp_mobilenumber`, `rp_emailid`, `rp_password`) VALUES
   ('$tl_id','$rp_repfirstname','$rp_replastname','$rp_gender','$rp_mobilenumber','$rp_emailid','$rp_password')";
  database::ExecuteQuery($query);
  ob_clean();
  header("location:../manage_representatives.php?msg=saved");
}
else if(empty($_GET['rp_id']) && $rp_id!=0){
$query="update representative set tl_id='$tl_id',rp_emailid='$rp_emailid'
,rp_repfirstname='$rp_repfirstname',rp_password='$rp_password',rp_replastname='$rp_replastname',rp_gender='$rp_gender'
,rp_mobilenumber='$rp_mobilenumber' where rp_id=$rp_id";
database::ExecuteQuery($query);
ob_clean();
header("location:../list_representatives.php?msg=edited");
}
else if(!empty($_GET['rp_id']))
{
$query="delete from representative where rp_id=".$_GET['rp_id'];
database::ExecuteQuery($query);
ob_clean();
header("location:../list_representatives.php?msg=deleted");
}
?>