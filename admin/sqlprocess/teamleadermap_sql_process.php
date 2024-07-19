<?php
ob_start();
include_once("../database.php");
ob_clean();
if(empty($_GET['tl_id'])){
$tl_id=$_POST['tl_id'];
$mapinfo=$_POST['mapinfo'];

$coordinates = explode("<>", $mapinfo);
}

if(empty($_GET['tl_id']) && $tl_id!=0){
  $query="DELETE FROM `teamleader_maparea`  where tl_id=$tl_id";
  database::ExecuteQuery($query);
foreach($coordinates as $point){
  $xy = explode(",", $point);
  if(count($xy)==2){
$query="INSERT INTO `teamleader_maparea`(`tl_id`, `tm_lat`, `tm_lng`) VALUES ($tl_id,".$xy[0].",".$xy[1].")";
database::ExecuteQuery($query);
  }
}
ob_clean();
header("location:../manage_teamleadrs_map.php?msg=saved&tl_id=$tl_id");
}
else if(!empty($_GET['tl_id']) ){
  $tl_id=$_GET['tl_id'];
  $query="DELETE FROM `teamleader_maparea`  where tl_id=$tl_id";
  database::ExecuteQuery($query);
  ob_clean();
  header("location:../manage_teamleadrs_map.php?msg=saved&tl_id=$tl_id");
}

?>