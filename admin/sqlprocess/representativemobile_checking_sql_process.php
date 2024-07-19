<?php
ob_start();
	include_once '../database.php';
	ob_clean();
	if((isset($_POST["ur_mobile"]) && !empty($_POST["ur_mobile"]))) {
		mailcheck(); 
	}
	function mailcheck(){
		$ur_mobile=$_POST["ur_mobile"];
		$rp_id=$_POST["rp_id"];
		if(database::RowExists("representative","rp_mobilenumber='$ur_mobile' and rp_id!=$rp_id")){
			echo "exsists";
		}
		else{
			echo "notexsists";
		}
	}
?>