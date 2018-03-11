<?php
if(!empty($_POST['submit']){
	$client_name = $_POST['client_name'];
	$client_add = $_POST['client_address'];
	$contract_name =$_POST['contract_name'];
	$contract_duration = $_POST['contract_duration'];
	$contract_description = $_POST['contract_description'];
	$service_1 = $_POST['scope1'];
	$service_2 = $_POST['scope1'];

}
require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf -> AddPage();
$pdf -> SetFont('Arial','B', 18);
$pdf -> Cell(0,10,"Dignitas Digital",1,1,C);
$pdf-> Cell(50,10,"Client Name:",{$client_name},1,1);
$pdf-> Cell(50,10,"Client Address:",{$client_adds},1,1);
$pdf-> Cell(50,10,"Contract Name:",{$contract_name},1,1);
$pdf-> Cell(50,10,"Contract Duration:",{$contract_duration},1,1);
$pdf-> Cell(50,10,"Contract Description:",{$contract_description},1,1);
$pdf-> Cell(50,10,"Scopes",1,1);
$pdf-> Cell(50,10,{$scope},1,1);
$pdf-> Cell(50,10,{$service_1},1,1);
$pdf-> Cell(50,10,{$service_2},1,1);

$pdf => Output();
?>