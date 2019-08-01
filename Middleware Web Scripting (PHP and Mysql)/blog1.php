<?php

	include("blogfunctions.php");
	$link = connect($host, $user, $pass, $db);

    $index_page = '<br /><a href="blog.php">Back to blog.php</a>';
?>

<html>
<head>
<title>Blogger Assignment</title>
	
<style>
	b {color: red;}
</style>
</head>
<body>
<?php


$cur_date = date("Y-m-d",time());
$cur_time = date("H:i:s", time());


/* +++++++++++++++++++ADD NEW MESSAGE +++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* ####################### This is the Form to add a new Message. Notice it uses the function
 blognames() which creates the drop down menu listing who the blogger is.  ########## */

if(isset($_GET['addmessage'])){
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

if(isset($_POST['addmessage2'])){
    
    $blogger_id = $_POST['bloggerid'];
    $blog_message = fixstrings(trim($_POST['message']));
    
    if(!empty($blog_message)){
        $is_message_result = mysqli_query($link, "SELECT message FROM blogposts WHERE message = '$blog_message';");
		$is_message = mysqli_fetch_assoc($is_message_result);
		
		if(mysqli_num_rows($is_message_result) == 0){
			
			$post_message_to_blog = mysqli_query($link, "INSERT INTO blogposts VALUES('', '$blog_message', '$blogger_id', '$cur_date', '$cur_time' );");
			
			die('Posted'.$index_page);
		}else{
			die('Double post.'.$index_page);
		}
		
    }else{
        die('Message field was blank.'.$index_page);
    }

// DONE Blog add message2
	
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


}




/* +++++++++++++++++++ADD NEW BLOGGER +++++++++++++++++++++++++++++*/



/*  ########### I wrote the first step in add a new blogger for you. Note
the field names.  ############# */




if(isset($_GET['addblogger'])){

    print "<form method=\"post\">\n
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


if(isset($_POST['addblogger2'])){
	
	$blogger_name = $_POST['bloggername'];
	$blogger_email = $_POST['bloggeremail'];
	$initial_message = $_POST['message'];
	
	if(
		!empty($initial_message)
		AND preg_match("/^([a-z  \.]*)$/i", $blogger_name)
		AND preg_match("/^([0-9a-z\.\-_]*)@([a-z\.]*)$/i", $blogger_email)
	){
		$blogger_name = fixstrings($blogger_name);
		$initial_message = fixstrings($initial_message);
		
		$check_blogger_name = mysqli_query($link, "SELECT * FROM bloggers WHERE bloggername = '$blogger_name'; ");
		
		if(mysqli_num_rows($check_blogger_name) == 0){ // if bloggername doesn't exist
			mysqli_query($link, "INSERT INTO bloggers VALUES('', '{$blogger_name}', '{$blogger_email}' ); ")
				or die('Couldn\'t insert new blogger'.$index_page); // insert blogger into blogger table
			
			$get_new_blogger_id = mysqli_query($link, "SELECT * FROM bloggers WHERE bloggername = '$blogger_name'; ")
				or die('Couldn\'t select new bloggers\' id'.$index_page); //query to get the new blogger's newly created bloggerid & get result
			
			$new_blogger_result = mysqli_fetch_assoc($get_new_blogger_id); //parse out that bloggerid
			
			
			mysqli_query($link, "INSERT INTO blogposts VALUES('', '$initial_message', '$new_blogger_result[bloggerid]', '$cur_date', '$cur_time');")
				or die('Error message for blogger already exists'.$index_page);
			// insert message into blogpost table with bloggerid, date and time
			 // Error message for blogger already exists
		
			
		}else{
			die('Error message for form not filled out properly'.$index_page);
		}	
			
		
		
		
	}

// DONE
	
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


}



/* +++++++++++++++++++DELETE MESSAGE  +++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/* #######################  Write the DELETE MESSAGE script. You must follow one basic 
rule with this. If it is the bloggers ONLY message, then you can not delete it.
 You'll need to check to see if mysql_num_rows($result) == 1
to determine this. If it equals 1 then don't delete the message. Otherwise
 go ahead and delete.  ####################### */

if(isset($_GET['deletemessage'])){
	// blog.php?deletemessage=yes&messageid=10&bloggerid=4
	$message_id = $_GET['messageid'];
	$blogger_id = $_GET['bloggerid'];
	
	$query_2 = mysqli_query($link, "SELECT * FROM blogposts WHERE bloggerid = '$blogger_id';")
		or die('!select from db'.$index_page);
	
	if(mysqli_num_rows($query_2) > 1){
		mysqli_query($link, "DELETE FROM blogposts WHERE messageid = '$message_id';");
	}else{
		die('Users` only message'.$index_page);
	}
}



/* +++++++++++++++++++EDIT MESSAGE +++++++++++++++++++++++++++++++++++++++++++++++++++++*/


/*  #######################  Write the two parts of the EDIT MESSAGE SCRIPT. The user should be able
 to change the actual message, and the name of the person who posted it. BUT YOU MUST 
 FOLLOW THIS RULE: if the message is the only message belonging to a user, you can not 
 change the name of the blogger. If you changed the name that would leave you with a user that 
 has no messages. The steps are written out for you below.  ####################### */




if(isset($_GET['editmessage'])){
	
	//http://power.arc.losrios.edu/~komarchukv/cisw410/blog.php?editmessage=yes&messageid=10&bloggerid=4
	$message_id = $_GET['messageid'];
	$blogger_id = $_GET['bloggerid'];
	
	
	$get_message_result = mysqli_query($link, "SELECT * FROM blogposts WHERE messageid = '$message_id';")
		or die("Couldn't select message".$index_page);
	$message_result = mysqli_fetch_assoc($get_message_result);
	
	echo "<form method='post' action='blog.php?editmessage2=yes&messageid={$message_id}&bloggerid={$blogger_id}'>

<table border='1' style='float: left'>

<caption>EDIT MESSAGES</caption>
".
blognames($blogger_id)
."
<tr><td><textarea name='message' cols='30' rows='6'>". revfixstrings($message_result[message]) ."</textarea></td></tr>
<tr><td><input type='submit' name='editmessage2' value='post'></td></tr>
</table></form>";
	
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

}


	/*  ####################### part 2  ####################### */

if(isset($_GET['editmessage2'])){

	$message_id = $_GET['messageid'];
	$blogger_id = $_GET['bloggerid'];
	$message    = $_POST['message'];
	
	if(!empty($message)){
		$message = fixstrings($message);
		
		mysqli_query($link, "UPDATE blogposts SET message = '$message', date = '$cur_date', time = '$cur_time' WHERE messageid = '$message_id';")
			or die('Couldn\'t update query'.$index_page);
		
		
	}else{
		die('error message for blank message field'.$index_page);
	}


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

}









/*  ####################### This line right here calls the function that is displaying the 
table to the screen with all the triggers to EDIT, DELETE, ADD POST, ADD Blogger  #######################  */


showblogtable();


mysqli_close($link);

?>


</body>
</html>