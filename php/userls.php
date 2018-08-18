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
            $inquiry = "SELECT * FROM login";
            $result = mysqli_query($connect, $inquiry); // MYSQLI INQUIRY
            $how = $result->num_rows; // AMOUNT OF USERS

            // USER LIST LOOP
            for ($i = 1; $i<=$how; $i++)
            {
                $row = mysqli_fetch_assoc($result);
                $id = $row['id'];
                $nick = $row['nick'];

                echo $nick."(".$id."), ";
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
