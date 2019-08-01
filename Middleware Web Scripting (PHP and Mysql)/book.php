<?php
include("bookfunction.php");
$link = connect($host, $user, $pass, $db);
?>

<html>
<head>
<title>Books Assignment</title>
</head>


<body>
<a href="index.php">Home</a> <br>



<?php

if(isset($_GET['addbook']))
{

print "<form method='post' action='book.php'>
<table border='1' style='float: left'>\n
<caption>ADD BOOK</caption>\n
<tr><td>";
ownernames();
print "</td></tr>
<tr><td>Title:<input type='text' name='title'></td></tr>
<tr><td>Genre:";

genredd();
print "</td></tr>
<tr><td><input type='submit' name='addbook1' value='Add Book'></td><tr>\n
</table>
</form>";

}

if(isset($_POST['addbook1']))
{
$title = $_POST['title'];
$genre = $_POST['genre'];
$authorid = $_POST['authorid'];
$reName = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
	if(preg_match($reName, $title))
	{
	$title = fixnames($title);

	$querycheck = "select * from books where title='$title' and 
	genre='$genre'";
	$resultcheck = mysqli_query($link, $querycheck);
		if(mysqli_num_rows($resultcheck) == 0)
		{
		$query = "insert into books values('', '$title', '$genre')";
		mysqli_query($link, $query);
		$queryid = "select bookid from books where title='$title' and genre='$genre'";
		$resultid = mysqli_query($link, $queryid);
		$row = mysqli_fetch_row($resultid);
		$bookid = $row[0];
		$queryref = "insert into publish values('', '$bookid', '$authorid')";
		mysqli_query($link, $queryref);
		print "<b>Author Added</b>";
		}
		else
		{
		print "<b>Duplicate Author</b>";
		}
	}
	else
	{
	print "<b>Fill out form correctly!</b>";
	}


}




if(isset($_GET['addauthor']))
{

print "<form method='post' action='books.php'>
<table border='1' style='float: left'>\n
<caption>ADD AUTHOR</caption>\n
<tr><td>First Name:<input type='text' name='fname'> </td></tr>
<tr><td>Last Name:<input type='text' name='lname'> </td></tr>
<tr><td>Country of Origin:<input type='text' name='country'> </td></tr>
<tr><td>Book Title:<input type='text' name='title'> </td></tr>";

print "
<tr><td>Genre:";

genredd();
print "</td></tr>
<tr><td><input type='submit' name='addauthor1' value='Add'></td><tr>\n
</table>
</form>";

}



if(isset($_POST['addauthor1']))
{
$title = $_POST['title'];
$genre = $_POST['genre'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$country = $_POST['country'];



$reName = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";

	if(preg_match($reName, $title) && $genre != "" &&
	preg_match($reName, $fname) 
	&& preg_match($reName, $lname) && 
	preg_match($reName, $country))
	{
	$fname = fixnames($fname);
	$lname = fixnames($lname);
	$title = fixnames($title);
	$query = "select * from authors where fname='$fname'
	and lname='$lname'";
	$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) == 0)
		{
		$querypet = "select * from books where title='$title'
		and genre='$genre'";
		$resultpet = mysqli_query($link, $querypet);
			if(mysqli_num_rows($resultpet) == 0)
			{
			$qaddowner = "insert into authors values('', '$fname', '$lname',
			'$country')";
			mysqli_query($link, $qaddowner);
			$qaddpet = "insert into books values('', '$title',  '$genre')";
			mysqli_query($link, $qaddpet);
			$qownerid = "select authorid from authors where fname='$fname' and
			lname='$lname' and country='$country'";
			$rownerid = mysqli_query($link, $qownerid);
			
			$qpetid = "select bookid from books where title='$title' and
			genre='$genre'";
			$rpetid = mysqli_query($link, $qpetid);
			
			$rowO = mysqli_fetch_row($rownerid);
			$authorid = $rowO[0];
			
			$rowP = mysqli_fetch_row($rpetid);
			$bookid = $rowP[0];
			$queryref = "insert into publish values('', '$bookid', '$authorid')";
			mysqli_query($link, $queryref);
			}
			else
			{
			print "<b>Duplicate Book Found</b>";
			}
		}
		else
		{
		print "<b>Duplicate Author Found</b>";
		}
	}
	else
	{
	print "<b>Please fill out the form properly</b>";
	}

}




if(isset($_GET['deletebook']))
{
$bookid = $_GET['bookid'];

$queryid = "select authorid from publish where bookid='$bookid'";
$resultid = mysqli_query($link, $queryid);
$row = mysqli_fetch_row($resultid);
$authorid = $row[0];
$querydel1 = "delete from books where bookid='$bookid'";
mysqli_query($link, $querydel1);
$querydel2 = "delete from publish where bookid='$bookid'";
mysqli_query($link, $querydel2);
	
print "<b>Book deleted </b>";
	
$queryowner = "select * from publish where authorid='$authorid'";
$resultowner = mysqli_query($link, $queryowner);
	if(mysqli_fetch_row($resultowner) == 0)
	{
	$querydel3 = "delete from authors where authorid='$authorid'";
	mysqli_query($link, $querydel3);
	print "<b>and author were deleted since that was the author's only book of record</b>";
	}


}







showbooks();
/*
showtables("books");
showtables("authors");
showtables("publish");
*/
?>
</body>
</html>