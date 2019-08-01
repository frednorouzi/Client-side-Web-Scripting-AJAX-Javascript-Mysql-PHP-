<?php
include("finalfunctions.php");
$link = connect($host, $user, $pass, $db);
?>
<html>
<head><title>Create Account</title>
<style>
b {color: red;}
</style>
</head>
<body>


<?php

print "
		<form method='post' action='createaccount.php'>
	<fieldset><legend>Create Account</legend>
	<label><input type='text' name='fname'>Fname</label><br>
	<label><input type='text' name='lname'>Lname</label><br>
	<label><input type='password' name='password'>Password</label><br>
	<label><input type='submit' name='createaccount' value='Create Account'></label>
	</fieldset>
	</form>";

	
	
if(isset($_POST['createaccount']))
{
$userid = $_POST['adminid'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$password = $_POST['password'];
$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";

	if(preg_match($re, $fname) && preg_match($re, $lname) && $password != "")
	{
	$fname = fixstrings($fname);
	$lname = fixstrings($lname);
	$queryp = "select * from users where fname='$fname' and lname='$lname'";
	$resultp = mysqli_query($link, $queryp);
		if(mysqli_num_rows($resultp) == 0)
		{
		$queryadd = "insert into users values('', '$fname', '$lname', '$password')";
		mysqli_query($link, $queryadd);
		print "<b>Account has been created. Please Login using the new name and password.</b> <a href='final.php'>Home</a>";
		}
		else
		{
		print "<b>There is already an account using that firstname and lastname.</b>";
		}
	}
	else
	{
	print "<b>You did not fill out the form correctly!</b>";
	}

}	
	
	
	
	
	
	
	
	
	

?>
	
	
	
	
	
	
	
	
</body>
</html>
