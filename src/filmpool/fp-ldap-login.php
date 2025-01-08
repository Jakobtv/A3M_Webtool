<?php
require_once __DIR__ . '/../../vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();


include_once 'a3m-ldap.php';

// Daten zur Authentifizierung
$domain = $_ENV['FP_LDAP_DOMAIN']; // Domain für die LDAP-Authentifizierung
$ldapconfig['host'] = $_ENV['FP_LDAP_HOST']; // LDAP-Server-Name
$ldapconfig['port'] = $_ENV['FP_LDAP_PORT']; // LDAP-Standart-Port
$ldapconfig['basedn'] = $_ENV['FP_LDAP_DN']; // Base-DN (Distinguished-Name)

$ds = ldap_connect($ldapconfig['host'], $ldapconfig['port']);

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
ldap_set_option($ds, LDAP_OPT_NETWORK_TIMEOUT, 5);

if (!empty($_POST['username']) && !empty($_POST['password']) ){
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $username = $_POST['username'];
        $password = $_POST['password'];
        $dn = $username. "@" . $domain;
        if ($bind=@ldap_bind($ds, $dn, $password)) {
            session_destroy();
            session_start();
            $_SESSION['fp_logged_in'] = true;
            header("Location: create-fp-user.php");
    } else {
        echo "Login fehlgeschlagen - Bitte überprüfen Sie Ihre Login-Daten";
        @session_destroy();
        }
    }
}