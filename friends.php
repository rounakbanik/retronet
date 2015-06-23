<?php
	require_once('controller/functions.php');
	require_once('controller/startsession.php');

	if(!isset($_SESSION['id']))
	{
		header("Location: ".$home_url);
	}
	else
	{
		$page_title = "Friends";

		$username = $_SESSION['username'];

		queryMysql("UPDATE users SET followers_new=0 WHERE username='$username'");

		require_once("view/header.php");
		require_once("view/menu_logged.php");
		require_once("view/search.php");

		$followers = queryMysql("SELECT follower FROM followers WHERE followee='$username'");
		$followers_number = $followers->num_rows;
		$following = queryMysql("SELECT followee FROM followers WHERE follower='$username'");
		$following_number = $following->num_rows;

		$f1 = array();
		$f2 = array();
		$f3 = array();
?>
	<div class='row'>
		<div class='col-md-4 border-right frn'>
			<h3 class='lato'>FOLLOWERS: <?php echo $followers_number ?></h3>
			<hr>
<?php


		for($j=0; $j<$followers_number; $j++)
		{
			$follower = $followers->fetch_array(MYSQLI_ASSOC)['follower'];
			array_push($f1, $follower);
			$person = queryMysql("SELECT firstname, lastname, image FROM users WHERE username='$follower'")->fetch_array(MYSQLI_ASSOC);
			$person_firstname = $person['firstname'];
			$person_lastname = $person['lastname'];
			$person_image = $person['image'];
?>

			<div class='padding'>
				<img class='inline thumbnail' style='display:inline; width:50px; height:50px' src='<?php echo $person_image; ?>'>
				<span><a class='oxygen' href='wall.php?person=<?php echo $follower ?>'>
					  <?php echo "$person_firstname $person_lastname" ?></a></span>
			</div>
			<br>
<?php
		}
?>
		</div>
		<div class='col-md-4 border-right frn'>
			<h3 class='lato'>FOLLOWING: <?php echo $following_number ?></h3>
			<hr>
<?php
		for($j=0; $j<$following_number; $j++)
		{
			$followee = $following->fetch_array(MYSQLI_ASSOC)['followee'];
			array_push($f2, $followee);
			if(in_array($followee, $f1))
			{
				array_push($f3, $followee);
			}
			$person = queryMysql("SELECT firstname, lastname, image FROM users WHERE username='$followee'")->fetch_array(MYSQLI_ASSOC);
			$person_firstname = $person['firstname'];
			$person_lastname = $person['lastname'];
			$person_image = $person['image'];
?>

			<div class='padding'>
 				<img style='display:inline; width:50px; height:50px' class='inline thumbnail' src='<?php echo $person_image; ?>'>
 				<span><a class='oxygen' href='wall.php?person=<?php echo $followee ?>'>
 					<?php echo "&nbsp;$person_firstname $person_lastname" ?></a></span>
			</div>
			<br>
<?php
		}
?>
		</div>
		<div class='col-md-4 frn'>
			<h3 class='lato'>FRIENDS: <?php echo count($f3) ?></h3>
			<hr>
<?php
		foreach($f3 as $friend)
		{
			$person = queryMysql("SELECT firstname, lastname, image FROM users WHERE username='$friend'")->fetch_array(MYSQLI_ASSOC);
			$person_firstname = $person['firstname'];
			$person_lastname = $person['lastname'];
			$person_image = $person['image'];

?>

			<div class='padding'>
 				<img style='display:inline; width:50px; height:50px' class='inline thumbnail' src='<?php echo $person_image; ?>'>
 				<span><a class='oxygen' href='wall.php?person=<?php echo $friend ?>'>
 					  <?php echo "&nbsp;$person_firstname $person_lastname" ?></a></span> 
			</div>
			<br>
<?php
		}
?>
		</div>
	</div>	
<?php
		require_once("view/footer.php");
	}
?>