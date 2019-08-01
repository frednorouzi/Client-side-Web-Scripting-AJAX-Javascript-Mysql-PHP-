<?php
/*Add your personal Data here*/
$host = "localhost";
$user = "norouzif";
$pass = "1426193";
$db = "norouzif";


/*functions for script below*/
	function connectdb($host, $user, $pass, $db) 
	{
	$link = mysqli_connect($host, $user, $pass, $db) or die("Error: Check your Username,Password, and DBname ".mysqli_error($link));
	return $link;
	}
	function fixnames($string)
	{
	$string = strtolower(htmlentities($string, ENT_QUOTES));
	$string = ucfirst($string);
	$string = stripslashes($string);
	return $string;
	}
$link = connectdb($host, $user, $pass, $db);


/*Add to database Script*/
if(isset($_POST['add']))
{
$animalname = fixnames($_POST['animalname']);
$species = $_POST['species'];
$description = fixnames($_POST['description']);

    if(!empty($animalname) && !empty($species) and !empty($description))
	{
	$query = "insert into animals values('', '$animalname', '$species', '$description')";	
	mysqli_query($link, $query);
	}
}



/* Delete from database*/
if(isset($_GET['delete']))
{
$animalid = $_GET['animalid'];
$query = "delete from animals where animalid='$animalid'";
mysqli_query($link, $query);
}





/*Display table*/

	if(isset($_GET['sort']))
	{
	$sort = $_GET['sort'];
	}
	else
	{
	$sort = "animalname";
	}
$query = "select * from animals order by $sort";
$result = mysqli_query($link, $query);
print "<table border='1'>
<tr>
<th>Delete</th>
<th><a href='db.php?sort=animalname' class='mysort'>Animal Name</a></th>
<th><a href='db.php?sort=species' class='mysort'>Species</a></th>
<th><a href='db.php?sort=description' class='mysort'>Description</a></th></tr>";
	while($row = mysqli_fetch_row($result))
	{
	list($animalid, $animalname, $species, $description) = $row;
	print "<tr>
	<td><a href='db.php?delete=yes&animalid=$animalid' id='del'>Delete</a></td>
	<td>$animalname</td><td>$species</td><td>$description</td></tr>";
	}
print "</table>";
?>