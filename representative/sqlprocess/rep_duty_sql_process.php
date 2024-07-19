<?php
ob_start();
include_once("../database.php");
var_dump($_POST);
$rd_id=$_POST['rd_id'];
$rd_dutydate=$_POST['rd_dutydate'];
$rd_status=$_POST['rd_status'];
if($rd_status=='new'){
$query="UPDATE `representative_duty` SET rd_status='checkin', rd_checkindate=CURDATE(),rd_checkintime=CURTIME() where rd_id=$rd_id";
}
else if($rd_status=='checkin'){
  $query="UPDATE `representative_duty` SET rd_status='checkout', rd_checkoutdate=CURDATE(),rd_checkouttime=CURTIME() where rd_id=$rd_id";
}
else if($rd_status=='checkout'){
  $query="UPDATE `representative_duty` SET rd_status='finish', rd_feedback='".$_POST['rd_feedback']."', rd_feedbackdate=CURDATE(),rd_feedbacktime=CURTIME() where rd_id=$rd_id";
}
database::ExecuteQuery($query);
ob_clean();
header("location:../progress_duty_map.php?rd_dutydate=$rd_dutydate");	

?>