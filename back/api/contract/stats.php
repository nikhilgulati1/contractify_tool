<?php
	include("../common/db.php");
	$query = "SELECT `contract_id` FROM dd_contract_main WHERE `is_deleted` = 0";
	$result = mysqli_num_rows(mysqli_query($conn,$query));
	//print_r($result);

	$query1 = "SELECT `client_id` FROM dd_client";
	$result1 = mysqli_num_rows(mysqli_query($conn,$query1));

	$query2 = "SELECT `id` FROM dd_service_list WHERE `parent_id` IS NULL";
	$result2 = mysqli_num_rows(mysqli_query($conn,$query2));

	$final_data = array(
		"total_contracts" => $result,
		"total_client" => $result1,
		"total_master" => $result2

	);

	//print_r($final_data);
	// $merge = array_merge($result, $result1, $result2);
	// print_r($merge);

	// $client_ids = array();
 //    

	$data_after_json_encoding = json_encode($final_data);
    print_r($data_after_json_encoding);




?>