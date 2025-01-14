<?php
include("tp-header.php");
session_start(); // Hier prüfen wir, ob die Session des Benutzers vorhanden ist, da $_SESSION in dem Fall einen Wert zurückgibt.
# Damit verhindern wir, dass ein Benutzer die Seite direkt mit der URL betreten, und somit den Login umgehen kann.
# Ist die Session vorhanden, erscheint das Formular zum Eintragen der benötigten Userdaten
# Ist dies nicht der Fall, wird der Benutzer zur Login-Seite geleitet.

#var_dump($_SESSION);
// Definition einer allgemeinen Error-Message
$errormessage = "Bitte tragen Sie alle benötigten Informationen ein!";
 
// Test ob Session vorhanden ist
if ($_SESSION['tp_logged_in'] === true) {?>
    <!DOCTYPE html>
    <html>
        <div class="form-container">
            <h2>Neuer Tower-Productions-Benutzer</h2>
            <div class="input-form" id="input-form">
                <form method="post" onsubmit="return validatePasswords()">
                    <div class="form-group">
                        <label for="vorname">Vorname</label>
                        <input type="text" name="vorname" required>
                    </div>
                    <div class="form-group">
                        <label for="nachname">Nachname</label>
                        <input type="text" name="nachname" required>
                    </div>
                    <div class="form-group">
                        <label for="standort">Standort</label>
                        <select name="standort" id="standort" onchange="updateOptions('standort')" required>
                            <option value="" disabled selected>Bitte auswählen</option>
                            <?php 
                            #$ADou1 = array('Berlin', 'Hürth', 'Köln');
                            $ADou1 = array_keys($_SESSION['allous']);
                            
                            $standortOptionen = '';
                            $firmaOptionen = '';
                            $abteilungOptionen = '';
                            
                            // Manuell gefilterte Standorte
                            $excludedStandorte = [
                                'A3MO365Contacts',
                                'Builtin',
                                'Computers',
                                'daniel',
                                'deaktiviert',
                                'desd',
                                'Domain Controllers',
                                'ForeignSecurityPrinciples',
                                'Frontend',
                                'groups_azure_a3md',
                                'groups_azure_tp',
                                'Jakob',
                                'Köln',
                                'Managed Service Accounts',
                                'Microsoft Exchange Security Groups',
                                'MMEcustomrecipients',
                                'MMEdistributionlists',
                                'MMEgroups',
                                'Servers',
                                'Users',
                                'users_azure_a3m',
                                'users_azure_tp',
                                'z_andere-user-konten',
                                'z_ausgeschieden_konto-aktiv_vor-loeschen-fragen'
                            ];  
                            
                            // Arrays zum Überprüfen von Duplikaten
                            $uniqueStandorte = [];
                            $uniqueFirmen = [];
                            $uniqueAbteilungen = [];
                            
                            foreach ($_SESSION['allous'] as $standort => $firmenArray) {
                                // Filtere den Standort
                                if (!in_array($standort, $uniqueStandorte) && !in_array($standort, $excludedStandorte)) {
                                    $standortOptionen .= sprintf('<option>%s</option>', $standort);
                                    $uniqueStandorte[] = $standort;
                                }
                            }; 
                            echo $standortOptionen;
                            ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="firmen">Firma</label>
                        <select name="firmen" id="firmen" onchange="updateOptions('firmen')" required>
                            <option value="" disabled selected>Bitte Standort auswählen</option>              
                        </select>
                    </div>    
                    <div class="form-group">
                        <label for="abteilungen">Abteilung</label>
                        <select name="abteilungen" id="abteilungen" onchange="updateOptions('abteilungen')" required>
                            <option value="" disabled selected>Bitte Firma auswählen</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="position">Position</label>
                        <input type="text" name="position" required>
                    </div>
                    <div class="form-group">
                        <label for="durchwahl">Durchwahl (Im Zweifel: 0)</label>
                        <input type="number" name="durchwahl" value="0" >
                    </div>
                    <div class="form-group">
                        <label for="ende">Beschäftigungsende</label>
                        <input type="date" name="ende" required>
                    </div>
                    <div class="form-group">
                        <label for="office">MS Office</label>
                        <select name="office" required>
                            <option value="" disabled selected>Bitte auswählen</option>
                            <option value="j">Ja</option>
                            <option value="n">Nein</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="boss">Vorgesetzte:r</label>
                        <input type="text" name="boss" placeholder="vorname.nachname"required>
                    </div> 
                    <div class="form-group"> 
                        <label for="password">Passwort:</label><br>
                        <input type="password" id="password" name="password" required><br><br>
                        <label for="confirmPassword">Passwort bestätigen:</label><br>
                        <input type="password" id="confirmPassword" name="confirmPassword" required><br><br>
                        <span id="passwordError" style="color: red;"></span><br><br>
                    </div>
                <button type="submit" id="submit-button">Absenden</button>
                </form>
            </div>
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
        $passwort = htmlspecialchars($_POST['password']);
        
        
        shell_exec("powershell.exe -ExecutionPolicy Bypass -file ../../scripts/create-tp-user.ps1 \"$vorname\" \"$nachname\" \"$position\" \"$standort\"  \"$firmen\" \"$abteilungen\" \"$durchwahl\" \"$ende\" $office \"$boss\" \"$passwort\"");
        // Ausführen des Create-User-Skripts, und die Übergabe der HTML-Form-Variablen an das Powershell-Skript via Parameter
        
        #header("Location: ".$_SERVER['PHP_SELF']);
        header("Location: ../index.php"); // Schutz vor "Browser-Refresh" - Wir senden den Benutzer zurück zum Menü
        // Damit schützen wir uns davor, dass der Benutzer zweimal die selbe Unit anlegt
        exit;
    }
} else header("Location: tp-ldap.php"); # Umleitung der in Zweile 3-7 erklärten Login-Funktion

include '../footer.php';
