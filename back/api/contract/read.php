<?php 
include("db.php");
   $value = $_GET['id'];
   //print_r($_GET);
   // print_r($_REQUEST);
   // print_r($_SERVER);
    
	/*$data_from_db= [
					"this is my","data"
					]*/
    // Step 1 : Get the records from DB using SQL, I am just hard coding some data for this tutorial.
    $data_from_db = "SELECT `contract_name`, `contract_abc` FROM dd_contract_main WHERE contract_id = ".$value."";

    $result = mysqli_query($conn,$data_from_db);



    $final_array = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($final_array, $row);
    }
    	

    // Step 2 : json_encode them                
    $data_after_json_encoding = json_encode($final_array);
    //print_r($data_after_json_encoding);

    // Step 3 : echo the JSON object. 
    echo $data_after_json_encoding;

?>