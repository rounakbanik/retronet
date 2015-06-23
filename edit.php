<?php
	$page_title='Edit Profile';
	require_once('controller/functions.php');
	require_once('controller/startsession.php');
	require_once('view/header.php');

	if(!isset($_SESSION['id']))
		header("Location: ".$home_url);

	else 
	{
		$id = $_SESSION['id'];
		$username = $_SESSION['username'];

		require_once('view/menu_logged.php');
		require_once('view/search.php');

		$about = queryMysql("SELECT firstname, lastname, image FROM users WHERE id='$id'")->fetch_array(MYSQLI_ASSOC);
		$interests = queryMysql("SELECT * FROM metadata WHERE id='$id'")->fetch_array(MYSQLI_ASSOC);
		$firstname = $about['firstname'];
		$lastname = $about['lastname'];
		$image = $about['image'];
		$movie = $interests['movie'];
		$song = $interests['song'];
		$quote = $interests['quote'];
		$school = $interests['school'];
		$sport = $interests['sport'];
		$college = $interests['college'];
		$religion = $interests['religion'];
		$politics = $interests['politics'];
		$sex = $_SESSION['sex'];
		$good_image = FALSE;

		if(isset($_POST['submit-about']) && $_POST['firstname'] != '' && $_POST['lastname'] != '')
		{
			$firstname = sanitizeString($_POST['firstname']);
			$lastname = sanitizeString($_POST['lastname']);
			$school = sanitizeString($_POST['school']);
			$college = sanitizeString($_POST['college']);
			$movie = sanitizeString($_POST['movie']);
			$song = sanitizeString($_POST['song']);
			$quote = sanitizeString($_POST['quote']);
			$sport = sanitizeString($_POST['sport']);
			$religion = sanitizeString($_POST['religion']);
			$politics = sanitizeString($_POST['politics']);
			$image = sanitizeString($_FILES['image']['name']);
			$image_type = $_FILES['image']['type'];
			$image_size = $_FILES['image']['size'];

			if(isset($_FILES['image']['name']) && ($image_type == 'image/gif' || $image_type == 'image/jpeg' || 
			   $image_type == 'image/pjpeg' || $image_type == 'image/png') && ($image_size > 0 && $image_size <= MM_MAXFILESIZE))
			{
				$image = "dp/$username.jpg";
				if(move_uploaded_file($_FILES['image']['tmp_name'], $image))
				{
					$good_image = TRUE;
					$result3 = queryMysql("UPDATE users SET image='$image' WHERE id='$id'");
				}
			}
			else
			{
				if(!empty($image))
					echo "<div class='row oxygen text-center' 
				      		style='color:red'>Make sure you've uploaded an image and that it is under 128 KB. :(</div>";
				$image = $about['image'];
			}

			$result1 = queryMysql("UPDATE users SET firstname = '$firstname', lastname= '$lastname' WHERE id='$id'");
			$result2 = queryMysql("UPDATE metadata SET school='$school', college= '$college', movie= '$movie', sport= '$sport',
				                   song= '$song', quote= '$quote', religion= '$religion', politics = '$politics' WHERE id='$id'");
			if($result1 && $result2)
				echo "<div class='row oxygen text-center' style='color:green'>Your changes have been saved. :)</div><hr>";
		}


echo <<<_END

<div class='row'>
<div class='col-md-8 form-edit' style='margin-left:16.66%; margin-right:16.66%; padding-bottom:10px' >
	<h2 id='here'>ABOUT ME</h2>
	<hr>
	<div>
		<img class='dp' src="$image" style='border: 2px solid #bbb'>
	</div>
	<hr>
	<h4 class='text-center'>Please click on 'Save Changes' to save your changes</h4>
	<hr>
	<div>
		<form enctype='multipart/form-data' method='post' action='edit.php'>
			<div class='form-group'>
				<label for="image">Change Profile Picture</label>
      			<input type="file"  class='oxygen' id="image" name="image">
			</div>
			<div class='form-group'>
				<label for='firstname'>First Name* </label>
				<input class='form-control oxygen' type='text' name='firstname' maxlength='16' value="$firstname" required>
			</div>
			<div class='form-group'>
				<label for='lastname'>Last Name*</label>
				<input class='form-control oxygen' type='text' name='lastname' maxlength='16' value="$lastname" required>
			</div>
			<div class='form-group'>
				<label for='school'>School</label>
				<input class='form-control oxygen' type='text' name='school' value="$school">
			</div>
			<div class='form-group'>
				<label for='college'>College</label>
				<input class='form-control oxygen' type='text' name='college' value="$college">
			</div>
			<div class='form-group'>
				<label for='movie'>Favorite Movie</label>
				<input class='form-control oxygen' type='text' name='movie' value="$movie">
			</div>
			<div class='form-group'>
				<label for='song'>Favorite Song</label>
				<input class='form-control oxygen' type='text' name='song' value="$song">
			</div>
			<div class='form-group'>
				<label for='quote'>Favorite Quote</label>
				<input class='form-control oxygen' type='text' name='quote' value="$quote">
			</div>
			<div class='form-group'>
				<label for='sport'>Sport</label>
				<input class='form-control oxygen' type='text' name='sport' value="$sport">
			</div>
			<div class='form-group'>
				<label for='religion'>Religious Views</label>
				<input class='form-control oxygen' type='text' name='religion' value="$religion">
			</div>
			<div class='form-group'>
				<label for='politics'>Political Views</label>
				<input class='form-control oxygen' type='text' name='politics' value="$politics">
			</div>
			<div>
				<input class="btn btn-primary btn-lg btn-block col-md-4" type='submit' value='Save Changes' name='submit-about'>
			</div>
		</form>
	</div>
</div>
</div>		
_END;

		
	}


require_once('view/footer.php');
?>



