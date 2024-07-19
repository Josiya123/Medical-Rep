<?php
ob_start();
	include_once '../database.php';
	ob_clean();
	if((isset($_POST["ur_landline"]) && !empty($_POST["ur_landline"]))) {
		mailcheck(); 
	}
	function mailcheck(){
		$ur_landline=$_POST["ur_landline"];
		$hp_id=$_POST["hp_id"];
		if(database::RowExists("hospitals","hp_landline='$ur_landline' and hp_id!=$hp_id")){
			echo "exsists";
		}
		else{
			echo "notexsists";
		}
	}
?>