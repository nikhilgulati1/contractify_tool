<?php 

    include("../common/db.php");
    
    $query = "SELECT * FROM dd_legal";
   
	$query_res = mysqli_query($conn,$query);
	//print_r($query_res);

    $ret_array = array();

    while ($row = mysqli_fetch_assoc($query_res)) {
    	array_push($ret_array, $row);
    }

    $ret_array = json_encode($ret_array);
    print_r($ret_array);

    


?>