<?php
    session_start();

    if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == true))
    {
        header('Location: panel.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panel logowania</title>

    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>

    <form action="login.php" method="post">
        Login: <br />
        <input type="text" name="login">
        <br />
        Hasło: <br />
        <input type="password" name="haslo">
        <br />
        <input type="submit" value="Zaloguj się">
    </form>
    <?php
    if(isset($_SESSION['blad']))
    {
        echo $_SESSION['blad'];
    }
    ?>

</body>
</html>