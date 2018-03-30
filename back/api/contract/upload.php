<?php
	include("../common/db.php");
	if(empty($_POST))
    die("Invalid Argumanets");

	// print_r($_POST);
	$contract = filter_var($_POST['upload_con'], FILTER_SANITIZE_STRING);
	$file_name = ($_POST['upload_name']);
	//print_r($file_name);

	$query = "INSERT INTO `dd_static_contract` (`contract`, `file_name`) VALUES ('".$contract."', '".$file_name."');";
	$result_1 = mysqli_query($conn,$query);

	if($result_1 != 1) {
            die("Error in uploading contract.");
    }
    $final_array = json_encode($result_1);
    echo $final_array;


?>