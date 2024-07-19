<?php
ob_start();
	include_once '../database.php';
	ob_clean();
	if((isset($_POST["ur_mobile"]) && !empty($_POST["ur_mobile"]))) {
		mailcheck(); 
	}
	function mailcheck(){
		$ur_mobile=$_POST["ur_mobile"];
		$hp_id=$_POST["hp_id"];
		if(database::RowExists("hospitals","hp_mobilenumber='$ur_mobile' and hp_id!=$hp_id")){
			echo "exsists";
		}
		else{
			echo "notexsists";
		}
	}
?>