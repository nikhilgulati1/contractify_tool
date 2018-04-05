<?php 
include("../common/db.php");
	
	if(empty($_POST))
    die("Invalid Argumanets");

    $status = filter_var($_POST['key1'], FILTER_SANITIZE_STRING);
    $contract_id = filter_var($_POST['key2'], FILTER_SANITIZE_STRING);
	$query = "UPDATE `dd_contract_main` SET `contract_status` = '".$status."' WHERE `contract_id` = '".$contract_id."' ";
	$result = mysqli_query($conn,$query);
	print_r($result);

?>