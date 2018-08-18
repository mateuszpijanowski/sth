<?php

    session_start();

    // LOGIN SESSION TEST
    if ((!isset($_POST['login'])) && (!isset($_POST['pass'])))
    {
        header('Location: /');
        exit();
    }

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
            $login = $_POST['login']; // USER LOGIN
            $pass = $_POST['pass']; // USER PASS

            $login = htmlentities($login, ENT_QUOTES, "UTF-8"); // HTML ENTITIES SCAN

            if ($result = $connect->query(
            sprintf("SELECT * FROM login WHERE nick='%s'",
            mysqli_real_escape_string($connect, $login)))) // MYSQLI SCAN TEST
            {
                $login_on = $result->num_rows; // AMOUNT OF USERS
                if ($login_on>0)
                {
                    $verse = $result->fetch_assoc(); // MYSQL ARRAY

                    if (password_verify($pass, $verse['pass'])) // USER PASS TEST
                    {
                        // SESSION VARIABLES
                        $_SESSION['login_on'] = true;
                        $_SESSION['id'] = $verse['id'];
                        $_SESSION['user'] = $verse['nick'];
                        $_SESSION['email'] = $verse['email'];

                        unset($_SESSION['error']); // DELETE ERROR VARIABLES
                        $result->close(); // CLOSE MYSQL SECURITY CONNECT
                        header('Location: dashboard.php'); // GO TO DASHBOARD
                    }
                    else // BAD PASS
                    {
                        $_SESSION['error'] = '<center><br /><span style="color:red">Bad login or password!</span></center>';
                        header('Location: /');
                    }
                }
                else // BAD LOGIN
                {
                    $_SESSION['error'] = '<center><br /><span style="color:red">Bad login or password!</span></center>';
                    header('Location: /');
                }
            }
            else // CONNECT TIMEOUT
            {
                echo '<span style="color:red">Server error!</span>';
            }

            $connect->close(); // CLOSE CONNECT
        }
    }
    catch(Exception $error) // LIST OF ERRORS
    {
        echo '<span style="color:red">Server error!</span>';
        echo '<br /><b>DEV info:</b> '.$error;
    }

?>
