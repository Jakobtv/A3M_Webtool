<title>Logout</title>

<?php
session_start();
session_destroy();
echo 'Sie wurden erfolgreich ausgeloggt.';
?>
<br>
<form action="index.php" method="post">
	<input type="submit" value="Zurück zum Login">
</form>