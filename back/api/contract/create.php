<?php
    
    include("db.php");
    //print_r($_POST);
    
    $data_from_db_1 = "INSERT INTO `dd_client` (  `client_id`, 
                                                `client_name`, 
                                                `client_address`, 
                                                `client_contact_no`, 
                                                `client_pan`, 
                                                `client_gstin`, 
                                                `client_billing_address`, 
                                                `client_payment_terms`, 
                                                `client_fromdate`
                                ) VALUES (NULL, '".$_POST['client_name']."', '".$_POST['client_address']."', '123456789', 'ASFA1625G', '1626362781262', 'Some Awesome City', 'NEFT', '2018-03-09');";

    $data_from_db_2 = "INSERT INTO `dd_contract_main` (`contract_id`, `client_id`, `scope_id`, `contract_name`, `contract_duration`, `contract_desription`, `asdsa`, `fsasd`, `fsdfs`) VALUES (NULL, '67', '67', '".$_POST['contract_name']."', '2018-03-08', 'asas', '12', '12', '12');";

    $result_1 = mysqli_query($conn,$data_from_db_1);
    $result_2 = mysqli_query($conn,$data_from_db_2);

    if($result_1 == 1 && $result_2 == 1) {
        echo "Successfully Inserted";
    } else {
        echo "Error Occured";
    }

    

?>