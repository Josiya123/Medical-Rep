<?php
ob_start();
include_once("../database.php");
$hp_id=$_POST['hp_id'];
$hospital_location=$_POST['hospital_location'];
$xy = explode(",", $hospital_location);
if(empty($_GET['hp_id'])&& $hp_id!=0)
{

  $query="update hospitals set hp_lat=".$xy[0]." ,hp_lon=".$xy[1]." where hp_id=$hp_id";
  database::ExecuteQuery($query);
  ob_clean();
  header("location:../manage_hospital_map.php?hp_id=$hp_id");
}
?>