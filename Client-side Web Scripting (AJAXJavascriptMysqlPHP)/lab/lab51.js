window.onload = initall;
function initall()
{
   var num = 0;
   do
   {
   document.getElementById('mydiv').innerHTML += "Hello World" + num + "<br>";
    num++;
	}
	while(num < 51);
   
}