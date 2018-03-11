<?php

    include("db.php");
    include('fpdf/fpdf.php');
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

    if(!empty($_POST)) { 
    
        $client_name = $_POST['client_name'];
        $client_add = $_POST['client_address'];
        $contract_name = $_POST['contract_name'];
        $contract_duration = $_POST['contract_duration'];
        $contract_description = $_POST['contract_description'];
        //$service_1 = $_POST['scope1'];
        //$service_2 = $_POST['scope1'];
        
        $pdf = new FPDF();

        $pdf -> AddPage();
        $pdf -> SetFont('Arial','B', 12);
        $pdf -> Cell(150,10,"Dignitas Digital",1,1,'C');
        //$pdf -> InsertText(\n);
        $pdf-> Cell(150,10,"Client Name: ".$client_name,1,1);
        $pdf-> Cell(150,10,"Client Address: ".$client_add,1,1);
        $pdf-> Cell(150,10,"Contract Name: ".$contract_name,1,1);
        $pdf-> Cell(150,10,"Contract Duration: ".$contract_duration,1,1);
        $pdf-> Cell(150,10,"Contract Description: ".$contract_description,1,1);
        $pdf-> Cell(150,10,"Scopes",1,1);
       // $pdf-> Cell(50,10,$service_1,1,1);
       // $pdf-> Cell(50,10,$service_2,1,1);
        //$pdf ->MultiCell(50,10,$service_1,0,'L');
        $filename= $contract_name.".pdf"; 

        //$filelocation = "./generated/contracts";//windows

        $fileNL = $filename;//Windows

        $pdf->Output($fileNL,'F');

        if($result_1 == 1 && $result_2 == 1) {
            echo "Contract Created";
        } else {
            echo "Error Occured";
        }

    } else {

        echo "POST parameter are empty";

    }


    

    

?>