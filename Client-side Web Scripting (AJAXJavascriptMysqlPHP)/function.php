<?php
$host = "localhost";
$user = "norouzif";
$pass = "1426193";
$db = "norouzif";


function connectdb($host, $user, $pass, $db) 
{
$link = mysqli_connect($host, $user, $pass, $db) or die("Error ".mysqli_error($link));
return $link;
}


function fixstring($string)
{
$string = htmlentities($string, ENT_QUOTES);
$string = preg_replace("/\r/", '<br>', $string);
$string = stripslashes($string);
return $string;
}
 

?>