<?php
session_start();
error_reporting(E_ERROR);
include 'fp-header.php';
if ($_SESSION['fp_logged_in'] == true) {
    header("Location: create-fp-user.php");
    exit();
} else

?>

<body>
    <h3>Bitte geben Sie Ihre Kontoinformationen ein:</h3>
    <form action="fp-ldap-login.php" method="post">
        <input type="username" name="username" placeholder="Benutzername">
        <input type="password" name="password" placeholder="Passwort"><br><br>
    <div class="button-container">
            <input type="submit" value="Login" id="box">
        </form>
    
        <form action="../index">
            <button id="backtostart">Zurück zum Hauptmenü</button>
        </form>
    </div>
</body>

<?php
include '../footer.php';