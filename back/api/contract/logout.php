<?php
session_start();
if(isset($_GET)) {
	unset($_SESSION['name']);
    session_destroy();
    header('Location:login.html');
    echo "Logout";
}
?>
