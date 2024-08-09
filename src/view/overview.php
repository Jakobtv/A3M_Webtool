<title>Übersicht</title>


<?php

if (preg_match('#/overview.php#', $_SERVER['REQUEST_URI'])) {
	header("Location: home.php");
}
session_start();
$welcome_name = $_POST['username'];
if (! empty($_SESSION['logged_in'])) {
    
?>
	<h1>Active Directory-Management</h1>

	<?php echo "Willkommen!" . $welcome_name; ?>
	


	<br><br>
	<form action="tower-prod.php">
		<input type="submit" value="Tower Productions">
	</form>

	
	<form action="filmpool.php">
		<input type="submit" value="Filmpool">
	</form>
	

	<form action="all3media.php">
		<input type="submit" value="All3Media">
	</form>

	
	<form action="logout.php" method="post">
		<input type="submit" value="Logout">
	
	</form>
<?php
}
else
{
    echo 'Sie sind nicht eingeloggt.' ?> 
	<form action="index.php" method="post">
		<input type="submit" value="Hier gehts zum Login">
	</form>
	<?php
}

	
