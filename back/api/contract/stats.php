<?php
	include("../common/db.php");
	$query = "SELECT COUNT(`contract_id`) FROM dd_contract_main";
	$final_object= mysqli_fetch_assoc(mysqli_query($conn,$query));
	$query1 = "SELECT COUNT(`client_id`),`contract_id` FROM dd_client";
	$result = mysqli_query($conn,$query1);
	$query2 = "SELECT COUNT(`id`) , `id` FROM dd_service_list WHERE `parent_id` IS NULL";
	$result1 = mysqli_query($conn,$query2);
	$client = array();
	$client_ids = array();
    while ($row = mysqli_fetch_assoc($result)) {
    	array_push($client, (object)$row);
        array_push($client_ids, $row['client_id']);
    }
    $master = array();
    $master_ids = array();
    while ($row = mysqli_fetch_assoc($result1)) {
   		array_push($client, (object)$row);
        array_push($master_ids, $row['id']);
    }

    $final_object['client'] = $client;
    $final_object['client_id'] = $client_ids;

	$final_object['master'] = $master;
    $final_object['master_id'] = $master_ids;

	$data_after_json_encoding = json_encode($final_object);
    print_r($data_after_json_encoding);




?>