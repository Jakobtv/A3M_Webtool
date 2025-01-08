<?php
include("a3m-header.php");
session_start(); // Hier prüfen wir, ob die Session des Benutzers vorhanden ist, da $_SESSION in dem Fall einen Wert zurückgibt.
# Damit verhindern wir, dass ein Benutzer die Seite direkt mit der URL betreten, und somit den Login umgehen kann.
# Ist die Session vorhanden, erscheint das Formular zum Eintragen der benötigten Userdaten
# Ist dies nicht der Fall, wird der Benutzer zur Login-Seite geleitet.

#var_dump($_SESSION);
// Definition einer allgemeinen Error-Message
$errormessage = "Bitte tragen Sie alle benötigten Informationen ein!";
 
// Test ob Session vorhanden ist
if ($_SESSION['a3m_logged_in'] === true) {?>
    <!DOCTYPE html>
    <html>
    <script src="../../js/formDropdown.js"></script>
    <h2>Neuen All3Media-Benutzer anlegen:</h2>
    <div class="inputForm" id="inputForm">
        <form method="post">
        <label for="vorname">Vornamen eingeben:</label>
        <input type="text" name="vorname" required><br>

        <label for="nachname">Nachnamen eingeben:</label>
        <input type="text" name="nachname" required><br><br>
        
        <label for="standort">Standort auswählen:</label>
        <select name="standort" id="standort" onchange="formDropdown()" required>
        
            <?php 
            #$ADou1 = array('Berlin', 'Hürth', 'Köln');
            $ADou1 = array_keys($_SESSION['allous']);
            
            $standortOptionen = '';

            foreach ($_SESSION['allous'] as $standort => $firmenArray) {
                $standortOptionen .= sprintf(
                    '<option>%s</option>',
                    $standort,
                );
                foreach ($firmenArray as $firma => $abteilungenArray) {
                    $firmaOptionen .= sprintf(
                        '<option data-standort="%s">%s</option>',
                        $standort,
                        $firma,
                    );
                    foreach ($abteilungenArray as $abteilung) {
                        $abteilungOptionen .= sprintf(
                            '<option data-standort="%s" data-firma="%s">%s</option>',
                            $standort,
                            $firma,
                            $abteilung,
                        );
                    }
                }
            }
              #  foreach($ADou1 as $standort1) {
                    
               # echo "<option value='$standort1'>$standort1</option>";
            echo $standortOptionen;
            
?> </select><br><br>

        <label for="firmen">Firma auswählen:</label>
        <select name="firmen" id="firmen" required>
            <?=$firmaOptionen ?>
        </select><br><br>

        <label for="abteilungen">Abteilung auswählen:</label>
        <select name="abteilungen" id="abteilungen" required>
            <?=$abteilungOptionen ?>
        </select><br><br>

        <label for="position">Position eingeben:</label>
        <input type="text" name="position" required><br><br>

        <label for="durchwahl">Durchwahl eingeben (Im Zweifel: 0):</label>
        <input type="number" name="durchwahl" value="0" ><br><br>
        
        <label for="ende">Beschäftigungsende angeben:</label>
        <input type="date" name="ende" required><br><br>

        <label for="office">MS Office (j/n):</label>
        <select name="office" required>
            <option value="j">Ja</option>
            <option value="n">Nein</option>   
        </select><br><br>
        
        <label for="boss">Vorgesetzte:n angeben (Nur Nachnamen):</label><br>
        <input type="text" name="boss" required><br><br>

        <button type="submit" id="box">Absenden</button>
        </form>
    </div>

    
    <?php

# php-Code zur Weiterleitung der Benutzer-Daten an das Powershell-Skript

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {   
    #if (isset($_POST['vorname'])) {

        // Variablen-"Cleanup" -> Sicherheit vor Code-Injection
        // und Übergabe der HTML-Form-Daten an die jeweiligen Variablen
        $vorname = htmlspecialchars($_POST['vorname']);
        $nachname = htmlspecialchars($_POST['nachname']);
        $position = htmlspecialchars($_POST['position']);
        $standort = htmlspecialchars($_POST['standort']);
        $firmen = htmlspecialchars($_POST['firmen']);
        $abteilungen = htmlspecialchars($_POST['abteilungen']);
        $durchwahl = htmlspecialchars($_POST['durchwahl']);
        $ende = htmlspecialchars($_POST['ende']);
        $boss = htmlspecialchars($_POST['boss']);
        $office = htmlspecialchars($_POST['office']);
        
        
        shell_exec("powershell.exe -ExecutionPolicy Bypass -file ../../scripts/create-a3m-user.ps1 \"$vorname\" \"$nachname\" \"$position\" \"$standort\"  \"$firmen\" \"$abteilungen\" \"$durchwahl\" \"$ende\" $office \"$boss\"");
        // Ausführen des Create-User-Skripts, und die Übergabe der HTML-Form-Variablen an das Powershell-Skript via Parameter
        
        #header("Location: ".$_SERVER['PHP_SELF']);
        header("Location: ../index.php"); // Schutz vor "Browser-Refresh" - Wir senden den Benutzer zurück zum Menü
        // Damit schützen wir uns davor, dass der Benutzer zweimal die selbe Unit anlegt
        
    }
} else header("Location: a3m-ldap.php"); # Umleitung der in Zweile 3-7 erklärten Login-Funktion

include '../footer.php';