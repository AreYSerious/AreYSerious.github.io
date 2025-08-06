<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=skip-bo', 'root', '1234');

if(isset($_GET['login'])) {
    $email = strtolower($_POST['email']);
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare("SELECT * FROM Spieler WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && md5($passwort) == $user['Passwort']) {//password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['Spieler_ID'];
        //die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
        header("Location: geheim.php");
    } else {
        $errorMessage = "<p style='color: red'>E-Mail oder Passwort war ungültig</p><br>";
    }

}
?>
<!DOCTYPE html>
<html>
<head>

    <title>Login</title>
</head>
<body>

<?php
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>

<form action="?login=1" method="post">
    E-Mail:<br>
    <input type="email" size="40" maxlength="250" name="email"><br><br>

    Dein Passwort:<br>
    <input type="password" size="40"  maxlength="250" name="passwort"><br>

    <input type="submit" value="Abschicken">
</form>
<ol>
    <li><a href="index.php">Startseite</a></li>
    <li><a href="register.php">Registrieren</a></li>
    <li><a href="logout.php">Logout</a> </li>
    <li><a href="geheim.php">Geheime Seite</a></li>
</ol>
</body>
</html>