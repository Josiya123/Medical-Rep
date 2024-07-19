<?php
ob_start();
	include_once '../database.php';
	ob_clean();
	if((isset($_POST["ur_email"]) && !empty($_POST["ur_email"]))) {
		mailcheck(); 
	}
	function mailcheck(){
		$ur_email=$_POST["ur_email"];
		$tl_id=$_POST["tl_id"];
		if(database::RowExists("teamleader","tl_emailid='$ur_email' and tl_id!=$tl_id")){
			echo "exsists";
		}
		else{
			echo "notexsists";
		}
	}
?>