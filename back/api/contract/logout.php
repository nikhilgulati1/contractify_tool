<?php
session_start();
if(isset($_GET)) {
    session_destroy();
    unset($_SESSION['name']);
    header('Location:login.html');
    echo "Logout";
}
?>
