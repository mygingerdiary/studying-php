<?php

    session_start();

    if(!isset($_POST['login']) || (!isset($_POST['haslo'])))
    {
        header('Location: index.php');
        exit();
    }

    require_once 'connect.php';

    $connection = @new mysqli($host, $db_login, $db_password, $db_name);

    if($connection->connect_errno!=0)
    {
        echo "Error: ".$connection->connect_errno;
    }
    else
    {
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $login = htmlentities($haslo, ENT_QUOTES, "UTF-8");

        if($result = @$connection->query(sprintf("SELECT * FROM uzytkownicy WHERE BINARY user='%s' AND BINARY pass='%s'",
        mysqli_real_escape_string($connection, $login),
        mysqli_real_escape_string($connection, $haslo))))
        {
            $users = $result->num_rows;
            if($users > 0)
            {
                $_SESSION['zalogowany'] = true;

                $row = $result->fetch_assoc();
                $_SESSION['id'] = $row['id'];
                $_SESSION['user'] = $row['user'];

                unset($_SESSION['blad']);
                $result->free();
                header('Location: panel.php');
            }
            else
            {
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                header('Location: index.php');
            }
        }

        $connection->close();
    }

