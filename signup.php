<?php
	$page_title= 'Sign Up';
	require_once('controller/functions.php');
	require_once('view/header.php');
	require_once('view/menu_unlog.php');
	echo "<script src='controller/javascript.js'></script>";



	if(isset($_SESSION['username']))
		destroySession();
	
	$error='Sign Up';
	$success = '';


	if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname'])
		&& isset($_POST['sex']) && isset($_POST['password1']))
	{
		$username = sanitizeString($_POST['username']);
		$firstname = sanitizeString($_POST['firstname']);
		$lastname = sanitizeString($_POST['lastname']);
		$password1 = sanitizeString($_POST['password1']);
		$password2 = sanitizeString($_POST['password2']);
		$email = sanitizeString($_POST['email']);
		$sex = sanitizeString($_POST['sex']);

		if($password1 != $password2)
			$error = "Sorry! The Passwords don't match!";
		else
		{
			$result = queryMysql("SELECT * FROM users WHERE username = '$username'");
			$result1 = queryMysql("SELECT * FROM users WHERE email='$email'");

			if($result->num_rows)
			{
				$error = "The username has already been taken!";
			}
			elseif($result1->num_rows)
			{
				$error = "The E-Mail is already in use!";
			}
			else
			{
				if($sex == 'm')
					$image = 'images/default_male.png';
				else
					$image = 'images/default_female.jpg';

				queryMysql("INSERT INTO users(firstname, lastname, username, password, email, sex, image)
					        VALUES('$firstname', '$lastname', '$username', SHA('$password1'), '$email', '$sex', '$image')");
				$row = queryMysql("SELECT id FROM users WHERE username='$username'")->fetch_array(MYSQLI_ASSOC);
				$id = $row['id'];
				queryMysql("INSERT INTO metadata(id) VALUES('$id')");
				$error = '';
				$success = "Your account has been created!";
				$_SESSION['id'] = $id;
				$_SESSION['username'] = $username;
				$_SESSION['sex'] = $sex;
				$_SESSION['password'] = $password1;

				setcookie('id', $id, time() + (60 * 60 * 24 * 30));    // expires in 30 days
          		setcookie('username', $username, time() + (60 * 60 * 24 * 30));
          		setcookie('sex', $sex, time() + (60 * 60 * 24 * 30));
          		setcookie('password', $password1, time() + (60 * 60 * 24 * 30));
			}
		}
	}


	if(!empty($success))
	{
		echo <<<_END
		<div class='row'><img style='display:block; margin-left:auto; margin-right:auto' 
		             class='center' src='images/success.jpg'></div>
		<div class='text-center subtitle'>$success</div>
		<hr>
		<div class='text-center'>You are now logged in. Next, go edit your profile <a href="edit.php#here">here</a></div>
		<hr>
_END;
	}

	else
	{
		echo <<<_END
		<div class='row text-center error subtitle'>$error</div>
		<hr>
		<div class='row form' style='margin-left:auto; margin-right:auto'>
				<h2>SIGNUP</h2>
				<hr>
				<div>
					<form method='post' action='signup.php'>
						<input class='form-control' type='text' name='firstname' maxlength='16' placeholder='First Name' required>
						<input class='form-control' type='text' name='lastname' maxlength='16' placeholder='Last Name' required>
						<input class='form-control' type='email' name='email' placeholder='E-Mail' onBlur='checkEmail(this)' required>
						<span id='info2'></span>
						<input class='form-control' type='text' name='username' placeholder='Username' onBlur='checkUser(this)' required>
						<span id='info1'></span>
						<input class='form-control' type= 'password' name='password1' placeholder='Password' required>
						<input class='form-control' type='password' name='password2' placeholder='Retype Password' required>
						<input class='form-inline' type="radio" name="sex" value="m" required>Male
						<input class='form-inline' type="radio" name="sex" value="f" required>Female<br>
						<input class="btn btn-primary btn-lg" type='submit' value='Sign Up'>
					</form>
				</div>
		</div>
		<hr>
_END;
	}

	require_once('view/footer.php');  
?>