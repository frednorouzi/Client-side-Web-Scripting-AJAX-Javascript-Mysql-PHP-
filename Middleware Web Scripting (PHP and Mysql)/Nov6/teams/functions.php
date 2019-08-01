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


function authenticateUser()
{
global $link;
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$pass = $_POST['pass'];
$query = "select * from admin where fname='$fname' and
lname='$lname' and password='$pass'";
$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 0)
	{
	$_SESSION['authenticate23425243234'] = "Not Valid!!!";
	}
	else
	{
	$_SESSION['authenticate23425243234'] = "validuser0982";
	}

}


function fixnames($string)
{
$string = strtolower($string);
$string = ucfirst($string);
$string = htmlentities($string, ENT_QUOTES);
$string = stripslashes($string);
return $string;
}


function showteams($teamidOld='')
{
global $link;
$query = "select * from teams order by color";
$result = mysqli_query($link, $query);

print "<label>Choose Team</label>
<select name='teamid'>
<option value=''>Select Existing</option>";
	while($row = mysqli_fetch_row($result))
	{
	list($teamid, $color) = $row;
		if($teamidOld == $teamid)
		{
		print "<option value='$teamid' selected='selected'>$color</option>";
		}
		else
		{
		print "<option value='$teamid'>$color</option>";
		}
	}
print "</select>";
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