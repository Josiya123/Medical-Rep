<?php
ob_start();
include_once 'database.php';
include_once('security_check_guest.php');
$query="SELECT `tl_id`, `dt_id`, `tl_emailid`, `tl_password`, `tl_firstname`, `tl_lastname`, `tl_gender`, `tl_mobilenumber`
 FROM `teamleader`  where tl_emailid='".$_POST['lg_username']."' AND tl_password='".$_POST['lg_password']."'";
$data=database::SelectData($query);
if(mysqli_num_rows($data)!=0){
	$user = mysqli_fetch_array($data);
	setcookie("mr_urid",$user['tl_id'], time() + (60*60*24*30));
	setcookie("mr_usertype","teamleader", time() + (60*60*24*30));
	ob_clean();
	header('location:list_representatives.php');	
}
else{
	ob_clean();
	header('location:index.php?status=failed');	
}
?>