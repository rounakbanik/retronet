<?php
	require_once('controller/functions.php');
	require_once('controller/startsession.php');

	if(!isset($_SESSION['id']))
		header("Location: ".$home_url);
	else
	{
		$page_title = 'Search';
		require_once('view/header.php');
		require_once('view/menu_logged.php');
		require_once('view/search.php');

		$search_firstname = sanitizeString($_GET['search_firstname']);
		$search_lastname = sanitizeString($_GET['search_lastname']);

		if(empty($search_lastname) && empty($search_firstname))
			header("Location: ".$_SERVER['HTTP_REFERER']);

		else 
		{
?>
<div class='row'><h4>Your search query returned the following results.</h4></div>
<hr>
<?php
			if(!empty($search_lastname) && !empty($search_firstname))
			{
				$result1 = queryMysql("SELECT firstname, lastname, username, image FROM users WHERE firstname LIKE '%$search_firstname%'
				AND lastname LIKE '%$search_lastname%'");
				$result2 = queryMysql("SELECT firstname, lastname, username, image FROM users WHERE firstname LIKE '%search_firstname%'
				OR lastname LIKE '%$search_lastname%'");
			}

			elseif(empty($search_lastname) && !empty($search_firstname))
			{
				$result2 = queryMysql("SELECT firstname, lastname, username, image FROM users WHERE firstname LIKE
					'%$search_firstname%'");
				$result1 = 0;
			}
			else
			{
				$result2 = queryMysql("SELECT firstname, lastname, username, image FROM users WHERE lastname LIKE
					'%$search_lastname%'");
				$result1 = 0;
			}

			$result1_number = $result1->num_rows;
			$result2_number = $result2->num_rows;
?>
<div class='row'>
<?php

			if($result1_number > 0)
			{
				for($i=0; $i<$result1_number; $i++)
				{
					$person = $result1->fetch_array(MYSQLI_ASSOC);

					$person_firstname = $person['firstname'];
					$person_lastname = $person['lastname'];
					$person_image = $person['image'];
					$person_username = $person['username'];
?>


	<div class='col-md-3'>
		<div class='center'>
			<img class='big_thumbnail' src='<?php echo $person_image ?>'>
			<h5><a style='font-size: 150%' href='wall.php?person=<?php echo $person_username ?>'>
				<?php echo "$person_firstname $person_lastname" ?></a></h5>
		</div>
	</div>
<?php
				}
			}

			if($result2_number > 0 && $result1_number ==0)
			{
				for($j=0; $j<$result2_number; $j++)
				{
					$person = $result2->fetch_array(MYSQLI_ASSOC);

					$person_firstname = $person['firstname'];
					$person_lastname = $person['lastname'];
					$person_image = $person['image'];
					$person_username = $person['username'];

?>
	<div class='col-md-3'>
		<div class='center'>
			<a href='wall.php?person=<?php echo $person_username ?>'>
				<img class='big_thumbnail' src='<?php echo $person_image ?>'></a>
			<h5><a style='font-size: 150%' href='wall.php?person=<?php echo $person_username ?>'>
				<?php echo "$person_firstname $person_lastname" ?></a></h5>
		</div>
	</div>


<?php          }
			}
?>
		</div>
	</body>
</html>
<?php

		}


		
	}
?>