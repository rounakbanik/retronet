<?php // Example 26-1: functions.php
  $dbhost  = 'localhost';    // Unlikely to require changing
  $dbname  = 'retronet_test';   // Modify these...
  $dbuser  = 'root';   // ...variables according
  $dbpass  = 'sweethome';   // ...to your installation
  $appname = "Retronet"; // ...and preference
  $home_url = "http://localhost/vhosts/retronet/index.php";
  define('MM_UPLOADPATH', 'dp/');
  define('MM_MAXFILESIZE', 32768*4); //Maximum size allowed is 128KB


//Make a connection to the database
  $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($connection->connect_error) die($connection->connect_error);

  function createTable($name, $query)
  {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
  }

  function queryMysql($query)
  {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    return $result;
  }

  function destroySession()
  {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time()-2592000, '/');

    setcookie('id', '', time() - (60 * 60 * 24 * 30));    // expires in 30 days
    setcookie('username', '', time() - (60 * 60 * 24 * 30));
    setcookie('sex', '', time() - (60 * 60 * 24 * 30));
    setcookie('password', '', time() - (60 * 60 * 24 * 30));

    session_destroy();
  }

  function sanitizeString($var)
  {
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $connection->real_escape_string($var);
  }

  function showProfile($user)
  {
    if (file_exists("$user.jpg"))
      echo "<img src='$user.jpg' style='float:left;'>";

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if ($result->num_rows)
    {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
    }
  }


?>
