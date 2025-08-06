<?php
session_start();
session_destroy();


header("Refresh: 3; url=index.php");
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    <h1>Logout erfolgreich</h1>
    <p>Sie wurden erfolgreich ausgeloggt. Sie werden in 3 Sekunden zur Startseite weitergeleitet.</p>
</body>
</html>
