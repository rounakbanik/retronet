<?php
	require_once('controller/functions.php');
	require_once('controller/startsession.php');

	if(!isset($_SESSION['id']))
		header("Location".$home_url);

	else
	{
		$page_title = "Messages";

		$username = $_SESSION['username'];

		queryMysql("UPDATE users SET messages_new=0 WHERE username='$username'");

		require_once('view/header.php');
		require_once('view/menu_logged.php');
		require_once('view/search.php');	
		
		$people = queryMysql("SELECT DISTINCT(author) AS author FROM messages WHERE recipient='$username' ORDER BY time DESC");
		$people_number = $people->num_rows;

		if($people_number == 0)
			echo "<h3 class='oxygen text-center'> You do not have any messages yet.</h3>";

		else
		{
			echo "<h3 class='lato text-center'> My Conversations</h3><hr>";
?>
<div class='row'>
	<div class='col-md-2' style='border-right: 1px solid #aaa'>
<?php

			$id = $_SESSION['id'];
			$username = $_SESSION['username'];
			$user1 = queryMysql("SELECT firstname, lastname, image FROM users WHERE id='$id'")->fetch_array(MYSQLI_ASSOC);
			$user1_firstname = $user1['firstname'];
			$user1_lastname = $user1['lastname'];
			$user1_image = $user1['image']; 

			for($j=0; $j<$people_number; $j++)
			{
				$person = $people->fetch_array(MYSQLI_ASSOC)['author'];
				$bio = queryMysql("SELECT firstname, lastname, image 
					FROM users WHERE username='$person'")->fetch_array(MYSQLI_ASSOC);
				$firstname = $bio['firstname'];
				$lastname = $bio['lastname'];
				$src = $bio['image'];
?>

		<div style='border-bottom: 1px solid #bbb; padding: 15px' >
			<a href='messages.php?person=<?php echo $person ?>#here'><img src='<?php echo $src ?>' style='width:100px; height:100px'></a>
			<a href='messages.php?person=<?php echo $person ?>#here'>
				<div class='oxygen'><?php echo "$firstname $lastname"; ?></div></a>
		</div>

<?php

			}
?>
	</div>
<?php
			if(isset($_GET['person']) && $_GET['person'] != $username)
			{
				$person = $_GET['person'];

				if(isset($_POST['sent-message']))
				{
					$sent_message = sanitizeString($_POST['sent-message']);
					queryMysql("INSERT INTO messages(recipient, author, messages, time) 
						   VALUES('$person', '$username', '$sent_message', NOW()) ");
					queryMysql("UPDATE users SET messages_new = messages_new+1 WHERE username='$person'");
				}

				$convo = queryMysql("SELECT author, messages FROM messages WHERE (author='$person' AND recipient='$username') OR 
					(author='$username' AND recipient='$person')");

				$convo_number = $convo->num_rows;

				$user2 = queryMysql("SELECT firstname, lastname, image FROM users WHERE username='$person'")->fetch_array(MYSQLI_ASSOC);
				$user2_firstname = $user2['firstname'];
				$user2_lastname = $user2['lastname'];
				$user2_image = $user2['image'];


?>
	<div class='col-md-10'>
		<div class='row oxygen text-center' style='font-size: 150%'><?php echo "$user2_firstname $user2_lastname" ?></div><hr>
		<div class='border messenger row' style='margin-left:auto; margin-right:auto;'>
<?php

				for($k=0; $k<$convo_number; $k++)
				{
					$conversation = $convo->fetch_array(MYSQLI_ASSOC);
					$msg = nl2br($conversation['messages']);

					if($conversation['author'] == $person)
					{
						$decider_username = $person;
						$decider_firstname = $user2_firstname;
						$decider_lastname = $user2_lastname;
						$decider_image = $user2_image;
					}
					else
					{
						$decider_username = $username;
						$decider_firstname = $user1_firstname;
						$decider_lastname = $user1_lastname;
						$decider_image = $user1_image;
					}

?>
			<div class='row'>
				<div class='col-md-1'>
					<img class='thumbnail' src='<?php echo "$decider_image" ?>'>
				</div>
				<div class='col-md-11'>
					<div><a href='wall.php?person=<?php echo $decider_username ?>'>
					<?php echo "$decider_firstname $decider_lastname" ?></a></div>
					<div class='oxygen'><?php echo $msg; ?></div>
				</div>
			</div>
<?php
				}
			
?>	
			<div id='here'></div>
		</div>
		<div class='row' style='padding:20px;'>
			<form class='center' method='post' action='messages.php?person=<?php echo $person ?>#here'>
				<textarea name='sent-message' class='form-control oxygen' rows='3' required></textarea>
				<input class='btn btn-lg oxygen btn-primary' 
			     	value='Reply' type='submit'>
			</form>
		</div>
	</div>
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