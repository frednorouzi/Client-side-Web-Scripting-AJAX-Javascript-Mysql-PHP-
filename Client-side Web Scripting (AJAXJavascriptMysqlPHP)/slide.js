window.onload = initAll;

var myWindow = null;
var myPix = new Array("Under-ocean-waterfall.jpg", "Aurora.jpg", "hot-spring.jpg", "stone-horse.jpeg",
 "rocks-human.jpeg");
var myDesc = new Array("This is an Under ocean waterfall.","Beautiful Aurora.","colourful hot spring.","It looks like the horse is thirsty.","Amazing place for vacation!");
var BigPic = new Array("Under-ocean-waterfall.jpg", "Aurora.jpg", "hot-spring.jpg", "stone-horse.jpeg", "rocks-human.jpeg");

var thisPic = 0;


function initAll()
{
document.getElementById('prevlink').onclick = processPrevious;
document.getElementById('nextlink').onclick = processNext;

	for (var i=0; i<document.images.length; i++)
  	{
		if (document.images[i].parentNode.tagName == "A")
		{
		rollOverFunction(document.images[i]);
		}
	}

	
			for(i=0; i<document.images.length; i++)
			{
			if(document.images[i].className == "newWin")
			{
			document.images[i].onclick = myNewWindow;
			}
			}
	
}




function rollOnFunction()
{
this.src = this.overImage.src;
}

function rollOffFunction()
{
this.src = this.outImage.src;
}




function processPrevious()
{
	if(thisPic == 0)
	{
	thisPic = myPix.length;
	}
thisPic--;
document.getElementById('mypicture').src = myPix[thisPic];
document.getElementById('mycontent').innerHTML = myDesc[thisPic];

return false;
}

function processNext()
{
thisPic++;
	if(thisPic == myPix.length) 
	{
	thisPic = 0;
	}
document.getElementById('mypicture').src = myPix[thisPic];
document.getElementById('mycontent').innerHTML = myDesc[thisPic];

return false;
}



function myNewWindow()
{

var littleWindow = window.open(BigPic[thisPic], "ltWin", 
"toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,width=600,height=450, left=450");
littleWindow.focus();

return false;
}



