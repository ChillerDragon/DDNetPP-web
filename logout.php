<head>
    <link rel="stylesheet" href="style.css"></style>
    <link href="http://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet" type="text/css">
    <title>Chilli.* teeworlds page (logout)</title>
</head>

<?php
session_start();
require_once(__DIR__ . "/global.php");


if ($_SESSION['csLOGGED'] !== "online")
{
	session_destroy();
	echo "you are not logged in";
}
else
{
	session_destroy();
	echo "logged out.";
}


echo "
<script type=\"text/javascript\">
  window.setTimeout(function()
  {
    window.location.href='index.php';
  }, 2000);
</script>
";


echo "<form><input type=\"button\" value=\"back\" onclick=\"window.location.href='index.php'\" /></form>";

?>
