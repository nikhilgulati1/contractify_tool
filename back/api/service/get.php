<?php

    include("../common/db.php");
    
    $query = "SELECT `master_id`, `master_service_name`, `master_service_price`, `scope_name` FROM dd_master_service INNER JOIN dd_sub_service ON dd_master_service.master_service_id=dd_sub_service.master_id";

    $query_res = mysqli_query($conn,$query);

    $ret_array = array();

    while ($row = mysqli_fetch_assoc($query_res)) {
    	array_push($ret_array, $row);
    }

    $ret_array = json_encode($ret_array);
    
    echo $ret_array;

?>