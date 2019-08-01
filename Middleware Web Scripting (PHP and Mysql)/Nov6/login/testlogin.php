<?php
session_start();
include('functions.php');
$link = connectdb($host, $user, $pass, $db);

	if($_SESSION['authenticate23425243234'] != 'validuser0982')
	{
	authenticateUser();
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>	
	<title>Testing Login</title>
	<style>
	label {display: block;}
	</style>
</head>
<body>
<a href="logout.php">Log out</a>

<?php
	if($_SESSION['authenticate23425243234'] != 'validuser0982')
	{ 
	print "<form method='post' action='testlogin.php'>
	<fieldset><legend>Login</legend>
	<label><input type='text' name='fname'>Fname</label>
	<label><input type='text' name='lname'>Lname</label>
	<label><input type='password' name='pass'>Password</label>
	<label><input type='submit' name='login' value='Login'></label>
	</fieldset>
	</form>";
	}
	else 
	{

?>
<h1>You are logged in</h1>




<?php
}
?>
</body>
</html>
