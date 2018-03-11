<?php
 include("db.php");
 //$id = $_GET['id'];

// FORM: Variables were posted
if (!empty($_POST))
{
 $data=unserialize($_POST['dataFromForm']);
print_r($data);
// Prepare form variables for database
foreach($data as $column => $value)
    ${$column} = clean($value);
   

// Perform MySQL UPDATE
$update = "UPDATE `dd_contract_main` SET ".$column."='".$value."'
    WHERE contract_id =".$id;
$result = mysqli_query($conn,$update);
//print_r($result);
   
}


?>