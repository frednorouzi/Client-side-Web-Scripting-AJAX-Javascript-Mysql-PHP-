<?php

if($_GET['form1']){
	
	substr($string, $start);
	
	$starwars_name = substr($_GET['fname'], 0, 3).
					 substr($_GET['lname'], 0, 2).
					 ' '.
					 substr($_GET['mom'], 0, 2).
					 substr($_GET['city'], 0, 3).
					 ', '.
					 strrev(substr($_GET['lname'], -3, 3)).
					 substr($_GET['car'], 0).
					 ' of '.
					 substr($_GET['medication'], 0);
	
	die("Your Star Wars name is: ".$starwars_name);
}


?>

<!DOCTYPE html>
<html>

<head>
<style>
	div {float: left; width:40%; }
	h2 {clear: both;}
</style>
<title>Star Wars Name Generator</title></head>

<body>
	<div>
		<h3>Fill out Form</h3>
		<form action="extra.php" method="get">
			Your First Name: <input type="text" required="required" pattern="[a-zA-Z ]+" title="One or more letters required" name="fname"/><br/>
			Your Last Name: <input type="text" required="required" pattern="[a-zA-Z ]+" title="One or more letters required" name="lname"/><br/>
			Your Mom's Maiden Name: <input type="text" required="required" pattern="[a-zA-Z ]+" title="One or more letters required" name="mom"/><br/>
			Your City of Birth: <input type="text" required="required" pattern="[a-zA-Z ]+" title="One or more letters required" name="city"/><br/>
			Name of your first car: <input type="text" required="required" pattern="[a-zA-Z ]+" title="One or more letters required" name="car"/><br/>
			Name of the last Medication you took: <input type="text" required="required" pattern="[a-zA-Z ]+" title="One or more letters required" name="medication"/><br/>
			<input name="form1" type="submit"/><br/>
		</form>
	</div>

	<div>
		<h3>The Rules</h3>
		<dl>
		<dt> First Name</dt>
			<dd>
			<ul>
			<li>Take the first 3 letters of your 1st name and add</li>
			<li>the first 2 letters of your last name</li>
			</ul>
			</dd>
		<dt>Last Name</dt>
			<dd>
			<ul>
			<li>Then take the first 2 letters of your Mom's maiden name and add</li>
			<li>the first 3 letters of the city you were born</li>
			</ul>
			</dd>
		<dt>Honorific and Title</dt>
			<dd>
			<ul>
			<li>Take the last three letters of your last name and reverse them.</li>
			<li> add the name of the first car you drove/owned</li>
			<li>insert the word "of" </li>
			<li>tack on the name of the last medication you took.</li>
			</ul>
			</dd>
		</dt>
		<h6>Rules come from: <a href="http://www.insectdissection.com/save-curtis/swname/formula.txt">star wars</a></h6>
	</div>


</body>
</html>