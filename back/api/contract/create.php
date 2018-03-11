<?php

    include("../common/db.php");
    include("../common/fpdf/fpdf.php");
    
    if(empty($_POST))
    die("Invalid Argumanets");

    print_r($_POST);

    $client_address = filter_var($_POST['client_address'], FILTER_SANITIZE_STRING);
    $client_billing_address = filter_var($_POST['client_billing_address'], FILTER_SANITIZE_EMAIL);
    $client_contact_no = filter_var($_POST['client_contact_no'], FILTER_SANITIZE_STRING);
    $client_gstn = filter_var($_POST['client_gstn'], FILTER_SANITIZE_STRING);
    $client_name = filter_var($_POST['client_name'], FILTER_SANITIZE_STRING);
    $client_pan = filter_var($_POST['client_pan'], FILTER_SANITIZE_STRING);
    $client_payment_terms = filter_var($_POST['client_payment_terms'], FILTER_SANITIZE_STRING);
    $client_spoc = filter_var($_POST['client_spoc'], FILTER_SANITIZE_STRING);
    $contract_description = filter_var($_POST['contract_description'], FILTER_SANITIZE_STRING);
    $contract_end_date = filter_var($_POST['contract_end_date'], FILTER_SANITIZE_STRING);
    $contract_name = filter_var($_POST['contract_name'], FILTER_SANITIZE_STRING);
    $contract_start_date = filter_var($_POST['contract_start_date'], FILTER_SANITIZE_STRING);
    $contract_type = filter_var($_POST['contract_type'], FILTER_SANITIZE_STRING);

    $client_id = null;
    

    if(!empty($_POST['client_id'])) {
        $client_id = $_POST['client_id'];
    } else {
        
        $query = "INSERT INTO `dd_client` ( `client_id`, `client_name`, `client_spoc`, `client_address`, `client_contact_no`, `client_pan`, `client_gstn`, `client_billing_address`,`client_payment_terms`, `client_recurring` ) VALUES (NULL, '".$client_name."', '".$client_spoc."', '".$client_address."', '".$client_contact_no."', '".$client_pan."', '".$client_gstn."', '".$client_billing_address."', '".$client_payment_terms."','0');";

        $result_1 = mysqli_query($conn,$query);
        
        if($result_1 == 1) {
            $client_id = mysqli_insert_id($conn);
        } else {
            die("Error in inserting client.");
        }
    }

    $query_2 = "INSERT INTO `dd_contract_main` (`contract_id`, `client_id`, `contract_name`, `contract_start_date`, `contract_end_date`, `contract_desription`, `contract_type`, `service_mapping_id`) VALUES (NULL, '".$client_id."', '".$contract_name."', '".$contract_start_date."', '".$contract_end_date."', '".$contract_description."', '".$contract_type."', '0');";

    $result_2 = mysqli_query($conn,$query_2);

    $contract_id = null;

    if($result_2 == 1) {
        $contract_id = mysqli_insert_id($conn);
        
        $pdf = new FPDF();

        $pdf -> AddPage();
        $pdf -> SetFont('Arial','B', 12);
        $pdf -> Cell(150,10,"Dignitas Digital",1,1,'C');
        
        $pdf-> Cell(150,10,"Client Name: ".$client_name,1,1);
        $pdf-> Cell(150,10,"Client SPOC: ".$client_spoc,1,1);
        $pdf-> Cell(150,10,"Contract Type: ".$contract_type,1,1);
        $pdf-> Cell(150,10,"Contract Start date: ".$contract_start_date,1,1);

        $filename= "dd_c".$contract_id.".pdf"; 

        $filelocation = "../../generated/contracts/";

        $fileNL = $filelocation.$filename;

        $pdf->Output($fileNL,'F');

        echo "Contract Created: ".$filename;

    } else {
        die("Error in inserting client.");
    }
    
    die();

?>