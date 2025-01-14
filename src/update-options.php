<?php
session_start();

// Manuell gefilterte Firmen
$excludedFirmen = [
    '_extern',
    '_Projekt-Accounts',
    'RDS',
    'RDP',
    'Zentrale',
    'SaB',
    'shared_mailboxes_former_users_tp',
    'shared_mailboxes_former_users_a3md',
    'computer',
    'Computer',
    'user'
]; 
// Manuell gefilterte Abteilungen
$excludedAbteilungen = [
    '_SystemAcc',
    'User',
    'Gruppen',
    'UPNTest',
    'User_Sesam_Zeit',
    'alt'
];

if (isset($_POST['type'])) {
    if ($_POST['type'] == 'standort') {
        if (isset($_POST['selectedStandort'])) {
            header('Content-Type: application/json');
            $selected = $_POST['selectedStandort'];
            
            $newOptions = [];
            foreach ($_SESSION['allous'][$selected] as $key => $value) {
                // Standorte filtern, die in den excludedFirmen oder excludedAbteilungen sind
                if (!in_array($key, $excludedFirmen) && !in_array($value, $excludedAbteilungen)) {
                    $newOption = ["value" => $key];
                    array_push($newOptions, $newOption);
                }
            }
            $response = [
                "status" => "success",
                "data" => $newOptions,
            ];
            echo json_encode($response);
            exit;
        }
    } else if ($_POST['type'] == 'firmen') {
        if (isset($_POST['selectedStandort']) && isset($_POST['selectedFirmen'])) {
            header('Content-Type: application/json');
            $selectedStandort = $_POST['selectedStandort'];
            $selectedFirmen = $_POST['selectedFirmen'];
        
            $newOptions = [];
            foreach ($_SESSION['allous'][$selectedStandort][$selectedFirmen] as $value) {
                // Firmen filtern, die in den excludedFirmen sind
                if (!in_array($value, $excludedAbteilungen)) {
                    $newOption = ["value" => $value];
                    array_push($newOptions, $newOption);
                }
            }
            $response = [
                "status" => "success",
                "data" => $newOptions,
            ];
            echo json_encode($response);
            exit;
        }
    }
}