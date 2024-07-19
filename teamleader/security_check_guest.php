<?php
if(!empty($_COOKIE["mr_usertype"]) && $_COOKIE["mr_usertype"]=='teamleader') 
{
header('location:list_representatives.php');
}
?>
	
	
