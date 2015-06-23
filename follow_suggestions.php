<?php
	require_once('controller/functions.php');
	require_once('controller/startsession.php');

	if(!isset($_SESSION['id']))
		header("Location: ".$home_url);

	else
	{
		$page_title = "Follow Suggestions";
		$username = $_SESSION['username'];

		require_once('view/header.php');
		require_once('view/menu_logged.php');
		require_once('view/search.php');

		$following = queryMysql("SELECT * FROM followers WHERE follower='$username'");
		$following_number = $following->num_rows;
		$following_array = array();

		if($following_number == 0)
			echo "<h3 class='oxygen'>Oops! Looks like you aren't following anyone! Maybe you should follow someone and come back to
		              make full use of this feature. You can search for people by typing their names in the 
		              Search Bar. </h3><hr>";
		else
		{
			$query = "SELECT * FROM followers WHERE follower='testmale'";

			for($j=0; $j<$following_number; $j++)
			{
				$person_temp = $following->fetch_array(MYSQLI_ASSOC);
				$person = $person_temp['followee'];

				array_push($following_array, $person);
				$query = $query." OR follower='$person'";
			}

			$query = $query." LIMIT 50";

			$suggestions = queryMysql($query);
			$suggestions_number = $suggestions->num_rows;

			for($j=0; $j<$suggestions_number; $j++)
			{
				$follow_person_temp = $suggestions->fetch_array(MYSQLI_ASSOC);
				$follow_person = $follow_person_temp['followee'];


				if(!in_array($follow_person, $following_array) && $follow_person != $username)
				{
					$follow_query = queryMysql("SELECT firstname, lastname, image FROM users WHERE username='$follow_person'")
				                ->fetch_array(MYSQLI_ASSOC);
					$follow_firstname = $follow_query['firstname'];
					$follow_lastname = $follow_query['lastname'];
					$follow_image = $follow_query['image'];
					array_push($following_array, $follow_person);

?>
<div>
	<img class='inline tiny_thumbnail' src='<?php echo $follow_image ?>'>
	<span>&nbsp;&nbsp;<a href="wall.php?person=<?php echo $follow_person ?>">
		<?php echo "$follow_firstname $follow_lastname" ?></a></span>
	<a href="controller/followers.php?person=<?php echo $follow_person ?>" class='btn btn-default btn-lg oxygen' style='float:right'>
				Follow</a>
</div>
<hr>
<?php
				}
			}

		}
?>

	</body>
</html>
<?php

	}
?>