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




function fixnames($string)
{
$string = strtolower($string);
$string = ucfirst($string);
$string = htmlentities($string, ENT_QUOTES);
$string = stripslashes($string);
return $string;
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


<th>Del</th>
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
	<td><input type='checkbox' name='petid[]' value='$petid'></td>";
	
	/*
	<td><a href='pets1.php?del=yes&petid=$petid' 
	onclick='return confirm(\"Are you sure\")'>Delete</a></td>*/
	print "<td><a href='pets1.php?edit=yes&petid=$petid'>$petname</a></td>
	<td>$species</td>
	<td>$desc</td>
	<td>$fname</td>
	<td>$lname</td>
	<td>$city</td>	
	</tr>";
	}

print "
<tr><td><input type='submit' name='del' value='DELETE'></td></tr>
</table></form>";




}




?>