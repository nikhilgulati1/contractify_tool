<?php

    include("../common/db.php");
    $scope = ($_POST['scope']);
    //print_r($scope);

    $query = "UPDATE `dd_service_list` SET `is_check` = 0 ";
    $result = mysqli_query($conn,$query);
    $size = count($scope);
    for($i =0;$i<$size;$i++){
    	$query1 = "UPDATE `dd_service_list` SET `is_check` = 1  WHERE dd_service_list.id='".$scope[$i]['id']."'";
    	$result1 = mysqli_query($conn,$query1);
   
    	$query2 = "UPDATE `dd_service_list` SET `is_check` = 1  WHERE dd_service_list.parent_id='".$scope[$i]['id']."'";
 		$result2 = mysqli_query($conn,$query2);
 	}

 	if($result1 == 1 && $result2 == 1){
 		echo "added services";
 	}
 	else{
 		echo "services not added";
 	}
 	
   

?>