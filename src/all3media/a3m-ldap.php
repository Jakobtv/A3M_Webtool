<?php
session_start();
error_reporting(E_ERROR);
include 'a3m-header.php';
if ($_SESSION['a3m_logged_in'] == true) {
    header("Location: create-a3m-user.php");
    exit();
} else

?>

<body>
    <h3>Bitte geben Sie Ihre Kontoinformationen ein:</h3>
    <form action="a3m-ldap-login.php" method="post">
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