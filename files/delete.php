<?php

session_start();
// LOGIN SESSION TEST
if (!isset($_SESSION['login_on']))
{
    header('Location: /sth/index.php');
    exit();
}

if ((isset($_REQUEST["file"]))) // SEND FILE VARIABLES TEST
{
    $file = $_REQUEST["file"]; // FILE NAME
    unlink($file); // DELETE FILE
}

?>
