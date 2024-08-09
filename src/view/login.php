<?php


if (isset($_GET['username']) and isset($_GET['password'])) {
	$_SESSION['logged_in'] = true;
	$ldap_dn = "uid=".$_POST["username"].",dc=example,dc=com";
	$ldap_password = $_POST["password"];

	
	$ldap_con = ldap_connect("ldap.forumsys.com");
	ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);

	if(@ldap_bind($ldap_con,$ldap_dn,$ldap_password))
	session_start();
	header('Location: /overview.php');
	echo "";

	} else {
		echo "Ihre Anmeldedaten sind leider falsch, bitte versuchen Sie es erneut!";
	}
