<?php
if(empty($_COOKIE["mr_usertype"]) && $_COOKIE["mr_usertype"]!='admin')
{
header('location:index.php');	
}
?>
	
	
