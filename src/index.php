<?php
include 'main-header.php';
?>

<body>
    <h3>Für welchen Branch soll der Benutzer erstellt werden:</h3>
    <div class="button-container">
        <form action="all3media/a3m-ldap">
            <button id="choosebox">Neuer All3Media-Benutzer</button>
        </form>
        <form action="filmpool/fp-ldap">
            <button id="choosebox">Neuer Filmpool-Benutzer</button>
        </form>
        <form action="towerproductions/tp-ldap">
            <button id="choosebox">Neuer Tower Productions-Benutzer</button>
        </form>
    </div>
</body>

<?php
session_start();
include 'footer.php';