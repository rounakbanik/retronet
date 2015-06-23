<?php
	require_once('controller/functions.php');
	require_once('controller/startsession.php');

	if(!isset($_SESSION['id']))
		header("Location: ".$home_url);

	else
	{
		$page_title = "Match";
		require_once('view/header.php');
		require_once('view/menu_logged.php');
		require_once('view/search.php');

		$sex = $_SESSION['sex'];
		$username = $_SESSION['username'];
		$user_table = "matches_".$sex;
		$user_query = queryMysql("SELECT * FROM $user_table WHERE username = '$username'");

		if($user_query->num_rows == 0)
			echo "<h3 class='oxygen'>Oops! Looks like you haven't filled out the <a class='oxygen' href='questionnaire.php'>questionnaire</a>. 
		              You need to do so in order to see your match.</h3><hr>";
		else
		{
			$responses_user = array();
			$max =0;
			$match_username = 'rounakbanik';

			for($j=1; $j<=25; $j++)
			{
				$temp = $user_query->fetch_array(MYSQLI_ASSOC)['response'];
				array_push($responses_user, $temp);
			}

			if($sex == 'm')
				$matches = "matches_f";
			else
				$matches = "matches_m";

			$people = queryMysql("SELECT DISTINCT(username) AS username FROM $matches");
			$people_number = $people->num_rows;

			if($people_number == 0)
				echo "<h3>Looks like no one from the opposite gender has answered our questions! We're sorry. Maybe 
				you could get some of your friends to join us?</h3><hr>";
			else
			{
				for($i=0; $i<$people_number; $i++)
				{
					$score = 0;
					$person = $people->fetch_array(MYSQLI_ASSOC)['username'];
					$person_query = queryMysql("SELECT * FROM $matches WHERE username='$person'");
					for($j=1; $j<=25; $j++)
					{
						$resp = $person_query->fetch_array(MYSQLI_ASSOC)['response'];

						if($responses_user[$j-1] == $resp)
							$score += 1;
					}

					if($score > $max)
					{
						$max = $score;
						$match_username = $person;
					}
				}

				$winner = queryMysql("SELECT firstname, lastname, image FROM users WHERE username='$match_username'")->fetch_array(MYSQLI_ASSOC);
				$winner_firstname = $winner['firstname'];
				$winner_lastname = $winner['lastname'];
				$winner_image = $winner['image'];

?>
	<div class='row'>
		<h3>And your match is...</h3>
		<hr>
	</div>
	<div>
		<div class='center'><a href="wall.php?person=<?php echo $match_username; ?>">
			<img class='big_thumbnail center block' src='<?php echo $winner_image ?>'></a></div>
		<br>
		<div class='text-center' id='here' style='font-size: 150%'><a href="wall.php?person=<?php echo $match_username; ?>"><?php echo "$winner_firstname $winner_lastname" ?></a></div>
	</div>
	<hr>

<?php
			}
		}

?>
	</body>
</html>
<?php

	}
?>