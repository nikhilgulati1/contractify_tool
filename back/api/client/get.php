<?php

    include("../common/db.php");
    
    $query = "SELECT * FROM dd_client";

    $query_res = mysqli_query($conn,$query);

    $ret_array = array();

    while ($row = mysqli_fetch_assoc($query_res)) {
    	array_push($ret_array, $row);
    }

    $ret_array = json_encode($ret_array);
    
    echo $ret_array;

?>