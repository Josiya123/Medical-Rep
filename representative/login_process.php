<?php
ob_start();
include_once ('security_check_guest.php');
include_once ('database.php');

$query="SELECT `rp_id`, `tl_id`, `rp_repfirstname`, `rp_replastname`, `rp_gender`, `rp_mobilenumber`, `rp_emailid`,
 `rp_password` FROM `representative` where rp_emailid='".$_POST['lg_username']."' AND rp_password='".$_POST['lg_password']."'";
$data=database::SelectData($query);
if(
mysqli_num_rows($data)!=0){$user=mysqli_fetch_array($data);
$today=date("Y-m-d");
setcookie("mr_urid",$user['rp_id'],time()+(60*60*24*30));
setcookie("mr_usertype","representative",time()+(60*60*24*30));
ob_clean();
header("location:progress_duty_map.php?rd_dutydate=$today");
/*echo	"<script type='text/javascript'>
location.href='progress_duty_map.php?rd_dutydate=".date("Y-m-d")."';
</script>";	*/
}
else{
    ob_clean();
header('location:index.php?status=failed');}

?>