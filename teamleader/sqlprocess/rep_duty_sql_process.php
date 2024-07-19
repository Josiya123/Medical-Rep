<?php
ob_start();
include_once("../database.php");
$rd_id=$_POST['rd_id'];
$rp_id=$_POST['rp_id'];
$mt_id=$_POST['mt_id'];
$pr_id=$_POST['pr_id'];
$hp_id=$_POST['hp_id'];
$dc_id=$_POST['dc_id'];
$rd_dutydate=$_POST['rd_dutydate'];
$rd_dutydescription=$_POST['rd_dutydescription'];
$rd_dutylocation=$_POST['rd_dutylocation'];
$xy = explode(",", $rd_dutylocation);

if(empty($_GET['rd_id'])&& $rd_id==0)
{

  $query="INSERT INTO `representative_duty`( `rp_id`, `rd_dutydate`, 
  `rd_dutydescription`, `rd_lat`, `rd_lng`,rd_status,mt_id,pr_id,hp_id,dc_id) 
  VALUES  ('$rp_id','$rd_dutydate','$rd_dutydescription','$xy[0]','$xy[1]','new','$mt_id','$pr_id','$hp_id','$dc_id')";
  database::ExecuteQuery($query);
  ob_clean();
  header("location:../assign_duty_map.php?rp_id=$rp_id&msg=saved&rd_dutydate=$rd_dutydate");
}

else if(empty($_GET['rd_id'])&& $rd_id!=0)
{
$query="delete from representative_duty where rd_id=$rd_id";
database::ExecuteQuery($query);
ob_clean();
header("location:../assign_duty_map.php?rp_id=$rp_id&msg=deleted&rd_dutydate=$rd_dutydate");
}

?>