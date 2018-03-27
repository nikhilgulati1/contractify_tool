<?php

    include("../common/db.php");
    include("../common/fpdf/fpdf.php");
    
    if(empty($_POST))
    die("Invalid Argumanets");

    
    $client_email_address = filter_var($_POST['client_email_address'], FILTER_SANITIZE_STRING);
    $client_billing_address = filter_var($_POST['client_billing_address'], FILTER_SANITIZE_EMAIL);
    $client_contact_no = filter_var($_POST['client_contact_no'], FILTER_SANITIZE_STRING);
    //$client_gstn = filter_var($_POST['client_gstn'], FILTER_SANITIZE_STRING);
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
        
        $query = "INSERT INTO `dd_client` ( `client_id`, `client_name`, `client_spoc`, `client_email_address`, `client_contact_no`, `client_pan`, `client_gstn`,`client_billing_address`,`client_payment_terms`, `client_recurring` ) VALUES (NULL, '".$client_name."', '".$client_spoc."', '".$client_email_address."', '".$client_contact_no."', '".$client_pan."', 'ABCDE4567Q','".$client_billing_address."', '".$client_payment_terms."','".$client_payment_terms."');";

        $result_1 = mysqli_query($conn,$query);
        
        if($result_1 == 1) {
            $client_id = mysqli_insert_id($conn);
        } else {
            die("Error in inserting client.");
        }
    }

    $query_2 = "INSERT INTO `dd_contract_main` (`contract_id`, `client_id`, `contract_name`, `contract_start_date`, `contract_end_date`, `contract_description`, `contract_type`,`contract_status`, `last_modified`) VALUES (NULL, '".$client_id."', '".$contract_name."', '".$contract_start_date."', '".$contract_end_date."', '".$contract_description."', '".$contract_type."', 'Started', ".time().");";

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
   
        $query8 = "SELECT a.*,b.service_name as parent FROM dd_service_list a INNER JOIN dd_service_list b ON a.id = b.parent_id INNER JOIN (SELECT `parent_id`,`service_name` FROM dd_service_list INNER JOIN dd_service_mapping ON dd_service_list.id = dd_service_mapping.service_list_id WHERE `contract_id` = '".$contract_id."' && `parent_id` = 2) as ABC ON b.service_name = ABC.service_name";
        $value4 = mysqli_query($conn,$query8);

        $query7 = "SELECT `name` FROM dd_legal INNER JOIN dd_legal_mapping ON dd_legal.id=dd_legal_mapping.legal_id WHERE `contract_id`= '".$contract_id."'";
        $value3 = mysqli_query($conn,$query7);
        //print_r($value2);
        
        // $service = array();
        // while ($row1 = mysqli_fetch_assoc($value2)){
        //    array_push($service ,$row1['service_name']);
           
        // } 
        //print_r($service);        
       
        

        

       
        //    if ( 0 < $_FILES['file']['error'] ) {
        //         echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        //     }
        //    else {
        //         move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/' . $_FILES['file']['name']);
        //     }
           
    
        class PDF extends FPDF
        {
// Page header
            function Header()
            {
        //         $this->SetFont('dejavusans', 'BI', 20, '', 'false');
        //         $this->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        // // Move to the right
        //         $this->Ln(5);
        //         $this->Cell(60);
        //         $this->Cell($w, $h=0, $txt='INCOME REPORT', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0,
        //         $ignore_min_height=false, $calign='T', $valign='M');
        //         $this->Line (0, 13, 210, 13, $style=array());
        // // Line break
        //         $this->Ln(5);
            }
// Page footer
            public function Footer() {
        // Position at 15 mm from bottom
                $this->SetY(-20);
                $this -> SetFont('Arial','', 6);
        // Set font
                $this-> SetTextColor(187,0,0);
        // Page number
                $this->Cell(0,10,'Dignitas Digtal Pvt Ltd                                                                                                  Digital Marketing | Web | Mobile Apps | Software ',0,1,'L');
                $this-> Line(0,-15,170,-15);

                $this->Cell(0,10,'1/4, Najafgarh Rd, Block 1, Tilak Nagar, New Delhi, Delhi 110018(regd.)             +91-11-45501210[phone]                www.dignitasdigital.com',0,1,'');
            }
            function Logo($x,$y){
                
                $this->Image('../../../front/images/DDlogo.png',$x,$y+10,20);
            }

        }

        $pdf = new PDF();
        $x = $pdf->GetX();
        $y = $pdf->GetY();


        $pdf -> AddPage();
        
        $pdf->Logo($x,$y);
        
        $pdf-> SetX(45);

        $pdf -> SetFont('Arial','B', 12);
        $pdf -> SetTextColor(187,0,0);
        $pdf -> Cell(150,10,"Scope of Work",0,1,'C');
        $pdf-> SetX(45);

        $pdf -> SetFont('Arial','B', 8);
        $pdf-> Cell(150,10,"Client Name:  ",1,0);
        //$pdf-> SetXY(35,20);
        $pdf -> SetTextColor(0,0,0);
        $pdf -> SetFont('Arial','', 8);
        $pdf-> Text(72,26,$client_name);
        $pdf->Ln();

        $pdf -> SetTextColor(187,0,0);
        
        $pdf-> SetX(45);
        $pdf -> SetFont('Arial','B', 8);
        $pdf-> Cell(150,10,"Client SPOC: ",1,0);

        $pdf -> SetTextColor(0,0,0);
        $pdf -> SetFont('Arial','', 8);
        $pdf-> Text(72,36,$client_spoc);
        $pdf->Ln();


        if($contract_type == 1){
            $pdf -> SetTextColor(187,0,0);
            $pdf-> SetX(45);
            $pdf -> SetFont('Arial','B', 8);
            $pdf-> Cell(150,10,"Contract Type:",1,0);
            $pdf -> SetTextColor(0,0,0);
            $pdf -> SetFont('Arial','', 8);
            $pdf-> Text(72,46,"Digital Marketing");
            $pdf->Ln();



        }
        else if($contract_type == 2){
            $pdf -> SetTextColor(187,0,0);
            $pdf-> SetX(45);
            $pdf -> SetFont('Arial','B', 8);
            $pdf-> Cell(150,10,"Contract Type: ",1,0);
            $pdf -> SetTextColor(0,0,0);
            $pdf -> SetFont('Arial','', 8);
            $pdf-> Text(72,46,"Technical");
            $pdf->Ln();

        }
        else {
            $pdf -> SetTextColor(187,0,0);
            $pdf-> SetX(45);
            $pdf -> SetFont('Arial','B', 8);
            $pdf-> Cell(150,10,"Contract Type: ",1,0);
            $pdf -> SetTextColor(0,0,0);
            $pdf -> SetFont('Arial','', 8);
            $pdf-> Text(72,46,"Digital Marketing and Technical");
            $pdf->Ln();
        }  
        $pdf -> SetTextColor(187,0,0);  
        $pdf-> SetX(45);
        $pdf -> SetFont('Arial','B', 8);
        $pdf-> Cell(150,10,"Contract Start date: ",1,0);
        $pdf -> SetTextColor(0,0,0);
        $pdf -> SetFont('Arial','', 8);
        $pdf-> Text(78,56,$contract_start_date);



        $pdf-> Ln(15);

        $pdf -> SetTextColor(0,0,0);
        
        $pdf-> Ln(10);

        $count = 0;
        $flag = 0;
        $check =0;
        $str ="";
        while ($row = mysqli_fetch_assoc($value2)){
            
            if($row['service_name'] == "Search Engine Optimization"){
                
                $pdf -> SetFont('Arial','', 10);
                $pdf -> SetTextColor(66,95,244);
                $pdf-> MultiCell(150,5,$row['service_name'],0,'L');
                $pdf -> SetTextColor(0,0,0);
                $pdf -> SetFont('Arial','B', 8);
                    if($row['parent'] == "On Page"){

                        $pdf-> MultiCell(150,4,"   -".$row['parent'],0,'L');
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
                        $pdf-> MultiCell(150,4,"   -".$row['parent'],0,'L');

                    }
            
            }
             
            else if($row['service_name'] == "Social Media Management"){
                $flag =1;
                $check++;
                $count++;
                    if($check == 1){
                        $pdf -> SetFont('Arial','', 10);
                        $pdf -> SetTextColor(66,95,244);
                        $pdf-> MultiCell(150,5,$row['service_name'],0,'L');
                    }
                
                
                if($count == 1)
                    $str1 = $str.$row['parent'];
                    //$str1 = ",".$str;
                else 
                    $str1 = $str1.",".$row['parent'];
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
        $pdf-> MultiCell(150,4,"   -Recommendation Social media integration with the brand'’'s website on multiple levels (for individual pages, products etc.), if applicable",0,'L');
        $pdf-> MultiCell(150,4,"   -User comments monitoring, reporting and replying across all managed social media channels",0,'L');
        $pdf-> MultiCell(150,4,"   -Facebook advertising '–' Only Boosting Posts",0,'L');
        $pdf -> SetFont('Arial','B', 8);
        $pdf-> MultiCell(150,4,"    Note: 100% payment of media spends is required up front. Media budget is NOT a part of this quotation.",0,'L');
        $pdf -> SetFont('Arial','', 8);
        $pdf-> MultiCell(150,4,"   -Social Media strategy consultation",0,'L');
        $pdf-> MultiCell(150,4,"   -Optimized campaigns for better results",0,'L');
        $pdf-> MultiCell(150,4,"   -Digital Marketing Consultation",0,'L');
        $pdf-> MultiCell(150,4,"   -Fortnightly Insights report",0,'L');
        }

       
        while ($row2 = mysqli_fetch_assoc($value5)){
            
            $pdf -> SetFont('Arial','', 10);
            $pdf -> SetTextColor(66,95,244);
            if($row2['service_name'] == "Search Engine Marketing" || $row2['service_name'] == "Email Marketing" || $row2['service_name'] == "Landing Page" || $row1['service_name'] == "SMS campaigning"){
                $pdf-> MultiCell(150,5,$row2['service_name'],0,'L');
            }
        }


                
            
            
        
        $pdf -> SetFont('Arial','B', 10);
        $pdf -> SetTextColor(66,95,244);
        $pdf-> Write(10,"PRICING");
        $pdf -> SetTextColor(0,0,0);
        $pdf-> Ln(10);
        $pdf -> SetFont('Arial','',8);
        while (($row2 = mysqli_fetch_assoc($value6)) && ($row3 = mysqli_fetch_assoc($value))){
            //echo "hello";
            $pdf-> Cell(150,5,"-".$row2['service_name'],0,0,'L');
            $pdf-> MultiCell(150,5,"INR ".$row3['price']." exclusive of GST",0,'L');

        }
        $pdf-> MultiCell(150,5,"-Applicable taxes additional(Currently GST @ 18%)",0,'L');
        // $pdf->SetY(-30);
        // $pdf -> SetTextColor(187,0,0);
        // $pdf->Cell(0,10,'Dignitas Digtal Pvt Ltd                                                                                                  Digital Marketing | Web | Mobile Apps | Software ',0,1,'L');
        // $x = $pdf->GetX();
        // $y = $pdf->GetY();
        // $pdf-> Line($x,$y,170,$y);

        // $pdf->Cell(0,10,'1/4, Najafgarh Rd, Block 1, Tilak Nagar, New Delhi, Delhi 110018(regd.)             +91-11-45501210[phone]                www.dignitasdigital.com',0,1,'');

        
        // $pdf->AddPage();
        // $pdf -> SetFont('Arial','', 7);
        // $x = $pdf->GetX();
        // $y = $pdf->Gety();
        // $pdf -> Image('../../../front/images/DDlogo.png',$x,$y,70);
        $pdf-> Write(5,"By signing this estimate client is agreeing to:");
        $pdf-> Ln(8);
        while ($row = mysqli_fetch_assoc($value3)){
            $pdf-> MultiCell(150,4,"".$row['name'],0,'L');
            $pdf-> Ln(2);
        }
        // $pdf->SetY(-15);
        // $pdf -> SetTextColor(187,0,0);
        // $pdf->Cell(0,10,'Dignitas Digtal Pvt Ltd                                                                                                  Digital Marketing | Web | Mobile Apps | Software ',0,1,'L');
        // $x = $pdf->GetX();
        // $y = $pdf->GetY();
        // $pdf-> Line($x,$y,170,$y);

        // $pdf->Cell(0,10,'1/4, Najafgarh Rd, Block 1, Tilak Nagar, New Delhi, Delhi 110018(regd.)             +91-11-45501210[phone]                www.dignitasdigital.com',0,1,'');




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