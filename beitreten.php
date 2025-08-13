<?php
global $pdo;
session_start();
#if(!isset($_SESSION['userid'])) {
#    die('Bitte zuerst <a href="login.php">einloggen</a>');
#}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];
$Spiel_ID = $_POST['beitreten'];

if ($Spiel_ID == "") {

    echo '<script>
        alert("Keine Spiel-ID vorhanden");
    </script>';

    header("Refresh: spiel.php; url=geheim.php");
}

$pdo = new PDO('mysql:host=localhost;dbname=skip-bo', 'root', '1234');
$statement = $pdo->prepare("SELECT COUNT(*) FROM Spiel WHERE Spiel_ID = :spiel_id");
$statement->execute(['spiel_id' => $Spiel_ID]);
$exists = $statement->fetchColumn() > 0;

if (!$exists) {
    echo "Die Spiel-ID existiert nicht. Bitte überprüfen Sie die ID. Sie werden zurückgeleitet.";
    header("Refresh: 2; url=geheim.php");
}
//Ziehstapel aus Datenbank abfragen
$statement = $pdo->prepare("SELECT Ziehstapel FROM Spiel WHERE Spiel_ID = :spiel_id");
$statement->execute(['spiel_id' => $Spiel_ID]);
$ziehstapel = $statement->fetchColumn();

//Ziehstapel in array umwandeln
$ziehstapel = explode(',', $ziehstapel);

$s1 = [];
$s2 = [];
$s3 = [];
$s4 = [];
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link rel="stylesheet" href="style/style_game.css">
</head>
<body>
<div class="grid">
    <!-- Zeile 1 -->
    <div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n1">1</div><div class="cell n1">1</div><div class="cell n1">1</div><div class="cell n1">1</div><div class="cell n1">1</div><div class="cell n0">0</div><div class="cell n0">0</div>
    <!-- Zeile 2 -->
    <div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div>
    <!-- Zeile 3 -->
    <div class="cell n2">2</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n3">3</div>
    <!-- Zeile 4 -->
    <div class="cell n2">2</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n3">3</div>
    <!-- Zeile 5 -->
    <div class="cell n2">
        2
    </div>

    <div class="cell n0">0</div>

    <div class="cell n6">
        <img class="dropzone" src="cards/card_skipBo.png" id="get" draggable="false" alt="hello" height="90" width="90">
    </div>

    <div class="cell n5">
        <img class="dropzone" id="drop1" draggable="false" alt="hello" height="90" width="90" src=<?php
        $LastEntry = end($s1);
        if (empty($s1)) {
            echo '"cards/card_0.png"';
        }else {
            echo '"cards/card_' . $LastEntry . '.png"';
        }
        ?>>
    </div>
    <div class="cell n5">
        <img class="dropzone" id="drop2" draggable="false" alt="hello" height="90" width="90" src=<?php
        $LastEntry = end($s2);
        if (empty($s1)) {
            echo '"cards/card_0.png"';
        }else {
            echo '"cards/card_' . $LastEntry . '.png"';
        }
        ?>>
    </div>
    <div class="cell n5">
        <img class="dropzone" id="drop3" draggable="false" alt="hello" height="90" width="90" src=<?php
        $LastEntry = end($s3);
        if (empty($s1)) {
            echo '"cards/card_0.png"';
        }else {
            echo '"cards/card_' . $LastEntry . '.png"';
        }
        ?>>
    </div>
    <div class="cell n5">
        <img class="dropzone" id="drop4" draggable="false" alt="hello" height="90" width="90" src=<?php
        $LastEntry = end($s4);
        if (empty($s1)) {
            echo '"cards/card_0.png"';
        }else {
            echo '"cards/card_' . $LastEntry . '.png"';
        }
        ?>>
    </div>

    <div class="cell n0">0</div>

    <div class="cell n3">
        3
    </div>

    <!-- Zeile 6 -->
    <div class="cell n2">2</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n3">3</div>
    <!-- Zeile 7 -->
    <div class="cell n2">2</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n3">3</div>
    <!-- Zeile 8 -->
    <div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div><div class="cell n0">0</div>
    <!-- Zeile 9 -->
    <div class="cell n0">0</div>
    <div class="cell n0">0</div>

        <div class="cell n4">4</div>
        <div class="cell n4">4</div>
        <div class="cell n4">4</div>
        <div class="cell n4">4</div>
        <div class="cell n4">
            <img src="assets/skipbo.png" alt="Drag me!" width="80" height="80" value="">
        </div>

    <div class="cell n0">0</div>
    <div class="cell n0">0</div>
</div>
<script>
    // Drag starten
    document.getElementById("drag1").addEventListener("dragstart", function(event) {
        event.dataTransfer.setData("text", event.target.id);
    });

    // Dropzones verarbeiten
    document.querySelectorAll(".dropzone").forEach(zone => {
        zone.addEventListener("dragover", e => e.preventDefault());

        zone.addEventListener("drop", function(event) {
            event.preventDefault();
            const elementId = event.dataTransfer.getData("text");
            const zoneId = event.target.id;
            const element = document.getElementById(elementId);
            event.target.appendChild(element);

            // AJAX an sich selbst schicken (an PHP-Teil oben)
            fetch("", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id=" + encodeURIComponent(elementId) + "&zone=" + encodeURIComponent(zoneId)
            })
                .then(res => res.text())
                .then(data => {
                    console.log("Antwort vom Server:", data);
                });
        });
    });
</script>
</body>
</html>
