<?php

    session_start();
    if (!isset($_SESSION['login_on']))
    {
        header('Location: /');
        exit();
    }
    else
    {
        header('Location: /php/dashboard.php');
        exit();
    }

?>
