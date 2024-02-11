<?php

include('config.php');

if ($connect == null)
{
    echo "Create a database then reload this page.";
    return;
}
else 
{
    if (isset($_SESSION['user_type']))
    {
        header("location:home.php");
    }
    else
    {
        header("location:login.php");
    }
}

?>