<?php
	require_once('functions.php');
	require_once('startsession.php');
	
	if(!isset($_SESSION['id']))
	{
		header("Location: ".$home_url);
	}

	else
	{
		$status_id = $_GET['status_id'];
		$enquiry = queryMysql("SELECT * FROM status WHERE status_id ='$status_id'")->fetch_array(MYSQLI_ASSOC);

		$author = $enquiry['author'];
		$recipient = $enquiry['recipient'];
		$username = $_SESSION['username'];

		if($author == $username || $recipient == $username)
		{
			$delete_status = queryMysql("DELETE FROM status WHERE status_id='$status_id'");
			header("Location: ".$_SERVER['HTTP_REFERER']);
		}
		else
			header("Location".$home_url);
	}
?>