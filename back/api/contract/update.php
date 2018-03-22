<?php

    include("../common/db.php");
    include("../common/fpdf/fpdf.php");
    
    if(empty($_POST))
    die("Invalid Argumanets");
    
    $client_email_address = filter_var($_POST['client_email_address'], FILTER_SANITIZE_STRING);
    $client_billing_address = filter_var($_POST['client_billing_address'], FILTER_SANITIZE_EMAIL);
    $client_contact_no = filter_var($_POST['client_contact_no'], FILTER_SANITIZE_STRING);
    $client_name = filter_var($_POST['client_name'], FILTER_SANITIZE_STRING);
    $client_pan = filter_var($_POST['client_pan'], FILTER_SANITIZE_STRING);
    $client_payment_terms = filter_var($_POST['client_payment_terms'], FILTER_SANITIZE_STRING);
    $client_spoc = filter_var($_POST['client_spoc'], FILTER_SANITIZE_STRING);
    $contract_description = filter_var($_POST['contract_description'], FILTER_SANITIZE_STRING);
    $contract_end_date = filter_var($_POST['contract_end_date'], FILTER_SANITIZE_STRING);
    $contract_name = filter_var($_POST['contract_name'], FILTER_SANITIZE_STRING);
    $contract_start_date = filter_var($_POST['contract_start_date'], FILTER_SANITIZE_STRING);
    $contract_type = filter_var($_POST['contract_type'], FILTER_SANITIZE_STRING);
    $contract_scope = ($_POST['scope']);
    $client_id = filter_var($_POST['client_id'], FILTER_SANITIZE_STRING);
    $contract_id = filter_var($_POST['contract_id'], FILTER_SANITIZE_STRING);

   

    $query = "UPDATE `dd_client` SET  `client_name` = '".$client_name."', `client_spoc` = '".$client_spoc."', `client_email_address` = '".$client_email_address."', `client_contact_no` = '".$client_contact_no."', `client_pan` = '".$client_pan."', `client_billing_address` = '".$client_billing_address."',`client_payment_terms` = '".$client_payment_terms."', `client_recurring` = '0'  WHERE `client_id` = ".$client_id;

    $result_1 = mysqli_query($conn,$query);
        
    if($result_1 != 1) {
        die("Error in updating client.");
    }

    $query_2 = "UPDATE `dd_contract_main` SET  `client_id` = '".$client_id."', `contract_name` = '".$contract_name."', `contract_start_date` = '".$contract_start_date."', `contract_end_date` = '".$contract_end_date."', `contract_description` = '".$contract_description."', `contract_type`= '".$contract_type."' WHERE `contract_id` = ".$contract_id;
    
    $result_2 = mysqli_query($conn,$query_2);
    if($result_2 != 1) {
        die("Error in updating client.");
    }

