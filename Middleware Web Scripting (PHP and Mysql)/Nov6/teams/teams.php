<?php
session_start();
include("functions.php");
$link = connectdb($host, $user, $pass, $db);
	if($_SESSION['authenticate23425243234'] != 'validuser0982')
	{
	authenticateUser();
	}


?>
<!DOCTYPE html>
<html lang="en">

<head>	
	<title>Pets</title>
	<style>
	label {display: block;}
	fieldset {width: 300px; background-color: khaki;}
	textarea {width: 300px;}
	.left {float: right;}
	</style>
</head>
<body>

<a href="teams.php">Clean</a> <br>
<a href="logout.php">Logout</a> <br>
<?php
	if($_SESSION['authenticate23425243234'] != 'validuser0982')
	{ 
	print "<form method='post' action='teams.php'>
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
























<form>
<fieldset>
<legend>Add Person</legend>
<label><input type='text' name='fname'>Fname</label>
<label><input type='text' name='lname'>Lname</label>
<label>Add New Team</label>
<label><input type='text' name='color'></label>
<?php

showteams();
?>

<label><input type='submit' name='addperson' value='Add'></label>

</fieldset>
</form>

<?php


if(isset($_GET['del']))
{
$peopleid = $_GET['peopleid'];
$query = "select teamid from people where peopleid='$peopleid'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
$teamid = $row[0];

$querynum = "select * from people where teamid='$teamid'";
$resultnum = mysqli_query($link, $querynum);
	if(mysqli_num_rows($resultnum) == 1)
	{
	print "Only person on team, can't delete!!!";
	}
	else
	{
	$querydel = "delete from people where peopleid='$peopleid'";
	mysqli_query($link, $querydel);
	print "Person deleted!!!";
	}


}

if(isset($_GET['delT']))
{
$teamid = $_GET['teamid'];

$query = "delete from teams where teamid='$teamid'";
mysqli_query($link, $query);
$query = "delete from people where teamid='$teamid'";
mysqli_query($link, $query);
print "Team Deleted!!!";

}





if(isset($_GET['edit']))
{
$peopleid = $_GET['peopleid'];
$query = "select fname, lname, teamid from people where peopleid='$peopleid'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($fname, $lname, $teamid) = $row;

print "<form>
<fieldset>
<legend>Edit Person</legend>
<input type='hidden' name='peopleid' value='$peopleid'>
<input type='hidden' name='teamidOld' value='$teamid'>
<label><input type='text' name='fname' value='$fname'>Fname</label>
<label><input type='text' name='lname' value='$lname'>Lname</label>";

showteams($teamid);

print "<label><input type='submit' name='edit2' value='Edit'></label>
</fieldset>
</form>";

}



if(isset($_GET['edit2']))
{
$peopleid = $_GET['peopleid'];
$fname = $_GET['fname'];
$lname = $_GET['lname'];
$teamid = $_GET['teamid'];
$teamidOld = $_GET['teamidOld'];
	if($fname != "" && $lname != "" && $teamid != "")
	{
	$fname = fixnames($fname);
	$lname = fixnames($lname);
	$query = "select * from people where fname='$fname' and lname='$lname'";
	$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) == 0)
		{
		$query = "update people set fname='$fname', lname='$lname' where 
		peopleid='$peopleid'";
		
		mysqli_query($link, $query);
		print "Names were updated";
	
			if($teamidOld != $teamid)
			{
			$querynum = "select * from people where teamid='$teamidOld'";
			$resultnum = mysqli_query($link, $querynum);
				if(mysqli_num_rows($resultnum) > 1)
				{
				$query = "update people set teamid='$teamid' where peopleid='$peopleid'";
				mysqli_query($link, $query);
				}
				else
				{
				print "Team was not updated";
				}
			}
		
		}
		else
		{
		print "No update -- duplicate entry";
		}
	}
}


if(isset($_GET['addperson']))
{
$fname = $_GET['fname'];
$lname = $_GET['lname'];
$color = $_GET['color'];
$teamid = $_GET['teamid'];

	if($fname != "" && $lname != "" && 
	($color != "" || $teamid != ""))
	{
	$fname = fixnames($fname);
	$lname = fixnames($lname);
	
	$queryp = "select * from people where fname='$fname' and
	lname='$lname'";
	$resultp = mysqli_query($link, $queryp);
		if(mysqli_num_rows($resultp) == 0)
		{
			if($color != "")
			{
			$color = fixnames($color);
			$query = "select * from teams where color='$color'";
			$result = mysqli_query($link, $query);
				if(mysqli_num_rows($result) == 0)
				{
				$queryadd = "insert into teams values('', '$color')";
				mysqli_query($link, $queryadd);
				$queryid = "select teamid from teams where color='$color'";
				$resultid = mysqli_query($link, $queryid);
				$row = mysqli_fetch_row($resultid);
				$teamid = $row[0];
				}
			}
			
		$queryaddp = "insert into people values('', '$fname', '$lname', '$teamid')";
		mysqli_query($link, $queryaddp);
		print "Person Added";
		}
	}
	else
	{
	print "Fill out form!";
	}

}






showtables("teams");
showtables("people");

$sort = $_GET['sort'];
	if(empty($sort))
	{
	$sort = "lname";
	}

$query = "select peopleid, fname, lname, color, teams.teamid from people, 
teams where people.teamid=teams.teamid order by $sort";


$result = mysqli_query($link, $query);

print "<table border='1'>
<tr>
<th>DELETE</th>
<th><a href='teams.php?sort=fname'>Fname</a></th>
<th><a href='teams.php?sort=lname'>Lname</a></th>
<th><a href='teams.php?sort=color'>Team Color</a></th>
<th>Delete Team</th>
</tr>";

	while($row = mysqli_fetch_row($result))
	{
	list($peopleid, $fname, $lname, $color, $teamid) = $row;
	print "<tr>
	<td><a href='teams.php?del=yes&peopleid=$peopleid'>DEL</a></td>
	<td>$fname</td>
	<td><a href='teams.php?edit=yes&peopleid=$peopleid'>$lname</a></td>
	<td>$color</td>	
	<td><a href='teams.php?delT=yes&teamid=$teamid'>Delete Team</a></td>
	</tr>";
	
	}

print "</table>";












}
?>



</body>
</html>