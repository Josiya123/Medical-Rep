<?php
class DataBase{
public static function ExecuteQuery($Query){
	$connection = mysqli_connect('localhost', 'root', '', 'medicalrep-stock');
	mysqli_query($connection, $Query) or die($Query);
	mysqli_close($connection);
}
public static function ExecuteQueryReturnID($Query){
	$connection = mysqli_connect('localhost', 'root', '', 'medicalrep-stock');
	mysqli_query($connection, $Query) or die($Query);
	$DataTable= mysqli_query($connection, "select @@identity as id") or die("0");
	mysqli_close($connection);
	$rows=mysqli_fetch_array($DataTable);
	return $rows["id"];
}
public static function SelectData($Query){
	$connection = mysqli_connect('localhost', 'root', '', 'medicalrep-stock');
	$DataTable= mysqli_query($connection, $Query) or die($Query);
	return $DataTable;
}
public static function RowExists($TableName,$Condition){
	$connection = mysqli_connect('localhost', 'root', '', 'medicalrep-stock');
	$DataTable= mysqli_query($connection, "select * from ".$TableName." where ".$Condition) or die("0");
	mysqli_close( $connection);
	if(mysqli_num_rows($DataTable)>0)
	{return true;}
	else
	{ return false;}
}
public static function RealEscape($text){
	$connection = mysqli_connect('localhost', 'root', '', 'medicalrep-stock');
	return mysqli_real_escape_string($connection,$text);
}
public static function RowCount($Query){
	$connection = mysqli_connect('localhost', 'root', '', 'medicalrep-stock');
	$DataTable= mysqli_query($connection, $Query) or die("0");
	mysqli_close( $connection);
	$rows=mysqli_fetch_array($DataTable);
	return  $rows[0];
}
}
?>