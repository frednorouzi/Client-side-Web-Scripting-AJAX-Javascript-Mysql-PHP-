window.onload = initall;

var req = new XMLHttpRequest();

function initall()
{

   document.getElementById('gen').onclick = generatedata;    
   document.getElementById('myform').onsubmit = validateForm;
   getData(); 
   draw();
   
}

var myNumbers = new Array();
var myNames = new Array();

var val = 0 ;

function validateForm()
{ 

resetBack();
 
rename = /^[a-zA-Z]+$/;

	if(!rename.test(document.getElementById('fname').value))
	{
	alert("first name please");
    document.getElementById('fname').style.border = "5px solid red";
    document.getElementById('fname').focus();  
	return false;
	}
	if(!rename.test(document.getElementById('lname').value))
	{
	alert("last name please");
    document.getElementById('lname').style.border = "5px solid red";
    document.getElementById('lname').focus(); 
	return false;
	}

remail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
	if(!remail.test(document.getElementById('email').value))
	{
	alert("bad email");
    document.getElementById('email').style.border = "5px solid red";
    document.getElementById('email').focus(); 
	return false;
	}
    
    
   var selectTags = document.getElementById('month');
    
	if(selectTags.options[selectTags.selectedIndex].value == "")
	{
     alert("You must chose a month");
     document.getElementById('month').style.border = "5px solid red";
     document.getElementById('month').focus(); 
	return false;
	} 
    
    
    var selectTagsDay = document.getElementById('day');
    
	if(selectTagsDay.options[selectTagsDay.selectedIndex].value == "")
	{
     alert("You must chose a day");
     document.getElementById('day').style.border = "5px solid red";
     document.getElementById('day').focus(); 
	return false;
	}    
    
 	   
reyear = /^(\d{4})$/;
	if(!reyear.test(document.getElementById('year').value))
	{
     alert("4 Diget Year of Birth Please");
     document.getElementById('year').style.border = "5px solid red";
     document.getElementById('year').focus(); 
	return false;
	}    
    
    
    

var num = -1;
var formTags = document.getElementsByTagName("INPUT");
	for (i=0; i<formTags.length; i++)
	{
		if (formTags[i].className == "bkcolor")
		{
			if(formTags[i].checked)
			{
			num = i;
			bk = formTags[i].value;
			
			}
		}
	}
	if(num == -1)
	{
	alert("You must chose a background color");
     document.getElementById('bklabel').style.border = "5px solid red";
	return false;
	}


var num2 = -1;
var formTags2 = document.getElementsByTagName("INPUT");
	for (i=0; i<formTags2.length; i++)
	{
		if (formTags2[i].className == "txcolor")
		{
			if(formTags2[i].checked)
			{
			num2 = i;
			tx = formTags2[i].value;
			}
		}
	}
	if(num2 == -1)
	{
	alert("You must chose a text color");
     document.getElementById('txlabel').style.border = "5px solid red";
	return false;
	}

   reblogname = /^[a-zA-Z ]*$/;

    if(!reblogname.test(document.getElementById('subject').value))
	{
	alert("Need Blog Title");
     document.getElementById('subject').style.border = "5px solid red";
    document.getElementById('subject').focus(); 
	return false;
	}
    
    if(!reblogname.test(document.getElementById('blog').value))
	{
	alert("Need Blog Entry");
     document.getElementById('blog').style.border = "5px solid red";
    document.getElementById('blog').focus(); 
	return false;
	}
	

return true;
}

