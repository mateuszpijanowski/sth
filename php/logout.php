<?php

	session_start(); // SESSION START

    session_unset(); // DELETE ALL SESSION VARIABLES

    header('Location: /'); // GO TO START PAGE

?>
