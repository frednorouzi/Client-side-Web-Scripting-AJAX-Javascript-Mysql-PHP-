<?php
session_start();
include("finalfunctions.php");
$link = connect($host, $user, $pass, $db);

if($_SESSION['authenticate211385095'] != 'validuser25874934')
{
authenticateperson();
}
?>
<html>
<head><title>User</title>

<style>
b {color: red;}
img.small {
	width: 150px;
    height: 100px;
}
</style>
</head>
<body>



<?php
if($_SESSION['authenticate211385095'] != 'validuser25874934')
{
		print "
		<form method='post' action='user.php'>
	<fieldset><legend>Login</legend>
	<label><input type='text' name='fname'>Fname</label><br>
	<label><input type='text' name='lname'>Lname</label><br>
	<label><input type='password' name='password'>Password</label><br>
	<label><input type='submit' name='login' value='Login'></label>
	</fieldset>
	</form>";

	}
	else
	{
	$Afname = $_SESSION['Afname'];
	$Alname = $_SESSION['Alname'];
	$level = $_SESSION['level'];
	$fileid = $_SESSION['fileid'];
	print "<h1>You are logged in as $Afname $Alname</h1><br>
			<a href='logoutfinal.php'>Logout</a> <br>";
			
		
if(isset($_POST['login']))
{
$userid = $_POST['userid'];
$fileid = $_POST['fileid'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$filename = "lab.txt";

$browser = $_SERVER{'HTTP_USER_AGENT'};
$ip = $_SERVER{'REMOTE_ADDR'};
$string = "$fname $lname on $ip with $browser";
$fp = fopen($filename, 'a') or die("Can not do that");
flock($fp, LOCK_EX);
fwrite($fp, "$string\n");
flock($fp, LOCK_UN);
fclose($fp);

}

if(isset($_GET['lab']))
{
$filename = "lab.txt";
$fp = fopen($filename, 'r') or die("Can not do that");
	while(!feof($fp))
	{
	$line = fgets($fp, 1000);
	print "$line<br>";
	}

}
	?>
	
	
	
	
<a href="user.php?lab=yes">Read Log File</a><br>	
<a href="user.php">Clean</a><br>
<br>
<br>

<?php

print "<fieldset style='float: right'><legend><h1>Upload File</h1></legend>
<form enctype='multipart/form-data' method='post' action='user.php'>
<input type='hidden' name='MAX_FILE_SIZE' value='1000000'>

<br>
<h2>Please fill out the form</h2>
<input type='hidden' name='fname'>
<input type='hidden' name='lname'>
Short Name:<br><input type='text' name='shortname'><br>
Description:<br><input type='text' name='description'><br>
<input type='file' name='userfile'><br>
<input type='submit' name='myupload' value='Load File'>
</form>	</fieldset>
<br>
<br>";
	




if(isset($_POST['myupload']))
{


global $link;
$userfile = $_FILES['userfile']['tmp_name'];
$userfile_name = $_FILES['userfile']['name'];
$userfile_size = $_FILES['userfile']['size'];
$userfile_type = $_FILES['userfile']['type'];
$userfile_error = $_FILES['userfile']['error'];
$shortname = $_POST['shortname'];
$description = $_POST['description'];
$fname = $_POST['fname'];
$lname = $_POS['lname'];
$userid = $_POST['userid'];
$fileid = $_POST['fileid'];	
$filename = $_POST['filename'];	

$userfile_name = time() . $userfile_name;


	if($userfile_error > 0)
	{
	print "<h2>There was a problem uploading the file</h2>";
		switch($userfile_error)
		{
		case 1: print "<h2>File exceeded SERVER file size</h2>"; break;
		case 2: print "<h2>File exceeded MAX file size</h2>"; break;
		case 3: print "<h2>File didn't all transfer</h2>"; break;
		case 4: print "<h2>No file selected</h2>"; break;
		}
	die();
	}

/*	if($userfile_type != 'text/plain')
	{
	print "<h2>That was not a text file</h2>";
	die();
	}
	*/
	
	



	
	
	
	
$upfile = "/home/lubkov/public_html/cisw410/userimages/" . $userfile_name;

	if(is_uploaded_file($userfile))
	{
	$check = move_uploaded_file($userfile, $upfile);
		if(!$check)
		{
		print "<h2>Problem could not move file to destination</h2>";
		die();
		}
	print "<h2>File ($userfile_name) uploaded</h2>";	
	}
	else
	{

	print "<h2>Problem with file -- possible attack</h2>";
	die();

	}

	$query1 = "insert into files values('', '$shortname', '$userfile_name', '$description', CURRENT_DATE, CURRENT_TIME)";
	mysqli_query($link, $query1);
	
		$queryid = "select fileid from books where shortname='$shortname' and filename='$filename'";
		mysqli_query($link, $queryid);
			
			$queryref = "insert into owners values('', '$fileid', '$userid')";
			mysqli_query($link, $queryref);
	

}







if(isset($_GET['editname']))
{
$fileid = $_GET['fileid'];
$shortname = $_GET['shortname'];
$description = $_GET['description'];
$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";

$querymessage = "select * from files where fileid='$fileid' and shortname='$shortname' and description='$description'";
$result = mysqli_query($link, $querymessage);
$row = mysqli_fetch_row($result);
list($fileid, $shortname, $filename, $description, $date, $time) = $row;
$description = revfixname($description);
print "	<fieldset style='float: left'><legend><h1>EDIT</h1></legend>
<form method='post' action='user.php'>\n
<input type='hidden' name='fileid' value='$fileid'>


Short Name:<br> <input type='text' name='shortname' value='$shortname'><br>
Description:<br><textarea name='description' cols='30' rows='6'>$description</textarea>\n<br>
<input type='submit' name='editname2' value='Edit'>\n

</form>\n </fieldset>";
}

if(isset($_POST['editname2']))
{
$fileid = $_POST ['fileid'];
$shortname = $_POST['shortname'];
$description = $_POST['description'];
if(!empty($shortname) and !empty($description))
	{
	$description = fixstrings($description);
	$queryupdate = "update files set shortname='$shortname', description='$description' where fileid='$fileid'";
	mysqli_query($link, $queryupdate);
	print "<b>Update done</b>";
	}
	else
	{
	print "<b>Please fill out the form</b>";
	}
}




if(isset($_GET['deletpic']))
{
$fileid = $_GET['fileid']; 
$filename = $_GET['filename'];

$querynum = "select * from files where fileid='$fileid'";
mysqli_query($link, $querynum);
	$querydel = "delete from files where fileid='$fileid'";
	mysqli_query($link, $querydel);


unlink("/home/lubkov/public_html/cisw410/userimages/".$filename);
print "$filename was deleted";

}
	




/*

$filename = $_GET['filename'];

if(isset($filename))
{
unlink("/home/lubkov/public_html/cisw410/userimages/".$filename);
print "$filename was deleted";
}

/*
if(isset($_POST['deletefile']))
{
$mypic = $_POST['mypic'];
unlink("/home/lubkov/public_html/cisw410/userimages/" . $mypic);
print "<h2>File deleted</h2>";
}




$current_dir = "userimages/";

$dir = opendir($current_dir);

print "<form method='post' action='user.php'>

<h2>The files are:</h2>
<ul>";


	while($file = readdir($dir))
	{
		if($file != "." && $file != "..")
		{
		print "<li><input type='radio' name='mypic' value='$file'><img src='userimages/$file' alt='picture' class='im'></li>";
		}
	}

print "</ul>
<input type='submit' name='deletefile' value='Delete Image'>
</form>";

closedir($dir);

$fileid = $_GET ['fileid'];
$shortname = $_GET['shortname'];
$filename = $_GET['filename'];


	$queryid = "select fileid from files where shortname='$shortname' and filename='$filename'";
	mysqli_query($link, $queryid);

	print "userid=$userid --- fname=$Afname --- fileid=$fileid";

*/




showuser();


?>



























<?php
}
?>
</body>
</html>
