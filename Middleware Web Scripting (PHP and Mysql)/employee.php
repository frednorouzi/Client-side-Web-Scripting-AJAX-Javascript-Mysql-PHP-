<?php
$link = mysqli_connect('localhost','norouzif','1426193','norouzif');
?>


<!DOCTYPE html>
<html lang="en">

<head>	
	<title>Employees</title>
	<style>
	label {display: block;}
	fieldset {width: 300px; background-color: khaki;}
	textarea {width: 300px;}
	</style>
</head>
<body>

<h1> Employee Table</h1>
<a href="employee.php">Clean</a> <br>
<h2> Add form </h2>
<form method="post" action="employee.php">
<input type="text" name="fname">First name<br>
<input type="text" name="lname">Last name<br>
<input type="text" name="email">Email<br>
<input type="text" name="zip">Zip Code<br>
<input type="hidden" name="employeeid">
<input type="submit" name="add" value="Add Record">
</form>

<br>



<?php

if(isset($_POST['add']))
{
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$zip = $_POST['zip'];
$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";

	if(preg_match($re, $fname) &&	!empty($lname) &&
	preg_match($re, $email))
	{
	$fname = fixnames($fname);
	$lname = fixnames($lname);
	
	$querycheck = "select * from employees where fname='$fname'
	and lname='$lname'";
	$resultcheck = mysqli_query($link, $querycheck);
		if(mysqli_num_rows($resultcheck) == 0)
		{
		$query = "insert into employees values('', '$fname', '$lname', '$email', '$zip')";
		mysqli_query($link, $query);
		print "Item Added";
		}
		else
		{
		print "That record already exists!";
		}
	
	
	

	}
	else
	{
	print "You did not fill out the form correctly!";
	}

}



if(isset($_POST['del']))
{
$employeeid = $_POST['employeeid'];
	if(is_array($employeeid))
	{
		foreach($employeeid as $temp)
		{
		$query = "delete from employees where employeeid='$temp'";
		mysqli_query($link, $query);
		}
	}
	
	
	print "Deletion done!";
}



if(isset($_GET['edit']))
{
$employeeid = $_GET['employeeid'];
$query = "select * from employees where employeeid='$employeeid'";
$result = mysqli_query($link, $query);

$row = mysqli_fetch_row($result);
list($employeeid, $fname, $lname, $email, $zip) = $row;


print "<form method='post' action='employee.php'>
<fieldset>
<legend>EDIT $fname</legend>
<input type='hidden' name='employeeid' value='$employeeid'>
<label><input type='text' name='fname' value='$fname'>First name</label>
<label><input type='text' name='lname' value='$lname'>Last name</label>
<label><input type='text' name='email' value='$email'>Email</label>
<label><input type='text' name='zip' value='$zip'>Zip code</label>";
//speciesdd($species);

print "<label><input type='submit' name='edit2' value='Edit'></label>
</fieldset>
</form>";


}

if(isset($_POST['edit2']))
{
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$zip = $_POST['zip'];
$employeeid = $_POST['employeeid'];
$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";

	if(preg_match($re, $fname) &&	!empty($lname) &&
	preg_match($re, $email))
	{
	$fname = fixnames($fname);
	$lname = fixnames($lname);
	
	$query = "select * from employees where fname='$fname'
	and lname='$lname' and eail='$email' and zip='$zip'";
	$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) == 0)
		{
		$queryupdate = "update employees set fname='$fname',
		lname='$lname', email='$email', zip='$zip' where
		employeeid='$employeeid'";
		mysqli_query($link, $queryupdate);
		print "$fname was updated!";
		}
	
	

	}

}


//showpets();
function showemp()
{
global $link;
	if(isset($_GET['choice']))
	{
	$choice = $_GET['choice'];
	}
	else
	{
	$choice = "lname";
	}

$query = "select * from employees order by $choice";
$result = mysqli_query($link, $query);


print "<table border='1'>

<tr>
<th>Edit</th>
<th>Delete</th>
<th><a href='employ.php?choice=fname'>FNAME</a></th>
<th><a href='employ.php?choice=lname'>LNAME</a></th>
<th><a href='employ.php?choice=email'>EMAIL</a></th>
<th><a href='employ.php?choice=zip'>ZIP</a></th>
</tr>";

	while($row = mysqli_fetch_row($result))
	{
	list($employeeid, $fname, $lname, $email, $zip) = $row;
	print "<tr>
	<td><a href='employ.php?edit=yes&employeeid=$employeeid'>Edit</a></td>
	<td><a href='employ.php?delete=yes&employeeid=$employeeid'
	 onclick='return confirm(\"Are you sure\")'>Delete</a></td>
	<td>$fname</td><td>$lname</td><td>$email</td><td>$zip</td>
	</tr>";
	}
print "</table>";
}

?>
</body>
</html>
