<?php

session_start();
// LOGIN SESSION TEST
if (!isset($_SESSION['login_on']))
{
    header('Location: /');
    exit();
}

if ((isset($_REQUEST["file_name"])) && (isset($_REQUEST["content"]))) // SEND VARIABLES TEST
{
    $file_name = $_REQUEST["file_name"]; // FILE NAME
    $new_content = $_REQUEST["content"]; // NEW FILE CONTENT
    $file = fopen($file_name,"a"); // FILE ACCESS
    fputs($file, $new_content); // EDIT FILE
    fclose($file); // CLOSE EDIT FILE
}
else // SEND VARIABLES ERROR
{
    exit(); // PHP STOP
}

?>
