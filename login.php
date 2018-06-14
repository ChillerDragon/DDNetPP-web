<?php
require_once(__DIR__ . "/global.php");
session_start();
if (IS_MINER == true)
{
    StartMiner();
}
?>

<html>
        <head>
                <link rel="stylesheet" href="login.css"></style>
                <link href="http://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet" type="text/css">
                <title>ChillBlock5 login</title>
        </head>
</html>

<?php

function print_html_main($fail_reason)
{
	echo
	"
	<!DOCTYPE html>
	<html>
		<body>
			<h2> ChillBlock5 login </h2>
        		<form method=\"post\" action=\"login.php\">
                		<input id=\"username\" type=\"text\" name=\"username\"  placeholder=\"username\"></br>
                		<input id=\"password\" type=\"text\" name=\"password\" type=\"password\" placeholder=\"password\"></br>


				</br></br>
                		<input type=\"submit\" value=\"Login\" >
        		</form>
			<form>
				<input type=\"button\" value=\"back\" onclick=\"window.location.href='index.php'\" />
			</form>
		</body>
	</html>
	";

	if ($fail_reason != "none")
	{
		echo "<font color=\"red\">$fail_reason</font>";
	}
}


if (!empty($_POST['username']) and !empty($_POST['password']))
{
	$username = isset($_POST['username'])? $_POST['username'] : '';
	$password = isset($_POST['password'])? $_POST['password'] : '';

	$db = new PDO(ABSOLUTE_DATABASE_PATH);
	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	$stmt = $db->prepare('SELECT * FROM Accounts WHERE Username = ? and Password = ?');
	$stmt->execute(array($username, $password));

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if ($rows)
	{
		#print_r($rows);
		$name = $rows[0]['Username'];
		$_SESSION['csID'] = $rows[0]['ID'];
		echo "Logged in as '$name' </br>";
		$_SESSION['csLOGGED'] = "online";
		echo "
			<script type=\"text/javascript\">
    				window.setTimeout(function() 
				{
    					window.location.href='index.php';
    				}, 2000);
			</script>
		";
		echo "<form><input type=\"button\" value=\"okay\" onclick=\"window.location.href='index.php'\" /></form>";
	}
	else
	{
		print_html_main("wrong username or password");
		$_SESSION['csLOGGED'] = "failed";
	}
}
else if (!empty($_POST['username']) or !empty($_POST['password']))
{
	print_html_main("both fields are required");
}
else //no name or pw given -> ask for it
{
	print_html_main("none");
}
?>
