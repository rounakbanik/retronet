<?php

	$username = 'rounakbanik';
	$password = 'theshowmustgoon';

	if(!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) 
		 || $_SERVER['PHP_AUTH_USER'] != $username || $_SERVER['PHP_AUTH_PW'] != $password)
	{
		//The user is not logged in/has entered an invalid username or password. Access is barred.
		header('HTTP/1.1 401 Unauthorized');
		header('WWW-Authenticate: Basic realm = "Retronet"');
		exit('<h2>You must enter a valid username and password to access this page.</h2>');
	}

