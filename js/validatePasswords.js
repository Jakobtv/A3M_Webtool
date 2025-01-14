function validatePasswords() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var passwordError = document.getElementById("passwordError");

    // Überprüfen, ob die Passwörter übereinstimmen
    if (password !== confirmPassword) {
        passwordError.innerHTML = "Die Passwörter stimmen nicht überein!";
        return false;  // Verhindert das Absenden des Formulars
    } else if (password.length < 8) {
        passwordError.innerHTML = "Das Passwort muss mindestens 8 Zeichen lang sein!";
        return false;  // Verhindert das Absenden des Formulars
    } else {
        passwordError.innerHTML = "";  // Kein Fehler
        return true;  // Formular kann abgesendet werden
    }
}