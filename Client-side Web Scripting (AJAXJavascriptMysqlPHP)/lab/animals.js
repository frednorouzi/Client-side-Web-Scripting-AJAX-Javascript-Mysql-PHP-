window.onload = initAll;
var req = new XMLHttpRequest();
function initAll()
  {
 getData();
 }
 function getData()
 {
 if(document.getElementById('animalname').value !="")
 var poststr = "animalname"+ endcodeURI(document.GetElementById("animalname").value);
 poststr += "&species=" + endcodeURI(document.GetElementById("species").value);
  poststr += "&description=" + endcodeURI(document.GetElementById("description").value);
  poststr += "&add=add";
  req.open("POST", "db.php", true);
  req.onreadystatechange = useResponse;
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  req.setRequestHeader("Content-length", poststr.length);
  req.setRequestHeader("Connection", "close");
  req.send(poststr);
  document.getElementById('myform').reset();
  }
  else
  {
  
  var myrand = Math.ceil(Math.random() * 99999999); 
   if(this.href)
   {
    var myurl = thishref + "&myrand=" + myrand;
	}
	else
	{
	 var myurl = "db.php";
	 }
req.open("GET", myurl, true);
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
		document.getElementById('mydiv').innerHTML = req.responseText;
		var mylinks = document.getElementsByTagName('A');
		  for(i=0; i <mylinks.length; i++)
		  {
		    if(mylinks[i].className=="mysort")
			{
			  mylinks[i].onclick = getData;
			}
			}
		}
	}
}