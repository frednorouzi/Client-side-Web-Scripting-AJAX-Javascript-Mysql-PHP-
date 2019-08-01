window.onload = initAll;

function initAll()
{
allTags = document.getElementsByTagName('A');
	for(i=0; i<allTags.length; i++)
	{
		if(allTags[i].className == "mylink")
		{
		allTags[i].onclick = getData;

		}
	}
	getData();
}

var req = new XMLHttpRequest(); 

function getData()
{


if (this.href)
{
var url = this.href;
}
else
{
var url = "body1.txt";
}
req.onreadystatechange = useResponse;
req.open("GET", url, true);
req.send(null);
return false;

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
	else
	{
	document.getElementById('mydiv').innerHTML = 'body1.txt';
	}
}