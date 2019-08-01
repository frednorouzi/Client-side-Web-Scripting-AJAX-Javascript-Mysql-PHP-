<?php
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
$reemail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/";
$remonth = "/^\d{2}$/";
$reday = "/^\d{2}$/";
$reyear = "/^\d{4}$/";

	if(preg_match($rename, $fname))
	{
	$fname = htmlentities($fname, ENT_QUOTES);
	print "<li style='color: green'>Fname - $fname -- validation good!</li>";
	}
	else
	{
	print "<li style='color: red'>Fname has some problem.</li>";
	}

	
	if(preg_match($rename, $lname))
	{
	$lname = htmlentities($lname, ENT_QUOTES);
	print "<li style='color: green'>Lname - $lname -- validation good!</li>";
	}
	else
	{
	print "<li style='color: red'>Lname has some problem.</li>";
	}
	

	if(preg_match($reemail, $email))
	{
	print "<li style='color: green'>Email - $email -- validation good!</li>";
	}
	else
	{
	print "<li style='color: red'>Email has some problem.</li>";
	}
	
	

	if(preg_match($remonth, $month))
	{
	print "<li style='color: green'>Month - $month -- validation good!</li>";
	}
	else
	{
	print "<li style='color: red'>Month has some problem.</li>";
	}
	
	

	if(preg_match($reday, $day))
	{
	print "<li style='color: green'>Day - $day -- validation good!</li>";
	}
	else
	{
	print "<li style='color: red'>Day has some problem.</li>";
	}
	

	if(preg_match($reyear, $year))
	{
	print "<li style='color: green'>Year - $year -- validation good!</li>";
	}
	else
	{
	print "<li style='color: red'>Year has some problem.</li>";
	}
	
	
	if($bkcolor != "")
	{
	print "<li style='color: green'>Bkcolor - $bkcolor -- validation good!</li>";
	}
	else
	{
	print "<li style='color: red'>Bkcolor has some problem.</li>";
	}
	
	
	if($txcolor != "")
	{
	print "<li style='color: green'>Txcolor - $txcolor -- validation good!</li>";
	}
	else
	{
	print "<li style='color: red'>Txcolor has some problem.</li>";
	}
	
	if($subject != "")
	{
	$subject = htmlentities($subject, ENT_QUOTES);
	print "<li style='color: green'>Subject - $subject -- validation good!</li>";
	}
	else
	{
	print "<li style='color: red'>Subject has some problem.</li>";
	}
	
	
	if($blog != "")
	{
	$blog = htmlentities($blog, ENT_QUOTES);
	print "<li style='color: green'>Blog - $blog -- validation good!</li>";
	}
	else
	{
	print "<li style='color: red'>Bloglog has some problem.</li>";
	}
}
?>


