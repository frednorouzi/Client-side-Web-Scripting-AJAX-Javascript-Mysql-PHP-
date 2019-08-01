window.onload = initall;
function initall()
{
document.getElementById('myform').onsubmit = validateform;
}
var req = new XMLHttpRequest();

function validateform()
{

var reName = /^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/ 
var reEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/
var reNum = /^\d+$/ 
var reText = /^[a-zA-Z]+$/ 
var reDate = /^(\d{2})$/

	if(!reName.test(document.getElementById('fname').value))
	{
	document.getElementById('fnamerr').innerHTML = "Please Enter First Name Correctly";
	document.getElementById('fnamerr').style.color = "red";
	document.getElementById('fname').focus();
	document.getElementById('fname').select();
	return false;
	}
	if(!reName.test(document.getElementById('lname').value))
	{
	document.getElementById('lnamerr').innerHTML = "Please Enter Last Name Correctly";
	document.getElementById('lnamerr').style.color = "red";
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
	document.getElementById('bmonth').innerHTML = "Please choose a Month";
	document.getElementById('bmonth').style.color = "red";
	return false;
	}
		
	var dayTag = document.getElementById('day');

	if(!reDate.test(dayTag.options[dayTag.selectedIndex].value))
	{
	document.getElementById('dday').innerHTML = "Please choose a Day";
	document.getElementById('dday').style.color = "red";
	return false;
	}
	
	if(!reNum.test(document.getElementById('year').value))
	{
	document.getElementById('yearinfo').innerHTML = "Please Enter Year";
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
		document.getElementById('cfinfo').innerHTML = "Please choose a Background color:";
		document.getElementById('cfinfo').style.color = "red";
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

function getData()
{
firstName = document.getElementById('fname').value;
lastName = document.getElementById('lname').value;
email = document.getElementById('email').value;
month = document.getElementById('month').options[document.getElementById('month').selectedIndex].value;
day = document.getElementById('day').options[document.getElementById('day').selectedIndex].value;
year = document.getElementById('year').value;


var inputs = document.getElementsByTagName('input');


for(i=0;i<inputs.length;i++)
	{
	if(inputs[i].name == "bkcolor" && inputs[i].checked == true)
		{
		bkcolor = inputs[i].value;
		}
	}
for(i=0;i<inputs.length;i++)
	{
	if(inputs[i].name == "txcolor" && inputs[i].checked == true)
		{
		txcolor = inputs[i].value;
		}
	}
subject = document.getElementById('subject').value;
blog = document.getElementById('blog').value;
sendbutton = "senddata=yes";

poststr = "fname=" + encodeURI(firstName);
poststr += "&lname=" + encodeURI(lastName);
poststr += "&email=" + encodeURI(email);
poststr += "&month=" + encodeURI(month);
poststr += "&day=" + encodeURI(day);
poststr += "&year=" + encodeURI(year);
poststr += "&bkcolor=" + encodeURI(bkcolor);
poststr += "&txcolor=" + encodeURI(txcolor);
poststr += "&subject=" + encodeURI(subject);
poststr += "&blog=" + encodeURI(blog);
poststr += "&" + sendbutton;

req.open("POST","form_engine.php",true);
req.onreadystatechange = useResponse;
req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
req.send(poststr);
}

function useResponse()
{
	if(req.readyState == 4)
	{
		if(req.status == 200)
		{
		document.getElementById('mydiv').innerHTML = req.responseText;
		}
	}
}

