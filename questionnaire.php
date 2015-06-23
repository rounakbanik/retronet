<?php
	require_once('controller/functions.php');
	require_once('controller/startsession.php');

	if(!isset($_SESSION['id']))
		header("Location: ".$home_url);

	else
	{
		$page_title = 'Questionnaire';
		$username = $_SESSION['username'];
		require_once('view/header.php');
		require_once('view/menu_logged.php');
		require_once('view/search.php');

		if(!isset($_POST['submitted']))
		{
			require_once('view/header.php');
			require_once('view/menu_logged.php');
			require_once('view/search.php');

			$responses = array();
			$matches = "matches_".$_SESSION['sex'];
			$response_query = queryMysql("SELECT * FROM $matches WHERE username='$username'");
			if($response_query->num_rows > 0)
			{
				for($j=1; $j<=25; $j++)
				{
					$temp = $response_query->fetch_array(MYSQLI_ASSOC)['response'];
					array_push($responses, $temp);
				}
			}
?>

<div class='row'>
	<h3 class='text-center'>QUESTIONNAIRE</h3>
	<hr>
</div>
<div class='row'>
	<form method='post' action='questionnaire.php'>
		<label class='block heading'>MOVIES</label>
		<hr>
		<label class='block question'>1. Do you like watching romantic 
			dramas/romatic comedies (such as The Notebook, Just Go With It 
			or Dilwale Dulhaniya Le Jayenge)?</label>
		<label><input required class='radio-inline' required type='radio' name='1' value='3' <?php echo $responses[0]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' required type='radio' name='1' value='4' <?php echo $responses[0]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>2. Do you like watching action/war 
			movies? (such as Fight Club, Troy, Zero Dark Thirty 
			or Border)?</label>
		<label><input required class='radio-inline' type='radio' name='2' value='3' <?php echo $responses[1]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='2' value='4' <?php echo $responses[1]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>3. What about horror movies? (such as The Exorcist, The Shining, Phoonk 
			or The Grudge)?</label>
		<label><input required class='radio-inline' type='radio' name='3' value='3' <?php echo $responses[2]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='3' value='4' <?php echo $responses[2]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<hr>
		<label class='block heading'>SONGS</label>
		<hr>
		<label class='block question'>4. Do you like listening to pop music (Michael Jackson, The Beatles,
			One Direction)?</label>
		<label><input required class='radio-inline' type='radio' name='4' value='3' <?php echo $responses[3]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='4' value='4' <?php echo $responses[3]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>5. Do you like listening to rock/heavy metal (Linkin Park, Red, Metallica
			or Alter Bridge)?</label>
		<label><input required class='radio-inline' type='radio' name='5' value='3' <?php echo $responses[4]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='5' value='4' <?php echo $responses[4]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>6. Do you like Bollywood Music? </label>
		<label><input required class='radio-inline' type='radio' name='6' value='3' <?php echo $responses[5]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='6' value='4' <?php echo $responses[5]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>7. Do you sing or play any musical instrument (such as the Guitar or Drums)? </label>
		<label><input required class='radio-inline' type='radio' name='7' value='3' <?php echo $responses[6]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='7' value='4' <?php echo $responses[6]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<hr>
		<label class='block heading'>BOOKS</label>
		<hr>
		<label class='block question'>8. Do you like reading classics (such as Oliver Twist, A Tale of Two Cities, The 
			Hunchback of Notro Dame or Moby Dick)? </label>
		<label><input required class='radio-inline' type='radio' name='8' value='3' <?php echo $responses[7]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='8' value='4' <?php echo $responses[7]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>9. Do you like reading fantasy literature and mythology (such as Harry Potter, Percy
			Jackson, Lord of the Rings or the Chronicles of Narnia)? </label>
		<label><input required class='radio-inline' type='radio' name='9' value='3' <?php echo $responses[8]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='9' value='4' <?php echo $responses[8]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>10. Are you a fan of detective novels (such as the ones written by the likes
			of Agatha Christie and Arthur Conan Doyle)? </label>
		<label><input required class='radio-inline' type='radio' name='10' value='3' <?php echo $responses[9]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='10' value='4' <?php echo $responses[9]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>11. What about the romance genre (Twilight, The Great Gatsby and the likes)?</label>
		<label><input required class='radio-inline' type='radio' name='11' value='3' <?php echo $responses[10]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='11' value='4' <?php echo $responses[10]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>12. Are you a fan of non-fiction (such as biographies, auto-biographies,
			historic and scientific literature)?</label>
		<label><input required class='radio-inline' type='radio' name='12' value='3' <?php echo $responses[11]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='12' value='4' <?php echo $responses[11]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<hr>
		<label class='block heading'>FOOD</label>
		<hr>
		<label class='block question'>13. Do you like North Indian food (Paneer, Butter Chicken, Malai Kofta)?</label>
		<label><input required class='radio-inline' type='radio' name='13' value='3' <?php echo $responses[12]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='13' value='4' <?php echo $responses[12]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>14. Do you like South Indian Food (Idly, Dosa, Sambar, Rasam)?</label>
		<label><input required class='radio-inline' type='radio' name='14' value='3' <?php echo $responses[13]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='14' value='4' <?php echo $responses[13]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>15. Are you a fast food addict?</label>
		<label><input required class='radio-inline' type='radio' name='15' value='3' <?php echo $responses[14]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='15' value='4' <?php echo $responses[14]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>16. Chinese food, anyone?</label>
		<label><input required class='radio-inline' type='radio' name='16' value='3' <?php echo $responses[15]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='16' value='4' <?php echo $responses[15]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>17. Are you open to the idea of trying new cuisines? (Greek food, maybe?)</label>
		<label><input required class='radio-inline' type='radio' name='17' value='3' <?php echo $responses[16]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='17' value='4' <?php echo $responses[16]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<hr>
		<label class='block heading'>PERSONALITY</label>
		<hr>
		<label class='block question'>18. Do you love travelling? Would you live off a backpack if
			that meant you could travel the world?</label>
		<label><input required class='radio-inline' type='radio' name='18' value='3' <?php echo $responses[17]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='18' value='4' <?php echo $responses[17]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>19. Are you a fan of the fine arts? Do you like delving into History, Politics,
			Psychology, Philology, Philosophy et cetera?</label>
		<label><input required class='radio-inline' type='radio' name='19' value='3' <?php echo $responses[18]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='19' value='4' <?php echo $responses[18]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>20. Do you consider yourself a geek? Do you find yourself spending more
			time with gadgets, anime, comic books than people?</label>
		<label><input required class='radio-inline' type='radio' name='20' value='3' <?php echo $responses[19]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='20' value='4' <?php echo $responses[19]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>21. Which language do you speak the MOST fluently in?</label>
		<label><input required class='radio-inline' type='radio' name='21' value='3' <?php echo $responses[20]==3 ? "checked" : ""; ?>><span class='oxygen'>English</span></label>
		<label><input required class='radio-inline' type='radio' name='21' value='4' <?php echo $responses[20]==4 ? "checked" : ""; ?>><span class='oxygen'>Hindi</span></label>
		<br><br>
		<label class='block question'>22. Are you an extrovert? Do you consider yourself 
			a party animal?</label>
		<label><input required class='radio-inline' type='radio' name='22' value='3' <?php echo $responses[21]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='22' value='4' <?php echo $responses[21]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<label class='block question'>23. Do you believe in casual dating and short-term affairs or are you more of 
		a one-man/one-woman kind of person? </label>
		<label><input required class='radio-inline' type='radio' name='23' value='3' <?php echo $responses[22]==3 ? "checked" : ""; ?>><span class='oxygen'>One Life One Love</span></label>
		<label><input required class='radio-inline' type='radio' name='23' value='4' <?php echo $responses[22]==4 ? "checked" : ""; ?>><span class='oxygen'>Casual Dating</span></label>
		<br><br>
		<label class='block question'>24. Success or relationships?</label>
		<label><input required class='radio-inline' type='radio' name='24' value='3' <?php echo $responses[23]==3 ? "checked" : ""; ?>><span class='oxygen'>Success</span></label>
		<label><input required class='radio-inline' type='radio' name='24' value='4' <?php echo $responses[23]==4 ? "checked" : ""; ?>><span class='oxygen'>Relationships</span></label>
		<br><br>
		<label class='block question'>25. Do you play or actively follow any sport?</label>
		<label><input required class='radio-inline' type='radio' name='25' value='3' <?php echo $responses[24]==3 ? "checked" : ""; ?>><span class='oxygen'>Yes</span></label>
		<label><input required class='radio-inline' type='radio' name='25' value='4' <?php echo $responses[24]==4 ? "checked" : ""; ?>><span class='oxygen'>No</span></label>
		<br><br>
		<input type='submit' class='btn btn-lg btn-primary' value='Show me my match!' name='submitted'> 
	</form>
</div>

<?php
			require_once('view/footer.php');
		}

		else
		{
			if($_SESSION['sex']=='m')
				$matches = "matches_m";
			else
				$matches = "matches_f";

			$existence = queryMysql("SELECT * FROM $matches WHERE username='$username'");
			$existence_number = $existence->num_rows;

			if($existence_number == 0)
			{
				for($j=1; $j<=25; $j++)
				{
					$response = $_POST["$j"];
					queryMysql("INSERT INTO $matches VALUES('$username', '$j', '$response')");
				}
			}
			else
			{
				for($j=1; $j<=25; $j++)
				{
					$response = $_POST["$j"];
					queryMysql("UPDATE $matches SET response='$response' WHERE username='$username' AND q_id='$j' ");
				}
			}
			header("Location: match.php#here");
		}
	}
?>