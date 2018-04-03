<?php

    include("../common/db.php");
    //include("con_pdf.php");
    include("../common/fpdf/fpdf.php");
    
    if(empty($_POST))
    die("Invalid Argumanets");

    $client_email_address = filter_var($_POST['client_email_address'], FILTER_SANITIZE_STRING);
    $client_billing_address = ($_POST['client_billing_address']);
    $client_contact_no = filter_var($_POST['client_contact_no'], FILTER_SANITIZE_STRING);
    $client_gstn = filter_var($_POST['client_gstn'], FILTER_SANITIZE_STRING);
    $client_gstn_name = filter_var($_POST['gstn_name'], FILTER_SANITIZE_STRING);
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
    $legal = ($_POST['legal']);
   
    
    $client_id = null;

    if(!empty($_POST['client_id'])) {
        $client_id = $_POST['client_id'];
    } else {
        
        $query = "INSERT INTO `dd_client` ( `client_id`, `client_name`, `client_spoc`, `client_email_address`, `client_contact_no`, `client_pan`, `client_gstn`, `client_gstn_name`, `client_billing_address`,`client_payment_terms`, `client_recurring` ) VALUES (NULL, '".$client_name."', '".$client_spoc."', '".$client_email_address."', '".$client_contact_no."', '".$client_pan."', '".$client_gstn."', '".$client_gstn_name."', '".$client_billing_address."','".$client_payment_terms."','0');";
        $result_1 = mysqli_query($conn,$query);

        
        if($result_1 == 1) {
            $client_id = mysqli_insert_id($conn);
        } else {
            die("Error in inserting client.");
        }
    }

    $query_2 = "INSERT INTO `dd_contract_main` (`contract_id`, `client_id`, `contract_name`, `contract_start_date`, `contract_end_date`, `contract_description`, `contract_type`,`contract_status`, `last_modified`) VALUES (NULL, '".$client_id."', '".$contract_name."', '".$contract_start_date."', '".$contract_end_date."', '".$contract_description."', '".$contract_type."', 'Proposal', ".time().");";

    $result_2 = mysqli_query($conn,$query_2);

    $contract_id = null;

    if($result_2 == 1) {
        $contract_id = mysqli_insert_id($conn);
        $size = count($legal);
        for($i=0;$i<$size;$i++){
            $query1 = "INSERT INTO `dd_legal_mapping` (`map_id`,`contract_id`,`legal_id`) VALUES (NULL, '".$contract_id."','".$legal[$i]['id']."');";
            $res = mysqli_query($conn,$query1);
            //print_r($res);

        }

        $size = count($contract_scope);
        $arr = array();
        for($i=0;$i<$size;$i++) {
        
            $query3 = "INSERT INTO `dd_service_mapping` (`map_id`,`contract_id`, `service_list_id`,`price`,`comment`) VALUES (NULL ,'".$contract_id."','".$contract_scope[$i]['id']."','".$contract_scope[$i]['price']."','".$contract_scope[$i]['comment']."');";
            
            $result = mysqli_query($conn,$query3);
        }

        
       $query4 = "SELECT SUM(price) as `price` FROM dd_service_mapping INNER JOIN dd_service_list ON dd_service_mapping.service_list_id = dd_service_list.id WHERE `contract_id` ='".$contract_id."' GROUP BY `parent_id` ";
       $value =  mysqli_query($conn,$query4);
       //print_r($value);
       // while ($row1 = mysqli_fetch_assoc($value)){
       //   print_r($row1);
        
       //  } 
       $query5 = "SELECT `service_list_id`, `service_name` FROM dd_service_mapping INNER JOIN dd_service_list ON dd_service_mapping.service_list_id = dd_service_list.id  WHERE `contract_id` = '".$contract_id."'";
       $value1 =  mysqli_query($conn,$query5);
       //print_r($value1);
       //$sub_service = array();
       // while ($row = mysqli_fetch_assoc($value1)){
       //  array_push($sub_service, $row['service_name']);
        
       //  } 
        
        $query6 = "SELECT a.*,b.service_name as parent FROM dd_service_list a INNER JOIN dd_service_list b ON a.id = b.parent_id INNER JOIN (SELECT `parent_id`,`service_name` FROM dd_service_list INNER JOIN dd_service_mapping ON dd_service_list.id = dd_service_mapping.service_list_id WHERE `contract_id` = '".$contract_id."') as ABC ON b.service_name = ABC.service_name";
        $value2 = mysqli_query($conn,$query6);
        $value5 = mysqli_query($conn,$query6);
        $value6 = mysqli_query($conn,$query6);
        $value7 = mysqli_query($conn,$query6);
        $value8 = mysqli_query($conn,$query6);
        $value9 = mysqli_query($conn,$query6);
   
        // $query8 = "SELECT a.*,b.service_name as parent FROM dd_service_list a INNER JOIN dd_service_list b ON a.id = b.parent_id INNER JOIN (SELECT `parent_id`,`service_name` FROM dd_service_list INNER JOIN dd_service_mapping ON dd_service_list.id = dd_service_mapping.service_list_id WHERE `contract_id` = '".$contract_id."' && `parent_id` = 2) as ABC ON b.service_name = ABC.service_name";
        // $value4 = mysqli_query($conn,$query8);

        $query7 = "SELECT `name` FROM dd_legal INNER JOIN dd_legal_mapping ON dd_legal.id=dd_legal_mapping.legal_id WHERE `contract_id`= '".$contract_id."'";
        $value3 = mysqli_query($conn,$query7);
        class PDF extends FPDF
        {
// Page header
            function Header()
            {
                global $client_name, $client_spoc, $contract_start_date, $contract_type;

                $this->Image('../../../front/images/DDlogo.png',5,15,25);
                $this-> SetX(45);

                $this -> SetFont('Arial','B', 12);
                $this -> SetTextColor(187,0,0);
                $this -> Cell(150,10,"Scope of Work",0,1,'C');
                $this-> SetX(45);

                $this -> SetFont('Arial','B', 8);
                $this-> Cell(150,10,"Client Name:  ",1,0);
        //$this-> SetXY(35,20);
                $this -> SetTextColor(0,0,0);
                $this -> SetFont('Arial','', 8);
                $this-> Text(72,26,$client_name);
                $this->Ln();

                $this -> SetTextColor(187,0,0);
        
                $this-> SetX(45);
                $this -> SetFont('Arial','B', 8);
                $this-> Cell(150,10,"Client SPOC: ",1,0);

                $this -> SetTextColor(0,0,0);
                $this -> SetFont('Arial','', 8);
                $this-> Text(72,36,$client_spoc);
                $this->Ln();


                if($contract_type == 1){
                    $this -> SetTextColor(187,0,0);
                    $this-> SetX(45);
                    $this -> SetFont('Arial','B', 8);
                    $this-> Cell(150,10,"Contract Type:",1,0);
                    $this -> SetTextColor(0,0,0);
                    $this -> SetFont('Arial','', 8);
                    $this-> Text(72,46,"Digital Marketing");
                    $this->Ln();
                }

                else if($contract_type == 2){
                    $this -> SetTextColor(187,0,0);
                    $this-> SetX(45);
                    $this -> SetFont('Arial','B', 8);
                    $this-> Cell(150,10,"Contract Type: ",1,0);
                    $this -> SetTextColor(0,0,0);
                    $this -> SetFont('Arial','', 8);
                    $this-> Text(72,46,"Technical");
                    $this->Ln();

                }
                else {
                    $this -> SetTextColor(187,0,0);
                    $this-> SetX(45);
                    $this -> SetFont('Arial','B', 8);
                    $this-> Cell(150,10,"Contract Type: ",1,0);
                    $this -> SetTextColor(0,0,0);
                    $this -> SetFont('Arial','', 8);
                    $this-> Text(72,46,"Digital Marketing and Technical");
                    $this->Ln();
                }  
                $this -> SetTextColor(187,0,0);  
                $this-> SetX(45);
                $this -> SetFont('Arial','B', 8);
                $this-> Cell(150,10,"Contract Start date:",1,0);
                $this -> SetTextColor(0,0,0);
                $this -> SetFont('Arial','', 8);
                $this-> Text(78,56,$contract_start_date);
                $this-> Ln(15);
               
            }
// Page footer
            public function Footer() {
        // Position at 15 mm from bottom
                $this->SetY(-15);
                $this -> SetFont('Arial','', 6);
        // Set font
                $this-> SetTextColor(187,0,0);
        // Page number
                $this->Cell(0,2,'  Dignitas Digtal Pvt Ltd                                                                                                                                                                                                        Digital Marketing | Web | Mobile Apps | Software ',0,1,'L');
                $this-> Cell(0,2,'______________________________________________________________________________________________________________________________________________________________',0,1);

                $this->Cell(0,4,'  1/4, Najafgarh Rd, Block 1, Tilak Nagar, New Delhi, Delhi 110018(regd.)                                                                                                                +91-11-45501210[phone]         www.dignitasdigital.com',0,1,'');
            }
            

        }
        
        $pdf = new PDF();
        $pdf -> AddPage();
        $pdf -> SetTextColor(0,0,0);
     
        $count = 0;
        $flag = 0;
        $check =0;
        $str ="";
        $master = array();
        while ($row = mysqli_fetch_assoc($value2)){
          if($row['service_name'] == "Search Engine Optimization"){
            if(!in_array($row['service_name'],$master)){
                    array_push($master, $row['service_name']); 
            }
            break;
          }     
        }  
         $pdf -> SetFont('Arial','B', 10);
                $pdf -> SetTextColor(66,95,244);
                
                $pdf-> MultiCell(150,5,"".$master[0],0,'L');
        while ($row8 = mysqli_fetch_assoc($value8)){ 
            if($row8['service_name'] == "Search Engine Optimization"){
                
               
                $pdf->Ln(3);
                $pdf -> SetTextColor(0,0,0);
                $pdf -> SetFont('Arial','B', 8);
                    if($row8['parent'] == "On Page"){

                        $pdf-> MultiCell(150,4,"   -".$row8['parent'],0,'L');
                        $pdf -> SetFont('Arial','', 8);

                        $pdf-> MultiCell(150,4,"       * Recommendations for Improving on-page SEO",0,'L');
                        $pdf-> MultiCell(150,4,"       * Keyword Research & Targeting",0,'L');
                        $pdf-> MultiCell(150,4,"       * HTML/Code Update Recommendations",0,'L');
                        $pdf-> MultiCell(150,4,"       * Content Writing & Optimization Recommendations",0,'L');
                        $pdf-> MultiCell(150,4,"       * Optimized URL Structure Recommendations",0,'L');
                        $pdf-> MultiCell(150,4,"       * Index submissions, as applicable",0,'L');
                    }
                    else{
                        $pdf -> SetFont('Arial','B', 8);
                        $pdf-> MultiCell(150,4,"   -".$row8['parent'],0,'L');

                    }
            $pdf->Ln(3);
            }
            
        }    
        while ($row9 = mysqli_fetch_assoc($value9)){    
            if($row9['service_name'] == "Social Media Management"){
                $flag =1;
                $check++;
                $count++;
                    if($check == 1){
                        $pdf -> SetFont('Arial','B', 10);
                        $pdf -> SetTextColor(66,95,244);
                        $pdf-> MultiCell(150,5,$row9['service_name'],0,'L');
                        $pdf->Ln(3);
                    }
                
                
                if($count == 1)
                    $str1 = $str.$row9['parent'];
                    //$str1 = ",".$str;
                else 
                    $str1 = $str1.",".$row9['parent'];
            } 
        }
            
        if($flag == 1){
        $pdf -> SetFont('Arial','', 8);
        $pdf -> SetTextColor(0,0,0);
        $pdf-> MultiCell(150,4,"   -Account management of ".$str1);

        $pdf-> MultiCell(150,4,"   -Creating brand-specific social media guidelines",0,'L');
        $pdf-> MultiCell(150,4,"   -Up to 3-4 posts per week in total on all managed social networks, based on best practices",0,'L');
        $pdf-> MultiCell(150,4,"   -Creation of 15 days social media calendar social media calendars for all social media networks, as desired",0,'L');
        $pdf-> MultiCell(150,4,"   -Creating graphics/banners for social media pages",0,'L');
        $pdf-> MultiCell(180,4,"   -Recommendation Social media integration with the brand website on multiple levels (for individual pages, products etc.), if applicable",0,'L');
        $pdf-> MultiCell(150,4,"   -User comments monitoring, reporting and replying across all managed social media channels",0,'L');
        $pdf-> MultiCell(150,4,"   -Facebook advertising  Only Boosting Posts",0,'L');
        $pdf -> SetFont('Arial','B', 8);
        $pdf-> MultiCell(150,4,"    Note: 100% payment of media spends is required up front. Media budget is NOT a part of this quotation.",0,'L');
        $pdf -> SetFont('Arial','', 8);
        $pdf-> MultiCell(150,4,"   -Social Media strategy consultation",0,'L');
        $pdf-> MultiCell(150,4,"   -Optimized campaigns for better results",0,'L');
        $pdf-> MultiCell(150,4,"   -Digital Marketing Consultation",0,'L');
        $pdf-> MultiCell(150,4,"   -Fortnightly Insights report",0,'L');
        }
        $pdf->Ln(3);
       
        while ($row2 = mysqli_fetch_assoc($value5)){
            
            
            if($row2['service_name'] == "Search Engine Marketing" || $row2['service_name'] == "Email Marketing" || $row2['service_name'] == "Landing Page" || $row2['service_name'] == "SMS campaigning"){
                $pdf -> SetFont('Arial','B', 10);
                $pdf -> SetTextColor(66,95,244);
                $pdf-> MultiCell(150,5,$row2['service_name'],0,'L');
                $pdf -> SetFont('Arial','', 8);
                $pdf -> SetTextColor(0,0,0);
                $pdf-> MultiCell(150,5,"  -".$row2['parent'],0,'L');
                

                $pdf->Ln(3);
            }
        }


         $pdf -> SetFont('Arial','B', 10);
        $pdf -> SetTextColor(66,95,244);
        $pdf-> Write(10,"PRICING");
        $pdf -> SetTextColor(0,0,0);
        $pdf-> Ln(10);
        $pdf -> SetFont('Arial','',8);
        $serv = array();

        while ($row2 = mysqli_fetch_assoc($value6)){
            if(!in_array($row2['service_name'],$serv)){
                array_push($serv, $row2['service_name']); 
            }
        }
        //$count = sizeof($serv);
        //print_r($serv);
            $i=0;
            while ($row4 = mysqli_fetch_assoc($value)){
                $pdf-> Cell(150,5,($i+1)." ".$serv[$i],0,0,'L');
                
                $pdf-> MultiCell(150,5,"INR ".$row4['price']." exclusive of GST",0,'L');
                $i++;
           

        }
        
        $pdf-> MultiCell(150,5,"-Applicable taxes additional(Currently GST @ 18%)",0,'L');
        $pdf->Ln(3);
        $pdf -> SetFont('Arial','B', 10);
        $pdf -> SetTextColor(66,95,244);
        $pdf-> Write(10,"LEGAL");
        $pdf-> Ln(7);
        $pdf -> SetFont('Arial','', 7);
        $pdf -> SetTextColor(0,0,0);
        $pdf-> Write(5,"By signing this estimate client is agreeing to:");
        $pdf-> Ln(8);
        while ($row7 = mysqli_fetch_assoc($value3)){
            $pdf-> MultiCell(150,4,"- ".$row7['name'],0,'L');
            $pdf-> Ln(2);
        }
        

    $filename= "dd_c".$contract_id.".pdf"; 

    $filelocation = "../../generated/contracts/";

    $fileNL = $filelocation.$filename;

    $pdf->Output($fileNL,'F');

    echo $filename;
} 
     else {
        die("Error in inserting client.");
    }
    
   die();
?>