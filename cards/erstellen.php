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
{

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


$statement = $pdo->prepare("INSERT INTO Spiel (Spiel_ID, Anzahl_Spieler, Spieler_ID_ALL, Ablage_Start, Begonnen, ziehstapel, "if(sizeof(":s1") . > 0,":s1", "NULL),". if(sizeof(:s2) > 0, ":s2, NULL), " if(sizeof(:s3) > 0, :s3, NULL),if(sizeof(:s4) > 0, :s4, NULL),S_Nr_1, S_Nr_2, S_Nr_3, S_Nr_4) VALUES (:ID, :spieler, :spieler_ID, :stapel, 0, :ziehstapel, if(sizeof(:s1) > 0, :s1, NULL),if(sizeof(:s2) > 0, :s2, NULL),if(sizeof(:s3) > 0, :s3, NULL),if(sizeof(:s4) > 0, :s4, NULL),:S_Nr_1, :S_Nr_2, :S_Nr_3, :S_Nr_4)");
$result = $statement->execute(array(
    'ID' => $Spiel_ID,
    'spieler' => $Spieler,
    'spieler_ID' => $userid,
    'stapel' => $Stapel,
    'ziehstapel' => implode(", ", $zieh_stapel),
    's1' => implode(", ", Array_aus_Array_List_lesen($Ablagestapel_Mitte_Array, 's1')),
    's2' => implode(", ", Array_aus_Array_List_lesen($Ablagestapel_Mitte_Array, 's2')),
    's3' => implode(", ", Array_aus_Array_List_lesen($Ablagestapel_Mitte_Array, 's3')),
    's4' => implode(", ", Array_aus_Array_List_lesen($Ablagestapel_Mitte_Array, 's4')),
    'S_Nr_1' => $Spieler_ID,
    'S_Nr_2' => NULL,
    'S_Nr_3' => NULL,
    'S_Nr_4' => NULL
));
echo "<br>";
echo "Spiel wurde erstellt<br>";
echo "Spiel ID: " . $Spiel_ID . "<br>";


?>