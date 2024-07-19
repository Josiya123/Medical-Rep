<?php
	ob_start();
	include_once '../database.php';
	ob_clean();
	if((isset($_POST["ur_email"]) && !empty($_POST["ur_email"]))) {
		mailcheck(); 
	}
	function mailcheck(){
		$ur_email=$_POST["ur_email"];
		$dc_id=$_POST["dc_id"];
		if(database::RowExists("doctors","dc_emailid='$ur_email' and dc_id!=$dc_id")){
			echo "exsists";
		}
		else{
			echo "notexsists";
		}
	}
?>