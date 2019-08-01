<!DOCTYPE html>
<html lang="en">
<head>	
	<title>Employee Table</title>
	
</head>
<body>
<a href="index.php">Home</a> 
 <a href="employee.php">Clean</a>
<br /><br />
<?php

$link = mysqli_connect('localhost','norouzif','1426193','norouzif');

echo '
<table border="1">
<tr><td>
<form>
<input type="text" name="fname"> Fname<br>
<input type="text" name="lname"> Lname <br>
<input type="text" name="email"> Email<br>
<input type="text" name="zip"> Zip<br>
</td>
</tr>
<tr>
<td style="text-align: right">
<input type="submit" name="add" value="Add Record"></form>
</td></tr></table>';

if ($_GET['add']){
	if(
		!empty($_GET['fname']) AND
		!empty($_GET['lname']) AND
		!empty($_GET['email']) AND
		!empty($_GET['zip'])
	){
		$add_emp_query = "INSERT INTO employees VALUES(null, '{$_GET[fname]}', '{$_GET[lname]}', '{$_GET[email]}', '{$_GET[zip]}') ; ";
		$result_add_query = mysqli_query($link, $add_emp_query) or die(mysqli_error($link));
		
	}	
}elseif($_GET['edit'] == 'yes' AND $_GET['employeeid'] != null){
	
	$edit_query = "SELECT * FROM employees WHERE employeeid = '$_GET[employeeid]';";
	$edit_result = mysqli_query($link, $edit_query);
	
	$edit_list = mysqli_fetch_assoc($edit_result);
	//list($employeeid, $fname, $lname, $email, $zip) = $row;
	
	echo '<table border="1" style="float: left">
	<tr><td><form><input type="hidden" name="employeeid" value="'. $edit_list[employeeid] .'">
	<input type="text" name="fname" value="'.$edit_list[fname].'"> Fname<br >
	<input type="text" name="lname" value="'.$edit_list[lname].'"> Lname<br >
	<input type="text" name="email" value="'.$edit_list[email].'"> Email<br >
	<input type="text" name="zip" value="'.$edit_list[zip].'" > Zip<br >
	</td></tr>
	<tr><td colspan="2" style="text-align: right">
	<input type="submit" name="edit2" value="Edit Record" ></form>
	</td></tr></table>';
	
	
}elseif($_GET['edit2']){
	$edit2_query = "UPDATE employees SET fname = '{$_GET[fname]}', lname = '{$_GET[lname]}', email = '{$_GET[email]}', zip = '{$_GET[zip]}'
		WHERE employeeid = '{$_GET[employeeid]}';";
		
	$edit2_result = mysqli_query($link, $edit2_query);
	
	
}elseif($_GET['delete'] == 'yes' AND $_GET['employeeid'] != null){
	$delete_query = "DELETE FROM employees WHERE employeeid = '{$_GET[employeeid]}' LIMIT 1;";
	$delete_result = mysqli_query($link,$delete_query);
}







function showemp(){
	global $link;
	
	if(isset($_GET['choice'])){
		$choice = $_GET['choice'];
	}else{
		$choice = "lname";
	}

	$query = "select * from employees order by $choice";
	$result = mysqli_query($link, $query);


	print "<table border='1'>

<tr>
<th>Edit</th>
<th>Delete</th>
<th><a href='employees.php?choice=fname'>FNAME</a></th>
<th><a href='employees.php?choice=lname'>LNAME</a></th>
<th><a href='employees.php?choice=email'>EMAIL</a></th>
<th><a href='employees.php?choice=zip'>ZIP</a></th>
</tr>";

	while($row = mysqli_fetch_row($result)){
		
		list($employeeid, $fname, $lname, $email, $zip) = $row;
		
		print "<tr>
<td><a href='employees.php?edit=yes&employeeid=$employeeid'>Edit</a></td>
<td><a href='employees.php?delete=yes&employeeid=$employeeid'
 onclick='return confirm(\"Are you sure\")'>Delete</a></td>
<td>$fname</td><td>$lname</td><td>$email</td><td>$zip</td>
</tr>";
	
	}
	
	print "</table>";
}


showemp();




mysqli_close($link);

?>
</body>
</html>