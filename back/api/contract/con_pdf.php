<?php 
    include("../common/db.php");
    include("../common/fpdf/fpdf.php");
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
            // function Logo($x,$y){
                
            //     $this->Image('../../../front/images/DDlogo.png',$x,$y,25);
            // }

        }
     
    function startcreating(){
        
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
            print_r($row8);
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
 ?> 
