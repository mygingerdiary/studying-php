<?php
session_start();

if (isset($_POST['email']))
{
    //udana walidacja
    $ok = true;

    //LOGIN
    $nick = $_POST['nick'];

    //długośc loginu
    if( (strlen($nick) < 3) || (strlen($nick) > 20) )
    {
        $ok = false;
        $_SESSION['e_nick'] = "Nick musi posiadać od 3 do 20 znaków";
    }

    //znaki alfanumeryczne
    if ( ctype_alnum($nick) == false )
    {
        $ok = false;
        $_SESSION['e_nick'] = "Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
    }

    //EMAIL
    $email = $_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

    if( (filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email) )
    {
        $ok = false;
        $_SESSION['e_email'] = "Podaj poprawny adres e-mail";
    }

    //HASŁO
    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];

    //dlugosc hasla
    if( (strlen($haslo1) < 8) || (strlen($haslo1) > 20) )
    {
        $ok = false;
        $_SESSION['e_haslo'] = "Hasło musi posiadać od 8 do 20 znaków";
    }

    if( $haslo1 != $haslo2 )
    {
        $ok = false;
        $_SESSION['e_haslo'] = "Podane hasła nie są identyczne";
    }

    $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

    //REGULAMIN
    if( !isset($_POST['regulamin']) )
    {
        $ok = false;
        $_SESSION['e_regulamin'] = "Zaakceptuj regulamin";
    }

    //CAPTCHA
    $sekret = "6LfwOQ4aAAAAAO5iEo39BRFAXv_kmB6-ox9vlhK3";

    $sprawdz = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$sekret."&response=".$_POST['g-recaptcha-response']);

    $odpowiedz = json_decode($sprawdz);

    if( $odpowiedz->success == false )
    {
        $ok = false;
        $_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem";
    }

    //zapamietaj wprowadzone dane
    $_SESSION['fr_nick'] = $nick;
    $_SESSION['fr_email'] = $email;
    $_SESSION['fr_haslo1'] = $haslo1;
    $_SESSION['fr_haslo2'] = $haslo2;
    if(isset($_POST['regulamin']))
    {
        $_SESSION['fr_regulamin'] = true;
    }

    //SPRAWDZANIE W BAZIE
    require_once('connect.php');
    mysqli_report(MYSQLI_REPORT_STRICT);

    try
    {
        $connection = new mysqli($host, $db_login, $db_password, $db_name);
        if($connection->connect_errno != 0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            //sprawdzenie, czy email juz istnieje
            $result = $connection->query("SELECT id FROM uzytkownicy WHERE email = '$email'");

            if(!$result)
            {
                throw new Exception($connection->error);
            }

            $nrOfEmails = $result->num_rows;
            if($nrOfEmails > 0)
            {
                $ok = false;
                $_SESSION['e_email'] = "Isnieje już konto przypisane do tego adresu email";
            }

            //sprawdzenie, czy nick juz istnieje
            $result = $connection->query("SELECT id FROM uzytkownicy WHERE user = '$nick'");

            if(!$result)
            {
                throw new Exception($connection->error);
            }

            $nrOfNicks = $result->num_rows;
            if($nrOfNicks > 0)
            {
                $ok = false;
                $_SESSION['e_nick'] = "Isnieje już konto o takim nicku";
            }

            if ($ok == true)
            {
                //walidacja się powiodła
                if ($connection->query("INSERT INTO uzytkownicy VALUES(NULL, '$nick', '$haslo_hash', '$email')"))
                {
                    $_SESSION['udana_rejestracja'] = true;
                    header("Location: witamy.php");
                }
                else
                {
                    throw new Exception($connection->error);
                }
            }

            $connection->close();
        }
    }
    catch (Exception $e)
    {
        echo '<span style="color: red;"> Błąd serwera. Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie </span>';
        //echo '<br />Informacja developerska: '.$e;
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Załóż konto</title>

    <link href="style.css" type="text/css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
    <form method="post">

        Nickname: <br /> <input type="text" name="nick" value="<?php
            if(isset($_SESSION['fr_nick']))
            {
                echo $_SESSION['fr_nick'];
                unset($_SESSION['fr_nick']);
            }
        ?>">
        <br />

        <?php

        if(isset($_SESSION['e_nick']))
        {
            echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
            unset($_SESSION['e_nick']);
        }

        ?>

        Email: <br /> <input type="text" name="email" value="<?php
        if(isset($_SESSION['fr_email']))
        {
            echo $_SESSION['fr_email'];
            unset($_SESSION['fr_email']);
        }
        ?>">
        <br />

        <?php

        if(isset($_SESSION['e_email']))
        {
            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
            unset($_SESSION['e_email']);
        }

        ?>

        Hasło: <br /> <input type="password" name="haslo1" value="<?php
        if(isset($_SESSION['fr_haslo1']))
        {
            echo $_SESSION['fr_haslo1'];
            unset($_SESSION['fr_haslo1']);
        }
        ?>">
        <br />

        <?php

        if(isset($_SESSION['e_haslo']))
        {
            echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
            unset($_SESSION['e_haslo']);
        }

        ?>

        Powtórz hasło: <br /> <input type="password" name="haslo2" value="<?php
        if(isset($_SESSION['fr_haslo2']))
        {
            echo $_SESSION['fr_haslo2'];
            unset($_SESSION['fr_haslo2']);
        }
        ?>">
        <br />

        <label>
            <input type="checkbox" name="regulamin" <?php
            if(isset($_SESSION['fr_regulamin']))
            {
                echo "checked";
                unset($_SESSION['fr_regulamin']);
            }
            ?> /> Akceptuję regulamin
        </label>

        <?php

        if(isset($_SESSION['e_regulamin']))
        {
            echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
            unset($_SESSION['e_regulamin']);
        }

        ?>

        <div class="g-recaptcha" data-sitekey="6LfwOQ4aAAAAAPMOBqxGJ9wfdVO1R-sRFF1WKFII"></div>

        <?php

        if(isset($_SESSION['e_bot']))
        {
            echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
            unset($_SESSION['e_bot']);
        }

        ?>

        <input type="submit" value="Zarejestruj">

    </form>
</body>
</html>
