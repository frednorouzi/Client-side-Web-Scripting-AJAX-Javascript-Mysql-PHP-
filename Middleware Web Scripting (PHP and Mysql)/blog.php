<?php
include("blogfunctions.php");
$link = connect($host="localhost", $user= "", $pass = "", $db= "");
?>

<html>
<head><title>Blogger Assignment</title>
<style>
b {color: red;}
</style>
</head>
<body>
<a href="blog.php">Clean</a> <br>
<?php



/* +++++++++++++++++++ADD NEW MESSAGE +++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ####################### This is the Form to add a new Message. Notice it uses the function
 blognames() which creates the drop down menu listing who the blogger is.  ########## */

if(isset($_GET['addmessage']))
{
print "<form method='post' action='blog.php'>\n
<table border='1' style='float: left'>\n
<caption>ADD MESSAGES</caption>\n
<tr><td>Name of Blogger<br>";


blognames();

print "</td></tr>\n
<tr><td><textarea name='message' cols='30' rows='6'></textarea></td></tr>\n
<tr><td><input type='submit' name='addmessage2' value='post'></td></tr>\n
</table>\n
</form>\n";
}




/*  ####################### You have to write the second part of the add messages script.
 The steps are written out for you.  ####################### */

if(isset($_POST['addmessage2']))
{
/* Parse in the variables
	if the message has something in it
	fix all the quotes using fixstrings() function
	query to the database to see if the message already exists and get a result
		if the message does not exist
		add it to the table with the bloggerid and CURRENT_DATE, CURRENT_TIME
		else
		Error message for a double post
	else
	Error Message for a blank message field.
*/

$messageid = $_POST['messageid'];
$message = $_POST['message'];
$bloggerid = $_POST['bloggerid'];
$date = $_POST['date'];
$time = $_POST['time'];

   if(!empty($message)) 
   {
    $querycheck = "select * from blogposts where message='$message' and bloggerid = '$bloggerid'";
print "$querycheck";
	$resultcheck = mysqli_query($link, $querycheck);
		if(mysqli_num_rows($resultcheck) == 0)
		{
		$query = "insert into blogposts values('', '$message', '$bloggerid', CURRENT_DATE, CURRENT_TIME)";
		mysqli_query($link, $query);
		print "Message Posted";
		}
		else
		{
		print "That message already exists!";
		}
   }
   else
	{
	print "You did not fill out the message form correctly!";
	}
}




/* +++++++++++++++++++ADD NEW BLOGGER +++++++++++++++++++++++++++++*/



/*  ########### I wrote the first step in add a new blogger for you. Note
the field names.  ############# */




if(isset($_GET['addblogger']))
{
print "<form>\n
<table border='1' style='float: left'>\n
<caption>ADD BLOGGER</caption>\n
<tr><td width='300'><b>RULE: All bloggers listed must have at least 1 message. So when a 
new blogger is added, they must also post an inital message.</b></td></tr>\n

<tr>
<td>Blogger Name: <input type='text' name='bloggername'></td></tr>\n
<tr><td>Blogger Email: <input type='text' name='bloggeremail'></td></tr>\n
<tr><td>Inital Message: <br/><textarea cols='30' rows='6' name='message'></textarea></td></tr>\n
<tr><td><input type='submit' name='addblogger2' value='Add'></td><tr>\n
</table>\n
</form>\n";

}


/*  #######################  You have the write the second part to the ADD NEW BLOGGER script.
 The Steps are written out for you.  ####################### */


if(isset($_GET['addblogger2']))
{
/*
Parse in all variables
	if message isn't blank, and bloggername and bloggeremail pass Regular Expression tests
	fix the message and the bloggername with fixstrings()
	Query to see if bloggername already exists in blogger table and get result
		if bloggername doesn't exist
		insert blogger into blogger table
		query to get the new blogger's newly created bloggerid & get result
		parse out that bloggerid
		insert message into blogpost table with bloggerid, date and time
		else
		Error message for blogger already exists
	else
	Error message for form not filled out properly
*/
$bloggername = $_GET['bloggername'];
$bloggeremail = $_GET['bloggeremail'];
$message = $_GET['message'];
$date = $_GET['date'];
$time = $_GET['time'];

   $rename = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
  $remail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/";
	if(preg_match($rename, $bloggername) &&	!empty($message) &&
	preg_match($remail, $bloggeremail))
	{
	
	$bloggername = fixstrings($bloggername);
	$bloggeremail = fixstrings($bloggeremail);
	
    $querycheck = "select * from bloggers where  bloggername='$bloggername'";
		$resultcheck = mysqli_query($link, $querycheck);
		if(mysqli_num_rows($resultcheck) == 0)
		{
		$query = "INSERT INTO bloggers VALUES('', '$bloggername', '$bloggeremail')";
		
		mysqli_query($link, $query);
		
	 	$querycheck1 = "select * from bloggers where  bloggername='$bloggername'";
		
		$new1 = mysqli_query($link, $querycheck1);
		$new_blogger_result = mysqli_fetch_assoc($new1); 
			
			$query1 = "INSERT INTO blogposts VALUES('', '$message', '$new_blogger_result[bloggerid]', CURRENT_DATE, CURRENT_TIME)";
			mysqli_query($link, $query1);
						
	  
		print "Record Added";
		}
		else
		{
		print "That Record already exists!";
		}
   }
   else
	{
	print "You did not fill out the message form correctly!";
	}

}



