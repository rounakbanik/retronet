<?php
	require_once('functions.php');
	require_once('startsession.php');

	if(!isset($_SESSION['id']))
		header("Location: ".$home_url);
	else
	{
		$person = $_GET['person'];
		$username = $_SESSION['username'];

		$follower_status = queryMysql("SELECT * FROM followers WHERE follower='$username' AND followee='$person'")->fetch_array(MYSQLI_ASSOC);

		if($follower_status)
			queryMysql("DELETE FROM followers WHERE follower='$username' AND followee='$person'");
	    else
	    {
	    	queryMysql("INSERT INTO followers VALUES('$person','$username')");
	    	queryMysql("UPDATE users SET followers_new = followers_new+1 WHERE username='$person'");
	   
	    }

	    header("Location: ".$_SERVER['HTTP_REFERER']);
	}
?>