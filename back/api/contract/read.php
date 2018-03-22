<?php 

    include("../common/db.php");
    $id = $_GET['id'];
    $query1 = "SELECT * FROM `dd_contract_main` INNER JOIN `dd_client` ON dd_contract_main.client_id = dd_client.client_id WHERE dd_contract_main.contract_id=".$id;
    
    $final_object = mysqli_fetch_assoc(mysqli_query($conn,$query1));

    // $query2 = "SELECT * FROM `dd_contract_service` INNER JOIN `dd_master_service` ON dd_contract_service.master_id =dd_master_service.master_service_id WHERE `con_id` = '".$id."'";
    // $result2 = mysqli_fetch_assoc(mysqli_query($conn,$query2));

    $query3 =  "SELECT a.*,b.service_name as parent FROM dd_service_list a INNER JOIN dd_service_list b ON a.id = b.parent_id INNER JOIN (SELECT `parent_id`,`service_name` FROM dd_service_list INNER JOIN dd_service_mapping ON dd_service_list.id = dd_service_mapping.service_list_id WHERE `contract_id` = '".$id."') as ABC ON b.service_name = ABC.service_name";
    $result3 = mysqli_query($conn,$query3);

    $sub_services = array();
    while ($row = mysqli_fetch_assoc($result3)){
        array_push($sub_services, $row['sub_service_id']);
    }

    $final_object['sub_services'] = $sub_services;

    $data_after_json_encoding = json_encode($final_object);
    echo $data_after_json_encoding;

?>