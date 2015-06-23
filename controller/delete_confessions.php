<?php
	require_once('functions.php');
	require_once('startsession.php');
	
	if(!isset($_SESSION['id']))
	{
		header("Location: ".$home_url);
	}

	else
	{
		$confession_id = $_GET['confession_id'];
		$enquiry = queryMysql("SELECT * FROM confessions WHERE confession_id ='$confession_id'")->fetch_array(MYSQLI_ASSOC);

		$recipient = $enquiry['recipient'];
		$username = $_SESSION['username'];

		if($recipient == $username)
		{
			$delete_status = queryMysql("DELETE FROM confessions WHERE confession_id='$confession_id'");
			header("Location: ".$_SERVER['HTTP_REFERER']);
		}
		else
			header("Location".$home_url);
	}
?>