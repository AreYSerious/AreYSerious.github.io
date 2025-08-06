<?php
session_start();
if(!isset($_SESSION['userid'])) {
    die('Bitte zuerst <a href="login.php">einloggen</a>');
}

//Abfrage der Nutzer ID vom Login
$Spieler_ID = $_SESSION['userid'];
$pdo = new PDO('mysql:host=localhost;dbname=skip-bo', 'root', '1234');
$statement = $pdo->prepare('SELECT Anzeigename FROM Spieler WHERE Spieler_ID = ' . $Spieler_ID);
$result = $statement->execute();
$user = $statement->fetch();

echo "Benutzername: " . $user['Anzeigename'] . "<br>";
echo "Spieler-ID: " . $Spieler_ID;
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<br>
    Hola como estas<br>
<hr>
    <div class="nav">
        <a href="index.php">Startseite</a> &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp;
        <a href="register.php">Registrieren</a> &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp;
        <a href="login.php">Login</a> &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp;
        <a href="logout.php">Logout</a> &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp; &emsp;
    </div>
    <div class="start">
    <h1>Willkommen im Skip-Bo Spiel</h1>
    <hr>
    <!-- Spiel Beitreten durch Lobby-Code-->
    <form action="beitreten.php" method="post">
        <label for="beitreten">Spiel Beitreten:</label>
        <br>
        <br>
        <input type="text" id="beitreten" name="beitreten" placeholder="Spiel beitreten">
        <input type="submit" value="Beitreten">
    </form>
    </div>
    <hr>
    <!-- Spiel Erstellen -->
    <div class="erstellen">
        <form action="erstellen.php" method="post">
            <fieldset>
                <label for="erstellen">Spiel Erstellen:</label>
                <br>
                <label for="Stapel">Stapel:</label>
                <input type="number" id="Stapel" name="Stapel" min="1" max="50" value="1">
                <br>
                <label for="Spieler">Spieler:</label>
                <input type="number" id="Spieler" name="Spieler" min="2" max="4" value="2">
                <br>
                <input type="submit" value="Neues Spiel Erstellen">
            </fieldset>
        </form>
    </div>
</body>
</html>