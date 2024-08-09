<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>A3M Webtool</title>
</head>
</html>
<body>
    <h1>Authentifizierung mit A3M-Active Directory</h1>
    <p>Bitte geben Sie Ihre Login-Daten ein!</p>
    <form action="login" method="post">
        <input type="text" name="username" placeholder="Benutzerkonto" <?php #required?>/><br>
        <input type="password" name="password" placeholder="Passwort" <?php #required?>/><br>
        <input type="submit" value="Login"/><br>
    </form>
</body>
</html>