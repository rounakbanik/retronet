<?php
	require_once('functions.php');

	if(isset($_POST['email']))
	{
		$email = sanitizeString($_POST['email']);
		$result = queryMysql("SELECT * FROM users where email='$email'");

		if($result->num_rows)
			echo "<span class='taken'>&nbsp;&#x2718; " .
            "This email is already in use</span>";
        else
           echo "<span class='available'></span>";

	}
?>