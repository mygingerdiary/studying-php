<?php

require('includes/Connection.php');

session_start();

if(isset($_POST['zaloguj']))
{
    $conn = new Connection();
    $conn->dbConnect();

    $_SESSION['connection'] = $conn;

    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    if(empty($login))
    {
        $error = "Podaj login";
    }
    elseif (empty($haslo))
    {
        $error = "Podaj hasło";
    }
    else
    {
        if($conn->user->login($login, $haslo))
        {
            $conn->user->redirect('index.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Koło PZW Amur w Płotach</title>

    <link rel="stylesheet" href="../styles/login_style.css" type="text/css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@400;900&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <h1>
        Koło PZW Amur w Płotach
    </h1>
</header>

<main>
        <div class="bg">
            <img src="../images/fish_white.png" alt="" class="bg_image">
            <img src="../images/camo.jpg" alt="" class="bg_image_camo">
        </div>
        <div id="login_panel">
            <p>Panel logowania</p>
            <form action="panel_logowania.php" method="post">
                <p>Login</p>
                <input type="text" name="login">
                <p>Hasło</p>
                <input type="password" name="haslo">
                <?php echo $error; ?>
                <button type="submit" name="zaloguj">Zaloguj się</button>
                <div class="link_border">
                    <span></span>
                </div>
            </form>
        </div>
</main>

<footer>
    <p id="footer">
        Oficjalna strona Koła Amur &copy; w Płotach
    </p>
</footer>

</body>
</html>