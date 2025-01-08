<?php
session_start();
include 'fp-header.php';
if ($_SESSION['fp_logged_in'] == true) {
    header("Location: create-fp-user.php");
    exit();
} else
?>
<!DOCTYPE html>
<html>
<head>
  <title>A3M-LDAP-Manager</title>
</head>
<body>
    <h3>Bitte geben Sie Ihre Kontoinformationen ein:</h3>
    <form action="fp-ldap-login" method="post">
        <input type="username" name="username" placeholder="Benutzername">
        <input type="password" name="password" placeholder="Passwort"><br><br>
        <input type="submit" value="Login" id="box">
    </form>

    <form action="../index">
        <button id="backtostart">Zurück zum Hauptmenü</button>
    </form>
</body>
</html>

<?php
include '../footer.php';