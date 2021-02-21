<?php
    session_start();

    if(!isset($_SESSION['udana_rejestracja']))
    {
        header('Location: index.php');
        exit();
    }
    else
    {
        unset($_SESSION['udana_rejestracja']);
    }

    //usuwamy zmienne, pamiętające wartości wpisywane do formularza
    if(isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']);
    if(isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
    if(isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
    if(isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
    if(isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);

    //usuwamy zmienne z błędami rejestracji
    if(isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
    if(isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
    if(isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
    if(isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
    if(isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panel logowania</title>

    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>

    <h1>Dziękujemy za rejestrację w serwisie. Możesz już zalogować sie na swoje konto!</h1>
    <br /><br />
    <a href="index.php">Zaloguj się na swoje konto</a>

</body>
</html>