<?php
	require_once('authorize.php');
?>

<!DOCTYPE hmtl>
<html>
	<head>
		<meta charset="utf-8">
		<title>Setting up Database</title>
	</head>
    <body>	

<?php
	require_once("functions.php");

	createTable('users', 'id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
		                  firstname VARCHAR(16) NOT NULL,
		                  lastname VARCHAR(16) NOT NULL,
		                  username VARCHAR(32) NOT NULL UNIQUE,
		                  password VARCHAR(40) NOT NULL,
		                  sex CHAR(1) NOT NULL,
		                  email VARCHAR(32) NOT NULL UNIQUE,
		                  dob DATE,
		                  image VARCHAR(256),
		                  male_visits INT DEFAULT 0,
		                  female_visits INT DEFAULT 0,
		                  INDEX(firstname(6)),
		                  INDEX(lastname(6)),
		                  INDEX(username(6))');

	createTable('metadata', 'id INT UNSIGNED NOT NULL PRIMARY KEY,
		                     movie TEXT,
		                     song TEXT,
		                     quote TEXT,
		                     sport TEXT,
		                     school TEXT,
		                     college TEXT,
		                     religion TEXT,
		                     politics TEXT');

	createTable('status', 'recipient VARCHAR(32) NOT NULL,
		                   author VARCHAR(32) NOT NULL,
		                   status TEXT NOT NULL,
		                   time DATETIME,
		                   status_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT');

	createTable('messages', 'recipient VARCHAR(32) NOT NULL,
		                     author VARCHAR(32) NOT NULL,
		                     messages TEXT NOT NULL,
		                     time DATETIME');

	createTable('confessions', 'recipient VARCHAR(32) NOT NULL,
		                        messages TEXT NOT NULL,
		                        time DATETIME,
		                        confession_id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
		                        author_gender CHAR(1) NOT NULL');

	createTable('followers', 'followee VARCHAR(32) NOT NULL,
		                      follower VARCHAR(32) NOT NULL');

	createTable('matches_m', 'username VARCHAR(32) NOT NULL,
		                    q_id INT UNSIGNED NOT NULL,
		                    response INT NOT NULL DEFAULT 0');

	createTable('matches_f', 'username VARCHAR(32) NOT NULL,
		                    q_id INT UNSIGNED NOT NULL,
		                    response INT NOT NULL DEFAULT 0');

	echo "The databases have been successfully created. It is now ready for use.";
?>
	</body>
</html>