<?php
	setcookie("mr_urid", "", time() - (60*60*24*30));
	setcookie("mr_usertype", "", time() - (60*60*24*30));	
	header('location:index.php');
?>