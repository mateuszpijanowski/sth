<?php

session_start();
// LOGIN SESSION TEST
if (!isset($_SESSION['login_on']))
{
    header('Location: /');
    exit();
}

if ((isset($_REQUEST["file_name"]))) // SEND FILE NAME VARIABLES TEST
{
    $file_name = $_REQUEST["file_name"]; // FILE NAME
    if (filesize($file_name)) // FILE CONTENT TEST
    {
        $content = fread(fopen($file_name, "r"), filesize($file_name)); // FILE CONTENT
        echo $content;
    }
    else // EMPTY FILE
    {
        echo "This file is empty!";
    }
}
else // SEND VARIABLES ERROR
{
    exit(); // PHP STOP
}

?>
