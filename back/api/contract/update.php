<?php

    include("../common/db.php");
    include("../common/fpdf/fpdf.php");
    
    if(empty($_POST))
    die("Invalid Argumanets");

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // die();
    
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
    $contract_legal = ($_POST['legal']);
    $client_id = filter_var($_POST['client_id'], FILTER_SANITIZE_STRING);
    $contract_id = filter_var($_POST['contract_id'], FILTER_SANITIZE_STRING);
   
    $query = "UPDATE `dd_client` SET  `client_name` = '".$client_name."', `client_spoc` = '".$client_spoc."', `client_email_address` = '".$client_email_address."', `client_contact_no` = '".$client_contact_no."', `client_pan` = '".$client_pan."', `client_billing_address` = '".$client_billing_address."',`client_payment_terms` = '".$client_payment_terms."', `client_recurring` = '0'  WHERE `client_id` = ".$client_id;
    $result_1 = mysqli_query($conn,$query);
        
    if($result_1 != 1) {
        die("Error in updating client.");
    }
    
    $query_2 = "UPDATE `dd_contract_main` SET  `client_id` = '".$client_id."', `contract_name` = '".$contract_name."', `contract_start_date` = '".$contract_start_date."', `contract_end_date` = '".$contract_end_date."', `contract_description` = '".$contract_description."', `contract_type`= '".$contract_type."', `last_modified`='".time()."' WHERE `contract_id` = ".$contract_id;
    $result_2 = mysqli_query($conn,$query_2);
    if($result_2 != 1) {
        die("Error in updating client.");
    }

    $size = count($contract_scope);
    $arr = array();

    mysqli_query($conn,"DELETE FROM `dd_service_mapping` WHERE `contract_id` = ".$contract_id);

    for($i=0;$i<$size;$i++) {

        $query3 = "INSERT INTO `dd_service_mapping` (`map_id`,`contract_id`, `service_list_id`,`price`,`comment`) VALUES (NULL ,'".$contract_id."','".$contract_scope[$i]['id']."','".$contract_scope[$i]['price']."','".$contract_scope[$i]['comment']."');";
        $result = mysqli_query($conn,$query3);

    }

    $size = count($contract_legal);
    $arr = array();

    mysqli_query($conn,"DELETE FROM `dd_legal_mapping` WHERE `contract_id` = ".$contract_id);

    for($i=0;$i<$size;$i++) {

        $query1 = "INSERT INTO `dd_legal_mapping` (`map_id`,`contract_id`,`legal_id`) VALUES (NULL, '".$contract_id."','".$contract_legal[$i]['id']."');";
            $res = mysqli_query($conn,$query1);

    }

    $query4 = "SELECT SUM(price) as `price` FROM dd_service_mapping INNER JOIN dd_service_list ON dd_service_mapping.service_list_id = dd_service_list.id WHERE `contract_id` ='".$contract_id."' GROUP BY `parent_id` ";
    $value =  mysqli_query($conn,$query4);
            
        
    $query5 = "SELECT `service_list_id`, `service_name` FROM dd_service_mapping INNER JOIN dd_service_list ON dd_service_mapping.service_list_id = dd_service_list.id  WHERE `contract_id` = '".$contract_id."'";
    $value1 =  mysqli_query($conn,$query5);
    
    $query6 = "SELECT a.*,b.service_name as parent FROM dd_service_list a INNER JOIN dd_service_list b ON a.id = b.parent_id INNER JOIN (SELECT `parent_id`,`service_name` FROM dd_service_list INNER JOIN dd_service_mapping ON dd_service_list.id = dd_service_mapping.service_list_id WHERE `contract_id` = '".$contract_id."') as ABC ON b.service_name = ABC.service_name";
    $value2 = mysqli_query($conn,$query6);
    $value5 = mysqli_query($conn,$query6);
    $value6 = mysqli_query($conn,$query6);

    $query7 = "SELECT `name` FROM dd_legal INNER JOIN dd_legal_mapping ON dd_legal.id=dd_legal_mapping.legal_id WHERE `contract_id`= '".$contract_id."'";
    $value3 = mysqli_query($conn,$query7);


    class PDF extends FPDF
        {
// Page header
            function Header()
            {
                global $client_name, $client_spoc, $contract_start_date;

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
        
                $this->SetY(-15);
                $this -> SetFont('Arial','', 6);
        
                $this-> SetTextColor(187,0,0);
       
                $this->Cell(0,2,'Dignitas Digtal Pvt Ltd                                                                                              Digital Marketing | Web | Mobile Apps | Software ',0,1,'L');
                $this-> Cell(0,2,'_______________________________________________________________________________________________________________',0,1);

                $this->Cell(0,4,'1/4, Najafgarh Rd, Block 1, Tilak Nagar, New Delhi, Delhi 110018(regd.)             +91-11-45501210[phone]                www.dignitasdigital.com',0,1,'');
            }
            

        }

        $pdf = new PDF();
        
        $pdf -> AddPage();
        
       
        $pdf -> SetTextColor(0,0,0);
        $count = 0;
        $flag = 0;
        $check =0;
        $str ="";
        while ($row = mysqli_fetch_assoc($value2)){
            
            if($row['service_name'] == "Search Engine Optimization"){
                
                $pdf -> SetFont('Arial','B', 10);
                $pdf -> SetTextColor(66,95,244);
                $pdf-> MultiCell(150,5,$row['service_name'],0,'L');
                $pdf->Ln(3);
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
            $pdf->Ln(3);
            }
            
             
            else if($row['service_name'] == "Social Media Management"){
                $flag =1;
                $check++;
                $count++;
                    if($check == 1){
                        $pdf -> SetFont('Arial','B', 10);
                        $pdf -> SetTextColor(66,95,244);
                        $pdf-> MultiCell(150,5,$row['service_name'],0,'L');
                        $pdf->Ln(3);
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
            
            
            if($row2['service_name'] == "Search Engine Marketing" || $row2['service_name'] == "Email Marketing" || $row2['service_name'] == "Landing Page" || $row1['service_name'] == "SMS campaigning"){
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
        while (($row2 = mysqli_fetch_assoc($value6)) && ($row3 = mysqli_fetch_assoc($value))){
            //echo "hello";
            $pdf-> Cell(150,5,"-".$row2['service_name'],0,0,'L');
            $pdf-> MultiCell(150,5,"INR ".$row3['price']." exclusive of GST",0,'L');

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
        while ($row = mysqli_fetch_assoc($value3)){
            $pdf-> MultiCell(150,4,"".$row['name'],0,'L');
            $pdf-> Ln(2);
        }

    $filename= "dd_c".$contract_id.".pdf"; 

    $filelocation = "../../generated/contracts/";

    $fileNL = $filelocation.$filename;

    $pdf->Output($fileNL,'F');

    echo $filename;

?>