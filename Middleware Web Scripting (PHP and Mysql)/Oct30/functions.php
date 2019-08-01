<?php
$host = "localhost";
$user = "";
$pass = "";
$db = "";


function connectdb($host, $user, $pass, $db)
{
$link = mysqli_connect("$host", "$user", "$pass", "$db") or die(mysqli_error($link));
return $link;
}


function speciesdd($species='')
{
$animals = array("Cat", "Dog", "Horse", "Bird", "Mouse", "Elephant",
"Frog", "Shark", "Pig", "Reindeer");

print "\n\n\n<select name='species'>\n
<option name=''>Select One</option>";
	for($i=0; $i<count($animals); $i++)
	{
		if($species == $animals[$i])
		{
		print "\n<option value='$animals[$i]' selected='selected'>$animals[$i]</option>";
		}
		else
		{
		print "\n<option value='$animals[$i]'>$animals[$i]</option>";
		}
	}
	

print "</select>\n\n\n";

}



function ownernames($id='')
{
global $link;
$query = "select ownerid, fname, lname from owners order by lname, fname";
$result = mysqli_query($link, $query);
print "<label>Owners</label>
<label><select name='ownerid'>\n";
$string = "";
	while($row = mysqli_fetch_row($result))
	{
	list($ownerid, $fname, $lname) = $row;
		if($id == $ownerid)
		{
		$string = "selected='selected'";
		}
	
	print "<option value='$ownerid' $string>$lname, $fname</option>\n";
		
	$string = "";
	}

print "</select>\n</label>"; 
}





function fixnames($string)
{
$string = strtolower($string);
$string = ucfirst($string);
$string = htmlentities($string, ENT_QUOTES);
$string = stripslashes($string);
return $string;
}


function showowners()
{
global $link;
$query = "select owners.ownerid, fname, lname, city, COUNT(ref.ownerid)
from owners, ref where ref.ownerid=owners.ownerid group by ref.ownerid
 order by lname, fname";
$result = mysqli_query($link, $query);
print "<table border='1'>
<tr>
<th>Delete</th>
<th>Fname</th>
<th>Lname</th>
<th>City</th>
<th># of Animals</th>
</tr>";
	while($row = mysqli_fetch_row($result))
	{
	list($ownerid, $fname, $lname, $city, $num) = $row;
	print "<tr>
	<td><a href='pets1.php?delowner=yes&ownerid=$ownerid'>DEL</a></td>
	<td>$fname</td>
	<td>$lname</td>
	<td>$city</td>
	<td>$num</td>
	</tr>";
	
	}
print "</table>";
}








function showpets()
{
global $link;


$sort = $_GET['sort'];
if(!isset($sort))
{
$sort = "petname";
}

$query = "select pets.petid, petname, species, description, 
owners.ownerid, fname, lname, city from pets, owners, ref where
 pets.petid=ref.petid and owners.ownerid=ref.ownerid 
 order by $sort";



$result = mysqli_query($link, $query) or die(mysqli_error($link));
print "<form method='post'>
<table border='1'>
<tr>


<th>Del Pet</th>
<th><a href='pets1.php?sort=petname'>Pet Name</a></th>
<th><a href='pets1.php?sort=species'>Species</a></th>
<th><a href='pets1.php?sort=description'>Desc</a></th>
<th><a href='pets1.php?sort=fname'>Fname</a></th>
<th><a href='pets1.php?sort=lname'>Lname</a></th>
<th><a href='pets1.php?sort=city'>City</a></th>

</tr>";
	while($row = mysqli_fetch_row($result))
	{
	list($petid, $petname, $species, $desc, $ownerid, $fname, $lname, $city) = $row;
	
	
	print "<tr>
	<td><input type='radio' name='petid' value='$petid'></td>
	<td><a href='pets1.php?editpet=yes&petid=$petid'>$petname</a></td>
	<td>$species</td>
	<td>$desc</td>
	<td>$fname</td>
	<td>$lname</td>
	<td>$city</td>	
	</tr>";
	}

print "
<tr><td><input type='submit' name='delpet' value='DELETE'></td></tr>
</table></form>";




}




?>