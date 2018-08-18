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
            if ((isset($_REQUEST["pass"])) && (isset($_REQUEST["user"]))) // SEND LOGIN AND PASS TEST
            {
                $user = $_REQUEST["user"]; // USER NICK
                $pass = $_REQUEST["pass"]; // USER PASS

                $user = htmlentities($user, ENT_QUOTES, "UTF-8"); // HTML ENTITIES SCAN
                $pass = htmlentities($pass, ENT_QUOTES, "UTF-8"); // HTML ENTITIES SCAN

                $pass_hash = password_hash($pass, PASSWORD_DEFAULT); //HASHED USER PASS

                $result_check = "SELECT * FROM login WHERE nick='$user'"; // MYSQLI INQUIRY
                $user_check = $result_check->num_rows; // AMOUNT OF USER
                if ($user_check<1) // THIS USER ISN'T THERE
                {
                    $result = "INSERT INTO login SET nick='$user', pass='$pass_hash', email='*'"; // MYSQLI INQUIRY
                    mysqli_query($connect, $result); // MYSQL RESULT
                }
                else // THIS USER IS THERE
                {
                    $connect->close(); // CLOSE CONNECT
                    exit(); // PHP STOP
                }
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
