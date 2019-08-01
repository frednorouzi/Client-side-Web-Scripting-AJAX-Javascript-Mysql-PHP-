window.onload = initAll;

function initAll()
{
	for(i = 100000; i <= 990000; i += 10000)
	{
	 document.getElementById('mydiv').innerHTML += "<p style='color: white; background-color: #"+ i +"'>The Background color is set to #"+ i +"</p>";
	}

}
