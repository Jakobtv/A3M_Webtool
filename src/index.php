<?php
include 'main-header.php';
?>
<head><title>A3M-LDAP-Manager</title></head> 

<body>
    <h3>Für welchen Branch soll der Benutzer erstellt werden:</h3>
    <form action="all3media/a3m-ldap">
        <button id="choosebox">Neuer All3Media-Benutzer</button>
    </form>

    <form action="filmpool/fp-ldap">
        <button id="choosebox">Neuer Filmpool-Benutzer</button>
    </form>
</body>

<?php
session_start();
include 'footer.php';