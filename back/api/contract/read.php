<?php 

    include("../common/db.php");
    $id = $_GET['id'];

    $query1 = "SELECT * FROM `dd_contract_main` INNER JOIN `dd_client` ON dd_contract_main.client_id = dd_client.client_id WHERE dd_contract_main.contract_id=".$id;
    $final_object = mysqli_fetch_assoc(mysqli_query($conn,$query1));

    $query3 =  "SELECT * FROM dd_service_mapping INNER JOIN dd_service_list ON dd_service_mapping.service_list_id = dd_service_list.id WHERE `contract_id` = '".$id."'";
    $result3 = mysqli_query($conn,$query3);

    $query4 =  "SELECT * FROM dd_legal_mapping INNER JOIN dd_legal ON dd_legal_mapping.legal_id = dd_legal.id WHERE `contract_id` = '".$id."'";
    $result4 = mysqli_query($conn,$query4);

    $sub_services = array();
    $sub_services_ids = array();
    while ($row = mysqli_fetch_assoc($result3)) {
        array_push($sub_services, (object)$row);
        array_push($sub_services_ids, $row['id']);
    }

    $legal = array();
    $legal_ids = array();
    while ($row = mysqli_fetch_assoc($result4)) {
        array_push($legal, (object)$row);
        array_push($legal_ids, $row['legal_id']);
    }

    $final_object['sub_services'] = $sub_services;
    $final_object['sub_services_ids'] = $sub_services_ids;

    $final_object['legal'] = $legal;
    $final_object['legal_ids'] = $legal_ids;

    $data_after_json_encoding = json_encode($final_object);
    print_r($data_after_json_encoding);

?>