<?php

if(!isset($_SESSION["admin"]))
{
    // $_SESSION['no-login-message']="please login to access";
    header("location:login_form.php");
}
?>