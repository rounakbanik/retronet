<?php
	$page_title = 'Login';
	require_once('controller/functions.php');

	if(isset($_SESSION['id']))
	{
		destroySession();
		header("Location: ".$home_url);
	}

	if(isset($_POST['username']))
	{
		$username = sanitizeString($_POST['username']);
		$password = sanitizeString($_POST['password']);

		if($username == '' || $password == '')
			$error = 'Please enter all fields to log in.';
		
		else
		{
			$result = queryMysql("SELECT * FROM users where username = '$username' AND password = SHA('$password')");

			if($result->num_rows == 0)
			{
				$error = "Username/Password Invalid.";
			} 

			else
			{
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$_SESSION['id'] = $row['id'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['sex'] = $row['sex'];
				$_SESSION['password'] = $password;

				setcookie('id', $row['id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
          		setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));
          		setcookie('sex', $row['sex'], time() + (60 * 60 * 24 * 30));
          		setcookie('password', $password, time() + (60 * 60 * 24 * 30));

          		header('Location: '.$home_url);
			} 
		}
	}


	require_once('view/header.php');
	require_once('view/menu_unlog.php');
	echo <<<_END
		<div class='row text-center error subtitle'>$error</div>
		<hr>
		<div class='row form' style='margin-left:auto; margin-right:auto'>
				<h2>LOGIN</h2>
				<hr>
				<div>
					<form method='post' action='login.php'>
						<input class='form-control' type='text' name='username' placeholder='Username' required>
						<input class='form-control' type= 'password' name='password' placeholder='Password' required>
						<input class="btn btn-primary btn-lg" type='submit' value='Log In'>
					</form>
				</div>
		</div>
		<hr>
_END;

require_once('view/footer.php');

?>
