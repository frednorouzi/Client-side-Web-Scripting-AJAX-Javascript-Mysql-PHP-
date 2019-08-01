<?php
$host = "localhost";
$user = "applem";
$pass = "1010123";
$db = "applem";


function connectdb($host, $user, $pass, $db)
{
$link = mysqli_connect("$host", "$user", "$pass", "$db") or die(mysqli_error($link));
return $link;
}


function authenticateUser()
{
global $link;
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$pass = $_POST['pass'];
$query = "select * from admin where fname='$fname' and
lname='$lname' and password='$pass'";
$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 0)
	{
	$_SESSION['authenticate23425243234'] = "Not Valid!!!";
	}
	else
	{
	$_SESSION['authenticate23425243234'] = "validuser0982";
	}

}




?>