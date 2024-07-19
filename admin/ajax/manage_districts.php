<?php
include_once('../database.php');
if(!empty($_POST['st_id'])){  
$st_id=$_POST['st_id'];
$data=DataBase::SelectData("SELECT `dt_id`,`st_id`,`na_id`,`dt_name`,`dt_pincode` FROM `district` 
where st_id=$st_id");
while($row1=mysqli_fetch_array($data)) {
?>
<option value="<?php echo $row1['dt_id']; ?>"><?php echo $row1['dt_name']; ?></option>                                             
<?php
}
}
?>
