window.onload = initAll;

function initAll()
{
document.getElementById('mylink').onclick = rollNum;
}


function rollNum()
{
	/*this first line is necessary to clean out the div with each click*/
document.getElementById('mydiv').innerHTML = "";
var num = Math.ceil(Math.random() * 3);

	if(num == 1)
	{
	mycitetag = document.createElement("cite");
	mycitetext = document.createTextNode("this is the cite tag");
	mycitetag.appendChild(mycite
	text);
	document.getElementById('mydiv').appendChild(mycitetag);
	
	/* Put the text inside the cite tag
	  append cite tag to the div called 'mydiv' on the page*/
	}
	else if(num == 2)
	{
	var mytagh = document.createElement('h3');
	var mytexth = document.createTextNode("this is a h3 tag");
	mytagh.appendChild(mytext);
	document.getElementById('mydiv').appendChild(mytagh);
	/* create an h3 tag
	   create a text node that says "this is the h3 tag"
	   put the text inside the h3 tag
	   append the h3 tag to the div on the page*/


	}
	else
	{
	var mytagp = document.createElement('p');
	var mytextp = document.createTextNode("this is the p tag");
	mytagp.appendChild(mytextp);
	document.getElementById('mydiv').appendChild(mytagp);
	
		

	/* create a paragraph tag
		create a text node that says 'this is the p tag'
		put the text inside the paragraph tag
		append the paragraph to the div on the page*/
	}
	


}