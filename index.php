<?php

	session_start();

	// LOGIN SESSION TEST
	if((isset($_SESSION['login_on'])) && ($_SESSION['login_on']==true))
	{
		header('Location: php/dashboard.php');
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>STH - Login</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<link rel="Shortcut icon" href="/img/HaaCk_StH.png" />

	<link rel="stylesheet" href="style.css" type="text/css" />

</head>

<body>

    <div id="logo">
        <a style="cursor:pointer" onclick="location.reload()"><img src="/img/HaaCk_StH2.png" /></a>
    </div>

	<div id="container">
		<form action="php/login.php" method="post">

			<input type="text" name="login" placeholder="Login" onfocus="this.placeholder=''" onblur="this.placeholder='Login'">

			<input type="password" name="pass" placeholder="Pass" onfocus="this.placeholder=''" onblur="this.placeholder='Pass'">

			<input type="submit"value="Sign in">

		</form>

		<?php

			// LOGIN ERROR
			if (isset($_SESSION['error']))
			{
				echo $_SESSION['error'];
			}

		?>

	</div>

    <div id="footer">
        <center>Powered by LYSY <br> STH &copy;</center>
    </div>

<?php
exit();
?>

</body>
</html>
