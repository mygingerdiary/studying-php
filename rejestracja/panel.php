<?php
    session_start();

    if(!isset($_SESSION['zalogowany']))
    {
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panel użytkownika</title>

    <link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>

<?php
    echo "<p>Witaj ".$_SESSION['user']."! [<a href='logout.php'>Wyloguj się</a>]</p>";
?>


</body>
</html>
