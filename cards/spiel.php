<?php
$pdo = new PDO('mysql:host=localhost;dbname=skip-bo', 'root', '1234');
$statement = $pdo->prepare("SELECT COUNT(*) FROM Spiel WHERE Spiel_ID = :spiel_id");
$statement->execute(['spiel_id' => $Spiel_ID]);
$exists = $statement->fetchColumn() > 0;

if (!$exists) {
echo "Die Spiel-ID existiert nicht. Bitte überprüfen Sie die ID. Sie werden zurückgeleitet.";
header("Refresh: 2; url=geheim.php");
}


