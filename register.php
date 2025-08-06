<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=skip-bo', 'root', '1234');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrierung</title>
</head>
<body>

<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll

if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $anzeigename = $_POST['anzeigename'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM Spieler WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();

        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
    }
    //Überprüfe, dass der Anzeigename noch nicht registriert wurde
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM Spieler WHERE anzeigename = :anzeigename");
        $result = $statement->execute(array('anzeigename' => $anzeigename));
        $user = $statement->fetch();

        if($user !== false) {
            echo 'Dieser Anzeigename ist bereits vergeben<br>';
            $error = true;
        }
    }

    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {
        $passwort_hash = md5($passwort);


        $statement = $pdo->prepare("INSERT INTO Spieler (email, anzeigename, passwort) VALUES (:email, :anzeigename, :passwort)");
        $result = $statement->execute(array('email' => $email, 'anzeigename' => $anzeigename, 'passwort' => $passwort_hash));

        if($result) {
            echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}

if($showFormular) {
    ?>

    <form action="?register=1" method="post">
        E-Mail:<br>
        <input type="email" size="40" maxlength="250" name="email"><br><br>

        Dein Username:<br>
        <input type="text" size="40" maxlength="250" name="anzeigename"><br><br>

        Dein Passwort:<br>
        <input type="password" size="40"  maxlength="250" name="passwort"><br>

        Passwort wiederholen:<br>
        <input type="password" size="40" maxlength="250" name="passwort2"><br><br>

        <input type="submit" value="Abschicken">
    </form>

    <?php
} //Ende von if($showFormular)
?>
<ol>
    <li><a href="index.php">Startseite</a></li>
    <li><a href="login.php">Login</a></li>
    <li><a href="geheim.php">Geheime Seite</a></li>
</ol>
</body>
</html>