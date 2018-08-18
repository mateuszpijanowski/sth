<?php

session_start();

// LOGIN SESSION TEST
if (!isset($_SESSION['login_on']))
{
    header('Location: /');
    exit();
}

else
{
    require_once "connect.php"; // REQUIRE MYSQL CONNECT
    mysqli_report(MYSQLI_REPORT_STRICT); // MYSQL REPORT TYPE

    try // CONNECT TRY
    {
        $connect = new mysqli($host, $db_user, $db_pass, $db_name); // MYSQL CONNECT
        if ($connect->connect_errno!=0) // CONNECT ERROR TEST
        {
            throw new Exception(mysqli_connect_errno()); // THROW CONNECT ERROR
        }
        else
        {
            if ((isset($_REQUEST["nick"])) && (isset($_REQUEST["pass"]))) // SEND LOGIN AND PASS TEST
            {
                $nick = $_REQUEST["nick"]; // USER NICK
                $pass = $_REQUEST["pass"]; // USER PASS

                $id = htmlentities($id, ENT_QUOTES, "UTF-8"); // HTML ENTITIES SCAN
                $pass = htmlentities($pass, ENT_QUOTES, "UTF-8"); // HTML ENTITIES SCAN

                $pass_hash = password_hash($pass, PASSWORD_DEFAULT); // HASHED USER PASS

                $result = "UPDATE login SET pass='$pass_hash' WHERE nick='$nick'"; // MYSQLI INQUIRY
                mysqli_query($connect, $result); // MYSQL RESULT
            }
            else // LOGIN OR PASS VARIABLES ERROR
            {
                $connect->close(); // CLOSE CONNECT
                exit(); // PHP STOP
            }
        }

        $connect->close(); // CLOSE CONNECT
    }

    catch(Exception $error) // LIST OF ERRORS
    {
        echo '<span style="color:red">Server error!</span>';
        echo '<br /><b>DEV info:</b> '.$error;
    }
}

?>