else {
          $size = count($contract_scope);
          $arr = array();

          mysqli_query($conn,"DELETE FROM `dd_service_mapping` WHERE `contract_id` = ".$contract_id);

          for($i=0;$i<$size;$i++) {

                
                $query3 = "INSERT INTO `dd_service_mapping` (`map_id`,`contract_id`, `service_list_id`,`price`,`comment`) VALUES (NULL ,'".$contract_id."','".$contract_scope[$i]['id']."','".$contract_scope[$i]['price']."','".$contract_scope[$i]['comment']."');";
                $result = mysqli_query($conn,$query3);
                
                    // if(! in_array($contract_scope[$i]['master_id'], $arr)) {

                    //     array_push($arr,$contract_scope[$i]['master_id']);
                    //     $query4 = "INSERT INTO `dd_contract_service` (`master_serv_contract_id`, `con_id`, `master_id`) VALUES (NULL ,'".$contract_id."','".$contract_scope[$i]['master_id']."');"; 
                    //     mysqli_query($conn,$query4);
                    // }

                

           }
        

        $query4 = "SELECT SUM(price) as `price` FROM dd_service_mapping INNER JOIN dd_service_list ON dd_service_mapping.service_list_id = dd_service_list.id WHERE `contract_id` ='".$contract_id."' GROUP BY `parent_id` ";
        $value =  mysqli_query($conn,$query4);
              
            
        $query5 = "SELECT `service_list_id`, `service_name` FROM dd_service_mapping INNER JOIN dd_service_list ON dd_service_mapping.service_list_id = dd_service_list.id  WHERE `contract_id` = '".$contract_id."'";
        $value1 =  mysqli_query($conn,$query5);
        
        $query6 = "SELECT a.*,b.service_name as parent FROM dd_service_list a INNER JOIN dd_service_list b ON a.id = b.parent_id INNER JOIN (SELECT `parent_id`,`service_name` FROM dd_service_list INNER JOIN dd_service_mapping ON dd_service_list.id = dd_service_mapping.service_list_id WHERE `contract_id` = '".$contract_id."') as ABC ON b.service_name = ABC.service_name";
        $value2 = mysqli_query($conn,$query6);


        $query7 = "SELECT `name` FROM dd_legal INNER JOIN dd_legal_mapping ON dd_legal.id=dd_legal_mapping.legal_id WHERE `contract_id`= '".$contract_id."'";
        $value3 = mysqli_query($conn,$query7);




        $pdf = new FPDF();

        $pdf -> AddPage();
        $pdf -> SetFont('Arial','B', 12);
        $pdf -> Cell(150,10,"Dignitas Digital",1,1,'C');
        
        $pdf-> Cell(150,10,"Client Name: ".$client_name,1,1);
        $pdf-> Cell(150,10,"Client SPOC: ".$client_spoc,1,1);
        if($contract_type == 1){
            $pdf-> Cell(150,10,"Contract Type: Digital Marketing",1,1);
        }
        else if($contract_type == 2){
            $pdf-> Cell(150,10,"Contract Type: Technical",1,1);
        }
        else {
            $pdf-> Cell(150,10,"Contract Type: Digital Marketing and Technical",1,1);
        }    
        $pdf-> Cell(150,10,"Contract Start date: ".$contract_start_date,1,1);
        $pdf-> Ln(5);
        $pdf-> Write(10,"CONTRACT SCOPE");
        $pdf -> SetFont('Arial','', 10);
        $pdf-> Ln(10);
        while ($row = mysqli_fetch_assoc($value1)){
            
            if($row['service_name'] == "On Page"){
                $pdf-> MultiCell(150,4,"-".$row['service_name'],0,'L');
                $pdf-> MultiCell(150,4,"   . Recommendations for Improving on-page SEO",0,'L');
                $pdf-> MultiCell(150,4,"   . Keyword Research & Targeting",0,'L');
                $pdf-> MultiCell(150,4,"   . HTML/Code Update Recommendations",0,'L');
                $pdf-> MultiCell(150,4,"   . Content Writing & Optimization Recommendations",0,'L');
                $pdf-> MultiCell(150,4,"   . Optimized URL Structure Recommendations",0,'L');
                $pdf-> MultiCell(150,4,"   . Index submissions, as applicable",0,'L');

            }
            else
                $pdf-> MultiCell(150,5,"-".$row['service_name'],0,'L');
        }
        $pdf -> SetFont('Arial','B', 12);
        $pdf-> Write(10,"PRICING");
        $pdf-> Ln(10);
        $pdf -> SetFont('Arial','', 10);
        while (($row = mysqli_fetch_assoc($value2)) && ($row1 = mysqli_fetch_assoc($value))){

            $pdf-> Cell(150,5,"-".$row['service_name'],0,0,'L');
            $pdf-> MultiCell(150,5,"INR ".$row1['price']." exclusive of GST",0,'L');

        }
        $pdf-> MultiCell(150,5,"-Applicable taxes additional(Currently GST @ 18%)",0,'L');
        $pdf-> Ln(10);
        $pdf -> SetFont('Arial','', 7);
        $pdf-> Write(5,"By signing this estimate client is agreeing to:

1.   To pay Dignitas Digital the amounts shown in this estimate in consideration of and for the services performed and/or purchases made on Client's behalf under this estimate agreement within 10 days of date of issue on the invoice.  If Dignitas Digital is required to retain the services of an attorney to collect any unpaid invoice (after serving three written or emailed notices), Client agrees to reimburse Dignitas Digital for its costs of collection. Payment to be made in the name of the Agency. In case of any dispute relating to the payment, terms and conditions or any other kind, jurisdiction of Court in Delhi will be applicable.
2.  To indemnify Dignitas Digital for all third party purchases (media, photography, printing, software modules etc.)  authorized by Client's signature under this agreement.  In the case of project cancellation this means Client is responsible for all costs and liabilities (including time, cancellation fees and any media \"short rates\") incurred up until Client cancels (unless other cancellation terms have been agreed to in writing) with the understanding that such cancellation costs will not exceed the amount(s) shown on this estimate.
3.  The price mentioned in this quote is in Indian Rupees.
4.  The client will pay for any gift items/sweepstakes awards/giveaways that may be used for promotion on social media channels
5.  The pricing mentioned in this quote is bulk pricing based on the project. The pricing is not for any individual components, but is based on milestones as mentioned.
6.  To allow Dignitas Digital to legally use client’s logo and name on dignitasdigital.com stating the project, if desired.
7.  To assume all responsibility for the accuracy of any and all information and materials supplied by Client to Dignitas Digital, including information about their ownership, and to indemnify and defend Dignitas Digital from all claims and damages resulting from Dignitas Digital's use of such materials in Client's projects.  Dignitas Digital will, in turn, do the same for Client in regard to any other information and materials Dignitas Digital provides as part of this project.
8.  Estimate terms may only be modified by replacing this estimate with a new estimate.
");

        $filename= "dd_c".$contract_id.".pdf"; 

        $filelocation = "../../generated/contracts/";

        $fileNL = $filelocation.$filename;

        $pdf->Output($fileNL,'F');

        echo $filename;
}else{
        die("Error in inserting client.");
    }
    
    

?>