<?php
	ob_start();
	include_once '../database.php';
	ob_clean();
	if((isset($_POST["ur_mobile"]) && !empty($_POST["ur_mobile"]))) {
		mailcheck(); 
	}
	function mailcheck(){
		$ur_mobile=$_POST["ur_mobile"];
		$tl_id=$_POST["tl_id"];
		if(database::RowExists("teamleader","tl_mobilenumber='$ur_mobile' and tl_id!=$tl_id")){
			echo "exsists";
		}
		else{
			echo "notexsists";
		}
	}
?>