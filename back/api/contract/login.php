<?php 

    include("../common/db.php");
    if(isset($_POST["uname"], $_POST["pwd"])) 
    {     
    	//print_r($_POST);
        $username = stripslashes($_POST["uname"]); 
		$username = mysqli_real_escape_string($_POST["uname"]);
		

        $password = stripslashes($_POST["pwd"]); 
		$password = mysqli_real_escape_string($_POST["pwd"]);
		//$password = md5($password);

        $result = mysqli_query($conn,"SELECT `username` FROM dd_login WHERE `username` = '".$username."' AND `password` = '".$password."'");
        $row = mysqli_fetch_array($result);
        $active = $row['active'];


        if(mysqli_num_rows($result) > 0 )
        { 
            $_SESSION["logged_in"] = true; 
            $_SESSION["name"] = $username; 
            header("location: ../front/index.html");
        }
        else
        {
            echo 'The username or password are incorrect!';
        }
	}


?>