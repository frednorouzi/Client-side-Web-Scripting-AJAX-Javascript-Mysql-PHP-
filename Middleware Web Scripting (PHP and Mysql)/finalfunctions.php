<?php
$host = "localhost";
$user = "norouzif";
$pass = "1426193";
$db = "norouzif";


/* CONNECT SCRIPT*/

function connect($host, $user, $pass, $db) 
{
$link = mysqli_connect($host, $user, $pass, $db) or die("Error ".mysqli_error($link));
return $link;
}



function authenticateperson()
{
global $link;
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$password = $_POST['password'];
$query = "select * from users where fname='$fname' and
lname='$lname' and password='$password'";
$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 0)
	{
	$_SESSION['authenticate211385095'] = "Incorrect Login";
	
	}
	else
	{
	$row = mysqli_fetch_row($result);
	list($userid, $fname, $lname, $password, $level) = $row;
	$_SESSION['authenticate211385095'] = "validuser25874934";
	$_SESSION['Afname'] = $fname;
	$_SESSION['Alname'] = $lname;
	$_SESSION['level'] = $level;
	$_SESSION['userid'] = $userid;
	}
}



/* Fix the strings. There are a bunch of textareas in this page that may have single quotes, 
double quotes, and returns where you'll want line breaks. This changes the characters
 to the appropriate code.*/
 
function fixstrings($str)
{
$str = htmlentities($str, ENT_QUOTES);
$str = preg_replace("/\r/", '<br>', $str);
$str = stripslashes($str);
return $str;
}

/* Fix the names*/
function fixname($string)
{
$string = strtolower(htmlentities($string, ENT_QUOTES));
$string = ucfirst($string);
$string = stripslashes($string);
return $string;
}


/* Reverse the fix*/
function revfixname($str)
{
$str = preg_replace("/&#39;/", "'", $str);
return $str;
}












/* Display the table*/
function showfinal()
{
global $link;

$sort = $_GET['sort'];

if(!isset($sort))
{
$sort = "fname";
}
$query = "select users.userid, fname, lname, 
files.fileid, shortname, filename, description, date, time from users, files, owners where
 users.userid=owners.userid and files.fileid=owners.fileid 
 order by $sort";

$result = mysqli_query($link, $query) or die(mysqli_error($link));

$i = 0;

print "<form method='post'>
<table border='1' class='displaytable'>

<tr>
<td class='high'>Gallery</td>
<td colspan='4'><a href='final.php?sort=shortname'>Soer By Name</a><br>
<a href='final.php?sort=date desc, time desc'>Newest</a><br>
<a href='final.php?sort=date, time'>Oldest</a>
</td></tr>\n";


	while($row = mysqli_fetch_row($result))
	{
if ($i %5 == 0) {
print "<tr></tr>";
}
		
	list($userid, $fname, $lname, $fileid, $shortname, $filename, $description, $date, $time, $dir) = $row;
	print "
	<td><a href='/~lubkov/cisw410/userimages/$filename'><img class='small' src='/~lubkov/cisw410/userimages/$filename' alt='$shortname'></a><br>
	Owner: $fname $lname <br>
	Name: $shortname <br>
	Date: $date<br>
	Time: $time<br>
	Description: $description
	</td>
	";
		$i++;
		
	}
print "</tr>\n</table>\n";

}







function showuser()
{
global $link;

$sort = $_GET['sort'];
$userid = $_GET['userid'];
$fileid = $_GET['fileid'];
$fname = $_GET['fname'];
$lname = $_GET['lname'];

if(!isset($sort))
{
$sort = "fname";
}
$query = "select users.userid, fname, lname, 
files.fileid, shortname, filename, description, date, time from users, files, owners where
 users.userid=owners.userid and files.fileid=owners.fileid 
 order by $sort";

$result = mysqli_query($link, $query) or die(mysqli_error($link));

$i = 0;

print "<form method='post'>
<table border='1' class='displaytable'>
<tr>
<th>Edit</th>
<th>Delete</th>
<th>Image</th>
<th>ALT</th>
<th>Description</th>
<th><a href='user.php?sort=date desc, time desc'>Date/Time</a></th>
</tr>\n";


	while($row = mysqli_fetch_row($result))
	{
if ($i %1 == 0) {
print "<tr></tr>";
}
		
	list($userid, $fname, $lname, $fileid, $shortname, $filename, $description, $date, $time) = $row;
	print "<tr>
	<td><a href='user.php?editname=yes&fileid=$fileid&shortname=$shortname&description=$description'>Edit</a></td>\n
	<td><a href='user.php?deletpic=yes&fileid=$fileid&filename=$filename' 
	onclick='return confirm(\"Are you sure\")'>Delete</a></td>\n
	<td><a href='/~lubkov/cisw410/userimages/$filename'><img class='small' src='/~lubkov/cisw410/userimages/$filename' alt='$shortname'></a> </td>
	<td>$shortname</td>
	<td>$description</td>
	<td>$date -<br> $time</td>
	";
		$i++;
		
	}
print "</tr>\n</table>\n";

}




function showtables($table)
{
global $link;
$query = "select * from $table";
$result = mysqli_query($link, $query);

print "<table border='1' class='left'>\n";

$i = 0;
	while ($row = mysqli_fetch_assoc($result)) 
	{
	print "<tr>\n";
			if($i == 0)
			{
					foreach ($row as $key=>$val)
					{
					print "<th>$key</th>\n";
					}
			print "</tr>\n\n<tr>\n";
			}

			foreach($row as $temp)
			{
			print "<td>$temp</td>\n";
			}
	$i++;
	print "</tr>\n\n";
	}

print "</table>";

}















?>