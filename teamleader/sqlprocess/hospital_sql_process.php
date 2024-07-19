<?php
ob_start();
include_once("../database.php");
$hp_id=$_POST['hp_id'];
$hp_name=$_POST['hp_name'];
$hp_code=$_POST['hp_code'];
$hp_mobilenumber=$_POST['hp_mobilenumber'];
$hp_emailid=$_POST['hp_emailid'];
$hp_weburl=$_POST['hp_weburl'];
$hp_landline=$_POST['hp_landline'];
$hp_type=$_POST['hp_type'];
$tl_id=$_COOKIE['mr_urid'];
if(empty($_GET['hp_id'])&& $hp_id==0)
{
  $query="INSERT INTO `hospitals`(`hp_name`, `hp_code`, `hp_address`, `hp_emailid`, 
  `hp_mobilenumber`, `hp_weburl`, `hp_landline`, `hp_lat`, `hp_lon`,hp_type,tl_id) 
  VALUES ('$hp_name','$hp_code','$hp_address','$hp_emailid','$hp_mobilenumber','$hp_weburl','$hp_landline',0,0,'$hp_type',$tl_id)";
  database::ExecuteQuery($query);
  ob_clean();
  header("location:../manage_hospitals.php?msg=saved");
}
else if(empty($_GET['hp_id'])&& $hp_id!=0)
{
$query="update hospitals set hp_name='$hp_name',hp_code='$hp_code',hp_address='$hp_address'
,hp_emailid='$hp_emailid',hp_mobilenumber='$hp_mobilenumber',hp_weburl='$hp_weburl',hp_landline='$hp_landline'
,hp_type='$hp_type'  where hp_id=$hp_id";
database::ExecuteQuery($query);
ob_clean();
header("location:../list_hospitals.php?msg=edited");
}
else if(!empty($_GET['hp_id']))
{
$query="delete from hospitals where hp_id=".$_GET['hp_id'];
database::ExecuteQuery($query);
ob_clean();
header("location:../list_hospitals.php?msg=deleted");
}

?>