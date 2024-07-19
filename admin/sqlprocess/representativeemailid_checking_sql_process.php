<?php
ob_start();
	include_once '../database.php';
	ob_clean();
	if((isset($_POST["ur_email"]) && !empty($_POST["ur_email"]))) {
		mailcheck(); 
	}
	function mailcheck(){
		$ur_email=$_POST["ur_email"];
		$rp_id=$_POST["rp_id"];
		if(database::RowExists("representative","rp_emailid='$ur_email' and rp_id!=$rp_id")){
			echo "exsists";
		}
		else{
			echo "notexsists";
		}
	}
?>