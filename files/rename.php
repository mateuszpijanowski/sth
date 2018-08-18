<?php

session_start();
// LOGIN SESSION TEST
if (!isset($_SESSION['login_on']))
{
    header('Location: /sth/index.php');
    exit();
}

if ((isset($_REQUEST["old_name"])) || (isset($_REQUEST["new_name"]))) // SEND VARIABLES TEST
{
    $old_name = $_REQUEST["old_name"]; // OLD FILE NAME
    $new_name = $_REQUEST["new_name"]; // NEW FILE NAME
    rename($old_name, $new_name); // REANME FILE
}

?>
