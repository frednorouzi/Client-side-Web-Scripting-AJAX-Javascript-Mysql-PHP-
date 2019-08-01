<?php
include('function.php');
$link = connectdb($host, $user, $pass, $db);

if(isset($_POST['senddata']))
{
	
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$month = $_POST['month'];
$day = $_POST['day'];
$year = $_POST['year'];
$bkcolor = $_POST['bkcolor'];
$txcolor = $_POST['txcolor'];
$subject = $_POST['subject'];
$blog = $_POST['blog'];



$rename = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
$reEmail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/";
$remonth = "/^\d{2}$/";
$reday = "/^\d{2}$/";
$reyear = "/^\d{4}$/";

	if(preg_match($rename, $fname) && preg_match($rename, $lname) && preg_match($reEmail, $email) &&  
	preg_match($remonth, $month) && preg_match($reday, $day) && preg_match($reyear, $year) && $bkcolor != '' && $txcolor != '' && $subject != '' && $blog != '')
	{
	$fname = htmlentities($fname, ENT_QUOTES);
	$lname = htmlentities($lname, ENT_QUOTES);
	$birth = "$year-$month-$day";
	$subject = htmlentities($subject, ENT_QUOTES);
	$blog = fixstring($blog);
	$query = "select * from myboard where fname='$fname' and lname='$lname' and subject='$subject' and blog='$blog'";
	$result = mysqli_query($link, $query);
	
		if(mysqli_num_rows($result) == 0)
		{
		$queryadd = "insert into myboard values('', '$fname', '$lname', '$email', '$birth', '$bkcolor', '$txcolor', '$subject', '$blog', CURRENT_DATE, CURRENT_TIME)";
		mysqli_query($link, $queryadd);
		print "Added";
		}

	}
	else
	{
	print "<h4>Validation failed</h4>";
	}
}

$query = "select * from  myboard order by date desc, time desc";
$result = mysqli_query($link, $query);
print "<div id='displaytable'>";
	while($row = mysqli_fetch_row($result))
	{
	list($id, $fname, $lname, $email, $birth, $bk, $tx, $subject, $blog, $date, $time) = $row;
	$idb = "id".$id;
	print "
	<div class='message' id='$id' style='background-color: $bk; color: $tx'>
		<div class='rowone' >
			<span class='userrow'><b>Name:</b> $fname $lname</span> 
			<span class='subject'><b>Subject</b>: $subject</span> 
		</div>
		<div class='rowtwo'>
			<div class='info'>
				<b>Birthday:</b> $birth<br>
				<b>Email:</b> $email<br>
				<b>Date:</b> $date<br>
				<b>Time:</b> $time<br>
			</div>
			<div class='blog' id='$idb'>
			<b>Message:</b> $blog
			</div>
		</div>
	</div>";
	}
print "</div>";
?>