<?php 

    include("../common/db.php");
    if(isset($_POST["uname"], $_POST["pwd"])) 
    {     
    	print_r($_POST);
        $username = stripslashes($_POST["uname"]); 
		$username = mysqli_real_escape_string($_POST["uname"]);
		$username = md5($username);

        $password = stripslashes($_POST["pwd"]); 
		$password = mysqli_real_escape_string($_POST["pwd"]);
		$password = md5($password);

        $result1 = mysqli_query($conn,"SELECT `username`, `password` FROM dd_login WHERE `username` = '".$username."' AND `password` = '".$password."'");

        if(mysqli_num_rows($result1) > 0 )
        { 
            $_SESSION["logged_in"] = true; 
            $_SESSION["name"] = $username; 
            //print_r($_SESSION);
        }
        else
        {
            echo 'The username or password are incorrect!';
        }
	}


?>