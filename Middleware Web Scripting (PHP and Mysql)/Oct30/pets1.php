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

<a href="pets1.php">Clean</a> <br>
<a href="pets1.php?allowners">Show All Owners</a><br>
<a href="pets1.php?owneradd=yes">Add Owners</a><br>
<a href="pets1.php?petadd=yes">Add Pet</a><br>

<br>



<?php


if(isset($_GET['allowners']))
{
showowners();
}

if(isset($_GET['delowner']))
{
$ownerid = $_GET['ownerid'];
$query = "delete from owners where ownerid='$ownerid'";
mysqli_query($link, $query);
$query2 = "select petid from ref where ownerid='$ownerid'";
$result2 = mysqli_query($link, $query2);
	while($row = mysqli_fetch_row($result2))
	{
	$petid = $row[0];
	$querydelanimal = "delete from pets where petid='$petid'";
	mysqli_query($link, $querydelanimal);
	}
$querydel = "delete from ref where ownerid='$ownerid'";
mysqli_query($link, $querydel);
print "<h2>Owner and all owner's animals were deleted</h2>";
showowners();
}



if(isset($_GET['editpet']))
{
$petid = $_GET['petid'];
$query = "select petname, species, description, ownerid from pets, ref
where pets.petid=ref.petid and pets.petid='$petid'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_row($result);
list($petname, $species, $description, $ownerid) = $row;


print "<form method='post' action='pets1.php'>
<fieldset>
<legend>Edit Pet</legend>
<input type='hidden' name='petid' value='$petid'>
<label><input type='text' name='petname' value='$petname'>Petname</label>
<label>Species</label>";
speciesdd($species);

print "<label>Description</label>
<label><textarea name='description'>$description</textarea></label>
<input type='hidden' name='owneridold' value='$ownerid'>";
ownernames($ownerid);
print "<label><input type='submit' name='petedit' value='Edit'></label>

</fieldset>
</form>";
}


if(isset($_POST['petedit']))
{
$petid = $_POST['petid'];
$petname = $_POST['petname'];
$species = $_POST['species'];
$description = $_POST['description'];
$ownerid = $_POST['ownerid'];
$owneridold = $_POST['owneridold'];

$reName = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
	if(preg_match($reName, $petname) && $species != "" && $description != ""
	&& $ownerid != "")
	{
	$petname = fixnames($petname);
	$description = fixnames($description);
	$query = "select * from pets where petname='$petname' and species='$species'
	and description='$description' and petid !='$petid'";
	$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) == 0)
		{
		$queryupdate = "update pets set petname='$petname', species='$species',
		description='$description' where petid='$petid'";
		mysqli_query($link, $queryupdate);
		print "<h2>Animal was updated</h2>";
		$query2 = "update ref set ownerid='$ownerid' where petid='$petid'";
		print "2 - $query2 <br>";
		mysqli_query($link, $query2);
		print "<h2>Owner was also updated</h2>";
		
		if($owneridold != $ownerid)
		{
		
			$querynum = "select * from ref where ownerid='$owneridold'";
			print "2 $querynum<br>";
			$resultnum = mysqli_query($link, $querynum);
				if(mysqli_num_rows($resultnum) == 0)
				{
				$query3 = "delete from owners where ownerid='$owneridold'";
				print "3 $query3<br>";
				mysqli_query($link, $query3);
				$query4 = "delete from ref where ownerid='$owneridold'";
				print "4 $query4<br>";
				mysqli_query($link, $query4);
				print "<h2>Old owner was removed</h2>";
				}	
		}	
		
		}
		else
		{
		print "<h2>Duplicate</h2>";
		}
	
	}
	

}












if(isset($_GET['owneradd']))
{
print "<form method='post' action='pets1.php'>
<fieldset>
<legend>Add Owner</legend>
<label><input type='text' name='fname'>Fname</label>
<label><input type='text' name='lname'>Lname</label>
<label><input type='text' name='city'>City</label>
<label><input type='text' name='petname'>Petname</label>
<label>Species</label>";

speciesdd();

print "<label>Description</label>
<label><textarea name='description'></textarea></label>
<label><input type='submit' name='addowner' value='Add'></label>
</fieldset>
</form>";
}


