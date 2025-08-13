<?php
global $pdo;
session_start();
#if(!isset($_SESSION['userid'])) {
#    die('Bitte zuerst <a href="login.php">einloggen</a>');
#}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];
$Spiel_ID = $_POST['beitreten'];
$pdo = new PDO('mysql:host=localhost;dbname=skip-bo', 'root', '1234');

if ($Spiel_ID == "") {
    echo '<script>
        alert("Keine Spiel-ID vorhanden");
    </script>';
    header("Refresh: spiel.php; url=geheim.php");
}

function Spiel_beenden()
{
    global $Spiel_ID, $pdo;
    if (sizeof($ablagestapel) > 0) {
        $statement = $pdo->prepare("UPDATE `skip-bo`.`spiel` SET `Begonnen` = '1' WHERE (`Spiel_ID` = :spiel_id)");
        $statement->execute(array('spiel_id' => $Spiel_ID));
    }
}

$statement = $pdo->prepare("SELECT COUNT(*) FROM Spiel WHERE Spiel_ID = :spiel_id");
$statement->execute(['spiel_id' => $Spiel_ID]);
$exists = $statement->fetchColumn() > 0;

if (!$exists) {
echo "Die Spiel-ID existiert nicht. Bitte überprüfen Sie die ID. Sie werden zurückgeleitet.";
header("Refresh: 2; url=geheim.php");
}

$statement = $pdo->prepare("SELECT Ziehstapel FROM Spiel WHERE Spiel_ID = :spiel_id");
$statement->execute(['spiel_id' => $Spiel_ID]);
$ziehstapel = $statement->fetchColumn();

//Ziehstapel in array umwandeln
$ziehstapel = explode(',', $ziehstapel);

