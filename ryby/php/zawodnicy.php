<?php
session_start();

require_once "params.php";
$sql = "SELECT * FROM zawodnicy";
$statement = $db_conn->prepare($sql);
$statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Koło PZW Amur w Płotach</title>

    <link rel="stylesheet" href="../styles/style.css" type="text/css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <h1>
        Zawodnicy
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
    <div id="content">
        <?php
        echo '<ol>';
        while($row = $statement->fetch())
        {
            echo '<li>'.$row["imie"].' '.$row['nazwisko'].'</li><br />';
        }
        echo '</ol>';
        ?>
    </div>
</main>

<footer>
    <p id="footer">
        Oficjalna strona Koła Amur &copy; w Płotach
    </p>
</footer>

</body>
</html>