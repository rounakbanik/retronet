<?php
	$username = $_SESSION['username'];
	$numbers = queryMysql("SELECT followers_new, messages_new, confessions_new FROM users WHERE username='$username'")
	            ->fetch_array(MYSQLI_ASSOC);
	$confessions_new = $numbers['confessions_new'];
	$messages_new = $numbers['messages_new'];
	$followers_new = $numbers['followers_new'];
?>

<div class='row menu'>
			<div class='col-md-2'><a href="index.php">HOME</a></div>
			<div class='col-md-1'><a href="feed.php">FEED</a></div>
			<div class='col-md-2'>
				<span><a href="friends.php">FRIENDS</a></span>
<?php
	if($followers_new > 0)
	{
		echo "<span class='notif'>&nbsp;$followers_new&nbsp;</span>";
	}
?>
			</div>
			<div class='col-md-2'>
				<span><a href="messages.php">MESSAGES</a></span>
<?php
	if($messages_new > 0)
	{
		echo "<span class='notif'>&nbsp;$messages_new&nbsp;</span>";
	}
?>
			</div>
			
			<div class='col-md-1'><a href="edit.php#here">EDIT</a></div>
			<div class='col-md-2'>
				<span><a href="confessions.php">CONFESSIONS</a></span>
<?php
	if($confessions_new > 0)
	{
		echo "<span class='notif'>&nbsp;$confessions_new&nbsp;</span>";
	}
?>
			</div>
			<div class='col-md-2'><a href="logout.php">LOGOUT</a></div>
</div>
<hr>