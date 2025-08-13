<?php
session_start();
if (!isset($_SESSION['userid'])) {
    die('Bitte zuerst <a href="login.php">einloggen</a>');
}

//Abfrage der Nutzer ID vom Login
$Spieler_ID = $_SESSION['userid'];
$pdo = new PDO('mysql:host=localhost;dbname=skip-bo', 'root', '1234');
$userid = $_SESSION['userid'];

echo "Hallo User: " . $userid;

// Hier wird ein neues Spiel erstellt
$Spieler = 4;#$_POST['Spieler'];
$Stapel_size = $_POST['Stapel'];
$Spiel_ID = idate("U");


function arrays_erstellen($size)
{
    $arrays = [];

    for ($i = 1; $i <= $size; $i++) {
        $arrays["s$i"] = []; // Erstellt Arrays mit den Namen s1, s2, s3, s4
    }
    return $arrays;
}

function Array_aus_Array_List_lesen($array, $index)
{
    // Überprüfen, ob der Index im gültigen Bereich liegt
    if (isset($array[$index])) {
        return $array[$index];
    } else {
        return null; // Oder eine andere geeignete Aktion, wenn der Index ungültig ist
    }
}

// Diese Funktion erstellt ein Array mit einer bestimmten Größe, gefüllt mit zufälligen Karten aus
function stapel_erstellen($size)
{
    // Ursprungsarray
    $originalArray = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 'Skip-Bo'];

    // Neues Array mit 100 zufälligen Einträgen
    $randomArray = [];
    for ($i = 0; $i < $size; $i++) {
        $randomArray[] = $originalArray[array_rand($originalArray)];
    }
    return $randomArray;
}
$Stapel = stapel_erstellen($Stapel_size);

$zieh_stapel = stapel_erstellen(100);

$Ablagestapel_Mitte_Array = arrays_erstellen(4);

$statement = $pdo->prepare("INSERT INTO Spiel (Spiel_ID, Anzahl_Spieler, Ablage_Start, Begonnen, ziehstapel, s1, s2, s3, s4, S_Nr_1, S_Nr_2, S_Nr_3, S_Nr_4) 
                            VALUES (:ID, :spieler, :stapel, 0, :ziehstapel, :s1, :s2, :s3, :s4, :S_Nr_1, :S_Nr_2, :S_Nr_3, :S_Nr_4)");
$result = $statement->execute(array(
    'ID' => $Spiel_ID,
    'spieler' => $Spieler,
    'stapel' => $Stapel_size,
    'ziehstapel' => implode(", ", $zieh_stapel),
    's1' => NULL,
    's2' => NULL,
    's3' => NULL,
    's4' => NULL,
    'S_Nr_1' => $Spieler_ID,
    'S_Nr_2' => NULL,
    'S_Nr_3' => NULL,
    'S_Nr_4' => NULL
));
if (!$result) {
    die("Fehler beim Erstellen des Spiels: " . implode(", ", $statement->errorInfo()));
}

$statement2 = $pdo->prepare("INSERT INTO Spielerhand(Hand_ID, Spieler_ID, Spiel_ID, Hand, Ablagestapel, S_1, S_2, S_3, S_4, SpielerNr)
                            VALUES(:Hand_ID, :Spieler_ID, :Spiel_ID, :Hand, :Ablagestapel, :S_1, :S_2, :S_3, :S_4, :SpielerNr)");
$result2 = $statement2->execute(array(
    'Hand_ID' => idate("U"),
    'Spieler_ID' => $Spieler_ID,
    'Spiel_ID' => $Spiel_ID,
    'Hand' => implode(", ", stapel_erstellen(5)),
    'Ablagestapel' => implode(", ", stapel_erstellen($Stapel_size)),
    'S_1' => NULL,
    'S_2' => NULL,
    'S_3' => NULL,
    'S_4' => NULL,
    'SpielerNr' => 1));

if (!$result2) {
    die("Fehler beim Erstellen der Spielerhand: " . implode(", ", $statement2->errorInfo()));
}
echo "<br>";
echo "Spiel wurde erstellt<br>";
echo "Spiel ID: " . $Spiel_ID . "<br>";
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<hr>
<form action="spiel.php" method="post">
    <label for="beitreten">Spiel Beitreten:</label>
    <br>
    <br>
    <input type="text" id="beitreten" name="beitreten" value="<?php echo $Spiel_ID; ?>">
    <input type="submit" value="Beitreten">
</form>
</body>
</html>
