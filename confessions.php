<?php
	require_once('controller/functions.php');
	require_once('controller/startsession.php');

	if(!isset($_SESSION['id']))
		header("Location: ".$home_url);
	else
	{
		$page_title = "Confessions";
		$username = $_SESSION['username'];

		queryMysql("UPDATE users SET confessions_new=0 WHERE username='$username'");
		
		$confessions = queryMysql("SELECT * FROM confessions WHERE recipient='$username' ORDER BY time DESC");
		$confession_number = $confessions->num_rows;

		require_once('view/header.php');
		require_once('view/menu_logged.php');
		require_once('view/search.php');

		if($confession_number == 0)
			echo "<h3 class='oxygen text-center'>You do not have any confessions yet.</h3>";

		else
		{
			for($j=$confession_number; $j>0; $j--)
			{
				$confession = $confessions->fetch_array(MYSQLI_ASSOC);
				$confession_id = $confession['confession_id'];
				$confession_messages = $confession['messages'];
				if($confession['author_gender'] == 'm')
					$src = "images/male_symbol.png";
				else
					$src = "images/female_symbol.gif";


echo <<<_END
		<div class='status'>
			<div class='padding' style='border-bottom: 1px solid #bbb'>
				<img  class='inline tiny_thumbnail' src="$src">
				<span>&nbsp;&nbsp;Confession #$j</span>
				<div style='float:right'><a href="controller/delete_confessions.php?confession_id=$confession_id"><img class='micro_thumbnail' src="images/delete_icon.jpeg"></a></div>
			</div>
			<div class='oxygen padding'>$confession_messages</div>
		</div>
		<br>
	</body>
	</html>
_END;
			}
		}

	}
?>