function getData()
{
	if(this.className == "delete")
	 {
        var r = confirm("permanently delete record?");
	    if (r != true)
	    {
        return false;
	    }
	 }  

if(document.getElementById('fname').value != "")
{

var poststr = "";
var poststr = "fname=" + encodeURI(document.getElementById('fname').value);
poststr += "&lname=" + encodeURI(document.getElementById('lname').value);
poststr += "&email=" + encodeURI(document.getElementById('email').value);
poststr += "&month=" + encodeURI(document.getElementById('month').value);
poststr += "&day=" + encodeURI(document.getElementById('day').value);
poststr += "&year=" + encodeURI(document.getElementById('year').value);
poststr += "&subject=" + encodeURI(document.getElementById('subject').value);
poststr += "&blog=" + encodeURI(document.getElementById('blog').value);

var formTags = document.getElementsByTagName("INPUT");

	for (i=0; i<formTags.length; i++)
	{
		if (formTags[i].className == "bkcolor")
		{
			if(formTags[i].checked)
			{
			poststr += "&bkcolor="+ encodeURI(formTags[i].value)+"&";
			}
		}
	}

	for (i=0; i<formTags.length; i++)
	{
		if (formTags[i].className == "txcolor")
		{
			if(formTags[i].checked)
			{
			poststr += "txcolor="+ encodeURI(formTags[i].value)+"&";
			}
		}
	}
poststr += "&senddata=yes";
req.open("POST", "data.php", true);
req.onreadystatechange = useResponse;
req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
req.send(poststr);
}
else
{

var myRand = parseInt(Math.random() * 999999999);
		if(this.href)
		 {
		 var myurl = this.href + "&myrand=" + myRand;
		 }
		 else
		 {
		 var myurl = "data.php";
		 }
		req.open("GET", myurl, true);
		req.onreadystatechange = useResponse;
		req.send(null);
 	        return false;    
  }
}

function useResponse()
{
  myNumbers.length = 0;
  myNames.length = 0;



	if(req.readyState == 4)
	{
		if(req.status == 200)
		{
		document.getElementById('myresponse').innerHTML = req.responseText;
	        var form = document.getElementById("myform");
                form.reset();
		}
	}
	else
   	{
	document.getElementById('myresponse').innerHTML = '<img src="count.gif" />';
   	}

     /*---- open close row two--- -*/ 
	var openclose = document.getElementsByTagName("A");
	for (i=0; i<openclose.length; i++)
	{
		if(openclose[i].id == "collapse")
		{
		openclose[i].onclick = myclose;		
		}
	}  

   /*------cookiecheck-----------*/
    if(localStorage.show)
    {
     	rows = document.getElementsByClassName("rowtwo");
        for(i=0; i<rows.length; i++)
	{ 
	  if(localStorage.show == "Close")
	    {
	    rows[i].style.display = "none";	
 	    document.getElementById('collapse').innerHTML = "Open";
	    }
	  else
	    {
	    rows[i].style.display = "block";
	    document.getElementById('collapse').innerHTML = "Close";
	    }
	}

     if(this.innerHTML == "Close")
	{
        this.innerHTML = "Open";
	}
     else
	{
	this.innerHTML = "Close";
	}
    }

    /*----delete record ----*/
	var deltags = document.getElementsByTagName("A");
	for (i=0; i<deltags.length; i++)
	{
		if(deltags[i].className == "delete")
		{
		deltags[i].onclick = getData;

		}		
	}

	/* --------single message display-----*/
	var counter = 5000;
        var onemessage = document.getElementsByClassName("message");
	
	for (i=0; i<onemessage.length; i++)
	{ counter++;
	myid = onemessage[i].id;
	var newNode = document.createElement('div');  
        newNode.id = "node"+ counter;
	newNode.innerHTML = "<a href='#' style='color:white'>click here to move this message </a>";
	onemessage[i].appendChild( newNode );
	document.getElementById("node" + counter).onclick = showmessage;	
	}

  /*---------get chart data -------*/

var allNames = document.getElementsByClassName("username");
	for (i=0; i<allNames.length; i++)
	{
	myNames.push(allNames[i].innerHTML);	
	}
var allNumbers = document.getElementsByClassName("usercount");
	for (i=0; i<allNumbers.length; i++)
	{
	myNumbers.push(allNumbers[i].innerHTML);	
	}
   
    drawChart();

}

function drawChart()
{
var myimg = document.getElementById('mycanvas').getContext('2d');
/*
myimg.fillStyle = "white";
*/
  myimg.setTransform(1, 0, 0, 1, 0, 0);
  myimg.clearRect(0, 0, myimg.canvas.width, myimg.canvas.height);



var fontS = '14';
myimg.font = fontS+'px Arial';
var fontX = 10; /*all text starts 10 pixels in*/
var fontY = 30; /*the first text starts 30 pixels down*/
var rectH =  5; /* all rectangles are 5 pixels tall*/
var rectX = 140;  /* all rectangles start 80 pixels in (so they don't run into the text*/


	for(i=0; i<myNames.length; i++)
	{
	var rectY = (fontY - fontS) + rectH + 1; /*this attempts to center rectangle on text*/
	myimg.fillStyle = "blue";
	myimg.fillText(myNames[i],fontX + 15, fontY);
	myimg.fillStyle = "red";
	myimg.fillText(myNumbers[i],fontX, fontY);	
	myimg.fillStyle = "green";
	myimg.fillRect(rectX, rectY, (myNumbers[i])*8, rectH); /*I multiple the numbers by 5 to make them bigger*/
	fontY = fontY + 33;  /*move the next text block down 33 pixels*/
	}

}
 

