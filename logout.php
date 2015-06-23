<?php
	require_once('controller/functions.php');
	require_once('controller/startsession.php');

	if(isset($_SESSION['username']))
		destroySession();

	header('Location: '.$home_url);
?>