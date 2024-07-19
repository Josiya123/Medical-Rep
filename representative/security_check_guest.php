<?php
if(!empty($_COOKIE["mr_usertype"]) && $_COOKIE["mr_usertype"]=='representative') 
{
	header("location:progress_duty_map.php?rd_dutydate=".date("Y-m-d"));	
}
?>
	
	
