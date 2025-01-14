<?php
require_once __DIR__ . '/../../vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();


include_once 'tp-ldap.php';

// Daten zur Authentifizierung
$domain = $_ENV['TP_LDAP_DOMAIN']; // Domain für die LDAP-Authentifizierung
$ldapconfig['host'] = $_ENV['TP_LDAP_HOST']; // LDAP-Server-Name
$ldapconfig['port'] = $_ENV['TP_LDAP_PORT']; // LDAP-Standart-Port = 389
$ldapconfig['basedn'] = $_ENV['TP_LDAP_DN']; // Base-DN (Distinguished-Name)

// $ds stellt eine Verbindung zum LDAP-Server her
$ds = ldap_connect($ldapconfig['host'], $ldapconfig['port']);

// LDAP-Verbindungsoptionen
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
ldap_set_option($ds, LDAP_OPT_NETWORK_TIMEOUT, 5);


// Login-Funktion
if (!empty($_POST['username']) && !empty($_POST['password']) ){
    
    // Login-Daten aus POST auslesen
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $dn = $username. "@" . $domain;

        // Hier wird geprüft ob die eingegebenen Nutzerdaten im LDAP-Verzeichnis vorhanden sind
        if ($bind=ldap_bind($ds, $dn, $password)) {
        // Sind die Nutzerdaten im LDAP-Verzeichnis vorhanden, starte folgenden Ablauf:
            
            // Definiere Filter für eine Benutzerabfrage
            $filter="(&(objectClass=user)(objectCategory=person))";
            $attributes = array("SamAccountName", "CN", "userAccountControl");
            
            // Suche nach allen LDAP-Einträgen und wende die Filter an, gib diese anschließend in einem $userdata-Array aus
            $sr=ldap_search($ds, 'DC=ads,DC=mme,DC=de', $filter, $attributes);
            $info = ldap_get_entries($ds, $sr);
            $userdata = [];

            // Überprüfe ob die User der letzten Suche "aktive" User sind
            foreach ($info as $user) {
                if ($user["useraccountcontrol"][0] != "514") {
                    // Reduziert die Einträge auf Common Name und SamAccountName
                    $userdata[] = [$user["cn"][0], $user["samaccountname"][0]];
                }
            }

            $filter = "(objectClass=organizationalUnit)";

            // Führe die LDAP-Suche nach OUs aus
            $sr=ldap_search($ds, 'DC=ads,DC=mme,DC=de', $filter,["ou"]);
            $info = ldap_get_entries($ds, $sr);
            #var_dump($info[22]["dn"]);

            // Array zum Speichern der OUs initialisieren
            $allOUs = [];
            foreach ($info as $ou) {
                // Extrahiere die OUs aus dem Distinguished Name (DN) der Organisationseinheit
                preg_match_all("/OU=([^,]+),/",$ou["dn"], $matches);
                // Drehe die OUs um, um sie hierarchisch aufzubauen
                $reverseOUs = array_reverse($matches[1]);
                for ($i = 0; $i < count($reverseOUs); $i++) {
                    if ($i == 0) {
                        if (!array_key_exists($reverseOUs[$i], $allOUs)) {
                            $allOUs[$reverseOUs[$i]] = [];
                        } 
                    }
                    if ($i == 1) {
                        if (!array_key_exists($reverseOUs[$i], $allOUs[$reverseOUs[0]])) {
                            $allOUs[$reverseOUs[0]][$reverseOUs[$i]] = [];
                        } 
                    } 
                    if ($i == 2) {
                        if (!in_array($reverseOUs[$i], $allOUs[$reverseOUs[0]][$reverseOUs[1]])) {
                            array_push($allOUs[$reverseOUs[0]][$reverseOUs[1]], $reverseOUs[$i]);
                        } 
                    }
                } 
            }
            
            // Speichere die Abfragen und das Login-Token in der $_SESSION-Globale, um es in anderen Files zugänglich zu machen
            session_start();
            $_SESSION['allous'] = $allOUs;
            $_SESSION['userdata'] = $userdata;
            $_SESSION['tp_logged_in'] = true;
            #print '<pre>';
            #var_dump($_SESSION['allous']);
            #print '</pre>';

            header("Location: create-tp-user.php");
            exit();
    } else {
        // Zeige folgende Meldung, falls der Login nicht erfolgreich ist
        echo "Login fehlgeschlagen - Bitte überprüfen Sie Ihre Login-Daten";
        // Zerstöre die Session, falls der Login fehlschlägt
        session_destroy();
        }} 
}