window.onload = initAll;



function initAll()
{
	for(i=0; i<document.links.length; i++)
	{
		if(document.links[i].className == "openWin")
		{
		document.links[i].onclick = myNewWindow;
		}
	}
}

function myNewWindow()
{

var smallWindow = window.open(this.href, "smWin", "toolbar=no,location=no,status=yes,menubar=yes,scrollbars=yes,width=200,height=200,left=300");
smallWindow.focus();
return false;
}

