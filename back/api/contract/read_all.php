<?php 
include("../common/db.php");
	/*$data_from_db= [
					"this is my","data"
					]*/
    // Step 1 : Get the records from DB using SQL, I am just hard coding some data for this tutorial.
    $data_from_db = "SELECT `contract_name`,`contract_id`,`contract_type`,`contract_start_date`, `contract_end_date`,`client_email_address` FROM `dd_contract_main` INNER JOIN `dd_client` ON dd_contract_main.client_id = dd_client.client_id";

    $result = mysqli_query($conn,$data_from_db);
    //print_r($result);

   $final_array = array();

    while ($row = mysqli_fetch_assoc($result)) {
    	array_push($final_array, $row);
    }
    //print_r($final_array);

    // Step 2 : json_encode them               
    $data_after_json_encoding = json_encode($final_array);
    //print_r($data_after_json_encoding);

    // Step 3 : echo the JSON object. 
    echo $data_after_json_encoding;

?>