<?php
global $pdo;
session_start();
if(!isset($_SESSION['userid'])) {
    die('Bitte zuerst <a href="login.php">einloggen</a>');
}

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];

echo "Hallo User: ".$userid;

// Hier wird ein neues Spiel erstellt
$Spieler = $_POST['Spieler'];
$Stapel = $_POST['Stapel'];
$Spiel_ID = idate("U");
// Ursprungsarray
$originalArray = [1,2,3,4,5,6,7,8,9,10,11,12,'Skip-Bo'];

// Neues Array mit 100 zufälligen Einträgen
$randomArray = [];
for ($i = 0; $i < 100; $i++) {
    $randomArray[] = $originalArray[array_rand($originalArray)];
}


$arrays = [];
for ($i = 1; $i <= $Spieler; $i++) {
    $arrays["s$i"] = []; // Erstellt Arrays mit den Namen s1, s2, s3, s4
}




$zieh_stapel = implode(", ", $randomArray);
// Ausgabe des neuen Arrays
//print_r($randomArray);
$pdo = new PDO('mysql:host=localhost;dbname=skip-bo', 'root', '1234');
$statement = $pdo->prepare("INSERT INTO Spiel (Spiel_ID, Anzahl_Spieler, Spieler_ID_ALL, Ablage_Start, Begonnen, ziehstapel) VALUES (:ID, :spieler, :spieler_ID, :stapel, 0, :ziehstapel)");
$result = $statement->execute(array(
    'ID' => $Spiel_ID,
    'spieler' => $Spieler,
    'spieler_ID' => $userid,
    'stapel' => $Stapel,
    'ziehstapel' => $zieh_stapel
));
echo "Spiel wurde erstellt<br>";
echo "Spiel ID: ".$Spiel_ID."<br>";

?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    <form action="beitreten.php" method="post">
        <label for="beitreten">Spiel Beitreten:</label>
        <br>
        <br>
        <input type="text" id="beitreten" name="beitreten" value="<?php echo $Spiel_ID; ?>">
        <input type="submit" value="Beitreten">
    </form>
</body>
</html>