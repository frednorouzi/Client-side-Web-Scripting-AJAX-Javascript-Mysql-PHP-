<?php
$host = "http://power.arc.losrios.edu";
$user = "norouzif";
$pass = "1426193";
$db = "norouzif";


function connectdb($host, $user, $pass, $db)
{
$link = mysqli_connect("$host", "$user", "$pass", "$db") or die(mysqli_error($link));
return $link;
}
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