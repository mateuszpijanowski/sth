<?php

session_start();
// LOGIN SESSION TEST
if (!isset($_SESSION['login_on']))
{
    header('Location: /');
    exit();
}

if ((isset($_REQUEST["file_name"]))) // SEND VARIABLE TEST
{
    $file_name = $_REQUEST["file_name"]; // FILE NAME
    $touch = fopen($file_name, "w"); // CREATE NEW FILE
    exit();
}
else // SEND VARIABLE ERROR
{
    exit(); // PHP STOP
}

?>