if(isset($_POST['addowner']))
{
$petname = $_POST['petname'];
$species = $_POST['species'];
$description = $_POST['description'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$city = $_POST['city'];

print "petname $petname<br>";


$reName = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
$reCity = "/^[a-zA-Z ]+$/";
	if(preg_match($reName, $petname) && $species != "" &&
	$description != "" && preg_match($reName, $fname) 
	&& preg_match($reName, $lname) && 
	preg_match($reCity, $city))
	{
	$fname = fixnames($fname);
	$lname = fixnames($lname);
	$petname = fixnames($petname);
	$description = fixnames($description);
	$city = fixnames($city);
	$query = "select * from owners where fname='$fname'
	and lname='$lname'";
	$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) == 0)
		{
		$querypet = "select * from pets where petname='$petname'
		and species='$species'";
		$resultpet = mysqli_query($link, $querypet);
			if(mysqli_num_rows($resultpet) == 0)
			{
			$qaddowner = "insert into owners values('', '$fname', '$lname',
			'$city')";
			mysqli_query($link, $qaddowner);
			$qaddpet = "insert into pets values('', '$petname',  '$species', 
			'$description')";
			mysqli_query($link, $qaddpet);
			$qownerid = "select ownerid from owners where fname='$fname' and
			lname='$lname' and city='$city'";
			print "$qownerid";
			$rownerid = mysqli_query($link, $qownerid);
			
			$qpetid = "select petid from pets where petname='$petname' and
			species='$species' and description='$description'";
			$rpetid = mysqli_query($link, $qpetid);
			
			$rowO = mysqli_fetch_row($rownerid);
			$ownerid = $rowO[0];
			
			$rowP = mysqli_fetch_row($rpetid);
			$petid = $rowP[0];
			$queryref = "insert into ref values('', '$petid', '$ownerid')";
			mysqli_query($link, $queryref);
			print "<h2>$fname, $lname, $petname was added to database</h2>";
			}
			else
			{
			print "<h2>Duplicate Pet Found</h2>";
			}
		}
		else
		{
		print "<h2>Duplicate Owner Found</h2>";
		}
	}


}


if(isset($_GET['petadd']))
{

print "<form method='post' action='pets1.php'>
<fieldset>
<legend>Add Pet</legend>
<label><input type='text' name='petname'>Petname</label>
<label>Species</label>";
speciesdd();

print "<label>Description</label>
<label><textarea name='description'></textarea></label>";
ownernames();
print "<label><input type='submit' name='addpet' value='Add'></label>

</fieldset>
</form>";


}

if(isset($_POST['addpet']))
{
$petname = $_POST['petname'];
$species = $_POST['species'];
$description = $_POST['description'];
$ownerid = $_POST['ownerid'];
$reName = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
	if(preg_match($reName, $petname) && $species != "" && $description != ""
	&& $ownerid != "")
	{
	$petname = fixnames($petname);
	$description = fixnames($description);
	$querycheck = "select * from pets where petname='$petname' and 
	species='$species' and description='$description'";
	$resultcheck = mysqli_query($link, $querycheck);
		if(mysqli_num_rows($resultcheck) == 0)
		{
		$query = "insert into pets values('', '$petname', '$species', '$description')";
		mysqli_query($link, $query);
		$queryid = "select petid from pets where petname='$petname' and species='$species'
		and description='$description'";
		$resultid = mysqli_query($link, $queryid);
		$row = mysqli_fetch_row($resultid);
		$petid = $row[0];
		$queryref = "insert into ref values('', '$petid', '$ownerid')";
		mysqli_query($link, $queryref);
		print "<h2>Pet Added</h2>";
		}
		else
		{
		print "<h2>Duplicate Pet</h2>";
		}
	}
	else
	{
	print "<h2>Fill out form correctly!</h2>";
	}
}







if(isset($_POST['delpet']))
{
$petid = $_POST['petid'];
$queryid = "select ownerid from ref where petid='$petid'";
$resultid = mysqli_query($link, $queryid);
$row = mysqli_fetch_row($resultid);
$ownerid = $row[0];
$querydel1 = "delete from pets where petid='$petid'";
mysqli_query($link, $querydel1);
$querydel2 = "delete from ref where petid='$petid'";
mysqli_query($link, $querydel2);
print "<h2>Pet has been deleted</h2>";

$queryowner = "select * from ref where ownerid='$ownerid'";
$resultowner = mysqli_query($link, $queryowner);
	if(mysqli_fetch_row($resultowner) == 0)
	{
	$querydel3 = "delete from owners where ownerid='$ownerid'";
	mysqli_query($link, $querydel3);
	print "<h2>That was owners only pet; owner was also deleted.</h2>";
	}


}










showpets();


?>
</body>
</html>
