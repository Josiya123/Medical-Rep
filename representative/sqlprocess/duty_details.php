<?php
if (is_ajax() &&(isset($_POST["rd_id"]) && !empty($_POST["rd_id"]))) {
	dutydetails(); 
}
function is_ajax() {
return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
function dutydetails(){
	$rd_id = $_POST;
	include_once('../database.php');
	$query="SELECT `rd_id`, `rp_id`, `pr_name`,`hp_name`,hp_type, `dc_name`, `mt_meetingtype`, `rd_dutydate`, `rd_dutydescription`, 
    `rd_lat`, `rd_lng`, `rd_checkindate`, `rd_checkintime`, `rd_checkoutdate`, `rd_checkouttime`, 
    `rd_feedback`, `rd_feedbackdate`, `rd_feedbacktime`, `rd_status` FROM 
    `representative_duty`
    inner join hospitals on hospitals.hp_id=representative_duty.hp_id
    inner join products on products.pr_id=representative_duty.pr_id
    inner join doctors on doctors.dc_id=representative_duty.dc_id
    inner join meeting_types on meeting_types.mt_id=representative_duty.mt_id
     WHERE rd_id=".$rd_id['rd_id'];
	$duty=database::SelectData($query);
    $result=null;
    while ($row = mysqli_fetch_assoc($duty)){
      
        $result["rd_id"]=$row['rd_id'];
        $result["pr_name"]=$row['pr_name'];
        $result["hp_name"]=$row['hp_name'];
        $result["hp_type"]=$row['hp_type'];
        $result["dc_name"]=$row['dc_name'];
        $result["mt_meetingtype"]=$row['mt_meetingtype'];
        $result["rd_dutydate"]=$row['rd_dutydate'];
        $result["rd_status"]=$row['rd_status'];

        $result["rd_checkindate"]=$row['rd_checkindate'];
        $result["rd_checkintime"]=$row['rd_checkintime'];
        $result["rd_checkoutdate"]=$row['rd_checkoutdate'];
        $result["rd_checkouttime"]=$row['rd_checkouttime'];
        $result["rd_feedback"]=$row['rd_feedback'];
        $result["rd_feedbackdate"]=$row['rd_feedbackdate'];
        $result["rd_feedbacktime"]=$row['rd_feedbacktime'];
        $result["hp_name"]=$row['hp_name'];

	}
	echo json_encode($result); 

}
//echo json_encode($_GET["rd_id"]); 
?>