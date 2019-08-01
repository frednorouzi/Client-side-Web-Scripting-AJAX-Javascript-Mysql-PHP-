
<?php
include("finalfunctions.php");
$link = connect($host, $user, $pass, $db);
?>

<html>
<head><title>Final Assignment</title>
<link rel="stylesheet" type="text/css" href="style.css"/>

</head>
<body>

<fieldset>
<a href="final.php">Clear</a> <br>
<a href="createaccount.php?createaccount=yes">Create Account</a><br>
<a href='user.php?login=yes'>Login</a> <br>
<a href='logoutfinal.php'>Logout</a> <br>
</fieldset>
<br>
<br>


<?php




/*
showfinal();
*/
showfinal();
/*
showtables("users");
showtables("files");
showtables("owners");
*/
?>









</body>
</html>