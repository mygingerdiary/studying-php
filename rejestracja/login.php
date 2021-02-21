<?php

    session_start();

    if(!isset($_POST['login']) || (!isset($_POST['haslo'])))
    {
        header('Location: index.php');
        exit();
    }


    require_once 'connect.php';

    try
    {
        $connection = new mysqli($host, $db_login, $db_password, $db_name);

        if($connection->connect_errno!=0)
        {
            echo "Error: ".$connection->connect_errno;
        }
        else
        {
            $login = $_POST['login'];
            $haslo = $_POST['haslo'];

            $login = htmlentities($login, ENT_QUOTES, "UTF-8");

            if($result = @$connection->query(sprintf("SELECT * FROM uzytkownicy WHERE BINARY user='%s'",
                mysqli_real_escape_string($connection, $login))))
            {
                $users = $result->num_rows;
                if($users > 0)
                {
                    $row = $result->fetch_assoc();
                    if(password_verify($haslo, $row['pass']))
                    {
                        $_SESSION['zalogowany'] = true;

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
                else
                {
                    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                    header('Location: index.php');
                }
            }

            $connection->close();
        }

    }
    catch (Exception $e)
    {
        echo '<span style="color: red;"> Błąd serwera. Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie </span>';
        echo '<br />Informacja developerska: '.$e;
    }