function showmessage()
{
var myid = this.parentNode.id;
vip = document.getElementById('id'+myid).innerHTML;
document.getElementById('showmessage').innerHTML = vip;
}

function myclose()
{
        rows = document.getElementsByClassName("rowtwo");
        for(i=0; i<rows.length; i++)
	{ 
	  if(this.innerHTML == "Close")
	    {
	    rows[i].style.display = "none";	
 	    localStorage.show = "Close";	
	    }
	  else
	    {
	    rows[i].style.display = "block";
	    localStorage.show = "Open" ;
	    }
	}

     if(this.innerHTML == "Close")
	{
        this.innerHTML = "Open";
	}
     else
	{
	this.innerHTML = "Close";
	}	
}


function resetBack()
{
var myEM = document.getElementsByTagName('input');
	for(i=0; i<myEM.length; i++)
	{
	myEM[i].style.border = "none";
	}
    
var myEM = document.getElementsByTagName('select');
	for(i=0; i<myEM.length; i++)
	{
	myEM[i].style.border = "none";
	}
    
    
var myEM = document.getElementsByTagName('label');
	for(i=0; i<myEM.length; i++)
	{
	myEM[i].style.border = "none";
	}
}


function generatedata()
{
/* FINISH THE ARRAYS. Note: you want these two arrays to match in number of elements so if have 10 first names, 
you will also have 10 last names */
var firstnames = new Array("David", "Thomas", "Richard", "Nicole", "John", "Silvia");

var lastnames = new Array("Dart", "Jefferson", "Patterson", "Kidman", "Simpson", "Jones");

var emails = new Array("dd@hotmail.com", "tj@marvel.com", "rpatter@yahoo.com", "kidmann@gmail.com", "johns@cisu.com", "siljones@yahoo.com");

var subjects = new Array("sport", "movies", "music", "pick nick", "library","family event");

var blogs = new Array("playing soccer", "i like action movies","i like light music" , "Around the american river is best area for pick nick", "Public library of Sacramento", "Birth day party");



var fnamenum = Math.floor((Math.random() * 6) + 0); 
var lnamenum = Math.floor((Math.random() * 6) + 0); 
var emailnum = Math.floor((Math.random() * 6) + 0); 
var subjectnum = Math.floor((Math.random() * 6) + 0); 
var blognum = Math.floor((Math.random() * 6) + 0); 

document.getElementById('fname').value = firstnames[fnamenum];
document.getElementById('lname').value = lastnames[lnamenum];
document.getElementById('email').value = emails[emailnum];
document.getElementById('subject').value = subjects[subjectnum];
document.getElementById('blog').value = blogs[blognum];


var monthnum = Math.floor((Math.random() * 12) + 1); 
if(monthnum<10)
  {
   monthnum = "0" + monthnum;
  }
document.getElementById('month').value = monthnum;

var daynum = Math.floor((Math.random() * 31) + 1); 
if(daynum<10)
  {
   daynum = "0" + daynum;
  }
document.getElementById('day').value = daynum;

var yearnum = Math.floor((Math.random() * (2015-1900+1)) + 1900); 
document.getElementById('year').value = yearnum;



/* create an array of all the background color input tag elements using the class name. You can use a LOOP like 
we've been doing in class or you can use getElementsByName or getElementByClassName function.  */

var bklist = document.getElementsByName('bkcolor');



/* Now use the array bklist you just created and generate a random number based on the number of radio buttons in the background color field*/

var bknum =  Math.floor((Math.random() * (bklist.length)) + 0); 


/*set the bklist array to checked = true based on the random number you generated for it*/

   bklist[bknum].checked = true;



var txtlist = document.getElementsByName('txcolor');


/* Now use the array bklist you just created and generate a random number based on the number of radio buttons in the background color field*/

var txtnum =  Math.floor((Math.random() * (txtlist.length)) + 0); 


/*set the bklist array to checked = true based on the random number you generated for it*/

   txtlist[txtnum].checked = true;
  

}









