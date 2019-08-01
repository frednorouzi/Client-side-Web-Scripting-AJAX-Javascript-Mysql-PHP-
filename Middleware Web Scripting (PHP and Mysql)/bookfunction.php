<?php

$host = "localhost";
$user = "norouzif";
$pass = "1426193";
$db = "norouzif";



function connect($host, $user, $pass, $db) 
{
$link = mysqli_connect($host, $user, $pass, $db) or die("Error ".mysqli_error($link));
return $link;
}


 
function fixstrings($str)
{
$str = htmlentities($str, ENT_QUOTES);
$str = preg_replace("/\r/", '<br>', $str);
$str = stripslashes($str);
return $str;
}



function revfixstrings($str)
{
$str = html_entity_decode($str, ENT_QUOTES);
$str = preg_replace("/\<br\>/", "\r", $str);
return $str;
}



function fixnames($string)
{
$string = strtolower($string);
$string = ucfirst($string);
$string = htmlentities($string, ENT_QUOTES);
$string = stripslashes($string);
return $string;
}

function showbooks()
{
global $link;


$sort = $_GET['sort'];
if(!isset($sort))
{
$sort = "title";
}
$query = "select books.bookid, title, genre, 
authors.authorid, fname, lname, country from books, authors, publish where
 books.bookid=publish.bookid and authors.authorid=publish.authorid 
 order by $sort";

$result = mysqli_query($link, $query) or die(mysqli_error($link));
print "<form method='post'>
<table border='1'>
<tr><th colspan='7'><a href='books.php?addbook=yes'>Add Book</a> | 
<a href='books.php?addauthor=yes'>Add Author</a></th></tr>\n
<tr>
<th>Delete Book</th>
<th><a href='books.php?sort=title'>Title</a></th>
<th><a href='books.php?sort=fname, lname'>Author Name</a></th>
<th><a href='books.php?sort=genre'>Genre</a></th>
<th><a href='books.php?sort=country'>Country</a></th>
</tr>\n";

	while($row = mysqli_fetch_row($result))
	{
	list($bookid, $title, $genre, $authorid, $fname, $lname, $country,) = $row;
	print "<tr>
	<td><a href='books.php?deletebook=yes&bookid=$bookid&authorid=$authorid' 
	onclick='return confirm(\"Are you sure\")'>Delete</a></td>\n
	<td>$title</td>\n
	<td>$fname $lname</td>\n
	<td>$genre</td>\n
	<td>$country</td>\n
	</tr>\n";
	}
print "</table>\n";
}






function genredd($genre='')
{
$animals = array("Biography", "Fantasy", "Fiction", "History", "Horror", "Mystery",
"Non-Fiction", "Romance", "Science Fiction", "Western");

print "\n\n\n<select name='genre'>\n";
	for($i=0; $i<count($animals); $i++)
	{
		if($genre == $animals[$i])
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
$query = "select authorid, fname, lname from authors order by lname, fname";
$result = mysqli_query($link, $query);
print "<label>Author:</label>
<label><select name='authorid'>\n";
$string = "";
	while($row = mysqli_fetch_row($result))
	{
	list($authorid, $fname, $lname) = $row;
		if($id == $authorid)
		{
		$string = "selected='selected'";
		}
	
	print "<option value='$authorid' $string>$fname $lname</option>\n";
		
	$string = "";
	}

print "</select>\n</label>"; 
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