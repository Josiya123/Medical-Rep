<?php
include_once('../database.php');
if(!empty($_POST['dt_id'])){  
$dt_id=$_POST['dt_id'];
$data=DataBase::SelectData("SELECT `tl_id`, `dt_id`, `tl_emailid`, `tl_password`, 
`tl_firstname`, `tl_lastname`, `tl_gender`, `tl_mobilenumber` FROM `teamleader`  
where dt_id=$dt_id");
while($row1=mysqli_fetch_array($data)) {
?>
<option value="<?php echo $row1['tl_id']; ?>"><?php echo $row1['tl_firstname'].' '.$row1['tl_lastname']; ?></option>                                             
<?php
}
if(mysqli_num_rows($data)==0){
?>
<option value="">No Team Leaders in Selecred District</option>
<?php
}

}
?>
