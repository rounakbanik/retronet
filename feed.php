<?php
	require_once('controller/functions.php');
	require_once('controller/startsession.php');

	if(!isset($_SESSION['id']))
		header("Location: ".$home_url);

	else
	{
		$page_title = "News Feed";
		$username = $_SESSION['username'];

		require_once('view/header.php');
		require_once('view/menu_logged.php');
		require_once('view/search.php');

		$following = queryMysql("SELECT * FROM followers WHERE follower='$username'");
		$following_number = $following->num_rows;

		if($following_number == 0)
			echo "<h3 class='oxygen'>Looks like your Feed is empty! How about you go and follow some of the people you love?</h3>";
		else
		{
			$query = "SELECT * FROM status WHERE author='$username'";

			for($j=0; $j<$following_number; $j++)
			{
				$person_temp = $following->fetch_array(MYSQLI_ASSOC);
				$person = $person_temp['followee'];

				$query = $query." OR author='$person'";
			}

			$query = $query."ORDER BY time DESC LIMIT 50";

			$statuses = queryMysql($query);
			$statuses_number = $statuses->num_rows;

			for($j=0; $j<$statuses_number; $j++)
			{
				$status_temp = $statuses->fetch_array(MYSQLI_ASSOC);
				$author = $status_temp['author'];
				$recipient = $status_temp['recipient'];
				$status = $status_temp['status'];

				$author_query = queryMysql("SELECT firstname, lastname, image FROM users WHERE username='$author'")
				                ->fetch_array(MYSQLI_ASSOC);
				$author_firstname = $author_query['firstname'];
				$author_lastname = $author_query['lastname'];
				$author_image = $author_query['image'];

				$recipient_query = queryMysql("SELECT firstname, lastname FROM users WHERE username='$recipient'")
				                ->fetch_array(MYSQLI_ASSOC);
				$recipient_firstname = $recipient_query['firstname'];
				$recipient_lastname = $recipient_query['lastname'];

?>

<div class='status'>
	<div class='padding' style='border-bottom: 1px solid #bbb'>
		<img class='inline tiny_thumbnail' src='<?php echo $author_image ?>'>
		<span>&nbsp;&nbsp;<a href="wall.php?person=<?php echo $author ?>"><?php echo "$author_firstname $author_lastname" ?></a></span>
<?php
	if($author != $recipient)
		echo "<span>--> <a href='wall.php?person=$recipient'>$recipient_firstname $recipient_lastname</a> </span>";
?>

	</div>
	<div class='oxygen padding'><?php echo "$status" ?></div>
</div>

<?php
			}
		}
?>

	</body>
</html>
<?php

	}
?>