/* +++++++++++++++++++DELETE MESSAGE  +++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* #######################  Write the DELETE MESSAGE script. You must follow one basic 
rule with this. If it is the bloggers ONLY message, then you can not delete it.
 You'll need to check to see if mysql_num_rows($result) == 1
to determine this. If it equals 1 then don't delete the message. Otherwise
 go ahead and delete.  ####################### */

if(isset($_GET['deletemessage']))
{
$messageid = $_GET['messageid'];
$bloggerid = $_GET['bloggerid'];

  $queryd = "SELECT * FROM blogposts WHERE bloggerid = '$bloggerid'";
	$resultcheckd = mysqli_query($link, $queryd);
		if(mysqli_num_rows($resultcheckd) > 1)
		{
		  $query1 = "DELETE FROM blogposts WHERE messageid='$messageid'";
		  mysqli_query($link, $query1);
		  print "Deletion done!";
	    }
	   	    
        else
	    {
		Print " That's this blogger's only message. You can not delete the last message.";
		}
}



/* +++++++++++++++++++EDIT MESSAGE +++++++++++++++++++++++++++++++++++++++++++++++++++++*/


/*  #######################  Write the two parts of the EDIT MESSAGE SCRIPT. The user should be able
 to change the actual message, and the name of the person who posted it. BUT YOU MUST 
 FOLLOW THIS RULE: if the message is the only message belonging to a user, you can not 
 change the name of the blogger. If you changed the name that would leave you with a user that 
 has no messages. The steps are written out for you below.  ####################### */




if(isset($_GET['editmessage']))
{

/*
Parse in variables
Query for the message using messageid and get result
Parse out message
Reverse the fix on the message using revfixstrings();
Create form with textarea with the message inside
The form should also hide the messageid inside it
Use the select menu function blognames() with bloggerid to create the drop down menu for blogger names
The form should also hide the ORIGINAL bloggerid inside it (just in case the user changes the blogger)
Submit button needs trigger for part2
*/
$messageid = $_GET['messageid'];
$bloggerid = $_GET['bloggerid'];
	
	$queryedit1 = "SELECT * FROM blogposts WHERE messageid = '$messageid'" ;
	$result = mysqli_query($link,$queryedit1 );
		
	$message_result = mysqli_fetch_assoc($result);
	
	Print "<form method='post' action='blog.php?editmessage2=yes&messageid='$messageid' & bloggerid='$bloggerid''>

<table border='1' style='float: left'>

<caption>Edit Message</caption> ".blognames($bloggerid)."
<tr><td><textarea name='message' cols='25' rows='8'>". revfixstrings($message_result[message]) ."</textarea></td></tr>
<tr><td><input type='submit' name='editmessage2' value='Edit'></td></tr>
</table></form>";
/*print "<form method='post' action='blog.php'>
<fieldset>
<legend>EDIT Message</legend>

<label><textarea name='message'>$message</textarea></label>
<label><input type='submit' name='edit2' value='Edit'></label>
</fieldset>

</form>";
blognames();*/
}


	/*  ####################### part 2  ####################### */

if(isset($_POST['editmessage2']))
{
/*
Parse in the variables
	if message is not empty
	fix message with fixstrings()
	query blogposts to get all messages for the ORIGINAL bloggerid and get result
		if there is only 1 message AND the ORIGINAL bloggerid does not equal the NEW bloggerid
		Update the MESSAGE only. Do not change the bloggerid and Tell user
		the message was changed, but the blogger's name was not changed as
		it would violate the rule of all bloggers must have at least 1 message.
		else
		update the message and bloggerid
				
	else
	error message for blank message field
*/

$messageid = $_GET['messageid'];
$bloggerid = $_GET['bloggerid'];
$message  = $_POST['message'];
	
	if(!empty($message))
	{
		$message = fixstrings($message);
		$querym = "UPDATE blogposts SET message = '$message', CURRENT_DATE, CURRENT_TIME WHERE messageid = '$messageid'";
		mysqli_query($link, $querym);
	}
	else
	{
		print" Message should be fill out";
	}
}



/*  ####################### This line right here calls the function that is displaying the 
table to the screen with all the triggers to EDIT, DELETE, ADD POST, ADD Blogger  #######################  */


showblogtable();


?>


</body>
</html>
