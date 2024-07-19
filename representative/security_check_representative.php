<?php
if(empty($_COOKIE["mr_usertype"]) && $_COOKIE["mr_usertype"]!='representative')
{
header('location:index.php');	
}
?>
	
	
