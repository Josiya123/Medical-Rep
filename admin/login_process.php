<?php
ob_start();
include_once 'database.php';
include_once('security_check_guest.php');
$query="SELECT `ad_id`, `ad_username`, `ad_password` from administrator where ad_username='".$_POST['lg_username']."' AND ad_password='".$_POST['lg_password']."'";
$data=database::SelectData($query);
if(mysqli_num_rows($data)!=0){
	$user = mysqli_fetch_array($data);
	setcookie("mr_urid",$user['ur_id'], time() + (60*60*24*30));
	setcookie("mr_usertype","admin", time() + (60*60*24*30));
	ob_clean();
	header('location:list_products.php');	
}
else{
	ob_clean();
	header('location:index.php?status=failed');	
}
?>