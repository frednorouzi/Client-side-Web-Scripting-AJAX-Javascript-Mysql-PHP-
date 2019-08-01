window.onload = initAll;

function initAll()
{
document.getElementById('mylink').onclick = mycolors;
}
function mycolors()
{
document.getElementById('mydiv').innerHTML = "Hello World";
document.getElementById('mydiv').style.borderColor = "red";
document.getElementById('mydiv').style.borderStyle = "solid";
document.getElementById('mydiv').style.margin = "auto";
document.getElementById('mydiv').style.width = "200px"
}