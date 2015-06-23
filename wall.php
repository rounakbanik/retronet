<?php
	require_once("controller/functions.php");
	require_once("controller/startsession.php");

	if(!isset($_SESSION['id']))
	{
		header("Location: ".$home_url);
	}
	elseif(!isset($_GET['person']) || $_GET['person'] == $_SESSION['username'])
	{
		header("Location: ".$home_url);
	}
	else
	{
		$username = $_SESSION['username'];
		$person = $_GET['person'];
		$gender = $_SESSION['sex'];

		if($_SESSION['sex']=='m')
		{
			queryMysql("UPDATE users SET male_visits=male_visits+1 WHERE username='$person'");
		}
		else
			queryMysql("UPDATE users SET female_visits=female_visits+1 WHERE username='$person'");


		if(isset($_POST['person-status-update']))
		{
			$person_status_upd = sanitizeString($_POST['person-status-update']);
			queryMysql("INSERT INTO status(recipient, author, status, time) VALUES('$person', '$username', '$person_status_upd', NOW())");
		}

		if(isset($_POST['person-confession']) && !empty($_POST['person-confession']))
		{
			$person_confession = sanitizeString($_POST['person-confession']);
			queryMysql("INSERT INTO confessions(recipient, messages, time, author_gender) 
				VALUES('$person', '$person_confession', NOW(), '$gender')");
			queryMysql("UPDATE users SET confessions_new=confessions_new+1 WHERE username='$person'");
		}

		if(isset($_POST['person-message']) && !empty($_POST['person-message']))
		{
			$person_message = sanitizeString($_POST['person-message']);
			queryMysql("INSERT INTO messages(recipient, author, messages, time)
			    VALUES('$person', '$username', '$person_message', NOW()) ");
			queryMysql("UPDATE users SET messages_new = messages_new+1 WHERE username='$person'");
		}

		$person_bio = queryMysql("SELECT * FROM users WHERE username='$person'")->fetch_array(MYSQLI_ASSOC);
		$person_id = $person_bio['id'];
		$person_metadata = queryMysql("SELECT * FROM metadata WHERE id='$person_id'")->fetch_array(MYSQLI_ASSOC);
		$person_status = queryMysql("SELECT * FROM status WHERE recipient='$person' ORDER BY time DESC");
		$person_status_number = $person_status->num_rows;

		$person_firstname = $person_bio['firstname'];
		$person_lastname = $person_bio['lastname'];
		$person_image = $person_bio['image'];
		$person_male_visits = $person_bio['male_visits'];
		$person_female_visits = $person_bio['female_visits']; 

		$page_title = "$person_firstname $person_lastname";

		$friend_status = queryMysql("SELECT * FROM followers WHERE follower='$username' AND followee='$person'")->fetch_array(MYSQLI_ASSOC);
		if($friend_status)
			$follow = "&nbsp;&#x2714; Following";
		else
			$follow = 'Follow';

		require_once("view/header.php"); 
		require_once("view/menu_logged.php");
		require_once("view/search.php");

		if(isset($_POST['person-confession']))
			echo "<div class='row success text-center oxygen'> Your confession has been sent.</div><hr>";
		elseif(isset($_POST['person-message']))
		{
			echo "<div class='row success text-center oxygen'> Your message has been sent.</div><hr>";
		}

?>

<div class='row'>
	<div class='col-md-4 border-right'>
		<div>
			<span style='font-size:175%'><?php echo "$person_firstname $person_lastname"; ?></span>
			<a href="controller/followers.php?person=<?php echo $person ?>" class='btn btn-default btn-lg oxygen' style='float:right'>
				<?php echo $follow ?></a>
		</div>
		<hr>
		<img class='dp frame' src=<?php echo "$person_image"; ?>>
		<hr>
		<div class='row center'>
			<div class='col-md-6'>
				<img class='tiny_thumbnail' style='display: inline' src="images/female_symbol.gif">
				<span class='subtitle'><?php echo ": $person_female_visits"; ?></span>
				
			</div>
			<div class='col-md-6'>
				<img class='inline tiny_thumbnail' style='display: inline' src="images/male_symbol.png">
				<span class='subtitle'><?php echo ": $person_male_visits"; ?></span>
			</div>
		</div>
		<hr>
		<div>
			<p>College: <span class='oxygen'><?php echo $person_metadata['college']; ?></span></p>
			<p>School: <span class='oxygen'><?php echo $person_metadata['school']; ?></span></p>
			<p>Favorite Movie: <span class='oxygen'><?php echo $person_metadata['movie']; ?></span></p>
			<p>Favorite Song: <span class='oxygen'><?php echo $person_metadata['song']; ?></span></p>
			<p>Favorite Quote: <span class='oxygen'><?php echo $person_metadata['quote']; ?></span></p>
			<p>Sport: <span class='oxygen'><?php echo $person_metadata['sport']; ?></span></p>
			<p>Religious Views: <span class='oxygen'><?php echo $person_metadata['religion']; ?></span></p>
			<p>Political Views: <span class='oxygen'><?php echo $person_metadata['politics']; ?></span></p>
		</div>
		<hr>
	</div>
	<div class='col-md-8'>
		<div class='row'>
			<div class='col-md-6'>
				<form method='post' action='wall.php?person=<?php echo $person ?>'>
					<textarea name='person-message' class='form-control oxygen' rows='3'
					placeholder='Message <?php echo $person_firstname ?>' required></textarea>
					<input type='submit' class='btn btn-danger btn-lg oxygen' value='Send Message'>
				</form>
			</div>
			<div class='col-md-6'>
				<form method='post' action='wall.php?person=<?php echo $person ?>'>
					<textarea name='person-confession' class='form-control oxygen' rows='3'
					placeholder='Confess to <?php echo $person_firstname ?>' required></textarea>
					<input type='submit' class='btn btn-warning btn-lg oxygen' value='Send Confession'>
				</form>
			</div>
		</div>
		<hr>

<?php
		$check1 = queryMysql("SELECT * FROM followers WHERE follower='$person' AND followee='$username'")->fetch_array(MYSQLI_ASSOC);
		$check2 = queryMysql("SELECT * FROM followers WHERE follower='$username' AND followee='$person'")->fetch_array(MYSQLI_ASSOC);


		if($check1 && $check2)
		{
?>
			<div style='padding: 5px'>
				<form method='post' action='wall.php?person=<?php echo $person ?>'>
					<textarea name='person-status-update' class='form-control oxygen' rows='3' 
				 	placeholder="Post on <?php echo $person_firstname ?>'s wall" required></textarea>
					<input type='submit' class="btn btn-success btn-lg oxygen " value='Post Update'>
				</form>
			</div>
			<hr>

<?php
		}

		for($j=0; $j<$person_status_number; $j++)
		{
			$person_update = $person_status->fetch_array(MYSQLI_ASSOC);
			$person_author = $person_update['author'];
			$person_status_id = $person_update['status_id'];
			$person_info = queryMysql("SELECT firstname, lastname, image FROM users WHERE username='$person_author'")->fetch_array(MYSQLI_ASSOC);
			$person_a_image = $person_info['image'];
			$person_a_firstname = $person_info['firstname'];
			$person_a_lastname = $person_info['lastname'];
			$person_text = nl2br($person_update['status']);
			echo $person_text->num_rows;


			echo "<div class='status'>";
			echo "<div class='padding' style='border-bottom: 1px solid #bbb'>";
			echo "	<img  class='inline thumbnail'src='$person_a_image'>";
			echo "	<span><a href='wall.php?person=$person_author'>$person_a_firstname $person_a_lastname</a></span>";
			if($person_author == $username)
			{
				echo "<div style='float:right'><a href='controller/delete.php?status_id=$person_status_id'>";
				echo "     <img class='micro_thumbnail' src='images/delete_icon.jpeg'></a></div>";
		    }
			echo "</div>";
			echo "<div class='oxygen padding'>$person_text</div>";
		    echo "</div>";
		    echo "<br>";

		}
	


	}
?>

	</div>
</div>

