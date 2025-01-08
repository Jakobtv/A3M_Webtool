<?php
include("fp-header.php");
## Hier prüfen wir, ob die Session des Benutzers vorhanden ist, da $_SESSION in dem Fall einen Wert zurückgibt.
## Damit verhindern wir, dass ein Benutzer die Seite direkt mit der URL betreten, und somit den Login umgehen kann.
##
## Ist die Session vorhanden, erscheint das Formular zum Eintragen der benötigten Userdaten
## Ist dies nicht der Fall, wird der Benutzer zur Login-Seite geleitet.
session_start();
# Definition einer allgemeinen Error-Message
$errormessage = "Bitte tragen Sie alle benötigten Informationen ein!";
var_dump($_SESSION["fp_logged_in"]);
if ( $_SESSION['fp_logged_in'] === true) {?>
    <h2>Neuen Filmpool-Benutzer anlegen:</h2>
    <div class="inputForm" id="inputForm">
        <form action="" method="post">
        <label for="vorname">Vornamen eingeben:</label>
        <input type="text" name="vorname" required><br>

        <label for="nachname">Nachnamen eingeben:</label>
        <input type="text" name="nachname" required><br><br>

        <label for="position">Position eingeben:</label>
        <input type="text" name="position" required><br>
        
        <label for="abteilung">Abteilung eingeben:</label>
        <input type="text" name="abteilung" required><br><br>

        <label for="durchwahl">Durchwahl eingeben (Im Zweifel: 0):</label>
        <input type="number" name="durchwahl" value="0" required><br><br>
        
        <label for="ende">Beschäftigungsende angeben:</label>
        <input type="date" name="ende" required><br><br>

        <label for="office">MS Office (j/n):</label>
        <select name="office" required>
            <option value="j">Ja</option>
            <option value="n">Nein</option>   
        </select><br><br>
        
        <label for="boss">Vorgesetzte:n angeben (Nur Nachnamen):</label><br>
        <input type="text" name="boss" required><br>

        <h4><?php if (!isset($_POST['vorname'])) {
        echo $errormessage;
    } ?></h4> <button type="submit" id="box">Absenden</button>
        </form>
    </div>


    <?php # php-Code zur Verarbeitung der Benutzer-Daten

    #if ($_SERVER['REQUEST_METHOD'] == 'POST') {   
    if (isset($_POST['vorname'])) {

        // Variablen-"Cleanup" -> Sicherheit vor Database-Injection
        // und Übergabe der POST-Daten an die jeweiligen Variablen
        ##########################################################
        $vorname = htmlspecialchars($_POST['vorname']);
        $nachname = htmlspecialchars($_POST['nachname']);
        $position = htmlspecialchars($_POST['position']);
        $abteilung = htmlspecialchars($_POST['abteilung']);
        $durchwahl = htmlspecialchars($_POST['durchwahl']);
        $ende = htmlspecialchars($_POST['ende']);
        $boss = htmlspecialchars($_POST['boss']);
        $office = htmlspecialchars($_POST['office']);
        ##########################################################
        // Ende der Übergabe
        
        // Ausführen des Create-Tower-User-Skripts, und die Übergabe der HTML-Form-Variablen an das Powershell-Skript via Parameter
        shell_exec("powershell.exe -ExecutionPolicy Bypass -file ../../scripts/create-fp-user.ps1 \"$vorname\" \"$nachname\" \"$position\" \"$abteilung\" \"$durchwahl\" \"$ende\" $office \"$boss\"");
        
        // Schutz vor "Browser-Refresh" - Wir senden den Benutzer zurück zum Menü
        // Damit schützen wir uns davor, dass der Benutzer zweimal die selbe Unit anlegt
        header("Location: ".$_SERVER['PHP_SELF']);
    
    }
} else header("Location: ../index.php"); # Umleitung der in Zweile 3-7 erklärten Login-Funktion

include '../footer.php';