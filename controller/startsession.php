<?php
	session_start();

	if(!isset($_SESSION['username']))
	{
		if(isset($_COOKIE['username']) && isset($_COOKIE['id']) && isset($_COOKIE['password']) && isset($_COOKIE['sex']))
		{
			$_SESSION['id'] = $_COOKIE['id'];
			$_SESSION['username'] = $_COOKIE['username'];
			$_SESSION['password'] = $_COOKIE['password'];
			$_SESSION['sex'] = $_COOKIE['sex'];
		}
	}