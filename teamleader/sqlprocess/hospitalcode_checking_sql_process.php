<?php
	ob_start();
	include_once '../database.php';
	ob_clean();
	if((isset($_POST["ur_code"]) && !empty($_POST["ur_code"]))) {
		mailcheck(); 
	}
	function mailcheck(){
		$ur_code=$_POST["ur_code"];
		$hp_id=$_POST["hp_id"];
		if(database::RowExists("hospitals","hp_code='$ur_code' and hp_id!=$hp_id")){
			echo "exsists";
		}
		else{
			echo "notexsists";
		}
	}
?>