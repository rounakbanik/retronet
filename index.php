<?php
	$page_title = 'Retronet';
	require_once("controller/functions.php");
	require_once("controller/startsession.php");
	require_once("view/header.php");
?>	

<script type="text/javascript">
	function O(i) { return typeof i == 'object' ? i : document.getElementById(i) }
	function S(i) { return O(i).style                                            }
	function C(i) { return document.getElementsByClassName(i)                    }

	function checkUser(username)
	{
		if(username.value == '')
		{
			O('info1') = '';
			return;
		}

		params  = "username=" + username.value
      	request = new ajaxRequest()
      	request.open("POST", "controller/checkuser.php", true)
      	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
      	request.setRequestHeader("Content-length", params.length)
      	request.setRequestHeader("Connection", "close")

      	request.onreadystatechange = function()
      	{
        	if (this.readyState == 4)
          	if (this.status == 200)
            	if (this.responseText != null)
              	O('info1').innerHTML = this.responseText
      	}
      	request.send(params)
	}

	function checkEmail(email)
	{
		if(email.value == '')
		{
			O('info2') = '';
			return;
		}

		params  = "email=" + email.value
      	request = new ajaxRequest()
      	request.open("POST", "controller/checkemail.php", true)
      	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
      	request.setRequestHeader("Content-length", params.length)
      	request.setRequestHeader("Connection", "close")

      	request.onreadystatechange = function()
      	{
        	if (this.readyState == 4)
          	if (this.status == 200)
            	if (this.responseText != null)
              	O('info2').innerHTML = this.responseText
      	}
      	request.send(params)
	}

	function ajaxRequest()
    {
      	try { var request = new XMLHttpRequest() }
      	catch(e1) {
        	try { request = new ActiveXObject("Msxml2.XMLHTTP") }
        	catch(e2) {
          	try { request = new ActiveXObject("Microsoft.XMLHTTP") }
          	catch(e3) {
            	request = false
      	} } }
      	return request
    }
</script>	

<?php
	if(isset($_SESSION['id']))

	{
		require_once('view/menu_logged.php');
		require_once('view/search.php');

		$id = $_SESSION['id'];
		$username = $_SESSION['username'];

		if(isset($_POST['status-update']))
		{
			$status_upd = sanitizeString($_POST['status-update']);
			queryMysql("INSERT INTO status(recipient, author, status, time) VALUES('$username', '$username', '$status_upd', NOW())");
		}

		$users = queryMysql("SELECT * FROM users WHERE id='$id'")->fetch_array(MYSQLI_ASSOC);
		$metadata = queryMysql("SELECT * FROM metadata WHERE id='$id'")->fetch_array(MYSQLI_ASSOC);
		$status = queryMysql("SELECT * FROM status WHERE recipient='$username' ORDER BY time DESC");
		$status_number = $status->num_rows;

		$firstname = $users['firstname'];
		$lastname = $users['lastname'];
		$image = $users['image'];
		$female_visits = $users['female_visits'];
		$male_visits = $users['male_visits'];

?>

<div class='row'>
	<div class='col-md-4 border-right'>
		<div>
			<h3><?php echo "$firstname $lastname"; ?></h3>
		</div>
		<hr>
		<div class='text-center'>
			<a class='btn btn-lg btn-default oxygen text-center' href='follow_suggestions.php'>Who should I follow?</a>
		</div>
		<hr>
		<div>
			<a class='btn btn-lg btn-danger oxygen' href='questionnaire.php'>Questionnaire</a>
			<a class='btn btn-lg btn-warning oxygen' href='match.php#here'>Matched With Me</a>
		</div>
		<hr>
		<img class='dp frame' src=<?php echo "$image"; ?>>
		<hr>
		<div class='row center'>
			<div class='col-md-6'>
				<img class='tiny_thumbnail' style='display: inline' src="images/female_symbol.gif">
				<span class='subtitle'><?php echo ": $female_visits"; ?></span>
				
			</div>
			<div class='col-md-6'>
				<img class='inline tiny_thumbnail' style='display: inline' src="images/male_symbol.png">
				<span class='subtitle'><?php echo ": $male_visits"; ?></span>
			</div>
		</div>
		<hr>
		<div>
			<p>College: <span class='oxygen'><?php echo $metadata['college']; ?></span></p>
			<p>School: <span class='oxygen'><?php echo $metadata['school']; ?></span></p>
			<p>Favorite Movie: <span class='oxygen'><?php echo $metadata['movie']; ?></span></p>
			<p>Favorite Song: <span class='oxygen'><?php echo $metadata['song']; ?></span></p>
			<p>Favorite Quote: <span class='oxygen'><?php echo $metadata['quote']; ?></span></p>
			<p>Sport: <span class='oxygen'><?php echo $metadata['sport']; ?></span></p>
			<p>Religious Views: <span class='oxygen'><?php echo $metadata['religion']; ?></span></p>
			<p>Political Views: <span class='oxygen'><?php echo $metadata['politics']; ?></span></p>
		</div>
		<hr>
	</div>
	<div class='col-md-8'>
		<div style='padding: 5px'>
			<form method='post' action='index.php'>
				<textarea name='status-update' class='form-control oxygen' rows='3' 
				 placeholder='What would you like the world to know today?' required></textarea>
				<input type='submit' class="btn btn-success btn-lg oxygen " value='Post Update'>
			</form>
		</div>
		<hr>
<?php
		for($j=0; $j<$status_number; $j++)
		{
			$update = $status->fetch_array(MYSQLI_ASSOC);
			$author = $update['author'];
			$status_id = $update['status_id'];
			$info = queryMysql("SELECT firstname, lastname, image FROM users WHERE username='$author'")->fetch_array(MYSQLI_ASSOC);
			$a_image = $info['image'];
			$a_firstname = $info['firstname'];
			$a_lastname = $info['lastname'];
			$text = nl2br($update['status']);


echo <<<_END
		<div class='status'>
			<div class='padding' style='border-bottom: 1px solid #bbb'>
				<img  class='inline thumbnail'src="$a_image">
				<span><a href='wall.php?person=$author'>$a_firstname $a_lastname</a></span>
				<div style='float:right'><a href="controller/delete.php?status_id=$status_id"><img class='micro_thumbnail' src="images/delete_icon.jpeg"></a></div>
			</div>
			<div class='oxygen padding'>$text</div>
		</div>
		<br>
_END;
		}
?>
	</div>
</div>

<?php
	}
	else
	{
		require_once('view/menu_unlog.php');
?>
		
		<div class='row tagline'>
			<div class='col-md-8 info'>The creator of this website placed a bet. That he would build a social networking
				site in a week. The result was Retronet.</div>
			<div class='col-md-4 form'>
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
		</div>
		<hr>
		<div class='row tagline'>
			<div class='col-md-8 info'>Experience Social Networking, retro style. Retronet is a social networking site
				akin to ones built at the starting of the millenium.<br>
				<ul>
				<li>No ads</li> 
				<li>No annoying game requests </li> 
				<li>Profile Visits </li>
				<li>Confessions</li>
				<li>Match</li>
		    	</ul>
		    	<br>
		    	For the complete list of features, click <a href='features.php'>here</a>
		    </div>
			<div class='col-md-4 form'>
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
		</div>
<?php 
	}
	require_once("view/footer.php");
?>