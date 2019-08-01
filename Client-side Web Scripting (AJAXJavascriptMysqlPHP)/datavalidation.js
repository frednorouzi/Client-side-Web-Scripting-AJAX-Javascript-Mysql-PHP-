window.onload = initall;
var req = new XMLHttpRequest();
var backcolor;
var textcolor;

function initall()
{
document.getElementById('myform').onsubmit = validateform;
getData();
}

function validateform()
{
var rename = /^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/;
var reemail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
var redate = /^(\d{2})$/;
var reyear = /^\d+$/;
var retext = /^[a-zA-Z]+$/;

	if(!rename.test(document.getElementById('fname').value))
	{
	document.getElementById('fname').style.backgroundColor = "red";
	return false;
	}
	
	if(!rename.test(document.getElementById('lname').value))
	{
	document.getElementById('lname').style.backgroundColor = "red";
	return false;
	}

	if(!reemail.test(document.getElementById('email').value))
	{
	document.getElementById('email').style.backgroundColor = "red";
	return false;
	}

var selectMonth = document.getElementById('month');

	if(!redate.test(selectMonth.options[selectMonth.selectedIndex].value))
	{
	document.getElementById('month').style.backgroundColor = "red";
	return false;
	}


var selectDay = document.getElementById('day');

	if(!redate.test(selectDay.options[selectDay.selectedIndex].value))
	{
	document.getElementById('day').style.backgroundColor = "red";
	return false;
	}


	if(!reyear.test(document.getElementById('year').value))
	{
	document.getElementById('year').style.backgroundColor = "red";
	return false;
	}



var numb = -1;
var formBk = document.getElementsByTagName("INPUT");
	for (b=0; b<formBk.length; b++)
	{
		if (formBk[b].className == "bkcolor")
		{
			if(formBk[b].checked)
			{
			backcolor = formBk[b].value;
			numb = b;
			}
		}
	}
	if(numb == -1)
	{
	document.getElementById('bkc').style.backgroundColor = "red";
	return false;
	}


var numt = -1;
var formTx = document.getElementsByTagName("INPUT");
	for (t=0; t<formTx.length; t++)
	{
		if (formTx[t].className == "txcolor")
		{
			if(formTx[t].checked)
			{
			textcolor = formTx[t].value;
			numt = t;
			}
		}
	}
	if(numt == -1)
	{
	document.getElementById('txc').style.backgroundColor = "red";
	return false;
	}


	if(!retext.test(document.getElementById('subject').value))
	{
	document.getElementById('subject').style.backgroundColor = "red";
	return false;
	}


	if(document.getElementById('blog').value == "")
	{
	document.getElementById('blog').style.backgroundColor = "red";
	return false;
	}
	
return true;

}


function getData()
{
	var poststr = "fname=" + encodeURI(document.getElementById('fname').value) +"&lname=" + encodeURI(document.getElementById('lname').value)+ "&email=" + encodeURI(document.getElementById('email').value)+"&month=" + encodeURI(document.getElementById('month').value)+"&day=" + encodeURI(document.getElementById('day').value)+"&year=" + encodeURI(document.getElementById('year').value)
+ "&bkcolor=" + backcolor + "&txcolor=" + textcolor+"&subject=" + encodeURI(document.getElementById('subject').value)+"&blog=" + encodeURI(document.getElementById('blog').value) + "&senddata=xxxx";
	
	
	if(document.getElementById('fname').value != "" && document.getElementById('lname').value != "")
	{
	
	req.open("POST", "data.php", true);
	req.onreadystatechange = useResponse;
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	req.setRequestHeader("Content-length", poststr.length);
	req.setRequestHeader("Connection", "close");
	req.send(poststr);
	document.getElementById('myform').reset();
	}
	else
	{
		if(!this.href)
		{
		myurl = "data.php?";
		}
		else	
		{
		myurl = "data.php?sort="+this.id;
		}

	myRand = parseInt(Math.random() * 999999999);
	modurl = myurl+"&rand="+myRand;

	req.open("GET", modurl, true);
	req.onreadystatechange = useResponse;
	req.send(null);
	return false;
	}


}


function useResponse()
{
    if(req.readyState == 4)
    {
	if(req.status == 200)
        {
	document.getElementById('bodycontent').innerHTML = req.responseText;
				
	mylinks = document.getElementsByTagName('A');
		for(i=0; i<mylinks.length; i++)
		{
			if(mylinks[i].className == "mysort")
			{
			mylinks[i].onclick = getData;
			}
		}
        }
			
    }

}