<?php
	ob_start();
	include_once '../database.php';
	ob_clean();
	if((isset($_POST["ur_email"]) && !empty($_POST["ur_email"]))) {
		mailcheck(); 
	}
	function mailcheck(){
		$ur_email=$_POST["ur_email"];
		$hp_id=$_POST["hp_id"];
		if(database::RowExists("hospitals","hp_emailid='$ur_email' and hp_id!=$hp_id")){
			echo "exsists";
		}
		else{
			echo "notexsists";
		}
	}
?>