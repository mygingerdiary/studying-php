<?php
    require('includes/Connection.php');

    session_start();

    if(isset($_SESSION['user_session']))
    {
        $conn = $_SESSION['connection'];

        $conn->user->log_out();
    }

    header('Location: panel_logowania.php');


    unset($_SESSION['connection']);