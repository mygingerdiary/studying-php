<?php

    require('includes/Connection.php');

    session_start();

    var_dump($_SESSION['user_session']);

    if( isset($_SESSION['connection']) )
    {
        $conn = $_SESSION['connection'];
        if($conn->user->is_logged_in())
        {

        }
        else
        {
            header('Location: panel_logowania.php');
        }

    }
    else
    {
        //header('Location: panel_logowania.php');
    }
?>

<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <title>Koło PZW Amur w Płotach</title>

    <link rel="stylesheet" href="../styles/style.css" type="text/css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div id="logout">
        <a href="wyloguj.php">Wyloguj się</a>
    </div>
    <h1>
        Koło PZW Amur w Płotach
    </h1>
</header>

<nav>
    <div id="menu">
        <p onclick="location.href='index.php'">
            Strona główna
        </p>
        <p onclick="location.href='losuj.php'">
            Losuj zawodników
        </p>
        <p onclick="location.href='zawodnicy.php'">
            Zawodnicy
        </p>
        <p onclick="location.href='statystyki.php'">
            Statystyki
        </p>
    </div>
</nav>

<main>
    <div id="main_page">
        <article>
            Witaj na stronie koła wędkarskiego Amur w Płotach.
            <div id="zdj_glowne">
                <img src="../images/zdj_glowne.jpg" alt="">
            </div>
        </article>
    </div>
</main>

<footer>
    <p id="footer">
        Oficjalna strona Koła Amur &copy; w Płotach
    </p>
</footer>

</body>
</html>