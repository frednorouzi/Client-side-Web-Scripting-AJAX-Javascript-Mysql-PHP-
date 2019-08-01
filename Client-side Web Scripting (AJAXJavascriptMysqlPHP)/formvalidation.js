window.onload = initall;

function initall()
{
document.getElementById('myform').onsubmit = validateform;
}

function validateform()
{



var reName = /^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/ 
var reEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/
var reNum = /^\d+$/ 
var reText = /^[a-zA-Z]+$/ 
var reDate = /^(\d{2})$/

	if(!reName.test(document.getElementById('fname').value))
	{
	document.getElementById('ifname').innerHTML = "Please Enter First Name Correctly";
	document.getElementById('ifname').style.color = "red";
	document.getElementById('fname').focus();
	document.getElementById('fname').select();
	return false;
	}
	if(!reName.test(document.getElementById('lname').value))
	{
	document.getElementById('ilname').innerHTML = "Please Enter Last Name Correctly";
	document.getElementById('ilname').style.color = "red";
	document.getElementById('lname').focus();
	document.getElementById('lname').select();
	return false;
	}
	
	if(!reEmail.test(document.getElementById('email').value))
	{
	document.getElementById('emailinfo').innerHTML = "Please Enter Email Correctly";
	document.getElementById('emailinfo').style.color = "red";
	document.getElementById('email').focus();
	document.getElementById('email').select();
	return false;
	}

	
	var monthTag = document.getElementById('month');

	if(!reDate.test(monthTag.options[monthTag.selectedIndex].value))
	{
	document.getElementById('imonth').innerHTML = "Please choose a Month";
	document.getElementById('imonth').style.color = "red";
	return false;
	}
	
	
	
	
	var dayTag = document.getElementById('day');

	if(!reDate.test(dayTag.options[dayTag.selectedIndex].value))
	{
	document.getElementById('iday').innerHTML = "Please choose a Day";
	document.getElementById('iday').style.color = "red";
	return false;
	}
	

	if(!reNum.test(document.getElementById('year').value))
	{
	document.getElementById('yearinfo').innerHTML = "Please Enter Year Correctly";
	document.getElementById('yearinfo').style.color = "red";
	document.getElementById('year').focus();
	document.getElementById('year').select();
	return false;
	}
	
	
var numform = -1;
var formColor = document.getElementsByTagName("INPUT");
	for (i=0; i<formColor.length; i++)
	{
		if (formColor[i].className == "bkcolor")
		{
			if (formColor[i].checked)
			{
				numform = i;
			}
		}
	}
	if(numform == -1)
	{
		document.getElementById('bkinfo').innerHTML = "Please choose a Background color:";
		document.getElementById('bkinfo').style.color = "red";
		return false;
	}
	
	
var numf = -1;
var formtColor = document.getElementsByTagName("INPUT");
	for (i=0; i<formtColor.length; i++)
	{
		if (formtColor[i].className == "txcolor")
		{
			if (formtColor[i].checked)
			{
				numf = i;
			}
		}
	}
	if(numf == -1)
	{
		document.getElementById('txinfo').innerHTML = "Please choose a Text Color:";
		document.getElementById('txinfo').style.color = "red";
		return false;
	}
	
	
	if(!reText.test(document.getElementById('subject').value))
	{
	document.getElementById('subinfo').innerHTML = "Please Enter Subject";
	document.getElementById('subinfo').style.color = "red";
	document.getElementById('subject').focus();
	document.getElementById('subject').select();
	return false;
	}
	
	
	if(document.getElementById('blog').value == "")
	{
	document.getElementById('cominfo').innerHTML = "Please Enter Comments";
	document.getElementById('cominfo').style.color = "red";
	document.getElementById('blog').focus();
	document.getElementById('blog').select();
	return false;
	}
	
	
return true;

	
}



