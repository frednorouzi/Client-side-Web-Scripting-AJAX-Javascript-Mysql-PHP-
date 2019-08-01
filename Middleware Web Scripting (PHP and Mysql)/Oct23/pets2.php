<?php
include("functions.php");
$link = connectdb($host, $user, $pass, $db);
?>


<!DOCTYPE html>
<html lang="en">

<head>	
	<title>Pets</title>
	<style>
	label {display: block;}
	fieldset {width: 300px; background-color: khaki;}
	textarea {width: 300px;}
	</style>
</head>
<body>

<a href="pets2.php">Clean</a> <br>
<a href='pets2.php?c=yes'>Code</a><br>
<a href='pets2.php?q=yes'>Query</a><br>
<form method="post" action="pets2.php">
<fieldset>
<legend>Add New</legend>
<label><input type="text" name="petname">Petname</label>
<label>Species</label>
<?php
speciesdd();
?>
<label>Description</label>
<label><textarea name="description"></textarea></label>
<label><input type="submit" name="add" value="Add"></label>
</fieldset>
</form>

<br>



<?php



if(isset($_POST['add']))
{
$petname = $_POST['petname'];
$species = $_POST['species'];
$description = $_POST['description'];
$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";

	if(preg_match($re, $petname) &&	!empty($species) &&
	preg_match($re, $description))
	{
	$petname = fixnames($petname);
	$description = fixnames($description);
	
	$querycheck = "select * from pets where petname='$petname'
	and species='$species'";
	$resultcheck = mysqli_query($link, $querycheck);
		if(mysqli_num_rows($resultcheck) == 0)
		{
		$query = "insert into pets values('', '$petname', '$species', '$description')";
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
$petid = $_POST['petid'];
	if(is_array($petid))
	{
		foreach($petid as $temp)
		{
		$query = "delete from pets where petid='$temp'";
		mysqli_query($link, $query);
		}
	}
	
	
	print "Deletion done!";
}



if(isset($_GET['edit']))
{
$petid = $_GET['petid'];
$query = "select * from pets where petid='$petid'";
$result = mysqli_query($link, $query);

$row = mysqli_fetch_row($result);
list($petid, $petname, $species, $description) = $row;


print "<form method='post' action='pets2.php'>
<fieldset>
<legend>EDIT $petname</legend>
<input type='hidden' name='petid' value='$petid'>
<label><input type='text' name='petname' value='$petname'>Petname</label>

<label>Species</label>";
speciesdd($species);

print "<label>Description</label>
<label><textarea name='description'>$description</textarea></label>
<label><input type='submit' name='edit2' value='Edit'></label>
</fieldset>
</form>";


}

if(isset($_POST['edit2']))
{
$petname = $_POST['petname'];
$species = $_POST['species'];
$description = $_POST['description'];
$petid = $_POST['petid'];
$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";

	if(preg_match($re, $petname) &&	!empty($species) &&
	preg_match($re, $description))
	{
	$petname = fixnames($petname);
	$description = fixnames($description);
	
	$query = "select * from pets where petname='$petname'
	and species='$species' and description='$description'";
	$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) == 0)
		{
		$queryupdate = "update pets set petname='$petname',
		species='$species', description='$description' where
		petid='$petid'";
		mysqli_query($link, $queryupdate);
		print "$petname was updated!";
		}
	
	

	}

}





if(isset($_GET['c']))
{
$query = "select ownerid from owners order by lname, fname";
$result = mysqli_query($link, $query);
$idarray = array();
	while($row = mysqli_fetch_row($result))
	{
	$ownerid = $row[0];

	$query2 = "select * from ref where ownerid='$ownerid'";

	$result2 = mysqli_query($link, $query2);
		if(mysqli_num_rows($result2) == 0)
		{

		array_push($idarray, $ownerid);
		}
	}
	foreach($idarray as $temp)
	{

	$querynames = "select fname, lname from owners where ownerid='$temp'";
	$resultnames = mysqli_query($link, $querynames);
		while($row = mysqli_fetch_row($resultnames))
		{
		list($fname, $lname) = $row;
		print "$temp, $fname $lname <br>";
		}
	}
}
if(isset($_GET['q']))
{
$query = "select owners.ownerid, fname, lname from (owners left join ref on owners.ownerid=ref.ownerid) left 
join pets on pets.petid=ref.petid where pets.petid is NULL";
$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_row($result))
	{
	list($ownerid, $fname, $lname) = $row;
	print "$ownerid, $fname, $lname <br>";
	}
}






showpets();


?>
</body>
</html>
