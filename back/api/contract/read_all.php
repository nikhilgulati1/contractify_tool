<?php 

    include("../common/db.php");
    
	$data_from_db = "SELECT `contract_name`,`contract_id`,`contract_type`,`contract_start_date`, `contract_end_date`,`client_email_address` FROM `dd_contract_main` INNER JOIN `dd_client` ON dd_contract_main.client_id = dd_client.client_id";

    $result = mysqli_query($conn,$data_from_db);
    
    $final_array = array();

    while ($row = mysqli_fetch_assoc($result)) {
    	array_push($final_array, $row);
    }
    
    $data_after_json_encoding = json_encode($final_array);
    
    echo $data_after_json_encoding;

?>