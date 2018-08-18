<?php

    session_start();

    // LOGIN SESSION TEST
    if (!isset($_SESSION['login_on']))
    {
        header('Location: /');
        exit();
    }

    // START TERMINAL CONTENT
    echo 'Hello <b><span style="color:red">'.$_SESSION['user'].'</span></b>!<br />';
    echo 'Today is '.date("Y/m/d").'<br />Server login time: '.date("h:i:sa").'<br><br />';
    echo 'If you want to logout write "<i>logout</i>" commands.<br /><br />';
    echo 'Use "<i>help</i>" to see available commands<br /><br />';
    echo '<span style="color:grey"><font size="2px"><i>STH Terminal v3.0</i></font></span><br /><br />';

?>
